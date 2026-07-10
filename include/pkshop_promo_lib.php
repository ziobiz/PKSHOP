<?php
/**
 * 메인 홍보 영역 — BEST / RECOMMENDED / All PRODUCTS 순환 노출
 */
if (!function_exists('pkshop_site_setting')) {
    require_once dirname(__FILE__) . '/site_settings_lib.php';
}
if (!function_exists('pkshop_main_product_has_image')) {
    require_once dirname(__FILE__) . '/product_detail_helper.php';
}

if (!function_exists('pkshop_promo_rotate_interval_options')) {
    function pkshop_promo_rotate_interval_options() {
        return array(
            '10'   => '10초',
            '30'   => '30초',
            '60'   => '60초',
            '90'   => '90초',
            '120'  => '2분',
            '180'  => '3분',
            '300'  => '5분',
            '600'  => '10분',
        );
    }
}

if (!function_exists('pkshop_promo_rotate_seconds')) {
    function pkshop_promo_rotate_seconds($section) {
        $opts = pkshop_promo_rotate_interval_options();
        $key = 'promo_rotate_' . $section;
        $val = pkshop_site_setting($key, '30');
        return isset($opts[(string)$val]) ? (int)$val : 30;
    }
}

if (!function_exists('pkshop_promo_fetch_api_rows')) {
    function pkshop_promo_fetch_api_rows($api_history, $post_data) {
        if (!function_exists('pkshop_main_all_fetch_api_rows')) {
            require_once dirname(__FILE__) . '/site_settings_lib.php';
        }
        return pkshop_main_all_fetch_api_rows($api_history, $post_data);
    }
}

if (!function_exists('pkshop_promo_filter_rows')) {
    function pkshop_promo_filter_rows($rows) {
        $out = array();
        if (!is_array($rows)) {
            return $out;
        }
        foreach ($rows as $row) {
            if (!is_array($row)) {
                continue;
            }
            if (function_exists('pkshop_main_all_row_has_image')) {
                if (!pkshop_main_all_row_has_image($row)) {
                    continue;
                }
            } elseif (empty($row['imgl']) && empty($row['imgb1'])) {
                continue;
            }
            $out[] = $row;
        }
        return $out;
    }
}

if (!function_exists('pkshop_promo_row_code1')) {
    function pkshop_promo_row_code1($row) {
        if (!empty($row['code1'])) {
            return $row['code1'];
        }
        $code = isset($row['code']) ? (string)$row['code'] : '';
        return $code !== '' ? substr($code, 0, 2) : '';
    }
}

if (!function_exists('pkshop_promo_row_price_tmp')) {
    function pkshop_promo_row_price_tmp($row) {
        global $cook_dis, $cook_dis1;
        $pricec = isset($row['pricec']) ? $row['pricec'] : 0;
        $prices = isset($row['prices']) ? $row['prices'] : 0;
        $priced = isset($row['priced']) ? $row['priced'] : 0;
        if ($cook_dis == "1" && $cook_dis1 == "승인") {
            return $priced;
        }
        if ($cook_dis == "2" && $cook_dis1 == "승인") {
            return $pricec;
        }
        if ($cook_dis == "3" && $cook_dis1 == "승인") {
            return $prices;
        }
        return ($priced > 0) ? $priced : $pricec;
    }
}

if (!function_exists('pkshop_promo_row_title')) {
    function pkshop_promo_row_title($row) {
        $title = isset($row['title']) ? $row['title'] : '';
        if (!empty($row['onlypoint']) && (int)$row['onlypoint'] === 1) {
            $title .= "<span style='color:#ff0000;'> [InT Only]</span>";
        }
        return $title;
    }
}

if (!function_exists('pkshop_promo_row_image_url')) {
    function pkshop_promo_row_image_url($row, $savedir = '//pentakleva.shop/upload/') {
        if (function_exists('pkshop_main_product_image_url')) {
            return pkshop_main_product_image_url($row, $savedir);
        }
        $imgl = isset($row['imgl']) ? $row['imgl'] : '';
        $imgb1 = isset($row['imgb1']) ? $row['imgb1'] : '';
        if ($imgl !== '') {
            return $savedir . $imgl;
        }
        if ($imgb1 !== '') {
            return $savedir . $imgb1;
        }
        return '';
    }
}

if (!function_exists('pkshop_promo_build_rotate_frames')) {
    function pkshop_promo_build_rotate_frames($items, $visible_count) {
        $visible_count = max(1, (int)$visible_count);
        $n = count($items);
        if ($n === 0) {
            return array();
        }
        if ($n <= $visible_count) {
            return array(array_slice($items, 0, $visible_count));
        }
        $frame_count = (int)ceil($n / $visible_count);
        $frames = array();
        for ($f = 0; $f < $frame_count; $f++) {
            $frame = array();
            for ($j = 0; $j < $visible_count; $j++) {
                $frame[] = $items[($f * $visible_count + $j) % $n];
            }
            $frames[] = $frame;
        }
        return $frames;
    }
}

if (!function_exists('pkshop_promo_build_multi_pool_frames')) {
    function pkshop_promo_build_multi_pool_frames($pools, $slot_size) {
        $slot_size = max(1, (int)$slot_size);
        if (empty($pools)) {
            return array();
        }
        $frame_count = 1;
        foreach ($pools as $pool) {
            $c = count($pool);
            if ($c > $slot_size) {
                $frame_count = max($frame_count, (int)ceil($c / $slot_size));
            }
        }
        $frames = array();
        for ($f = 0; $f < $frame_count; $f++) {
            $frame = array();
            foreach ($pools as $pool) {
                $n = count($pool);
                if ($n === 0) {
                    continue;
                }
                for ($j = 0; $j < $slot_size; $j++) {
                    $frame[] = $pool[($f * $slot_size + $j) % $n];
                }
            }
            if (!empty($frame)) {
                $frames[] = $frame;
            }
        }
        return $frames;
    }
}

if (!function_exists('pkshop_promo_fetch_theme_rows')) {
    function pkshop_promo_fetch_theme_rows($api_history, $type) {
        $de_id = 'e7bb77ca2517821473681d3e9fe132e54c21bdff0ef170596f0414032aac3dbc';
        $post = 'deId=' . rawurlencode($de_id) . '&Type=' . rawurlencode($type);
        return pkshop_promo_filter_rows(pkshop_promo_fetch_api_rows($api_history, $post));
    }
}

if (!function_exists('pkshop_promo_all_category_pools')) {
    function pkshop_promo_all_category_pools($api_history) {
        if (!function_exists('pkshop_main_all_categories_list')) {
            require_once dirname(__FILE__) . '/site_settings_lib.php';
        }
        $categories = pkshop_main_all_categories_list();
        $pools = array();
        if (empty($categories)) {
            $post = pkshop_main_all_api_post_data();
            $rows = pkshop_promo_filter_rows(pkshop_promo_fetch_api_rows($api_history, $post));
            if (!empty($rows)) {
                $pools[] = $rows;
            }
            return $pools;
        }
        foreach ($categories as $entry) {
            $post = pkshop_main_all_api_post_data_for_entry($entry);
            $rows = pkshop_promo_filter_rows(pkshop_promo_fetch_api_rows($api_history, $post));
            if (!empty($rows)) {
                $pools[] = $rows;
            }
        }
        return $pools;
    }
}

if (!function_exists('pkshop_promo_all_rotate_frames')) {
    function pkshop_promo_all_rotate_frames($api_history, $slot_size = 4) {
        $pools = pkshop_promo_all_category_pools($api_history);
        if (empty($pools)) {
            return array();
        }
        if (count($pools) === 1) {
            return pkshop_promo_build_rotate_frames($pools[0], $slot_size);
        }
        return pkshop_promo_build_multi_pool_frames($pools, $slot_size);
    }
}

if (!function_exists('pkshop_promo_card_html')) {
    function pkshop_promo_card_html($row, $layout, $savedir = '//pentakleva.shop/upload/', $type = '') {
        $code = isset($row['code']) ? $row['code'] : '';
        $code1 = pkshop_promo_row_code1($row);
        $code2 = isset($row['code2']) ? $row['code2'] : '';
        $code3 = isset($row['code3']) ? $row['code3'] : '';
        $code4 = isset($row['code4']) ? $row['code4'] : '';
        $title = pkshop_promo_row_title($row);
        $price_tmp = pkshop_promo_row_price_tmp($row);
        $img_url = pkshop_promo_row_image_url($row, $savedir);
        if ($img_url === '') {
            return '';
        }
        $view_url = '../sub04/view.php?left_code=' . rawurlencode($code)
            . '&code1=' . rawurlencode($code1)
            . '&code2=' . rawurlencode($code2)
            . '&code3=' . rawurlencode($code3)
            . '&code4=' . rawurlencode($code4)
            . '&theme=f&type=' . rawurlencode($type);
        $title_plain = htmlspecialchars(strip_tags($title), ENT_QUOTES, 'UTF-8');
        $price_html = '';
        if (function_exists('pkshop_can_show_price') && pkshop_can_show_price()) {
            $price_html = '<p class="best_price" style="text-align:center; font-weight:bold;font-size:16px;color:#c3070b"><a href="'
                . htmlspecialchars($view_url, ENT_QUOTES, 'UTF-8') . '" class="c_red">'
                . pkshop_format_usd_jpy_price($price_tmp) . '</a></p>';
        }

        if ($layout === 'recommended') {
            return '<div class="new_product01">'
                . '<div class="sp15"></div>'
                . '<div class="new_img"><a href="' . htmlspecialchars($view_url, ENT_QUOTES, 'UTF-8') . '">'
                . '<img src="' . htmlspecialchars($img_url, ENT_QUOTES, 'UTF-8') . '" alt="' . $title_plain . '">'
                . '</a></div><div class="sp15"></div>'
                . '<p class="best_text" style="text-align:center;"><a href="' . htmlspecialchars($view_url, ENT_QUOTES, 'UTF-8') . '" class="a_3">' . $title . '</a></p>'
                . $price_html
                . '<div class="sp25"></div></div>';
        }
        if ($layout === 'all') {
            $price_class = 'all_price';
            $price_inner = $price_html;
            if ($price_inner !== '') {
                $price_inner = str_replace('class="best_price"', 'class="' . $price_class . '"', $price_inner);
            }
            return '<div class="all_box01">'
                . '<div class="all_img"><a href="' . htmlspecialchars($view_url, ENT_QUOTES, 'UTF-8') . '">'
                . '<img src="' . htmlspecialchars($img_url, ENT_QUOTES, 'UTF-8') . '" alt="' . $title_plain . '">'
                . '</a></div>'
                . '<p class="all_text" style="padding-bottom:5px;height: auto;"><a href="' . htmlspecialchars($view_url, ENT_QUOTES, 'UTF-8') . '" class="a_3">' . $title . '</a></p>'
                . $price_inner
                . '</div>';
        }
        return '<div class="best_box01">'
            . '<div class="best_img"><a href="' . htmlspecialchars($view_url, ENT_QUOTES, 'UTF-8') . '">'
            . '<img src="' . htmlspecialchars($img_url, ENT_QUOTES, 'UTF-8') . '" alt="' . $title_plain . '">'
            . '</a></div>'
            . '<p class="best_text" style="padding-bottom:5px;text-align:center;"><a href="' . htmlspecialchars($view_url, ENT_QUOTES, 'UTF-8') . '" class="a_3">' . $title . '</a></p>'
            . $price_html
            . '</div>';
    }
}

if (!function_exists('pkshop_promo_frame_html')) {
    function pkshop_promo_frame_html($frame_rows, $layout, $savedir = '//pentakleva.shop/upload/', $type = '') {
        $html = '';
        if (!is_array($frame_rows)) {
            return $html;
        }
        foreach ($frame_rows as $row) {
            $html .= pkshop_promo_card_html($row, $layout, $savedir, $type);
        }
        return $html;
    }
}

if (!function_exists('pkshop_promo_render_rotating_section')) {
    function pkshop_promo_render_rotating_section($options) {
        $container_id = $options['container_id'];
        $frames = isset($options['frames']) ? $options['frames'] : array();
        $layout = isset($options['layout']) ? $options['layout'] : 'best';
        $interval_sec = isset($options['interval_sec']) ? (int)$options['interval_sec'] : 30;
        $savedir = isset($options['savedir']) ? $options['savedir'] : '//pentakleva.shop/upload/';
        $type = isset($options['type']) ? $options['type'] : '';
        $empty_message = isset($options['empty_message']) ? $options['empty_message'] : '표시할 상품이 없습니다.';

        if (empty($frames)) {
            echo '<p style="text-align:center;color:#666;padding:20px 0;">' . htmlspecialchars($empty_message, ENT_QUOTES, 'UTF-8') . '</p>';
            return;
        }

        $html_frames = array();
        foreach ($frames as $frame) {
            $html_frames[] = pkshop_promo_frame_html($frame, $layout, $savedir, $type);
        }
        if (empty($html_frames[0])) {
            echo '<p style="text-align:center;color:#666;padding:20px 0;">' . htmlspecialchars($empty_message, ENT_QUOTES, 'UTF-8') . '</p>';
            return;
        }

        echo '<div id="' . htmlspecialchars($container_id, ENT_QUOTES, 'UTF-8') . '" class="pkshop-promo-rotate pkshop-promo-rotate--' . htmlspecialchars($layout, ENT_QUOTES, 'UTF-8') . '" data-interval="' . (int)$interval_sec . '">';
        echo $html_frames[0];
        echo '</div>';

        if (count($html_frames) > 1) {
            $json = json_encode($html_frames, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
            if ($json === false) {
                $json = '[]';
            }
            echo '<script>if (window.pkshopPromoRotateRegister) { pkshopPromoRotateRegister('
                . json_encode($container_id) . ', ' . $json . ', ' . (int)$interval_sec . '); }</script>';
        }
    }
}
