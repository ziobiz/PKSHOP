<?
	include "../lib/basic_class2.php";
	include "../lib/config_read.php";
	include "../lib/common.php";
	include "../lib/php_page.php"; 
	include "../lib/php_function.php"; 


$memberid = $_GET['uid'];

$sortfield = 6;
$old_sortfield= 6;

$vid = $_GET['vid'];
if (!$memberid && $vid== "") 
{
	echo "<script>alert('Try again!'); </script>";

}

function grant($grant){
	switch ($grant){
		case "1":
			$bgcolor="#FFCC00";
			break;
		case "2":
			$bgcolor="#009900";
			break;
		case "3":
			$bgcolor="#0066FF";
			break;
		case "4":
			$bgcolor="#9933CC";
			break;
		case "5":
			$bgcolor="#9933CC";
			break;
		case "6":
			$bgcolor="#FF66CC";
			break;
		case "7":
			$bgcolor="#FF3300";
			break;

			default:
			$bgcolor="#CDE1E2";
			break;

		}
	return $bgcolor;
}



?>
	<style>
	td,b,p,font { margin-top:0; margin-bottom:0; line-height:120%; text-align:center }
	</style>

<script language="javascript">
function backbtn()
{
	history.back(-1);
}
</script>

    <meta charset="UTF-8" />
<table border="0" align="center">
<tr>
<td width="10" bgcolor="#CDE1E2">&nbsp;</td><td>1 Lv</td>
<td width="10" bgcolor="#FFCC00">&nbsp;</td><td>2 Lv</td>
<td width="10" bgcolor="#009900">&nbsp;</td><td>3 Lv</td>
<td width="10" bgcolor="#0066FF">&nbsp;</td><td>4 Lv</td>
<td width="10" bgcolor="#9933CC">&nbsp;</td><td>5 Lv</td>


</tr>
</table>

<br>



<?

$td_width=80;
$tr_height=50;

 $viewLine=3;
 
$cell[0][0]="";  $cell[0][1]=""; $cell[1][0]=""; $cell[1][1]=""; $colcount=2;	$rowcount=2;
$iscodechk="n";
$JIK='';

$sortfield = 6;
$viewLine=3;
//////////////////////////////////////////////////////////////
// 데이터 가져오기
/////////////////////////////////////////////////////////////

	mysqli_query("set names utf8");

	$DB->get("select * from $member_table where C_ID='$memberid'", $custs, $custn);	
if ($vid != "")
{
	$DB->get("select * from $member_table where C_CODE='$vid'", $custs, $custn);
	$memberid =$custs[0]['C_ID'];
}
if($custn > 0)
{
	$pos = 0;
	for ($i=0;$i<$custn;$i++)
	{
			$DB_code 		= $cust[$i]['C_CODE'];
			$DB_name 		=$cust[$i]['C_NAME'];// iconv("UTF-8", "EUC-KR", ) ;
			$DB_id			= $cust[$i]['C_ID'];
			$DB_date		= $cust[$i]['C_DATE'];
				$DB_c_c_code	= $cust[$i]['C_C_CODE'];
				$DB_c_h_code	= $cust[$i]['C_C_CODE'];
			
			$DB_serial		= $cust[$i]['C_SERIAL'];
			$DB_tree_type	= '';
			$DB_jik         = $cust[$i]['C_JIK'];

			
		
			if ($sortfield == "6" || $sortfield == "8")	
			{
				$DB_tree_type	=	substr($DB_tree_type,0,7)."*******";
			}
			else if ($sortfield == "7"  || $sortfield == "9")
			{
				$DB_tree_type	=	'';
			}
			
			if ( strtolower($DB_id) == strtolower($memberid))
			{
				$session_membercode = $DB_code;
				$iscodechk = "y";
				
			}
			
			$cust[$pos]= array($DB_code,$DB_name,$DB_id,$DB_date,$DB_jik ,$DB_pv,$DB_c_c_code,$DB_c_h_code,($DB_tree_type.$DB_serial),$DB_L,$DB_R,$country);
			$pos= $pos +1;
	}


	
if($iscodechk=="n"){echo "<script>alert('do not  history');//history.back();</script>";exit;}
if(!$vid) $vid=$session_membercode;

$viewLine=3;
$sortfield = 6;
			

$ccount= 3;	
$rcount = $pos;
for ($j=0;$j<$rcount ;$j++)	{	 if($cust[$j][0]==$vid){ 
																
									if($cust[$j][1]=="") $del="o"; else $del="x";
									$custcode=$cust[$j][0];
									$custname=$cust[$j][1];
									$custid=$cust[$j][2];
									$custdate=$cust[$j][3];
									$custgrant=$cust[$j][4];
									$custemail=$cust[$j][5];
									$c_l=$cust[$j][10];
									$c_r=$cust[$j][9];
									$country =$cust[$j][11];
									
									
									$cell[0][1]=( $del."|".$custcode."|".$custname."|".$custid."|".$custdate."|".$custgrant."|".$custemail."|".$c_l."|".$c_r."|".$country );
									FindTree( $custcode, 1);
									break; 
									} 
				
					}



	
	$k=0;
	for($j=($rowcount-1) ;$j>=1;$j--)
	{	
		if(!($j%2 == 0))
		{	for($i=$colcount-1;$i>=0;$i--)
			{	if($cell[($j)][$i]=="d") 
					$k=$i; 
				else if($cell[($j)][$i]=="a") 
					{	ExChangeLines($i, ($j)-1, (int) (($k-$i) / 2) );   
					  	$k= 0;
					} 
				else if(($k>0)&&($cell[($j)][$i]=="")) $cell[($j)][$i]="b";
			}
		}
	}

 include "make_t_table.php";

}


function ExChangeLines($col, $row, $incn)
{  	global $cell;
	for($j=$row;$j>=0;$j--)	{	$cell[$j][$col+$incn]=	$cell[$j][$col];
					$cell[$j][$col]="";
				}
	if($cell[$row+1][$col+$incn]=="b") $cell[$row+1][$col+$incn]="c"; else $cell[$row+1][$col+$incn]="f";
}



function FindTree( $code, $step)
{ 	global $cust;
	global $sortfield;
	global $viewLine;
	global $rcount;
	global $cell;
	global $colcount;
	global $rowcount;
	$nal=0;

	for ($j=0;$j<$rcount ;$j++) { 
		if($cust[$j][$sortfield]==$code)
					{				

									$nal=$nal+1;
									if($nal==1) $str="e";
									if($nal>1)	{	$colcount=$colcount+2;
												for($m=0;$m<$rowcount;$m++){       $cell[$m][$colcount-1]="";  $cell[$m][$colcount-2]="";                    }
												



												for($k=$colcount-1;$k>=0;$k--)	{	$str=$cell[(($step*2)-1)][$k];
																		if($str=="e"){ $cell[(($step*2)-1)][$k]="a"; break; }
																		if($str=="d"){ $cell[(($step*2)-1)][$k]="g"; break; }
																	}
												$str="d";
											}
									if($cust[$j][1]=="") $del="o"; else $del="x";  
																		$custcode=$cust[$j][0];
									$custname=$cust[$j][1];
									$custid=$cust[$j][2];
									$custdate=$cust[$j][3];
									$custgrant=$cust[$j][4];
									$custemail=$cust[$j][5];
									$c_l=$cust[$j][10];
									$c_r=$cust[$j][9];
									$country =$cust[$j][11];


									$cell[$step*2][$colcount-1]=( $del."|".$custcode."|".$custname."|".$custid."|".$custdate."|".$custgrant."|".$custemail."|".$c_l."|".$c_r."|".$country);

									$cell[$step*2-1][$colcount-1]=$str;
									if ($step<=$viewLine){
									FindTree( $custcode, $step+1);
									}

								            if($rowcount<(($step*2)+1)) {	$rowcount=(($step*2) + 1);
													for($t=0;$t<$colcount;$t++) $cell[$rowcount][$t]="";
												      }
//									echo $cust[$j+1][$sortfield]."_".$code."<BR>";
									//if($cust[$j+1][$sortfield]!=$code) break;
					}
				}

			
}

?>

<div id="explaintext" style="POSITION: absolute;display:block;width:240;height:50;Z-INDEX:3;filter:alpha(opacity=70);"></div>

<script>
function sub_table()
{
 // self.close();
 document.getElementById("details").style.display="none";	
}

function explain(num1,num2,num3,num4)
{
	x = event.x + 10 + document.body.scrollLeft;
	y  = event.y + 10 + document.body.scrollTop;

	//if (!num1) num1="미입력";
	//if (!num2) num2="미입력";
	//if (!num4) num4="미입력";
	//if (!num3) num3="미등록";

	in_html="<table cellpadding='0' cellspacing='0' BORDER=0 bordercolordark=#FFFFFF bgcolor='#F0F8FF' bordercolor='#3399FF' width='240' style='font-size:12px' id='details'>";
	in_html +="<tr><td width='80' height='30'>회원ID</td><td>"+num1+"</td></tr>";
	in_html +="<tr><td width='80' height='30'>회원가입일</td><td>"+num2+"</td></tr>";
	in_html +="<tr><td width='80' height='30'>직급</td><td>"+num3+"</td></tr>";
	in_html +="<tr><td width='80' height='35'></td><td><input type='button' value='닫기' onclick='sub_table()'></td></tr>";
	in_html +="</table>";
	document.all.explaintext.innerHTML=in_html;
	document.all.explaintext.style.left=x;
	document.all.explaintext.style.top=y;
	document.all.explaintext.style.padding=1;
	document.all.explaintext.style.spacing=2;
	document.all.explaintext.style.background="";
	document.all.explaintext.style.display="block";
}
function code_change(code)
{
location.href="tree_view.php?vid="+code;
}
</script>
