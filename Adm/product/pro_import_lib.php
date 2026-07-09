<?php
/**
 * 상품 CSV/엑셀 일괄등록 공통 라이브러리
 * pro_up.php / pro_up_ok.php 등록 로직 기반
 */

function pkshop_import_columns() {
    return array(
        'code1'      => array('label' => '대분류코드',   'required' => true),
        'code2'      => array('label' => '중분류코드',   'required' => false, 'default' => '00'),
        'code3'      => array('label' => '소분류코드',   'required' => false, 'default' => '00'),
        'code4'      => array('label' => '세분류코드',   'required' => false, 'default' => '00'),
        'title'      => array('label' => '상품명',       'required' => true),
        'company'    => array('label' => '제조사',       'required' => false),
        'country'    => array('label' => '국가코드',     'required' => true),
        'home'       => array('label' => '원산지',       'required' => false),
        'color'      => array('label' => '색상종류',     'required' => false),
        'size'       => array('label' => '사이즈규격',   'required' => false),
        'pricec'     => array('label' => '판매가격',     'required' => false),
        'prices'     => array('label' => '할인가격',     'required' => false),
        'priced'     => array('label' => '실판매가격',   'required' => false),
        'c_pv'       => array('label' => 'RV퍼센트',     'required' => false),
        'onlypoint'  => array('label' => '포인트전용',   'required' => false, 'default' => '0'),
        'dis'        => array('label' => '상품구분',     'required' => false, 'default' => '0'),
        'currnum'    => array('label' => '재고',         'required' => false, 'default' => '0'),
        'warnnum'    => array('label' => '경고재고',     'required' => false, 'default' => '0'),
        'theme'      => array('label' => '상품홍보',     'required' => false, 'default' => 'g'),
        'detail'     => array('label' => '상세설명',     'required' => false),
        'imgl'       => array('label' => '리스트이미지', 'required' => false),
        'imgm'       => array('label' => '중간이미지',   'required' => false),
        'imgb1'      => array('label' => '상세이미지1',  'required' => false),
    );
}

function pkshop_import_header_map() {
    $map = array();
    foreach (pkshop_import_columns() as $key => $col) {
        $map[$key] = $key;
        $map[$col['label']] = $key;
    }
    $map['색상/종류'] = 'color';
    $map['사이즈/규격'] = 'size';
    return $map;
}

function pkshop_import_valid_countries() {
    return array('82', '66', '91', '1', '81', '86', '84', '62');
}

function pkshop_import_parse_file($filepath, $filename) {
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $rows = array();

    if ($ext === 'csv' || $ext === 'txt') {
        $rows = pkshop_import_parse_csv($filepath);
    } elseif ($ext === 'xls' || $ext === 'xlsx') {
        $rows = pkshop_import_parse_excel_html($filepath);
        if (count($rows) === 0) {
            $rows = pkshop_import_parse_csv($filepath, "\t");
        }
    } else {
        return array('error' => '지원하지 않는 파일 형식입니다. (csv, xls, xlsx, txt)');
    }

    if (count($rows) === 0) {
        return array('error' => '파일에서 데이터를 읽을 수 없습니다.');
    }

    return array('rows' => $rows);
}

function pkshop_import_parse_csv($filepath, $delimiter = ',') {
    $content = file_get_contents($filepath);
    if ($content === false) {
        return array();
    }

    if (substr($content, 0, 3) === "\xEF\xBB\xBF") {
        $content = substr($content, 3);
    }

    $encoding = mb_detect_encoding($content, array('UTF-8', 'EUC-KR', 'CP949', 'ASCII'), true);
    if ($encoding && $encoding !== 'UTF-8') {
        $content = mb_convert_encoding($content, 'UTF-8', $encoding);
    }

    $lines = preg_split('/\r\n|\r|\n/', $content);
    $rows = array();

    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '') {
            continue;
        }
        $rows[] = str_getcsv($line, $delimiter);
    }

    return $rows;
}

function pkshop_import_parse_excel_html($filepath) {
    $content = file_get_contents($filepath);
    if ($content === false || stripos($content, '<table') === false) {
        return array();
    }

    $encoding = mb_detect_encoding($content, array('UTF-8', 'EUC-KR', 'CP949'), true);
    if ($encoding && $encoding !== 'UTF-8') {
        $content = mb_convert_encoding($content, 'UTF-8', $encoding);
    }

    $rows = array();
    if (preg_match_all('/<tr[^>]*>(.*?)<\/tr>/is', $content, $tr_matches)) {
        foreach ($tr_matches[1] as $tr_html) {
            if (!preg_match_all('/<t[dh][^>]*>(.*?)<\/t[dh]>/is', $tr_html, $cell_matches)) {
                continue;
            }
            $row = array();
            foreach ($cell_matches[1] as $cell) {
                $cell = strip_tags($cell);
                $cell = html_entity_decode($cell, ENT_QUOTES, 'UTF-8');
                $cell = trim($cell);
                $row[] = $cell;
            }
            if (count($row) > 0) {
                $rows[] = $row;
            }
        }
    }

    return $rows;
}

function pkshop_import_rows_to_assoc($raw_rows) {
    if (count($raw_rows) < 2) {
        return array('error' => '헤더와 데이터 행이 최소 1건 이상 필요합니다.');
    }

    $header_map = pkshop_import_header_map();
    $headers = array();
    foreach ($raw_rows[0] as $h) {
        $h = trim($h);
        $headers[] = isset($header_map[$h]) ? $header_map[$h] : $h;
    }

    $columns = pkshop_import_columns();
    $data_rows = array();

    for ($i = 1; $i < count($raw_rows); $i++) {
        $line = $raw_rows[$i];
        if (pkshop_import_row_is_empty($line)) {
            continue;
        }

        $assoc = array();
        foreach ($columns as $key => $col) {
            $assoc[$key] = isset($col['default']) ? $col['default'] : '';
        }

        for ($j = 0; $j < count($headers); $j++) {
            if (!isset($line[$j])) {
                continue;
            }
            $field = $headers[$j];
            if (isset($columns[$field])) {
                $assoc[$field] = trim($line[$j]);
            }
        }

        $data_rows[] = array('line' => $i + 1, 'data' => $assoc);
    }

    if (count($data_rows) === 0) {
        return array('error' => '등록할 상품 데이터가 없습니다.');
    }

    return array('rows' => $data_rows);
}

function pkshop_import_row_is_empty($row) {
    foreach ($row as $cell) {
        if (trim($cell) !== '') {
            return false;
        }
    }
    return true;
}

function pkshop_import_validate_category($DB, $shop_cate, $code1, $code2, $code3, $code4) {
    if ($code1 === '' || $code1 === '00') {
        return '대분류코드(code1)는 필수입니다.';
    }

    $code2 = ($code2 === '') ? '00' : $code2;
    $code3 = ($code3 === '') ? '00' : $code3;
    $code4 = ($code4 === '') ? '00' : $code4;

    $query = "SELECT uid FROM $shop_cate WHERE code1='$code1' AND code2='$code2' AND code3='$code3' AND code4='$code4' LIMIT 1";
    $DB->get($query, $rs, $rn);
    if ($rn < 1) {
        return "카테고리를 찾을 수 없습니다. ($code1/$code2/$code3/$code4)";
    }

    return '';
}

function pkshop_import_generate_code($DB, $shop_goods, $code1, $code2, $code3, $code4) {
    $code2 = ($code2 === '' || $code2 === '00') ? '00' : $code2;
    $code3 = ($code3 === '' || $code3 === '00') ? '00' : $code3;
    $code4 = ($code4 === '' || $code4 === '00') ? '00' : $code4;

    if ($code4 !== '00') {
        $prefix = $code1 . $code2 . $code3 . $code4;
    } elseif ($code3 !== '00') {
        $prefix = $code1 . $code2 . $code3 . '00';
    } elseif ($code2 !== '00') {
        $prefix = $code1 . $code2 . '0000';
    } else {
        $prefix = $code1 . '000000';
    }

    $DB->get("SELECT max(code) FROM $shop_goods WHERE code LIKE '$prefix%'", $row, $ros);
    if ($row[0][0]) {
        $new_code = substr($row[0][0], -3);
        $new_code = $new_code + 1;
        $new_code = sprintf('%03d', $new_code);
    } else {
        $new_code = '001';
    }

    return $prefix . $new_code;
}

function pkshop_import_parse_theme($theme_str) {
    $theme_str = strtolower(trim($theme_str));
    if ($theme_str === '') {
        return array('theme_g' => 'g', 'theme_n' => '', 'theme_r' => '', 'theme_f' => '');
    }

    $parts = preg_split('/[,|\/]/', $theme_str);
    $result = array('theme_g' => '', 'theme_n' => '', 'theme_r' => '', 'theme_f' => '');

    foreach ($parts as $part) {
        $part = trim($part);
        if ($part === 'g' || $part === '기본' || $part === '기본상품') {
            $result['theme_g'] = 'g';
        } elseif ($part === 'n' || $part === '추천' || $part === '추천상품') {
            $result['theme_n'] = 'n';
        } elseif ($part === 'r' || $part === 'best' || $part === '베스트') {
            $result['theme_r'] = 'r';
        } elseif ($part === 'f' || $part === 'hot' || $part === 'hot상품') {
            $result['theme_f'] = 'f';
        }
    }

    if ($result['theme_g'] === '' && $result['theme_n'] === '' && $result['theme_r'] === '' && $result['theme_f'] === '') {
        $result['theme_g'] = 'g';
    }

    return $result;
}

function pkshop_import_validate_row($row) {
    $errors = array();
    $columns = pkshop_import_columns();

    if ($row['code1'] === '' || $row['code1'] === '00') {
        $errors[] = '대분류코드(code1) 필수';
    }
    if ($row['title'] === '') {
        $errors[] = '상품명(title) 필수';
    }
    if ($row['country'] === '') {
        $errors[] = '국가코드(country) 필수';
    } elseif (!in_array($row['country'], pkshop_import_valid_countries(), true)) {
        $errors[] = '국가코드 오류 (82,66,91,1,81,86,84,62)';
    }

    foreach (array('pricec', 'prices', 'priced', 'c_pv', 'currnum', 'warnnum') as $num_field) {
        if ($row[$num_field] !== '' && !is_numeric($row[$num_field])) {
            $errors[] = $columns[$num_field]['label'] . ' 숫자 형식 오류';
        }
    }

    if ($row['onlypoint'] !== '' && !in_array($row['onlypoint'], array('0', '1'), true)) {
        $errors[] = '포인트전용(onlypoint)은 0 또는 1';
    }
    if ($row['dis'] !== '' && !in_array($row['dis'], array('0', '1'), true)) {
        $errors[] = '상품구분(dis)은 0(일반) 또는 1(재구매)';
    }

    return $errors;
}

function pkshop_db_exec_insert($DB, $shop_goods, $insert_data, $code) {
    try {
        $DB->insert($shop_goods, $insert_data);
    } catch (Exception $e) {
        return array('success' => false, 'error' => 'DB 오류: ' . $e->getMessage());
    }

    $safe_code = addslashes($code);
    $DB->get("SELECT No FROM $shop_goods WHERE code='$safe_code' ORDER BY No DESC LIMIT 1", $rs, $rn);
    if ($rn < 1 || empty($rs[0]['No'])) {
        return array('success' => false, 'error' => 'DB 등록 후 상품 확인 실패');
    }

    return array('success' => true, 'No' => $rs[0]['No'], 'code' => $code);
}

function pkshop_import_insert_product($DB, $shop_goods, $row) {
    $code1 = $row['code1'];
    $code2 = ($row['code2'] === '') ? '00' : $row['code2'];
    $code3 = ($row['code3'] === '') ? '00' : $row['code3'];
    $code4 = ($row['code4'] === '') ? '00' : $row['code4'];

    $code = pkshop_import_generate_code($DB, $shop_goods, $code1, $code2, $code3, $code4);
    $theme = pkshop_import_parse_theme($row['theme']);

    $title   = addslashes(trim($row['title']));
    $company = addslashes(trim($row['company']));
    $home    = addslashes(trim($row['home']));
    $color   = addslashes(trim($row['color']));
    $size    = addslashes(trim($row['size']));
    $detail  = addslashes(trim($row['detail']));
    $imgl    = addslashes(trim($row['imgl']));
    $imgm    = addslashes(trim($row['imgm']));
    $imgb1   = addslashes(trim($row['imgb1']));

    $pricec    = ($row['pricec'] !== '') ? $row['pricec'] : '0';
    $prices    = ($row['prices'] !== '') ? $row['prices'] : $pricec;
    $priced    = ($row['priced'] !== '') ? $row['priced'] : $prices;
    $c_pv      = ($row['c_pv'] !== '') ? $row['c_pv'] : '0';
    $onlypoint = ($row['onlypoint'] !== '') ? $row['onlypoint'] : '0';
    $dis       = ($row['dis'] !== '') ? $row['dis'] : '0';
    $currnum   = ($row['currnum'] !== '') ? $row['currnum'] : '0';
    $warnnum   = ($row['warnnum'] !== '') ? $row['warnnum'] : '0';
    $country   = ($row['country'] !== '') ? $row['country'] : '1';

    $signdate  = time();
    $esigndate = time();
    $soldout   = 'N';
    $pr_kind   = 'main';
    $p_id      = 'admin';
    $order1    = 99999;
    $order2    = 99999;
    $order3    = 99999;
    $order4    = 99999;

    $insert_data = "code1='$code1',code2='$code2',code3='$code3',code4='$code4',code='$code',"
        . "title='$title',info='',company='$company',color='$color',size='$size',home='$home',shelf='',"
        . "theme='',event='',event_str='',new='',pricec='$pricec',priced='$priced',coin='',prices='$prices',"
        . "point='',point_dis='',currnum='$currnum',warnnum='$warnnum',"
        . "imgl='$imgl',imgm='$imgm',imgb1='$imgb1',imgb2='',imgb3='',imgb4='',imgb5='',"
        . "detail='$detail',feature='',signdate='$signdate',soldout='$soldout',rank='',"
        . "option_t1='',option_n1='',option_p1='',option_k1='',option_t2='',option_n2='',option_p2='',option_k2='',"
        . "option_t3='',option_n3='',option_p3='',option_k3='',option_t4='',option_n4='',option_p4='',option_k4='',"
        . "option_t5='',option_n5='',option_p5='',option_k5='',"
        . "order1='$order1',order2='$order2',order3='$order3',order4='$order4',"
        . "color_opt='',size_opt='',add_opt1='',add_opt2='',add_opt3='',add_opt4='',add_opt5='',relation='',"
        . "price_dis='',best='',cut='',recommend='',"
        . "theme_g='{$theme['theme_g']}',theme_n='{$theme['theme_n']}',theme_r='{$theme['theme_r']}',theme_f='{$theme['theme_f']}',"
        . "theme_x='',theme_y='',theme_z='',rank_g='',rank_n='',rank_r='',rank_f='',rank_x='',rank_y='',rank_z='',"
        . "opt_num='',opt_num_str='',theme_s='',rank_s='',p_id='$p_id',esigndate='$esigndate',pr_kind='$pr_kind',"
        . "c_pv='$c_pv',country='$country',onlypoint='$onlypoint',c_dis='$dis'";

    return pkshop_db_exec_insert($DB, $shop_goods, $insert_data, $code);
}

/**
 * 생성 가격 범위 정규화 (마지막 자리 0, 최소 10)
 */
function pkshop_ai_price_bounds($min, $max = 0) {
    $min = intval(preg_replace('/[^0-9]/', '', strval($min)));
    $max = intval(preg_replace('/[^0-9]/', '', strval($max)));

    if ($min <= 0 && $max <= 0) {
        return null;
    }

    if ($max <= 0) {
        return pkshop_ai_price_range_from_base($min);
    }

    $min = (int)(ceil($min / 10) * 10);
    $max = (int)(floor($max / 10) * 10);
    if ($min < 10) {
        $min = 10;
    }
    if ($max < $min) {
        $max = $min;
    }

    return array('min' => $min, 'max' => $max);
}

/**
 * 생성 가격 기준 USD 가격대 (예: 100 → 110~190, 1000 → 1100~1900) — 하위 호환
 */
function pkshop_ai_price_range_from_base($base) {
    $base = intval(preg_replace('/[^0-9]/', '', strval($base)));
    if ($base <= 0) {
        return null;
    }
    $unit = intval(max(10, $base / 10));
    $min = (int)(ceil(($base + $unit) / 10) * 10);
    $max = (int)(floor(($base + ($unit * 9)) / 10) * 10);
    if ($min > $max) {
        $max = $min;
    }
    return array('base' => $base, 'min' => $min, 'max' => $max);
}

function pkshop_ai_get_price_bounds_from_options($options) {
    $min = isset($options['gen_price_min']) ? intval($options['gen_price_min']) : 0;
    $max = isset($options['gen_price_max']) ? intval($options['gen_price_max']) : 0;
    if ($min > 0 || $max > 0) {
        return pkshop_ai_price_bounds($min, $max);
    }
    if (isset($options['gen_price']) && intval($options['gen_price']) > 0) {
        return pkshop_ai_price_range_from_base(intval($options['gen_price']));
    }
    return null;
}

function pkshop_ai_random_price_in_range($min, $max = 0) {
    $range = pkshop_ai_price_bounds($min, $max);
    if ($range === null) {
        return 10;
    }
    $steps = (int)(($range['max'] - $range['min']) / 10);
    return $range['min'] + (rand(0, max(0, $steps)) * 10);
}

function pkshop_ai_apply_generation_price(&$item, $min_price, $max_price = 0) {
    $range = pkshop_ai_price_bounds($min_price, $max_price);
    if ($range === null) {
        return;
    }
    $price = pkshop_ai_random_price_in_range($range['min'], $range['max']);
    $item['pricec'] = $price;
    $item['prices'] = $price;
    $item['priced'] = $price;
}

/**
 * AI 가격 정규화 — 생성 가격 범위 적용, 마지막 자리 0 절상
 */
function pkshop_ai_normalize_price($price, $memo = '', $min_price = 0, $max_price = 0) {
    $price = intval(preg_replace('/[^0-9]/', '', strval($price)));

    $range = null;
    if ($min_price > 0 || $max_price > 0) {
        $range = pkshop_ai_price_bounds($min_price, $max_price);
    } elseif ($min_price > 0) {
        $range = pkshop_ai_price_range_from_base($min_price);
    } elseif ($memo !== '' && preg_match('/(\d+)\s*(대|원대|달러대|\$대|usd)/iu', $memo, $m)) {
        $range = pkshop_ai_price_range_from_base(intval($m[1]));
    }

    if ($range !== null) {
        if ($price < $range['min'] || $price > $range['max'] || ($price % 10) !== 0) {
            $price = pkshop_ai_random_price_in_range($range['min'], $range['max']);
        }
        return $price;
    }

    if ($price <= 0) {
        return 10;
    }

    while ($price >= 1000 && $price % 100 === 0) {
        $price = intval($price / 100);
    }

    $price = (int)(ceil($price / 10) * 10);
    if ($price < 10) {
        $price = 10;
    }

    return $price;
}

function pkshop_ai_map_generated_images($job_images, $product_index, $image_count = 4) {
    if (!function_exists('pkshop_ai_resolve_image_filename')) {
        include_once dirname(__FILE__) . '/../../include/product_detail_helper.php';
    }

    $image_count = intval($image_count);
    if ($image_count < 4) {
        $image_count = 4;
    }
    if ($image_count > 8) {
        $image_count = 8;
    }

    $files = array();
    for ($i = 0; $i < $image_count; $i++) {
        $key = $product_index . '_' . $i;
        $files[$i] = pkshop_ai_resolve_image_filename(isset($job_images[$key]) ? $job_images[$key] : '');
    }

    $imgl = $files[0];
    $imgm = $files[1];
    if ($imgl === '' && $imgm !== '') {
        $imgl = $imgm;
    }
    if ($imgm === '' && $imgl !== '') {
        $imgm = $imgl;
    }

    $detail_images = array();
    for ($i = 4; $i < $image_count; $i++) {
        if ($files[$i] !== '') {
            $detail_images[] = $files[$i];
        }
    }
    if (count($detail_images) === 0) {
        for ($i = 0; $i < $image_count; $i++) {
            if ($files[$i] !== '' && !in_array($files[$i], $detail_images, true)) {
                $detail_images[] = $files[$i];
            }
        }
    }

    return array(
        'imgl' => $imgl,
        'imgm' => $imgm,
        'imgb1' => isset($files[2]) ? $files[2] : '',
        'imgb2' => isset($files[3]) ? $files[3] : '',
        'imgb3' => '',
        'imgb4' => '',
        'imgb5' => '',
        'detail_images' => $detail_images,
    );
}

function pkshop_ai_format_detail($detail) {
    $product = array('detail' => $detail);
    return pkshop_ai_build_detail_html($product, array());
}

function pkshop_ai_detail_line($text, $bold = false) {
    $text = trim((string)$text);
    if ($text === '') {
        return '<p style="text-align:center;margin-bottom:10px;font-size:13px;">&nbsp;</p>';
    }
    $style = 'text-align:center;margin-bottom:10px;font-size:13px;';
    if ($bold) {
        return '<p style="' . $style . '"><strong>' . htmlspecialchars($text, ENT_QUOTES, 'UTF-8') . '</strong></p>';
    }
    return '<p style="' . $style . '">' . htmlspecialchars($text, ENT_QUOTES, 'UTF-8') . '</p>';
}

function pkshop_ai_build_detail_html($product, $image_files = array()) {
    if (!function_exists('pkshop_ai_split_editor_note_lines')) {
        include_once dirname(__FILE__) . '/../../include/product_detail_helper.php';
    }

    $html = '';

    $editors_notes = '';
    if (!empty($product['editors_notes'])) {
        $editors_notes = $product['editors_notes'];
    } elseif (!empty($product['detail'])) {
        $editors_notes = strip_tags($product['detail']);
    }

    $html .= pkshop_ai_detail_line("Editor's Notes", true);
    foreach (pkshop_ai_split_editor_note_lines($editors_notes) as $line) {
        if ($line !== '') {
            $html .= pkshop_ai_detail_line($line);
        }
    }
    $html .= pkshop_ai_detail_line('');

    $features = array();
    if (!empty($product['features']) && is_array($product['features'])) {
        $features = $product['features'];
    }
    foreach ($features as $f) {
        $f = trim((string)$f);
        if ($f === '') {
            continue;
        }
        if (substr($f, 0, 2) !== '- ') {
            $f = '- ' . $f;
        }
        $html .= pkshop_ai_detail_line($f);
    }
    $html .= pkshop_ai_detail_line('');

    $html .= pkshop_ai_detail_line('Measurements(in.)', true);
    $size_label = !empty($product['measurements_size']) ? $product['measurements_size'] : (isset($product['size']) ? $product['size'] : 'One Size');
    $html .= pkshop_ai_detail_line('Size ' . $size_label);

    if (!empty($product['measurements']) && is_array($product['measurements'])) {
        foreach ($product['measurements'] as $m) {
            if (is_array($m) && isset($m['label'], $m['value'])) {
                $html .= pkshop_ai_detail_line('- ' . $m['label'] . ': ' . $m['value']);
            } else {
                $line = trim((string)$m);
                if ($line === '') {
                    continue;
                }
                if (substr($line, 0, 2) !== '- ') {
                    $line = '- ' . $line;
                }
                $html .= pkshop_ai_detail_line($line);
            }
        }
    }
    if (!empty($product['model_info'])) {
        $html .= pkshop_ai_detail_line('* Model info: ' . $product['model_info']);
    }
    $html .= pkshop_ai_detail_line('');

    $html .= pkshop_ai_detail_line('Composition & Care', true);
    if (!empty($product['composition_care']) && is_array($product['composition_care'])) {
        foreach ($product['composition_care'] as $c) {
            $c = trim((string)$c);
            if ($c === '') {
                continue;
            }
            if (substr($c, 0, 2) !== '- ') {
                $c = '- ' . $c;
            }
            $html .= pkshop_ai_detail_line($c);
        }
    }
    $html .= pkshop_ai_detail_line('');

    $designer = '';
    if (!empty($product['designer'])) {
        $designer = $product['designer'];
    } elseif (!empty($product['company'])) {
        $designer = $product['company'];
    }
    if ($designer !== '' && stripos($designer, 'by ') !== 0) {
        $designer = 'by ' . $designer;
    }
    $html .= pkshop_ai_detail_line('Designer', true);
    if ($designer !== '') {
        $html .= pkshop_ai_detail_line('- ' . $designer);
    }
    $html .= pkshop_ai_detail_line('');

    if (!function_exists('pkshop_ai_append_detail_images_html')) {
        include_once dirname(__FILE__) . '/../../include/product_detail_helper.php';
    }
    $html .= pkshop_ai_append_detail_images_html($image_files, $product);

    return $html;
}

function pkshop_ai_enrich_product_detail($product) {
    if (!function_exists('gemini_generate_text')) {
        return $product;
    }
    if (!empty($product['editors_notes']) && !empty($product['features'])) {
        return $product;
    }

    $title = isset($product['title']) ? $product['title'] : '';
    $company = isset($product['company']) ? $product['company'] : '';
    $size = isset($product['size']) ? $product['size'] : '';
    $color = isset($product['color']) ? $product['color'] : '';

    $prompt = 'Create realistic e-commerce product copy as JSON only for: "' . $title . '".
Brand: ' . $company . ', Size: ' . $size . ', Color: ' . $color . '
Schema:
{
  "editors_notes": "2 sentences, line1\\nline2",
  "features": ["Intended for ...", "Vintage ...", "Maxi length", "Snap button fastenings", "Toggle button detail"],
  "measurements_size": "One Size(XS-M)",
  "measurements": [{"label":"Length","value":"38.39 in"},{"label":"Bust","value":"48.03 in"}],
  "model_info": "Height 5\' 8\" Bust 31.5\" Waist 24.5\" Hip 35\"",
  "composition_care": ["80% Cotton, 20% Polyester", "Machine wash cold"],
  "designer": "by BRAND"
}
Use realistic measurements and materials for this product type. Return JSON only.';

    $result = gemini_generate_text($prompt, true);
    if (isset($result['error'])) {
        return $product;
    }
    $data = json_decode($result['text'], true);
    if (!is_array($data)) {
        return $product;
    }
    foreach ($data as $k => $v) {
        if (!isset($product[$k]) || $product[$k] === '' || $product[$k] === array()) {
            $product[$k] = $v;
        }
    }
    return $product;
}

/**
 * AI 생성 상품 등록 (imgb2 포함 4장 이미지)
 */
function pkshop_ai_insert_product($DB, $shop_goods, $row) {
    $code1 = $row['code1'];
    $code2 = ($row['code2'] === '') ? '00' : $row['code2'];
    $code3 = ($row['code3'] === '') ? '00' : $row['code3'];
    $code4 = ($row['code4'] === '') ? '00' : $row['code4'];

    $code = pkshop_import_generate_code($DB, $shop_goods, $code1, $code2, $code3, $code4);
    // AI 상품은 ETC(기본) 등록만 — BEST/추천/HOT 자동 노출 방지
    $theme = array('theme_g' => 'g', 'theme_n' => '', 'theme_r' => '', 'theme_f' => '');

    $title   = addslashes(trim($row['title']));
    $company = addslashes(trim($row['company']));
    $home    = addslashes(trim($row['home']));
    $color   = addslashes(trim($row['color']));
    $size    = addslashes(trim($row['size']));
    $memo    = isset($row['_memo']) ? $row['_memo'] : '';
    $gen_price_min = isset($row['_gen_price_min']) ? intval($row['_gen_price_min']) : 0;
    $gen_price_max = isset($row['_gen_price_max']) ? intval($row['_gen_price_max']) : 0;
    if ($gen_price_min <= 0 && isset($row['_gen_price'])) {
        $legacy = pkshop_ai_price_range_from_base(intval($row['_gen_price']));
        if ($legacy !== null) {
            $gen_price_min = $legacy['min'];
            $gen_price_max = $legacy['max'];
        }
    }
    if (!empty($row['detail']) && strpos($row['detail'], "Editor's Notes") !== false) {
        $detail = addslashes(trim($row['detail']));
    } else {
        $detail = addslashes(pkshop_ai_build_detail_html($row, array(
            isset($row['detail_images']) && is_array($row['detail_images']) ? $row['detail_images'] : array(
                isset($row['imgb3']) ? $row['imgb3'] : '',
                isset($row['imgb4']) ? $row['imgb4'] : '',
                isset($row['imgb5']) ? $row['imgb5'] : '',
            ),
        )));
    }
    $imgl    = addslashes(trim($row['imgl']));
    $imgm    = addslashes(trim($row['imgm']));
    $imgb1   = addslashes(trim(isset($row['imgb1']) ? $row['imgb1'] : ''));
    $imgb2   = addslashes(trim(isset($row['imgb2']) ? $row['imgb2'] : ''));
    $imgb3   = addslashes(trim(isset($row['imgb3']) ? $row['imgb3'] : ''));
    $imgb4   = addslashes(trim(isset($row['imgb4']) ? $row['imgb4'] : ''));
    $imgb5   = addslashes(trim(isset($row['imgb5']) ? $row['imgb5'] : ''));

    $pricec    = strval(pkshop_ai_normalize_price(isset($row['pricec']) ? $row['pricec'] : '0', $memo, $gen_price_min, $gen_price_max));
    $prices    = strval(pkshop_ai_normalize_price(isset($row['prices']) ? $row['prices'] : $pricec, $memo, $gen_price_min, $gen_price_max));
    $priced    = strval(pkshop_ai_normalize_price(isset($row['priced']) ? $row['priced'] : $prices, $memo, $gen_price_min, $gen_price_max));
    $c_pv      = ($row['c_pv'] !== '') ? $row['c_pv'] : '0';
    $onlypoint = ($row['onlypoint'] !== '') ? $row['onlypoint'] : '0';
    $dis       = ($row['dis'] !== '') ? $row['dis'] : '0';
    $currnum   = ($row['currnum'] !== '') ? $row['currnum'] : '0';
    $warnnum   = ($row['warnnum'] !== '') ? $row['warnnum'] : '0';
    $country   = ($row['country'] !== '') ? $row['country'] : '1';

    $signdate  = time();
    $esigndate = time();
    $soldout   = 'N';
    $pr_kind   = 'main';
    $p_id      = 'admin_ai';

    $insert_data = "code1='$code1',code2='$code2',code3='$code3',code4='$code4',code='$code',"
        . "title='$title',info='',company='$company',color='$color',size='$size',home='$home',shelf='',"
        . "theme='',event='',event_str='',new='',pricec='$pricec',priced='$priced',coin='',prices='$prices',"
        . "point='',point_dis='',currnum='$currnum',warnnum='$warnnum',"
        . "imgl='$imgl',imgm='$imgm',imgb1='$imgb1',imgb2='$imgb2',imgb3='$imgb3',imgb4='$imgb4',imgb5='$imgb5',"
        . "detail='$detail',feature='',signdate='$signdate',soldout='$soldout',rank='',"
        . "option_t1='',option_n1='',option_p1='',option_k1='',option_t2='',option_n2='',option_p2='',option_k2='',"
        . "option_t3='',option_n3='',option_p3='',option_k3='',option_t4='',option_n4='',option_p4='',option_k4='',"
        . "option_t5='',option_n5='',option_p5='',option_k5='',"
        . "order1='99999',order2='99999',order3='99999',order4='99999',"
        . "color_opt='',size_opt='',add_opt1='',add_opt2='',add_opt3='',add_opt4='',add_opt5='',relation='',"
        . "price_dis='',best='',cut='',recommend='',"
        . "theme_g='{$theme['theme_g']}',theme_n='{$theme['theme_n']}',theme_r='{$theme['theme_r']}',theme_f='{$theme['theme_f']}',"
        . "theme_x='',theme_y='',theme_z='',rank_g='',rank_n='',rank_r='',rank_f='',rank_x='',rank_y='',rank_z='',"
        . "opt_num='',opt_num_str='',theme_s='',rank_s='',p_id='$p_id',esigndate='$esigndate',pr_kind='$pr_kind',"
        . "c_pv='$c_pv',country='$country',onlypoint='$onlypoint',c_dis='$dis'";

    return pkshop_db_exec_insert($DB, $shop_goods, $insert_data, $code);
}

function pkshop_import_get_categories($DB, $shop_cate) {
    $query = "SELECT code1,code2,code3,code4,cate1,cate2,cate3,cate4 FROM $shop_cate ORDER BY code1,code2,code3,code4";
    $DB->get($query, $rs, $rn);
    return array('rows' => $rs, 'count' => $rn);
}

function pkshop_import_csv_escape($val) {
    $val = str_replace('"', '""', $val);
    if (strpos($val, ',') !== false || strpos($val, '"') !== false || strpos($val, "\n") !== false) {
        return '"' . $val . '"';
    }
    return $val;
}

/**
 * AI 상품생성용 대분류 카테고리 자동 등록
 */
function pkshop_ai_create_category_level1($DB, $shop_cate, $cate_name) {
    $cate_name = trim($cate_name);
    if ($cate_name === '') {
        return array('error' => '신규 카테고리명을 입력하세요.');
    }

    $DB->get("SELECT code1 FROM $shop_cate WHERE code2='00' AND code3='00' AND code4='00' ORDER BY code1 DESC LIMIT 1", $rs, $rn);
    if ($rn > 0 && $rs[0]['code1'] !== '') {
        $ncode1 = intval($rs[0]['code1']) + 1;
    } else {
        $ncode1 = 1;
    }
    $code1 = sprintf('%02d', $ncode1);

    $DB->get("SELECT uid FROM $shop_cate WHERE code1='$code1' AND code2='00' AND code3='00' AND code4='00'", $chk, $crn);
    if ($crn > 0) {
        return array('error' => '카테고리 코드 충돌: ' . $code1);
    }

    $DB->get("SELECT max(uid) as max_uid FROM $shop_cate", $uid_rs, $uid_rn);
    $new_uid = ($uid_rn > 0 && $uid_rs[0]['max_uid']) ? intval($uid_rs[0]['max_uid']) + 1 : 1;

    $DB->get("SELECT max(rank) as max_rank FROM $shop_cate WHERE code2='00' AND code3='00' AND code4='00'", $rank_rs, $rank_rn);
    $rank = ($rank_rn > 0 && $rank_rs[0]['max_rank']) ? intval($rank_rs[0]['max_rank']) + 1 : 1;

    $cate1_safe = addslashes($cate_name);
    $query = "uid='$new_uid',cate1='$cate1_safe',cate2='',cate3='',cate4='',code1='$code1',code2='00',code3='00',code4='00',rank='$rank',order_rank='$rank'";

    try {
        $DB->insert($shop_cate, $query);
    } catch (Exception $e) {
        return array('error' => '카테고리 등록 실패: ' . $e->getMessage());
    }

    return array(
        'success' => true,
        'code1'   => $code1,
        'cate1'   => $cate_name,
    );
}

function pkshop_ai_option_genders() {
    return array('female' => '여성', 'male' => '남성', 'children' => '아동', 'all' => '전체');
}

function pkshop_ai_generate_products_plan($count, $options) {
    if (function_exists('gemini_generate_products_plan')) {
        return gemini_generate_products_plan($count, $options);
    }

    $batch_size = 5;
    $all_products = array();
    $offset = 0;
    $target = intval($count);
    $max_rounds = max(12, (int)ceil($target / 2) + 4);
    $round = 0;

    while (count($all_products) < $target && $round < $max_rounds) {
        $round++;
        $need = $target - count($all_products);
        $batch_count = min($batch_size, $need);
        $prompt = gemini_build_product_plan_prompt($batch_count, $options, $offset);
        $text_result = gemini_generate_text($prompt, true);
        if (isset($text_result['error'])) {
            if (count($all_products) > 0) {
                break;
            }
            return array('error' => $text_result['error']);
        }
        $plan = gemini_parse_product_plan($text_result['text'], $options);
        if (isset($plan['error'])) {
            if (count($all_products) > 0) {
                break;
            }
            return array('error' => $plan['error']);
        }
        $got = count($plan['products']);
        if ($got === 0) {
            sleep(2);
            continue;
        }
        foreach ($plan['products'] as $p) {
            $all_products[] = $p;
            if (count($all_products) >= $target) {
                break;
            }
        }
        $offset += $got;
        if (count($all_products) < $target) {
            sleep(1);
        }
    }

    if (count($all_products) < $target) {
        return array(
            'error' => '상품 기획 ' . $target . '개 중 ' . count($all_products) . '개만 생성되었습니다. 잠시 후 다시 시도하거나 수량을 줄여주세요.',
            'products' => array_slice($all_products, 0, $target),
        );
    }

    return array('products' => array_slice($all_products, 0, $target));
}
