<?include "../include/get_balance.php";?>
<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
    <? 
	

	    include "../include/login_check.php";?>
 </head>
 <body>
	<div class="wrap">	

	<!-- 상단(Top) -->

	 
	  <? include "../include/top.php"; ?>

				
	<!-- 상단(Top) -->

	<!-- 컨텐츠 시작 -->
		
		<div class="content_inner">

			<div class="sp40"></div>

			 <!-- 카테고리 -->

			<? include "../include/category_info.php"; ?>

			<!-- 카테고리 끝 -->



			<div class="content">

				<div class="page_title">
					Check the points.
				</div>
				<?
				$ords = json_decode(curl_d($api_cart,"&Type=pointList&session_cart=$session_cart"),true);

				$total_record = $ords[0]["count"];
				
				?>

				<div class="point_sum">
					<table class="point_table">
						<tr>
							<th width="100%">
								Your available shopping point.
								<div class="sp10"></div>
								<span class="c_red font_48"><?=number_format($json_balance["total_SP"])?></span> <span class="font_24"></span>
							</th>
						</tr>
					</table>
				</div>

				<div class="sp80"></div>

				<div class="point_title">
					<span class="c_orange">Shopping point.</span> <span class="font_12 c_9">This is the usage history of HCBRS.</span>
				</div>
				<table class="cart_table">
					<tr>
						<th width="20%">Shopping point</th>					
						<th width="25%">Registration date</th>
					</tr>
				<?
	
			if ($valid_user == "")
			{
				exit;
			}
			else
			{

				for($i=0;$i<$total_record;$i++) {
					
					$usepoint	= $ords[$i]['usepoint'];
					$signdate		= date("Y-m-d",$ords[$i]['signdate']);
#####################################################################
?> 



				<tr style="border-bottom: 1px solid #e0e0e0;">
					<td><?=$usepoint?></td>
					<td><?=$signdate?></td>
				</tr>
<?
		}
  }
  

?>
					</table>
				</table>

			</div>
		</div>
	<!-- 컨텐츠 종료 -->


	<!-- 하단(Copy) -->

	 <div class="sp50"></div>
	  <? include "../include/bottom.php"; ?>	  
				
				
	<!-- 하단(Copy) -->

	


</div>
</body>
</html>
