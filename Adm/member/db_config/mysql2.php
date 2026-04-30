<?
##########커맨드디비쿼리(일반)##############################
function point_db_queiry(){

global $shop_point,$No,$valid_user;

$Point_Result = "select No,Cid,Cont,Point,Wdate,Signdate from $shop_point";
$Point_Result = $Point_Result." order by No desc";
$Point_Rs= mysql_query($Point_Result);
$Point_tn=mysql_num_rows($Point_Rs);
$Point_count = $Point_d[Point_count];
return array ($Point_Rs,$Point_tn);
}
#########################################################

##########커맨드 내용 값###################################
function point_db_value(){

global $point_query ;

	//------------------------------------------
	$No = $point_query[No];			
	$Cid = $point_query[Cid];
	$Cont = $point_query[Cont];		
	$Point = $point_query[Point];
	$Wdate = $point_query[Wdate];
	$Signdate = $point_query[Signdate];
	
	$Point_Y=substr($Wdate,0,4);	
	$Point_M=substr($Wdate,5,2); 	
	$Point_D=substr($Wdate,8,2);
	$Point_Date=$Point_Y."년 ".$Point_M."월 ".$Point_D."일";
	$Point_Date=$Wdate;

	$Point1_Y=substr($Signdate,0,4);	
	$Point2_M=substr($Signdate,5,2); 	
	$Point3_D=substr($Signdate,8,2);
	$Point1_Date=$Point1_Y.":".$Point1_M.":".$Point1_D;
	//------------------------------------------

return array ($No,$Cid,$Cont,$Point,$Point_Date,$Point_Date1);

}
#########################################################
?>