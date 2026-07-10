<?php
/**
 * PKSHOP — CRYPTO/TINPASS 레이아웃 로그인 화면 (관리자 전용 UI/브랜딩)
 * - 관리자: Adm/login/login.php + login_do.php / admanager
 * - 회원: member/login.php — 쇼핑몰 기본 레이아웃 (본 라이브러리 미사용)
 * - 이메일·OTP·JWT 인증 없음 (CRYPTO Node/PG 기능 미이식)
 */
require_once dirname(__FILE__) . '/site_settings_lib.php';

if (!function_exists('pkshop_auth_h')) {
    function pkshop_auth_h($s) {
        return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('pkshop_auth_branding')) {
    /**
     * @param string $context 'admin' | 'member'
     */
    function pkshop_auth_branding($context = 'member') {
        $s = pkshop_site_settings();
        $prefix = ($context === 'admin') ? 'login_admin_' : 'login_member_';

        $notice_enabled = isset($s['login_notice_enabled']) && $s['login_notice_enabled'] !== '0';

        return array(
            'auth_logo' => pkshop_site_asset_url($s['login_auth_logo']),
            'auth_background' => pkshop_site_asset_url($s['login_auth_background']),
            'auth_main_text' => isset($s['login_auth_main_text']) ? $s['login_auth_main_text'] : '',
            'notice_enabled' => $notice_enabled,
            'notice_title' => isset($s['login_notice_title']) ? $s['login_notice_title'] : '',
            'notice_body' => isset($s['login_notice_body']) ? $s['login_notice_body'] : '',
            'footer_text' => isset($s['login_footer_text']) ? $s['login_footer_text'] : '',
            'form_title' => isset($s[$prefix . 'title']) ? $s[$prefix . 'title'] : '로그인',
            'label_id' => isset($s[$prefix . 'label_id']) ? $s[$prefix . 'label_id'] : '아이디',
            'label_password' => isset($s[$prefix . 'label_password']) ? $s[$prefix . 'label_password'] : '비밀번호',
            'btn_submit' => isset($s[$prefix . 'btn']) ? $s[$prefix . 'btn'] : '로그인',
        );
    }
}

if (!function_exists('pkshop_auth_chrome_open')) {
    function pkshop_auth_chrome_open($context = 'member') {
        $b = pkshop_auth_branding($context);
        $bg_style = '';
        if ($b['auth_background'] !== '') {
            $bg_style = ' style="background-image:url(' . pkshop_auth_h($b['auth_background']) . ');"';
        }
        echo '<div class="pk-auth-root">' . "\n";
        echo '<div class="pk-auth-hero"' . $bg_style . '>' . "\n";
        if ($b['auth_main_text'] !== '') {
            echo '<div class="pk-auth-hero-text">' . nl2br(pkshop_auth_h($b['auth_main_text'])) . '</div>' . "\n";
        }
        echo '</div>' . "\n";
        echo '<div class="pk-auth-panel">' . "\n";
        echo '<div class="pk-auth-panel-inner">' . "\n";

        if ($b['auth_logo'] !== '') {
            echo '<div class="pk-auth-logo-wrap"><img src="' . pkshop_auth_h($b['auth_logo']) . '" alt="" class="pk-auth-logo"></div>' . "\n";
        }

        if ($b['notice_enabled'] && ($b['notice_title'] !== '' || $b['notice_body'] !== '')) {
            echo '<section class="pk-auth-notice" role="note">';
            if ($b['notice_title'] !== '') {
                echo '<h3 class="pk-auth-notice-title">' . pkshop_auth_h($b['notice_title']) . '</h3>';
            }
            if ($b['notice_body'] !== '') {
                echo '<div class="pk-auth-notice-body">' . nl2br(pkshop_auth_h($b['notice_body'])) . '</div>';
            }
            echo '</section>' . "\n";
        }

        echo '<div class="pk-auth-form-wrap">' . "\n";
        return $b;
    }
}

if (!function_exists('pkshop_auth_chrome_close')) {
    function pkshop_auth_chrome_close($footer_text = null) {
        if ($footer_text === null) {
            $b = pkshop_auth_branding('member');
            $footer_text = $b['footer_text'];
        }
        echo '</div><!-- pk-auth-form-wrap -->' . "\n";
        if ($footer_text !== '') {
            echo '<p class="pk-auth-footer">' . pkshop_auth_h($footer_text) . '</p>' . "\n";
        }
        echo '</div></div></div><!-- pk-auth-root -->' . "\n";
    }
}

if (!function_exists('pkshop_auth_css_link')) {
    function pkshop_auth_css_link() {
        $v = '20260710auth';
        echo '<link rel="stylesheet" href="/images/pkshop_auth.css?v=' . $v . '" type="text/css" />' . "\n";
    }
}
