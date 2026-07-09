<?php
/**
 * 쇼핑몰 노출 정책
 * true  = 비회원도 가격·상품상세 열람 가능 (2026-07-09)
 * false = 기존(회원만 가격·상세) — backup/20260709_price_login_gate 참고
 */
if (!defined('PKSHOP_PUBLIC_PRICE')) {
    define('PKSHOP_PUBLIC_PRICE', true);
}

function pkshop_can_show_price() {
    if (PKSHOP_PUBLIC_PRICE) {
        return true;
    }
    return isset($_SESSION['member_id']) && $_SESSION['member_id'] !== '';
}
