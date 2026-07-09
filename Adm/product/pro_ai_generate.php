<?
include "../common/dbconn.php";
include "../inc/top_menu.php";
include "../inc/left_menu_product.php";
include "pro_import_lib.php";
include "gemini_client.php";

$gender_opts = gemini_gender_options();
$season_opts = gemini_season_options();
$country_opts = gemini_country_options();
$type_opts = gemini_product_type_options();
$api_key_status = gemini_api_key_status();
?>
					<table width=900 border=0 cellpadding=0 cellspacing=0>
						<tr><td height=30></td></tr>
						<tr><td>
							<table border=0 cellpadding=0 cellspacing=0>
								<tr>
									<td width=60 align=center><img src="../image/icon2.gif" width=45 height=35 border=0></td>
									<td class='td14'><b>AI 상품 생성 (제미나이)</b></td>
								</tr>
							</table>
						</td></tr>
						<tr><td height=10></td></tr>
						<tr>
							<td valign=top style="padding:10px;">
								<font color="#003366">
									키워드(성별·계절·국가·종목 등)를 입력하면 제미나이 API가 상품명·가격·설명·이미지(4~8장/상품)를 자동 생성하여 등록합니다.
								</font>
								<br><br>
								<table width="860" border='0' cellspacing='0' cellpadding='0'>
									<tr><td colspan=2 height=2 bgcolor='#88B7DA'></td></tr>

									<tr>
										<td width="140" height="35" align="center">API 키</td>
										<td align="left" style="padding-left:10px;">
											<font color="#003366">API 키 설정은 <a href="pro_site_settings.php?tab=ai"><b>환경설정 → A. AI 설정</b></a> 에서 관리합니다.</font>
										</td>
									</tr>
									<tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>

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
	$sel = ($code === '1') ? 'selected' : '';
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
											<table width="700" border="0" cellpadding="2" cellspacing="0" style="font-size:12px;">
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
										<td height="35" align="center">5. 생성 가격</td>
										<td align="left" style="padding-left:10px;">
											최저 <input type="number" id="gen_price_min" value="110" min="10" step="10" size="8" class="adminbttn"> USD
											~ 최대 <input type="number" id="gen_price_max" value="190" min="10" step="10" size="8" class="adminbttn"> USD
											<font color="#666">(마지막 자리 0 — 예: 110~190, 1100~1900)</font>
										</td>
									</tr>
									<tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>

									<tr>
										<td valign="top" align="center" style="padding-top:8px;">6. 참고 내용</td>
										<td align="left" style="padding:8px 10px;">
											<textarea id="memo" rows="3" cols="70" class="adminbttn" placeholder="예: 프리미엄 라인, 20~30대 타겟, 캐주얼 스타일"></textarea>
										</td>
									</tr>
									<tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>

									<tr>
										<td height="35" align="center">7. 생성 이미지</td>
										<td align="left" style="padding-left:10px;">
											<select id="gen_image_count" class="adminbttn">
												<option value="4" selected>4장 (기본)</option>
												<option value="5">5장</option>
												<option value="6">6장</option>
												<option value="7">7장</option>
												<option value="8">8장</option>
											</select>
											<font color="#666">(앞 4장: 목록/상세 썸네일, 5장 이상: Product Details에 추가 노출)</font>
										</td>
									</tr>
									<tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>

									<tr>
										<td height="35" align="center">8. 생성 수량</td>
										<td align="left" style="padding-left:10px;">
											<input type="number" id="gen_count" value="3" min="1" max="100" size="5" class="adminbttn"> 개
											<font color="#666">(1~100, 많을수록 API 비용·시간 증가)</font>
										</td>
									</tr>
									<tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>

									<tr>
										<td valign="top" align="center" style="padding-top:8px;">9. 카테고리</td>
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
	params.append('gen_price_min', document.getElementById('gen_price_min').value);
	params.append('gen_price_max', document.getElementById('gen_price_max').value);
	params.append('image_count', document.getElementById('gen_image_count').value);
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

<? if (!$api_key_status['configured']) { ?>
	alert('먼저 환경설정 → AI 설정에서 Gemini API 키를 등록하세요.');
	location.href = 'pro_site_settings.php?tab=ai';
	return;
<? } ?>

	var genPriceMin = parseInt(document.getElementById('gen_price_min').value, 10);
	var genPriceMax = parseInt(document.getElementById('gen_price_max').value, 10);
	if (isNaN(genPriceMin) || genPriceMin < 10) {
		alert('생성 가격 최저금액(USD)을 10 이상 입력하세요.');
		return;
	}
	if (isNaN(genPriceMax) || genPriceMax < genPriceMin) {
		alert('생성 가격 최대금액은 최저금액 이상이어야 합니다.');
		return;
	}

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

	var imageCount = parseInt(document.getElementById('gen_image_count').value, 10);
	if (isNaN(imageCount) || imageCount < 4 || imageCount > 8) {
		alert('생성 이미지 수는 4~8장 사이로 선택하세요.');
		return;
	}

	var count = parseInt(document.getElementById('gen_count').value, 10);
	if (isNaN(count) || count < 1 || count > 100) {
		alert('생성 수량은 1~100 사이로 입력하세요.');
		return;
	}

	if (!confirm(count + '개 상품을 AI로 생성합니다.\n(상품당 이미지 ' + imageCount + '장, API 비용 발생)\n계속하시겠습니까?')) return;

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

	var totalSteps = totalProducts * (imageCount + 1);
	var doneSteps = 0;

	for (var p = 0; p < totalProducts; p++) {
		log('상품 ' + (p+1) + '/' + totalProducts + ' 이미지 생성 중...', '#0066cc');

		for (var img = 0; img < imageCount; img++) {
			setProgress(doneSteps, totalSteps, '상품 ' + (p+1) + ' — 이미지 ' + (img+1) + '/' + imageCount);
			var imgRes = await postRun({
				action: 'process_image',
				job_id: currentJobId,
				product_index: p,
				image_index: img
			});

			doneSteps++;
			setProgress(doneSteps, totalSteps, '상품 ' + (p+1) + ' — 이미지 ' + (img+1) + '/' + imageCount);

			if (imgRes.error) {
				log('  이미지 ' + (img+1) + ' 실패: ' + imgRes.error, 'red');
				if (imgRes.quota_exceeded) {
					log('=== 이미지 API 한도 초과 — 작업 중단 ===', 'red');
					log('Google AI Studio에서 결제 등록 후 유료 API 키(AIzaSy...)로 교체해 주세요.', 'red');
					isRunning = false;
					document.getElementById('btn_start').disabled = false;
					return;
				}
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

<? include "../inc/down_menu.php"; ?>
