<?php

class Database {
	private $host = DB_HOST;
	private $user = DB_USER;
	private $pass = DB_PASS;
	private $dbname = DB_NAME;
	
	private $DBh;
	private $error;
	private $stmt;
	
	public function __construct() {
		// Set DSN
		$dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
		$options = array (
			PDO::ATTR_PERSISTENT => true,
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8"
		);

		// Create a new PDO instanace
		try {
			$this->dbh = new PDO ($dsn, $this->user, $this->pass, $options);
		}		// Catch any errors
		catch ( PDOException $e ) {
			$this->error = $e->getMessage();
		}
	}
	
	// Prepare statement with query
	public function query($query) {
		$this->stmt = $this->dbh->prepare($query);
	}
	public function insert($table,$query,$array=array(),$type="key"){
		
		$query = "insert into $table set $query";
		
		$this->stmt = $this->dbh->prepare($query);				
		if(count($array)>0){
			if($type=="key"){
				foreach($array as $key => $value){ 
					$this->bind($key,addslashes(htmlspecialchars($value)));
				}
			}else{
				$i=1;
				foreach($array as $key => $value){
					$this->bind($i,addslashes(htmlspecialchars($value)));
					$i++;
				}
			}
		}
		$this->execute();
	}
	public function delete($table,$query,$array=array(),$type="key"){
		
		$query = "delete from $table where $query";
		
		$this->stmt = $this->dbh->prepare($query);				
		if(count($array)>0){
			if($type=="key"){
				foreach($array as $key => $value){ 
					$this->bind($key,addslashes(htmlspecialchars($value)));
				}
			}else{
				$i=1;
				foreach($array as $key => $value){
					$this->bind($i,addslashes(htmlspecialchars($value)));
					$i++;
				}
			}
		}
		$this->execute();
	}
	public function update($table,$query,$array=array(),$type="key"){
		
		$query = "update  $table set $query";
		
		$this->stmt = $this->dbh->prepare($query);	
		
		if(count($array)>0){
			if($type=="key"){
				foreach($array as $key => $value){ 
					$this->bind($key,addslashes(htmlspecialchars($value)));
				}
			}else{
				$i=1;
				foreach($array as $key => $value){
					$this->bind($i,addslashes(htmlspecialchars($value)));
					$i++;
				}
			}
		}
		$this->execute();
	}
	public function get($query,&$rs,&$rn,$array=array(),$type="key"){
        // echo $query;
        $rs=NULL;
		$rn=0;
		$this->stmt = $this->dbh->prepare($query);
        
        // echo "asd";exit;
        // $this->bind("1","asd");
		// echo count($array);
		// exit;
		if(count($array)>0){
			if($type=="key"){
				foreach($array as $key => $value){
					$this->bind($key,$value);
				}
			}else{
				$i=1;
				foreach($array as $key => $value){
					$this->bind($i,$value);
					$i++;
				}
			}
		}
        
        // print_r($this);
        
		
			$this->execute();
			$rs = $this->stmt->fetchAll();
            $rn = $this->stmt->rowCount();
            
		
	}
	public function single($query,&$rs,&$rn,$array=array(),$type="key"){
        // echo $query;
        $rs=NULL;
		$rn=0;
		$this->stmt = $this->dbh->prepare($query);
		
        // echo "asd";exit;
        // $this->bind("1","asd");
		if(count($array)>0){
			if($type=="key"){
				foreach($array as $key => $value){
					$this->bind($key,$value);
				}
			}else{
				$i=1;
				foreach($array as $key => $value){
					$this->bind($i,$value);
					$i++;
				}
			}
		}
        
        // print_r($this);
        
		
			$this->execute();
			$rs = $this->stmt->fetch();
            $rn = $this->stmt->rowCount();
            
		
	}
	
	// Bind values
	public function bind($param, $value, $type = null) {
		if (is_null ($type)) {
			switch (true) {
				case is_int ($value) :
					$type = PDO::PARAM_INT;
					break;
				case is_bool ($value) :
					$type = PDO::PARAM_BOOL;
					break;
				case is_null ($value) :
					$type = PDO::PARAM_NULL;
					break;
				default :
					$type = PDO::PARAM_STR;
			}
		}
		$this->stmt->bindValue($param, htmlspecialchars($value), $type);
	}
	
	// Execute the prepared statement
	public function execute(){
		return $this->stmt->execute();
	}
	
	// ROW전체
	public function resultset(){
		$this->execute();
		return $this->stmt->fetchAll();
	}
	
	// 하나가져올때
	// public function single(){
	// 	$this->execute();
	// 	return $this->stmt->fetch();
	// }
	
	// Get record row count
	public function rowCount(){
		return $this->stmt->rowCount();
	}
	
	// Returns the last inserted ID
	public function lastInsertId(){
		return $this->dbh->lastInsertId();
	}
}



// class dbConnect {
// 	var $DB_host, $DB_name, $DB_user, $DB_pwd, $DB_conn;

// 	function dbConnect ( $DB_host, $DB_name, $DB_user, $DB_pwd) {
// 		$this->db_host		= $DB_host;
// 		$this->db_name		= $DB_name;
// 		$this->db_user		= $DB_user;
// 		$this->db_pwd		= $DB_pwd;

// 		$this->db_conn = @mysqli_connect( $this->db_host, $this->db_user, $this->db_pwd) or die("Will not connect to the database.");
// 		mysqli_set_charset($this->db_conn,"utf8");
// 		@mysqli_select_db( $this->db_conn, $this->db_name );
// 	}

	
//   function MakeMemberCode($table){
// 	$sql		= "select * from $table order by C_CODE asc";
// 	$result		= mysqli_result($sql);
// 	$count		= mysqli_num_rows($result);
	
// 	$last_code = mysqli_result($result,$count-1,"C_CODE");
// 	$make_code = $last_code + 1;

// 	return $make_code;
//   }
  

// 	function exist_table($table_name)
// 	{
// 	  $result = mysqli_query("SHOW TABLES LIKE '$table_name'");
// 	  $row = mysqli_fetch_array($result, mysqli_NUM);
// 	  if($row == false)return false;
// 	  return true;
// 	}
  
//   function MakeSellCode(){
// 	$sql		= "select * from money_upgrade order by c_sell_code desc";
// 	$result		= $this->result($sql);
// 	$count		= mysqli_num_rows($result);

	
// 	$make_code = $count + 1;


// 	return $make_code;
//   }
  
  
// function GetTotalCnt($table)
// {
// 	  $sql                = "Select * from $table";
// 	  $result			  =$this->result($sql);
// 	  $count			     = mysqli_num_rows($result);

// 	  return $count; 
// }
  
// 	function get($q, &$rs, &$rn)
// 	{
// 		$rs=NULL;
// 		$rn=0;
// 		mysqli_set_charset($this->db_conn, "utf8");	
// 		$rs1 = mysqli_query($this->db_conn, $q) or die (mysqli_error());
// 		$rn = mysqli_num_rows($rs1);
// 		while ($row=mysqli_fetch_array($rs1)) 
// 			$rs[] = $row;
// 	}
  
//   function GetSerial($table)
//   {
//   	$sql 				= "select * from $table ";
// 	$result			  	= $this->result($sql);
// 	$count			    = mysqli_num_rows($result);
  	
// 	return $count;
//   }
  
//   function getHCode($table, $where)
//   {
//   	$sql 				= "select * from $table $where";
// 	$result			  	= $this->result($sql);
// 	$row			    = @mysqli_fetch_row($result);
	
// 	$cnt = $row[24];
// 	if ($cnt == 1)
// 	{
// 		return $row[12];
// 	}
// 	else 
// 	{
// 		return $rs[0][0];
// 	}  					
//   }
//  function GetData($table, $field, $where){
// 	  $sql                = "Select * from $table $where";
// 	  $result			  =$this->result($sql);
// 	  $row			     = @mysqli_fetch_row($result);
// 	  return $row[$field];
	  
	
// }
	
//   function getCode($table, $where){
// 	  $sql                = "Select * from $table $where";
// 	  $result			  =$this->result($sql);
// 	  $row			     = @mysqli_fetch_row($result);
// 	  return $rs[0][0];
//   }

// 	function result ( $sql ) {
// 		$sql				= trim( $sql );
// 		$result			= @mysqli_query($this->db_conn, $sql) or die($sql);
// 		return $result;
// 	}

// 	function select ( $table, $where, $field = "*" ) {
// 		$sql				= "Select $field from $table $where";
// 		$result			= $this->result( $sql );
// 		return $result;
// 	}

// 	function object ( $table, $where, $field = "*" ) {
// 		$sql				= "Select $field from $table $where";
// 		$result			= $this->result( $sql );
// 		$row			= @mysqli_fetch_object($result);
// 		return $row;
// 	}

// 	function row ( $table, $where, $field = "*" ) {
// 		$sql				= "Select $field from $table $where";
// 		$result			= $this->result( $sql );
// 		$row			= @mysqli_fetch_row($result);
// 		return $row;
// 	}

// 	function sum ( $table, $where, $field = "*" ) {
// 		$sql				= "Select sum($field) from $table $where";
// 		$result			= $this->result( $sql );
// 		$row			=  @mysqli_fetch_row($result);
// 		if( $row[0] ) { return $rs[0][0]; } else { return 0;}
// 	}

// 	function cnt ( $table, $where) {
// 		$sql				= "Select count(C_ID) from $table $where";
// 		$result			= $this->result( $sql );
// 		$row			=  @mysqli_fetch_row($result);
// 		if( $row[0] ) { return $rs[0][0]; } else { return 0;}
// 	}

// 	function insert ( $table, $data ) {
// 		$sql				= "insert into $table set $data";
// 		if($this->result( $sql )) { return true; } else { return false; }
// 	}

// 	function update ( $table, $data ) {
// 		$sql				= "update $table set $data";
// 		if($this->result( $sql )) { return true; } else { return false; }
// 	}
	
// 	function delete ( $table, $data ) {
// 		$sql				= "delete from $table $data";
// 		if($this->result( $sql )) { return true; } else { return false; }
// 	}
	
// 	function dropTable ( $data ) {
// 		$sql				= "drop table $data";
// 		if($this->result( $sql )) { return true; } else { return false; }
// 	}

// 	function createTable ( $data ) {
// 		$sql				= "create table $data";
// 		if($this->result( $sql )) { return true; } else { return false; }
// 	}

// 	function stripSlash ( $str ) {
// 		$str				= trim( $str );
// 		$str				= stripslashes( $str );
// 		return $str;
// 	}

// 	function addSlash ( $str ) {
// 		$str				= trim( $str );
// 		$str				= addslashes( $str );
// 		if(empty( $str )) {
// 			$str			= "NULL";
// 		}
// 		return $str;
// 	}
		
		
		
// }

class tools {

	// 엔코드
	function encode($data) {
		return base64_encode($data)."||";
	}
		
	// 디코드
	function decode($data){
		$vars=explode("&",base64_decode(str_replace("||","",$data)));
		$vars_num=count($vars);
		for($i=0;$i<$vars_num;$i++) {
			$elements=explode("=",$vars[$i]);
			$var[$elements[0]]=$elements[1];
		}
		return $var;
	}

	// 엔코드(URL)
	function url_encode($data) {
		return urlencode($data)."||";
	}

	// 디코드(URL)
	function url_decode($data){
		$vars=explode("&",urldecode(str_replace("||","",$data)));
		$vars_num=count($vars);
		for($i=0;$i<$vars_num;$i++) {
			$elements=explode("=",$vars[$i]);
			$var[$elements[0]]=$elements[1];
		}
		return $var;
	}
	
	// 문자열 자르는 부분
	function strCut($str, $len) {
		if ($len >= strlen($str)) return $str;
		$klen = $len - 1;
		while(ord($str[$klen]) & 0x80) $klen--;
		return substr($str, 0, $len - (($len + $klen + 1) % 2)) ."..";
	}
	
	// HTML 출력
	function strHtml($str) {
		$str = trim($str);
		$str = stripslashes($str);
		return $str;
	}

	// 문자열 HTML BR 형태 출력
	function strHtmlBr($str) {
		$str = trim($str);
		$str = stripslashes($str);
		$str = str_replace("\n","<br>", $str);
		return $str;
	}

	// 문자열 TEXT 형태 출력
	function strHtmlNo($str) {
		$str = trim($str);
		$str = htmlspecialchars($str);
		$str = stripslashes($str);
		$str = str_replace("\n","<br>", $str);
		return $str;
	}
	
	// 문자열 TEXT 형태 출력
	function strHtmlNoBr($str) {
		$str = trim($str);
		$str = htmlspecialchars($str);
		$str = stripslashes($str);
		return $str;
	}

	// 날자출력 형태 
	function strDateCut($str, $chk = 1) {
		if( $chk==1 ) {
			$year	=	substr($str,0,4);
			$mon	=	substr($str,5,2);
			$day	=	substr($str,8,2);
			$str	=	$year."/".$mon."/".$day;
		} else if( $chk==2 ) {
			$year	=	substr($str,0,4);
			$mon	=	substr($str,5,2);
			$day	=	substr($str,8,2);
			$time	=	substr($str,11,2);
			$minu	=	substr($str,14,2);
			$str	=	$year."/".$mon."/".$day." ".$time.":".$minu;
		} else if( $chk==3 ) {
			$year	=	substr($str,0,4);
			$mon	=	substr($str,5,2);
			$day	=	substr($str,8,2);
			$str	=	$year."-".$mon."-".$day;
		} else if( $chk==4 ) {
			$year	=	substr($str,0,4);
			$mon	=	substr($str,5,2);
			$day	=	substr($str,8,2);
			$time	=	substr($str,11,2);
			$minu	=	substr($str,14,2);
			$str	=	$year."-".$mon."-".$day." ".$time.":".$minu;
		} else if( $chk==5 ) {
			$year	=	substr($str,0,4);
			$mon	=	substr($str,5,2);
			$day	=	substr($str,8,2);
			$str	=	$year."년 ".$mon."월 ".$day."일";
		} else if( $chk==6) {
			$year	=	substr($str,0,4);
			$mon	=	substr($str,5,2);
			$day	=	substr($str,8,2);
			$time	=	substr($str,11,2);
			$minu	=	substr($str,14,2);
			$str	=	$year."년 ".$mon."월 ".$day."일 ".$time."시 ".$minu."분";
		}
		return $str;
	}
	
	// 숫자로 된 값을 요일로 변환한다. (0:월요일, 1:화요일, 6:일요일)
	function strDateWeek($chk) {
		if( $chk==0 ) {
			$str="월요일";
		} else if( $chk==1 ) {
			$str="화요일";
		} else if( $chk==2 ) {
			$str="수요일";
		} else if( $chk==3 ) {
			$str="목요일";
		} else if( $chk==4 ) {
			$str="금요일";
		} else if( $chk==5 ) {
			$str="토요일";
		} else if( $chk==6) {
			$str="일요일";
		}
		return $str;
	}
	
	# E-MAIL 주소가 정확한 것인지 검사하는 함수
	#
	# preg_match - 정규 표현식을 이용한 검사 (대소문자 무시)
	#         http://www.php.net/manual/function.preg_match.php
	# gethostbynamel - 호스트 이름으로 ip 를 얻어옴
	#          http://www.php.net/manual/function.gethostbynamel.php
	# checkdnsrr - 인터넷 호스트 네임이나 IP 어드레스에 대응되는 DNS 레코드를 체크함
	#          http://www.php.net/manual/function.checkdnsrr.php
	function chkMail($email,$hchk=0) {
		$url = trim($email);
		if($hchk) {
			$host = explode("@",$url);
			if(preg_match("^[\xA1-\xFEa-z0-9_-]+@[\xA1-\xFEa-z0-9_-]+\.[a-z0-9._-]+$", $url)) {
				if(checkdnsrr($host[1],"MX") || gethostbynamel($host[1])) return $url;  else return false;
			}
		} else {
			if(preg_match("^[\xA1-\xFEa-z0-9_-]+@[\xA1-\xFEa-z0-9_-]+\.[a-z0-9._-]+$", $url)) return $url;  else return false;
		}
	}
	// 주민등록번호진위여부 확인 함수
	function chkJumin($resno1,$resno2) { 
		$resno = $resno1.$resno2;
		$len = strlen($resno); 
		if ($len <> 13) return false;
		if (!ereg('^[[:digit:]]{6}[1-4][[:digit:]]{6}$', $resno)) return false; 
		$birthYear = ('2' >= $resno[6]) ? '19' : '20'; 
		$birthYear += substr($resno, 0, 2); 
		$birthMonth = substr($resno, 2, 2); 
		$birthDate = substr($resno, 4, 2); 
		if (!checkdate($birthMonth, $birthDate, $birthYear)) return false; 
		for ($i = 0; $i < 13; $i++) $buf[$i] = (int) $resno[$i]; 
		$multipliers = array(2,3,4,5,6,7,8,9,2,3,4,5); 
		for ($i = $sum = 0; $i < 12; $i++) $sum += ($buf[$i] *= $multipliers[$i]); 
		if ((11 - ($sum % 11)) % 10 != $buf[12]) return false; 
		return true; 
	} 

	// 사업자등록번호 체크 함수
	function chkCompany($reginum) { 
		$weight = '137137135';
		$len = strlen($reginum); 
		$sum = 0; 
		if ($len <> 10) return false;
		for ($i = 0; $i < 9; $i++) $sum = $sum + (substr($reginum,$i,1)*substr($weight,$i,1)); 
		$sum = $sum + ((substr($reginum,8,1)*5)/10); 
		$rst = $sum%10; 
		if ($rst == 0) $result = 0;
		else $result = 10 - $rst;
		$saub = substr($reginum,9,1); 
		if ($result <> $saub) return false;
		return true; 
	} 

	# 문자열에 한글이 포함되어 있는지 검사하는 함수
	function chkHan($str) {
		# 특정 문자가 한글의 범위내(0xA1A1 - 0xFEFE)에 있는지 검사
		$strCnt=0;
		while( strlen($str) >= $strCnt) {
			$char = ord($str[$strCnt]);
			if($char >= 0xa1 && $char <= 0xfe) return true;
			$strCnt++;
		}
	}

	// 문자열 체크(숫자)
	function chkDigit($str) {
		if(ereg("^[1-9]+[0-9]*$",$str))  return true;
		else return false;
	}

	// 문자열 체크(알파)
	function chkAlpha($str) {
		if(ereg("^[a-zA-Z]+[a-zA-Z]*$",$str))  return true;
		else return false;
	}

	// 문자열 체크(알파+숫자)		
	function chkAlnum($str) {
		if(ereg("^[1-9a-zA-Z]+[0-9a-zA-Z]*$",$str))  return true;
		else return false;
	}

	// 문자열 체크(알파+숫자+특수문자)		
	function chkAlnumAll($str) {
		if(ereg("^[1-9a-zA-Z_-]+[0-9a-zA-Z_-]*$",$str))  return true;
		else return false;
	}

	// 메세지 출력
	function msg($msg) {
		echo "<script language='javascript'> alert('$msg'); </script>";
	}

	// 메세지 출력후 BACK
	function errMsg($msg) {
		echo "<script language='javascript'> alert('$msg'); history.back(); </script>";
		exit();
	}

	// 메세지 출력후 이동하는 자바스크립트
	function alertJavaGo($msg,$url) {
		echo "<script language='javascript'> alert('$msg'); location.replace('$url'); </script>";
		exit();
	}

	// 메세지 출력후 이동하는 메타테그
	function alertMetaGo($msg,$url) {
		echo "<script language='javascript'> alert('$msg'); </script>"; 
		echo "<meta http-equiv='refresh' content='0;url=$url'>";
		exit();
	}
	
	// 메타태그로 바로 가기
	function metaGo($url) {
		echo "<meta http-equiv='refresh' content='0;url=$url'>";
		exit();
	}

	// 자바스크립트로 바로 가기
	function javaGo($url) {
		echo "<script language='javascript'> location.href='$url'; </script>";
		exit();
	}
	
	// 창을 닫기
	function winClose() { 
		echo "<script language='javascript'> window.close(); </script>";
		exit();
	}

	// 메세지 출력후 창을 닫기
	function msgClose($msg) { 
		echo "<script language='javascript'> alert('$msg'); window.close(); </script>";
		exit();
	}


	// 창을 닫고 가는 함수
	function javaGoClose($url) { 
		echo "<script language='javascript'> opener.location.replace('$url'); self.close(); </script>";
		exit();
	}
	
	// 프레임으로 된 경우 상위 프레임으로 가는 함수
	function javaGoTop($url) { 
		echo "<script language='javascript'> parent.frames.top.location.replace('$url'); </script>";
		exit();
	}
	
}



//  foreach($_POST as $key => $value){
	  
// 	if(preg_match('/[\r\n\s\t\'\;\"\>\<\/,]+/', $value)) {
// 		$result = array("result"=>"0","msg"=>"input is wrong1");
// 		echo json_encode($result);
// 		exit;
// 	}


// 	if(preg_match('/(union|select|from|where|drop|update|substr|user_tables|user_table_columns|information_schema|sysobject|table_schema|declare|admin|administrator|script|function)/i', $value)) {
// 		$result = array("result"=>"0","msg"=>"input is wrong2");
// 		echo json_encode($result);
// 		exit;			
	
// 	}
// }

?>