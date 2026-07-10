<?php
/**
 * PKSHOP Admin shell helpers.
 */
require_once __DIR__ . '/admin_shell_menu.php';
require_once __DIR__ . '/adm_ui_lib.php';

function adm_shell_normalize_path($url) {
    $path = parse_url($url, PHP_URL_PATH);
    if (!$path) {
        return '';
    }
    $path = str_replace('\\', '/', $path);
    if (strpos($path, '/Adm/') !== false) {
        $path = substr($path, strpos($path, '/Adm/'));
    }
    return rtrim($path, '/');
}

function adm_shell_normalize_url($url) {
    $path = adm_shell_normalize_path($url);
    $query = parse_url($url, PHP_URL_QUERY);
    if ($query) {
        parse_str($query, $params);
        ksort($params);
        $query = http_build_query($params);
        return $path . '?' . $query;
    }
    return $path;
}

function adm_shell_current_url() {
    $uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
    return adm_shell_normalize_url($uri);
}

function adm_shell_build_menu_info() {
    global $ADM_SHELL_MENU, $ADM_SHELL_HOME;

    $info = array();
    $info[$ADM_SHELL_HOME['url']] = array(
        'label'  => $ADM_SHELL_HOME['label'],
        'parent' => '',
        'id'     => 'home',
        'group'  => '',
    );

    foreach ($ADM_SHELL_MENU as $group) {
        foreach ($group['children'] as $child) {
            $key = adm_shell_normalize_url($child['url']);
            $info[$key] = array(
                'label'  => $child['label'],
                'parent' => $group['label'],
                'id'     => $child['id'],
                'group'  => $group['id'],
            );
        }
    }

    return $info;
}

function adm_shell_match_menu_item($current_url) {
    $info = adm_shell_build_menu_info();
    if (isset($info[$current_url])) {
        return $info[$current_url];
    }

    $path_only = adm_shell_normalize_path($current_url);
    $best = null;
    $best_len = 0;
    foreach ($info as $url => $meta) {
        $item_path = adm_shell_normalize_path($url);
        if ($path_only === $item_path) {
            if (strlen($url) > $best_len) {
                $best = $meta;
                $best_len = strlen($url);
            }
        }
    }
    if ($best) {
        return $best;
    }

    foreach ($info as $url => $meta) {
        $item_path = adm_shell_normalize_path($url);
        if ($item_path !== '' && strpos($path_only, $item_path) === 0) {
            if (strlen($item_path) > $best_len) {
                $best = $meta;
                $best_len = strlen($item_path);
            }
        }
    }

    return $best ? $best : array(
        'label'  => '관리자',
        'parent' => '',
        'id'     => '',
        'group'  => '',
    );
}

function adm_shell_resolve_context() {
    global $ADM_SHELL_MENU;

    $current = adm_shell_current_url();
    $match = adm_shell_match_menu_item($current);
    $title = $match['label'];
    $trail = array();
    if (!empty($match['parent'])) {
        $trail[] = $match['parent'];
    }
    $trail[] = $title;

    $active_group = isset($match['group']) ? $match['group'] : '';

    return array(
        'currentUrl'  => $current,
        'title'       => $title,
        'trail'       => $trail,
        'breadcrumb'  => implode(' > ', $trail),
        'activeGroup' => $active_group,
        'menuId'      => isset($match['id']) ? $match['id'] : '',
    );
}

function adm_shell_h($text) {
    return htmlspecialchars((string) $text, ENT_QUOTES, 'UTF-8');
}

function adm_shell_icon_svg($icon) {
    $icons = array(
        'box'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><path d="M3.3 7.7 12 12l8.7-4.3"/><path d="M12 22V12"/></svg>',
        'truck' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h1"/><path d="M15 18h2a1 1 0 0 0 1-1v-3.5a1 1 0 0 0-.3-.7l-2.5-2.5A1 1 0 0 0 14 10H9"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/></svg>',
        'chart' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3v18h18"/><path d="M7 16v-4"/><path d="M11 16V8"/><path d="M15 16v-6"/><path d="M19 16V5"/></svg>',
        'users' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
        'bank'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 10h18"/><path d="M5 10V18"/><path d="M9 10V18"/><path d="M15 10V18"/><path d="M19 10V18"/><path d="M2 18h20"/><path d="M12 2 2 7h20L12 2z"/></svg>',
        'settings' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>',
        'ai'    => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3 13.5 8.5 19 10l-5.5 1.5L12 17l-1.5-5.5L5 10l5.5-1.5L12 3z"/><path d="M5 19l1 2M19 19l-1 2M3 14h2M19 14h2"/></svg>',
        'home'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><path d="M9 22V12h6v10"/></svg>',
    );
    return isset($icons[$icon]) ? $icons[$icon] : $icons['box'];
}

function adm_shell_render_sidebar() {
    global $ADM_SHELL_MENU, $ADM_SHELL_HOME;

    $ctx = adm_shell_resolve_context();
    $active_group = $ctx['activeGroup'];
    $current = $ctx['currentUrl'];

    echo '<aside id="pg-sidebar" class="pg-sidebar">';
    echo '<div class="pg-sidebar-logo">';
    echo '<a href="' . adm_shell_h($ADM_SHELL_HOME['url']) . '" class="pg-logo-link" data-tab-url="' . adm_shell_h(adm_shell_normalize_url($ADM_SHELL_HOME['url'])) . '">';
    echo '<span class="pg-logo-text">Pentakleva</span>';
    echo '<span class="pg-logo-sub">Admin</span>';
    echo '</a>';
    echo '</div>';

    echo '<nav class="pg-side-nav-wrap">';
    echo '<div class="pg-sidebar-collapse-wrap">';
    echo '<button type="button" id="pg-sidebar-fold" class="pg-sidebar-collapse" aria-label="사이드바 접기">';
    echo '<span id="pg-sidebar-fold-label">« 접기</span>';
    echo '</button>';
    echo '</div>';

    echo '<ul class="pg-side-nav" id="pg-side-nav">';

    echo '<li class="pg-side-group' . ($current === adm_shell_normalize_url($ADM_SHELL_HOME['url']) ? ' is-active' : '') . '">';
    echo '<a class="pg-side-parent pg-side-parent-single" href="' . adm_shell_h($ADM_SHELL_HOME['url']) . '" data-tab-url="' . adm_shell_h(adm_shell_normalize_url($ADM_SHELL_HOME['url'])) . '">';
    echo '<span class="pg-side-icon">' . adm_shell_icon_svg('home') . '</span>';
    echo '<span class="pg-side-label">' . adm_shell_h($ADM_SHELL_HOME['label']) . '</span>';
    echo '</a></li>';

    foreach ($ADM_SHELL_MENU as $group) {
        $open = ($active_group === $group['id']);
        echo '<li class="pg-side-group' . ($open ? ' is-open is-active' : '') . '" data-group="' . adm_shell_h($group['id']) . '">';
        echo '<button type="button" class="pg-side-parent" aria-expanded="' . ($open ? 'true' : 'false') . '">';
        echo '<span class="pg-side-icon">' . adm_shell_icon_svg($group['icon']) . '</span>';
        echo '<span class="pg-side-label">' . adm_shell_h($group['label']) . '</span>';
        echo '<span class="pg-side-arrow" aria-hidden="true"></span>';
        echo '</button>';
        echo '<ul class="pg-side-children"' . ($open ? '' : ' hidden') . '>';
        foreach ($group['children'] as $child) {
            $url = adm_shell_normalize_url($child['url']);
            $active = ($current === $url) ? ' is-active' : '';
            echo '<li class="pg-side-child' . $active . '">';
            echo '<a href="' . adm_shell_h($child['url']) . '" data-tab-url="' . adm_shell_h($url) . '" data-menu-id="' . adm_shell_h($child['id']) . '">';
            echo adm_shell_h($child['label']);
            echo '</a></li>';
        }
        echo '</ul></li>';
    }

    echo '</ul></nav></aside>';
}

function adm_shell_render_session_bar() {
    $admin_id = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : '관리자';
    $client_ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '—';

    echo '<header class="pg-session-bar">';
    echo '<div class="pg-session-inner">';
    echo '<div class="pg-session-tools">';

    echo '<div class="pg-theme-wrap">';
    echo '<span class="pg-session-meta-label">테마</span>';
    echo '<div class="pg-theme-pill">';
    echo '<button type="button" class="pg-theme-btn" data-theme="dark">어두운</button>';
    echo '<button type="button" class="pg-theme-btn is-active" data-theme="default">기본</button>';
    echo '<button type="button" class="pg-theme-btn" data-theme="light">밝은</button>';
    echo '</div></div>';

    echo '<span class="pg-session-pipe">|</span>';
    echo '<div class="pg-session-meta">';
    echo '<span class="pg-session-meta-label">접속시간</span>';
    echo '<span class="pg-session-meta-value" id="pg-access-time">—</span>';
    echo '</div>';

    echo '<span class="pg-session-pipe">|</span>';
    echo '<div class="pg-session-meta">';
    echo '<span class="pg-session-meta-label">IP</span>';
    echo '<span class="pg-session-meta-value">' . adm_shell_h($client_ip) . '</span>';
    echo '</div>';

    echo '<span class="pg-session-pipe">|</span>';
    echo '<div class="pg-session-user">';
    echo '<span class="pg-session-user-name">' . adm_shell_h($admin_id) . '</span>';
    echo '<a href="../login/logout.php" class="pg-session-logout">로그아웃</a>';
    echo '</div>';

    echo '<button type="button" id="pg-tab-close-all" class="pg-session-close pg-session-close-idle">X 전체닫기</button>';
    echo '</div></div></header>';
}

function adm_shell_render_frame_head($ctx = null) {
    if ($ctx === null) {
        $ctx = adm_shell_resolve_context();
    }
    if (!empty($GLOBALS['ADM_SHELL_TITLE'])) {
        $ctx['title'] = $GLOBALS['ADM_SHELL_TITLE'];
    }
    if (!empty($GLOBALS['ADM_SHELL_BREADCRUMB'])) {
        $ctx['breadcrumb'] = $GLOBALS['ADM_SHELL_BREADCRUMB'];
    }

    echo '<div class="pg-frame-head">';
    echo '<h1 class="pg-frame-title" id="pg-frame-title">' . adm_shell_h($ctx['title']) . '</h1>';
    echo '<div class="pg-frame-path" id="pg-frame-path">' . adm_shell_h($ctx['breadcrumb']) . '</div>';
    echo '</div>';
}

function adm_shell_render_subtabs($group_id) {
    global $ADM_SHELL_MENU;

    $ctx = adm_shell_resolve_context();
    $current = $ctx['currentUrl'];

    foreach ($ADM_SHELL_MENU as $group) {
        if ($group['id'] !== $group_id) {
            continue;
        }
        if (count($group['children']) < 2) {
			return;
		}
        echo '<div class="pg-subtab-bar">';
        foreach ($group['children'] as $child) {
            $url = adm_shell_normalize_url($child['url']);
            $active = ($current === $url) ? ' pg-subtab-active' : ' pg-subtab-idle';
            echo '<a href="' . adm_shell_h($child['url']) . '" class="pg-subtab' . $active . '" data-tab-url="' . adm_shell_h($url) . '">';
            echo adm_shell_h($child['label']);
            echo '</a>';
        }
        echo '</div>';
        return;
    }
}

function adm_shell_json_menu_info() {
    return adm_shell_build_menu_info();
}

/**
 * PG-style order status pill (replaces legacy <font color>).
 */
function adm_order_status_pill($status) {
    $status = trim(strip_tags((string) $status));
    $tone_map = array(
        '주문접수' => 'pending',
        '결제완료' => 'success',
        '준비중'   => 'pending',
        '배송중'   => 'progress',
        '배송완료' => 'success',
        '구매확정' => 'success',
        '주문취소' => 'cancel',
        '주문자취소' => 'cancel',
        '반송'     => 'void',
        '반품'     => 'refund',
        '결제실패' => 'fail',
        '입금확인' => 'progress',
        '입금완료' => 'success',
    );
    $tone = isset($tone_map[$status]) ? $tone_map[$status] : 'other';
    return '<span class="pg-status-pill pg-status-pill--' . $tone . '">' . adm_shell_h($status) . '</span>';
}
