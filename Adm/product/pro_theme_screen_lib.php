<?php
/**
 * 테마 상품 목록 화면 (HOT/BEST/추천 등) — PG 카드 UI 공통 렌더
 */

function pro_theme_screen_reset_codes($sel_cate) {
    if ($sel_cate === '' || $sel_cate === null) {
        return array('', '', '', '');
    }
    if ($sel_cate === '1') {
        return array(null, '', '', '');
    }
    if ($sel_cate === '2') {
        return array(null, null, '', '');
    }
    if ($sel_cate === '3') {
        return array(null, null, null, '');
    }
    return array(null, null, null, null);
}

function pro_theme_screen_cate_select($DB, $shop_cate, $level, $sel_code1, $sel_code2, $sel_code3, $sel_code4, $selected_code) {
    $labels = array(1 => '1차 카테고리', 2 => '2차 카테고리', 3 => '3차 카테고리', 4 => '4차 카테고리');
    $html = '<div class="pg-search-cell pg-search-cell--with-label">';
    $html .= '<span class="pg-search-cell-label">' . adm_ui_h($labels[$level]) . '</span>';
    $html .= '<div class="pg-search-cell-input"><select name="sel_code' . $level . '" class="pg-select" onchange="proThemeGoSelect(' . $level . ');">';
    $html .= '<option value="">전체</option>';

    if ($level === 1) {
        $query = "SELECT cate1,code1 FROM {$shop_cate} WHERE code1<>'00' AND code2='00' AND code3='00' AND code4='00' ORDER BY rank";
    } elseif ($level === 2) {
        $query = "SELECT cate2,code2 FROM {$shop_cate} WHERE code1='" . addslashes($sel_code1) . "' AND code2!='00' AND code3='00' AND code4='00' ORDER BY rank";
    } elseif ($level === 3) {
        $query = "SELECT cate3,code3 FROM {$shop_cate} WHERE code1='" . addslashes($sel_code1) . "' AND code2='" . addslashes($sel_code2) . "' AND code3!='00' AND code4='00' ORDER BY rank";
    } else {
        $query = "SELECT cate4,code4 FROM {$shop_cate} WHERE code1='" . addslashes($sel_code1) . "' AND code2='" . addslashes($sel_code2) . "' AND code3='" . addslashes($sel_code3) . "' AND code4!='00' ORDER BY rank";
    }

    $DB->get($query, $rs, $rn);
    for ($i = 0; $i < $rn; $i++) {
        $cate = htmlspecialchars(stripslashes($rs[$i][0]), ENT_QUOTES, 'UTF-8');
        $g_code = $rs[$i][1];
        $oselect = ((string) $selected_code === (string) $g_code) ? ' selected' : '';
        $html .= '<option value="' . adm_ui_h($g_code) . '"' . $oselect . '>' . $cate . '</option>';
    }
    $html .= '</select></div></div>';
    return $html;
}

function pro_theme_screen_goods_options($DB, $shop_goods, $theme_col, $sel_code1, $sel_code2, $sel_code3, $sel_code4) {
    $html = '';
    $c1 = addslashes($sel_code1);
    $c2 = addslashes($sel_code2);
    $c3 = addslashes($sel_code3);
    $c4 = addslashes($sel_code4);
    $query = "SELECT code,title,{$theme_col} FROM {$shop_goods} "
        . "WHERE (code1='{$c1}' OR code2='{$c2}' OR code3='{$c3}' OR code4='{$c4}') AND soldout<>'Y' ORDER BY signdate DESC";
    $DB->get($query, $rs, $rn);
    for ($i = 0; $i < $rn; $i++) {
        $g_code = $rs[$i][0];
        $title = htmlspecialchars(stripslashes($rs[$i][1]), ENT_QUOTES, 'UTF-8');
        $theme_val = $rs[$i][2];
        $html .= '<option value="' . adm_ui_h($theme_val . $g_code) . '">' . $title . '</option>';
    }
    return $html;
}

function pro_theme_screen_render($DB, $shop_cate, $shop_goods, $config) {
    $theme = $config['theme'];
    $theme_col = $config['theme_col'];
    $rank_col = $config['rank_col'];
    $page_title = $config['page_title'];
    $self_php = $config['self_php'];
    $add_label = isset($config['add_label']) ? $config['add_label'] : ($page_title . ' 추가');

    $sel_cate = isset($_REQUEST['sel_cate']) ? $_REQUEST['sel_cate'] : '';
    list($r1, $r2, $r3, $r4) = pro_theme_screen_reset_codes($sel_cate);
    if ($r1 === '') $sel_code1 = '';
    if ($r2 === '') $sel_code2 = '';
    if ($r3 === '') $sel_code3 = '';
    if ($r4 === '') $sel_code4 = '';

    $query = "SELECT code,code1,code2,code3,title,currnum,pricec,{$rank_col},code4,order4,No "
        . "FROM {$shop_goods} WHERE {$theme_col}='{$theme}' ORDER BY {$rank_col} ASC, signdate DESC";
    $DB->get($query, $rs, $rn);
    $total_record = $rn;

    $page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
    $per_page_info = adm_ui_resolve_per_page();
    $pg = adm_ui_paginate_slice($total_record, $page, $per_page_info);
    $theme_list_mode = 'sel_cate=' . urlencode($sel_cate)
        . '&sel_code1=' . urlencode($sel_code1)
        . '&sel_code2=' . urlencode($sel_code2)
        . '&sel_code3=' . urlencode($sel_code3)
        . '&sel_code4=' . urlencode($sel_code4)
        . '&p_num=' . rawurlencode(adm_ui_per_page_query_value($per_page_info));
    $page_per_block = 10;
?>
<script language="javascript">
Array.prototype.indexOf = Array.prototype.indexOf || function(obj) {
    for (var i = 0, length = this.length; i < length; i++) {
        if (this[i] == obj) return i;
    }
    return -1;
};
function proThemeGoSelect(i) {
    document.form.sel_cate.value = i;
    document.form.action = <?=json_encode($self_php)?>;
    document.form.submit();
}
function proThemeGoDel() {
    document.form.action = "pro_theme_del.php?theme=<?=adm_ui_h($theme)?>";
    document.form.submit();
}
function proThemeGoRank(num) {
    var tmp_total = [], temp = "";
    num = parseInt(num, 10);
    for (var i = 1; i < num; i++) {
        temp = document.form['rank' + i].value;
        if (temp !== "") {
            temp = temp.substring(0, 2);
            if (tmp_total.indexOf(temp) > -1) {
                alert("우선순위를 다시 선택하세요");
                return;
            }
            tmp_total.push(temp);
        }
    }
    document.form.action = "pro_theme_rank.php?theme=<?=adm_ui_h($theme)?>&rank_num=" + num;
    document.form.submit();
}
function proThemeGoAdd() {
    if (!document.form.sel_goods.value) {
        alert("추가할 상품을 선택하세요.");
        return;
    }
    document.form.action = "pro_theme_add.php?theme=<?=adm_ui_h($theme)?>";
    document.form.submit();
}
function proThemeAllChk() {
    var boxes = document.querySelectorAll('input[name^="check"]');
    var allChecked = true;
    boxes.forEach(function(b) { if (!b.checked) allChecked = false; });
    boxes.forEach(function(b) { b.checked = !allChecked; });
}
</script>

<?php adm_ui_page_open('pg-products-screen'); ?>
<form name="form" method="post">
<input type="hidden" name="sel_cate" value="<?=adm_ui_h($sel_cate)?>">

<?php adm_ui_card_open($add_label); ?>
<div class="pg-screen-search-form pg-products-search-form">
    <div class="pg-search-form-row pg-search-form-row--cate">
<?=pro_theme_screen_cate_select($DB, $shop_cate, 1, $sel_code1, $sel_code2, $sel_code3, $sel_code4, $sel_code1)?>
<?=pro_theme_screen_cate_select($DB, $shop_cate, 2, $sel_code1, $sel_code2, $sel_code3, $sel_code4, $sel_code2)?>
<?=pro_theme_screen_cate_select($DB, $shop_cate, 3, $sel_code1, $sel_code2, $sel_code3, $sel_code4, $sel_code3)?>
<?=pro_theme_screen_cate_select($DB, $shop_cate, 4, $sel_code1, $sel_code2, $sel_code3, $sel_code4, $sel_code4)?>
        <div class="pg-search-cell pg-search-cell--with-label">
            <span class="pg-search-cell-label">상품</span>
            <div class="pg-search-cell-input">
                <select name="sel_goods" class="pg-select">
                    <option value="">상품 선택</option>
                    <?=pro_theme_screen_goods_options($DB, $shop_goods, $theme_col, $sel_code1, $sel_code2, $sel_code3, $sel_code4)?>
                </select>
            </div>
        </div>
        <div class="pg-search-actions">
            <button type="button" class="pg-btn pg-btn-primary" onclick="proThemeGoAdd()">추가</button>
        </div>
    </div>
</div>
<?php adm_ui_card_close(); ?>

<?php adm_ui_card_open($page_title . ' 목록'); ?>
<div class="pg-summary-total-bar" style="margin-bottom:12px;">
    <?php adm_ui_per_page_bar($self_php, $theme_list_mode, $per_page_info, $total_record); ?>
    <span style="margin-left:auto;display:flex;gap:8px;flex-wrap:wrap;">
        <button type="button" class="pg-btn pg-btn-outline" onclick="proThemeGoDel()">목록에서 제외</button>
        <button type="button" class="pg-btn pg-btn-primary" onclick="proThemeGoRank('<?=(int)$pg['page_count'] + 1?>')">우선순위변경</button>
    </span>
</div>

<div class="pg-table-responsive">
<table class="pg-data-grid pg-theme-list-grid">
    <thead>
        <tr>
            <th class="pg-col-num">번호</th>
            <th class="pg-col-code">상품코드</th>
            <th class="pg-col-title">상품명</th>
            <th class="pg-col-price">판매가격</th>
            <th class="pg-col-qty">현재수량</th>
            <th class="pg-col-rank">우선순위</th>
            <th class="pg-col-check"><a href="javascript:proThemeAllChk()" class="cate-all" title="전체 선택">all</a></th>
        </tr>
    </thead>
    <tbody>
<?php
    if ($total_record < 1) {
        echo '<tr><td colspan="7" class="pg-table-empty">등록된 상품이 없습니다.</td></tr>';
    }
    $page_row_count = 0;
    for ($i = $pg['first']; $i <= $pg['last']; $i++) {
        $page_row_count++;
        $code = $rs[$i][0];
        $title = htmlspecialchars(stripslashes($rs[$i][4]), ENT_QUOTES, 'UTF-8');
        $currnum = $rs[$i][5];
        $pricec = $rs[$i][6];
        $rank = $rs[$i][7];
        $No = $rs[$i][10];
        if ($rank === '9') $rank = '';
        $ii = $page_row_count;
        $display_num = $i + 1;
?>
        <tr>
            <td class="pg-col-num text-center"><?=$display_num?></td>
            <td class="pg-col-code text-center"><?=adm_ui_h($code)?></td>
            <td class="pg-col-title"><a href="pro_info.php?sel_theme=<?=adm_ui_h($theme)?>&code=<?=urlencode($code)?>&No=<?=(int)$No?>"><?=$title?></a></td>
            <td class="pg-col-price text-center"><?=adm_ui_h($pricec)?></td>
            <td class="pg-col-qty text-center"><?=adm_ui_h($currnum)?></td>
            <td class="pg-col-rank text-center">
                <select name="rank<?=$ii?>" class="pg-select" style="min-width:64px;">
<?php for ($j = 1; $j <= $total_record; $j++) { ?>
                    <option value="<?=$j?>" <?=$ii == $j ? 'selected' : ''?>><?=$j?></option>
<?php } ?>
                </select>
                <input type="hidden" name="code<?=$ii?>" value="<?=adm_ui_h($code)?>">
            </td>
            <td class="pg-col-check text-center"><input type="checkbox" name="check<?=$ii?>" value="<?=adm_ui_h($code)?>"></td>
        </tr>
<?php
    }
?>
    </tbody>
</table>
</div>
<?php
    if ($pg['total_page'] > 1) {
        adm_ui_pagination(adm_ui_mode_with_pnum($theme_list_mode, $per_page_info), $pg['page'], $pg['total_page'], $page_per_block, $pg['is_next']);
    }
?>
<input type="hidden" name="sel_theme" value="<?=adm_ui_h($theme)?>">
<input type="hidden" name="sel_num" value="<?=(int)$page_row_count?>">
<input type="hidden" name="p_num" value="<?=adm_ui_h(adm_ui_per_page_query_value($per_page_info))?>">
<input type="hidden" name="page" value="<?=(int)$pg['page']?>">
<?php adm_ui_card_close(); ?>
</form>
<?php adm_ui_page_close(); ?>
<?php
}
