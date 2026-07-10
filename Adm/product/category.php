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

function pkshop_render_cate_panel($level, $title, $short_label, $items, $sel, $DB, $shop_cate) {
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
    $panel_class = 'cate-col cate-col--lv' . $lv;
    if (!$parent_ready && $lv > 1) $panel_class .= ' is-locked';
    if ($cur_uid !== '') $panel_class .= ' has-selection';
?>
<section class="<?=$panel_class?>" data-level="<?=$lv?>">
    <header class="cate-col-head">
        <span class="cate-level-badge"><?=$lv?>차</span>
        <h3 class="cate-col-title"><?=htmlspecialchars($title, ENT_QUOTES, 'UTF-8')?></h3>
        <span class="cate-col-count"><?=$item_count?>건</span>
    </header>
    <div class="cate-col-body">
<? if (!$parent_ready && $lv > 1) { ?>
        <p class="cate-hint"><span class="cate-hint-icon">↑</span> 상위 <?=$lv - 1?>차 카테고리를 먼저 선택하세요.</p>
<? } else { ?>
        <div class="cate-list-head">
            <span class="cate-list-head-check"><a href="javascript:all_chk('<?=$lv?>')" class="cate-all" title="전체 선택">all</a></span>
            <span class="cate-list-head-name">카테고리명</span>
            <span class="cate-list-head-actions">관리</span>
        </div>
        <ul class="cate-item-list">
<? if ($item_count === 0) { ?>
            <li class="cate-item cate-item--empty">등록된 카테고리가 없습니다.</li>
<? } ?>
<? foreach ($items as $pos => $item) {
    $ii = $item['index'];
    $uid = $item['uid'];
    $cate_view = htmlspecialchars(stripslashes($item['cate_name']), ENT_QUOTES, 'UTF-8');
    $cate_raw = htmlspecialchars($item['cate_name'], ENT_QUOTES, 'UTF-8');
    $item_code = htmlspecialchars($item['cate_code'], ENT_QUOTES, 'UTF-8');
    $hidden = (intval($item['cate_show']) === 1);
    $selected = ((string)$cur_uid === (string)$uid);
    $row_class = 'cate-item cate-row' . ($selected ? ' cate-row-selected' : '') . ($hidden ? ' cate-row-hidden' : '');
    $can_up = ($pos > 0);
    $can_down = ($pos < $item_count - 1);
?>
            <li class="<?=$row_class?>" id="cate-row-<?=$lv?>-<?=$uid?>" data-level="<?=$lv?>" data-uid="<?=$uid?>">
                <label class="cate-item-check">
                    <input type="checkbox" name="catechk<?=$lv?><?=$ii?>" value="Y">
                </label>
                <div class="cate-item-main">
                    <a href="javascript:selectcate('<?=$lv?>','<?=$uid?>')" class="cate-name" title="<?=htmlspecialchars($cate_view, ENT_QUOTES, 'UTF-8')?> — 하위 보기 / 수정">
                        <span class="cate-code"><?=$item_code?></span>
                        <span class="cate-name-text"><?=$cate_view?></span>
                    </a>
                    <? if ($hidden) { ?><span class="cate-badge-hidden">숨김</span><? } ?>
                    <input type="hidden" name="rank<?=$lv?><?=$ii?>" value="<?=$ii?>">
                </div>
                <div class="cate-actions">
                    <button type="button" class="cate-btn cate-btn-arrow" title="위로" data-action="move" data-dir="up" data-level="<?=$lv?>" data-uid="<?=$uid?>" <?=$can_up ? '' : 'disabled'?>>▲</button>
                    <button type="button" class="cate-btn cate-btn-arrow" title="아래로" data-action="move" data-dir="down" data-level="<?=$lv?>" data-uid="<?=$uid?>" <?=$can_down ? '' : 'disabled'?>>▼</button>
                    <button type="button" class="cate-btn" data-action="edit" data-level="<?=$lv?>" data-uid="<?=$uid?>" data-code="<?=$item_code?>" data-name="<?=$cate_raw?>">수정</button>
                    <button type="button" class="cate-btn <?=$hidden ? 'cate-btn-show' : 'cate-btn-hide'?>" data-action="toggle" data-level="<?=$lv?>" data-uid="<?=$uid?>"><?=$hidden ? '표시' : '숨김'?></button>
                    <button type="button" class="cate-btn cate-btn-del" data-action="delete" data-level="<?=$lv?>" data-uid="<?=$uid?>" data-name="<?=$cate_view?>">삭제</button>
                </div>
            </li>
<? } ?>
        </ul>
        <input type="hidden" name="catenum<?=$lv?>" value="<?=$catenum?>">

        <div class="cate-form-box">
            <div class="cate-form-title">추가 / 수정</div>
            <div class="cate-form-grid">
                <label class="cate-form-field">
                    <span class="cate-form-label">코드</span>
                    <input type="text" name="code<?=$lv?>" id="code<?=$lv?>" value="<?=htmlspecialchars($form_code, ENT_QUOTES, 'UTF-8')?>" maxlength="2" class="pg-input cate-input-code">
                </label>
                <label class="cate-form-field cate-form-field--grow">
                    <span class="cate-form-label">카테고리명</span>
                    <input type="text" name="cate<?=$lv?>" id="cate<?=$lv?>" value="<?=htmlspecialchars($cur_cate, ENT_QUOTES, 'UTF-8')?>" maxlength="15" class="pg-input">
                </label>
            </div>
            <input type="hidden" name="cateuid<?=$lv?>" id="cateuid<?=$lv?>" value="<?=htmlspecialchars($cur_uid, ENT_QUOTES, 'UTF-8')?>">
            <div class="cate-form-btns">
                <button type="button" class="pg-btn pg-btn-primary" onclick="go_up('<?=$lv?>')">추가</button>
                <button type="button" class="pg-btn" onclick="go_modify('<?=$lv?>')">수정</button>
                <button type="button" class="pg-btn pg-btn-danger" onclick="go_delete('<?=$lv?>')">선택 삭제</button>
            </div>
        </div>
<? } ?>
    </div>
</section>
<? if ($lv < 4) { ?><div class="cate-flow-arrow" aria-hidden="true">›</div><? } ?>
<?
}

$items1 = pkshop_cate_fetch_list($DB, $shop_cate, 1, $code1, $code2, $code3);
$items2 = pkshop_cate_parent_ready(2, $code1, $code2, $code3) ? pkshop_cate_fetch_list($DB, $shop_cate, 2, $code1, $code2, $code3) : array();
$items3 = pkshop_cate_parent_ready(3, $code1, $code2, $code3) ? pkshop_cate_fetch_list($DB, $shop_cate, 3, $code1, $code2, $code3) : array();
$items4 = pkshop_cate_parent_ready(4, $code1, $code2, $code3) ? pkshop_cate_fetch_list($DB, $shop_cate, 4, $code1, $code2, $code3) : array();

$cate_path_parts = array();
if ($cate1 !== '') $cate_path_parts[] = '1차: ' . htmlspecialchars(stripslashes($cate1), ENT_QUOTES, 'UTF-8') . ($code1 !== '' ? ' (' . $code1 . ')' : '');
if ($cate2 !== '') $cate_path_parts[] = '2차: ' . htmlspecialchars(stripslashes($cate2), ENT_QUOTES, 'UTF-8') . ($code2 !== '' ? ' (' . $code2 . ')' : '');
if ($cate3 !== '') $cate_path_parts[] = '3차: ' . htmlspecialchars(stripslashes($cate3), ENT_QUOTES, 'UTF-8') . ($code3 !== '' ? ' (' . $code3 . ')' : '');
if ($cate4 !== '') $cate_path_parts[] = '4차: ' . htmlspecialchars(stripslashes($cate4), ENT_QUOTES, 'UTF-8') . ($code4 !== '' ? ' (' . $code4 . ')' : '');
?>
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

<?php adm_ui_page_open('pg-cate-screen'); ?>
<form name="form" method="post">
<input type="hidden" name="code1" id="code1" value="<?=htmlspecialchars($code1, ENT_QUOTES, 'UTF-8')?>">
<input type="hidden" name="code2" id="code2" value="<?=htmlspecialchars($code2, ENT_QUOTES, 'UTF-8')?>">
<input type="hidden" name="code3" id="code3" value="<?=htmlspecialchars($code3, ENT_QUOTES, 'UTF-8')?>">
<input type="hidden" name="code4" id="code4" value="<?=htmlspecialchars($code4, ENT_QUOTES, 'UTF-8')?>">
<?php adm_ui_card_open('분류 등록 / 수정'); ?>

<nav class="cate-path-bar" aria-label="선택 경로">
    <span class="cate-path-label">현재 경로</span>
<? if (count($cate_path_parts) > 0) { ?>
    <? foreach ($cate_path_parts as $idx => $part) { ?>
    <span class="cate-path-sep"><?=$idx > 0 ? '›' : ''?></span>
    <span class="cate-path-item"><?=$part?></span>
    <? } ?>
<? } else { ?>
    <span class="cate-path-empty">1차 카테고리부터 선택하세요</span>
<? } ?>
</nav>

<p class="cate-guide">왼쪽에서 <strong>1차 → 2차 → 3차 → 4차</strong> 순으로 선택하면 하위 분류가 열립니다. 카테고리명을 클릭하면 하위 목록이 표시됩니다.</p>

<div class="cate-cascade">
<? pkshop_render_cate_panel(1, '대분류', '1차', $items1, $sel, $DB, $shop_cate); ?>
<? pkshop_render_cate_panel(2, '중분류', '2차', $items2, $sel, $DB, $shop_cate); ?>
<? pkshop_render_cate_panel(3, '소분류', '3차', $items3, $sel, $DB, $shop_cate); ?>
<? pkshop_render_cate_panel(4, '세분류', '4차', $items4, $sel, $DB, $shop_cate); ?>
</div>
<?php adm_ui_card_close(); ?>

<?php adm_ui_card_open('이용 안내'); ?>
                <p><b>이용방법</b></p>
                <ul class="pg-help-list">
                    <li><b>카테고리 추가</b> : 상품코드와 카테고리명을 입력한 후 <b>추가</b> 버튼 클릭</li>
                    <li><b>카테고리 수정</b> : 목록에서 <b>수정</b> 버튼 또는 카테고리명 클릭 → 코드·이름 수정 후 <b>수정</b> 버튼 클릭</li>
                    <li><b>순서 변경</b> : 각 항목 옆 <b>▲ ▼</b> 화살표로 위·아래 이동</li>
                    <li><b>숨김/표시</b> : 항목 옆 <b>숨김</b>·<b>표시</b> 버튼으로 즉시 전환</li>
                    <li><b>카테고리 삭제</b> : 항목 옆 <b>삭제</b> 버튼 또는 체크 후 <b>선택 삭제</b></li>
                </ul>
                <p><b>이용 팁</b> — 우선순위는 사이트 노출 순서입니다. 1~4차 카테고리별 두 자리 코드 체계(예: 11223344001)를 사용하면 상품 관리가 편리합니다.</p>
<?php adm_ui_card_close(); ?>
</form>
<?php adm_ui_page_close(); ?>

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
