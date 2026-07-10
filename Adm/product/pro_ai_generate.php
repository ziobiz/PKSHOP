<?
include "../common/dbconn.php";
include "../inc/top_menu.php";
include "../inc/left_menu_ai.php";
include "pro_import_lib.php";
include "gemini_client.php";

$gender_opts = gemini_gender_options();
$model_ethnicity_opts = gemini_model_ethnicity_main_options();
$east_asian_detail_opts = gemini_east_asian_detail_options();
$season_opts = gemini_season_options();
$country_opts = gemini_country_options();
$type_opts = gemini_product_type_options();
$api_key_status = gemini_api_key_status();

$gender_html = '<div class="pg-radio-group">';
foreach ($gender_opts as $val => $label) {
	$chk = ($val === 'all') ? ' checked' : '';
	$gender_html .= '<label class="pg-radio-item"><input type="radio" name="gender" value="' . adm_ui_h($val) . '"' . $chk . '> ' . adm_ui_h($label) . '</label>';
}
$gender_html .= '</div>';

$ethnicity_html = '<div class="pg-ai-model-select-inline">';
$ethnicity_html .= '<select id="model_ethnicity" class="pg-select pg-select--w-md" onchange="toggleEastAsianDetail();">';
foreach ($model_ethnicity_opts as $val => $label) {
	$ethnicity_html .= '<option value="' . adm_ui_h($val) . '">' . adm_ui_h($label) . '</option>';
}
$ethnicity_html .= '</select>';
$ethnicity_html .= '<span id="east_asian_detail_wrap" class="pg-ai-model-detail" style="display:none;">';
$ethnicity_html .= '<span class="pg-ai-model-detail-label">동양(개별)</span>';
$ethnicity_html .= '<select id="east_asian_detail" class="pg-select pg-select--w-md">';
foreach ($east_asian_detail_opts as $val => $label) {
	$ethnicity_html .= '<option value="' . adm_ui_h($val) . '">' . adm_ui_h($label) . '</option>';
}
$ethnicity_html .= '</select></span></div>';

$season_html = '<select id="season" class="pg-select pg-select--w-md">';
foreach ($season_opts as $val => $label) {
	$sel = ($val === 'all_season') ? ' selected' : '';
	$season_html .= '<option value="' . adm_ui_h($val) . '"' . $sel . '>' . adm_ui_h($label) . '</option>';
}
$season_html .= '</select>';

$country_html = '<select id="country" class="pg-select pg-select--w-country">';
foreach ($country_opts as $code => $info) {
	$sel = ((string)$code === '1') ? ' selected' : '';
	$country_html .= '<option value="' . adm_ui_h($code) . '"' . $sel . '>' . adm_ui_h($info['name']) . ' (' . adm_ui_h($info['label']) . ')</option>';
}
$country_html .= '</select>';

$types_html = '<div class="pg-check-grid pg-check-grid--4col">';
foreach ($type_opts as $val => $label) {
	$chk = ($val === 'clothing') ? ' checked' : '';
	$types_html .= '<label class="pg-check-item"><input type="checkbox" name="product_types" value="' . adm_ui_h($val) . '"' . $chk . '> ' . adm_ui_h($label) . '</label>';
}
$types_html .= '</div>';
$types_html .= '<div class="pg-ai-custom-type"><span class="pg-ai-custom-type-label">기타 종목</span>';
$types_html .= '<input type="text" id="product_type_custom" class="pg-input pg-input--w-lg" placeholder="예: 골프용품, 캠핑장비 등"></div>';

$price_html = '<div class="pg-input-unit pg-input-unit--inline-hint pg-input-unit--price-range">';
$price_html .= '<span>최저</span>';
$price_html .= '<input type="number" id="gen_price_min" value="110" min="10" step="10" class="pg-input pg-input--w-sm">';
$price_html .= '<span>USD ~ 최대</span>';
$price_html .= '<input type="number" id="gen_price_max" value="190" min="10" step="10" class="pg-input pg-input--w-sm">';
$price_html .= '<span>USD</span>';
$price_html .= '<span class="pg-field-hint-inline">(마지막 자리 0 — 예: 110~190, 1100~1900)</span>';
$price_html .= '</div>';

$cate_html = '<div class="pg-ai-cate-inline">';
$cate_html .= '<select id="cate_mode" class="pg-select pg-select--w-cate-mode" onchange="toggleCateMode();">';
$cate_html .= '<option value="existing" selected>기존 카테고리</option>';
$cate_html .= '<option value="new">신규 카테고리 생성</option>';
$cate_html .= '</select>';
$cate_html .= '<span id="cate_existing" class="pg-ai-cate-extra">';
$cate_html .= '<select id="code1" class="pg-select pg-select--w-md"><option value="">대분류 선택</option>';
$query = "SELECT cate1,code1 FROM $shop_cate WHERE code2='00' AND code3='00' AND code4='00' ORDER BY order_rank";
$DB->get($query, $rs, $rn);
for ($i = 0; $i < $rn; $i++) {
	$cate = adm_ui_h(stripslashes($rs[$i]['cate1']));
	$g_code = adm_ui_h($rs[$i]['code1']);
	$cate_html .= '<option value="' . $g_code . '">' . $cate . ' (' . $g_code . ')</option>';
}
$cate_html .= '</select></span>';
$cate_html .= '<span id="cate_new" class="pg-ai-cate-extra" style="display:none;">';
$cate_html .= '<input type="text" id="new_cate_name" class="pg-input pg-input--w-md" placeholder="신규 카테고리명 (예: AI 가전, AI 여행상품)">';
$cate_html .= '<span class="pg-field-hint-inline">(대분류 자동 생성)</span>';
$cate_html .= '</span></div>';

$image_html = '<div class="pg-input-unit pg-input-unit--inline-hint">';
$image_html .= '<select id="gen_image_count" class="pg-select pg-select--w-sm">';
$image_html .= '<option value="4" selected>4장 (기본)</option>';
$image_html .= '<option value="5">5장</option><option value="6">6장</option>';
$image_html .= '<option value="7">7장</option><option value="8">8장</option>';
$image_html .= '</select>';
$image_html .= '<span class="pg-field-hint-inline">(앞 4장: 목록/상세 썸네일, 5장 이상: Product Details에 추가 노출)</span>';
$image_html .= '</div>';

$count_html = '<div class="pg-input-unit pg-input-unit--inline-hint">';
$count_html .= '<input type="number" id="gen_count" value="3" min="1" max="100" class="pg-input pg-input--w-xs">';
$count_html .= '<span>개</span>';
$count_html .= '<span class="pg-field-hint-inline">(1~100, 많을수록 API 비용·시간 증가)</span>';
$count_html .= '</div>';
?>
<?php adm_ui_page_open('pg-ai-generate-screen'); ?>
<?php adm_ui_notice('키워드(성별·인종·계절·국가·종목 등)를 입력하면 제미나이 API가 상품명·가격·설명·이미지(4~8장/상품)를 자동 생성하여 등록합니다. 또한 의류·뷰티·주얼리·스포츠 등 모델 촬영 상품에 적용됩니다. 미선택 시 전체(제한 없음)입니다.', 'info'); ?>

<?php adm_ui_card_open('기본 조건'); ?>
<?php
adm_ui_field_row('성별', $gender_html, true, true);
adm_ui_field_row('모델선정', $ethnicity_html, false, true);
adm_ui_field_row('계절', $season_html, false, true);
adm_ui_field_row('국가', $country_html, false, true);
?>
<?php adm_ui_card_close(); ?>

<?php adm_ui_card_open('상품 종목 · 가격'); ?>
<?php
adm_ui_field_row('상품 종목', $types_html, true, true);
adm_ui_field_row('생성 가격', $price_html, true, true);
adm_ui_field_row('참고 내용', '<textarea id="memo" rows="12" class="pg-input pg-input--ai-memo" placeholder="예: 프리미엄 라인, 20~30대 타겟, 캐주얼 스타일"></textarea>', false, true);
?>
<?php adm_ui_card_close(); ?>

<?php adm_ui_card_open('생성 옵션'); ?>
<?php
adm_ui_field_row('생성 이미지', $image_html, false, true);
adm_ui_field_row('생성 수량', $count_html, true, true);
adm_ui_field_row('카테고리', $cate_html, true, true);
?>
<?php adm_ui_card_close(); ?>

<?php adm_ui_card_open('실행'); ?>
<?php adm_ui_form_actions(
	'<button type="button" id="btn_start" class="pg-btn pg-btn-primary" onclick="startGeneration();">AI 상품 생성 시작</button>'
	. '<button type="button" class="pg-btn" onclick="location.href=\'products.php\';">전체상품관리</button>'
); ?>
<?php adm_ui_card_close(); ?>

<?php adm_ui_card_open('생성 진행'); ?>
<div id="progress_idle" class="pg-screen-notice pg-screen-notice--info">AI 상품 생성을 시작하면 여기에 진행 상황이 표시됩니다.</div>
<div id="progress_area" class="pg-ai-progress" style="display:none;">
	<div class="pg-ai-progress-label">진행 상황</div>
	<div class="pg-ai-progress-track">
		<div id="progress_bar" class="pg-ai-progress-bar"></div>
	</div>
	<div id="progress_text" class="pg-ai-progress-text">대기 중...</div>
	<div id="log_area" class="pg-ai-log"></div>
</div>
<?php adm_ui_card_close(); ?>
<?php adm_ui_page_close(); ?>

<script>
var currentJobId = '';
var totalProducts = 0;
var isRunning = false;

function toggleEastAsianDetail() {
	var main = document.getElementById('model_ethnicity').value;
	var wrap = document.getElementById('east_asian_detail_wrap');
	wrap.style.display = (main === 'east_asian') ? '' : 'none';
	if (main !== 'east_asian') {
		document.getElementById('east_asian_detail').value = '';
	}
}

function resolveEthnicitiesForSubmit() {
	var main = document.getElementById('model_ethnicity').value;
	var detail = document.getElementById('east_asian_detail').value;
	var list = [];
	if (!main) {
		return list;
	}
	if (main === 'east_asian') {
		if (detail === 'mix') {
			list.push('mix_east_asian');
		} else if (detail) {
			list.push(detail);
		}
	} else {
		list.push(main);
	}
	return list;
}

function toggleCateMode() {
	var mode = document.getElementById('cate_mode').value;
	document.getElementById('cate_existing').style.display = (mode === 'existing') ? '' : 'none';
	document.getElementById('cate_new').style.display = (mode === 'new') ? '' : 'none';
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
	params.append('cate_mode', document.getElementById('cate_mode').value);
	params.append('code1', document.getElementById('code1').value);
	params.append('new_cate_name', document.getElementById('new_cate_name').value);
	params.append('code2', '00');
	params.append('code3', '00');
	params.append('code4', '00');

	document.querySelectorAll('input[name=product_types]:checked').forEach(function(el) {
		params.append('product_types[]', el.value);
	});

	params.append('model_ethnicity', document.getElementById('model_ethnicity').value);
	params.append('east_asian_detail', document.getElementById('east_asian_detail').value);

	resolveEthnicitiesForSubmit().forEach(function(val) {
		params.append('ethnicities[]', val);
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

	var cateMode = document.getElementById('cate_mode').value;
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
	document.getElementById('progress_idle').style.display = 'none';
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
