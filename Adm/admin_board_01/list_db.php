<?
extract($_POST);
extract($_GET);
extract($_SERVER);
extract($_FILES);
extract($_ENV);
extract($_COOKIE);
 if (count($_SESSION)) extract($_SESSION, EXTR_PREFIX_SAME, 'SESSION_'); 
include "../common/user_function.php";

$DBurl="localhost";
$dbname="mcasand";     
$DBid="mcasand"; 
$DBpass="mca1234";

$DBconn =mysql_connect($DBurl, $DBid, $DBpass);
$status = mysql_select_db($dbname);

$Old_Sub = 12;
$Old_table = "admin_board_01";

$New_Sub = 4;
$New_table = "2013_admin_board_01";

$Result_o="select * from admin_board_01 where Sub_No='$Old_Sub' order by No";

$Rs_table_o= mysql_query($Result_o);
while($View_d=mysql_fetch_array($Rs_table_o)){
//==========================================================================//
$No = $View_d[No];								$Sub_No=$View_d[Sub_No];
$Name = $View_d[Name];						$Title=$View_d[Title];							
$Email = $View_d[Email];						$Homepage=$View_d[Homepage];
$Cont=$View_d[Cont];							$Cnt = $View_d[Cnt];
$Ip = $View_d[Ip];									$Wdate=$View_d[Wdate];	
$Pass=$View_d[Pass];							$Fname = $View_d[Fname];	
$Fsize = $View_d[Fsize];						$Fname1 = $View_d[Fname1];	
$Fsize1 = $View_d[Fsize1];					$No1 = $View_d[No1];			
$Cont_type = $View_d[Cont_type];			$B_Title = $View_d[B_Title];	
$P_up = $View_d[P_up];

$Cont = addslashes($Cont);
$Name = addslashes($Name);
$Title = addslashes($Title);
$Email = addslashes($Email);
$Homepage = addslashes($Homepage);
$Wdate = addslashes($Wdate);

$Result="insert into $New_table values";
				$Result=$Result."(";
				$Result=$Result."''"; #no 값이 들어 간다...자동 증가.
				$Result=$Result.",'$New_Sub'";
				$Result=$Result.",'$Name'";
				$Result=$Result.",'$Title'";
				$Result=$Result.",'$Email'";
				$Result=$Result.",'$Homepage'";
				$Result=$Result.",'$Cont'";
				$Result=$Result.",'$Cnt'";
				$Result=$Result.",'$Ip'";
				$Result=$Result.",'$Wdate'";
				$Result=$Result.",'$Pass'";
				$Result=$Result.",'$Fname'";
				$Result=$Result.",'$Fsize'";
				$Result=$Result.",'$Fname1'";
				$Result=$Result.",'$Fsize1'";
				$Result=$Result.",'0'";
				$Result=$Result.",'$Cont_type'";
				$Result=$Result.",'$B_Title'";
				$Result=$Result.",'$P_up'";
				$Result=$Result.")";

				//$Rs_table= mysql_query($Result);

				$Result_n="update 2013_admin_board_01 set No1=No where No1=0";

				//$Rs_table_n= mysql_query($Result_n);

if (!$Rs_table){
		echo "<h1>오류발생".$Result."</h1>"; 
	}else{
		echo "<meta http-equiv='refresh' content='1;url=list.php'>"; 
	}
}

mysql_close($DB);
?>
