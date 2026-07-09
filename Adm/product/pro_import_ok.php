<?
include "../common/dbconn.php";
include "../common/user_function.php";
include "pro_import_lib.php";

if (!isset($_FILES['import_file']) || $_FILES['import_file']['error'] !== UPLOAD_ERR_OK) {
	error("UPLOAD_COPY_FAILURE");
	exit;
}

$tmp_path  = $_FILES['import_file']['tmp_name'];
$file_name = $_FILES['import_file']['name'];

$parsed = pkshop_import_parse_file($tmp_path, $file_name);
if (isset($parsed['error'])) {
	echo "<script>alert('" . addslashes($parsed['error']) . "'); history.back();</script>";
	exit;
}

$assoc_result = pkshop_import_rows_to_assoc($parsed['rows']);
if (isset($assoc_result['error'])) {
	echo "<script>alert('" . addslashes($assoc_result['error']) . "'); history.back();</script>";
	exit;
}

$success_list = array();
$fail_list    = array();

foreach ($assoc_result['rows'] as $item) {
	$line = $item['line'];
	$data = $item['data'];

	$val_errors = pkshop_import_validate_row($data);
	if (count($val_errors) > 0) {
		$fail_list[] = array('line' => $line, 'title' => $data['title'], 'error' => implode(', ', $val_errors));
		continue;
	}

	$cate_error = pkshop_import_validate_category(
		$DB, $shop_cate,
		$data['code1'], $data['code2'], $data['code3'], $data['code4']
	);
	if ($cate_error !== '') {
		$fail_list[] = array('line' => $line, 'title' => $data['title'], 'error' => $cate_error);
		continue;
	}

	$result = pkshop_import_insert_product($DB, $shop_goods, $data);
	if (!$result['success']) {
		$fail_list[] = array('line' => $line, 'title' => $data['title'], 'error' => $result['error']);
		continue;
	}

	$success_list[] = array(
		'line'  => $line,
		'title' => $data['title'],
		'code'  => $result['code'],
		'No'    => $result['No'],
	);
}

include "../inc/top_menu.php";
include "../inc/left_menu_product.php";
?>
					<table width=800 border=0 cellpadding=0 cellspacing=0>
						<tr><td height=30></td></tr>
						<tr><td>
							<table border=0 cellpadding=0 cellspacing=0>
								<tr>
									<td width=60 align=center><img src="../image/icon2.gif" width=45 height=35 border=0></td>
									<td class='td14'><b>일괄등록 결과</b></td>
								</tr>
							</table>
						</td></tr>
						<tr><td height=10></td></tr>
						<tr>
							<td valign=top style="padding:10px;">
								<b>성공: <?=count($success_list)?>건</b> &nbsp;|&nbsp;
								<b>실패: <?=count($fail_list)?>건</b>
								<br><br>
<?
if (count($success_list) > 0) {
?>
								<table width="780" border="1" cellpadding="4" cellspacing="0" style="border-collapse:collapse;font-size:12px;">
									<tr bgcolor="#E8FFE8">
										<td><b>행</b></td>
										<td><b>상품명</b></td>
										<td><b>상품코드</b></td>
										<td><b>관리</b></td>
									</tr>
<?
	foreach ($success_list as $s) {
?>
									<tr>
										<td><?=$s['line']?></td>
										<td><?=htmlspecialchars($s['title'])?></td>
										<td><?=$s['code']?></td>
										<td><a href="pro_info.php?No=<?=$s['No']?>">상품보기</a></td>
									</tr>
<?
	}
?>
								</table>
								<br>
<?
}

if (count($fail_list) > 0) {
?>
								<table width="780" border="1" cellpadding="4" cellspacing="0" style="border-collapse:collapse;font-size:12px;">
									<tr bgcolor="#FFE8E8">
										<td><b>행</b></td>
										<td><b>상품명</b></td>
										<td><b>오류</b></td>
									</tr>
<?
	foreach ($fail_list as $f) {
?>
									<tr>
										<td><?=$f['line']?></td>
										<td><?=htmlspecialchars($f['title'])?></td>
										<td><font color="red"><?=htmlspecialchars($f['error'])?></font></td>
									</tr>
<?
	}
?>
								</table>
<?
}
?>
								<br>
								<input type="button" value="다시 등록" onclick="location.href='pro_import.php';" class="adminbttn">
								&nbsp;
								<input type="button" value="전체상품관리" onclick="location.href='products.php';" class="adminbttn">
							</td>
						</tr>
						<tr><td height=40></td></tr>
					</table>

<? include "../inc/down_menu.php"; ?>
