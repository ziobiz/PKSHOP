<?
include "../common/dbconn.php";
include "../inc/top_menu.php";
include "../inc/left_menu_product.php";
include "category_lib.php";

$sel = pkshop_cate_init_selection($DB, $shop_cate, array(
    'cateuid1' => isset($_REQUEST['cateuid1']) ? $_REQUEST['cateuid1'] : '',
    'cateuid2' => isset($_REQUEST['cateuid2']) ? $_REQUEST['cateuid2'] : '',
    'cateuid3' => isset($_REQUEST['cateuid3']) ? $_REQUEST['cateuid3'] : '',
    'cateuid4' => isset($_REQUEST['cateuid4']) ? $_REQUEST['cateuid4'] : '',
));

$cate1 = $sel['cate1']; $cate2 = $sel['cate2']; $cate3 = $sel['cate3']; $cate4 = $sel['cate4'];
$code1 = $sel['code1']; $code2 = $sel['code2']; $code3 = $sel['code3']; $code4 = $sel['code4'];
$cateuid1 = $sel['cateuid1']; $cateuid2 = $sel['cateuid2']; $cateuid3 = $sel['cateuid3']; $cateuid4 = $sel['cateuid4'];

function pkshop_render_cate_panel($level, $title, $items, $sel, $DB, $shop_cate) {
    $lv = intval($level);
    $code1 = $sel['code1'];
    $code2 = $sel['code2'];
    $code3 = $sel['code3'];
    $parent_ready = pkshop_cate_parent_ready($lv, $code1, $code2, $code3);

    $cur_code = $sel['code' . $lv];
    $cur_cate = $sel['cate' . $lv];
    $cur_uid = $sel['cateuid' . $lv];
    $next_code = $parent_ready ? pkshop_cate_next_code($DB, $shop_cate, $lv, $code1, $code2, $code3) : '00';
    $form_code = ($cur_code !== '') ? $cur_code : $next_code;
    $catenum = count($items) + 1;
    $item_count = count($items);
?>
    <table class="cate-panel" width="280" border="1" cellspacing="0" cellpadding="8" bordercolor="#88B7DA" bgcolor="#D2DEE8" align="left">
        <tr>
            <td valign="top">
                <div class="cate-panel-title"><?=htmlspecialchars($title)?></div>
<? if (!$parent_ready && $lv > 1) { ?>
                <p class="cate-hint">상위 카테고리를 먼저 선택하세요.</p>
<? } else { ?>
                <table class="cate-list" width="100%" border="0" cellspacing="0" cellpadding="2">
                    <tr class="cate-head">
                        <td width="22"><a href="javascript:all_chk('<?=$lv?>')" class="cate-all">all</a></td>
                        <td>카테고리</td>
                        <td width="88" align="center">순서·관리</td>
                    </tr>
<? if ($item_count === 0) { ?>
                    <tr><td colspan="3" class="cate-empty">등록된 카테고리가 없습니다.</td></tr>
<? } ?>
<? foreach ($items as $pos => $item) {
    $ii = $item['index'];
    $uid = $item['uid'];
    $cate_view = htmlspecialchars(stripslashes($item['cate_name']), ENT_QUOTES, 'UTF-8');
    $cate_raw = htmlspecialchars($item['cate_name'], ENT_QUOTES, 'UTF-8');
    $item_code = htmlspecialchars($item['cate_code'], ENT_QUOTES, 'UTF-8');
    $hidden = (intval($item['cate_show']) === 1);
    $selected = ((string)$cur_uid === (string)$uid);
    $row_class = 'cate-row' . ($selected ? ' cate-row-selected' : '') . ($hidden ? ' cate-row-hidden' : '');
    $can_up = ($pos > 0);
    $can_down = ($pos < $item_count - 1);
?>
                    <tr class="<?=$row_class?>" id="cate-row-<?=$lv?>-<?=$uid?>" data-level="<?=$lv?>" data-uid="<?=$uid?>">
                        <td valign="top">
                            <input type="checkbox" name="catechk<?=$lv?><?=$ii?>" value="Y">
                        </td>
                        <td valign="top">
                            <span class="cate-code"><?=$item_code?></span>
                            <a href="javascript:selectcate('<?=$lv?>','<?=$uid?>')" class="cate-name" title="하위 카테고리 보기 / 수정 폼에 불러오기"><?=$cate_view?></a>
                            <? if ($hidden) { ?><span class="cate-badge-hidden">숨김</span><? } ?>
                            <input type="hidden" name="rank<?=$lv?><?=$ii?>" value="<?=$ii?>">
                        </td>
                        <td align="center" nowrap class="cate-actions">
                            <button type="button" class="cate-btn cate-btn-arrow" title="위로" data-action="move" data-dir="up" data-level="<?=$lv?>" data-uid="<?=$uid?>" <?=$can_up ? '' : 'disabled'?>>▲</button>
                            <button type="button" class="cate-btn cate-btn-arrow" title="아래로" data-action="move" data-dir="down" data-level="<?=$lv?>" data-uid="<?=$uid?>" <?=$can_down ? '' : 'disabled'?>>▼</button>
                            <button type="button" class="cate-btn" data-action="edit" data-level="<?=$lv?>" data-uid="<?=$uid?>" data-code="<?=$item_code?>" data-name="<?=$cate_raw?>">수정</button>
                            <button type="button" class="cate-btn <?=$hidden ? 'cate-btn-show' : 'cate-btn-hide'?>" data-action="toggle" data-level="<?=$lv?>" data-uid="<?=$uid?>"><?=$hidden ? '표시' : '숨김'?></button>
                            <button type="button" class="cate-btn cate-btn-del" data-action="delete" data-level="<?=$lv?>" data-uid="<?=$uid?>" data-name="<?=$cate_view?>">삭제</button>
                        </td>
                    </tr>
<? } ?>
                </table>
                <input type="hidden" name="catenum<?=$lv?>" value="<?=$catenum?>">

                <div class="cate-form-box">
                    <div class="cate-form-title">추가 / 수정</div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="2">
                        <tr>
                            <td width="70"><b>상품코드</b></td>
                            <td><input type="text" name="code<?=$lv?>" id="code<?=$lv?>" value="<?=htmlspecialchars($form_code, ENT_QUOTES, 'UTF-8')?>" size="4" maxlength="2" class="adminbttn"></td>
                        </tr>
                        <tr>
                            <td><b>카테고리명</b></td>
                            <td><input type="text" name="cate<?=$lv?>" id="cate<?=$lv?>" value="<?=htmlspecialchars($cur_cate, ENT_QUOTES, 'UTF-8')?>" size="18" maxlength="15" class="adminbttn"></td>
                        </tr>
                    </table>
                    <input type="hidden" name="cateuid<?=$lv?>" id="cateuid<?=$lv?>" value="<?=htmlspecialchars($cur_uid, ENT_QUOTES, 'UTF-8')?>">
                    <div class="cate-form-btns">
                        <input type="button" value="추가" class="adminbttn" onclick="go_up('<?=$lv?>')">
                        <input type="button" value="수정" class="adminbttn" onclick="go_modify('<?=$lv?>')">
                        <input type="button" value="선택 삭제" class="adminbttn" onclick="go_delete('<?=$lv?>')">
                    </div>
                </div>
<? } ?>
            </td>
        </tr>
    </table>
<?
}

$items1 = pkshop_cate_fetch_list($DB, $shop_cate, 1, $code1, $code2, $code3);
$items2 = pkshop_cate_parent_ready(2, $code1, $code2, $code3) ? pkshop_cate_fetch_list($DB, $shop_cate, 2, $code1, $code2, $code3) : array();
$items3 = pkshop_cate_parent_ready(3, $code1, $code2, $code3) ? pkshop_cate_fetch_list($DB, $shop_cate, 3, $code1, $code2, $code3) : array();
$items4 = pkshop_cate_parent_ready(4, $code1, $code2, $code3) ? pkshop_cate_fetch_list($DB, $shop_cate, 4, $code1, $code2, $code3) : array();
?>
<style>
.cate-panel { margin-bottom: 8px; font-size: 12px; }
.cate-panel-title { font-weight: bold; text-align: center; padding: 4px 0 10px; font-size: 13px; }
.cate-hint { color: #666; text-align: center; padding: 20px 8px; }
.cate-list { font-size: 11px; }
.cate-head td { font-weight: bold; border-bottom: 1px solid #88B7DA; padding-bottom: 4px; }
.cate-empty { color: #888; text-align: center; padding: 12px 4px; }
.cate-row td { border-bottom: 1px solid #c5d8e8; padding: 5px 2px; vertical-align: middle; }
.cate-row-selected { background: #fff8dc; }
.cate-row-hidden .cate-name { color: #999; text-decoration: line-through; }
.cate-code { display: inline-block; min-width: 22px; color: #336699; font-weight: bold; margin-right: 4px; }
.cate-name { color: #003366; text-decoration: none; }
.cate-name:hover { text-decoration: underline; }
.cate-badge-hidden { display: inline-block; margin-left: 4px; padding: 0 4px; background: #999; color: #fff; font-size: 10px; border-radius: 2px; }
.cate-actions { white-space: nowrap; line-height: 1.8; }
.cate-btn { font-size: 10px; padding: 1px 4px; margin: 1px 0; cursor: pointer; border: 1px solid #88B7DA; background: #fff; border-radius: 2px; }
.cate-btn:hover { background: #eef5fb; }
.cate-btn:disabled { opacity: 0.35; cursor: default; }
.cate-btn-arrow { font-size: 9px; padding: 0 5px; font-weight: bold; }
.cate-btn-del { color: #a00; border-color: #c99; }
.cate-btn-hide { color: #666; }
.cate-btn-show { color: #060; }
.cate-all { font-weight: bold; color: #003366; text-decoration: none; }
.cate-form-box { margin-top: 12px; padding-top: 10px; border-top: 1px dashed #88B7DA; background: #eaf1f7; padding: 8px; }
.cate-form-title { font-weight: bold; margin-bottom: 6px; color: #003366; }
.cate-form-btns { text-align: center; padding-top: 8px; }
.cate-columns { display: flex; flex-wrap: wrap; gap: 12px; align-items: flex-start; justify-content: flex-start; }
.cate-col-gap { width: 4px; }
</style>

<script language="javascript">
function go_up(i) {
    var codeEl = document.getElementById('code' + i);
    var cateEl = document.getElementById('cate' + i);
    if (!codeEl.value) { alert('상품코드를 입력하십시요'); return; }
    if (!cateEl.value) { alert('카테고리명을 입력하십시요'); return; }
    document.form.action = "category_post.php?cate=" + i;
    document.form.submit();
}
function go_modify(i) {
    var uidEl = document.getElementById('cateuid' + i);
    if (!uidEl.value) { alert('수정할 카테고리를 선택하거나 [수정] 버튼을 클릭하세요.'); return; }
    var codeEl = document.getElementById('code' + i);
    var cateEl = document.getElementById('cate' + i);
    if (!codeEl.value) { alert('상품코드를 입력하십시요'); return; }
    if (!cateEl.value) { alert('카테고리명을 입력하십시요'); return; }
    document.form.action = "category_modify.php?cate=" + i;
    document.form.submit();
}
function go_delete(i) {
    var chk = document.querySelector('input[name^="catechk' + i + '"]:checked');
    if (!chk) { alert('삭제할 카테고리 왼쪽 체크박스를 선택하세요.'); return; }
    if (!confirm('선택한 카테고리를 삭제하시겠습니까?')) return;
    document.form.action = "category_delete.php?cate=" + i;
    document.form.submit();
}
function selectcate(i, uid) {
    if (i == "1") {
        document.form.cateuid2.value = ""; document.form.code2.value = ""; document.form.cate2.value = "";
        document.form.cateuid3.value = ""; document.form.code3.value = ""; document.form.cate3.value = "";
        document.form.cateuid4.value = ""; document.form.code4.value = ""; document.form.cate4.value = "";
    } else if (i == "2") {
        document.form.cateuid3.value = ""; document.form.code3.value = ""; document.form.cate3.value = "";
        document.form.cateuid4.value = ""; document.form.code4.value = ""; document.form.cate4.value = "";
    } else if (i == "3") {
        document.form.cateuid4.value = ""; document.form.code4.value = ""; document.form.cate4.value = "";
    }
    document.getElementById('cateuid' + i).value = uid;
    document.form.action = "category.php?cate=" + i;
    document.form.submit();
}
function fillCateForm(level, uid, code, name) {
    document.getElementById('cateuid' + level).value = uid;
    document.getElementById('code' + level).value = code;
    document.getElementById('cate' + level).value = name;
    document.querySelectorAll('.cate-row').forEach(function(row) {
        row.classList.remove('cate-row-selected');
    });
    var row = document.getElementById('cate-row-' + level + '-' + uid);
    if (row) row.classList.add('cate-row-selected');
}
function all_chk(level) {
    var boxes = document.querySelectorAll('input[name^="catechk' + level + '"]');
    var allChecked = true;
    boxes.forEach(function(b) { if (!b.checked) allChecked = false; });
    boxes.forEach(function(b) { b.checked = !allChecked; });
}
function cateAjax(params, reloadOnOk) {
    var body = new URLSearchParams(params);
    body.append('code1', document.getElementById('code1') ? document.getElementById('code1').value : '');
    body.append('code2', document.getElementById('code2') ? document.getElementById('code2').value : '');
    body.append('code3', document.getElementById('code3') ? document.getElementById('code3').value : '');
    return fetch('category_ajax.php', {
        method: 'POST',
        credentials: 'same-origin',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: body.toString()
    }).then(function(r) { return r.json(); }).then(function(res) {
        if (!res.ok) { alert(res.message || '처리 실패'); return res; }
        if (reloadOnOk !== false) location.reload();
        return res;
    }).catch(function() { alert('통신 오류가 발생했습니다.'); });
}
</script>

<form name="form" method="post">
    <table width="1500" border="0" cellpadding="0" cellspacing="0">
        <tr><td height="30"></td></tr>
        <tr><td>
            <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="60" align="center"><img src="../image/icon1.gif" width="45" height="35" border="0"></td>
                    <td class="td14">&nbsp;<b>분류등록/수정</b></td>
                </tr>
            </table>
        </td></tr>
        <tr><td height="3"></td></tr>
        <tr>
            <td valign="top" align="left" style="padding-left:10px;">
                <div class="cate-columns">
<? pkshop_render_cate_panel(1, '1차 카테고리', $items1, $sel, $DB, $shop_cate); ?>
<? pkshop_render_cate_panel(2, '2차 카테고리', $items2, $sel, $DB, $shop_cate); ?>
<? pkshop_render_cate_panel(3, '3차 카테고리', $items3, $sel, $DB, $shop_cate); ?>
<? pkshop_render_cate_panel(4, '4차 카테고리', $items4, $sel, $DB, $shop_cate); ?>
                </div>

                <br>
                <table border="0" cellspacing="0" cellpadding="0" class="left_margin30">
                    <tr>
                        <td valign="top">
                            <p><b>이용방법</b><br><br></p>
                            <table width="900" border="0" cellspacing="1" cellpadding="0" bgcolor="#88B7DA">
                                <tr>
                                    <td bgcolor="#EBF0F4" style="padding:12px;">
                                        <p><b>카테고리 추가</b> : 상품코드와 카테고리명을 입력한 후 <b>추가</b> 버튼 클릭</p>
                                        <p><b>카테고리 수정</b> : 목록에서 <b>수정</b> 버튼 또는 카테고리명 클릭 → 코드·이름 수정 후 <b>수정</b> 버튼 클릭</p>
                                        <p><b>순서 변경</b> : 각 항목 옆 <b>▲ ▼</b> 화살표로 위·아래 이동 (우선순위 = 사이트 노출 순서)</p>
                                        <p><b>숨김/표시</b> : 항목 옆 <b>숨김</b>·<b>표시</b> 버튼으로 즉시 전환</p>
                                        <p><b>카테고리 삭제</b> : 항목 옆 <b>삭제</b> 버튼 또는 체크 후 하단 <b>선택 삭제</b> (전체 선택: <b>all</b>)</p>
                                    </td>
                                </tr>
                            </table>
                            <br><br>
                        </td>
                    </tr>
                </table>
                <table border="0" cellspacing="0" cellpadding="0" class="left_margin30">
                    <tr>
                        <td valign="top">
                            <p><b>이용 팁</b><br><br></p>
                            <table width="900" border="0" cellspacing="1" cellpadding="20" bgcolor="#88B7DA">
                                <tr>
                                    <td bgcolor="#EBF0F4">
                                        <p><b><font color="#990000">우선 순위란?</font></b> : 사이트에서 소개될 카테고리명의 순서</p>
                                        <p><b><font color="#990000">효과적인 상품코드 이용</font></b> :
                                        1,2,3,4차 카테고리별로 각각 두자리의 코드를 입력하실 수 있습니다. 이는 어떤 상품을 코드만 보고도 파악할 수 있도록 한 시스템입니다. 카테고리를 3차 까지 사용한 경우
                                        <font color="#990000">11</font><font color="#CC6633">22</font><font color="#339999">33</font><font color="#0000ff">44</font> (예) 의 코드가 발생하며 상품등록시 3자리의 코드를 추가 입력할 수 있도록
                                        하여 ( 카테고리당 999개까지 등록 가능 )<font color="#990000">11</font><font color="#CC6633">22</font><font color="#339999">33</font><font color="#0000ff">44</font>001(예)과 같이 9자리의 코드를 사용하실 수 있습니다. 상품 코드 체계를 먼저 설정하시고 사용하시면 효과적으로 사용하실 수 있습니다. 이 체계를 사용하지 않으셔도 무방합니다.</p>
                                    </td>
                                </tr>
                            </table>
                            <br><br>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr><td height="40"></td></tr>
    </table>
</form>

<? include "../inc/down_menu.php"; ?>

<script>
$(document).ready(function() {
    $(document).on('click', '.cate-btn[data-action="edit"]', function() {
        var $b = $(this);
        fillCateForm($b.data('level'), String($b.data('uid')), String($b.data('code')), String($b.data('name')));
    });
    $(document).on('click', '.cate-btn[data-action="move"]', function() {
        var $b = $(this);
        if ($b.prop('disabled')) return;
        cateAjax({ action: 'move', level: $b.data('level'), uid: $b.data('uid'), dir: $b.data('dir') });
    });
    $(document).on('click', '.cate-btn[data-action="toggle"]', function() {
        var $b = $(this);
        cateAjax({ action: 'toggle_show', level: $b.data('level'), uid: $b.data('uid') });
    });
    $(document).on('click', '.cate-btn[data-action="delete"]', function() {
        var $b = $(this);
        if (!confirm('[' + $b.data('name') + '] 카테고리를 삭제하시겠습니까?')) return;
        cateAjax({ action: 'delete_one', level: $b.data('level'), uid: $b.data('uid') });
    });
});
</script>
