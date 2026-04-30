<?	include "../include/com.php";


	$id = trim($_POST['id']);
	$pass = trim($_POST['passwd']);

	$sid = str_replace("'","",str_replace("?","",str_replace("!","",str_replace("%","",$id))));
	//$spw = hash('sha256',$pass);


	if ($sid == "")
	{
		echo "<script language='javascript'> location.replace('login.php'); </script>";
	}
	else
	{
		$data = "deId=e7bb77ca2517821473681d3e9fe132e54c21bdff0ef170596f0414032aac3dbc&logid=".$sid."&logpwd=".$pass;

		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_URL, $api_login);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt ($ch, CURLOPT_POST, 1);
		curl_setopt ($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt ($ch, CURLOPT_TIMEOUT, 5);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec ($ch);
		// echo $api_login;
		// echo $result;exit;
		curl_close ($ch);

		$json_o = json_decode($result,true);

		if ($json_o['result'] == "0")
		{
			echo "<script language='javascript'> alert('".$json_o['msg']."'); location.replace('login.php'); </script>";
		}
		else if ($json_o['mycode'] != "")
		{
			$_SESSION['member_id']	= strtolower($sid);
			$_SESSION['member_code'] = $json_o['mycode'];


			echo "<script language='javascript'> location.href='../main/main.html'; </script>";
		}
		else
		{
			echo "<script language='javascript'> alert('".$json_o['msg']."'); location.replace('login.php'); </script>";


		}

	}
?>
