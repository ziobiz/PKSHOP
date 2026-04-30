<?
//   error_reporting( E_ALL );
//   ini_set( "display_errors", 1 );
	include_once( "../lib/basic_class.php");
	include_once( "../lib/config.php");
	include_once( "../lib/common.php");
	include_once( "../lib/php_function.php");





	$n_name			= $_POST['n_name'];
	$passwd			= password_hash($_POST['passwd'],PASSWORD_DEFAULT);
	$f_pass			= password_hash($_POST['fin_passwd'],PASSWORD_DEFAULT);
	$phone			= $_POST['phone'];
	$country_num		= $_POST['m_contury'];
	$deId			= $_POST['deId'];
	$c_id			= $_POST['c_id'];
	$email			= $_POST['email'];
	$c_c_id			= $_POST['c_c_id'];
	$certify1			= $_POST['certi_input'];
	$certify2			= $_POST['certi_code'];
	$h_username = $_POST["h_username"];
	$center = $_POST["center"];
	$cap = $_POST["cap"];
	$capcode = $_POST["capcode"];
	$email_code = $_POST["email_code"];
	$emailveri = $_POST["emailveri"];
	$C_ZIP = $_POST["C_ZIP"];
	$C_ADDR = $_POST["C_ADDR"];
	$C_ADDR2 = $_POST["C_ADDR2"];
	$jisa =trim($_POST["jisa"]);

	//추천코드확인
	// if(!password_verify($certify1,$certify2)){
	// 	$result = array("result"=>"0","msg"=>"Please check the authentication number.");
	// 	echo json_encode($result);
	// 	exit;
	// }
	// if(!password_verify($certify1,$certify2)){
	// 	$result = array("result"=>"0","msg"=>"Please check the email code.");
	// 	echo json_encode($result);
	// 	exit;
	// }
	// $DB->single("select * from center where c_name=:c_name  ",$centers,$centern,array("c_name"=>$jisa),"key");
	// if($centern==0){
	// 	$result = array("result"=>"0","msg"=>"Please check the name of the center.");
	// 	echo json_encode($result);
	// 	exit;
	// }
	// $DB->single("select * from $sms_list where c_id=:phone  ",$codes,$coden,array("phone"=>"$phone"),"key");
	// if($coden==0){
	// 	$result = array("result"=>"22","msg"=>"This is the registered phone number.");
	// 	echo json_encode($result);
	// 	exit;
	// }
	// if(!password_verify($email_code,$emailveri)){
	// 	$result = array("result"=>"0","msg"=>"Please check the email code.");
	// 	echo json_encode($result);
	// 	exit;
	// }

	/*
	$DB->single("select * from $member_table where C_HAND=:phone  ",$codes,$coden,array("phone"=>"$phone"),"key");
	if($coden>0){
		$result = array("result"=>"0","msg"=>"This is the registered phone number.");
		echo json_encode($result);
		exit;
	}

	$DB->single("select * from $member_table where C_EMAIL=:email  ",$codes,$coden,array("email"=>"$email"),"key");
	if($coden>0){
		$result = array("result"=>"22","msg"=>"This is the registered email.");
		echo json_encode($result);
		exit;
	}
	*/

	$DB->single("select * from $member_table where C_ID=:id  ",$custs,$custn,array("id"=>$c_id),"key");



	$C_NAL=0;

	$DB->single("select * from $member_table where C_ID=:id  ",$custs,$custn,array("id"=>$c_id),"key");

	$DB->single("select * from $board_type where C_ID=:h_id", $hs, $hn,array("h_id"=>$h_username),"key");

	$idx = $hs['idx'];

	// $DB->single("select * from $board_type where idx=:idx", $hs1, $hn1,array("idx"=>$idx),"key");

	// if($hn==0){
	// 	$result = array("result"=>"0","msg"=>"Sponsor is wrong");
	// 	echo json_encode($result);
	// 	exit;
	// }

	// if($hn1<2){
	// 	$C_NAL = $hn1+1;
	// 	$C_H_ID = $h_username;
	// }else{
	// 	$result = array("result"=>"0","msg"=>"deId is wrong");
	// 	echo json_encode($result);
	// 	exit;
	// }

	// if($C_NAL==0){
	// 	$result = array("result"=>"0","msg"=>"Sponsor is wrong");
	// 	echo json_encode($result);
	// 	exit;
	// }


	// $DB->single("select * from $board_type where c_code=:code", $hs1, $hn1,array("code"=>$C_H_CODE),"key");

	// if($hn==0){
	// 	$result = array("result"=>"0","msg"=>"Sponsor is wrong");
	// 	echo json_encode($result);
	// 	exit;
	// }




		//include "low_jik.php";






		$DB->single("select * from $member_table where C_ID=:id  ",$codes,$coden,array("id"=>$c_c_id),"key");
		$c_c_code = $codes["C_CODE"];

		$DB->single("select * from $member_table where C_C_CODE=:c_c_code  ",$codes,$coden2,array("c_c_code"=>$c_c_code),"key");
		$C_NAL = $coden2+1;


	if ($deId != $store_key)
	{
		$result = array("result"=>"0","msg"=>"deId is wrong");
		echo json_encode($result);
		exit;
	}
	// else if ($certify1 != $certify2)
	// {
	// 	$result = array("result"=>"0","msg"=>"certification number is wrong");
	// 	echo json_encode($result);
	// 	exit;
	// }
	// else if ($coden == 0)
	// {

	// 	$result = array("result"=>"0","msg"=>"Please check your referral");
	// 	echo json_encode($result);
	// 	exit;
	// }
	else
	{
		if ($custn == 0)
		{

			// $C_H_CODE="";
			// $C_H_ID="";
			// $C_NAL=0;
			$DB->single("select * from $member_table order by C_CODE desc limit 0,1  ",$cnts,$cntn);
			$code 			= $cnts['C_CODE'] +1;


			$DB->insert("C_CODE=:code,C_DATE=:date,C_NAME =:name,C_HAND=:phone,C_ID=:id,C_EMAIL=:email,C_PASS=:pass,C_FIN_PASS=:fin,
			c_country_num	=:country_num,C_C_CODE	=:C_C_CODE,C_C_ID =:c_c_id,C_NAL=:C_NAL,C_JISA=:jisa,C_ZIP =:C_ZIP,C_ADDR=:C_ADDR,C_ADDR2=:C_ADDR2",
			array("code"=>$code,"date"=>date("Y-m-d"),"name"=>$n_name,"phone"=>$phone,"id"=>$c_id,"email"=>$email,"pass"=>$passwd,"fin"=>$f_pass,"country_num"=>$country_num,"jisa"=>$jisa,"C_C_CODE"=>$c_c_code,"c_c_id"=>$c_c_id,"C_NAL"=>$C_NAL,"C_ZIP"=>$C_ZIP,"C_ADDR"=>$C_ADDR,"C_ADDR2"=>$C_ADDR2),"key",$member_table);

			// $DB->insert("C_CODE=:code,C_DATE=:date,C_NAME =:name,C_HAND=:phone,C_ID=:id,C_EMAIL=:email,C_PASS=:pass,
			// c_country_num	=:country_num",
			// array("code"=>$code,"date"=>date("Y-m-d"),"name"=>$n_name,"phone"=>$phone,"id"=>$c_id,"email"=>$email,"pass"=>$passwd,"country_num"=>$country_num,),"key",$member_table);


			// $DB->single("select * from $board_type where c_id=:id", $hs, $hn, array("id" => $h_username), "key");

			// $board_up_idx = $hs['idx'];
			// $c_h_code = $hs['c_code'];

			// $code = $code;
			// $c_id = $c_id;
			// $btype = 0;
			// $DB->single("select * from $board_type where idx=:board_up_idx ", $nals, $naln,array("board_up_idx"=>$board_up_idx),"key");

			// $nal = $nals['c_nal'] +1;
			// if ($low_rec_check == "y"){

			// 	$DB->update("c_nal=:nal  where idx=:board_up_idx",array("nal"=>$nal,"board_up_idx"=>$board_up_idx),"key",$board_type);
			// }
			// else
			// {

			// 	$DB->update("c_nal=:nal  where idx=:board_up_idx",array("nal"=>$nal,"board_up_idx"=>$board_up_idx),"key",$board_type);
			// }


			// $date = date("Y-m-d H:i:s");
			// $cust_add1 = "c_code=:code,c_id=:id, c_date=:date, c_up_code=:board_up_idx, c_gu=:gu,c_nal='0',c_level=:btype";
			// $DB->insert($cust_add1,array("code"=>$code,"id"=>$c_id,"date"=>$date,"board_up_idx"=>$board_up_idx,"gu"=>$nal,"btype"=>$btype),"key",$board_type);


			$result = array("result"=>"1","msg"=>"Complete");
			echo json_encode($result);
		}
		else
		{
			$result = array("result"=>"0","msg"=>"User id is exist");
			echo json_encode($result);
		}

	}
?>