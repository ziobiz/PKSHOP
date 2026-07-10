<?
include "../common/dbconn.php";
include "../inc/top_menu.php";
include "../inc/left_menu_product.php";
include "pro_import_lib.php";

$columns = pkshop_import_columns();
$cate_data = pkshop_import_get_categories($DB, $shop_cate);
?>
<script language="javascript">
function onImportFileChange(input) {
	var display = document.getElementById('import_file_display');
	if (input.files && input.files.length > 0) {
		display.value = input.files[0].name;
	} else {
		display.value = '';
	}
}
function go_import() {
	var f = document.form;
	if (!f.import_file.value) {
		alert('업로드할 파일을 선택해주세요.');
		return;
	}
	var ext = f.import_file.value.split('.').pop().toLowerCase();
	if (ext != 'csv' && ext != 'xls' && ext != 'xlsx' && ext != 'txt') {
		alert('csv, xls, xlsx, txt 파일만 업로드 가능합니다.');
		return;
	}
	if (!confirm('파일의 상품을 일괄 등록하시겠습니까?')) return;
	f.action = "pro_import_ok.php";
	f.submit();
}
</script>

<?php adm_ui_page_open(); ?>
<form name="form" method="post" action="pro_import_ok.php" enctype="multipart/form-data">

<?php adm_ui_card_open('파일 업로드'); ?>
<div class="pg-file-attach-toolbar">
	<div class="pg-file-attach-picker">
		<input type="text" id="import_file_display" class="pg-input pg-file-attach-name" readonly placeholder="선택된 파일 없음" value="">
		<label for="import_file" class="pg-btn pg-btn-outline pg-btn-file-browse">파일 선택</label>
		<input type="file" name="import_file" id="import_file" class="pg-file-attach-hidden" accept=".csv,.xls,.xlsx,.txt" onchange="onImportFileChange(this);">
	</div>
	<button type="button" class="pg-btn pg-btn-primary pg-file-attach-submit" onclick="go_import();">일괄등록 실행</button>
</div>
<p class="pg-file-attach-hint">허용 파일: CSV, XLS, XLSX, TXT (UTF-8 또는 EUC-KR)</p>
<?php adm_ui_field_row('샘플 템플릿', '<a href="pro_import_template.php?type=csv" target="_blank">CSV 템플릿 다운로드</a> &nbsp; <a href="pro_import_template.php?type=xls" target="_blank">엑셀 템플릿 다운로드</a>'); ?>
<?php adm_ui_card_close(); ?>

<?php adm_ui_card_open('입력 항목 안내'); ?>
<div class="pg-table-responsive">
<table class="pg-data-grid adm-table">
<thead><tr><th>컬럼명</th><th>필수</th><th>설명</th></tr></thead>
<tbody>
<?
foreach ($columns as $key => $col) {
	$req = !empty($col['required']) ? 'O' : '';
	$desc = '';
	if ($key === 'country') $desc = '82=한국, 66=태국, 91=인도, 1=미국, 81=일본, 86=중국, 84=베트남, 62=인도네시아';
	if ($key === 'dis') $desc = '0=일반제품, 1=재구매제품';
	if ($key === 'onlypoint') $desc = '0=일반, 1=포인트전용';
	if ($key === 'theme') $desc = 'g,n,r,f (기본/추천/BEST/HOT) 콤마구분';
	if ($key === 'code2' || $key === 'code3' || $key === 'code4') $desc = '미사용시 00';
	if (isset($col['default']) && $desc === '') $desc = '기본값: ' . $col['default'];
?>
<tr>
	<td><?=htmlspecialchars($col['label'], ENT_QUOTES, 'UTF-8')?> (<?=htmlspecialchars($key, ENT_QUOTES, 'UTF-8')?>)</td>
	<td><?=$req?></td>
	<td><?=htmlspecialchars($desc, ENT_QUOTES, 'UTF-8')?></td>
</tr>
<? } ?>
</tbody>
</table>
</div>
<?php adm_ui_notice('* 이미지 파일명(imgl,imgm,imgb1)은 /upload/ 폴더에 미리 업로드된 파일명을 입력하세요.', 'info'); ?>
<?php adm_ui_card_close(); ?>

<?php adm_ui_card_open('카테고리 코드 참고'); ?>
<div class="pg-table-responsive">
<table class="pg-data-grid adm-table">
<thead>
<tr><th>code1</th><th>code2</th><th>code3</th><th>code4</th><th>대분류</th><th>중분류</th><th>소분류</th><th>세분류</th></tr>
</thead>
<tbody>
<?
for ($i = 0; $i < $cate_data['count'] && $i < 30; $i++) {
	$c = $cate_data['rows'][$i];
?>
<tr>
	<td><?=htmlspecialchars($c['code1'], ENT_QUOTES, 'UTF-8')?></td>
	<td><?=htmlspecialchars($c['code2'], ENT_QUOTES, 'UTF-8')?></td>
	<td><?=htmlspecialchars($c['code3'], ENT_QUOTES, 'UTF-8')?></td>
	<td><?=htmlspecialchars($c['code4'], ENT_QUOTES, 'UTF-8')?></td>
	<td><?=htmlspecialchars($c['cate1'], ENT_QUOTES, 'UTF-8')?></td>
	<td><?=htmlspecialchars($c['cate2'], ENT_QUOTES, 'UTF-8')?></td>
	<td><?=htmlspecialchars($c['cate3'], ENT_QUOTES, 'UTF-8')?></td>
	<td><?=htmlspecialchars($c['cate4'], ENT_QUOTES, 'UTF-8')?></td>
</tr>
<? }
if ($cate_data['count'] > 30) {
?>
<tr><td colspan="8">... 외 <?=($cate_data['count'] - 30)?>건 (분류등록/수정 메뉴에서 전체 확인)</td></tr>
<? } ?>
</tbody>
</table>
</div>
<?php adm_ui_card_close(); ?>

</form>
<?php adm_ui_page_close(); ?>
<? include "../inc/down_menu.php"; ?>
