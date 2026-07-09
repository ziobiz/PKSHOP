<?php
/**
 * 쇼핑몰 노출 정책
 * true  = 비회원도 가격·상품상세 열람 가능 (2026-07-09)
 * false = 기존(회원만 가격·상세) — backup/20260709_price_login_gate 참고
 */
if (!defined('PKSHOP_PUBLIC_PRICE')) {
    define('PKSHOP_PUBLIC_PRICE', true);
}

require_once dirname(__FILE__) . '/site_settings_lib.php';

function pkshop_can_show_price() {
    if (PKSHOP_PUBLIC_PRICE) {
        return true;
    }
    return isset($_SESSION['member_id']) && $_SESSION['member_id'] !== '';
}

function pkshop_usd_jpy_cache_path() {
    return dirname(__FILE__) . '/.usd_jpy_yahoo.cache';
}

/**
 * Yahoo Finance USD/JPY 환율 (JPY=X, 1 USD당 엔)
 */
function pkshop_fetch_yahoo_usd_jpy_rate() {
    $cache = pkshop_usd_jpy_cache_path();
    if (file_exists($cache) && (time() - filemtime($cache)) < 3600) {
        $cached = trim((string)@file_get_contents($cache));
        if ($cached !== '' && floatval($cached) > 0) {
            return floatval($cached);
        }
    }

    $rate = 0.0;
    if (function_exists('curl_init')) {
        $url = 'https://query1.finance.yahoo.com/v8/finance/chart/JPY=X?interval=1d&range=1d';
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

function pkshop_get_usd_jpy_rate() {
    static $rate = null;
    if ($rate !== null) {
        return $rate;
    }
    $rate = pkshop_fetch_yahoo_usd_jpy_rate();
    if ($rate <= 0) {
        $rate = 150.0;
    }
    return $rate;
}

/** JPY 금액 끝 2자리를 00으로 올림 (100엔 단위 절상) */
function pkshop_ceil_jpy_to_hundreds($jpy) {
    $jpy = floatval($jpy);
    if ($jpy <= 0) {
        return 0;
    }
    return (int)(ceil($jpy / 100) * 100);
}

function pkshop_usd_to_jpy($usd, $rate = null) {
    $usd = floatval(preg_replace('/[^0-9.]/', '', (string)$usd));
    if ($usd <= 0) {
        return 0;
    }
    if ($rate === null) {
        $rate = pkshop_get_usd_jpy_rate();
    }
    return pkshop_ceil_jpy_to_hundreds($usd * $rate);
}

function pkshop_pick_display_usd($pricec, $prices, $priced, $country = '1') {
    $pricec = floatval($pricec);
    $prices = floatval($prices);
    $priced = floatval($priced);

    if ($country == '82') {
        if ($priced > 0) {
            return $priced;
        }
        return $pricec;
    }
    if ($priced > 0) {
        return $priced;
    }
    if ($pricec > 0) {
        return $pricec;
    }
    return $prices;
}

function pkshop_format_usd_jpy_price($usd) {
    return pkshop_format_display_price($usd);
}

function pkshop_format_checkout_price($usd) {
    return pkshop_format_payment_price($usd);
}
