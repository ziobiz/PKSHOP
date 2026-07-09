<?php
header('Content-Type: application/json; charset=utf-8');

include '../common/dbconn.php';
include '../common/user_function.php';
include 'products_order_lib.php';

if (session_id() === '') {
    @session_start();
}
if (!isset($_SESSION['idok']) || $_SESSION['idok'] !== 'yes') {
    echo json_encode(array('ok' => false, 'message' => '관리자 로그인이 필요합니다.'), JSON_UNESCAPED_UNICODE);
    exit;
}

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
$no = isset($_REQUEST['No']) ? intval($_REQUEST['No']) : 0;
$dir = isset($_REQUEST['dir']) ? trim($_REQUEST['dir']) : '';

$soldout = isset($_REQUEST['soldout']) ? $_REQUEST['soldout'] : '';
$sel_code1 = isset($_REQUEST['sel_code1']) ? $_REQUEST['sel_code1'] : '';
$sel_code2 = isset($_REQUEST['sel_code2']) ? $_REQUEST['sel_code2'] : '';
$sel_code3 = isset($_REQUEST['sel_code3']) ? $_REQUEST['sel_code3'] : '';
$sel_code4 = isset($_REQUEST['sel_code4']) ? $_REQUEST['sel_code4'] : '';

if ($action !== 'move') {
    echo json_encode(array('ok' => false, 'message' => '알 수 없는 요청입니다.'), JSON_UNESCAPED_UNICODE);
    exit;
}

$result = pkshop_product_move_order($DB, $shop_goods, $no, $dir, $soldout, $sel_code1, $sel_code2, $sel_code3, $sel_code4);
echo json_encode($result, JSON_UNESCAPED_UNICODE);
