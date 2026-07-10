<?php
/**
 * PKSHOP Admin shell menu — PG/Crypto style main + sub menus.
 */
if (!defined('ADM_SHELL_MENU_LOADED')) {
    define('ADM_SHELL_MENU_LOADED', true);

    $ADM_SHELL_MENU = array(
        array(
            'id'    => 'product',
            'label' => '상품관리',
            'icon'  => 'box',
            'children' => array(
                array('id' => 'M0101', 'label' => '분류등록/수정',   'url' => '/Adm/product/category.php'),
                array('id' => 'M0102', 'label' => '상품등록',       'url' => '/Adm/product/pro_up.php'),
                array('id' => 'M0103', 'label' => '상품 일괄등록',   'url' => '/Adm/product/pro_import.php'),
                array('id' => 'M0105', 'label' => '전체상품관리',    'url' => '/Adm/product/products.php'),
                array('id' => 'M0106', 'label' => '대기상품관리',    'url' => '/Adm/product/products.php?soldout=Y'),
                array('id' => 'M0107', 'label' => '추천상품',       'url' => '/Adm/product/pro_pri.php'),
                array('id' => 'M0108', 'label' => '베스트상품',      'url' => '/Adm/product/pro_propose.php'),
                array('id' => 'M0109', 'label' => 'HOT상품',        'url' => '/Adm/product/pro_like.php'),
                array('id' => 'M0110', 'label' => 'All 상품',        'url' => '/Adm/product/pro_all.php'),
            ),
        ),
        array(
            'id'    => 'ai_ops',
            'label' => 'AI 운영관리',
            'icon'  => 'ai',
            'children' => array(
                array('id' => 'M0120', 'label' => 'AI 상품생성', 'url' => '/Adm/product/pro_ai_generate.php'),
                array('id' => 'M0121', 'label' => 'AI 상품관리', 'url' => '/Adm/product/pro_ai_products.php'),
            ),
        ),
        array(
            'id'    => 'order',
            'label' => '주문배송관리',
            'icon'  => 'truck',
            'children' => array(
                array('id' => 'M0200', 'label' => '전체',     'url' => '/Adm/product/pro_order.php?sel_status='),
                array('id' => 'M0201', 'label' => '주문접수',  'url' => '/Adm/product/pro_order.php?sel_status=주문접수'),
                array('id' => 'M0202', 'label' => '결제완료',  'url' => '/Adm/product/pro_order.php?sel_status=결제완료'),
                array('id' => 'M0203', 'label' => '준비중',    'url' => '/Adm/product/pro_order.php?sel_status=준비중'),
                array('id' => 'M0204', 'label' => '배송중',    'url' => '/Adm/product/pro_order.php?sel_status=배송중'),
                array('id' => 'M0205', 'label' => '배송완료',  'url' => '/Adm/product/pro_order.php?sel_status=배송완료'),
                array('id' => 'M0206', 'label' => '구매확정',  'url' => '/Adm/product/pro_order.php?sel_status=구매확정'),
                array('id' => 'M0207', 'label' => '주문취소',  'url' => '/Adm/product/pro_order.php?sel_status=주문취소'),
                array('id' => 'M0208', 'label' => '주문자취소', 'url' => '/Adm/product/pro_order.php?sel_status=주문자취소'),
                array('id' => 'M0209', 'label' => '반송',     'url' => '/Adm/product/pro_order.php?sel_status=반송'),
                array('id' => 'M0210', 'label' => '반품',     'url' => '/Adm/product/pro_order.php?sel_status=반품'),
            ),
        ),
        array(
            'id'    => 'sales',
            'label' => '매출관리',
            'icon'  => 'chart',
            'children' => array(
                array('id' => 'M0301', 'label' => '월별 매출 조회', 'url' => '/Adm/product/order_month.php'),
                array('id' => 'M0302', 'label' => '일별 매출 조회', 'url' => '/Adm/product/order_day.php'),
            ),
        ),
        array(
            'id'    => 'member',
            'label' => '회원관리',
            'icon'  => 'users',
            'children' => array(
                array('id' => 'M0401', 'label' => '일반회원', 'url' => '/Adm/member/member.php?dis=0'),
            ),
        ),
        array(
            'id'    => 'settings',
            'label' => '환경설정',
            'icon'  => 'settings',
            'children' => array(
                array('id' => 'M0501', 'label' => 'AI 설정',   'url' => '/Adm/product/pro_site_settings.php?tab=ai'),
                array('id' => 'M0502', 'label' => '브랜드설정', 'url' => '/Adm/product/pro_site_settings.php?tab=brand'),
                array('id' => 'M0503', 'label' => '통화설정',   'url' => '/Adm/product/pro_site_settings.php?tab=currency'),
                array('id' => 'M0504', 'label' => '결제연동',   'url' => '/Adm/product/pro_site_settings.php?tab=payment'),
                array('id' => 'M0505', 'label' => '홍보설정',   'url' => '/Adm/product/pro_site_settings.php?tab=promo'),
                array('id' => 'M0506', 'label' => '계좌변경',   'url' => '/Adm/admin_pass/bank_change.php'),
            ),
        ),
    );

    $ADM_SHELL_HOME = array(
        'id'    => 'home',
        'label' => '메인',
        'url'   => '/Adm/main/main.php',
        'parent'=> '',
    );
}
