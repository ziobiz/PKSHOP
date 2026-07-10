<?
include "../common/dbconn.php";
include "../inc/top_menu.php";
include "../inc/left_menu_product.php";
include "../common/user_function.php";
include "../inc/set_com.php";
include "pro_theme_screen_lib.php";

pro_theme_screen_render($DB, $shop_cate, $shop_goods, array(
    'theme'      => 'f',
    'theme_col'  => 'theme_f',
    'rank_col'   => 'rank_f',
    'page_title' => 'HOT 상품',
    'add_label'  => 'HOT 상품 추가',
    'self_php'   => 'pro_like.php',
));

include "../inc/down_menu.php";
