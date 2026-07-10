<?
header('Content-Type: application/json; charset=utf-8');

include_once('../lib/basic_class2.php');
include_once('../lib/config.php');
include_once('../lib/common.php');
include_once('../lib/php_function.php');
require_once dirname(__FILE__) . '/../../include/pkshop_adglobal_lib.php';

pkshop_adglobal_send_cors();
pkshop_adglobal_ensure_schema($DB, $shop_goods);

$deId = isset($_POST['deId']) ? $_POST['deId'] : '';
$Type = isset($_POST['Type']) ? $_POST['Type'] : '';

if ($deId !== $store_key) {
    echo json_encode(array('result' => '0', 'msg' => 'deId is wrong'));
    exit;
}

$base_url = pkshop_adglobal_shop_base_url();
$data_list = array();

if ($Type === 'list') {
    $sql = "SELECT code1,code2,code3,code4,code,title,info,pricec,prices,priced,company,soldout,imgl,imgm,color,size "
        . "FROM $shop_goods WHERE expose_ag='Y' AND soldout='N' ORDER BY order1 ASC, signdate DESC LIMIT 20";
    $DB->get($sql, $rows, $row_count);
    for ($i = 0; $i < $row_count; $i++) {
        if (!pkshop_adglobal_category_visible($DB, $shop_cate, $rows[$i]['code1'], $rows[$i]['code2'])) {
            continue;
        }
        $data_list[] = pkshop_adglobal_product_row($rows[$i], $base_url, false);
    }
    echo json_encode(array('result' => '1', 'count' => count($data_list), 'products' => $data_list));
    exit;
}

if ($Type === 'view') {
    $code = isset($_POST['code']) ? trim($_POST['code']) : '';
    if ($code === '') {
        echo json_encode(array('result' => '0', 'msg' => 'code required'));
        exit;
    }
    $sql = "SELECT * FROM $shop_goods WHERE code=:code AND expose_ag='Y' AND soldout='N' LIMIT 1";
    $DB->get($sql, $rows, $row_count, array('code' => $code));
    if ($row_count < 1) {
        echo json_encode(array('result' => '0', 'msg' => 'product not found'));
        exit;
    }
    if (!pkshop_adglobal_category_visible($DB, $shop_cate, $rows[0]['code1'], $rows[0]['code2'])) {
        echo json_encode(array('result' => '0', 'msg' => 'product not available'));
        exit;
    }
    echo json_encode(array(
        'result' => '1',
        'product' => pkshop_adglobal_product_row($rows[0], $base_url, true),
    ));
    exit;
}

echo json_encode(array('result' => '0', 'msg' => 'unknown Type'));
