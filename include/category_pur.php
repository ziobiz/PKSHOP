
			<div class="sub05_category">
<!-- 				<div class="category_box01"> -->
<!-- 					<div class="sp30"></div> -->
<!-- 					<h1>SEARCH</h1> -->
<!-- 					<div class="sp10"></div> -->
<!-- 					<div class="category_line"></div> -->
<!-- 					<div class="sp15"></div> -->
<!-- 					<form> -->
<!-- 						<input type="text" name="search" placeholder="청소기"> -->
<!-- 					</form> -->
<!-- 					<div class="sp10"></div> -->
<!-- 					<a href="#"><img src="../sub04/images/search_button.jpg"></a> -->
<!-- 					<div class="sp15"></div> -->
<!-- 				</div> -->
				<div class="category_box02">
					<div class="sp10"></div>
	<?	

		$code1 = substr($left_code, 0, 2);
		$code2 = substr($left_code, 2, 2);
		$code3 = substr($left_code, 4, 2);
		$code4 = substr($left_code, 6, 2);

		//1차분류
		//$query_tt = "SELECT code1,cate1 FROM $shop_cate where  code2='00' and code3='00' and code4='00' and code1='$code1' order by order_rank";

		$data = "deId=e7bb77ca2517821473681d3e9fe132e54c21bdff0ef170596f0414032aac3dbc&userid=".$_SESSION['member_id']."&Type=cate1&cate1=".$code1;
		
		
		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_URL, $api_history);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt ($ch, CURLOPT_POST, 1);
		curl_setopt ($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt ($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec ($ch);
		curl_close ($ch);
		

		$json_o = json_decode($result,true);

		$count = count($json_o);

		
		$total_record_tt = $count;
		//echo "$total_record_tt";
		//exit;
		
		for($i_tt  = 0; $i_tt  < $total_record_tt ; $i_tt ++) {

			$menu_code1 = $json_o[$i_tt]['code'];
			$menu_title1 = $json_o[$i_tt]['cate'];

			$menu_code123=$menu_code1;


		?>
		<div class="sp10"></div>
			<ul class="category_list">
					<li class="category_listTitle category_listTitle2">
						<a href="../sub04/list.php?left_code=<?=$menu_code123?>000000">
							<?=$menu_title1?>
						</a>
		<div class="sp10"></div>
			<div class="category_line02"></div>
			<!-- <span class="submenu_title"><?=$menu_title1?></span><br/><br/> -->
				<?
				//2차분류
			
				$data = "deId=e7bb77ca2517821473681d3e9fe132e54c21bdff0ef170596f0414032aac3dbc&userid=".$_SESSION['member_id']."&Type=cate2&cate1=".$menu_code123;
				
	
				$ch = curl_init();
				curl_setopt ($ch, CURLOPT_URL, $api_history);
				curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 1);
				curl_setopt ($ch, CURLOPT_POST, 1);
				curl_setopt ($ch, CURLOPT_POSTFIELDS, $data);
				curl_setopt ($ch, CURLOPT_TIMEOUT, 30);
				curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
				$result = curl_exec ($ch);
				curl_close ($ch);
				
				
				$json_o = json_decode($result,true);

				$count = count($json_o);
				
				$total_record_tm = $count;
				?>

				<?if($total_record_tm>0){?>
					<?
					 for($i_tm  = 0; $i_tm  < $total_record_tm ; $i_tm ++) {
					
						$menu_code2 = $json_o[$i_tm]['code2'];
						$menu_title2 = $json_o[$i_tm]['cate2'];
						$order_rank = $json_o[$i_tm]['order_rank'];
						$cc_code=$menu_code2;	
						$menu_code222 = $menu_code123.$cc_code;
								

						
							
					
					#####################################################################
					?>	
					<ul class="category_subList" style="margin-top:10px;">
					
						<li><a href="../sub04/list.php?left_code=<?=$menu_code222?>&type=1">- <?=$menu_title2?></a></li>
						<?
				//2차분류
			
				$data = "deId=e7bb77ca2517821473681d3e9fe132e54c21bdff0ef170596f0414032aac3dbc&userid=".$_SESSION['member_id']."&Type=cate33&cate1=".$menu_code123."&cate2=".$menu_code2;
				
	
				$ch = curl_init();
				curl_setopt ($ch, CURLOPT_URL, $api_history);
				curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 1);
				curl_setopt ($ch, CURLOPT_POST, 1);
				curl_setopt ($ch, CURLOPT_POSTFIELDS, $data);
				curl_setopt ($ch, CURLOPT_TIMEOUT, 30);
				curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
				$result_tt = curl_exec ($ch);
				curl_close ($ch);
				// echo $result_tt;
				
				$json_o_tt = json_decode($result_tt,true);

				$count_tt = count($json_o_tt);
				
				$total_record_tt = $count_tt;
				?>

				<?if($total_record_tt>0){?>
					<?
					 for($i_tt  = 0; $i_tt  < $total_record_tt ; $i_tt ++) {
					
						$menu_code3 = $json_o_tt[$i_tt]['code3'];
						$menu_title3 = $json_o_tt[$i_tt]['cate3'];
						$order_rank = $json_o_tt[$i_tt]['order_rank'];
						$cc_code=$menu_code3;	
						$menu_code333 = $menu_code222.$cc_code;
								

						
							
					
					#####################################################################
					?>	
						<li ><a style="    font-size: 13px;   color: #686868;" href="../sub04/list.php?left_code=<?=$menu_code333?>&type=1">- <?=$menu_title3?></a></li>
					<?}
					}?>
					<p style="display: block;clear:both;height: 1px;">&nbsp;</p>
					<!-- <br> -->
					<?}?>
					
					</ul>
				<?}?>

		<?}?>		
				</li>
					</ul>
	

						</li>


					<div class="sp10"></div>
				</div>
			</div>