<?


$DBurl="localhost";
$dbname="ngtmall";     
$DBid="ngtmall"; 
$DBpass="ngtmall.net";  

$url_check=split('/',$PATH_TRANSLATED );
$DB_names=ucfirst($dbname) ;
$DBtable="admin_board_03";     


$pagesize=10;   
$chapsize=10;
$top_size=3;//리스트에 공지글 몇개 출력 할지 정해야지요!
$epass="2004";

$DB=mysql_connect($DBurl, $DBid, $DBpass);
mysql_select_db($dbname);  


######################게시판 테이블 생성#########################

$tts = mysql_list_tables ($dbname); 
for($k=0; $k< mysql_num_rows ($tts); $k++ ) 
       if ($DBtable== mysql_tablename ($tts, $k)) $find="ok" ; 
if ($find!="ok")  { 
      
				$Result="create table $DBtable";
				$Result=$Result."(";
				$Result=$Result."No int not null primary key auto_increment"; //넘버값
				$Result=$Result.",Sub_No int"; // 카타고리
				$Result=$Result.",Name char(20) not null"; //성명
				$Result=$Result.",Title char(120) not null"; // 타이틀
				$Result=$Result.",Email char(50)"; //이메일
				$Result=$Result.",Homepage char(50)"; //홈페이지
				$Result=$Result.",Cont text not null"; // 내용
				$Result=$Result.",Cnt mediumint unsigned not null"; // 조회수
				$Result=$Result.",Ip char(30) not null"; //아이피
				$Result=$Result.",Wdate  datetime not null"; //등록일
				$Result=$Result.",Pass char(20) not null"; //패스워드
				$Result=$Result.",Fname  varchar(30)"; //파일이름
				$Result=$Result.",Fsize  int";//파일사이즈1
				$Result=$Result.",Fname1  varchar(30)"; //파일이름1
				$Result=$Result.",Fsize1  int";//파일사이즈
				$Result=$Result.",No1 int not null"; //답변글 넘버
				$Result=$Result.",Cont_type char(6) not null"; //상태
				$Result=$Result.",B_Title int"; //공지글
				$Result=$Result.",P_up int"; //팝업글

				$Result=$Result.")";
				$Rs_table= mysql_query($Result);
				
				if(!$Rs_table){echo "$Result <br>";  exit();} 



	mysql_close($DB);



	 
		echo "<meta http-equiv='refresh' content='0;url=./list.php'>"; 
	    exit; 
  } 

#############################################################


?>
































