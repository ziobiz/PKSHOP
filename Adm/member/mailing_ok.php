<meta charset="utf-8">
<?
########################메일 보네기 실행#############################

include "../common/dbconn.php";
include "../common/user_function.php";

if ($htmlyn!="Y") {
	$doc=nl2br($doc);
}	

$from="cho2002m@hanmail.net";

if ($kind!="a") {
	$to = $to_name;	
	$message = "$doc";
	$subject = "$title";
	$mailheader .= "Return-Path: $from\r\n";
	$mailheader .= "From: $from_name <$from>\r\n";

	if(strcmp($userfile,"")) {
		$filename=basename($userfile_name);
		$fp = fopen($userfile,"r");
		$file = fread($fp,$userfile_size);
		fclose($fp);
		if ($userfile_type == "")
		{ 
			$userfile_type = "application/octet-stream";
		}
		$boundary = "--------" . uniqid("part");
		$mailheader .= "MIME-Version: 1.0\r\n";
		$mailheader .= "Content-Type: multipart/mixed; boundary=\"$boundary\"";
		$messages  = "This is a multi-part message in MIME format.\r\n\r\n";
		$messages .= "--$boundary\r\n";
		$messages .= "Content-Type: text/html; charset=euc-kr\r\n";
		$messages .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
		$messages .= stripslashes($message) . "\r\n";
		$messages .= "--$boundary\r\n";
		$messages .= "Content-Type: $userfile_type; name=\"$filename\"\r\n";
		$messages .= "Content-Transfer-Encoding: base64\r\n\r\n";
		$messages .= ereg_replace("(.{80})","\\1\r\n",base64_encode($file));
		$messages .= "\r\n--$boundary" . "\r\n";
	}else {
         $mailheader .= "Content-Type: text/html; charset=euc-kr\r\n";
         $mailheader .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
         $messages = $mail_head."\r\n";
         $messages .= stripslashes($message)."\r\n";
         $messages .= $mail_tail."\r\n";
    }
		
		mail($to,$subject,$messages,$mailheader);
}else {
	$message = "$doc";
	$subject = "$title";
	$mailheader .= "Return-Path: $from\r\n";
	$mailheader .= "From: $from_name <$from>\r\n";
	if(strcmp($userfile,"")) {
		$filename=basename($userfile_name);
		$fp = fopen($userfile,"r");
		$file = fread($fp,$userfile_size);
		fclose($fp);
		if ($userfile_type == "")
		{ 
			$userfile_type = "application/octet-stream";
		}
		$boundary = "--------" . uniqid("part");
		$mailheader .= "MIME-Version: 1.0\r\n";
		$mailheader .= "Content-Type: multipart/mixed; boundary=\"$boundary\"";
		$messages  = "This is a multi-part message in MIME format.\r\n\r\n";
		$messages .= "--$boundary\r\n";
		$messages .= "Content-Type: text/html; charset=euc-kr\r\n";
		$messages .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
		$messages .= stripslashes($message) . "\r\n";
		$messages .= "--$boundary\r\n";
		$messages .= "Content-Type: $userfile_type; name=\"$filename\"\r\n";
		$messages .= "Content-Transfer-Encoding: base64\r\n\r\n";
		$messages .= ereg_replace("(.{80})","\\1\r\n",base64_encode($file));
		$messages .= "\r\n--$boundary" . "\r\n";
	}else {
         $mailheader .= "Content-Type: text/html; charset=euc-kr\r\n";
         $mailheader .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
         $messages = $mail_head."\r\n";
         $messages .= stripslashes($message)."\r\n";
         $messages .= $mail_tail."\r\n";
    }
	
	//등록일 순으로 추가 최대 10000명씩 전송
	//10000명이 넘으면 가입일을 변경하도록 안내문을 표시한다.
	//m_year m_month m_day m_year1 m_month1 m_day1
	//sex
	//job

$wdate = mktime(00,00,00,$m_month,$m_day,$m_year); 
$wdate1 = mktime(23,59,59,$m_month1,$m_day1,$m_year1);

$query = "SELECT email,name from $member_table";

	if($m_year!='0' and $m_month!='0' and $m_day!='0' and $m_year1!='0' and $m_month1!='0' and $m_day1!='0'){
	$query = $query." $wdate<=signdate and $wdate1>=signdate";
	}
	
	if($m_year!='0' and $m_month!='0' and $m_day!='0' and $m_year1!='0' and $m_month1!='0' and $m_day1!='0' and $sex!='0'){
	$query = $query." and";
	}

	if($sex!='0'){
	$query = $query." sex='$sex'";
	}
	
	if($sex!='0' and $job!='0'){
	$query = $query." and";
	}
	if($m_year!='0' and $m_month!='0' and $m_day!='0' and $m_year1!='0' and $m_month1!='0' and $m_day1!='0' and $job!='0'){
	$query = $query." and";
	}

	if($job!='0'){
	$query = $query." job='$job'";
	}

$query = $query." ORDER BY signdate DESC";

	$DB->get($query,$rs,$rn);
	if(!$result) {
  		error("QUERY_ERROR");
   	exit;
	}
	$total_record = $rn;

	if($total_record>10000){
?>
		<SCRIPT LANGUAGE="JavaScript">
		<!--
		alert("한번에 10,000명 이상은 전송하실수 없습니다. /n 조건을 변경하여 주세요.");
		history.back();
		//-->
		</SCRIPT>
<?
	}else{
		for($i=0;$i<$total_record=$rn;$i++) {
			$to =$rs[$i][0];
			$to_name =$rs[$i][1];
			$to = $to_name." <".$to.">";				

			mail($to,$subject,$messages,$mailheader);
		}	
	}
}

echo "<meta http-equiv='Refresh' content='0; URL=./mailing.php'>";  

#####################################################################
?>