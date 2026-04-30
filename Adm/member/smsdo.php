<? 
include "../common/user_function.php";
include "../common/dbconn.php";

	//$guest_no = "";
	//$guest_key = "";
?>

<?
if($stran_phone_kk ==""){//전체

	if($dis_kk==""){
		$dis_kk=3;
	}

	$encoded_key = urlencode($key);
	$query = "SELECT id from $member_table where dis='$dis_kk'";
	$query = $query."ORDER BY signdate DESC";	

	$DB->get($query,$rs,$rn);
	if(!$result) {
	   error("QUERY_ERROR");
	   exit;
	}
	$total_record = $rn;
	$kkk = 200;

	$total_record_kk = ($total_record - ($total_record % $kkk)) / $kkk; 
	$total_record_kkk = $total_record % $kkk;

	for($i = 0; $i < $total_record_kk; $i++) { 
		$i_k = $i*200 + 1;
		$query_kk = "SELECT handphone from $member_table where dis='$dis_kk'";
		$query_kk = $query_kk."ORDER BY signdate DESC limit $i_k,200";	

		$result_kk = mysql_query($query_kk,$DBconn);
		if(!$result_kk) {
		   error("QUERY_ERROR");
		   exit;
		}
		$total_record_mm = mysql_num_rows($result_kk);

		for($j = 0; $j < $total_record_mm; $j++) { 

			$tel_kk = mysql_result($result_kk,$j,0);

			if($stran_phone!=""){
				$stran_phone=$stran_phone."=".$tel_kk;
			}else{
				$stran_phone=$tel_kk;
			}
		}

	}


	//나머지
	$i_k = $total_record_kk*200;

			if($total_record_kkk > 0){
				$query_kkk = "SELECT handphone from $member_table where dis='$dis_kk'";
				$query_kkk = $query_kkk."ORDER BY signdate DESC limit $i_k,$total_record_kkk";

				$result_kkk = mysql_query($query_kkk,$DBconn);
				if(!$result_kkk) {
				   error("QUERY_ERROR");
				   exit;
				}
				$total_record_kkk = mysql_num_rows($result_kkk);

				for($k = 0; $k < $total_record_kkk; $k++) {
					$tel_kkk = mysql_result($result_kkk,$k,0);

					if($stran_phone!=""){
						$stran_phone=$stran_phone."=".$tel_kkk;
					}else{
						$stran_phone=$tel_kkk;
					}
				}
			}

					if(isset($stran_phone) && $stran_phone != "") {

					  $xml_file = "http://sms.direct.co.kr/link/".
								  "send.php?stran_phone=".$stran_phone.
								  "&stran_callback=".$stran_callback.
								  "&stran_date=".urlencode($stran_date).
								  "&stran_msg=".urlencode($stran_msg).
								  "&guest_no=".$guest_no.
								  "&guest_key=".$guest_key;

					  $dom = domxml_open_file($xml_file);
					  $root = $dom->document_element();
					  $nodes = $root->child_nodes();
					  $ret = $nodes[count($nodes)-1]->get_content();
						
					}

}else{//개인

			$stran_phone = $stran_phone_kk;

					if(isset($stran_phone) && $stran_phone != "") {

					  $xml_file = "http://sms.direct.co.kr/link/".
								  "send.php?stran_phone=".$stran_phone.
								  "&stran_callback=".$stran_callback.
								  "&stran_date=".urlencode($stran_date).
								  "&stran_msg=".urlencode($stran_msg).
								  "&guest_no=".$guest_no.
								  "&guest_key=".$guest_key;

					  $dom = domxml_open_file($xml_file);
					  $root = $dom->document_element();
					  $nodes = $root->child_nodes();
					  $ret = $nodes[count($nodes)-1]->get_content();
						
					}

}

echo "<meta http-equiv='refresh' content='1;url=sms.php?dis=$dis'>"; 

?>
