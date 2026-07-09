

<?php
if (!function_exists('pkshop_site_setting')) {
	require_once dirname(__FILE__) . '/site_settings_lib.php';
}
$pk = pkshop_site_settings();
?>
<div id="footer_2">
	    <div class="inner">
	        <div class="item-0 item-1">
	            <p class="text-tit"><?=htmlspecialchars($pk['footer_cs_title'], ENT_QUOTES, 'UTF-8')?></p>
	            <p class="p1"><?=htmlspecialchars($pk['footer_cs_line1'], ENT_QUOTES, 'UTF-8')?></p>
	            <p class="p1"><?=htmlspecialchars($pk['footer_cs_line2'], ENT_QUOTES, 'UTF-8')?></p>
	        </div>
	        <div class="item-0 item-1">
	            <p class="text-tit"><?=htmlspecialchars($pk['footer_bank_title'], ENT_QUOTES, 'UTF-8')?></p>
				<div class="div01">
	            <p style="font-size:12px;"><?=htmlspecialchars($pk['footer_bank_line1'], ENT_QUOTES, 'UTF-8')?></p>
	            </div><BR>
				<div class="div01">
					<p style="font-size:11px;"><?=htmlspecialchars($pk['footer_bank_line2'], ENT_QUOTES, 'UTF-8')?></p>
	            </div>
	        </div>
	        <div class="item-0 item-3">
	            <p class="text-tit"><?=htmlspecialchars($pk['footer_history_title'], ENT_QUOTES, 'UTF-8')?></p>
	            <div class="div01">
	                <ul>
	                    <li>
	                        <a href="../cart/overview.php">
	                            <img src="<?=htmlspecialchars($pk['footer_icon_myinfo'], ENT_QUOTES, 'UTF-8')?>">
	                            <p>MY INFO</p>
	                        </a>
	                    </li>
	                    <li>
	                        <a href="../cart/cart.php">
	                            <img src="<?=htmlspecialchars($pk['footer_icon_cart'], ENT_QUOTES, 'UTF-8')?>">
	                            <p>CART</p>
	                        </a>
	                    </li>
	                </ul>
	            </div>
	        </div>
	        <div class="item-0 item-4">
	            <p class="text-tit"><?=htmlspecialchars($pk['footer_delivery_title'], ENT_QUOTES, 'UTF-8')?></p>
	            <p class="p1"><?=htmlspecialchars($pk['footer_delivery_line1'], ENT_QUOTES, 'UTF-8')?></p>
	        </div>
	    </div>
	</div>

	<div id="footer">
	    <div class="footer_top">
	        <a href="../main/main.html"><?=htmlspecialchars($pk['footer_link_home'], ENT_QUOTES, 'UTF-8')?></a>
	        <div class="footer_top_bar"></div>
	        <a href="../member/agree.php"><?=htmlspecialchars($pk['footer_link_terms'], ENT_QUOTES, 'UTF-8')?></a>
	        <div class="footer_top_bar"></div>
	        <a href="../member/agree.php"><?=htmlspecialchars($pk['footer_link_policy'], ENT_QUOTES, 'UTF-8')?></a>
	        <div class="footer_top_bar"></div>
	    </div>

	    <div class="footer_middle">
	        <div class="sp30"></div>
	        <div class="footer_middle_box">
	            <p class="footer_middle_title"><span><?=htmlspecialchars($pk['footer_about_title'], ENT_QUOTES, 'UTF-8')?></span></p>
	            <div class="footer_middle_titlebar"></div>
	            <p class="company_text"><span><?=htmlspecialchars($pk['footer_company_label'], ENT_QUOTES, 'UTF-8')?></span>&nbsp;&nbsp;<?=htmlspecialchars($pk['footer_company_name'], ENT_QUOTES, 'UTF-8')?>
	                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><?=htmlspecialchars($pk['footer_ceo_label'], ENT_QUOTES, 'UTF-8')?></span>&nbsp;&nbsp;<?=htmlspecialchars($pk['footer_ceo'], ENT_QUOTES, 'UTF-8')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	                <span><?=htmlspecialchars($pk['footer_address_label'], ENT_QUOTES, 'UTF-8')?></span>&nbsp;&nbsp;<?=htmlspecialchars($pk['footer_address'], ENT_QUOTES, 'UTF-8')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	               <span><?=htmlspecialchars($pk['footer_tel_label'], ENT_QUOTES, 'UTF-8')?></span>&nbsp;&nbsp;<?=htmlspecialchars($pk['footer_tel'], ENT_QUOTES, 'UTF-8')?>
	                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><?=htmlspecialchars($pk['footer_fax_label'], ENT_QUOTES, 'UTF-8')?></span>&nbsp;&nbsp;<?=htmlspecialchars($pk['footer_fax'], ENT_QUOTES, 'UTF-8')?><br>
	        <span><?=htmlspecialchars($pk['footer_biz_label'], ENT_QUOTES, 'UTF-8')?></span>&nbsp;&nbsp;<?=htmlspecialchars($pk['footer_biz_no'], ENT_QUOTES, 'UTF-8')?>
	                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><span><?=htmlspecialchars($pk['footer_mail_order_label'], ENT_QUOTES, 'UTF-8')?></span>&nbsp;&nbsp;<?=htmlspecialchars($pk['footer_mail_order'], ENT_QUOTES, 'UTF-8')?>
	        </div>
	        <div class="sp30"></div>
<?php if (!empty($pk['footer_bottom_image'])) {
	$fbw = isset($pk['footer_bottom_image_width']) ? $pk['footer_bottom_image_width'] : 1200;
	$fbh = isset($pk['footer_bottom_image_height']) ? $pk['footer_bottom_image_height'] : 0;
	$fbstyle = pkshop_site_image_style_attr($fbw, $fbh, 1200, 0);
?>
	        <div class="footer-bottom-image-wrap" style="text-align:center;padding-bottom:20px;">
	            <img src="<?=htmlspecialchars($pk['footer_bottom_image'], ENT_QUOTES, 'UTF-8')?>" alt="" class="footer-bottom-image"<?=$fbstyle?>>
	        </div>
<?php } ?>
	    </div>

	    <div class="footer_bottom">
	        <div class="footer_bottom_inner">
	            <p class="copy"><?=htmlspecialchars($pk['footer_copyright'], ENT_QUOTES, 'UTF-8')?></p>
	        </div>
	    </div>
	</div>
