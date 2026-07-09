<?
include "../common/dbconn.php";
include "../common/user_function.php";
require_once dirname(__FILE__) . '/../../include/site_settings_lib.php';
require_once dirname(__FILE__) . '/../../include/icopay_settings_lib.php';

if (!isset($_SESSION["idok"]) || $_SESSION["idok"] !== "yes") {
	echo "<script>alert('관리자만 접근할 수 있습니다.');location.href='../login/login.php';</script>";
	exit;
}

$section = isset($_POST['section']) ? $_POST['section'] : '';

if ($section === 'promo') {
	require_once dirname(__FILE__) . '/../../include/pkshop_promo_lib.php';
	$opts = pkshop_promo_rotate_interval_options();
	$fields = array('promo_rotate_best', 'promo_rotate_recommended', 'promo_rotate_all');
	$data = array();
	foreach ($fields as $field) {
		$val = isset($_POST[$field]) ? trim((string)$_POST[$field]) : '30';
		if (!isset($opts[$val])) {
			echo "<script>alert('지원하지 않는 순환 시간입니다.');location.href='pro_site_settings.php?tab=promo';</script>";
			exit;
		}
		$data[$field] = $val;
	}
	if (!pkshop_site_settings_save($data)) {
		echo "<script>alert('설정 저장에 실패했습니다.');location.href='pro_site_settings.php?tab=promo';</script>";
		exit;
	}
	echo "<script>alert('홍보설정이 저장되었습니다.');location.href='pro_site_settings.php?tab=promo';</script>";
	exit;
}

$allowed = array('brand', 'currency', 'payment');
if (!in_array($section, $allowed, true)) {
	echo "<script>alert('잘못된 요청입니다.');history.back();</script>";
	exit;
}

$data = array();
$defaults = pkshop_site_settings_defaults();
foreach ($defaults as $k => $v) {
	if (isset($_POST[$k])) {
		$data[$k] = is_string($_POST[$k]) ? trim($_POST[$k]) : $_POST[$k];
	}
}

$delete_image_fields = array(
	'footer_bottom_image',
	'footer_story_banner1',
	'footer_story_banner2',
);
foreach ($delete_image_fields as $field) {
	if (!empty($_POST['delete_' . $field])) {
		$data[$field] = '';
	}
}

if ($section === 'currency') {
	$opts = pkshop_currency_options();
	$primary = strtoupper($data['currency_primary_code']);
	$secondary = strtoupper($data['currency_secondary_code']);
	$payment = strtoupper($data['currency_payment_code']);
	if (!isset($opts[$primary]) || !isset($opts[$secondary]) || !isset($opts[$payment])) {
		echo "<script>alert('지원하지 않는 통화 코드입니다.');history.back();</script>";
		exit;
	}
	$data['currency_primary_enabled'] = isset($_POST['currency_primary_enabled']) ? '1' : '0';
	$data['currency_secondary_enabled'] = isset($_POST['currency_secondary_enabled']) ? '1' : '0';
	$enabled = array();
	if ($data['currency_primary_enabled'] === '1') $enabled[] = $primary;
	if ($data['currency_secondary_enabled'] === '1' && !in_array($secondary, $enabled, true)) $enabled[] = $secondary;
	if (empty($enabled)) {
		echo "<script>alert('최소 1개 통화는 노출해야 합니다.');history.back();</script>";
		exit;
	}
	if (!in_array($payment, $enabled, true)) {
		echo "<script>alert('결제 기준 통화는 노출 통화 중에서만 선택할 수 있습니다.');history.back();</script>";
		exit;
	}
}

if ($section === 'payment') {
	$data['payment_pg_enabled'] = isset($_POST['payment_pg_enabled']) ? '1' : '0';
	$provider = isset($data['payment_pg_provider']) ? strtoupper($data['payment_pg_provider']) : 'ICOPAY';
	if ($provider !== 'ICOPAY') {
		echo "<script>alert('현재 ICOPAY만 지원합니다.');history.back();</script>";
		exit;
	}
	$data['payment_pg_provider'] = 'ICOPAY';

	$comp_id = isset($data['icopay_comp_id']) ? trim($data['icopay_comp_id']) : '';
	if ($data['payment_pg_enabled'] === '1' && $comp_id === '') {
		echo "<script>alert('업체코드(compId)를 입력하세요.');history.back();</script>";
		exit;
	}

	$modes = pkshop_icopay_integration_mode_options();
	if (!isset($modes[$data['icopay_integration_mode']])) {
		$data['icopay_integration_mode'] = 'unified';
	}

	$langs = pkshop_icopay_checkout_lang_options();
	if (!isset($langs[$data['icopay_checkout_lang']])) {
		$data['icopay_checkout_lang'] = 'JPN';
	}

	$opts = pkshop_currency_options();
	$pay_cur = strtoupper($data['icopay_payment_currency']);
	if (!isset($opts[$pay_cur])) {
		echo "<script>alert('지원하지 않는 결제 통화입니다.');history.back();</script>";
		exit;
	}
	$data['icopay_payment_currency'] = $pay_cur;

	if (empty($data['icopay_api_base_url'])) {
		$data['icopay_api_base_url'] = 'https://api.icopay.co.kr';
	}

	$new_secret = isset($_POST['icopay_broker_secret']) ? trim($_POST['icopay_broker_secret']) : '';
	$existing_secret = pkshop_icopay_load_broker_secret();
	if ($data['payment_pg_enabled'] === '1' && $new_secret === '' && $existing_secret === '') {
		echo "<script>alert('브로커 시크릿을 입력하세요.');history.back();</script>";
		exit;
	}

	if (!pkshop_site_settings_save($data)) {
		echo "<script>alert('설정 저장에 실패했습니다.');history.back();</script>";
		exit;
	}

	$secret_to_write = ($new_secret !== '') ? $new_secret : null;
	$write = pkshop_icopay_write_secrets_file($data, $secret_to_write);
	if (!$write['ok']) {
		echo "<script>alert('" . addslashes($write['error']) . "');history.back();</script>";
		exit;
	}

	echo "<script>alert('결제연동 설정이 저장되었습니다.');location.href='pro_site_settings.php?tab=payment';</script>";
	exit;
}

$upload_dir = dirname(__FILE__) . '/../../images/site/';
if (!is_dir($upload_dir)) {
	@mkdir($upload_dir, 0755, true);
}

$file_fields = array(
	'favicon' => array('prefix' => 'favicon', 'ext' => array('ico', 'png', 'jpg', 'gif')),
	'logo_pc' => array('prefix' => 'logo_pc', 'ext' => array('png', 'jpg', 'gif', 'svg')),
	'logo_mobile' => array('prefix' => 'logo_mobile', 'ext' => array('png', 'jpg', 'gif', 'svg')),
	'banner1' => array('prefix' => 'banner1', 'ext' => array('jpg', 'jpeg', 'png', 'webp')),
	'banner2' => array('prefix' => 'banner2', 'ext' => array('jpg', 'jpeg', 'png', 'webp')),
	'banner3' => array('prefix' => 'banner3', 'ext' => array('jpg', 'jpeg', 'png', 'webp')),
	'footer_icon_myinfo' => array('prefix' => 'icon_myinfo', 'ext' => array('png', 'jpg', 'gif')),
	'footer_icon_cart' => array('prefix' => 'icon_cart', 'ext' => array('png', 'jpg', 'gif')),
	'footer_bottom_image' => array('prefix' => 'footer_bottom', 'ext' => array('png', 'jpg', 'gif', 'webp')),
	'footer_story_banner1' => array('prefix' => 'story_banner1', 'ext' => array('jpg', 'jpeg', 'png', 'webp')),
	'footer_story_banner2' => array('prefix' => 'story_banner2', 'ext' => array('jpg', 'jpeg', 'png', 'webp')),
);

foreach ($file_fields as $field => $rule) {
	$input = 'upload_' . $field;
	if (!isset($_FILES[$input]) || $_FILES[$input]['error'] === UPLOAD_ERR_NO_FILE) {
		continue;
	}
	if ($_FILES[$input]['error'] !== UPLOAD_ERR_OK) {
		continue;
	}
	$orig = $_FILES[$input]['name'];
	$ext = strtolower(pathinfo($orig, PATHINFO_EXTENSION));
	if (!in_array($ext, $rule['ext'], true)) {
		continue;
	}
	$fname = $rule['prefix'] . '_' . date('YmdHis') . '.' . $ext;
	$dest = $upload_dir . $fname;
	if (@move_uploaded_file($_FILES[$input]['tmp_name'], $dest)) {
		$web_path = '../images/site/' . $fname;
		if ($field === 'favicon') {
			$web_path = 'images/site/' . $fname;
		}
		$data[$field] = $web_path;
	}
}

if (!pkshop_site_settings_save($data)) {
	echo "<script>alert('설정 저장에 실패했습니다.');history.back();</script>";
	exit;
}

$tab = 'brand';
if ($section === 'currency') {
	$tab = 'currency';
} elseif ($section === 'payment') {
	$tab = 'payment';
}
echo "<script>alert('환경설정이 저장되었습니다.');location.href='pro_site_settings.php?tab=" . $tab . "';</script>";
?>
