<meta charset="utf-8">
<?
// error_reporting( E_ALL );
// ini_set( "display_errors", 1 );

#####################################################################

include "../common/dbconn.php";
include "../common/user_function.php";
include "../inc/set_com.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>관리자</title>
<link rel="stylesheet" href="../image/style.css" type="text/css">

</head>

<body>
<?
// print_r($_POST);exit;
$chk_num= $_POST["chk_num"];
$select_status = $_POST["select_status"];
for ($i = 0; $i < $chk_num; $i++){
 	$tmpchk = "check" . $i;
	$tmpchk1 = "check1" . $i;
	$tmpchk2 = "check2" . $i;
	$tmpchk3 = "check3" . $i;
	$tmpchk4 = "check4" . $i;
	$tmpchk5 = "check5" . $i;
	$tmpchk6 = "check6" . $i;
 	$sel_check = $_POST[$tmpchk];
	$sel_check1 = $_POST[$tmpchk1];
	$sel_check2 = $_POST[$tmpchk2];
	$sel_check3 = $_POST[$tmpchk3];
	$sel_check4 = $_POST[$tmpchk4];
	$sel_check5 = $_POST[$tmpchk5];
	$sel_check6 = $_POST[$tmpchk6];
	
	// continue;

	if ($sel_check2 != ""){
		
		$ordernum=$sel_check2;
        if ($select_status=="결제완료") {
            $query="select * from $shop_order  WHERE ordernum='$ordernum' ;";
            $DB->get($query, $os, $on);
            $sts = $os[0]["status"];
            if ($sts != "결제완료") {
                $query1 = "SELECT * FROM $shop_sell where  ordernum ='$ordernum' order by idx asc";
            
                $DB->get($query1, $ord2s, $ord2n);
            
                for ($iss=0;$iss<$ord2n;$iss++) {
                    $idx = $ord2s[$iss]["idx"];
            
                    $price = $ord2s[$iss]["money"];
                    $title = $ord2s[$iss]["title"];
                    $c_pv = $ord2s[$iss]["c_pv"];
                    $code = $ord2s[$iss]["code"];
                    $user_id = $ord2s[$iss]["id"];
                    $c_dis = $ord2s[$iss]["c_dis"];
                    $query1 = "SELECT * FROM cust_member where  C_ID ='$user_id'";
                    $DB->get($query1, $ms, $mn);
                    $member_code=$ms[0]["C_CODE"];
                    $count = $ord2s[$iss]["count"];
                    $price=$price*$count;
                    $c_pv=$c_pv*$count;
                    if ($c_dis=="1") {
                        $c_state="resell";
                    } else {
                        $c_state="upgrade";
                    }
            
                    foreach ($amount_array as $key => $value) {
                        if ($price >= $value) {
                            $type=$key;
                        }
                    }
        
                    $date = date("Y-m-d H:i:s");
                    $sql = "c_ordernum = '$ordernum',c_sellnum = '$idx',c_code='$member_code',c_id='$user_id',c_date='$date',c_cash='$price',c_state='$c_state',c_state1='Active',code='$code',title='$title',c_pv='$c_pv',c_type='$type',c_type2='USD'		";
                    // echo $sql;echo "<br>";
                    // continue;
                    $DB->insert($sell_table, $sql);
        
        
                    $DB->get("select sum(c_cash) as total from $sell_table  where c_code = '$member_code' and c_state1='Active' and c_state <> 'resell'", $moneys_all, $moneyn_all);
        
        
                    // echo $moneys_all[0]['total'];
                    // print_r($amount_array);
                    foreach ($amount_array as $key => $value) {
                        if ($moneys_all[0]['total']>=$value) {
                            $type = $key;
                        }
                    }
                
        
                    //직급업데이트
                    $sql = "C_JIK='$type' where C_CODE='$member_code'";
                    $DB->update($member_table, $sql);
        
        
                    $sql = "c_level='$type' where c_code='$member_code'";
                    $DB->update("board1", $sql);
        
                    // echo $sql;
                }
            }
        }
// exit;
$query="";
#####################################################
if($select_status!=''){//전체가 아니면
	
	$query=$query." status='$select_status'  where ordernum='$sel_check2'";
	// echo $query;exit;
	
	$DB->update($shop_order, $query);
	// if(!$result) {
	//    error("QUERY_ERROR");
	//    exit;
	// }
}

#####################################################


#####################################################

#####################################################

#####################################################

	}
}

$encoded_key = urlencode($key);


#####################################################################


$encoded_key = urlencode($key);
echo "
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<meta http-equiv='Refresh' content='0; URL=pro_order.php?page=$page&keyfield=$keyfield&key=$encoded_key&sel_status=$sel_status'>";

#####################################################################
?>