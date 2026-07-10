<?
header('Content-Type: application/json; charset=utf-8');

include "../common/dbconn.php";
include "../common/user_function.php";
include "products_theme_lib.php";

$action = isset($_POST['action']) ? $_POST['action'] : '';
$no = isset($_POST['No']) ? intval($_POST['No']) : 0;

if ($action === 'save_row') {
	if ($no <= 0) {
		echo json_encode(array('ok' => false, 'message' => '잘못된 상품 번호입니다.'));
		exit;
	}
	$theme_n = (isset($_POST['theme_n']) && $_POST['theme_n'] === 'n') ? 'n' : '';
	$theme_r = (isset($_POST['theme_r']) && $_POST['theme_r'] === 'r') ? 'r' : '';
	$theme_f = (isset($_POST['theme_f']) && $_POST['theme_f'] === 'f') ? 'f' : '';
	pkshop_products_update_themes($DB, $shop_goods, $no, $theme_n, $theme_r, $theme_f);

	$sel_cate = isset($_POST['sel_cate']) ? $_POST['sel_cate'] : '';
	$sel_val = isset($_POST['sel']) ? $_POST['sel'] : '';
	if ($sel_val !== '' && $sel_val !== '99999') {
		if ($sel_cate == 2) $order_tmp = 'order2';
		else if ($sel_cate == 3) $order_tmp = 'order3';
		else if ($sel_cate == 4) $order_tmp = 'order4';
		else $order_tmp = 'order1';
		$order_val = addslashes($sel_val);
		$DB->update($shop_goods, "$order_tmp='$order_val' WHERE No='$no'");
	}

	echo json_encode(array('ok' => true, 'message' => '저장되었습니다.'));
	exit;
}

if ($action === 'delete_row') {
	if ($no <= 0) {
		echo json_encode(array('ok' => false, 'message' => '잘못된 상품 번호입니다.'));
		exit;
	}
	$shop_img = "../../upload/";
	$savedir = $shop_img;
	$Result = "select imgl,imgm,imgb1,imgb2,imgb3,imgb4,imgb5 from $shop_goods where No=$no";
	$DB->get($Result, $rs, $rn);
	if ($rn > 0) {
		$imgs = array('imgl', 'imgm', 'imgb1', 'imgb2', 'imgb3', 'imgb4', 'imgb5');
		foreach ($imgs as $img_key) {
			$img_file = isset($rs[0][$img_key]) ? $rs[0][$img_key] : '';
			if ($img_file !== '') {
				$img_path = $savedir . $img_file;
				if (file_exists($img_path)) {
					@unlink($img_path);
				}
			}
		}
	}
	$DB->delete($shop_goods, " No = '$no'");
	echo json_encode(array('ok' => true, 'message' => '삭제되었습니다.'));
	exit;
}

if ($action === 'delete_rows') {
	$nos = isset($_POST['nos']) ? $_POST['nos'] : array();
	if (!is_array($nos) || count($nos) < 1) {
		echo json_encode(array('ok' => false, 'message' => '삭제할 상품을 선택해 주세요.'));
		exit;
	}

	$shop_img = "../../upload/";
	$savedir = $shop_img;
	$deleted = 0;
	foreach ($nos as $raw_no) {
		$del_no = intval($raw_no);
		if ($del_no <= 0) continue;

		$Result = "select imgl,imgm,imgb1,imgb2,imgb3,imgb4,imgb5 from $shop_goods where No=$del_no";
		$DB->get($Result, $rs, $rn);
		if ($rn > 0) {
			$imgs = array('imgl', 'imgm', 'imgb1', 'imgb2', 'imgb3', 'imgb4', 'imgb5');
			foreach ($imgs as $img_key) {
				$img_file = isset($rs[0][$img_key]) ? $rs[0][$img_key] : '';
				if ($img_file !== '') {
					$img_path = $savedir . $img_file;
					if (file_exists($img_path)) {
						@unlink($img_path);
					}
				}
			}
		}
		$DB->delete($shop_goods, " No = '$del_no'");
		$deleted++;
	}

	if ($deleted < 1) {
		echo json_encode(array('ok' => false, 'message' => '삭제할 상품이 없습니다.'));
		exit;
	}

	echo json_encode(array('ok' => true, 'message' => $deleted . '개 상품이 삭제되었습니다.'));
	exit;
}

echo json_encode(array('ok' => false, 'message' => '지원하지 않는 요청입니다.'));
?>
