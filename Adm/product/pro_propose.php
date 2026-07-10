<?
include "../common/dbconn.php";
include "../inc/top_menu.php";
include "../inc/left_menu_product.php";
include "../common/user_function.php";
include "../inc/set_com.php";
include "pro_theme_screen_lib.php";

pro_theme_screen_render($DB, $shop_cate, $shop_goods, array(
    'theme'      => 'r',
    'theme_col'  => 'theme_r',
    'rank_col'   => 'rank_r',
    'page_title' => 'BEST 상품',
    'add_label'  => 'BEST 상품 추가',
    'self_php'   => 'pro_propose.php',
));

include "../inc/down_menu.php";
