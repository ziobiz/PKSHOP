<?php
set_time_limit(300);
header('Content-Type: application/json; charset=utf-8');

include "../common/dbconn.php";
include "gemini_client.php";
include "pro_import_lib.php";

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
$job_id = isset($_REQUEST['job_id']) ? $_REQUEST['job_id'] : '';

function ai_json_response($data) {
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

function ai_job_session_key($job_id) {
    return 'pkshop_ai_job_' . preg_replace('/[^a-zA-Z0-9_\-]/', '', $job_id);
}

function ai_save_job_state($job_id, $job) {
    if (session_id() === '') {
        @session_start();
    }
    $_SESSION[ai_job_session_key($job_id)] = $job;
    gemini_save_job($job_id, 'state', $job);
}

function ai_load_job_state($job_id) {
    if ($job_id === '') {
        return null;
    }
    if (session_id() === '') {
        @session_start();
    }
    $key = ai_job_session_key($job_id);
    if (isset($_SESSION[$key]) && is_array($_SESSION[$key])) {
        return $_SESSION[$key];
    }
    return gemini_load_job($job_id, 'state');
}

function ai_require_admin() {
    if (session_id() === '') {
        @session_start();
    }
    if (!isset($_SESSION['idok']) || $_SESSION['idok'] !== 'yes') {
        ai_json_response(array('error' => '관리자 로그인이 필요합니다.'));
    }
}

if ($action === 'save_api_key') {
    ai_require_admin();
    $api_key = isset($_POST['api_key']) ? trim($_POST['api_key']) : '';
    $result = gemini_save_api_key($api_key);
    if (isset($result['error'])) {
        ai_json_response($result);
    }
    ai_json_response(array(
        'success' => true,
        'masked' => $result['masked'],
        'message' => 'API 키가 저장되었습니다.',
    ));
}

if (!function_exists('pkshop_ai_create_category_level1')) {
    function pkshop_ai_create_category_level1($DB, $shop_cate, $cate_name) {
        $cate_name = trim($cate_name);
        if ($cate_name === '') return array('error' => '신규 카테고리명을 입력하세요.');
        $DB->get("SELECT code1 FROM $shop_cate WHERE code2='00' AND code3='00' AND code4='00' ORDER BY code1 DESC LIMIT 1", $rs, $rn);
        $ncode1 = ($rn > 0 && $rs[0]['code1'] !== '') ? intval($rs[0]['code1']) + 1 : 1;
        $code1 = sprintf('%02d', $ncode1);
        $DB->get("SELECT max(uid) as max_uid FROM $shop_cate", $uid_rs, $uid_rn);
        $new_uid = ($uid_rn > 0 && $uid_rs[0]['max_uid']) ? intval($uid_rs[0]['max_uid']) + 1 : 1;
        $DB->get("SELECT max(rank) as max_rank FROM $shop_cate WHERE code2='00' AND code3='00' AND code4='00'", $rank_rs, $rank_rn);
        $rank = ($rank_rn > 0 && $rank_rs[0]['max_rank']) ? intval($rank_rs[0]['max_rank']) + 1 : 1;
        $cate1_safe = addslashes($cate_name);
        $query = "uid='$new_uid',cate1='$cate1_safe',cate2='',cate3='',cate4='',code1='$code1',code2='00',code3='00',code4='00',rank='$rank',order_rank='$rank'";
        try { $DB->insert($shop_cate, $query); } catch (Exception $e) {
            return array('error' => '카테고리 등록 실패: ' . $e->getMessage());
        }
        return array('success' => true, 'code1' => $code1, 'cate1' => $cate_name);
    }
}

function ai_build_plan_prompt($count, $options, $batch_offset) {
    $gender_map = array('female' => '여성', 'male' => '남성', 'children' => '아동', 'all' => '전체');
    $season_map = array('spring' => '봄', 'summer' => '여름', 'autumn' => '가을', 'winter' => '겨울', 'all_season' => '사계절');
    $type_map = array(
        'clothing' => '의류/패션', 'appliances' => '가전', 'electronics' => '전자제품', 'computer' => '컴퓨터/IT',
        'gift_card' => '상품권', 'travel' => '여행권', 'hotel' => '호텔이용권', 'food' => '식품', 'beauty' => '뷰티/화장품',
        'sports' => '스포츠/레저', 'furniture' => '가구/인테리어', 'books' => '도서', 'toys' => '완구/키즈',
        'jewelry' => '주얼리/액세서리', 'automotive' => '자동차용품', 'pet' => '반려동물용품', 'health' => '건강/의료기기',
        'office' => '문구/오피스', 'other' => '기타',
    );
    $country_map = array(
        '82' => array('label' => 'KOREA', 'name' => '한국'), '66' => array('label' => 'THAILAND', 'name' => '태국'),
        '91' => array('label' => 'INDIA', 'name' => '인도'), '1' => array('label' => 'USA', 'name' => '미국'),
        '81' => array('label' => 'JAPAN', 'name' => '일본'), '86' => array('label' => 'CHINA', 'name' => '중국'),
        '84' => array('label' => 'VIETNAM', 'name' => '베트남'), '62' => array('label' => 'INDONESIA', 'name' => '인도네시아'),
    );
    $gender = isset($options['gender']) ? $options['gender'] : 'all';
    $season = isset($options['season']) ? $options['season'] : 'all_season';
    $country_code = isset($options['country']) ? $options['country'] : '1';
    $memo = isset($options['memo']) ? trim($options['memo']) : '';
    $gender_label = isset($gender_map[$gender]) ? $gender_map[$gender] : '전체';
    $season_label = isset($season_map[$season]) ? $season_map[$season] : '사계절';
    $country_info = isset($country_map[$country_code]) ? $country_map[$country_code] : $country_map['1'];
    $types = isset($options['product_types']) ? $options['product_types'] : array('clothing');
    if (!is_array($types)) $types = array($types);
    $type_labels = array();
    foreach ($types as $t) { if (isset($type_map[$t])) $type_labels[] = $type_map[$t]; }
    if (!empty($options['product_type_custom'])) $type_labels[] = trim($options['product_type_custom']);
    if (count($type_labels) === 0) $type_labels[] = '일반 상품';
    $types_str = implode(', ', $type_labels);
    $offset_note = $batch_offset > 0 ? ' (batch offset ' . $batch_offset . ')' : '';
    $price_note = '';
    if (function_exists('pkshop_ai_get_price_bounds_from_options')) {
        $range = pkshop_ai_get_price_bounds_from_options($options);
        if ($range !== null) {
            $price_note = 'pricec/prices/priced in USD, ONLY between ' . $range['min'] . ' and ' . $range['max'] . ', last digit MUST be 0. ';
        }
    } else {
        $price_note = 'pricec/prices/priced in USD, last digit MUST be 0. ';
    }
    return 'Generate exactly ' . intval($count) . ' unique e-commerce products' . $offset_note . '.
Keywords: Gender=' . $gender_label . ', Season=' . $season_label . ', Country=' . $country_info['name'] . ', Categories=' . $types_str . '
' . ($memo !== '' ? 'Notes: ' . $memo . "\n" : '') . 'Return ONLY JSON array. Each item: title, company, country("' . $country_code . '"), home("' . $country_info['label'] . '"), color, size, pricec, prices, priced, c_pv, theme, detail(HTML), image_prompts[N English prompts, N=' . (isset($options['image_count']) ? intval($options['image_count']) : 4) . '].
' . $price_note . 'image_prompts: photorealistic e-commerce, no text/watermark.';
}

function ai_generate_products_plan($count, $options) {
    if (function_exists('pkshop_ai_generate_products_plan')) {
        return pkshop_ai_generate_products_plan($count, $options);
    }
    if (function_exists('gemini_generate_products_plan')) {
        return gemini_generate_products_plan($count, $options);
    }
    return array('error' => 'AI 상품 기획 함수를 찾을 수 없습니다.');
}

if ($action === 'start') {
    set_time_limit(600);

    $count = isset($_POST['count']) ? intval($_POST['count']) : 3;
    if ($count < 1) $count = 1;
    if ($count > 100) $count = 100;

    $cate_mode = isset($_POST['cate_mode']) ? $_POST['cate_mode'] : 'existing';
    $code1 = isset($_POST['code1']) ? $_POST['code1'] : '';
    $code2 = isset($_POST['code2']) ? $_POST['code2'] : '00';
    $code3 = isset($_POST['code3']) ? $_POST['code3'] : '00';
    $code4 = isset($_POST['code4']) ? $_POST['code4'] : '00';
    $new_cate_name = isset($_POST['new_cate_name']) ? trim($_POST['new_cate_name']) : '';

    $gender = isset($_POST['gender']) ? $_POST['gender'] : 'all';
    $season = isset($_POST['season']) ? $_POST['season'] : 'all_season';
    $country = isset($_POST['country']) ? $_POST['country'] : '1';
    $memo = isset($_POST['memo']) ? trim($_POST['memo']) : '';
    $gen_price_min = isset($_POST['gen_price_min']) ? intval(preg_replace('/[^0-9]/', '', $_POST['gen_price_min'])) : 0;
    $gen_price_max = isset($_POST['gen_price_max']) ? intval(preg_replace('/[^0-9]/', '', $_POST['gen_price_max'])) : 0;
    $image_count = isset($_POST['image_count']) ? intval($_POST['image_count']) : 4;
    if ($image_count < 4) $image_count = 4;
    if ($image_count > 8) $image_count = 8;
    $product_type_custom = isset($_POST['product_type_custom']) ? trim($_POST['product_type_custom']) : '';

    $ethnicities = array();
    if (isset($_POST['model_ethnicity'])) {
        $ethnicities = gemini_resolve_ethnicity_from_form(
            isset($_POST['model_ethnicity']) ? $_POST['model_ethnicity'] : '',
            isset($_POST['east_asian_detail']) ? $_POST['east_asian_detail'] : ''
        );
    } elseif (isset($_POST['ethnicities']) && is_array($_POST['ethnicities'])) {
        $ethnicities = gemini_normalize_ethnicity_selection($_POST['ethnicities']);
    } elseif (isset($_POST['ethnicities']) && $_POST['ethnicities'] !== '') {
        $ethnicities = gemini_normalize_ethnicity_selection(array($_POST['ethnicities']));
    }

    $product_types = array();
    if (isset($_POST['product_types']) && is_array($_POST['product_types'])) {
        $product_types = $_POST['product_types'];
    } elseif (isset($_POST['product_types']) && $_POST['product_types'] !== '') {
        $product_types = array($_POST['product_types']);
    }
    if (count($product_types) === 0) {
        ai_json_response(array('error' => '상품 종목을 1개 이상 선택하세요.'));
    }

    if ($gen_price_min < 10) {
        ai_json_response(array('error' => '생성 가격 최저금액(USD)을 10 이상 입력하세요.'));
    }
    if ($gen_price_max < $gen_price_min) {
        ai_json_response(array('error' => '생성 가격 최대금액은 최저금액 이상이어야 합니다.'));
    }
    if (function_exists('pkshop_ai_price_bounds')) {
        $bounds = pkshop_ai_price_bounds($gen_price_min, $gen_price_max);
        if ($bounds !== null) {
            $gen_price_min = $bounds['min'];
            $gen_price_max = $bounds['max'];
        }
    }

    $options = array(
        'gender'             => $gender,
        'ethnicities'        => $ethnicities,
        'season'             => $season,
        'country'            => $country,
        'memo'               => $memo,
        'gen_price_min'      => $gen_price_min,
        'gen_price_max'      => $gen_price_max,
        'image_count'        => $image_count,
        'product_types'      => $product_types,
        'product_type_custom'=> $product_type_custom,
    );

    if ($cate_mode === 'new') {
        if ($new_cate_name === '') {
            ai_json_response(array('error' => '신규 카테고리명을 입력하세요.'));
        }
        $cate_result = pkshop_ai_create_category_level1($DB, $shop_cate, $new_cate_name);
        if (isset($cate_result['error'])) {
            ai_json_response(array('error' => $cate_result['error']));
        }
        $code1 = $cate_result['code1'];
    } else {
        if ($code1 === '' || $code1 === '00') {
            ai_json_response(array('error' => '카테고리(대분류)를 선택하세요.'));
        }
    }

    $cate_err = pkshop_import_validate_category($DB, $shop_cate, $code1, $code2, $code3, $code4);
    if ($cate_err !== '') {
        ai_json_response(array('error' => $cate_err));
    }

    $plan = ai_generate_products_plan($count, $options);
    if (isset($plan['error'])) {
        ai_json_response(array('error' => '상품 기획 생성 실패: ' . $plan['error']));
    }

    $products = array_slice($plan['products'], 0, $count);
    if (count($products) < $count) {
        ai_json_response(array('error' => '요청하신 ' . $count . '개 중 ' . count($products) . '개만 기획되었습니다. 다시 시도하거나 수량을 줄여주세요.'));
    }
    $job_id = 'ai' . date('YmdHis') . rand(1000, 9999);

    $job = array(
        'job_id'    => $job_id,
        'created'   => date('Y-m-d H:i:s'),
        'code1'     => $code1,
        'code2'     => $code2,
        'code3'     => $code3,
        'code4'     => $code4,
        'options'   => $options,
        'total'     => count($products),
        'products'  => $products,
        'images'    => array(),
        'saved'     => array(),
        'errors'    => array(),
    );

    ai_save_job_state($job_id, $job);

    if (ai_load_job_state($job_id) === null) {
        ai_json_response(array('error' => '작업 상태 저장 실패. 세션/캐시 폴더 권한을 확인하세요.'));
    }

    ai_json_response(array(
        'ok'      => true,
        'job_id'  => $job_id,
        'total'   => count($products),
        'message' => count($products) . '개 상품 기획 완료. 이미지 생성을 시작합니다.',
    ));
}

if ($action === 'process_image') {
    if ($job_id === '') {
        ai_json_response(array('error' => 'job_id 필요'));
    }

    $product_index = isset($_POST['product_index']) ? intval($_POST['product_index']) : 0;
    $image_index   = isset($_POST['image_index']) ? intval($_POST['image_index']) : 0;

    $job = ai_load_job_state($job_id);
    if ($job === null) {
        ai_json_response(array('error' => '작업을 찾을 수 없습니다.'));
    }

    if (!isset($job['products'][$product_index])) {
        ai_json_response(array('error' => '상품 인덱스 오류'));
    }

    $product = $job['products'][$product_index];
    $img_key = $product_index . '_' . $image_index;

    if (isset($job['images'][$img_key])) {
        ai_json_response(array(
            'ok'       => true,
            'skipped'  => true,
            'filename' => $job['images'][$img_key],
            'product_index' => $product_index,
            'image_index'   => $image_index,
        ));
    }

    $prompts = $product['image_prompts'];
    $base_prompt = isset($prompts[$image_index]) ? $prompts[$image_index] : $prompts[0];
    $job_options = isset($job['options']) ? $job['options'] : array();
    $full_prompt = gemini_image_prompt_enhance($base_prompt, $product['title'], $job_options, $image_index);

    $img_result = gemini_generate_image($full_prompt);
    if (isset($img_result['error'])) {
        $job['errors'][] = array(
            'product_index' => $product_index,
            'image_index'   => $image_index,
            'error'         => $img_result['error'],
        );
        ai_save_job_state($job_id, $job);
        $resp = array('error' => $img_result['error'], 'product_index' => $product_index, 'image_index' => $image_index);
        if (!empty($img_result['quota_exceeded'])) {
            $resp['quota_exceeded'] = true;
        }
        ai_json_response($resp);
    }

    $upload_dir = dirname(__FILE__) . '/../../upload';
    $save = gemini_save_image_binary($img_result['binary'], $img_result['mime'], $upload_dir);
    if (isset($save['error'])) {
        ai_json_response(array('error' => $save['error']));
    }

    $job['images'][$img_key] = $save['filename'];
    ai_save_job_state($job_id, $job);

    ai_json_response(array(
        'ok'            => true,
        'filename'      => $save['filename'],
        'model'         => $img_result['model'],
        'product_index' => $product_index,
        'image_index'   => $image_index,
        'title'         => $product['title'],
    ));
}

if ($action === 'save_product') {
    if ($job_id === '') {
        ai_json_response(array('error' => 'job_id 필요'));
    }

    $product_index = isset($_POST['product_index']) ? intval($_POST['product_index']) : 0;
    $job = ai_load_job_state($job_id);
    if ($job === null) {
        ai_json_response(array('error' => '작업을 찾을 수 없습니다.'));
    }

    if (isset($job['saved'][$product_index])) {
        ai_json_response(array('ok' => true, 'skipped' => true, 'saved' => $job['saved'][$product_index]));
    }

    if (!isset($job['products'][$product_index])) {
        ai_json_response(array('error' => '상품 인덱스 오류'));
    }

    $product = $job['products'][$product_index];
    $image_count = isset($job['options']['image_count']) ? intval($job['options']['image_count']) : 4;
    if ($image_count < 4) $image_count = 4;
    if ($image_count > 8) $image_count = 8;

    $mapped = pkshop_ai_map_generated_images($job['images'], $product_index, $image_count);
    $imgl = $mapped['imgl'];
    $imgm = $mapped['imgm'];
    $imgb1 = $mapped['imgb1'];
    $imgb2 = $mapped['imgb2'];
    $imgb3 = $mapped['imgb3'];
    $imgb4 = $mapped['imgb4'];
    $imgb5 = $mapped['imgb5'];

    if ($imgl === '' && $imgm === '') {
        ai_json_response(array('error' => '이미지가 아직 생성되지 않았습니다.'));
    }
    if ($imgm === '') $imgm = $imgl;
    if ($imgl === '') $imgl = $imgm;

    $job_country = isset($job['options']['country']) ? $job['options']['country'] : '1';
    $country_map = array(
        '82' => 'KOREA', '66' => 'THAILAND', '91' => 'INDIA', '1' => 'USA',
        '81' => 'JAPAN', '86' => 'CHINA', '84' => 'VIETNAM', '62' => 'INDONESIA',
    );
    $home_label = isset($country_map[$job_country]) ? $country_map[$job_country] : 'USA';

    $product = pkshop_ai_enrich_product_detail($product);
    $detail_html = pkshop_ai_build_detail_html($product, $mapped['detail_images']);

    $row = array(
        'code1'     => $job['code1'],
        'code2'     => $job['code2'],
        'code3'     => $job['code3'],
        'code4'     => $job['code4'],
        'title'     => $product['title'],
        'company'   => isset($product['company']) ? $product['company'] : 'Pentakleva',
        'country'   => '1',
        'home'      => isset($product['home']) && $product['home'] !== '' ? $product['home'] : 'USA',
        'color'     => isset($product['color']) ? $product['color'] : '',
        'size'      => isset($product['size']) ? $product['size'] : 'S,M,L,XL',
        'pricec'    => isset($product['pricec']) ? strval($product['pricec']) : '500',
        'prices'    => isset($product['prices']) ? strval($product['prices']) : '450',
        'priced'    => isset($product['priced']) ? strval($product['priced']) : '450',
        'c_pv'      => isset($product['c_pv']) ? strval($product['c_pv']) : '10',
        'onlypoint' => '0',
        'dis'       => '0',
        'currnum'   => strval(rand(50, 200)),
        'warnnum'   => '10',
        'theme'     => 'g',
        'detail'    => $detail_html,
        'detail_images' => $mapped['detail_images'],
        'editors_notes' => isset($product['editors_notes']) ? $product['editors_notes'] : '',
        'features'  => isset($product['features']) ? $product['features'] : array(),
        'measurements_size' => isset($product['measurements_size']) ? $product['measurements_size'] : '',
        'measurements' => isset($product['measurements']) ? $product['measurements'] : array(),
        'model_info' => isset($product['model_info']) ? $product['model_info'] : '',
        'composition_care' => isset($product['composition_care']) ? $product['composition_care'] : array(),
        'designer'  => isset($product['designer']) ? $product['designer'] : '',
        'imgl'      => $imgl,
        'imgm'      => $imgm,
        'imgb1'     => $imgb1,
        'imgb2'     => $imgb2,
        'imgb3'     => $imgb3,
        'imgb4'     => $imgb4,
        'imgb5'     => $imgb5,
        '_memo'     => isset($job['options']['memo']) ? $job['options']['memo'] : '',
        '_gen_price_min'=> isset($job['options']['gen_price_min']) ? intval($job['options']['gen_price_min']) : 0,
        '_gen_price_max'=> isset($job['options']['gen_price_max']) ? intval($job['options']['gen_price_max']) : 0,
    );

    $result = pkshop_ai_insert_product($DB, $shop_goods, $row);
    if (!$result['success']) {
        ai_json_response(array('error' => $result['error']));
    }

    $job['saved'][$product_index] = array(
        'No'    => $result['No'],
        'code'  => $result['code'],
        'title' => $product['title'],
    );
    ai_save_job_state($job_id, $job);

    ai_json_response(array(
        'ok'            => true,
        'product_index' => $product_index,
        'No'            => $result['No'],
        'code'          => $result['code'],
        'title'         => $product['title'],
    ));
}

if ($action === 'status') {
    if ($job_id === '') {
        ai_json_response(array('error' => 'job_id 필요'));
    }
    $job = ai_load_job_state($job_id);
    if ($job === null) {
        ai_json_response(array('error' => '작업을 찾을 수 없습니다.'));
    }

    $image_count = count($job['images']);
    $saved_count = count($job['saved']);

    ai_json_response(array(
        'ok'          => true,
        'job_id'      => $job_id,
        'total'       => $job['total'],
        'image_count' => $image_count,
        'saved_count' => $saved_count,
        'saved'       => array_values($job['saved']),
        'errors'      => $job['errors'],
    ));
}

ai_json_response(array('error' => '알 수 없는 action'));
