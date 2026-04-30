<?
   include "../include/com.php";

   
   include "../include/get_balance.php";

   $amount		= $_POST['amount'];
   $fpass		= $_POST['fpass'];

   $dash_price = $_POST['dprice'];	


	if ($dash_balance < $amount)
	{
			$tools->alertJavaGo("금액이 부족합니다","../sub/public.php");		
	}
	else 
	{
		$id = $_SESSION['member_id'];

		$spw = hash('sha256',$fpass);

		$data = "deId=e7bb77ca2517821473681d3e9fe132e54c21bdff0ef170596f0414032aac3dbc&userid=".$id."&passwd=".$spw."&amount=".$amount."&dprice=".$dash_price;

					
		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_URL, $api_purchase);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt ($ch, CURLOPT_POST, 1);
		curl_setopt ($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt ($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec ($ch);
		curl_close ($ch);
		
		$json_o = json_decode($result,true);
		
		$tools->alertJavaGo($json_o['msg'],"../sub/public.php");		
	
	}
?>