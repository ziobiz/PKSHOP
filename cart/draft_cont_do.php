<? include "../include/get_balance.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?
$d_signdate = date("Y.m.d H:i:s");

if($sian_status=="수정요청"){
?>
	<?
	$detail=$detail."[$d_signdate]";
	$query="update $shop_sell set ";
	$query=$query."detail='$detail'";
	$query=$query.",c_status='수정요청' ";
	$query=$query."WHERE No='$No'";


	$result = mysql_query($query);

	if(!$result) {
	   error("QUERY_ERROR");
	   exit;
	}


	$query="update $shop_order set ";
	$query=$query."status='수정요청' ";
	$query=$query."WHERE ordernum='$ordernum'";

	$result = mysql_query($query);

	if(!$result) {
	   error("QUERY_ERROR");
	   exit;
	}



	$encoded_key = urlencode($key);

	?>
	<script type="text/javascript">
	<!--
		alert("수정요청이 완료되었습니다.");
		location="draft.php?k_name=<?=$k_name?>&k_ordernum1=<?=$k_ordernum1?>&k_ordernum2=<?=$k_ordernum2?>&k_ordernum3=<?=$k_ordernum3?>";
	//-->
	</script>

<?}?>

<?
if($sian_status=="시안확정"){
?>
	<?
	$query_k = "SELECT ordernum,detail,c_status FROM $shop_sell WHERE No='$No'";

	$result_k = mysql_query($query_k,$DBconn);
	if(!$result_k) {
		error("QUERY_ERROR");
		exit;
	}
	$row_k = mysql_fetch_row($result_k);
	$ordernum = $row_k[0];		$detail = $row_k[1];
	$c_status = $row_k[2];


	$detail=$detail."
시안확정 [$d_signdate]";
	$query="update $shop_sell set ";
	$query=$query."detail='$detail'";
	$query=$query.",c_status='시안확정' ";
	$query=$query."WHERE No='$No'";


	$result = mysql_query($query);

	if(!$result) {
	   error("QUERY_ERROR");
	   exit;
	}


	$query="update $shop_order set ";
	$query=$query."status='시안확정' ";
	$query=$query."WHERE ordernum='$ordernum'";

	$result = mysql_query($query);

	if(!$result) {
	   error("QUERY_ERROR");
	   exit;
	}



	$encoded_key = urlencode($key);

	?>
	<script type="text/javascript">
	<!--
		alert("시안을 확정하였습니다.");
		location="draft.php?k_name=<?=$k_name?>&k_ordernum1=<?=$k_ordernum1?>&k_ordernum2=<?=$k_ordernum2?>&k_ordernum3=<?=$k_ordernum3?>";
	//-->
	</script>

<?}?>