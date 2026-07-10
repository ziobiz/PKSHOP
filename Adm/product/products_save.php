<?
include "../common/dbconn.php";
include "../common/user_function.php";
require_once __DIR__ . '/../inc/adm_ui_lib.php';
include "products_theme_lib.php";

$sel_cate = isset($_POST['sel_cate']) ? $_POST['sel_cate'] : '';
$soldout = isset($_POST['soldout']) ? $_POST['soldout'] : '';
$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
if ($page < 1) $page = 1;
$p_num = isset($_POST['p_num']) ? $_POST['p_num'] : adm_ui_per_page_default();
if (adm_ui_per_page_is_all($p_num)) {
	$p_num = 0;
} else {
	$p_num = intval($p_num);
}
$keyfield = isset($_POST['keyfield']) ? $_POST['keyfield'] : '';
$key = isset($_POST['key']) ? $_POST['key'] : '';
$chk_order = isset($_POST['chk_order']) ? $_POST['chk_order'] : '';
$sel_code1 = isset($_POST['sel_code1']) ? $_POST['sel_code1'] : '';
$sel_code2 = isset($_POST['sel_code2']) ? $_POST['sel_code2'] : '';
$sel_code3 = isset($_POST['sel_code3']) ? $_POST['sel_code3'] : '';
$sel_code4 = isset($_POST['sel_code4']) ? $_POST['sel_code4'] : '';

$theme_n_post = (isset($_POST['theme_n']) && is_array($_POST['theme_n'])) ? $_POST['theme_n'] : array();
$theme_r_post = (isset($_POST['theme_r']) && is_array($_POST['theme_r'])) ? $_POST['theme_r'] : array();
$theme_f_post = (isset($_POST['theme_f']) && is_array($_POST['theme_f'])) ? $_POST['theme_f'] : array();
$nos = (isset($_POST['no']) && is_array($_POST['no'])) ? $_POST['no'] : array();
$sel = (isset($_POST['sel']) && is_array($_POST['sel'])) ? $_POST['sel'] : array();

if ($sel_cate == 1) {
	$order_tmp = 'order1';
} else if ($sel_cate == 2) {
	$order_tmp = 'order2';
} else if ($sel_cate == 3) {
	$order_tmp = 'order3';
} else if ($sel_cate == 4) {
	$order_tmp = 'order4';
} else {
	$order_tmp = 'order1';
}

foreach ($nos as $no => $no_val) {
	$no = intval($no);
	if ($no <= 0) continue;

	$theme_n = isset($theme_n_post[$no]) ? 'n' : '';
	$theme_r = isset($theme_r_post[$no]) ? 'r' : '';
	$theme_f = isset($theme_f_post[$no]) ? 'f' : '';
	pkshop_products_update_themes($DB, $shop_goods, $no, $theme_n, $theme_r, $theme_f);

	if (isset($sel[$no]) && $sel[$no] !== '' && $sel[$no] !== '99999') {
		$order_val = addslashes($sel[$no]);
		$DB->update($shop_goods, "$order_tmp='$order_val' WHERE No='$no'");
	}
}

$tmp_url = "products.php?sel_code1=$sel_code1&sel_code2=$sel_code2&sel_code3=$sel_code3&sel_code4=$sel_code4&chk_order=$chk_order&sel_cate=$sel_cate&soldout=$soldout&page=$page&p_num=$p_num&keyfield=$keyfield&key=" . urlencode($key);
echo "<meta http-equiv='Refresh' content='0; URL=$tmp_url'>";
?>
