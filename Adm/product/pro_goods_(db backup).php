<?
include "../common/dbconn.php";
include "../common/user_function.php";

$DBurl="localhost";
$dbname="codckey";     
$DBid="codckey"; 
$DBpass="dckey1129"; 
$DBconn =mysql_connect($DBurl, $DBid, $DBpass);
$status = mysql_select_db($dbname);

$shop_img="../../shop_img/";

	$query="select code1,code2,code3,title,info,theme,pricec,prices";
	$query=$query.",priced,point,color,size,currnum";
	$query=$query.",warnnum,company,detail,feature,soldout,new,relation,best,cut,recommend,price_dis,code,signdate,rank";
	$query=$query." FROM ";
	$query=$query." shop_goods order by signdate desc";
	
		
	$DB->get($query,$rs,$rn);
	

$DB->get($query,$rs,$rn);
while($row=mysql_fetch_row($result)){
	$code1 = $rs[0][0];										$code2 = $row[1];
	$code3 = $row[2];										$title = $row[3];
	$info = $row[4];											$theme = $row[5];
	$pricec = $row[6];										$prices = $row[7];
	$priced = $row[8];										$point = $row[9];
	$color = $row[10];										$size = $row[11];
	$currnum = $row[12];									$warnnum = $row[13];
	$company = $row[14];									$detail = $row[15];
	$feature = $row[16];									$soldout = $row[17];
	$new = $row[18];										$relation = $row[19];
	$best = $row[20];										$cut = $row[21];
	$recommend = $row[22];								$price_dis = $row[23];
	$code = $row[24];										$signdate = $row[25];
	$rank = $row[26];

	$code4 = '00';
	$code_kk = substr($code,0,6);
	$code_kk1 = substr($code,6,3);
	$code = $code_kk.$code4.$code_kk1;

$theme_g = "";
$theme_n = "";
$theme_r = "";
$theme_f = "";
$theme_x = "";
$theme_y = "";
$theme_z = "";
$theme_s = "";

if($theme == "g")  $theme_g = $theme;
if($theme == "n")  $theme_n = $theme;
if($theme == "r")  $theme_r = $theme;
if($theme == "f")  $theme_f = $theme;
if($theme == "x")  $theme_x = $theme;
if($theme == "y")  $theme_y = $theme;
if($theme == "z")  $theme_z = $theme;
if($theme == "s")  $theme_s = $theme;

$point_dis = "pe";

$xxx_lg = $shop_img . $code.'_l.gif';
$xxx_mg = $shop_img . $code.'_m.gif';
$xxx_b1g = $shop_img . $code.'_b1.gif';
$xxx_b2g = $shop_img . $code.'_b2.gif';
$xxx_b3g = $shop_img . $code.'_b3.gif';
$xxx_b4g = $shop_img . $code.'_b4.gif';
$xxx_b5g = $shop_img . $code.'_b5.gif';
if (file_exists($xxx_lg)) $imgl = $code.'_l.gif';
if (file_exists($xxx_mg)) $imgm = $code.'_m.gif';
if (file_exists($xxx_b1g)) $imgb1 = $code.'_b1.gif';
if (file_exists($xxx_b2g)) $imgb2 = $code.'_b2.gif';
if (file_exists($xxx_b3g)) $imgb3 = $code.'_b3.gif';
if (file_exists($xxx_b4g)) $imgb4 = $code.'_b4.gif';
if (file_exists($xxx_b5g)) $imgb5 = $code.'_b5.gif';


$xxx_lj = $shop_img . $code.'_l.jpg';
$xxx_mj = $shop_img . $code.'_m.jpg';
$xxx_b1j = $shop_img . $code.'_b1.jpg';
$xxx_b2j = $shop_img . $code.'_b2.jpg';
$xxx_b3j = $shop_img . $code.'_b3.jpg';
$xxx_b4j = $shop_img . $code.'_b4.jpg';
$xxx_b5j = $shop_img . $code.'_b5.jpg';
if (file_exists($xxx_lj)) $imgl = $code.'_l.jpg';
if (file_exists($xxx_mj)) $imgm = $code.'_m.jpg';
if (file_exists($xxx_b1j)) $imgb1 = $code.'_b1.jpg';
if (file_exists($xxx_b2j)) $imgb2 = $code.'_b2.jpg';
if (file_exists($xxx_b3j)) $imgb3 = $code.'_b3.jpg';
if (file_exists($xxx_b4j)) $imgb4 = $code.'_b4.jpg';
if (file_exists($xxx_b5j)) $imgb5 = $code.'_b5.jpg';

/* 전체 백업용 쿼리
$query_w="insert into 2013_shop_goods( 
				code1,
				code2,
				code3,
				code,
				title,
				info,
				company,
				color,
				size,
				home,
				shelf,
				theme,
				event,
				event_str,
				new,
				pricec,
				prices,
				priced,
				point,
				point_dis,
				currnum,
				warnnum,
				imgl,
				imgm,
				imgb1,
				imgb2,
				imgb3,
				imgb4,
				imgb5,
				detail,
				feature,
				signdate,
				soldout,
				rank,
				option_t1,option_n1,option_p1,option_k1,
				option_t2,option_n2,option_p2,option_k2,
				option_t3,option_n3,option_p3,option_k3,
				option_t4,option_n4,option_p4,option_k4,
				option_t5,option_n5,option_p5,option_k5,
				order1,
				order2,
				order3,
				color_opt,
				size_opt,
				add_opt1,
				add_opt2,
				add_opt3,
				add_opt4,
				add_opt5,
				relation,
				price_dis,
				best,
				cut,
				recommend,
				theme_g,theme_n,theme_r,theme_f,theme_x,theme_y,theme_z,
				rank_g,rank_n,rank_r,rank_f,rank_x,rank_y,rank_z,
				opt_num,
				opt_num_str,
				theme_s,
				rank_s) 
				values
				(
				'$code1',
				'$code2',
				'$code3',
				'$code',
				'$title',
				'$info',
				'$company',
				'$color',
				'$size',
				'$home',
				'$shelf',
				'$theme',
				'$event',
				'$event_str',
				'$new',
				'$pricec',
				'$prices',
				'$priced',
				'$point',
				'$point_dis',
				'$currnum',
				'$warnnum',
				'$imgl',
				'$imgm',
				'$imgb1',
				'$imgb2',
				'$imgb3',
				'$imgb4',
				'$imgb5',
				'$detail',
				'$feature',
				'$signdate',
				'$soldout',
				'$rank',
				'$option_t1','$option_n1','$option_p1','$option_k1',
				'$option_t2','$option_n2','$option_p2','$option_k2',
				'$option_t3','$option_n3','$option_p3','$option_k3',
				'$option_t4','$option_n4','$option_p4','$option_k4',
				'$option_t5','$option_n5','$option_p5','$option_k5',
				'$order1',
				'$order2',
				'$order3',
				'$color_opt',
				'$size_opt',
				'$add_opt1',
				'$add_opt2',
				'$add_opt3',
				'$add_opt4',
				'$add_opt5',
				'$relation',
				'$price_dis',
				'$best',
				'$cut',
				'$recommend',
				'$theme_g','$theme_n','$theme_r','$theme_f','$theme_x','$theme_y','$theme_z',
				'$rank_g','$rank_n','$rank_r','$rank_f','$rank_x','$rank_y','$rank_z',
				'$opt_num',
				'$opt_num_str',
				'$theme_s',
				'$rank_s'
				)";
*/

//이미지 제외  백업용 쿼리
$query_w="insert into 2013_shop_goods( 
				code1,
				code2,
				code3,
				code,
				title,
				info,
				company,
				color,
				size,
				home,
				shelf,
				theme,
				event,
				event_str,
				new,
				pricec,
				prices,
				priced,
				point,
				point_dis,
				currnum,
				warnnum,

				detail,
				feature,
				signdate,
				soldout,
				rank,
				option_t1,option_n1,option_p1,option_k1,
				option_t2,option_n2,option_p2,option_k2,
				option_t3,option_n3,option_p3,option_k3,
				option_t4,option_n4,option_p4,option_k4,
				option_t5,option_n5,option_p5,option_k5,
				order1,
				order2,
				order3,
				color_opt,
				size_opt,
				add_opt1,
				add_opt2,
				add_opt3,
				add_opt4,
				add_opt5,
				relation,
				price_dis,
				best,
				cut,
				recommend,
				theme_g,theme_n,theme_r,theme_f,theme_x,theme_y,theme_z,
				rank_g,rank_n,rank_r,rank_f,rank_x,rank_y,rank_z,
				opt_num,
				opt_num_str,
				theme_s,
				rank_s) 
				values
				(
				'$code1',
				'$code2',
				'$code3',
				'$code',
				'$title',
				'$info',
				'$company',
				'$color',
				'$size',
				'$home',
				'$shelf',
				'$theme',
				'$event',
				'$event_str',
				'$new',
				'$pricec',
				'$prices',
				'$priced',
				'$point',
				'$point_dis',
				'$currnum',
				'$warnnum',

				'$detail',
				'$feature',
				'$signdate',
				'$soldout',
				'$rank',
				'$option_t1','$option_n1','$option_p1','$option_k1',
				'$option_t2','$option_n2','$option_p2','$option_k2',
				'$option_t3','$option_n3','$option_p3','$option_k3',
				'$option_t4','$option_n4','$option_p4','$option_k4',
				'$option_t5','$option_n5','$option_p5','$option_k5',
				'$order1',
				'$order2',
				'$order3',
				'$color_opt',
				'$size_opt',
				'$add_opt1',
				'$add_opt2',
				'$add_opt3',
				'$add_opt4',
				'$add_opt5',
				'$relation',
				'$price_dis',
				'$best',
				'$cut',
				'$recommend',
				'$theme_g','$theme_n','$theme_r','$theme_f','$theme_x','$theme_y','$theme_z',
				'$rank_g','$rank_n','$rank_r','$rank_f','$rank_x','$rank_y','$rank_z',
				'$opt_num',
				'$opt_num_str',
				'$theme_s',
				'$rank_s'
				)";

/* 이미지 업데이트용 쿼리
$query_w="update 2013_shop_goods set( 
				imgl='$imgl',
				imgm='$imgm',
				imgb1='$imgb1',
				imgb2='$imgb2',
				imgb3='$imgb3',
				imgb4='$imgb4',
				imgb5='$imgb5',
*/

//echo $query_w;

	$Rs_table= mysql_query($query_w);

	if (!$Rs_table){
		echo "<h1>오류발생".$query_w."</h1>"; 
	}
};
?>
