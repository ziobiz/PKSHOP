<?
	include_once( "../lib/basic_class2.php") ;
	include_once( "../lib/config.php");
	include_once( "../lib/common.php");
	include_once( "../lib/php_function.php"); 

	

	$deId		= $_POST['deId'];
	$userid		= $_POST['userid'];


	if ($deId != $store_key)
	{
		$result = array("result"=>"0","msg"=>"deId is wrong");
		echo json_encode($result);
		exit;
	}
	else
	{


	$nc = 6;
	$a='0123456789';
     $l=strlen($a)-1; $rr='';
     while($nc-->0) $rr.=$a{mt_rand(0,$l)};
 
		if ($_POST['userid'] != "")
		{

			$DB->get("select * from $member_table where C_ID='$userid'", $rs, $rn);
	
			if ($rn == "")
			{
					$result = array("result"=>"0","msg"=>"userid is empty");
					echo json_encode($result);
					exit;
			
			}
			
			if ($rs[0]['C_EMAIL'] == "")
			{
					$result = array("result"=>"0","msg"=>"user email is empty");
					echo json_encode($result);
					exit;
			
			}
			else
			{

				$to_mail = trim($rs[0]['C_EMAIL']);

				$Name = "MSGLOBAL";
				$toName = $rs[0]['C_NAME'];
				$subject = "MSGLOBAL System : MSGLOBAL Password change";
				$content="<div id='wrap' style='height: 100%;background:url(https://msglobal.io/images/visual.jpg)no-repeat;background-size: 100% 100%;'><div class='menu_c' style='text-align: center;padding-bottom: 20px;border-bottom: 2px dotted rgba(255,255,255,0.1);width: 50%;margin: 0 auto;'><img src='https://msglobal.io/images/logo.png' style='width:90px;margin-top:20px;'></div><div class='header_title' style='float: left;color: #fff;text-align: center;font-size: 1.3em;width: 100%;margin-bottom: 10px; margin-top: 70px;'><div class='sp10'></div><span style='font-size: 25px;font-weight: 700;'>We will send Password number.</span><div class='sp10'></div></div><p style='font-size: 20px;color: #ffffff;text-align: Center;height: 220px;line-height: 110px;font-weight: 700;'>Password : <span style='color: #ffe84d;padding: 10px;'>".$rr."</span></p><div id='container' style='position: relative;padding: 15px 3% 20px;'><div class='notice_view01' style='border-top: 1px solid rgba(255, 255, 255, 0.1);padding-top: 10px;clear: both;'><div class='notice_text' style='font-size: 15px;color: #fff;padding: 10px 10px; min-height: 115px;background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.1);margin-top: 15px;border-top: 2px solid rgb(181, 159, 116);border-radius: 3px;'><div style='text-align:center;padding-top:20px;'><span style='font-size:23px;'>Thank you!!</span><br><br>MSGLOBAL System Support Team</div></div></div></div></div>";

				$aa = '{"personalizations": [{"to": [{"email": "'.$to_mail.'","name": "'.$toName.'"}],"subject": "'.$subject.'"}],"from": {"email": "MSGLOBAL@gmail.com","name": "'.$Name.'"},"reply_to": {"email": "MSGLOBAL@gmail.com","name": "'.$Name.'"},"content": [{"type": "text/html","value": "'.$content.'"}]}';

				$ch3 = curl_init();
				curl_setopt ($ch3, CURLOPT_URL, "https://api.sendgrid.com/v3/mail/send");
				curl_setopt($ch3, CURLOPT_HEADER, true);
				curl_setopt($ch3, CURLOPT_HTTPHEADER, array( 'Authorization: Bearer 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','Content-Type: application/json'));
				curl_setopt ($ch3, CURLOPT_SSL_VERIFYPEER, 1);
				curl_setopt ($ch3, CURLOPT_POST, 0);
				curl_setopt ($ch3, CURLOPT_POSTFIELDS,$aa);
				curl_setopt ($ch3, CURLOPT_TIMEOUT, 30);
				curl_setopt ($ch3, CURLOPT_RETURNTRANSFER, 1);
				$result_send = curl_exec($ch3);

				if(strpos($result_send, "errors") !== false) {  
					$result = array("result"=>"0","msg"=>"Mail transfer is fail !!");
					echo json_encode($result);	
					exit;
				}
				else
				{
					$pass = $rr;
					$sql = "C_PASS='$pass' where C_CODE='".$rs[0]['C_CODE']."'";
					$DB->update($member_table, $sql);

					$result = array("result"=>"1","msg"=>"Check your Email!");
					echo json_encode($result);
					exit;
				}
			}
		}
		else
		{
			$result = array("result"=>"1","msg"=>"userid is empty");
			echo json_encode($result);
			exit;
		
		}

		
	}
?>