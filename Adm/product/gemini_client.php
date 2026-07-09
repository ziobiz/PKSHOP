<?php
/**
 * 제미나이(Gemini) API 클라이언트 — 텍스트·이미지 생성
 */

function gemini_load_api_key() {
    if (defined('GEMINI_API_KEY') && GEMINI_API_KEY !== '' && GEMINI_API_KEY !== 'YOUR_GEMINI_API_KEY_HERE') {
        return GEMINI_API_KEY;
    }
    $secret_file = dirname(__FILE__) . '/../../lib/gemini_secrets.local.php';
    if (file_exists($secret_file)) {
        include_once $secret_file;
    }
    if (defined('GEMINI_API_KEY') && GEMINI_API_KEY !== '' && GEMINI_API_KEY !== 'YOUR_GEMINI_API_KEY_HERE') {
        return GEMINI_API_KEY;
    }
    return '';
}

function gemini_secrets_file_path() {
    return dirname(__FILE__) . '/../../lib/gemini_secrets.local.php';
}

function gemini_mask_api_key($key) {
    $key = trim((string)$key);
    if ($key === '' || $key === 'YOUR_GEMINI_API_KEY_HERE') {
        return '';
    }
    $len = strlen($key);
    if ($len <= 3) {
        return $key;
    }
    return substr($key, 0, 3) . str_repeat('*', $len - 3);
}

function gemini_api_key_status() {
    $key = gemini_load_api_key();
    if ($key === '') {
        return array('configured' => false, 'masked' => '', 'message' => '미설정');
    }
    return array(
        'configured' => true,
        'masked' => gemini_mask_api_key($key),
        'message' => '설정됨',
    );
}

function gemini_save_api_key($new_key) {
    $new_key = trim($new_key);
    if ($new_key === '') {
        return array('error' => 'API 키를 입력하세요.');
    }
    if (strlen($new_key) < 20) {
        return array('error' => '올바른 API 키 형식이 아닙니다. Google AI Studio에서 발급한 키를 입력하세요.');
    }

    $path = gemini_secrets_file_path();
    $dir = dirname($path);
    if (!is_dir($dir)) {
        return array('error' => 'lib 폴더를 찾을 수 없습니다.');
    }
    if (file_exists($path)) {
        if (!is_writable($path)) {
            return array('error' => 'API 키 파일에 쓸 수 없습니다. lib/gemini_secrets.local.php 권한을 확인하세요.');
        }
    } elseif (!is_writable($dir)) {
        return array('error' => 'lib 폴더에 쓸 수 없습니다. 서버 폴더 권한을 확인하세요.');
    }

    $escaped = addslashes($new_key);
    $content = "<?php\n";
    $content .= "/**\n";
    $content .= " * Gemini API 키 — AI 상품 생성 관리자에서 저장됨\n";
    $content .= " */\n";
    $content .= "if (!defined('GEMINI_API_KEY')) {\n";
    $content .= "    define('GEMINI_API_KEY', '" . $escaped . "');\n";
    $content .= "}\n";

    $written = @file_put_contents($path, $content, LOCK_EX);
    if ($written === false) {
        return array('error' => 'API 키 저장에 실패했습니다. 서버 lib 폴더 쓰기 권한을 확인하세요.');
    }

    return array('success' => true, 'masked' => gemini_mask_api_key($new_key));
}

function gemini_api_request($model, $payload, $timeout = 120) {
    $api_key = gemini_load_api_key();
    if ($api_key === '') {
        return array('error' => 'GEMINI API 키가 설정되지 않았습니다. AI 상품 생성 화면에서 API 키를 등록하세요.');
    }

    $url = 'https://generativelanguage.googleapis.com/v1beta/models/' . $model . ':generateContent';

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'x-goog-api-key: ' . $api_key,
    ));
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_err = curl_error($ch);
    curl_close($ch);

    if ($response === false) {
        return array('error' => 'API 연결 실패: ' . $curl_err);
    }

    $data = json_decode($response, true);
    if ($http_code >= 400) {
        $msg = isset($data['error']['message']) ? $data['error']['message'] : ('HTTP ' . $http_code);
        $formatted = gemini_format_api_error($msg);
        return array('error' => $formatted['message'], 'quota_exceeded' => $formatted['quota_exceeded'], 'raw' => $response);
    }

    return array('data' => $data);
}

function gemini_format_api_error($msg) {
    $quota = (stripos($msg, 'quota') !== false || stripos($msg, 'free_tier') !== false || stripos($msg, 'billing') !== false);
    if ($quota) {
        return array(
            'quota_exceeded' => true,
            'message' => '[API 한도 초과] 이미지 생성은 유료 결제(Tier 1)가 필요합니다. '
                . 'Google AI Studio(https://aistudio.google.com) → 결제 정보 등록 후 AIzaSy... 형식 API 키를 사용하세요. '
                . '(무료 티어는 이미지 생성 한도가 0입니다)',
        );
    }
    if (strlen($msg) > 200) {
        $msg = substr($msg, 0, 200) . '...';
    }
    return array('quota_exceeded' => false, 'message' => $msg);
}

function gemini_text_models() {
    return array(
        'gemini-2.5-flash',
        'gemini-2.0-flash',
        'gemini-1.5-flash',
    );
}

function gemini_image_models() {
    return array(
        'gemini-2.5-flash',
        'gemini-2.5-flash-image',
    );
}

function gemini_generate_text($prompt, $json_mode = false) {
    $payload = array(
        'contents' => array(
            array('parts' => array(array('text' => $prompt))),
        ),
    );
    if ($json_mode) {
        $payload['generationConfig'] = array(
            'responseMimeType' => 'application/json',
            'maxOutputTokens' => 8192,
        );
    }

    $last_error = '';
    $errors = array();

    foreach (gemini_text_models() as $model) {
        $result = gemini_api_request($model, $payload, 90);
        if (!isset($result['error'])) {
            $text = gemini_extract_text($result['data']);
            if ($text !== '') {
                return array('text' => $text, 'model' => $model);
            }
        }
        $last_error = isset($result['error']) ? $result['error'] : 'empty response';
        $errors[] = $model . ': ' . $last_error;
    }

    return array('error' => isset($last_error) ? $last_error : '텍스트 생성 실패', 'tried' => $errors);
}

function gemini_extract_text($data) {
    if (!isset($data['candidates'][0]['content']['parts'])) {
        return '';
    }
    $text = '';
    foreach ($data['candidates'][0]['content']['parts'] as $part) {
        if (isset($part['text'])) {
            $text .= $part['text'];
        }
    }
    return trim($text);
}

function gemini_generate_image($prompt) {
    $payload = array(
        'contents' => array(
            array('parts' => array(array('text' => $prompt))),
        ),
        'generationConfig' => array(
            'responseModalities' => array('IMAGE', 'TEXT'),
        ),
    );

    foreach (gemini_image_models() as $model) {
        $result = gemini_api_request($model, $payload, 180);
        if (isset($result['error'])) {
            $last_error = $result['error'];
            if (!empty($result['quota_exceeded'])) {
                return array('error' => $last_error, 'quota_exceeded' => true);
            }
            continue;
        }
        $image = gemini_extract_image($result['data']);
        if ($image !== null) {
            return array(
                'binary' => $image['binary'],
                'mime'   => $image['mime'],
                'model'  => $model,
            );
        }
        $last_error = '이미지 데이터 없음 (' . $model . ')';
    }

    return array('error' => isset($last_error) ? $last_error : '이미지 생성 실패');
}

function gemini_extract_image($data) {
    if (!isset($data['candidates'][0]['content']['parts'])) {
        return null;
    }
    foreach ($data['candidates'][0]['content']['parts'] as $part) {
        if (isset($part['inlineData']['data'])) {
            $binary = base64_decode($part['inlineData']['data']);
            if ($binary !== false && strlen($binary) > 100) {
                return array(
                    'binary' => $binary,
                    'mime'   => isset($part['inlineData']['mimeType']) ? $part['inlineData']['mimeType'] : 'image/png',
                );
            }
        }
        if (isset($part['inline_data']['data'])) {
            $binary = base64_decode($part['inline_data']['data']);
            if ($binary !== false && strlen($binary) > 100) {
                return array(
                    'binary' => $binary,
                    'mime'   => isset($part['inline_data']['mime_type']) ? $part['inline_data']['mime_type'] : 'image/png',
                );
            }
        }
    }
    return null;
}

function gemini_save_image_binary($binary, $mime, $upload_dir) {
    if (!is_dir($upload_dir)) {
        if (!@mkdir($upload_dir, 0755, true)) {
            return array('error' => 'upload 폴더 생성 실패: ' . $upload_dir);
        }
    }
    if (!is_writable($upload_dir)) {
        return array('error' => 'upload 폴더 쓰기 권한 없음: ' . $upload_dir);
    }

    $free = @disk_free_space($upload_dir);
    if ($free !== false && $free < 5 * 1024 * 1024) {
        return array('error' => '디스크 용량 부족 (남은 공간: ' . round($free / 1024 / 1024, 1) . 'MB)');
    }

    $binary = gemini_compress_image_binary($binary, $mime);
    if ($binary === false || strlen($binary) < 100) {
        return array('error' => '이미지 처리 실패');
    }

    $ext = 'jpg';
    $filename = rand(10000000, 99999999) . '.' . $ext;
    $filepath = rtrim($upload_dir, '/\\') . DIRECTORY_SEPARATOR . $filename;

    $count = 0;
    while (file_exists($filepath) && $count < 20) {
        $filename = rand(10000000, 99999999) . '_' . $count . '.' . $ext;
        $filepath = rtrim($upload_dir, '/\\') . DIRECTORY_SEPARATOR . $filename;
        $count++;
    }

    $written = @file_put_contents($filepath, $binary);
    if ($written === false) {
        return array('error' => '이미지 저장 실패 (' . $filepath . ')');
    }

    return array('filename' => $filename, 'path' => $filepath);
}

function gemini_catalog_image_dimensions() {
    return array('width' => 525, 'height' => 700);
}

function gemini_compress_image_binary($binary, $mime) {
    if (!function_exists('imagecreatefromstring')) {
        return $binary;
    }

    $img = @imagecreatefromstring($binary);
    if ($img === false) {
        return $binary;
    }

    $dims = gemini_catalog_image_dimensions();
    $target_w = $dims['width'];
    $target_h = $dims['height'];

    $width = imagesx($img);
    $height = imagesy($img);
    $src_ratio = $width / $height;
    $dst_ratio = $target_w / $target_h;

    if ($src_ratio > $dst_ratio) {
        $crop_h = $height;
        $crop_w = (int) round($height * $dst_ratio);
        $src_x = (int) round(($width - $crop_w) / 2);
        $src_y = 0;
    } else {
        $crop_w = $width;
        $crop_h = (int) round($width / $dst_ratio);
        $src_x = 0;
        $src_y = (int) round(($height - $crop_h) / 2);
    }

    $resized = imagecreatetruecolor($target_w, $target_h);
    $white = imagecolorallocate($resized, 255, 255, 255);
    imagefill($resized, 0, 0, $white);
    imagecopyresampled($resized, $img, 0, 0, $src_x, $src_y, $target_w, $target_h, $crop_w, $crop_h);
    imagedestroy($img);
    $img = $resized;

    ob_start();
    imagejpeg($img, null, 85);
    $jpeg = ob_get_clean();
    imagedestroy($img);

    return ($jpeg !== false && strlen($jpeg) > 100) ? $jpeg : $binary;
}

function gemini_product_type_options() {
    return array(
        'clothing'    => '의류/패션',
        'appliances'  => '가전',
        'electronics' => '전자제품',
        'computer'    => '컴퓨터/IT',
        'gift_card'   => '상품권',
        'travel'      => '여행권',
        'hotel'       => '호텔이용권',
        'food'        => '식품',
        'beauty'      => '뷰티/화장품',
        'sports'      => '스포츠/레저',
        'furniture'   => '가구/인테리어',
        'books'       => '도서',
        'toys'        => '완구/키즈',
        'jewelry'     => '주얼리/액세서리',
        'automotive'  => '자동차용품',
        'pet'         => '반려동물용품',
        'health'      => '건강/의료기기',
        'office'      => '문구/오피스',
        'other'       => '기타',
    );
}

function gemini_gender_options() {
    return array(
        'female'   => '여성',
        'male'     => '남성',
        'children' => '아동',
        'all'      => '전체',
    );
}

function gemini_season_options() {
    return array(
        'spring'     => '봄',
        'summer'     => '여름',
        'autumn'     => '가을',
        'winter'     => '겨울',
        'all_season' => '사계절',
    );
}

function gemini_country_options() {
    return array(
        '82' => array('label' => 'KOREA', 'name' => '한국'),
        '66' => array('label' => 'THAILAND', 'name' => '태국'),
        '91' => array('label' => 'INDIA', 'name' => '인도'),
        '1'  => array('label' => 'USA', 'name' => '미국'),
        '81' => array('label' => 'JAPAN', 'name' => '일본'),
        '86' => array('label' => 'CHINA', 'name' => '중국'),
        '84' => array('label' => 'VIETNAM', 'name' => '베트남'),
        '62' => array('label' => 'INDONESIA', 'name' => '인도네시아'),
    );
}

function gemini_build_product_plan_prompt($count, $options = array(), $batch_offset = 0) {
    $gender_map = gemini_gender_options();
    $season_map = gemini_season_options();
    $type_map   = gemini_product_type_options();
    $country_map = gemini_country_options();

    $gender = isset($options['gender']) ? $options['gender'] : 'all';
    $season = isset($options['season']) ? $options['season'] : 'all_season';
    $country_code = isset($options['country']) ? $options['country'] : '1';
    $memo = isset($options['memo']) ? trim($options['memo']) : '';

    $gender_label = isset($gender_map[$gender]) ? $gender_map[$gender] : '전체';
    $season_label = isset($season_map[$season]) ? $season_map[$season] : '사계절';
    $country_info = isset($country_map[$country_code]) ? $country_map[$country_code] : $country_map['1'];

    $types = isset($options['product_types']) ? $options['product_types'] : array('clothing');
    if (!is_array($types)) {
        $types = array($types);
    }
    $type_labels = array();
    foreach ($types as $t) {
        if (isset($type_map[$t])) {
            $type_labels[] = $type_map[$t];
        }
    }
    if (isset($options['product_type_custom']) && trim($options['product_type_custom']) !== '') {
        $type_labels[] = trim($options['product_type_custom']);
    }
    if (count($type_labels) === 0) {
        $type_labels[] = '일반 상품';
    }
    $types_str = implode(', ', $type_labels);

    $image_count = isset($options['image_count']) ? intval($options['image_count']) : 4;
    if ($image_count < 4) $image_count = 4;
    if ($image_count > 8) $image_count = 8;

    $offset_note = $batch_offset > 0 ? ' (batch offset ' . $batch_offset . ', create different products from previous batches)' : '';

    $price_rules = "- pricec/prices/priced: USD integer price for US market. Last digit MUST be 0 (110 OK, 111 NOT allowed).\n"
        . "- Examples: 110, 450, 580 — NOT 111, 115, 49000.\n"
        . "- If notes mention price range like \"100대\" or \"500 dollar range\": use only that band, always ending in 0.\n"
        . "- Never use prices ending in 00 excess zeros (use 450 not 45000).\n";
    if (function_exists('pkshop_ai_get_price_bounds_from_options')) {
        $range = pkshop_ai_get_price_bounds_from_options($options);
        if ($range !== null) {
            $mid = $range['min'] + 10;
            if ($mid > $range['max']) {
                $mid = $range['min'];
            }
            $price_rules = "- pricec/prices/priced: USD integer ONLY between {$range['min']} and {$range['max']} inclusive.\n"
                . "- Manager set price range {$range['min']}~{$range['max']} USD — valid examples: {$range['min']}, {$mid}, {$range['max']}.\n"
                . "- Last digit MUST be 0 (ceil to tens). NEVER use values outside {$range['min']}~{$range['max']}.\n";
        }
    }

    return 'You are an e-commerce merchandiser for Pentakleva concept shopping mall.
Generate exactly ' . intval($count) . ' unique product entries' . $offset_note . ' based on these keywords:

- Target gender: ' . $gender_label . '
- Season: ' . $season_label . '
- Country/Market: ' . $country_info['name'] . ' (' . $country_info['label'] . ')
- Product categories: ' . $types_str . '
' . ($memo !== '' ? '- Additional notes from manager: ' . $memo . "\n" : '') . '
Return ONLY valid JSON array (no markdown). Each item schema:
{
  "title": "English product name, max 80 chars",
  "company": "brand name",
  "country": "' . $country_code . '",
  "home": "' . $country_info['label'] . '",
  "color": "comma-separated (use N/A for non-fashion items)",
  "size": "S,M,L,XL or N/A",
  "pricec": 450,
  "prices": 450,
  "priced": 450,
  "c_pv": 10,
  "theme": "g",
  "editors_notes": "Two realistic sentences about the product, separated by newline",
  "features": ["Intended for a relaxed fit", "Breathable fabric", "Summer essential", "Easy care"],
  "measurements_size": "One Size(XS-M) or S,M,L,XL",
  "measurements": [{"label":"Length","value":"26.5 in"},{"label":"Bust","value":"40.0 in"}],
  "model_info": "Height 5 ft 8 in, Bust 31.5 in, Waist 24.5 in, Hip 35 in",
  "composition_care": ["80% Cotton, 20% Polyester", "Machine wash cold"],
  "designer": "by Brand Name",
  "image_prompts": [
    "female model wearing the product, full-body portrait, clean white studio background, fashion e-commerce catalog photo, vertical 3:4",
    "model mid-shot showing product fit and styling, white studio background",
    "fabric texture and product detail close-up",
    "alternate angle or back view on model, white background"
  ]
}
Rules:
- Products MUST match the categories: ' . $types_str . '
- Gender target: ' . $gender_label . ', Season: ' . $season_label . '
' . $price_rules . '- editors_notes, features, measurements, composition_care, designer must be realistic for the actual product (like a real fashion e-commerce listing).
- features: 4-6 bullet points without leading dash in JSON (dash added on display).
- measurements: 4-6 realistic inch measurements appropriate for product type.
- composition_care: fabric composition % and care instruction.
- designer: format "by BRANDNAME" matching company field.
- image_prompts: exactly ' . $image_count . ' detailed English prompts. Image 1 MUST be a model wearing the product (portrait catalog shot). Images 2-4: styling, detail, alternate angle (used for list/thumbnail gallery). Images 5-' . $image_count . ': additional product detail shots for Product Details section (flat lay, back view, close-up, lifestyle). White studio background, photorealistic, no text/watermark/logo. Vertical portrait orientation.
- country field always "' . $country_code . '", home "' . $country_info['label'] . '"
- theme: always "g" (basic product only — do NOT use n, r, or f)
- Vary product names and styles across items
Return JSON array only.';
}

function gemini_generate_products_plan($count, $options) {
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

function gemini_image_prompt_enhance($prompt, $product_title, $options = array(), $image_index = 0) {
    $types = isset($options['product_types']) ? $options['product_types'] : array('clothing');
    $is_fashion = in_array('clothing', $types) || in_array('jewelry', $types);
    $gender = isset($options['gender']) ? $options['gender'] : 'female';

    if ($is_fashion) {
        if ($image_index === 0) {
            $style = 'Professional fashion e-commerce catalog photo matching Pentakleva mall style. '
                . 'Portrait orientation 3:4, female model wearing the product, full or 3/4 body shot, '
                . 'clean white studio background, soft natural lighting, same look as high-end online boutique.';
        } elseif ($image_index === 1) {
            $style = 'Fashion e-commerce photo, model wearing the product, white studio background, portrait orientation.';
        } else {
            $style = 'Fashion product detail photo, white background, e-commerce catalog style.';
        }
        if ($gender === 'male') {
            $style = str_replace('female model', 'male model', $style);
        } elseif ($gender === 'children') {
            $style = str_replace('female model', 'child model', $style);
        }
    } else {
        $style = 'Professional e-commerce product photography, white background, centered product, portrait orientation 3:4.';
    }

    return $style . ' Product: ' . $product_title . '. '
        . $prompt
        . ' High quality, no watermark, no text, no logo, realistic.';
}

function gemini_normalize_product_plan_items($data) {
    if (!is_array($data)) {
        return array();
    }
    if (isset($data['products']) && is_array($data['products'])) {
        return $data['products'];
    }
    if (isset($data['items']) && is_array($data['items'])) {
        return $data['items'];
    }
    if (isset($data['title'])) {
        return array($data);
    }
    $items = array();
    foreach ($data as $k => $item) {
        if (is_array($item) && isset($item['title'])) {
            $items[] = $item;
        }
    }
    return $items;
}

function gemini_ensure_product_image_prompts(&$item, $image_count = 4) {
    $title = isset($item['title']) ? trim((string)$item['title']) : 'fashion product';
    $image_count = intval($image_count);
    if ($image_count < 4) $image_count = 4;
    if ($image_count > 8) $image_count = 8;

    if (!isset($item['image_prompts']) || !is_array($item['image_prompts'])) {
        $item['image_prompts'] = array();
    }
    $defaults = array(
        'Female model wearing ' . $title . ', full-body portrait, white studio background, fashion e-commerce catalog photo',
        'Model mid-shot showing fit and styling of ' . $title . ', white studio background',
        'Fabric and detail close-up of ' . $title . ', white background',
        'Alternate angle of ' . $title . ' on model, white background',
        'Lifestyle styling shot of ' . $title . ', natural pose, clean background',
        'Back view of ' . $title . ' on model, white studio background',
        'Flat lay product photo of ' . $title . ', white background',
        'Additional detail macro shot of ' . $title . ', texture and craftsmanship',
    );
    for ($i = 0; $i < $image_count; $i++) {
        if (!isset($item['image_prompts'][$i]) || trim((string)$item['image_prompts'][$i]) === '') {
            $item['image_prompts'][$i] = isset($defaults[$i]) ? $defaults[$i] : $defaults[3];
        }
    }
    $item['image_prompts'] = array_slice($item['image_prompts'], 0, $image_count);
}

function gemini_parse_product_plan($text, $options = array()) {
    $text = trim($text);
    $text = preg_replace('/^```json\s*/i', '', $text);
    $text = preg_replace('/^```\s*/', '', $text);
    $text = preg_replace('/\s*```$/', '', $text);

    $data = json_decode($text, true);
    if (!is_array($data)) {
        return array('error' => 'JSON 파싱 실패');
    }

    $data = gemini_normalize_product_plan_items($data);
    $gen_price_min = isset($options['gen_price_min']) ? intval($options['gen_price_min']) : 0;
    $gen_price_max = isset($options['gen_price_max']) ? intval($options['gen_price_max']) : 0;
    if (($gen_price_min <= 0 || $gen_price_max <= 0) && function_exists('pkshop_ai_get_price_bounds_from_options')) {
        $bounds = pkshop_ai_get_price_bounds_from_options($options);
        if ($bounds !== null) {
            $gen_price_min = $bounds['min'];
            $gen_price_max = $bounds['max'];
        }
    }
    $memo = isset($options['memo']) ? trim($options['memo']) : '';
    $image_count = isset($options['image_count']) ? intval($options['image_count']) : 4;
    if ($image_count < 4) $image_count = 4;
    if ($image_count > 8) $image_count = 8;

    $products = array();
    foreach ($data as $item) {
        if (!is_array($item) || !isset($item['title']) || trim((string)$item['title']) === '') {
            continue;
        }
        gemini_ensure_product_image_prompts($item, $image_count);
        while (count($item['image_prompts']) < $image_count) {
            $item['image_prompts'][] = $item['image_prompts'][0];
        }
        $item['image_prompts'] = array_slice($item['image_prompts'], 0, $image_count);
        if ($gen_price_min > 0 && function_exists('pkshop_ai_apply_generation_price')) {
            pkshop_ai_apply_generation_price($item, $gen_price_min, $gen_price_max);
        } elseif (function_exists('pkshop_ai_normalize_price')) {
            if (isset($item['pricec'])) {
                $item['pricec'] = pkshop_ai_normalize_price($item['pricec'], $memo, $gen_price_min, $gen_price_max);
            }
            if (isset($item['prices'])) {
                $item['prices'] = pkshop_ai_normalize_price($item['prices'], $memo, $gen_price_min, $gen_price_max);
            }
            if (isset($item['priced'])) {
                $item['priced'] = pkshop_ai_normalize_price($item['priced'], $memo, $gen_price_min, $gen_price_max);
            }
        }
        $products[] = $item;
    }

    if (count($products) === 0) {
        return array('error' => '유효한 상품 데이터가 없습니다.');
    }

    return array('products' => $products);
}

function gemini_ai_cache_dir() {
    $candidates = array(
        dirname(__FILE__) . '/ai_gen_cache',
        dirname(__FILE__) . '/../../upload/.ai_gen_cache',
        sys_get_temp_dir() . '/pkshop_ai_gen_cache',
    );
    foreach ($candidates as $dir) {
        if (is_dir($dir) && is_writable($dir)) {
            return $dir;
        }
        if (@mkdir($dir, 0755, true) && is_writable($dir)) {
            return $dir;
        }
    }
    return $candidates[0];
}

function gemini_job_session_key($job_id) {
    return 'pkshop_ai_job_' . preg_replace('/[^a-zA-Z0-9_\-]/', '', $job_id);
}

function gemini_job_path($job_id, $suffix) {
    return gemini_ai_cache_dir() . '/job_' . preg_replace('/[^a-zA-Z0-9_\-]/', '', $job_id) . '_' . $suffix . '.json';
}

function gemini_save_job($job_id, $suffix, $data) {
    if (session_id() === '') {
        @session_start();
    }
    $_SESSION[gemini_job_session_key($job_id)] = $data;

    $path = gemini_job_path($job_id, $suffix);
    $json = json_encode($data, JSON_UNESCAPED_UNICODE);
    if ($json !== false) {
        @file_put_contents($path, $json);
    }
    return true;
}

function gemini_load_job($job_id, $suffix) {
    if ($job_id === '') {
        return null;
    }
    if (session_id() === '') {
        @session_start();
    }
    $session_key = gemini_job_session_key($job_id);
    if (isset($_SESSION[$session_key]) && is_array($_SESSION[$session_key])) {
        return $_SESSION[$session_key];
    }

    $path = gemini_job_path($job_id, $suffix);
    if (!file_exists($path)) {
        return null;
    }
    $data = json_decode(file_get_contents($path), true);
    if (is_array($data)) {
        $_SESSION[$session_key] = $data;
    }
    return $data;
}
