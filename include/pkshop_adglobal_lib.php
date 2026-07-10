<?php
/**
 * AdGloball channel integration helpers for PKSHOP.
 */

if (!function_exists('pkshop_adglobal_ensure_schema')) {
    function pkshop_adglobal_ensure_schema($DB, $shop_goods) {
        static $done = false;
        if ($done) {
            return;
        }
        $done = true;
        if (!isset($DB) || !isset($shop_goods)) {
            return;
        }
        try {
            $DB->get("SHOW COLUMNS FROM $shop_goods LIKE 'expose_ag'", $cols, $cnt);
            if ((int)$cnt === 0 && isset($DB->dbh)) {
                $DB->dbh->exec("ALTER TABLE $shop_goods ADD COLUMN expose_ag CHAR(1) NOT NULL DEFAULT 'N'");
            }
        } catch (Exception $e) {
            // Ignore if column already exists.
        }
    }
}

if (!function_exists('pkshop_adglobal_expose_from_post')) {
    function pkshop_adglobal_expose_from_post() {
        return (isset($_POST['expose_ag']) && $_POST['expose_ag'] === 'Y') ? 'Y' : 'N';
    }
}

if (!function_exists('pkshop_adglobal_expose_checkbox_html')) {
    function pkshop_adglobal_expose_checkbox_html($expose_ag) {
        $checked = ($expose_ag === 'Y') ? ' checked' : '';
        return '<label class="pg-check-item pg-check-item--block">'
            . '<input type="checkbox" name="expose_ag" value="Y"' . $checked . '> '
            . 'AdGloball(adgloball.com) 쇼핑 페이지에 노출'
            . '</label>'
            . '<p class="pg-field-hint">체크한 상품만 WordPress 사이트 <strong>/shop/</strong> 에 표시됩니다.</p>';
    }
}

if (!function_exists('pkshop_adglobal_shop_base_url')) {
    function pkshop_adglobal_shop_base_url() {
        $settings_path = dirname(__FILE__) . '/.site_settings.json';
        if (is_file($settings_path)) {
            $json = json_decode(file_get_contents($settings_path), true);
            if (is_array($json) && !empty($json['adglobal_shop_base_url'])) {
                return rtrim($json['adglobal_shop_base_url'], '/');
            }
        }
        if (!empty($_SERVER['HTTP_HOST'])) {
            $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
            return $scheme . '://' . $_SERVER['HTTP_HOST'];
        }
        return '';
    }
}

if (!function_exists('pkshop_adglobal_image_url')) {
    function pkshop_adglobal_image_url($filename, $base_url = '') {
        $filename = trim((string)$filename);
        if ($filename === '') {
            return '';
        }
        if (preg_match('#^https?://#i', $filename)) {
            return $filename;
        }
        $base = $base_url !== '' ? rtrim($base_url, '/') : pkshop_adglobal_shop_base_url();
        return $base . '/upload/' . ltrim($filename, '/');
    }
}

if (!function_exists('pkshop_adglobal_product_row')) {
    function pkshop_adglobal_product_row($row, $base_url = '', $detail = false) {
        $price = $row['priced'];
        if ($price === '' || $price === null || (float)$price <= 0) {
            $price = $row['pricec'];
        }
        $out = array(
            'code' => $row['code'],
            'title' => $row['title'],
            'info' => isset($row['info']) ? $row['info'] : '',
            'company' => isset($row['company']) ? $row['company'] : '',
            'price' => $price,
            'price_original' => isset($row['pricec']) ? $row['pricec'] : '',
            'price_sale' => isset($row['prices']) ? $row['prices'] : '',
            'soldout' => isset($row['soldout']) ? $row['soldout'] : 'N',
            'image' => pkshop_adglobal_image_url(isset($row['imgl']) ? $row['imgl'] : '', $base_url),
            'image_detail' => pkshop_adglobal_image_url(isset($row['imgm']) ? $row['imgm'] : '', $base_url),
            'color' => isset($row['color']) ? $row['color'] : '',
            'size' => isset($row['size']) ? $row['size'] : '',
            'purchase_url' => rtrim($base_url, '/') . '/sub04/view.php?code=' . rawurlencode($row['code']) . '&from=adgloball',
        );
        if ($detail) {
            $out['detail_html'] = isset($row['detail']) ? $row['detail'] : '';
            $out['images'] = array();
            foreach (array('imgl', 'imgm', 'imgb1', 'imgb2', 'imgb3', 'imgb4', 'imgb5') as $img_key) {
                if (!empty($row[$img_key])) {
                    $out['images'][] = pkshop_adglobal_image_url($row[$img_key], $base_url);
                }
            }
            for ($i = 1; $i <= 5; $i++) {
                $out['option_t' . $i] = isset($row['option_t' . $i]) ? $row['option_t' . $i] : '';
                $out['option_n' . $i] = isset($row['option_n' . $i]) ? $row['option_n' . $i] : '';
                $out['option_p' . $i] = isset($row['option_p' . $i]) ? $row['option_p' . $i] : '';
            }
        }
        return $out;
    }
}

if (!function_exists('pkshop_adglobal_category_visible')) {
    function pkshop_adglobal_category_visible($DB, $shop_cate, $code1, $code2) {
        $DB->get("SELECT show1 FROM $shop_cate WHERE code1=:code1 AND code2='00' AND code3='00' AND code4='00' LIMIT 1", $c1, $n1, array('code1' => $code1));
        if ($n1 > 0 && isset($c1[0]['show1']) && $c1[0]['show1'] == 1) {
            return false;
        }
        if ($code2 !== '' && $code2 !== '00') {
            $DB->get("SELECT show2 FROM $shop_cate WHERE code1=:code1 AND code2=:code2 AND code3='00' AND code4='00' LIMIT 1", $c2, $n2, array('code1' => $code1, 'code2' => $code2));
            if ($n2 > 0 && isset($c2[0]['show2']) && $c2[0]['show2'] == 1) {
                return false;
            }
        }
        return true;
    }
}

if (!function_exists('pkshop_adglobal_send_cors')) {
    function pkshop_adglobal_send_cors() {
        $origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';
        $allowed = array('https://adgloball.com', 'https://www.adgloball.com', 'http://localhost:8080', 'http://127.0.0.1:8080');
        if ($origin !== '' && in_array($origin, $allowed, true)) {
            header('Access-Control-Allow-Origin: ' . $origin);
            header('Vary: Origin');
            header('Access-Control-Allow-Methods: POST, OPTIONS');
            header('Access-Control-Allow-Headers: Content-Type');
        }
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(204);
            exit;
        }
    }
}
