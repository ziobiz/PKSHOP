<?php
/**
 * PKSHOP Admin — PG-style card form / list UI helpers.
 */

function adm_ui_h($s) {
    return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8');
}

function adm_ui_page_open($extra_class = '') {
    $cls = 'adm-content-panel-inner pg-comp-reg-form';
    if ($extra_class !== '') {
        $cls .= ' ' . $extra_class;
    }
    echo '<div class="' . adm_ui_h($cls) . '">' . "\n";
}

function adm_ui_page_close() {
    echo "</div><!-- adm-content-panel-inner -->\n";
}

function adm_ui_card_open($title, $extra_class = '', $id = '') {
    $cls = 'pg-card mb-3';
    if ($extra_class !== '') {
        $cls .= ' ' . $extra_class;
    }
    $id_attr = ($id !== '') ? ' id="' . adm_ui_h($id) . '"' : '';
    echo '<section class="' . adm_ui_h($cls) . '"' . $id_attr . '>' . "\n";
    echo '<div class="pg-card-header">' . adm_ui_h($title) . '</div>' . "\n";
    echo '<div class="pg-card-body">' . "\n";
}

function adm_ui_card_close() {
    echo "</div></section>\n";
}

function adm_ui_form_actions($html) {
    echo '<div class="pg-form-actions">' . $html . '</div>' . "\n";
}

function adm_ui_field_row($label, $content, $required = false, $stacked = false) {
    $star = $required ? ' <span class="pg-required">*</span>' : '';
    $cls = 'pg-form-field';
    if ($stacked) {
        $cls .= ' pg-form-field--stacked';
    }
    echo '<div class="' . $cls . '">';
    echo '<label class="pg-form-label">' . adm_ui_h($label) . $star . '</label>';
    echo '<div class="pg-form-control">' . $content . '</div>';
    echo '</div>' . "\n";
}

function adm_ui_notice($text, $type = 'info') {
    echo '<div class="pg-screen-notice pg-screen-notice--' . adm_ui_h($type) . '">' . $text . '</div>' . "\n";
}

/** 환경설정: 한 열 세로 묶음 (라벨 위 · 입력 아래) */
function adm_ui_settings_col_open($extra_class = '') {
    $cls = 'pg-settings-col';
    if ($extra_class !== '') {
        $cls .= ' ' . $extra_class;
    }
    echo '<div class="' . adm_ui_h($cls) . '">' . "\n";
}

function adm_ui_settings_col_close() {
    echo "</div><!-- pg-settings-col -->\n";
}

/** 환경설정: 한 줄 가로 묶음 (각 필드 라벨 위 · 입력 아래) */
function adm_ui_settings_row_open($extra_class = '') {
    $cls = 'pg-settings-field-row';
    if ($extra_class !== '') {
        $cls .= ' ' . $extra_class;
    }
    echo '<div class="' . adm_ui_h($cls) . '">' . "\n";
}

function adm_ui_settings_row_close() {
    echo "</div><!-- pg-settings-field-row -->\n";
}

function adm_ui_pagination($mode, $page, $total_page, $page_per_block, $is_next) {
    $total_block = ceil($total_page / $page_per_block);
    $block = ceil($page / $page_per_block);
    $first_page = ($block - 1) * $page_per_block;
    $last_page = $block * $page_per_block;
    if ($total_block <= $block) {
        $last_page = $total_page;
    }

    echo '<nav class="pg-pagination" aria-label="페이지">';
    if ($page > 1) {
        $page_num = $page - 1;
        echo '<a href="?' . adm_ui_h($mode) . '&page=' . (int) $page_num . '" class="pg-page-link">&lsaquo;</a>';
    }
    for ($direct_page = $first_page + 1; $direct_page <= $last_page; $direct_page++) {
        if ($page == $direct_page) {
            echo '<span class="pg-page-current">' . (int) $direct_page . '</span>';
        } else {
            echo '<a href="?' . adm_ui_h($mode) . '&page=' . (int) $direct_page . '" class="pg-page-link">' . (int) $direct_page . '</a>';
        }
    }
    if ($is_next > 0) {
        $page_num = $page + 1;
        echo '<a href="?' . adm_ui_h($mode) . '&page=' . (int) $page_num . '" class="pg-page-link">&rsaquo;</a>';
    }
    echo '</nav>';
}

/** 한 번에 보기 옵션 (기본 목록) */
function adm_ui_per_page_options() {
    return array(50, 100, 300, 400, 500, 1000);
}

function adm_ui_per_page_default() {
    return 100;
}

function adm_ui_per_page_is_all($raw) {
    return ($raw === 'all' || $raw === '0' || $raw === 0);
}

/**
 * 요청에서 페이지당 건수 해석 (기본 100, 모두=all|0)
 * @return array{p_num:int,is_all:bool}
 */
function adm_ui_resolve_per_page($request = null, $default = null) {
    if ($default === null) {
        $default = adm_ui_per_page_default();
    }
    $options = adm_ui_per_page_options();
    $raw = null;

    if ($request === null) {
        if (isset($_REQUEST['p_num']) && $_REQUEST['p_num'] !== '') {
            $raw = $_REQUEST['p_num'];
        } elseif (isset($_REQUEST['num_per_page']) && $_REQUEST['num_per_page'] !== '') {
            $raw = $_REQUEST['num_per_page'];
        }
    } else {
        if (isset($request['p_num']) && $request['p_num'] !== '') {
            $raw = $request['p_num'];
        } elseif (isset($request['num_per_page']) && $request['num_per_page'] !== '') {
            $raw = $request['num_per_page'];
        }
    }

    if ($raw === null) {
        return array('p_num' => (int) $default, 'is_all' => false);
    }
    if (adm_ui_per_page_is_all($raw)) {
        return array('p_num' => 0, 'is_all' => true);
    }

    $p_num = intval($raw);
    if (!in_array($p_num, $options, true)) {
        $p_num = (int) $default;
    }
    return array('p_num' => $p_num, 'is_all' => false);
}

function adm_ui_per_page_query_value($per_page_info) {
    return $per_page_info['is_all'] ? 'all' : (int) $per_page_info['p_num'];
}

function adm_ui_mode_with_pnum($mode, $per_page_info) {
    $p = adm_ui_per_page_query_value($per_page_info);
    if ($mode === '' || $mode === null) {
        return 'p_num=' . rawurlencode($p);
    }
    return $mode . '&p_num=' . rawurlencode($p);
}

/**
 * 목록 슬라이스 계산 (products.php 호환: first/last 포함 인덱스)
 */
function adm_ui_paginate_slice($total_record, $page, $per_page_info) {
    if ($page < 1) {
        $page = 1;
    }

    if ($per_page_info['is_all'] || (int) $per_page_info['p_num'] <= 0) {
        $num_per_page = max(1, (int) $total_record);
        $total_page = 1;
    } else {
        $num_per_page = (int) $per_page_info['p_num'];
        $total_page = ($total_record > 0) ? (int) ceil($total_record / $num_per_page) : 1;
    }

    if ($page > $total_page) {
        $page = $total_page;
    }

    if ($total_record <= 0) {
        return array(
            'num_per_page' => $num_per_page,
            'page' => 1,
            'first' => 0,
            'last' => -1,
            'total_page' => 1,
            'article_num' => 0,
            'is_next' => 0,
            'page_count' => 0,
        );
    }

    $first = $num_per_page * ($page - 1);
    $last = $num_per_page * $page;
    $is_next = $total_record - $last;
    if ($is_next > 0) {
        $last -= 1;
    } else {
        $last = $total_record - 1;
    }

    return array(
        'num_per_page' => $num_per_page,
        'page' => $page,
        'first' => $first,
        'last' => $last,
        'total_page' => $total_page,
        'article_num' => $total_record - $num_per_page * ($page - 1),
        'is_next' => $is_next,
        'page_count' => $last - $first + 1,
    );
}

/**
 * 한 번에 보기: 50 100 … 1000 모두 건 (총 N건)
 */
function adm_ui_per_page_bar($base_file, $mode, $per_page_info, $total_record) {
    $options = adm_ui_per_page_options();
    $sep = (strpos($base_file, '?') !== false) ? '&' : '?';
    $prefix = adm_ui_h($base_file) . $sep;
    $mode_str = ($mode !== '' && $mode !== null) ? adm_ui_h($mode) . '&' : '';

    echo '<div class="pg-per-page-bar">';
    echo '<span class="pg-per-page-label">한 번에 보기:</span>';
    echo '<span class="pg-per-page-options">';
    foreach ($options as $ps) {
        if (!$per_page_info['is_all'] && (int) $per_page_info['p_num'] === (int) $ps) {
            echo '<strong class="pg-per-page-active">' . (int) $ps . '</strong>';
        } else {
            echo '<a href="' . $prefix . $mode_str . 'page=1&amp;p_num=' . (int) $ps . '" class="pg-per-page-link">' . (int) $ps . '</a>';
        }
    }
    if ($per_page_info['is_all']) {
        echo '<strong class="pg-per-page-active">모두</strong>';
    } else {
        echo '<a href="' . $prefix . $mode_str . 'page=1&amp;p_num=all" class="pg-per-page-link">모두</a>';
    }
    echo '</span>';
    echo '<span class="pg-per-page-suffix">건</span>';
    echo '<span class="pg-per-page-total">(총 ' . number_format((int) $total_record) . '건)</span>';
    echo '</div>';
}

function adm_ui_per_page_links($base_file, $mode, $current, $options = null) {
    $per_page_info = array('p_num' => (int) $current, 'is_all' => adm_ui_per_page_is_all($current));
    if ($per_page_info['is_all']) {
        $per_page_info['p_num'] = 0;
    } elseif (!in_array($per_page_info['p_num'], adm_ui_per_page_options(), true)) {
        $per_page_info['p_num'] = adm_ui_per_page_default();
    }
    adm_ui_per_page_bar($base_file, $mode, $per_page_info, 0);
}

/**
 * 상품 country 코드 → 관리 화면 표시명 (한글 + 영문)
 */
function adm_ui_country_label($code, $home = '') {
    static $map = null;
    if ($map === null) {
        $map = array(
            '82' => array('name' => '한국', 'label' => 'KOREA'),
            '66' => array('name' => '태국', 'label' => 'THAILAND'),
            '91' => array('name' => '인도', 'label' => 'INDIA'),
            '1'  => array('name' => '미국', 'label' => 'USA'),
            '81' => array('name' => '일본', 'label' => 'JAPAN'),
            '86' => array('name' => '중국', 'label' => 'CHINA'),
            '84' => array('name' => '베트남', 'label' => 'VIETNAM'),
            '62' => array('name' => '인도네시아', 'label' => 'INDONESIA'),
        );
    }

    $code = trim((string) $code);
    if ($code === '') {
        $code = '1';
    }

    if (isset($map[$code])) {
        return $map[$code]['name'] . ' (' . $map[$code]['label'] . ')';
    }

    $home = trim((string) $home);
    if ($home !== '') {
        return $home;
    }

    return $code;
}

/**
 * 상품 code1~4 기준 최종 카테고리명
 */
function adm_ui_product_cate_name($DB, $shop_cate, $code1, $code2, $code3, $code4) {
    $code1 = addslashes($code1);
    $code2 = addslashes($code2);
    $code3 = addslashes($code3);
    $code4 = addslashes($code4);

    if ($code2 === '00' || $code2 === '') {
        $query = "SELECT cate1 FROM $shop_cate WHERE code1='$code1' and code2='00' and code3='00' and code4='00'";
    } elseif ($code3 === '00' || $code3 === '') {
        $query = "SELECT cate2 FROM $shop_cate WHERE code1='$code1' and code2='$code2' and code3='00' and code4='00'";
    } elseif ($code4 === '00' || $code4 === '') {
        $query = "SELECT cate3 FROM $shop_cate WHERE code1='$code1' and code2='$code2' and code3='$code3' and code4='00'";
    } else {
        $query = "SELECT cate4 FROM $shop_cate WHERE code1='$code1' and code2='$code2' and code3='$code3' and code4='$code4'";
    }

    $DB->get($query, $rs2, $rn2);
    if ($rn2 < 1 || !isset($rs2[0][0])) {
        return '';
    }
    return stripslashes($rs2[0][0]);
}

/**
 * Y/M/D → ISO (YYYY-MM-DD) for PG date inputs.
 */
function adm_ui_iso_from_ymd($y, $m, $d) {
    $y = intval($y);
    $m = intval($m);
    $d = intval($d);
    if ($y < 1 || $m < 1 || $d < 1) {
        return '';
    }
    return sprintf('%04d-%02d-%02d', $y, $m, $d);
}

/**
 * ISO date → array(y,m,d) or null.
 */
function adm_ui_ymd_from_iso($iso) {
    $iso = trim((string) $iso);
    if (!preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $iso, $m)) {
        return null;
    }
    return array(
        'y' => intval($m[1]),
        'm' => intval($m[2]),
        'd' => intval($m[3]),
    );
}

/**
 * PG-style date range: native calendar inputs + legacy hidden y/m/d fields.
 *
 * $from_ymd / $to_ymd: array('y'=>,'m'=>,'d'=>)
 * $field_map: array('from'=>array('y'=>'ydate1','m'=>'mdate1','d'=>'ddate1'), 'to'=>...)
 */
function adm_ui_pg_date_range_html($from_ymd, $to_ymd, $field_map) {
    $iso_from = adm_ui_iso_from_ymd(
        isset($from_ymd['y']) ? $from_ymd['y'] : '',
        isset($from_ymd['m']) ? $from_ymd['m'] : '',
        isset($from_ymd['d']) ? $from_ymd['d'] : ''
    );
    $iso_to = adm_ui_iso_from_ymd(
        isset($to_ymd['y']) ? $to_ymd['y'] : '',
        isset($to_ymd['m']) ? $to_ymd['m'] : '',
        isset($to_ymd['d']) ? $to_ymd['d'] : ''
    );

    $html = '<div class="pg-search-date-range" data-pg-date-range="1">';
    $html .= '<input type="date" lang="en-CA" class="pg-input pg-date-input-iso pg-search-date-input" data-pg-date-from="1" name="search_from_date" value="' . adm_ui_h($iso_from) . '" autocomplete="off">';
    $html .= '<span class="pg-search-daterange-sep" aria-hidden="true">—</span>';
    $html .= '<input type="date" lang="en-CA" class="pg-input pg-date-input-iso pg-search-date-input" data-pg-date-to="1" name="search_to_date" value="' . adm_ui_h($iso_to) . '" autocomplete="off">';

    foreach (array('from', 'to') as $side) {
        if (!isset($field_map[$side]) || !is_array($field_map[$side])) {
            continue;
        }
        $ymd = ($side === 'from') ? $from_ymd : $to_ymd;
        $keys = $field_map[$side];
        foreach (array('y', 'm', 'd') as $part) {
            if (!isset($keys[$part])) {
                continue;
            }
            $val = isset($ymd[$part]) ? $ymd[$part] : '';
            $html .= '<input type="hidden" name="' . adm_ui_h($keys[$part]) . '" value="' . adm_ui_h($val) . '" data-pg-hidden-' . $part . '="1">';
        }
    }

    $html .= '</div>';
    return $html;
}

/**
 * Apply search_from_date / search_to_date to legacy y/m/d request vars.
 */
function adm_ui_apply_pg_date_range_request($field_map) {
    if (!empty($_REQUEST['search_from_date']) && isset($field_map['from'])) {
        $p = adm_ui_ymd_from_iso($_REQUEST['search_from_date']);
        if ($p !== null) {
            if (isset($field_map['from']['y'])) {
                $_REQUEST[$field_map['from']['y']] = $p['y'];
            }
            if (isset($field_map['from']['m'])) {
                $_REQUEST[$field_map['from']['m']] = $p['m'];
            }
            if (isset($field_map['from']['d'])) {
                $_REQUEST[$field_map['from']['d']] = $p['d'];
            }
        }
    }
    if (!empty($_REQUEST['search_to_date']) && isset($field_map['to'])) {
        $p = adm_ui_ymd_from_iso($_REQUEST['search_to_date']);
        if ($p !== null) {
            if (isset($field_map['to']['y'])) {
                $_REQUEST[$field_map['to']['y']] = $p['y'];
            }
            if (isset($field_map['to']['m'])) {
                $_REQUEST[$field_map['to']['m']] = $p['m'];
            }
            if (isset($field_map['to']['d'])) {
                $_REQUEST[$field_map['to']['d']] = $p['d'];
            }
        }
    }
}

function adm_ui_order_date_field_map() {
    return array(
        'from' => array('y' => 'ydate1', 'm' => 'mdate1', 'd' => 'ddate1'),
        'to'   => array('y' => 'ydate2', 'm' => 'mdate2', 'd' => 'ddate2'),
    );
}

function adm_ui_sales_day_date_field_map() {
    return array(
        'from' => array('y' => 'tyear', 'm' => 'tmonth', 'd' => 'tday'),
        'to'   => array('y' => 'eyear', 'm' => 'emonth', 'd' => 'eday'),
    );
}
