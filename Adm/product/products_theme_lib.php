<?php

function pkshop_products_rebuild_theme($theme_g, $theme_r, $theme_n, $theme_f, $theme_x, $theme_y, $theme_z, $theme_s) {
	return trim($theme_g . ' ' . $theme_r . ' ' . $theme_n . ' ' . $theme_f . ' ' . $theme_x . ' ' . $theme_y . ' ' . $theme_z . ' ' . $theme_s);
}

function pkshop_products_update_themes(&$DB, $shop_goods, $no, $theme_n, $theme_r, $theme_f) {
	$no = intval($no);
	if ($no <= 0) {
		return false;
	}

	$query = "SELECT theme_g, theme_n, theme_r, theme_f, theme_x, theme_y, theme_z, theme_s, rank_n, rank_r, rank_f FROM $shop_goods WHERE No='$no' LIMIT 1";
	$DB->get($query, $rs, $rn);
	if ($rn < 1) {
		return false;
	}

	$row = $rs[0];
	$theme_g = isset($row['theme_g']) ? $row['theme_g'] : (isset($row[0]) ? $row[0] : '');
	$theme_x = isset($row['theme_x']) ? $row['theme_x'] : (isset($row[4]) ? $row[4] : '');
	$theme_y = isset($row['theme_y']) ? $row['theme_y'] : (isset($row[5]) ? $row[5] : '');
	$theme_z = isset($row['theme_z']) ? $row['theme_z'] : (isset($row[6]) ? $row[6] : '');
	$theme_s = isset($row['theme_s']) ? $row['theme_s'] : (isset($row[7]) ? $row[7] : '');
	$rank_n = isset($row['rank_n']) ? $row['rank_n'] : (isset($row[8]) ? $row[8] : '');
	$rank_r = isset($row['rank_r']) ? $row['rank_r'] : (isset($row[9]) ? $row[9] : '');
	$rank_f = isset($row['rank_f']) ? $row['rank_f'] : (isset($row[10]) ? $row[10] : '');

	$theme_n = ($theme_n === 'n') ? 'n' : '';
	$theme_r = ($theme_r === 'r') ? 'r' : '';
	$theme_f = ($theme_f === 'f') ? 'f' : '';

	if ($theme_n === '') {
		$rank_n = '99999';
	}
	if ($theme_r === '') {
		$rank_r = '99999';
	}
	if ($theme_f === '') {
		$rank_f = '99999';
	}

	$theme = pkshop_products_rebuild_theme($theme_g, $theme_r, $theme_n, $theme_f, $theme_x, $theme_y, $theme_z, $theme_s);
	$theme = addslashes($theme);

	$DB->update(
		$shop_goods,
		"theme_n='$theme_n', theme_r='$theme_r', theme_f='$theme_f', rank_n='$rank_n', rank_r='$rank_r', rank_f='$rank_f', theme='$theme' WHERE No='$no'"
	);

	return true;
}
