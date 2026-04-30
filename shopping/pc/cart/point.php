<?include "../include/top_session.php";?>
<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
    <? include "../../Adm/common/dbconn.php";
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
					포인트조회
				</div>


				<div class="point_sum">
					<table class="point_table">
						<tr>
							<th width="100%">
								현재 고객님의 사용가능 GP
								<div class="sp10"></div>
								<span class="c_red font_48"><?=number_format($GP,2)?></span> <span class="font_24"></span>
							</th>
						</tr>
					</table>
				</div>

				<div class="sp80"></div>

				<div class="point_title">
					<span class="c_orange">GP</span> 적립 <span class="font_12 c_9">HCBRS에서 사용/적립 내역입니다.</span>
				</div>
				<table class="cart_table">
					<tr>
						<th width="20%">GP</th>					
						<th width="25%">등록일</th>
					</tr>
				<?

			if ($valid_user == "")
			{
				exit;
			}
			else
			{


$query = "select ordernum, kind, charge, status,char_num from $shop_order where id = '$valid_user' and status='결제완료' order by ordernum desc";

 $result= mysql_query($query,$DBconn);
 if (!$result) {
 	error("QUERY_ERROR");
 	exit;
 }
 
 $total_record = mysql_num_rows($result);

 ####################################################################


?>	


<?
if($total_record > 0) {

  $flag = 0;
  for($i=0;$i<$total_record;$i++) {

	$ordernum = mysql_result($result,$i,0);
	$kind = mysql_result($result,$i,1);
	$charge = mysql_result($result,$i,2);
	$status = mysql_result($result,$i,3);
	$char_num = mysql_result($result,$i,4);

    $query1 = "SELECT ordernum,signdate, title, money , count , opt1,code, coin, prices FROM $shop_sell where ordernum = '$ordernum'";
 
    $result1 = mysql_query($query1,$DBconn);
    if (!$result1) {
 	  error("QUERY_ERROR");
 	  exit;
    }
 
    $total_record1 = mysql_num_rows($result1);

	if($i==0) $ordernum_last=$ordernum;

	for($j = 0; $j < $total_record1; $j++) {

		$o_ordernum = mysql_result($result1,$j,0);
		$o_signdate = mysql_result($result1,$j,1);
		$o_title = mysql_result($result1,$j,2);
		$o_money1 = mysql_result($result1,$j,3);
		$count_sm = mysql_result($result1,$j,4);
		$o_opt1 = mysql_result($result1,$j,5);
		$o_code = mysql_result($result1,$j,6);
		$o_coin = mysql_result($result1,$j,7);
		$o_price = mysql_result($result1,$j,8);

		$o_signdate = date("Y.m.d",$o_signdate);	


		
			$Point_kk = $o_coin * 0.5;
#####################################################################
?> 



				<tr>
					<td><?=$Point_kk?></td>
					<td><?=$o_signdate?></td>
				</tr>
<?
		}
  }}
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
