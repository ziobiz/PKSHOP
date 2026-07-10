<?php
if (!function_exists('pkshop_site_setting')) {
	require_once dirname(__FILE__) . '/site_settings_lib.php';
}

$pkshop_head_style = isset($pkshop_head_style) ? (string)$pkshop_head_style : 'shop';
$pkshop_page_title = isset($pkshop_page_title) ? trim((string)$pkshop_page_title) : '';
$browser_title = pkshop_site_setting('browser_title', 'Pentakleva');
if ($pkshop_page_title !== '') {
	$document_title = $pkshop_page_title . ' | ' . $browser_title;
} else {
	$document_title = $browser_title;
}
$favicon = pkshop_site_asset_url(pkshop_site_setting('favicon', 'images/pentakleva.ico'));
$og_image = pkshop_site_asset_url(pkshop_site_setting('og_image', '../images/kakao.jpg?=1'));
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1" />
<meta property="og:title" content="<?=htmlspecialchars(pkshop_site_setting('og_title', $browser_title), ENT_QUOTES, 'UTF-8')?>">
<meta property="og:type" content="website">
<meta property="og:image" content="<?=htmlspecialchars($og_image, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:image:width" content="800"/>
<meta property="og:image:height" content="400"/>
<meta property="og:description" content="<?=htmlspecialchars(pkshop_site_setting('og_description'), ENT_QUOTES, 'UTF-8')?>">
<title><?=htmlspecialchars($document_title, ENT_QUOTES, 'UTF-8')?></title>
<?php if ($favicon !== '') {
	$favicon_type = function_exists('pkshop_favicon_mime_type') ? pkshop_favicon_mime_type($favicon) : 'image/x-icon';
?>
<link rel="shortcut icon" type="<?=htmlspecialchars($favicon_type, ENT_QUOTES, 'UTF-8')?>" href="<?=htmlspecialchars($favicon, ENT_QUOTES, 'UTF-8')?>">
<link rel="icon" type="<?=htmlspecialchars($favicon_type, ENT_QUOTES, 'UTF-8')?>" href="<?=htmlspecialchars($favicon, ENT_QUOTES, 'UTF-8')?>">
<?php } ?>
<link rel="stylesheet" href="../include/reset.css">
<?php if ($pkshop_head_style === 'main') { ?>
<link rel="stylesheet" type="text/css" href="../include/style_main.css?v=20260710promogrid" media="screen and (min-width:1024px)"/>
<?php } else { ?>
<link rel="stylesheet" type="text/css" href="../include/style.css" media="screen and (min-width:1024px)"/>
<?php } ?>
<link rel="stylesheet" type="text/css" href="../include/responsive.css" media="screen and (max-width:1023px)"/>
<link rel="stylesheet" href="../include/swiper.min.css">
