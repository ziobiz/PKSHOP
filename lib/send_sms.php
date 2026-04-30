<?php
	    include "class.http.php";
		include "class.EmmaSMS.php";

		 function rand_code($nc) {
			$a='0123456789';
			 $l=strlen($a)-1; $r='';
			 while($nc-->0) $r.=$a{mt_rand(0,$l)};
			 return $r;
		 }	


		$rand = rand_code(6);
        $sms_id = "hanwul1";
        $sms_passwd = "a7608119A@";
        $sms_to = $_GET['sms_to'];
        $sms_from = '010-6273-6654';
		$sms_date =""; 
        $sms_msg = "Verification Code :".$rand;
        $sms_type = "L";    // 설정 하지 않는다면 80byte 넘는 메시지는 쪼개져서 sms로 발송, L 로 설정하면 80byte 넘으면 자동으로 lms 변환

        $sms = new EmmaSMS();
        $sms->login($sms_id, $sms_passwd);
        $ret = $sms->send($sms_to, $sms_from, $sms_msg, $sms_date, $sms_type);

        //$sms_msg = json_decode($ret,true);
		
		echo $rand;
  
?>