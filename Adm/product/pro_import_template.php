<?
include "pro_import_lib.php";

$type = isset($_GET['type']) ? $_GET['type'] : 'csv';
$columns = pkshop_import_columns();

$headers = array();
$sample  = array();

foreach ($columns as $key => $col) {
	$headers[] = $col['label'];
}

$sample = array(
	'01', '00', '00', '00',
	'샘플 상품명',
	'샘플제조사',
	'82',
	'KOREA',
	'블랙,화이트',
	'S,M,L',
	'50000',
	'45000',
	'45000',
	'10',
	'0',
	'0',
	'100',
	'10',
	'g',
	'<p>상품 상세설명 HTML</p>',
	'',
	'',
	'',
);

if ($type === 'xls') {
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=product_import_template.xls");
	header("Content-Description: PHP Generated Data");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<table border="1">
	<tr>
<?
	foreach ($headers as $h) {
		echo "<td><b>" . htmlspecialchars($h) . "</b></td>";
	}
?>
	</tr>
	<tr>
<?
	foreach ($sample as $s) {
		echo "<td>" . htmlspecialchars($s) . "</td>";
	}
?>
	</tr>
</table>
<br>
<table border="0">
	<tr><td colspan="5"><b>[입력 안내]</b></td></tr>
	<tr><td>대분류코드</td><td colspan="4">shop_cate 테이블 code1 (필수, 00 불가)</td></tr>
	<tr><td>중/소/세분류코드</td><td colspan="4">미사용 시 00</td></tr>
	<tr><td>국가코드</td><td colspan="4">82=한국, 66=태국, 91=인도, 1=미국, 81=일본, 86=중국, 84=베트남, 62=인도네시아</td></tr>
	<tr><td>상품구분</td><td colspan="4">0=일반제품, 1=재구매제품</td></tr>
	<tr><td>포인트전용</td><td colspan="4">0=일반, 1=포인트전용구매</td></tr>
	<tr><td>상품홍보</td><td colspan="4">g=기본, n=추천, r=BEST, f=HOT (콤마로 복수선택 가능)</td></tr>
	<tr><td>이미지</td><td colspan="4">/upload/ 폴더에 미리 업로드한 파일명 입력</td></tr>
</table>
</body>
</html>
<?
	exit;
}

header("Content-type: text/csv; charset=UTF-8");
header("Content-Disposition: attachment; filename=product_import_template.csv");
header("Content-Description: PHP Generated Data");

echo "\xEF\xBB\xBF";
echo implode(',', array_map('pkshop_import_csv_escape', $headers)) . "\r\n";
echo implode(',', array_map('pkshop_import_csv_escape', $sample)) . "\r\n";
