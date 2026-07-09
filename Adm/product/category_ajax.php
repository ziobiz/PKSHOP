<?php
header('Content-Type: application/json; charset=utf-8');

include '../common/dbconn.php';
include '../common/user_function.php';
include 'category_lib.php';

if (session_id() === '') {
    @session_start();
}
if (!isset($_SESSION['idok']) || $_SESSION['idok'] !== 'yes') {
    echo json_encode(array('ok' => false, 'message' => '관리자 로그인이 필요합니다.'), JSON_UNESCAPED_UNICODE);
    exit;
}

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
$level = isset($_REQUEST['level']) ? intval($_REQUEST['level']) : 0;
$uid = isset($_REQUEST['uid']) ? trim($_REQUEST['uid']) : '';
$dir = isset($_REQUEST['dir']) ? trim($_REQUEST['dir']) : '';

$code1 = isset($_REQUEST['code1']) ? $_REQUEST['code1'] : '';
$code2 = isset($_REQUEST['code2']) ? $_REQUEST['code2'] : '';
$code3 = isset($_REQUEST['code3']) ? $_REQUEST['code3'] : '';

if ($level < 1 || $level > 4) {
    echo json_encode(array('ok' => false, 'message' => '잘못된 카테고리 단계입니다.'), JSON_UNESCAPED_UNICODE);
    exit;
}

$result = array('ok' => false, 'message' => '알 수 없는 요청입니다.');

if ($action === 'move') {
    if ($uid === '' || ($dir !== 'up' && $dir !== 'down')) {
        $result = array('ok' => false, 'message' => '이동 정보가 올바르지 않습니다.');
    } else {
        $result = pkshop_cate_move($DB, $shop_cate, $level, $uid, $dir, $code1, $code2, $code3);
    }
} elseif ($action === 'toggle_show') {
    if ($uid === '') {
        $result = array('ok' => false, 'message' => '카테고리를 선택하세요.');
    } else {
        $result = pkshop_cate_toggle_show($DB, $shop_cate, $level, $uid);
    }
} elseif ($action === 'delete_one') {
    if ($uid === '') {
        $result = array('ok' => false, 'message' => '카테고리를 선택하세요.');
    } else {
        $result = pkshop_cate_delete_one($DB, $shop_cate, $level, $uid);
    }
}

echo json_encode($result, JSON_UNESCAPED_UNICODE);
