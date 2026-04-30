<?	
//  error_reporting( E_ALL );
//  ini_set( "display_errors", 1 );

include $_SERVER["DOCUMENT_ROOT"]."/include/com.php";

	$nname			= $_POST['name1'];

	// $nname			= $_POST['username'];
	
	$tel_1			= trim($_POST['tel_1']);
	$tel_2			= trim($_POST['tel_2']);
	$tel_3			= trim($_POST['tel_3']);
	$phone			= $tel_1."-".$tel_2."-".$tel_3;
	$country_num		= $_POST['m_contury'];
	$passwd			= trim($_POST['passwd']);
	$fin_pass		= trim($_POST['pin']);
	$c_id			= trim($_POST['s_username']);
	$email			= $_POST['email'];
	$c_c_id			= trim($_POST['c_username']);
	$C_ZIP			= trim($_POST['C_ZIP']);
	$C_ADDR			= trim($_POST['C_ADDR']);
	$C_ADDR2			= trim($_POST['C_ADDR2']);
	$jisa = trim($_POST["jisa"]);

	$certi_input=trim($_POST['veri_code']);
	$certi_code=$_SESSION['smsveri'];

	$email_code=trim($_POST['veri_code']);
	$emailveri=$_SESSION['emailveri'];
	
	$h_username = trim($_POST["h_username"]);
	$center = trim($_POST["center"]);
	$cap = $_SESSION['capt'];
	$capcode = trim($_POST['capcode']);

	$nname = str_replace(",","",$nname);
	
	
	// if(!password_verify($certi_input,$certi_code)){
	// 	$result = array("result"=>"0","msg"=>"Please check the authentication number.");
	// 	echo json_encode($result);
	// 	exit;
	
	// }
	
	


	$request_uri = $_SERVER['REQUEST_URI'];
	$request_uri = str_replace("/","",$request_uri);
	$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	$sid=$c_id;

	$data = "deId=e7bb77ca2517821473681d3e9fe132e54c21bdff0ef170596f0414032aac3dbc&logid=".$sid."&url=".$request_uri."&ip=".$ip;

	$ch22 = curl_init();
	curl_setopt ($ch22, CURLOPT_URL, $api_acount);
	curl_setopt ($ch22, CURLOPT_SSL_VERIFYPEER, 1);
	curl_setopt ($ch22, CURLOPT_POST, 1);
	curl_setopt ($ch22, CURLOPT_POSTFIELDS, $data);
	curl_setopt ($ch22, CURLOPT_TIMEOUT, 30);
	curl_setopt ($ch22, CURLOPT_RETURNTRANSFER, 1);
	$result22 = curl_exec ($ch22);
	curl_close ($ch22);


	$data = "deId=e7bb77ca2517821473681d3e9fe132e54c21bdff0ef170596f0414032aac3dbc&n_name=".$nname."&passwd=".$passwd."&fin_passwd=".$fin_pass."&phone=".$phone."&m_contury=".$country_num."&c_id=".$c_id."&email=".$email."&c_c_id=".$c_c_id."&certi_input=".$certi_input."&certi_code=".$certi_code."&h_username=".$h_username."&center=".$center."&cap=".$cap."&capcode=".$capcode."&email_code=".$email_code."&emailveri=".$emailveri."&jisa=".$jisa."&C_ZIP=".$C_ZIP."&C_ADDR=".$C_ADDR."&C_ADDR2=".$C_ADDR2;

	$ch = curl_init();
	curl_setopt ($ch, CURLOPT_URL, $api_signup);
	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 1);
	curl_setopt ($ch, CURLOPT_POST, 1);
	curl_setopt ($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt ($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec ($ch);
	
	curl_close ($ch);
	$json_o = json_decode($result,true);

	if($json_o['result']=="22"){
		$_SESSION["emailveri"]="";
		
	}
	if($json_o['result']=="23"){
		$_SESSION["emailveri"]="";
		
	}
	echo $result;
	exit;
	

	//echo "<script language='javascript'> alert('".$json_o['msg']."'); location.replace('login.php'); </script>";
?>