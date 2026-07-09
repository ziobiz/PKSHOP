<?
include "../common/dbconn.php";
include "../inc/top_menu.php";
include "../inc/left_menu_product.php";
include "pro_import_lib.php";

$columns = pkshop_import_columns();
$cate_data = pkshop_import_get_categories($DB, $shop_cate);
?>
					<table width=800 border=0 cellpadding=0 cellspacing=0>
						<tr><td height=30></td></tr>
						<tr><td>
							<table border=0 cellpadding=0 cellspacing=0>
								<tr>
									<td width=60 align=center><img src="../image/icon2.gif" width=45 height=35 border=0></td>
									<td class='td14'><b>상품 일괄등록 (CSV/엑셀)</b></td>
								</tr>
							</table>
						</td></tr>
						<tr><td height=3></td></tr>
						<tr>
							<td valign=top>
<script language="javascript">
function go_import() {
	var f = document.form;
	if (f.import_file.value == "") {
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
							<table width="800" border='0' cellspacing='0' cellpadding='0'>
								<form name="form" method="post" action="./pro_import_ok.php" enctype="multipart/form-data">
									<tr><td colspan=2 height=2 bgcolor='#88B7DA'></td></tr>
									<tr><td colspan=2 height=10></td></tr>
									<tr>
										<td width="150" height="30" align="center">파일 선택</td>
										<td width="650" height="30" align="left">
											&nbsp;&nbsp;
											<input type="file" name="import_file" size="50" class="adminbttn">
											&nbsp;
											<input type="button" value="일괄등록 실행" onclick="go_import();" class="adminbttn">
										</td>
									</tr>
									<tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>
									<tr>
										<td height="30" align="center">샘플 템플릿</td>
										<td height="30" align="left">
											&nbsp;&nbsp;
											<a href="pro_import_template.php?type=csv" target="_blank">[CSV 템플릿 다운로드]</a>
											&nbsp;&nbsp;
											<a href="pro_import_template.php?type=xls" target="_blank">[엑셀 템플릿 다운로드]</a>
										</td>
									</tr>
									<tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>
									<tr>
										<td height="30" align="center">지원 형식</td>
										<td height="30" align="left">
											&nbsp;&nbsp; CSV, XLS, XLSX, TXT (UTF-8 또는 EUC-KR)
										</td>
									</tr>
									<tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>
									<tr>
										<td valign="top" align="center" style="padding-top:10px;">입력 항목</td>
										<td align="left" style="padding:10px;">
											<table border="1" cellpadding="4" cellspacing="0" style="border-collapse:collapse;font-size:12px;">
												<tr bgcolor="#E8F0F8">
													<td><b>컬럼명</b></td>
													<td><b>필수</b></td>
													<td><b>설명</b></td>
												</tr>
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
													<td><?=$col['label']?> (<?=$key?>)</td>
													<td align="center"><?=$req?></td>
													<td><?=$desc?></td>
												</tr>
<?
}
?>
											</table>
											<br>
											<font color="#003366">* 이미지 파일명(imgl,imgm,imgb1)은 /upload/ 폴더에 미리 업로드된 파일명을 입력하세요.</font>
										</td>
									</tr>
									<tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>
									<tr>
										<td valign="top" align="center" style="padding-top:10px;">카테고리<br>코드 참고</td>
										<td align="left" style="padding:10px;">
											<table border="1" cellpadding="3" cellspacing="0" style="border-collapse:collapse;font-size:11px;">
												<tr bgcolor="#E8F0F8">
													<td>code1</td><td>code2</td><td>code3</td><td>code4</td>
													<td>대분류</td><td>중분류</td><td>소분류</td><td>세분류</td>
												</tr>
<?
for ($i = 0; $i < $cate_data['count'] && $i < 30; $i++) {
	$c = $cate_data['rows'][$i];
?>
												<tr>
													<td><?=$c['code1']?></td>
													<td><?=$c['code2']?></td>
													<td><?=$c['code3']?></td>
													<td><?=$c['code4']?></td>
													<td><?=htmlspecialchars($c['cate1'])?></td>
													<td><?=htmlspecialchars($c['cate2'])?></td>
													<td><?=htmlspecialchars($c['cate3'])?></td>
													<td><?=htmlspecialchars($c['cate4'])?></td>
												</tr>
<?
}
if ($cate_data['count'] > 30) {
?>
												<tr><td colspan="8" align="center">... 외 <?=($cate_data['count'] - 30)?>건 (분류등록/수정 메뉴에서 전체 확인)</td></tr>
<?
}
?>
											</table>
										</td>
									</tr>
									<tr><td colspan=2 height=1 bgcolor='#88B7DA'></td></tr>
								</form>
							</table>
							<br><br>
							</td>
						</tr>
						<tr><td height=40></td></tr>
					</table>

<? include "../inc/down_menu.php"; ?>
