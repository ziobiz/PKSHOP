<?
include "../common/dbconn.php";
include_once "../inc/admin_shell_lib.php";
include "pro_import_lib.php";
include "gemini_client.php";

$gender_opts = gemini_gender_options();
$season_opts = gemini_season_options();
$country_opts = gemini_country_options();
$type_opts = gemini_product_type_options();
?>
<?php pkshop_admin_auto_shell_begin(); ?>
					<table class="pg-table pg-table-form" width="100%" border=0 cellpadding=0 cellspacing=0>
						<tr><td height=30></td></tr>
						<tr><td height=10></td></tr>
						<tr>
							<td valign=top style="padding:10px;">
								<font color="#003366">
									키워드(성별·계절·국가·종목 등)를 입력하면 제미나이 API가 상품명·가격·설명·이미지(4장/상품)를 자동 생성하여 등록합니다.
								</font>
								<br><br>
								<table class="pg-table pg-table-form" width="100%" border='0' cellspacing='0' cellpadding='0'>
									<tr><td colspan=2 height=2 bgcolor='#88B7DA'></td></tr>

									<tr>
										<td width="140" height="35" align="center">1. 성별</td>
										<td align="left" style="padding-left:10px;">
<?
foreach ($gender_opts as $val => $label) {
	$chk = ($val === 'all') ? 'checked' : '';
?>
											<label><input type="radio" name="gender" value="<?=$val?>" <?=$chk?>> <?=$label?></label>&nbsp;&nbsp;
<?
}
?>
										</td>
									</tr>
									<tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>

									<tr>
										<td height="35" align="center">2. 계절</td>
										<td align="left" style="padding-left:10px;">
											<select id="season" class="adminbttn">
<?
foreach ($season_opts as $val => $label) {
	$sel = ($val === 'all_season') ? 'selected' : '';
?>
												<option value="<?=$val?>" <?=$sel?>><?=$label?></option>
<?
}
?>
											</select>
										</td>
									</tr>
									<tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>

									<tr>
										<td height="35" align="center">3. 국가</td>
										<td align="left" style="padding-left:10px;">
											<select id="country" class="adminbttn">
<?
foreach ($country_opts as $code => $info) {
	$sel = ($code === '82') ? 'selected' : '';
?>
												<option value="<?=$code?>" <?=$sel?>><?=$info['name']?> (<?=$info['label']?>)</option>
<?
}
?>
											</select>
										</td>
									</tr>
									<tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>

									<tr>
										<td valign="top" align="center" style="padding-top:8px;">4. 상품 종목</td>
										<td align="left" style="padding:8px 10px;">
											<table class="pg-table pg-table-form" width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:12px;">
												<tr>
<?
$i = 0;
foreach ($type_opts as $val => $label) {
	if ($i > 0 && $i % 4 === 0) echo '</tr><tr>';
	$chk = ($val === 'clothing') ? 'checked' : '';
?>
													<td width="175"><label><input type="checkbox" name="product_types" value="<?=$val?>" <?=$chk?>> <?=$label?></label></td>
<?
	$i++;
}
?>
												</tr>
											</table>
											기타 종목: <input type="text" id="product_type_custom" size="40" class="adminbttn" placeholder="예: 골프용품, 캠핑장비 등">
										</td>
									</tr>
									<tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>

									<tr>
										<td valign="top" align="center" style="padding-top:8px;">5. 참고 내용</td>
										<td align="left" style="padding:8px 10px;">
											<textarea id="memo" rows="3" cols="70" class="adminbttn" placeholder="예: 프리미엄 라인, 20~30대 타겟, 미니멀 스타일, 가격대 5~10만원 등"></textarea>
										</td>
									</tr>
									<tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>

									<tr>
										<td height="35" align="center">6. 생성 수량</td>
										<td align="left" style="padding-left:10px;">
											<input type="number" id="gen_count" value="3" min="1" max="100" size="5" class="adminbttn"> 개
											<font color="#666">(1~100, 많을수록 API 비용·시간 증가)</font>
										</td>
									</tr>
									<tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>

									<tr>
										<td valign="top" align="center" style="padding-top:8px;">7. 카테고리</td>
										<td align="left" style="padding:8px 10px;">
											<label><input type="radio" name="cate_mode" value="existing" checked onclick="toggleCateMode();"> 기존 카테고리</label>
											&nbsp;&nbsp;
											<label><input type="radio" name="cate_mode" value="new" onclick="toggleCateMode();"> 신규 카테고리 생성</label>
											<br><br>
											<div id="cate_existing">
												<select id="code1" class="adminbttn">
													<option value="">대분류 선택</option>
<?
$query = "SELECT cate1,code1 FROM $shop_cate WHERE code2='00' AND code3='00' AND code4='00' ORDER BY order_rank";
$DB->get($query, $rs, $rn);
for ($i = 0; $i < $rn; $i++) {
	$cate = htmlspecialchars(stripslashes($rs[$i]['cate1']));
	$g_code = $rs[$i]['code1'];
?>
													<option value="<?=$g_code?>"><?=$cate?> (<?=$g_code?>)</option>
<?
}
?>
												</select>
											</div>
											<div id="cate_new" style="display:none;">
												신규 카테고리명: <input type="text" id="new_cate_name" size="30" class="adminbttn" placeholder="예: AI 가전, AI 여행상품">
												<font color="#666">(대분류가 자동 생성됩니다)</font>
											</div>
										</td>
									</tr>
									<tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>

									<tr>
										<td height="35" align="center">실행</td>
										<td align="left" style="padding-left:10px;">
											<input type="button" id="btn_start" value="AI 상품 생성 시작" class="adminbttn" onclick="startGeneration();">
											&nbsp;
											<input type="button" value="전체상품관리" class="adminbttn" onclick="location.href='products.php';">
										</td>
									</tr>
									<tr><td colspan=2 height=1 bgcolor='#88B7DA'></td></tr>
								</table>

								<br>
								<div id="progress_area" style="display:none;">
									<b>진행 상황</b><br>
									<div style="width:840px;height:20px;border:1px solid #ccc;background:#f5f5f5;margin:8px 0;">
										<div id="progress_bar" style="width:0%;height:100%;background:#88B7DA;"></div>
									</div>
									<div id="progress_text">대기 중...</div>
									<br>
									<div id="log_area" style="width:840px;height:320px;overflow-y:auto;border:1px solid #D2DEE8;padding:8px;font-size:12px;background:#fafafa;"></div>
								</div>
							</td>
						</tr>
						<tr><td height=40></td></tr>
					</table>

<script>
var currentJobId = '';
var totalProducts = 0;
var isRunning = false;

function toggleCateMode() {
	var mode = document.querySelector('input[name=cate_mode]:checked').value;
	document.getElementById('cate_existing').style.display = (mode === 'existing') ? 'block' : 'none';
	document.getElementById('cate_new').style.display = (mode === 'new') ? 'block' : 'none';
}

function log(msg, color) {
	var el = document.getElementById('log_area');
	var line = document.createElement('div');
	line.style.color = color || '#333';
	line.textContent = '[' + new Date().toLocaleTimeString() + '] ' + msg;
	el.appendChild(line);
	el.scrollTop = el.scrollHeight;
}

function setProgress(done, total, text) {
	var pct = total > 0 ? Math.round((done / total) * 100) : 0;
	document.getElementById('progress_bar').style.width = pct + '%';
	document.getElementById('progress_text').textContent = text || (done + ' / ' + total);
}

function postRun(data) {
	var body = (data instanceof URLSearchParams) ? data.toString() : new URLSearchParams(data).toString();
	return fetch('pro_ai_generate_run.php', {
		method: 'POST',
		credentials: 'same-origin',
		headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
		body: body
	}).then(function(r) { return r.json(); });
}

function collectFormData() {
	var params = new URLSearchParams();
	params.append('action', 'start');
	params.append('count', document.getElementById('gen_count').value);
	params.append('gender', document.querySelector('input[name=gender]:checked').value);
	params.append('season', document.getElementById('season').value);
	params.append('country', document.getElementById('country').value);
	params.append('memo', document.getElementById('memo').value);
	params.append('product_type_custom', document.getElementById('product_type_custom').value);
	params.append('cate_mode', document.querySelector('input[name=cate_mode]:checked').value);
	params.append('code1', document.getElementById('code1').value);
	params.append('new_cate_name', document.getElementById('new_cate_name').value);
	params.append('code2', '00');
	params.append('code3', '00');
	params.append('code4', '00');

	document.querySelectorAll('input[name=product_types]:checked').forEach(function(el) {
		params.append('product_types[]', el.value);
	});

	return params;
}

async function startGeneration() {
	if (isRunning) return;

	var types = document.querySelectorAll('input[name=product_types]:checked');
	if (types.length === 0) {
		alert('상품 종목을 1개 이상 선택하세요.');
		return;
	}

	var cateMode = document.querySelector('input[name=cate_mode]:checked').value;
	if (cateMode === 'existing' && !document.getElementById('code1').value) {
		alert('기존 카테고리(대분류)를 선택하세요.');
		return;
	}
	if (cateMode === 'new' && !document.getElementById('new_cate_name').value.trim()) {
		alert('신규 카테고리명을 입력하세요.');
		return;
	}

	var count = parseInt(document.getElementById('gen_count').value, 10);
	if (isNaN(count) || count < 1 || count > 100) {
		alert('생성 수량은 1~100 사이로 입력하세요.');
		return;
	}

	if (!confirm(count + '개 상품을 AI로 생성합니다.\n(상품당 이미지 4장, API 비용 발생)\n계속하시겠습니까?')) return;

	isRunning = true;
	document.getElementById('btn_start').disabled = true;
	document.getElementById('progress_area').style.display = 'block';
	document.getElementById('log_area').innerHTML = '';
	log('작업 시작 — 키워드 기반 상품 기획 생성 중...', '#0066cc');

	var formData = collectFormData();
	var startRes = await postRun(formData);

	if (startRes.error) {
		log('오류: ' + startRes.error, 'red');
		isRunning = false;
		document.getElementById('btn_start').disabled = false;
		return;
	}

	if (!startRes.job_id) {
		log('오류: job_id를 받지 못했습니다.', 'red');
		isRunning = false;
		document.getElementById('btn_start').disabled = false;
		return;
	}

	currentJobId = startRes.job_id;
	totalProducts = startRes.total;
	log(startRes.message, 'green');

	var totalSteps = totalProducts * 5;
	var doneSteps = 0;

	for (var p = 0; p < totalProducts; p++) {
		log('상품 ' + (p+1) + '/' + totalProducts + ' 이미지 생성 중...', '#0066cc');

		for (var img = 0; img < 4; img++) {
			setProgress(doneSteps, totalSteps, '상품 ' + (p+1) + ' — 이미지 ' + (img+1) + '/4');
			var imgRes = await postRun({
				action: 'process_image',
				job_id: currentJobId,
				product_index: p,
				image_index: img
			});

			doneSteps++;
			setProgress(doneSteps, totalSteps, '상품 ' + (p+1) + ' — 이미지 ' + (img+1) + '/4');

			if (imgRes.error) {
				log('  이미지 ' + (img+1) + ' 실패: ' + imgRes.error, 'red');
			} else {
				log('  이미지 ' + (img+1) + ' 완료: ' + imgRes.filename + (imgRes.skipped ? ' (기존)' : ''), '#333');
			}
			await new Promise(function(r) { setTimeout(r, 1500); });
		}

		setProgress(doneSteps, totalSteps, '상품 ' + (p+1) + ' DB 등록 중...');
		var saveRes = await postRun({
			action: 'save_product',
			job_id: currentJobId,
			product_index: p
		});
		doneSteps++;
		setProgress(doneSteps, totalSteps, '상품 ' + (p+1) + ' 완료');

		if (saveRes.error) {
			log('  DB 등록 실패: ' + saveRes.error, 'red');
		} else {
			log('  등록 완료: ' + saveRes.title + ' (코드:' + saveRes.code + ', No:' + saveRes.No + ')', 'green');
		}
	}

	log('=== 전체 작업 완료 ===', 'green');
	setProgress(totalSteps, totalSteps, '완료!');
	isRunning = false;
	document.getElementById('btn_start').disabled = false;
}
</script>
<?php pkshop_admin_shell_end(); ?>
