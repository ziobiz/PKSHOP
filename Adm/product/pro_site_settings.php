<?
include "../common/dbconn.php";
include "../inc/top_menu.php";
include "../inc/left_menu_product.php";
require_once dirname(__FILE__) . '/../../include/site_settings_lib.php';
require_once dirname(__FILE__) . '/../../include/icopay_settings_lib.php';
require_once dirname(__FILE__) . '/../../include/pkshop_promo_lib.php';
include "gemini_client.php";

$tab = isset($_GET['tab']) ? $_GET['tab'] : 'ai';
if (!in_array($tab, array('ai', 'brand', 'currency', 'payment', 'promo'), true)) {
	$tab = 'ai';
}
$s = pkshop_site_settings();
if ($tab === 'payment') {
	$s = pkshop_icopay_admin_form_values();
}
$currency_opts = pkshop_currency_options();
$api_key_status = gemini_api_key_status();
$enabled_codes = pkshop_currency_enabled_codes();
$icopay_secret_status = pkshop_icopay_broker_secret_status();
$icopay_mode_opts = pkshop_icopay_integration_mode_options();
$icopay_lang_opts = pkshop_icopay_checkout_lang_options();
$icopay_webhook_url = pkshop_icopay_webhook_url();
$interval_opts = pkshop_promo_rotate_interval_options();
$promo_best_sec = pkshop_promo_rotate_seconds('best');
$promo_recommended_sec = pkshop_promo_rotate_seconds('recommended');
$promo_all_sec = pkshop_promo_rotate_seconds('all');
?>
<script>
function postRun(data) {
	var body = (data instanceof URLSearchParams) ? data.toString() : new URLSearchParams(data).toString();
	return fetch('pro_ai_generate_run.php', {
		method: 'POST',
		credentials: 'same-origin',
		headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
		body: body
	}).then(function(r) { return r.json(); });
}
async function saveApiKey() {
	var key = document.getElementById('api_key_input').value.trim();
	if (!key) { alert('API 키를 입력하세요.'); return; }
	var res = await postRun({ action: 'save_api_key', api_key: key });
	if (res.error) { alert(res.error); return; }
	document.getElementById('api_key_masked').textContent = res.masked;
	document.getElementById('api_key_input').value = '';
	alert(res.message || 'API 키가 저장되었습니다.');
}
function syncPaymentCurrency() {
	var enabled = [];
	if (document.getElementById('currency_primary_enabled').checked) {
		enabled.push(document.getElementById('currency_primary_code').value);
	}
	if (document.getElementById('currency_secondary_enabled').checked) {
		var sec = document.getElementById('currency_secondary_code').value;
		if (enabled.indexOf(sec) < 0) enabled.push(sec);
	}
	var sel = document.getElementById('currency_payment_code');
	var current = sel.value;
	sel.innerHTML = '';
	for (var i = 0; i < enabled.length; i++) {
		var opt = document.createElement('option');
		opt.value = enabled[i];
		opt.textContent = enabled[i];
		if (enabled[i] === current) opt.selected = true;
		sel.appendChild(opt);
	}
	if (sel.options.length === 0) {
		var opt = document.createElement('option');
		opt.value = 'USD';
		opt.textContent = 'USD';
		sel.appendChild(opt);
	}
}
</script>
					<table width=900 border=0 cellpadding=0 cellspacing=0>
						<tr><td height=30></td></tr>
						<tr><td>
							<table border=0 cellpadding=0 cellspacing=0>
								<tr>
									<td width=60 align=center><img src="../image/icon2.gif" width=45 height=35 border=0></td>
									<td class='td14'><b>환경설정</b></td>
								</tr>
							</table>
						</td></tr>
						<tr><td height=10></td></tr>
						<tr>
							<td valign=top style="padding:10px;">
								<input type="button" value="A. AI 설정" class="adminbttn" onclick="location.href='pro_site_settings.php?tab=ai';"<?=$tab==='ai'?' style="font-weight:bold;"':''?>>
								<input type="button" value="B. 브랜드" class="adminbttn" onclick="location.href='pro_site_settings.php?tab=brand';"<?=$tab==='brand'?' style="font-weight:bold;"':''?>>
								<input type="button" value="C. 통화" class="adminbttn" onclick="location.href='pro_site_settings.php?tab=currency';"<?=$tab==='currency'?' style="font-weight:bold;"':''?>>
								<input type="button" value="D. 결제연동" class="adminbttn" onclick="location.href='pro_site_settings.php?tab=payment';"<?=$tab==='payment'?' style="font-weight:bold;"':''?>>
								<input type="button" value="E. 홍보설정" class="adminbttn" onclick="location.href='pro_site_settings.php?tab=promo';"<?=$tab==='promo'?' style="font-weight:bold;"':''?>>
								<br><br>

<? if ($tab === 'ai') { ?>
								<table width="860" border='0' cellspacing='0' cellpadding='0'>
									<tr><td colspan=2 height=2 bgcolor='#88B7DA'></td></tr>
									<tr><td colspan=2 style="padding:10px;background:#f9f9f9;font-weight:bold;">A. AI 설정 (제미나이 API)</td></tr>
									<tr>
										<td width="140" height="35" align="center">API 키</td>
										<td align="left" style="padding:10px;">
											현재: <span id="api_key_masked" style="font-family:monospace;color:#003366;">
<? if ($api_key_status['configured']) {
	echo htmlspecialchars($api_key_status['masked']);
} else { ?>
												<font color="#cc0000">미설정</font>
<? } ?>
											</span><br><br>
											<input type="password" id="api_key_input" size="50" class="adminbttn" placeholder="Google AI Studio API 키 (AIzaSy...)" autocomplete="off">
											<input type="button" value="API 키 저장" class="adminbttn" onclick="saveApiKey();">
											<font color="#666"> lib/gemini_secrets.local.php 에 저장됩니다.</font>
										</td>
									</tr>
									<tr><td colspan=2 style="padding:10px;">
										<font color="#003366">AI 상품 생성은 <a href="pro_ai_generate.php">AI 상품 생성</a> 메뉴에서 진행합니다.</font>
									</td></tr>
								</table>

<? } elseif ($tab === 'brand') { ?>
								<form method="post" action="pro_site_settings_ok.php" enctype="multipart/form-data">
								<input type="hidden" name="section" value="brand">
								<table width="860" border='0' cellspacing='0' cellpadding='0'>
									<tr><td colspan=2 height=2 bgcolor='#88B7DA'></td></tr>
									<tr><td colspan=2 style="padding:8px;background:#f9f9f9;font-weight:bold;">기본 / 브라우저</td></tr>
									<tr><td width="160" align="center">브라우저 타이틀</td><td style="padding:6px;"><input type="text" name="browser_title" value="<?=htmlspecialchars($s['browser_title'])?>" size="60" class="adminbttn"></td></tr>
									<tr><td align="center">페이지 타이틀</td><td style="padding:6px;"><input type="text" name="site_title" value="<?=htmlspecialchars($s['site_title'])?>" size="60" class="adminbttn"></td></tr>
									<tr><td align="center">OG 타이틀/설명</td><td style="padding:6px;">
										<input type="text" name="og_title" value="<?=htmlspecialchars($s['og_title'])?>" size="25" class="adminbttn">
										<input type="text" name="og_description" value="<?=htmlspecialchars($s['og_description'])?>" size="30" class="adminbttn">
									</td></tr>
									<tr><td align="center">파비콘</td><td style="padding:6px;">
										현재: <?=htmlspecialchars($s['favicon'])?><br>
										<input type="file" name="upload_favicon" class="adminbttn"> <font color="#666">권장 .ico (32×32)</font>
									</td></tr>

									<tr><td colspan=2 style="padding:8px;background:#f9f9f9;font-weight:bold;">상단 로고</td></tr>
									<tr><td align="center">PC 로고</td><td style="padding:6px;">
										현재: <?=htmlspecialchars($s['logo_pc'])?>
										가로 <input type="text" name="logo_pc_width" value="<?=htmlspecialchars($s['logo_pc_width'])?>" size="4" class="adminbttn"> px
										세로 <input type="text" name="logo_pc_height" value="<?=htmlspecialchars($s['logo_pc_height'])?>" size="4" class="adminbttn"> px<br>
										<input type="file" name="upload_logo_pc" class="adminbttn">
									</td></tr>
									<tr><td align="center">모바일 로고</td><td style="padding:6px;">
										현재: <?=htmlspecialchars($s['logo_mobile'])?>
										가로 <input type="text" name="logo_mobile_width" value="<?=htmlspecialchars($s['logo_mobile_width'])?>" size="4" class="adminbttn"> px
										세로 <input type="text" name="logo_mobile_height" value="<?=htmlspecialchars($s['logo_mobile_height'])?>" size="4" class="adminbttn"> px<br>
										<input type="file" name="upload_logo_mobile" class="adminbttn">
									</td></tr>

									<tr><td colspan=2 style="padding:8px;background:#f9f9f9;font-weight:bold;">메인 배너 (슬라이드 3장)</td></tr>
									<tr><td align="center">배너 권장 사이즈</td><td style="padding:6px;">
										가로 <input type="text" name="banner_width" value="<?=htmlspecialchars($s['banner_width'])?>" size="4" class="adminbttn"> ×
										세로 <input type="text" name="banner_height" value="<?=htmlspecialchars($s['banner_height'])?>" size="4" class="adminbttn"> px
									</td></tr>
<? for ($bi = 1; $bi <= 3; $bi++) { $bk = 'banner' . $bi; ?>
									<tr><td align="center">배너 <?=$bi?></td><td style="padding:6px;">
										현재: <?=htmlspecialchars($s[$bk])?><br>
										<input type="file" name="upload_<?=$bk?>" class="adminbttn">
									</td></tr>
<? } ?>
									<tr><td align="center">메인 문구</td><td style="padding:6px;">
										BEST <input type="text" name="main_welcome_best" value="<?=htmlspecialchars($s['main_welcome_best'])?>" size="50" class="adminbttn"><br>
										REC <input type="text" name="main_welcome_recommended" value="<?=htmlspecialchars($s['main_welcome_recommended'])?>" size="50" class="adminbttn"><br>
										ALL <input type="text" name="main_welcome_all" value="<?=htmlspecialchars($s['main_welcome_all'])?>" size="50" class="adminbttn">
									</td></tr>

									<tr><td colspan=2 style="padding:8px;background:#f9f9f9;font-weight:bold;">푸터 위 환영 배너 (메인 하단 story-box)</td></tr>
									<tr><td align="center">환영 배너 1</td><td style="padding:6px;">
										현재: <?=htmlspecialchars($s['footer_story_banner1'])?>
										<?php if (!empty($s['footer_story_banner1'])) { ?><br><img src="<?=htmlspecialchars($s['footer_story_banner1'])?>" alt="" style="max-width:320px;max-height:80px;margin:6px 0;"><?php } ?><br>
										<input type="file" name="upload_footer_story_banner1" class="adminbttn">
										<label><input type="checkbox" name="delete_footer_story_banner1" value="1"> 삭제</label>
										<font color="#666"> (푸터 顧客センター 블록 바로 위)</font>
									</td></tr>
									<tr><td align="center">환영 배너 2</td><td style="padding:6px;">
										현재: <?=htmlspecialchars($s['footer_story_banner2'])?>
										<?php if (!empty($s['footer_story_banner2'])) { ?><br><img src="<?=htmlspecialchars($s['footer_story_banner2'])?>" alt="" style="max-width:320px;max-height:80px;margin:6px 0;"><?php } ?><br>
										<input type="file" name="upload_footer_story_banner2" class="adminbttn">
										<label><input type="checkbox" name="delete_footer_story_banner2" value="1"> 삭제</label>
										<font color="#666"> (슬라이드 2번째, 선택)</font>
									</td></tr>
									<tr><td align="center">배너 고정 사이즈</td><td style="padding:6px;">
										가로 <input type="text" name="footer_story_banner_width" value="<?=htmlspecialchars($s['footer_story_banner_width'])?>" size="4" class="adminbttn"> px
										× 세로 <input type="text" name="footer_story_banner_height" value="<?=htmlspecialchars($s['footer_story_banner_height'])?>" size="4" class="adminbttn"> px
										<font color="#666"> 기본 1200 × 420</font>
									</td></tr>

									<tr><td colspan=2 style="padding:8px;background:#f9f9f9;font-weight:bold;">하단 정보 블록 (일본어 항목명·내용)</td></tr>
									<tr><td align="center">顧客センター</td><td style="padding:6px;">
										제목 <input type="text" name="footer_cs_title" value="<?=htmlspecialchars($s['footer_cs_title'])?>" size="20" class="adminbttn"><br>
										<input type="text" name="footer_cs_line1" value="<?=htmlspecialchars($s['footer_cs_line1'])?>" size="70" class="adminbttn"><br>
										<input type="text" name="footer_cs_line2" value="<?=htmlspecialchars($s['footer_cs_line2'])?>" size="70" class="adminbttn">
									</td></tr>
									<tr><td align="center">銀行口座情報</td><td style="padding:6px;">
										제목 <input type="text" name="footer_bank_title" value="<?=htmlspecialchars($s['footer_bank_title'])?>" size="20" class="adminbttn"><br>
										<input type="text" name="footer_bank_line1" value="<?=htmlspecialchars($s['footer_bank_line1'])?>" size="70" class="adminbttn"><br>
										<input type="text" name="footer_bank_line2" value="<?=htmlspecialchars($s['footer_bank_line2'])?>" size="70" class="adminbttn">
									</td></tr>
									<tr><td align="center">購入履歴情報</td><td style="padding:6px;">
										제목 <input type="text" name="footer_history_title" value="<?=htmlspecialchars($s['footer_history_title'])?>" size="20" class="adminbttn">
									</td></tr>
									<tr><td align="center">配送情報</td><td style="padding:6px;">
										제목 <input type="text" name="footer_delivery_title" value="<?=htmlspecialchars($s['footer_delivery_title'])?>" size="20" class="adminbttn"><br>
										<input type="text" name="footer_delivery_line1" value="<?=htmlspecialchars($s['footer_delivery_line1'])?>" size="70" class="adminbttn">
									</td></tr>
									<tr><td align="center">하단 링크</td><td style="padding:6px;">
										<input type="text" name="footer_link_home" value="<?=htmlspecialchars($s['footer_link_home'])?>" size="12" class="adminbttn">
										<input type="text" name="footer_link_terms" value="<?=htmlspecialchars($s['footer_link_terms'])?>" size="22" class="adminbttn">
										<input type="text" name="footer_link_policy" value="<?=htmlspecialchars($s['footer_link_policy'])?>" size="18" class="adminbttn">
									</td></tr>

									<tr><td colspan=2 style="padding:8px;background:#f9f9f9;font-weight:bold;">About company</td></tr>
									<tr><td align="center">회사 정보</td><td style="padding:6px;">
										<input type="text" name="footer_about_title" value="<?=htmlspecialchars($s['footer_about_title'])?>" size="20" class="adminbttn"> (섹션 제목)<br>
										회사명 <input type="text" name="footer_company_name" value="<?=htmlspecialchars($s['footer_company_name'])?>" size="40" class="adminbttn"><br>
										대표 <input type="text" name="footer_ceo" value="<?=htmlspecialchars($s['footer_ceo'])?>" size="30" class="adminbttn"><br>
										주소 <input type="text" name="footer_address" value="<?=htmlspecialchars($s['footer_address'])?>" size="70" class="adminbttn"><br>
										Tel <input type="text" name="footer_tel" value="<?=htmlspecialchars($s['footer_tel'])?>" size="20" class="adminbttn">
										Fax <input type="text" name="footer_fax" value="<?=htmlspecialchars($s['footer_fax'])?>" size="20" class="adminbttn"><br>
										사업자번호 <input type="text" name="footer_biz_no" value="<?=htmlspecialchars($s['footer_biz_no'])?>" size="20" class="adminbttn"><br>
										Copyright <input type="text" name="footer_copyright" value="<?=htmlspecialchars($s['footer_copyright'])?>" size="60" class="adminbttn">
									</td></tr>
									<tr><td align="center">약관 회사명</td><td style="padding:6px;">
										<input type="text" name="agree_company_name" value="<?=htmlspecialchars($s['agree_company_name'])?>" size="40" class="adminbttn">
										<font color="#666"> agree.php 내 회사명 치환</font><br>
										주소 <input type="text" name="agree_company_address" value="<?=htmlspecialchars($s['agree_company_address'])?>" size="60" class="adminbttn">
									</td></tr>
									<tr><td align="center">하단 아이콘·이미지</td><td style="padding:6px;">
										MY INFO <input type="file" name="upload_footer_icon_myinfo" class="adminbttn"> (현재: <?=htmlspecialchars($s['footer_icon_myinfo'])?>)<br>
										CART <input type="file" name="upload_footer_icon_cart" class="adminbttn"> (현재: <?=htmlspecialchars($s['footer_icon_cart'])?>)<br><br>
										<b>회사정보(About company) 아래 이미지</b><br>
										현재: <?=htmlspecialchars($s['footer_bottom_image'])?>
										<?php if (!empty($s['footer_bottom_image'])) { ?><br><img src="<?=htmlspecialchars($s['footer_bottom_image'])?>" alt="" style="max-width:320px;max-height:80px;margin:6px 0;"><?php } ?><br>
										<input type="file" name="upload_footer_bottom_image" class="adminbttn">
										<label><input type="checkbox" name="delete_footer_bottom_image" value="1"> 삭제</label><br>
										가로 <input type="text" name="footer_bottom_image_width" value="<?=htmlspecialchars($s['footer_bottom_image_width'])?>" size="4" class="adminbttn"> px
										× 세로 <input type="text" name="footer_bottom_image_height" value="<?=htmlspecialchars($s['footer_bottom_image_height'])?>" size="4" class="adminbttn"> px
										<font color="#666"> 가로 기본 1200px (0=자동높이)</font>
									</td></tr>

									<tr><td colspan=2 style="padding:8px;background:#f9f9f9;font-weight:bold;">현금결제 은행정보 (주문페이지)</td></tr>
									<tr><td align="center">은행 표시</td><td style="padding:6px;">
										<input type="text" name="payment_bank_line1" value="<?=htmlspecialchars($s['payment_bank_line1'])?>" size="70" class="adminbttn"><br>
										<input type="text" name="payment_bank_line2" value="<?=htmlspecialchars($s['payment_bank_line2'])?>" size="70" class="adminbttn"><br>
										<input type="text" name="payment_bank_line3" value="<?=htmlspecialchars($s['payment_bank_line3'])?>" size="70" class="adminbttn">
									</td></tr>

									<tr><td colspan=2 align="center" style="padding:15px;">
										<input type="submit" value="브랜드 설정 저장" class="adminbttn" style="padding:8px 20px;">
									</td></tr>
								</table>
								</form>

<? } elseif ($tab === 'currency') { ?>
								<form method="post" action="pro_site_settings_ok.php" onsubmit="syncPaymentCurrency();">
								<input type="hidden" name="section" value="currency">
								<table width="860" border='0' cellspacing='0' cellpadding='0'>
									<tr><td colspan=2 height=2 bgcolor='#88B7DA'></td></tr>
									<tr><td colspan=2 style="padding:10px;background:#f9f9f9;">
										<b>C. 통화 설정</b> — 상품 DB 가격은 USD 기준입니다. Yahoo Finance 환율로 변환·표시합니다.
									</td></tr>
									<tr>
										<td width="160" align="center">1차 통화</td>
										<td style="padding:8px;">
											<label><input type="checkbox" name="currency_primary_enabled" id="currency_primary_enabled" value="1" <?=$s['currency_primary_enabled']!=='0'?'checked':''?> onchange="syncPaymentCurrency();"></label>
											<select name="currency_primary_code" id="currency_primary_code" class="adminbttn" onchange="syncPaymentCurrency();">
<? foreach ($currency_opts as $code => $info) { ?>
												<option value="<?=$code?>" <?=$s['currency_primary_code']===$code?'selected':''?>><?=$info['label']?></option>
<? } ?>
											</select>
										</td>
									</tr>
									<tr>
										<td align="center">2차 통화</td>
										<td style="padding:8px;">
											<label><input type="checkbox" name="currency_secondary_enabled" id="currency_secondary_enabled" value="1" <?=$s['currency_secondary_enabled']!=='0'?'checked':''?> onchange="syncPaymentCurrency();"></label>
											<select name="currency_secondary_code" id="currency_secondary_code" class="adminbttn" onchange="syncPaymentCurrency();">
<? foreach ($currency_opts as $code => $info) { ?>
												<option value="<?=$code?>" <?=$s['currency_secondary_code']===$code?'selected':''?>><?=$info['label']?></option>
<? } ?>
											</select>
											<font color="#666">미사용 시 1개 통화만 노출·결제</font>
										</td>
									</tr>
									<tr>
										<td align="center">결제 기준 통화</td>
										<td style="padding:8px;">
											<select name="currency_payment_code" id="currency_payment_code" class="adminbttn">
<? foreach ($enabled_codes as $code) { ?>
												<option value="<?=$code?>" <?=$s['currency_payment_code']===$code?'selected':''?>><?=$code?> (ICOPAY·카드결제)</option>
<? } ?>
											</select>
											<font color="#666">노출 통화 중에서만 선택 가능</font>
										</td>
									</tr>
									<tr><td colspan=2 style="padding:10px;">
										예시 (USD 430 기준): <b><?=htmlspecialchars(pkshop_format_display_price(430))?></b><br>
										결제 금액 예시: <b><?=pkshop_format_currency_amount(pkshop_payment_amount_from_usd(430), pkshop_get_payment_currency())?></b>
									</td></tr>
									<tr><td colspan=2 align="center" style="padding:15px;">
										<input type="submit" value="통화 설정 저장" class="adminbttn" style="padding:8px 20px;">
									</td></tr>
								</table>
								</form>
								<script>syncPaymentCurrency();</script>
<? } elseif ($tab === 'payment') { ?>
								<form method="post" action="pro_site_settings_ok.php">
								<input type="hidden" name="section" value="payment">
								<table width="860" border='0' cellspacing='0' cellpadding='0'>
									<tr><td colspan=2 height=2 bgcolor='#88B7DA'></td></tr>
									<tr><td colspan=2 style="padding:10px;background:#f9f9f9;">
										<b>D. 결제연동 (ICOPAY)</b> — 카드결제·통합 인라인 체크아웃 설정입니다. 브로커 시크릿은 <code>lib/icopay_pg_secrets.local.php</code> 에 저장됩니다.
									</td></tr>
									<tr>
										<td width="180" align="center">결제 사용</td>
										<td style="padding:8px;">
											<label><input type="checkbox" name="payment_pg_enabled" value="1" <?=$s['payment_pg_enabled']!=='0'?'checked':''?>> ICOPAY 카드결제 활성화</label>
										</td>
									</tr>
									<tr>
										<td align="center">결제대행사</td>
										<td style="padding:8px;">
											<select name="payment_pg_provider" class="adminbttn">
												<option value="ICOPAY" <?=$s['payment_pg_provider']==='ICOPAY'?'selected':''?>>ICOPAY</option>
											</select>
										</td>
									</tr>
									<tr>
										<td align="center">가맹점 명칭</td>
										<td style="padding:8px;">
											<input type="text" name="icopay_merchant_name" value="<?=htmlspecialchars($s['icopay_merchant_name'], ENT_QUOTES, 'UTF-8')?>" size="40" class="adminbttn" placeholder="예: TESTING LIVE">
											<font color="#666">관리용 표시명</font>
										</td>
									</tr>
									<tr>
										<td align="center">업체코드 (compId)</td>
										<td style="padding:8px;">
											<input type="text" name="icopay_comp_id" value="<?=htmlspecialchars($s['icopay_comp_id'], ENT_QUOTES, 'UTF-8')?>" size="30" class="adminbttn" placeholder="6000000017">
										</td>
									</tr>
									<tr>
										<td align="center">브로커 시크릿</td>
										<td style="padding:8px;">
											현재: <span style="font-family:monospace;color:#003366;">
<? if ($icopay_secret_status['configured']) {
	echo htmlspecialchars($icopay_secret_status['masked'], ENT_QUOTES, 'UTF-8');
} else { ?>
												<font color="#cc0000">미설정</font>
<? } ?>
											</span><br><br>
											<input type="password" name="icopay_broker_secret" size="55" class="adminbttn" placeholder="ic_... (변경 시에만 입력)" autocomplete="off">
											<font color="#666">비워두면 기존 시크릿 유지</font>
										</td>
									</tr>
									<tr>
										<td align="center">API Base URL</td>
										<td style="padding:8px;">
											<input type="text" name="icopay_api_base_url" value="<?=htmlspecialchars($s['icopay_api_base_url'], ENT_QUOTES, 'UTF-8')?>" size="55" class="adminbttn">
										</td>
									</tr>
									<tr>
										<td align="center">연동 방식</td>
										<td style="padding:8px;">
											<select name="icopay_integration_mode" class="adminbttn">
<? foreach ($icopay_mode_opts as $mode_key => $mode_label) { ?>
												<option value="<?=htmlspecialchars($mode_key, ENT_QUOTES, 'UTF-8')?>" <?=$s['icopay_integration_mode']===$mode_key?'selected':''?>><?=htmlspecialchars($mode_label, ENT_QUOTES, 'UTF-8')?></option>
<? } ?>
											</select>
										</td>
									</tr>
									<tr>
										<td align="center">결제 통화</td>
										<td style="padding:8px;">
											<select name="icopay_payment_currency" class="adminbttn">
<? foreach ($currency_opts as $code => $info) { ?>
												<option value="<?=$code?>" <?=$s['icopay_payment_currency']===$code?'selected':''?>><?=$info['label']?></option>
<? } ?>
											</select>
											<font color="#666">ICOPAY prepare API currency (예: JPY)</font>
										</td>
									</tr>
									<tr>
										<td align="center">체크아웃 언어</td>
										<td style="padding:8px;">
											<select name="icopay_checkout_lang" class="adminbttn">
<? foreach ($icopay_lang_opts as $lang_key => $lang_label) { ?>
												<option value="<?=$lang_key?>" <?=$s['icopay_checkout_lang']===$lang_key?'selected':''?>><?=htmlspecialchars($lang_label, ENT_QUOTES, 'UTF-8')?></option>
<? } ?>
											</select>
										</td>
									</tr>
									<tr><td colspan=2 style="padding:8px;background:#f9f9f9;font-weight:bold;">JPAY / 레거시 (참고·ChillPay CCD)</td></tr>
									<tr>
										<td align="center">JPAY MID</td>
										<td style="padding:8px;">
											<input type="text" name="icopay_jpay_mid" value="<?=htmlspecialchars($s['icopay_jpay_mid'], ENT_QUOTES, 'UTF-8')?>" size="20" class="adminbttn" placeholder="10546">
											<font color="#666">관리 참고용 (통합 인라인은 ICOPAY가 PG 자동 선택)</font>
										</td>
									</tr>
									<tr>
										<td align="center">ChillPay MID</td>
										<td style="padding:8px;">
											<input type="text" name="icopay_ccd_merchant_code" value="<?=htmlspecialchars($s['icopay_ccd_merchant_code'], ENT_QUOTES, 'UTF-8')?>" size="30" class="adminbttn">
										</td>
									</tr>
									<tr>
										<td align="center">ChillPay API Key</td>
										<td style="padding:8px;">
											<input type="text" name="icopay_ccd_api_key" value="<?=htmlspecialchars($s['icopay_ccd_api_key'], ENT_QUOTES, 'UTF-8')?>" size="55" class="adminbttn">
										</td>
									</tr>
									<tr>
										<td align="center">ChillPay CCD 언어</td>
										<td style="padding:8px;">
											<input type="text" name="icopay_ccd_lang" value="<?=htmlspecialchars($s['icopay_ccd_lang'], ENT_QUOTES, 'UTF-8')?>" size="10" class="adminbttn" placeholder="en">
										</td>
									</tr>
									<tr><td colspan=2 style="padding:8px;background:#f9f9f9;font-weight:bold;">Webhook (ICOPAY 본사 등록)</td></tr>
									<tr>
										<td align="center">Webhook URL</td>
										<td style="padding:8px;">
											<input type="text" value="<?=htmlspecialchars($icopay_webhook_url, ENT_QUOTES, 'UTF-8')?>" size="65" class="adminbttn" readonly onclick="this.select();">
											<font color="#666">ICOPAY 업체관리 merchantNotifyUrls 에 등록</font>
										</td>
									</tr>
									<tr><td colspan=2 style="padding:10px;">
										상태:
<? if ($icopay_secret_status['configured'] && $s['icopay_comp_id'] !== '') { ?>
										<font color="#006600"><b>연동 준비됨</b></font> (compId <?=htmlspecialchars($s['icopay_comp_id'], ENT_QUOTES, 'UTF-8')?>, <?=htmlspecialchars($s['icopay_integration_mode'], ENT_QUOTES, 'UTF-8')?>)
<? } else { ?>
										<font color="#cc0000"><b>업체코드·브로커 시크릿을 입력 후 저장하세요.</b></font>
<? } ?>
									</td></tr>
									<tr><td colspan=2 align="center" style="padding:15px;">
										<input type="submit" value="결제연동 설정 저장" class="adminbttn" style="padding:8px 20px;">
									</td></tr>
								</table>
								</form>
<? } elseif ($tab === 'promo') { ?>
								<form method="post" action="pro_site_settings_ok.php">
								<input type="hidden" name="section" value="promo">
								<table width="860" border='0' cellspacing='0' cellpadding='0'>
									<tr><td colspan=2 height=2 bgcolor='#88B7DA'></td></tr>
									<tr><td colspan=2 style="padding:10px;background:#f9f9f9;font-weight:bold;">E. 홍보설정 (메인 순환 노출)</td></tr>
									<tr><td colspan=2 style="padding:8px 10px;color:#666;">
										메인 첫 화면의 <b>BEST</b>(4개), <b>RECOMMENDED</b>(8개), <b>All PRODUCTS</b> 영역이<br>
										등록된 상품·카테고리 풀에서 정해진 시간마다 순차적으로 교체되도록 설정합니다.
									</td></tr>
									<tr>
										<td width="220" align="center">BEST 순환 간격</td>
										<td style="padding:8px;">
											<select name="promo_rotate_best" class="adminbttn">
<? foreach ($interval_opts as $sec => $label) { ?>
												<option value="<?=$sec?>" <?=(string)$promo_best_sec===(string)$sec?'selected':''?>><?=htmlspecialchars($label, ENT_QUOTES, 'UTF-8')?> (화면 4개)</option>
<? } ?>
											</select>
										</td>
									</tr>
									<tr>
										<td align="center">RECOMMENDED 순환 간격</td>
										<td style="padding:8px;">
											<select name="promo_rotate_recommended" class="adminbttn">
<? foreach ($interval_opts as $sec => $label) { ?>
												<option value="<?=$sec?>" <?=(string)$promo_recommended_sec===(string)$sec?'selected':''?>><?=htmlspecialchars($label, ENT_QUOTES, 'UTF-8')?> (화면 8개)</option>
<? } ?>
											</select>
										</td>
									</tr>
									<tr>
										<td align="center">All PRODUCTS 순환 간격</td>
										<td style="padding:8px;">
											<select name="promo_rotate_all" class="adminbttn">
<? foreach ($interval_opts as $sec => $label) { ?>
												<option value="<?=$sec?>" <?=(string)$promo_all_sec===(string)$sec?'selected':''?>><?=htmlspecialchars($label, ENT_QUOTES, 'UTF-8')?> (카테고리별 4개)</option>
<? } ?>
											</select>
										</td>
									</tr>
									<tr><td colspan=2 style="padding:10px;color:#666;">
										※ BEST·RECOMMENDED는 테마 등록 상품이 지정 개수보다 많을 때 자동 순환합니다.<br>
										※ All PRODUCTS는 <a href="pro_all.php">ALL상품</a>에 등록한 카테고리별 4개씩 순환합니다.
									</td></tr>
									<tr><td colspan=2 align="center" style="padding:15px;">
										<input type="submit" value="홍보설정 저장" class="adminbttn" style="padding:8px 24px;">
									</td></tr>
								</table>
								</form>
<? } ?>
							</td>
						</tr>
						<tr><td height=40></td></tr>
					</table>
<? include "../inc/down_menu.php"; ?>
