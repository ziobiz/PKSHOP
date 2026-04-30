<?
//   error_reporting( E_ALL );
//   ini_set( "display_errors", 1 );

include "../common/dbconn.php";
include "../common/user_function.php";
if($_REQUEST["sel_code1"] !="" || $_REQUEST["sel_code2"] !="" || $_REQUEST["sel_code3"] !="" || $_REQUEST["sel_code4"] !=""){
$sel_code1 = $_REQUEST["sel_code1"];
$sel_code2 = $_REQUEST["sel_code2"];
$sel_code3 = $_REQUEST["sel_code3"];
$sel_code4 = $_REQUEST["sel_code4"];
}else{
$sel_code1 = $_GET["sel_code1"];
$sel_code2 = $_GET["sel_code2"];
$sel_code3 = $_GET["sel_code3"];
$sel_code4 = $_GET["sel_code4"];
}
if($_REQUEST["keyfield"] !="" || $_REQUEST['key'] !="" || $_REQUEST[page] !=""){
$keyfield = $_REQUEST['keyfield'];
$key = $_REQUEST['key'];
$page =$_REQUEST["page"];
}else{
$keyfield = $_GET['keyfield'];
$key = $_GET['key'];
$page =$_GET["page"];
}
$chk_num= $_POST["chk_num"];
for ($i = 0; $i < $chk_num; $i++){
 		$tmpchk = "check" . $i;
		 
 		$sel_check = $_REQUEST[$tmpchk];
		 if ($sel_check == "") {
			continue;
		 }
		
 		if ($sel_check != "") {
		##########/shop_img/ 폴더 화일 삭제
			$shop_img="../../upload/";
			$savedir = "$shop_img";

			$Result = "select imgl,imgm,imgb1,imgb2,imgb3,imgb4,imgb5 from $shop_goods where No=$sel_check"; 
			$DB->get($Result,$rs,$rn);


			//------------------------------------------------
			$imgl=$rs[0]["imgl"]; 
			$imgm=$rs[0]["imgm"];
			$imgb1=$rs[0]["imgb1"];
			$imgb2=$rs[0]["imgb2"];
			$imgb3=$rs[0]["imgb3"];
			$imgb4=$rs[0]["imgb4"];
			$imgb5=$rs[0]["imgb5"];
			//---------------------------------------------
			$imgb1_name = $_FILES['imgb1']['name'];
			$imgb1_size = $_FILES['imgb1']['size'];
			$imgb2_name1 = $_FILES['imgb2']['name'];
			$imgb2_size1 = $_FILES['imgb2']['size'];
			$imgb1 = $_FILES['imgb1']['tmp_name'];
			$imgb2 = $_FILES['imgb2']['tmp_name'];

			if ($imgl!="") {
				$img_name = $savedir . $imgl;
				$img_name_exist = file_exists("$img_name");
				if($img_name_exist){
					if(!unlink("$img_name")){
						error("UPLOAD_DELETE_FAILURE");
						exit;
					}
				}
			}	

			if ($imgm!="")	{
				$img_name = $savedir . $imgm;
				$img_name_exist = file_exists("$img_name");
				if($img_name_exist){
					if(!unlink("$img_name")){
						error("UPLOAD_DELETE_FAILURE");
						exit;
					}
				}
			}

			if ($imgb1!="")	{
				$img_name = $savedir . $imgb1;
				$img_name_exist = file_exists("$img_name");
				if($img_name_exist){
					if(!unlink("$img_name")){
						error("UPLOAD_DELETE_FAILURE");
						exit;
					}
				}
			}

			if ($imgb2!="")	{
				$img_name = $savedir . $imgb2;
				$img_name_exist = file_exists("$img_name");
				if($img_name_exist){
					if(!unlink("$img_name")){
						error("UPLOAD_DELETE_FAILURE");
						exit;
					}
				}
			}

			if ($imgb3!="")	{
				$img_name = $savedir . $imgb3;
				$img_name_exist = file_exists("$img_name");
				if($img_name_exist){
					if(!unlink("$img_name")){
						error("UPLOAD_DELETE_FAILURE");
						exit;
					}
				}
			}

			if ($imgb4!="")	{
				$img_name = $savedir . $imgb4;
				$img_name_exist = file_exists("$img_name");
				if($img_name_exist){
					if(!unlink("$img_name")){
						error("UPLOAD_DELETE_FAILURE");
						exit;
					}
				}
			}

			if ($imgb5!="")	{
				$img_name = $savedir . $imgb5;
				$img_name_exist = file_exists("$img_name");
				if($img_name_exist){
					if(!unlink("$img_name")){
						error("UPLOAD_DELETE_FAILURE");
						exit;
					}
				}
			}
		}
		#################################

 			
			$DB->delete($shop_goods," No = '$sel_check'");
 			
 		}
	
if ($buy_chk=='Y') {
	$tmp_url = "pro_buy.php?page=$page";
}
else {
	$tmp_url = "products.php?sel_code1=$sel_code1&sel_code2=$sel_code2&sel_code3=$sel_code3&chk_order=Y&sel_cate=$sel_cate";
}
echo "<meta http-equiv='Refresh' content='0; URL=$tmp_url'>";
?>