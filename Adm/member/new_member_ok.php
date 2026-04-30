<meta charset="utf-8">
<?
#####################################################################

include "../common/dbconn.php";
include "../common/user_function.php";


$id=$_POST['id'];
$passwd=$_POST['passwd'];
$name=$_POST['name'];
$email=$_POST['email'];
$handphone=$_POST['handphone'];
$shop_key=$_POST['shop_key'];
$signdate = time();


$passwd=trim($passwd);
$name=trim($name);
$email=trim($email);
$handphone=trim($handphone);




if($shop_key=="459sdfwodlfjsx342255" && $id!="" && $passwd!="" && $name!="" && $handphone!=""){

	//데이터베이스에 입력값을 삽입한다
	$query="INSERT INTO $member";
	$query=$query."(";
	$query=$query."id,passwd,name,jumin,solar,sex,job,email";
	$query=$query.",tel,handphone,zip,address,info,signdate,point,dis,dis1,company,recommend,comnum,etc1,etc2";
	$query=$query.")";
	$query=$query."VALUES";
	$query=$query."(";
	$query=$query."'$id','$passwd','$name','$jumin','$solar','$sex','$job','$email','$tel'";
	$query=$query.",'$handphone','$zipcorde','$address','$info','$signdate','$point','$dis','$dis1','$company','$recommend','$comnum','$etc1','$etc2'";
	$query=$query.")";

	$DB->get($query,$rs,$rn);
	if($result) {
	// 리스트 출력화면으로 이동한다
		echo"1";
	} else {
		echo"2";
	}
}else{
	echo"0";
}


?>
