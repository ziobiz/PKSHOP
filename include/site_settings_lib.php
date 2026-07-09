<?php
/**
 * 사이트 환경설정 (브랜드 / 통화 / AI는 gemini_client 사용)
 */
if (!function_exists('pkshop_site_settings_path')) {
    function pkshop_site_settings_path() {
        return dirname(__FILE__) . '/.site_settings.json';
    }
}

if (!function_exists('pkshop_site_settings_defaults')) {
    function pkshop_site_settings_defaults() {
        return array(
            'site_title' => 'Pentakleva Concept Shopping mall',
            'browser_title' => 'Pentakleva',
            'og_title' => 'Pentakleva',
            'og_description' => 'Pentakleva',
            'og_image' => '../images/kakao.jpg?=1',
            'favicon' => 'images/pentakleva.ico',
            'logo_pc' => '../images/logo2.png',
            'logo_pc_width' => '200',
            'logo_pc_height' => '60',
            'logo_mobile' => '../images/logo2.png',
            'logo_mobile_width' => '120',
            'logo_mobile_height' => '40',
            'banner1' => '../images/banner01.jpg',
            'banner2' => '../images/banner02.jpg',
            'banner3' => '../images/banner03.jpg',
            'banner_width' => '1920',
            'banner_height' => '600',
            'main_welcome_best' => 'Welcome to Pentakleva Concept MALL.',
            'main_welcome_recommended' => "This month's recommended product.",
            'main_welcome_all' => 'Welcome to Pentakleva MALL.',
            'main_all_code1' => '',
            'main_all_code2' => '',
            'main_all_code3' => '',
            'main_all_code4' => '',
            'main_all_sel_cate' => '',
            'main_all_categories' => '',
            'promo_rotate_best' => '30',
            'promo_rotate_recommended' => '30',
            'promo_rotate_all' => '30',
            'footer_cs_title' => '顧客センター',
            'footer_cs_line1' => 'OPEN: 09:00 ~ 18:00 / 土日祝休業',
            'footer_cs_line2' => 'ip@onthelinem.com',
            'footer_bank_title' => '銀行口座情報',
            'footer_bank_line1' => 'SUMITOMO MITSUI BANKING (SMBC) IN JAPAN / 7282155 (Branch Number: 888)',
            'footer_bank_line2' => 'Holder: Ontheline Japan Co., Ltd.',
            'footer_history_title' => '購入履歴情報',
            'footer_delivery_title' => '配送情報',
            'footer_delivery_line1' => '会社住所: 9th Floor, Nippon Building Annex, 1-2-18 Nihonbashi Kayabacho, Chuo-ku, Tokyo',
            'footer_link_home' => '家',
            'footer_link_terms' => '利用規約 / 返金ポリシー',
            'footer_link_policy' => 'ポリシーについて',
            'footer_about_title' => 'About company',
            'footer_company_label' => '会社名',
            'footer_company_name' => 'Ontheline Japan Co., Ltd.',
            'footer_ceo_label' => '代表取締役',
            'footer_ceo' => 'TAKEDA HIROSHI',
            'footer_address_label' => '会社住所',
            'footer_address' => '9th Floor, Nippon Building Annex, 1-2-18 Nihonbashi Kayabacho, Chuo-ku, Tokyo',
            'footer_tel_label' => 'Tel',
            'footer_tel' => '+81(0)366670722',
            'footer_fax_label' => 'Fax',
            'footer_fax' => '+81(0)366670720',
            'footer_biz_label' => 'Business registration number.',
            'footer_biz_no' => '0111-01-090261',
            'footer_mail_order_label' => 'The mail order business.',
            'footer_mail_order' => '',
            'footer_copyright' => 'Copyright (C) Ontheline Japan Co., Ltd. All Rights Reserved.',
            'footer_icon_myinfo' => '../images/b-icon01.png',
            'footer_icon_cart' => '../images/b-icon02.png',
            'footer_bottom_image' => '',
            'footer_bottom_image_width' => '1200',
            'footer_bottom_image_height' => '0',
            'footer_story_banner1' => '../images/bottom01.jpg',
            'footer_story_banner2' => '../images/1016623029.jpg',
            'footer_story_banner_width' => '1200',
            'footer_story_banner_height' => '420',
            'agree_company_name' => 'Ontheline Japan Co., Ltd.',
            'agree_company_address' => '9th Floor, Nippon Building Annex, 1-2-18 Nihonbashi Kayabacho, Chuo-ku, Tokyo',
            'payment_bank_line1' => 'SUMITOMO MITSUI BANKING (SMBC) IN JAPAN / 7282155 (Branch Number: 888)',
            'payment_bank_line2' => 'Holder: Ontheline Japan Co., Ltd.',
            'payment_bank_line3' => '',
            'currency_primary_code' => 'USD',
            'currency_primary_enabled' => '1',
            'currency_secondary_code' => 'JPY',
            'currency_secondary_enabled' => '1',
            'currency_payment_code' => 'USD',
            'payment_pg_provider' => 'ICOPAY',
            'payment_pg_enabled' => '1',
            'icopay_merchant_name' => '',
            'icopay_comp_id' => '',
            'icopay_api_base_url' => 'https://api.icopay.co.kr',
            'icopay_integration_mode' => 'unified',
            'icopay_payment_currency' => 'JPY',
            'icopay_checkout_lang' => 'JPN',
            'icopay_jpay_mid' => '',
            'icopay_ccd_merchant_code' => '',
            'icopay_ccd_api_key' => '',
            'icopay_ccd_lang' => 'en',
        );
    }
}

if (!function_exists('pkshop_site_image_style_attr')) {
    function pkshop_site_image_style_attr($width, $height = 0, $default_width = 1200, $default_height = 0) {
        $width = intval($width);
        $height = intval($height);
        if ($width <= 0) {
            $width = intval($default_width);
        }
        $style = 'width:' . $width . 'px;max-width:100%;display:block;margin:0 auto;';
        if ($height > 0) {
            $style .= 'height:' . $height . 'px;object-fit:cover;';
        } else {
            $style .= 'height:auto;';
        }
        return ' style="' . $style . '"';
    }
}

if (!function_exists('pkshop_currency_options')) {
    function pkshop_currency_options() {
        return array(
            'USD' => array('label' => 'USD (미국 달러)', 'symbol' => 'USD', 'decimals' => 0),
            'JPY' => array('label' => 'JPY (일본 엔)', 'symbol' => 'JPY', 'decimals' => 0, 'ceil_unit' => 100),
            'KRW' => array('label' => 'KRW (한국 원)', 'symbol' => 'KRW', 'decimals' => 0, 'ceil_unit' => 100),
            'EUR' => array('label' => 'EUR (유로)', 'symbol' => 'EUR', 'decimals' => 0),
            'THB' => array('label' => 'THB (태국 바트)', 'symbol' => 'THB', 'decimals' => 0),
            'CNY' => array('label' => 'CNY (중국 위안)', 'symbol' => 'CNY', 'decimals' => 0),
        );
    }
}

if (!function_exists('pkshop_site_settings')) {
    function pkshop_site_settings($refresh = false) {
        static $cache = null;
        if ($cache !== null && !$refresh) {
            return $cache;
        }
        $settings = pkshop_site_settings_defaults();
        $path = pkshop_site_settings_path();
        if (file_exists($path)) {
            $raw = @file_get_contents($path);
            $json = json_decode($raw, true);
            if (is_array($json)) {
                $settings = array_merge($settings, $json);
            }
        }
        $cache = $settings;
        return $settings;
    }
}

if (!function_exists('pkshop_site_setting')) {
    function pkshop_site_setting($key, $default = '') {
        $settings = pkshop_site_settings();
        return isset($settings[$key]) ? $settings[$key] : $default;
    }
}

if (!function_exists('pkshop_site_asset_url')) {
    function pkshop_site_asset_url($path) {
        $path = trim((string)$path);
        if ($path === '') {
            return '';
        }
        if (preg_match('#^(https?:)?//#i', $path) || strpos($path, '/') === 0) {
            return $path;
        }
        $path = preg_replace('#^(\.\./)+#', '', $path);
        return '/' . ltrim(str_replace('\\', '/', $path), '/');
    }
}

if (!function_exists('pkshop_main_all_entry_from_codes')) {
    function pkshop_main_all_entry_from_codes($sel_cate, $code1, $code2, $code3, $code4) {
        $code1 = trim((string)$code1);
        $code2 = trim((string)$code2);
        $code3 = trim((string)$code3);
        $code4 = trim((string)$code4);
        $sel_cate = trim((string)$sel_cate);

        if ($code1 === '') {
            return array('sel_cate' => '', 'code1' => '', 'code2' => '', 'code3' => '', 'code4' => '');
        }
        if ($code2 === '' || $code2 === '00') {
            return array('sel_cate' => '1', 'code1' => $code1, 'code2' => '', 'code3' => '', 'code4' => '');
        }
        if ($code3 === '' || $code3 === '00') {
            return array('sel_cate' => '2', 'code1' => $code1, 'code2' => $code2, 'code3' => '', 'code4' => '');
        }
        if ($code4 === '' || $code4 === '00') {
            return array('sel_cate' => '3', 'code1' => $code1, 'code2' => $code2, 'code3' => $code3, 'code4' => '');
        }
        return array('sel_cate' => '4', 'code1' => $code1, 'code2' => $code2, 'code3' => $code3, 'code4' => $code4);
    }
}

if (!function_exists('pkshop_main_all_entry_from_post')) {
    function pkshop_main_all_entry_from_post($item) {
        if (!is_array($item)) {
            return array('sel_cate' => '', 'code1' => '', 'code2' => '', 'code3' => '', 'code4' => '');
        }
        return pkshop_main_all_entry_from_codes(
            isset($item['sel_cate']) ? $item['sel_cate'] : '',
            isset($item['code1']) ? $item['code1'] : '',
            isset($item['code2']) ? $item['code2'] : '',
            isset($item['code3']) ? $item['code3'] : '',
            isset($item['code4']) ? $item['code4'] : ''
        );
    }
}

if (!function_exists('pkshop_main_all_normalize')) {
    function pkshop_main_all_normalize($sel_cate, $code1, $code2, $code3, $code4) {
        $entry = pkshop_main_all_entry_from_codes($sel_cate, $code1, $code2, $code3, $code4);
        if ($entry['code1'] === '') {
            return array(
                'main_all_sel_cate' => '',
                'main_all_code1' => '',
                'main_all_code2' => '',
                'main_all_code3' => '',
                'main_all_code4' => '',
            );
        }
        return array(
            'main_all_sel_cate' => $entry['sel_cate'],
            'main_all_code1' => $entry['code1'],
            'main_all_code2' => $entry['code2'],
            'main_all_code3' => $entry['code3'],
            'main_all_code4' => $entry['code4'],
        );
    }
}

if (!function_exists('pkshop_main_all_categories_list')) {
    function pkshop_main_all_categories_list() {
        $raw = pkshop_site_setting('main_all_categories', '');
        if ($raw !== '') {
            $decoded = json_decode($raw, true);
            if (is_array($decoded)) {
                $list = array();
                foreach ($decoded as $item) {
                    $entry = pkshop_main_all_entry_from_post($item);
                    if ($entry['code1'] !== '') {
                        $list[] = $entry;
                    }
                }
                if (!empty($list)) {
                    return $list;
                }
            }
        }
        $legacy = pkshop_main_all_normalize(
            pkshop_site_setting('main_all_sel_cate'),
            pkshop_site_setting('main_all_code1'),
            pkshop_site_setting('main_all_code2'),
            pkshop_site_setting('main_all_code3'),
            pkshop_site_setting('main_all_code4')
        );
        if ($legacy['main_all_code1'] !== '') {
            return array(pkshop_main_all_entry_from_codes(
                $legacy['main_all_sel_cate'],
                $legacy['main_all_code1'],
                $legacy['main_all_code2'],
                $legacy['main_all_code3'],
                $legacy['main_all_code4']
            ));
        }
        return array();
    }
}

if (!function_exists('pkshop_main_all_entry_key')) {
    function pkshop_main_all_entry_key($entry) {
        return $entry['code1'] . '|' . $entry['code2'] . '|' . $entry['code3'] . '|' . $entry['code4'];
    }
}

if (!function_exists('pkshop_main_all_save_categories_list')) {
    function pkshop_main_all_save_categories_list($categories) {
        $clean = array();
        $seen = array();
        if (is_array($categories)) {
            foreach ($categories as $item) {
                $entry = pkshop_main_all_entry_from_post($item);
                if ($entry['code1'] === '') {
                    continue;
                }
                $key = pkshop_main_all_entry_key($entry);
                if (isset($seen[$key])) {
                    continue;
                }
                $seen[$key] = true;
                $clean[] = $entry;
            }
        }
        $data = array('main_all_categories' => json_encode($clean, JSON_UNESCAPED_UNICODE));
        if (!empty($clean)) {
            $first = $clean[0];
            $data = array_merge($data, pkshop_main_all_normalize(
                $first['sel_cate'],
                $first['code1'],
                $first['code2'],
                $first['code3'],
                $first['code4']
            ));
        } else {
            $data = array_merge($data, pkshop_main_all_normalize('', '', '', '', ''));
        }
        return pkshop_site_settings_save($data);
    }
}

if (!function_exists('pkshop_main_all_category_codes')) {
    function pkshop_main_all_category_codes() {
        $list = pkshop_main_all_categories_list();
        if (!empty($list)) {
            return pkshop_main_all_normalize(
                $list[0]['sel_cate'],
                $list[0]['code1'],
                $list[0]['code2'],
                $list[0]['code3'],
                $list[0]['code4']
            );
        }
        return pkshop_main_all_normalize('', '', '', '', '');
    }
}

if (!function_exists('pkshop_main_all_api_post_data_for_entry')) {
    function pkshop_main_all_api_post_data_for_entry($entry, $de_id = 'e7bb77ca2517821473681d3e9fe132e54c21bdff0ef170596f0414032aac3dbc', $limit = 0) {
        $entry = pkshop_main_all_entry_from_post($entry);
        $data = 'deId=' . rawurlencode($de_id) . '&Type=all3';
        if ($entry['code1'] !== '') {
            $data .= '&code1=' . rawurlencode($entry['code1']);
        }
        if ($entry['code2'] !== '') {
            $data .= '&code2=' . rawurlencode($entry['code2']);
        }
        if ($entry['code3'] !== '') {
            $data .= '&code3=' . rawurlencode($entry['code3']);
        }
        if ($entry['code4'] !== '') {
            $data .= '&code4=' . rawurlencode($entry['code4']);
        }
        if ((int)$limit > 0) {
            $data .= '&limit=' . (int)$limit;
        }
        return $data;
    }
}

if (!function_exists('pkshop_main_all_api_post_data')) {
    function pkshop_main_all_api_post_data($de_id = 'e7bb77ca2517821473681d3e9fe132e54c21bdff0ef170596f0414032aac3dbc') {
        $list = pkshop_main_all_categories_list();
        if (count($list) === 1) {
            return pkshop_main_all_api_post_data_for_entry($list[0], $de_id, 0);
        }
        if (count($list) > 1) {
            return pkshop_main_all_api_post_data_for_entry($list[0], $de_id, 4);
        }
        return 'deId=' . rawurlencode($de_id) . '&Type=all3';
    }
}

if (!function_exists('pkshop_main_all_fetch_api_rows')) {
    function pkshop_main_all_fetch_api_rows($api_history, $post_data) {
        if ($api_history === '' || $post_data === '') {
            return array();
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_history);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        $rows = json_decode($result, true);
        return is_array($rows) ? $rows : array();
    }
}

if (!function_exists('pkshop_main_all_row_has_image')) {
    function pkshop_main_all_row_has_image($row) {
        if (!is_array($row)) {
            return false;
        }
        if (function_exists('pkshop_main_product_has_image')) {
            return pkshop_main_product_has_image($row);
        }
        return !empty($row['imgl']) || !empty($row['imgb1']);
    }
}

if (!function_exists('pkshop_main_all_get_display_products')) {
    function pkshop_main_all_get_display_products($api_history, $per_category = 4) {
        $per_category = max(1, (int)$per_category);
        $categories = pkshop_main_all_categories_list();
        $display = array();

        if (empty($categories)) {
            $rows = pkshop_main_all_fetch_api_rows($api_history, pkshop_main_all_api_post_data());
            foreach ($rows as $row) {
                if (pkshop_main_all_row_has_image($row)) {
                    $display[] = $row;
                }
            }
            return $display;
        }

        foreach ($categories as $entry) {
            $post = pkshop_main_all_api_post_data_for_entry($entry, 'e7bb77ca2517821473681d3e9fe132e54c21bdff0ef170596f0414032aac3dbc', $per_category + 4);
            $rows = pkshop_main_all_fetch_api_rows($api_history, $post);
            $added = 0;
            foreach ($rows as $row) {
                if (!pkshop_main_all_row_has_image($row)) {
                    continue;
                }
                $display[] = $row;
                $added++;
                if ($added >= $per_category) {
                    break;
                }
            }
        }
        return $display;
    }
}

if (!function_exists('pkshop_site_settings_save')) {
    function pkshop_site_settings_save($data) {
        $settings = pkshop_site_settings(true);
        if (!is_array($data)) {
            return false;
        }
        foreach ($data as $k => $v) {
            if (array_key_exists($k, pkshop_site_settings_defaults())) {
                $settings[$k] = $v;
            }
        }
        $path = pkshop_site_settings_path();
        $json = json_encode($settings, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        if ($json === false) {
            return false;
        }
        $ok = @file_put_contents($path, $json, LOCK_EX);
        if ($ok !== false) {
            pkshop_site_settings(true);
        }
        return $ok !== false;
    }
}

if (!function_exists('pkshop_fx_cache_path')) {
    function pkshop_fx_cache_path($pair) {
        $safe = preg_replace('/[^A-Z0-9=]/', '', strtoupper($pair));
        return dirname(__FILE__) . '/.fx_' . $safe . '.cache';
    }
}

if (!function_exists('pkshop_fetch_yahoo_fx_rate')) {
    function pkshop_fetch_yahoo_fx_rate($yahoo_symbol) {
        $cache = pkshop_fx_cache_path($yahoo_symbol);
        if (file_exists($cache) && (time() - filemtime($cache)) < 3600) {
            $cached = trim((string)@file_get_contents($cache));
            if ($cached !== '' && floatval($cached) > 0) {
                return floatval($cached);
            }
        }
        $rate = 0.0;
        if (function_exists('curl_init')) {
            $url = 'https://query1.finance.yahoo.com/v8/finance/chart/' . rawurlencode($yahoo_symbol) . '?interval=1d&range=1d';
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; PKSHOP/1.0)');
            $response = curl_exec($ch);
            curl_close($ch);
            if ($response !== false) {
                $data = json_decode($response, true);
                if (isset($data['chart']['result'][0]['meta']['regularMarketPrice'])) {
                    $rate = floatval($data['chart']['result'][0]['meta']['regularMarketPrice']);
                }
            }
        }
        if ($rate > 0) {
            @file_put_contents($cache, (string)$rate, LOCK_EX);
            return $rate;
        }
        if (file_exists($cache)) {
            $cached = trim((string)@file_get_contents($cache));
            if ($cached !== '' && floatval($cached) > 0) {
                return floatval($cached);
            }
        }
        return 0.0;
    }
}

if (!function_exists('pkshop_get_fx_rate')) {
    function pkshop_get_fx_rate($from, $to) {
        static $memo = array();
        $from = strtoupper(trim($from));
        $to = strtoupper(trim($to));
        if ($from === $to) {
            return 1.0;
        }
        $key = $from . '_' . $to;
        if (isset($memo[$key])) {
            return $memo[$key];
        }
        $fallback = array(
            'USD_JPY' => 150.0,
            'USD_KRW' => 1350.0,
            'USD_EUR' => 0.92,
            'USD_THB' => 35.0,
            'USD_CNY' => 7.2,
        );
        $rate = 0.0;
        if ($from === 'USD') {
            $rate = pkshop_fetch_yahoo_fx_rate($to . '=X');
        } elseif ($to === 'USD') {
            $r = pkshop_fetch_yahoo_fx_rate($from . '=X');
            $rate = ($r > 0) ? (1.0 / $r) : 0.0;
        } else {
            $via_usd = pkshop_get_fx_rate($from, 'USD');
            $usd_to = pkshop_get_fx_rate('USD', $to);
            $rate = $via_usd * $usd_to;
        }
        if ($rate <= 0 && isset($fallback[$key])) {
            $rate = $fallback[$key];
        }
        $memo[$key] = $rate > 0 ? $rate : 1.0;
        return $memo[$key];
    }
}

if (!function_exists('pkshop_currency_enabled_codes')) {
    function pkshop_currency_enabled_codes() {
        $s = pkshop_site_settings();
        $codes = array();
        if (!empty($s['currency_primary_enabled']) && $s['currency_primary_enabled'] !== '0') {
            $codes[] = strtoupper($s['currency_primary_code']);
        }
        if (!empty($s['currency_secondary_enabled']) && $s['currency_secondary_enabled'] !== '0') {
            $sec = strtoupper($s['currency_secondary_code']);
            if (!in_array($sec, $codes, true)) {
                $codes[] = $sec;
            }
        }
        if (empty($codes)) {
            $codes[] = 'USD';
        }
        return $codes;
    }
}

if (!function_exists('pkshop_get_payment_currency')) {
    function pkshop_get_payment_currency() {
        $s = pkshop_site_settings();
        $pay = strtoupper($s['currency_payment_code']);
        $enabled = pkshop_currency_enabled_codes();
        if (in_array($pay, $enabled, true)) {
            return $pay;
        }
        return $enabled[0];
    }
}

if (!function_exists('pkshop_convert_usd_amount')) {
    function pkshop_convert_usd_amount($usd, $to_currency) {
        $usd = floatval(preg_replace('/[^0-9.]/', '', (string)$usd));
        if ($usd <= 0) {
            return 0;
        }
        $to_currency = strtoupper($to_currency);
        $opts = pkshop_currency_options();
        $amount = $usd * pkshop_get_fx_rate('USD', $to_currency);
        if (isset($opts[$to_currency]['ceil_unit'])) {
            $unit = intval($opts[$to_currency]['ceil_unit']);
            if ($unit > 0) {
                $amount = ceil($amount / $unit) * $unit;
            }
        } else {
            $amount = round($amount);
        }
        return (int)$amount;
    }
}

if (!function_exists('pkshop_format_currency_amount')) {
    function pkshop_format_currency_amount($amount, $currency_code) {
        $currency_code = strtoupper($currency_code);
        $opts = pkshop_currency_options();
        $symbol = isset($opts[$currency_code]['symbol']) ? $opts[$currency_code]['symbol'] : $currency_code;
        return $symbol . ' ' . number_format((int)$amount);
    }
}

if (!function_exists('pkshop_format_display_price')) {
    function pkshop_format_display_price($usd) {
        $parts = array();
        foreach (pkshop_currency_enabled_codes() as $code) {
            $amt = pkshop_convert_usd_amount($usd, $code);
            $parts[] = pkshop_format_currency_amount($amt, $code);
        }
        return implode(' / ', $parts);
    }
}

if (!function_exists('pkshop_format_payment_price')) {
    /** 결제 페이지용 — 결제 기준 통화를 먼저, 그 외 노출 통화도 함께 표시 */
    function pkshop_format_payment_price($usd) {
        $usd = floatval(preg_replace('/[^0-9.]/', '', (string)$usd));
        $pay = pkshop_get_payment_currency();
        $enabled = pkshop_currency_enabled_codes();
        $parts = array();
        $ordered = array($pay);
        foreach ($enabled as $code) {
            if (!in_array($code, $ordered, true)) {
                $ordered[] = $code;
            }
        }
        foreach ($ordered as $code) {
            $amt = pkshop_convert_usd_amount($usd, $code);
            $parts[] = pkshop_format_currency_amount($amt, $code);
        }
        return implode(' / ', $parts);
    }
}

if (!function_exists('pkshop_currency_js_config')) {
    function pkshop_currency_js_config() {
        $opts = pkshop_currency_options();
        $enabled = pkshop_currency_enabled_codes();
        $payment = pkshop_get_payment_currency();
        $rates = array();
        $ceil_units = array();
        $symbols = array();
        foreach ($enabled as $code) {
            $rates[$code] = pkshop_get_fx_rate('USD', $code);
            $symbols[$code] = isset($opts[$code]['symbol']) ? $opts[$code]['symbol'] : $code;
            if (isset($opts[$code]['ceil_unit'])) {
                $ceil_units[$code] = intval($opts[$code]['ceil_unit']);
            }
        }
        $ordered = array($payment);
        foreach ($enabled as $code) {
            if (!in_array($code, $ordered, true)) {
                $ordered[] = $code;
            }
        }
        return array(
            'enabled' => $enabled,
            'payment' => $payment,
            'display_order' => $ordered,
            'rates' => $rates,
            'ceil_units' => $ceil_units,
            'symbols' => $symbols,
        );
    }
}

if (!function_exists('pkshop_payment_amount_from_usd')) {
    function pkshop_payment_amount_from_usd($usd) {
        $pay_cur = pkshop_get_payment_currency();
        return pkshop_convert_usd_amount($usd, $pay_cur);
    }
}

if (!function_exists('pkshop_brand_replace_text')) {
    function pkshop_brand_replace_text($text) {
        $name = pkshop_site_setting('agree_company_name');
        $addr = pkshop_site_setting('agree_company_address');
        $replacements = array(
            'Naphi Exchange Co., Ltd.' => $name,
            'Ontheline Japan Co., Ltd.' => $name,
            'Ontheline Co., Ltd.' => $name,
            '52 Adamas, Ramintra Rd (Soi 31), Anusawaree, Bangkhen Bangkok, Thailand 10220' => $addr,
            '9th Floor, Nippon Building Annex, 1-2-18 Nihonbashi Kayabacho, Chuo-ku, Tokyo' => $addr,
        );
        return str_replace(array_keys($replacements), array_values($replacements), $text);
    }
}
