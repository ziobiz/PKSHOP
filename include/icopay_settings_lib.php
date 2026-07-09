<?php
/**
 * ICOPAY 결제 연동 — 관리자 환경설정 저장/조회
 */
if (!function_exists('pkshop_icopay_secrets_file_path')) {
    function pkshop_icopay_secrets_file_path() {
        return dirname(__FILE__) . '/../lib/icopay_pg_secrets.local.php';
    }
}

if (!function_exists('pkshop_icopay_mask_secret')) {
    function pkshop_icopay_mask_secret($secret) {
        $secret = trim((string)$secret);
        if ($secret === '') {
            return '';
        }
        $len = strlen($secret);
        if ($len <= 8) {
            return str_repeat('*', $len);
        }
        return substr($secret, 0, 6) . str_repeat('*', max(4, $len - 10)) . substr($secret, -4);
    }
}

if (!function_exists('pkshop_icopay_load_broker_secret')) {
    function pkshop_icopay_load_broker_secret() {
        if (defined('ICOPAY_BROKER_SECRET') && ICOPAY_BROKER_SECRET !== '') {
            return ICOPAY_BROKER_SECRET;
        }
        $path = pkshop_icopay_secrets_file_path();
        if (!is_file($path)) {
            return '';
        }
        include_once $path;
        return (defined('ICOPAY_BROKER_SECRET') && ICOPAY_BROKER_SECRET !== '') ? ICOPAY_BROKER_SECRET : '';
    }
}

if (!function_exists('pkshop_icopay_broker_secret_status')) {
    function pkshop_icopay_broker_secret_status() {
        $secret = pkshop_icopay_load_broker_secret();
        if ($secret === '') {
            return array('configured' => false, 'masked' => '', 'message' => '미설정');
        }
        return array(
            'configured' => true,
            'masked' => pkshop_icopay_mask_secret($secret),
            'message' => '설정됨',
        );
    }
}

if (!function_exists('pkshop_icopay_webhook_url')) {
    function pkshop_icopay_webhook_url() {
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'pentakleva.shop';
        return $scheme . '://' . $host . '/cart/icopay_webhook.php';
    }
}

if (!function_exists('pkshop_icopay_integration_mode_options')) {
    function pkshop_icopay_integration_mode_options() {
        return array(
            'unified' => 'ICOPAY 통합 인라인 (권장)',
            'chillpay' => 'ChillPay CCD (레거시)',
        );
    }
}

if (!function_exists('pkshop_icopay_checkout_lang_options')) {
    function pkshop_icopay_checkout_lang_options() {
        return array(
            'ENG' => 'English (ENG)',
            'JPN' => 'Japanese (JPN)',
            'KOR' => 'Korean (KOR)',
            'CHN' => 'Chinese (CHN)',
            'THA' => 'Thai (THA)',
        );
    }
}

if (!function_exists('pkshop_icopay_write_secrets_file')) {
    function pkshop_icopay_write_secrets_file($settings, $broker_secret = null) {
        $path = pkshop_icopay_secrets_file_path();
        $dir = dirname($path);
        if (!is_dir($dir)) {
            return array('ok' => false, 'error' => 'lib 폴더를 찾을 수 없습니다.');
        }
        if (file_exists($path) && !is_writable($path)) {
            return array('ok' => false, 'error' => 'lib/icopay_pg_secrets.local.php 에 쓸 수 없습니다. 권한을 확인하세요.');
        }
        if (!file_exists($path) && !is_writable($dir)) {
            return array('ok' => false, 'error' => 'lib 폴더에 쓸 수 없습니다. 서버 폴더 권한을 확인하세요.');
        }

        if ($broker_secret === null || $broker_secret === '') {
            $broker_secret = pkshop_icopay_load_broker_secret();
        } else {
            $broker_secret = trim((string)$broker_secret);
        }

        $comp_id = isset($settings['icopay_comp_id']) ? trim((string)$settings['icopay_comp_id']) : '';
        $mode = isset($settings['icopay_integration_mode']) ? trim((string)$settings['icopay_integration_mode']) : 'unified';
        $currency = isset($settings['icopay_payment_currency']) ? strtoupper(trim((string)$settings['icopay_payment_currency'])) : 'JPY';
        $lang = isset($settings['icopay_checkout_lang']) ? trim((string)$settings['icopay_checkout_lang']) : 'JPN';
        $ccd_lang = isset($settings['icopay_ccd_lang']) ? trim((string)$settings['icopay_ccd_lang']) : 'en';
        $ccd_mid = isset($settings['icopay_ccd_merchant_code']) ? trim((string)$settings['icopay_ccd_merchant_code']) : '';
        $ccd_key = isset($settings['icopay_ccd_api_key']) ? trim((string)$settings['icopay_ccd_api_key']) : '';

        if (!in_array($mode, array('unified', 'chillpay'), true)) {
            $mode = 'unified';
        }

        $lines = array();
        $lines[] = '<?php';
        $lines[] = '/**';
        $lines[] = ' * ICOPAY 결제 연동 — 관리자 환경설정에서 저장됨';
        $lines[] = ' * Git에 올리지 마세요.';
        $lines[] = ' */';
        if ($comp_id !== '') {
            $lines[] = "define('ICOPAY_COMP_ID', '" . addslashes($comp_id) . "');";
        }
        if ($broker_secret !== '') {
            $lines[] = "define('ICOPAY_BROKER_SECRET', '" . addslashes($broker_secret) . "');";
        }
        $lines[] = "define('ICOPAY_INTEGRATION_MODE', '" . addslashes($mode) . "');";
        $lines[] = "define('ICOPAY_PAYMENT_CURRENCY', '" . addslashes($currency) . "');";
        $lines[] = "define('ICOPAY_CHECKOUT_LANG', '" . addslashes($lang) . "');";
        if ($ccd_lang !== '') {
            $lines[] = "define('ICOPAY_CCD_LANG', '" . addslashes($ccd_lang) . "');";
        }
        if ($ccd_mid !== '') {
            $lines[] = "define('ICOPAY_CCD_MERCHANT_CODE', '" . addslashes($ccd_mid) . "');";
        }
        if ($ccd_key !== '') {
            $lines[] = "define('ICOPAY_CCD_API_KEY', '" . addslashes($ccd_key) . "');";
        }
        $lines[] = '';

        $written = @file_put_contents($path, implode("\n", $lines), LOCK_EX);
        if ($written === false) {
            return array('ok' => false, 'error' => '시크릿 파일 저장에 실패했습니다.');
        }
        return array('ok' => true);
    }
}

if (!function_exists('pkshop_icopay_is_enabled')) {
    function pkshop_icopay_is_enabled() {
        if (!function_exists('pkshop_site_setting')) {
            require_once dirname(__FILE__) . '/site_settings_lib.php';
        }
        return pkshop_site_setting('payment_pg_enabled', '1') !== '0'
            && strtoupper(pkshop_site_setting('payment_pg_provider', 'ICOPAY')) === 'ICOPAY';
    }
}

if (!function_exists('pkshop_icopay_admin_form_values')) {
    function pkshop_icopay_admin_form_values() {
        if (!function_exists('pkshop_site_settings')) {
            require_once dirname(__FILE__) . '/site_settings_lib.php';
        }
        $values = pkshop_site_settings();
        $path = pkshop_icopay_secrets_file_path();
        if (!is_file($path)) {
            return $values;
        }
        include_once $path;
        if ($values['icopay_comp_id'] === '' && defined('ICOPAY_COMP_ID') && ICOPAY_COMP_ID !== '') {
            $values['icopay_comp_id'] = ICOPAY_COMP_ID;
        }
        if ($values['icopay_integration_mode'] === '' && defined('ICOPAY_INTEGRATION_MODE') && ICOPAY_INTEGRATION_MODE !== '') {
            $values['icopay_integration_mode'] = ICOPAY_INTEGRATION_MODE;
        }
        if ($values['icopay_payment_currency'] === '' && defined('ICOPAY_PAYMENT_CURRENCY') && ICOPAY_PAYMENT_CURRENCY !== '') {
            $values['icopay_payment_currency'] = ICOPAY_PAYMENT_CURRENCY;
        }
        if ($values['icopay_checkout_lang'] === '' && defined('ICOPAY_CHECKOUT_LANG') && ICOPAY_CHECKOUT_LANG !== '') {
            $values['icopay_checkout_lang'] = ICOPAY_CHECKOUT_LANG;
        }
        if ($values['icopay_ccd_lang'] === '' && defined('ICOPAY_CCD_LANG') && ICOPAY_CCD_LANG !== '') {
            $values['icopay_ccd_lang'] = ICOPAY_CCD_LANG;
        }
        if ($values['icopay_ccd_merchant_code'] === '' && defined('ICOPAY_CCD_MERCHANT_CODE') && ICOPAY_CCD_MERCHANT_CODE !== '') {
            $values['icopay_ccd_merchant_code'] = ICOPAY_CCD_MERCHANT_CODE;
        }
        if ($values['icopay_ccd_api_key'] === '' && defined('ICOPAY_CCD_API_KEY') && ICOPAY_CCD_API_KEY !== '') {
            $values['icopay_ccd_api_key'] = ICOPAY_CCD_API_KEY;
        }
        return $values;
    }
}
