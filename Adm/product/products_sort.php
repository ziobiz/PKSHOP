<?include "../common/dbconn.php";?>
<?

// error_reporting( E_ALL );
//   ini_set( "display_errors", 1 );

include "../common/user_function.php";

$chk_order = $_GET["chk_order"];
$init = $_GET["init"];
$sel_cate = $_POST["sel_cate"];
if($_POST["sel_code1"] !="" || $_POST["sel_code2"] !="" || $_POST["sel_code3"] !="" || $_POST["sel_code4"] !=""){
$sel_code1 = $_POST["sel_code1"];
$sel_code2 = $_POST["sel_code2"];
$sel_code3 = $_POST["sel_code3"];
$sel_code4 = $_POST["sel_code4"];
}else{
$sel_code1 = $_GET["sel_code1"];
$sel_code2 = $_GET["sel_code2"];
$sel_code3 = $_GET["sel_code3"];
$sel_code4 = $_GET["sel_code4"];
}
$soldout = $_GET["soldout"];
$mode = $_GET["mode"];
if($_POST["keyfield"] !="" || $_POST['key'] !=""){
$keyfield = $_POST['keyfield'];
$key = $_POST['key'];
}else{
$keyfield = $_GET['keyfield'];
$key = $_GET['key'];
$page_num =$_GET["page"];
}
$sel = $_POST["sel"];
$no = $_POST["no"];
// print_r($_POST);
if($sel_cate==1){
	$order_tmp="order1";
}else if($sel_cate==2){
	$order_tmp="order2";
}else if($sel_cate==3){
	$order_tmp="order3";
}else {
	$order_tmp="order1";
}
//$No를 $sel[] 과 no[]의 공통 키값으로 활용
foreach($sel as $key=>$val){
	$query="";
	// echo $val;
	// echo "asd";
	if($init=='init'){
		$order=$order_tmp."=99999";
	}else{
		$order=$order_tmp."='$sel[$key]'";
	}
	
	$query=$query." $order where No='$no[$key]'";
	// echo $query;
	// exit;
	// echo "<br>";
	$DB->update($shop_goods,$query);

	
}
// exit;

$tmp_url = "products.php?sel_code1=$sel_code1&sel_code2=$sel_code2&sel_code3=$sel_code3&chk_order=Y&sel_cate=$sel_cate";
echo "<meta http-equiv='Refresh' content='0; URL=$tmp_url'>";
?>
