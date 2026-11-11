<?php
/**
 * Main page product list helpers (PHP 8.4 safe grid rendering).
 */

if (!function_exists('pkshop_main_upload_base')) {
	function pkshop_main_upload_base() {
		$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'pentakleva.shop';
		$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
		return $scheme . '://' . $host . '/upload/';
	}
}

if (!function_exists('pkshop_main_filter_products')) {
	function pkshop_main_filter_products($rows, $shop_country = '1') {
		if (!is_array($rows)) {
			return array();
		}
		$shop_country = (string)$shop_country;
		if ($shop_country === '') {
			$shop_country = '1';
		}
		$out = array();
		foreach ($rows as $row) {
			if (!is_array($row)) {
				continue;
			}
			$country = isset($row['country']) ? (string)$row['country'] : '';
			// Keep items with empty country; only skip clear mismatches.
			if ($country !== '' && $country !== $shop_country) {
				continue;
			}
			$imgl = isset($row['imgl']) ? trim((string)$row['imgl']) : '';
			$imgb1 = isset($row['imgb1']) ? trim((string)$row['imgb1']) : '';
			if ($imgl === '' && $imgb1 === '') {
				continue;
			}
			$out[] = $row;
		}
		return $out;
	}
}

if (!function_exists('pkshop_main_product_price')) {
	function pkshop_main_product_price($row) {
		$pricec = isset($row['pricec']) ? $row['pricec'] : 0;
		$prices = isset($row['prices']) ? $row['prices'] : 0;
		$priced = isset($row['priced']) ? $row['priced'] : 0;
		$cook_dis = isset($GLOBALS['cook_dis']) ? $GLOBALS['cook_dis'] : '';
		$cook_dis1 = isset($GLOBALS['cook_dis1']) ? $GLOBALS['cook_dis1'] : '';
		if ($cook_dis == '1' && $cook_dis1 == '승인') {
			return $priced;
		}
		if ($cook_dis == '2' && $cook_dis1 == '승인') {
			return $pricec;
		}
		if ($cook_dis == '3' && $cook_dis1 == '승인') {
			return $prices;
		}
		if ((float)$priced > 0) {
			return $priced;
		}
		return $pricec;
	}
}

if (!function_exists('pkshop_main_render_card')) {
	function pkshop_main_render_card($row, $opts = array()) {
		$box = isset($opts['box']) ? $opts['box'] : 'best_box01';
		$text = isset($opts['text']) ? $opts['text'] : 'best_text';
		$price_cls = isset($opts['price']) ? $opts['price'] : 'best_price';
		$img_wrap = isset($opts['img']) ? $opts['img'] : 'best_img';
		$type = isset($opts['type']) ? $opts['type'] : '';
		$shop_jpy_rate = isset($opts['rate']) ? $opts['rate'] : (isset($GLOBALS['shop_jpy_rate']) ? $GLOBALS['shop_jpy_rate'] : 0);
		$show_price = !empty($_SESSION['member_id']);

		$code = isset($row['code']) ? $row['code'] : '';
		$code1 = isset($row['code1']) ? $row['code1'] : '';
		$code2 = isset($row['code2']) ? $row['code2'] : '';
		$code3 = isset($row['code3']) ? $row['code3'] : '';
		$code4 = isset($row['code4']) ? $row['code4'] : '';
		$title = isset($row['title']) ? $row['title'] : '';
		if (!empty($row['onlypoint']) && (string)$row['onlypoint'] === '1') {
			$title .= " <span style='color:#ff0000;'> [InT Only]</span>";
		}
		$imgl = isset($row['imgl']) ? trim((string)$row['imgl']) : '';
		$imgb1 = isset($row['imgb1']) ? trim((string)$row['imgb1']) : '';
		$savedir = pkshop_main_upload_base();
		$img = $imgl !== '' ? ($savedir . $imgl) : ($savedir . $imgb1);
		$href = '../sub04/view.php?left_code=' . rawurlencode($code)
			. '&code1=' . rawurlencode($code1)
			. '&code2=' . rawurlencode($code2)
			. '&code3=' . rawurlencode($code3)
			. '&code4=' . rawurlencode($code4)
			. '&theme=f&type=' . rawurlencode((string)$type);
		$price_tmp = pkshop_main_product_price($row);

		echo '<div class="' . htmlspecialchars($box, ENT_QUOTES, 'UTF-8') . '">';
		echo '<div class="' . htmlspecialchars($img_wrap, ENT_QUOTES, 'UTF-8') . '">';
		echo '<a href="' . htmlspecialchars($href, ENT_QUOTES, 'UTF-8') . '">';
		echo '<img src="' . htmlspecialchars($img, ENT_QUOTES, 'UTF-8') . '" border="0" alt="">';
		echo '</a></div>';
		echo '<p class="' . htmlspecialchars($text, ENT_QUOTES, 'UTF-8') . '" style="padding-bottom:5px;text-align:center;">';
		echo '<a href="' . htmlspecialchars($href, ENT_QUOTES, 'UTF-8') . '" class="a_3">' . $title . '</a></p>';
		if ($show_price && function_exists('shop_format_usd_jpy_dual')) {
			echo '<p class="' . htmlspecialchars($price_cls, ENT_QUOTES, 'UTF-8') . '" style="text-align:center;font-weight:bold;font-size:16px;color:#c3070b">';
			echo '<a href="' . htmlspecialchars($href, ENT_QUOTES, 'UTF-8') . '" class="c_red">' . shop_format_usd_jpy_dual($price_tmp, $shop_jpy_rate) . '</a></p>';
		}
		echo '</div>';
	}
}
