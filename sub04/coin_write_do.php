<? include "../include/get_balance.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html  xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Kona Summit Platform</title>
<meta name="naver-site-verification" content="dd28ee0fe0b0cd04931850f770acd306527b83ae"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="생활용품, 가전, 식품, 스포츠용품, 건강식품, 화장품 도소매 판매사이트">
<meta property="og:type" content="website">
<meta property="og:title" content="(주)코알플러스">
<meta property="og:description" content="생활용품, 가전, 식품, 스포츠용품, 건강식품, 화장품 도소매 판매사이트">
<meta property="og:image" content="http://megabuyer.cafe24.com/images/logo2.png">
<meta property="og:url" content="http://megabuyer.cafe24.com">

<link rel="stylesheet" href="../include/reset.css">
<link rel="stylesheet" type="text/css" href="../include/style.css" media="screen and (min-width:1024px)"/>
<link rel="stylesheet" type="text/css" href="../include/responsive.css" media="screen and (max-width:1023px)"/>

<? include "../include/naver.php"; ?>
<? include "../include/login_check.php"; ?>

</head>

<body>

<?

$Signdate_kk = date("Y-m-d h:i:s",$signdate); 
$Cont = "코인충전";
$query="insert into $shop_point values";
$query=$query."(";
$query=$query."''"; #no 값이 들어 간다...자동 증가.
$query=$query.",'$uid'";
$query=$query.",'$Cont'";
$query=$query.",'$amount'";
$query=$query.",now()";
$query=$query.",'$signdate'";
$query=$query.")";

$result = mysql_query($query);

if (!$result){
	echo "0";
}else{
	echo "1";
}
?>
