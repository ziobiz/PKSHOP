<?php
/**
 * USD 기준가 → JPY 표시·결제 환산 (10엔 단위 올림).
 * 환율: get_balance 의 c_usdprice 우선, 없으면 SHOP_USD_JPY_RATE.
 */

function shop_usd_jpy_rate(array $json_balance = array()): float
{
	if (!empty($json_balance['c_usdprice']) && is_numeric($json_balance['c_usdprice'])) {
		$rate = (float)$json_balance['c_usdprice'];
		if ($rate > 0) {
			return $rate;
		}
	}
	if (defined('SHOP_USD_JPY_RATE') && (float)SHOP_USD_JPY_RATE > 0) {
		return (float)SHOP_USD_JPY_RATE;
	}
	return 162.0;
}

/** USD → JPY (환경설정 통화 반올림 규칙 적용, 기본 10엔 절사). */
function shop_usd_to_jpy_ceiling($usd, $rate = null): int
{
	if (function_exists('pkshop_convert_usd_amount')) {
		return (int)pkshop_convert_usd_amount($usd, 'JPY');
	}
	$usd = (float)str_replace(',', '', (string)$usd);
	if ($usd <= 0) {
		return 0;
	}
	if ($rate === null || (float)$rate <= 0) {
		global $json_balance;
		$rate = shop_usd_jpy_rate(is_array($json_balance ?? null) ? $json_balance : array());
	}
	$jpy = $usd * (float)$rate;
	// 레거시 폴백: 10엔 절사
	return (int)(floor($jpy / 10) * 10);
}

function shop_format_usd($usd): string
{
	return 'USD ' . number_format((float)str_replace(',', '', (string)$usd));
}

function shop_format_jpy($jpy): string
{
	return 'JPY ' . number_format((int)$jpy);
}

/** USD 500 / JPY 81,000 */
function shop_format_usd_jpy_dual($usd, $rate = null): string
{
	if ($rate === null || (float)$rate <= 0) {
		global $json_balance;
		$rate = shop_usd_jpy_rate(is_array($json_balance ?? null) ? $json_balance : array());
	}
	$jpy = shop_usd_to_jpy_ceiling($usd, $rate);
	return shop_format_usd($usd) . ' / ' . shop_format_jpy($jpy);
}

/** USD 500 / JPY 81,000 — HTML 이스케이프된 문자열 */
function shop_format_usd_jpy_dual_esc($usd, $rate = null): string
{
	return htmlspecialchars(shop_format_usd_jpy_dual($usd, $rate), ENT_QUOTES, 'UTF-8');
}
