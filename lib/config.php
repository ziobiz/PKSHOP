<?

define("DB_HOST","localhost");
define("DB_USER","linemdjp");
define("DB_PASS","jpline2020<>");
define("DB_NAME","linemdjp");
// 아이피 차단

// 

$DB_HOST="localhost";
$DB_USER="linemdjp";
$DB_PWD="jpline2020<>";
$DB_NAME="linemdjp";

$member_table="cust_member";		//회원테이블2
$shop_cate="shop_cate";		//상품분류테이블 
$shop_goods="shop_goods";		//상품정보테이블
$shop_order="shop_order";		//주문정보
$shop_sell="shop_sell";		//매출정보테이블
$member="member";				//회원테이블
$member_log="member_log";				//접속
$state="state";				//접속통계테이블
$admin_member="admin";		//관리자테이블
$shop_point="point";		//관리자테이블
$shop_cart="cart";		//장바구니 저장공간
$shop_save="save";		//찜하기
$attendance="attendance";
$member_p="member_p";				//이벤트데이타
$coin_goods="coin_goods";
$shop_key		= "459sdfwodlfjsx342255";

$store_key = "e7bb77ca2517821473681d3e9fe132e54c21bdff0ef170596f0414032aac3dbc";

$eth_key	= "_eth";
date_default_timezone_set("Asia/Seoul");
$master_wallet = "rf5TW9fXJjDDqxeZHFDYtMccVHsa5dchwy";




$amount_array = array("0","50","150","300","600","1200","2400","3600","5000","10000");
$amount_array2 = array("0","25","25","35","45","50","550");
$pv_array = array("0","50","150","300","600","1200","2400","3600","5000","10000");

/*
 * ICOPAY (통합 인라인 / JPAY) — $GLOBALS['ICOPAY_COMP_ID'], ICOPAY_BROKER_SECRET 등 채우기.
 * lib/icopay_pg_secrets.local.php 예시 참고: compId 6000000017, ICOPAY_INTEGRATION_MODE=unified, JPY.
 * 인라인 결제(공식 샘플): ICOPAY_INLINE_CHECKOUT=true(기본), 브로커 시크릿만 있으면 동작.
 * 카드용 KSNET(KSPay) 스크립트는 기본 OFF. 구 KSPay 쓰려면 ICOPAY_USE_KSPAY_CARD=true.
 */
if (!isset($GLOBALS['ICOPAY_USE_KSPAY_CARD'])) {
	$GLOBALS['ICOPAY_USE_KSPAY_CARD'] = false;
}
if (!isset($GLOBALS['ICOPAY_COMP_ID'])) {
	$GLOBALS['ICOPAY_COMP_ID'] = '';
}
if (!isset($GLOBALS['ICOPAY_BROKER_SECRET'])) {
	$GLOBALS['ICOPAY_BROKER_SECRET'] = '';
}
if (!isset($GLOBALS['ICOPAY_INLINE_CHECKOUT'])) {
	$GLOBALS['ICOPAY_INLINE_CHECKOUT'] = true;
}
if (!isset($GLOBALS['ICOPAY_CCD_MERCHANT_CODE'])) {
	$GLOBALS['ICOPAY_CCD_MERCHANT_CODE'] = '';
}
if (!isset($GLOBALS['ICOPAY_CCD_API_KEY'])) {
	$GLOBALS['ICOPAY_CCD_API_KEY'] = '';
}

?>