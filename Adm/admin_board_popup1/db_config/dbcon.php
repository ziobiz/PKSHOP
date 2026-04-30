<?
$DBurl="localhost";
$dbname="ngtmall";     
$DBid="ngtmall"; 
$DBpass="ngtmall.net";  
$DBtable="admin_board_popup1";     
$DBtable2="admin_board_popup1_Cm"; 


$pagesize=20;   
$chapsize=10;
$top_size=3;//리스트에 공지글 몇개 출력 할지 정해야지요!
$epass="paxm@";




$DB=mysql_connect("localhost", $DBid, $DBpass);
mysql_select_db($dbname);  


######################게시판 테이블 생성#########################

$tts = mysql_list_tables ($dbname); 
for($k=0; $k< mysql_num_rows ($tts); $k++ ) 
       if ($DBtable== mysql_tablename ($tts, $k)) $find="ok" ; 
if ($find!="ok")  { 
      
$nnn=1;
for($nnn=1;$nnn<=2;$nnn++) {
		
		
		if($nnn==1)	{
				$Result="create table $DBtable";
				$Result=$Result."(";
				$Result=$Result."No int not null primary key auto_increment"; //넘버값
				$Result=$Result.",Sub_No int"; // 카타고리
				$Result=$Result.",Name char(20) not null"; //작성자
				$Result=$Result.",P_Up int"; //팝업사용여부
				$Result=$Result.",P_Name char(20) not null"; // 팝업명
				$Result=$Result.",P_Location char(50)"; //팝업위치
				$Result=$Result.",P_Size char(50)"; //팝업크기
				$Result=$Result.",P_Link char(250)"; //링크
				$Result=$Result.",P_Target char(20)"; //타겟
				$Result=$Result.",Cont text"; // 팝업내용
				$Result=$Result.",P_Fname  varchar(30)"; //내용(이미지)
				$Result=$Result.",P_Fsize  int";//파일사이즈1
				$Result=$Result.",Cnt mediumint unsigned not null"; // 조회수
				$Result=$Result.",Ip char(30) not null"; //아이피
				$Result=$Result.",Wdate  datetime not null"; //등록일
				$Result=$Result.",Pass char(20) not null"; //패스워드
				$Result=$Result.",Cont_type char(6) not null"; //상태

				$Result=$Result.")";
				$Rs_table= mysql_query($Result);
				
				if(!$Rs_table){echo "$Result <br>";  exit();} 
			}
			
			if($nnn==2){
				$Result="create table $DBtable2";
				$Result=$Result."(";
				$Result=$Result."Comm_No int not null primary key auto_increment";
				$Result=$Result.",Board_No int";		
				$Result=$Result.",Comm_Writer char(20)";
				$Result=$Result.",Comm_Pass char(10)";
				$Result=$Result.",Comm_Cont text";
				$Result=$Result.",Comm_Wdate  datetime";
				$Result=$Result.")";
				$Rs_table2= mysql_query($Result);
				
				if(!$Rs_table2){echo "$Result <br>";  exit();} 
		
			}
	}#for 문 종료

	mysql_close($DB);



	 
		echo "<meta http-equiv='refresh' content='0;url=./list.php'>"; 
	    exit; 
  } 

#############################################################


?>
































