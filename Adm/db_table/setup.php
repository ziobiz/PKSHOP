<? 
include "../common/dbconn.php";
include_once "../inc/admin_shell_lib.php";
pkshop_admin_auto_shell_begin();
$setup = $_GET[setup];
?>

<table class="pg-table pg-table-form" width="100%" border=0 cellpadding=0 cellspacing=0>
	<tr><td height=30 colspan="2"></td></tr>
	<tr>
		<td width=60 align=center><img src="../image/icon1.gif" width=45 height=35 border=0></td>
		<td class='td14'>&nbsp;<b>데이터베이스 설정</b></td>
	</tr>
	<tr><td height=3 colspan="2"></td></tr>
</table>

<?
### 테이블 삭제 ####################################################
if($delete=="drop"){
	$sql="drop table $drop_table";
	$r = mysql_query("$sql");
		if(!$r) {
			echo "<center><br><br><H1>테이블 삭제 오류</H1><br>
			<table width='600' cellpadding='5'><tr><td>$sql</td></tr></table>
			<br><BR><a href='index.php'>리스트로 이동</a>";
		} else {
			echo "<center><br><br><H1>테이블 삭제 완료</H1><br>
			<table width='600' cellpadding='5'><tr><td>$sql</td></tr></table>
			<br><BR><a href='index.php'>리스트로 이동</a>";
		}
exit;
}

### 테이블 만들기 ####################################################
switch ($setup) {

	// 상품분류 테이블 만들기 
	case ("$shop_cate"):
		$sql="create table $shop_cate (uid mediumint(9) not null primary key, code1 char(2), code2 char(2), code3 char(2) , cate1 varchar(30), cate2 varchar(30), cate3 varchar(30), rank char(2), order_rank int(10), code4 char(2), cate4 varchar(30))";		
	break;

	// 상품정보 테이블 만들기 
	case ("$shop_goods"):
		$sql="create table $shop_goods";
		$sql=$sql."(";
		$sql=$sql."No int not null primary key auto_increment"; //넘버값
		$sql=$sql.",code1 char(2) not null";
		$sql=$sql.",code2 char(2)";
		$sql=$sql.",code3 char(2)";
		$sql=$sql.",code4 char(2)";
		$sql=$sql.",code varchar(15)";
		
		$sql=$sql.",title varchar(250) not null"; //상품명
		$sql=$sql.",info varchar(100)"; //상품한줄소개
		$sql=$sql.",company varchar(40)";//제조회사
		$sql=$sql.",color text";//색상
		$sql=$sql.",size text";//사이즈
		$sql=$sql.",home varchar(100)";//원산지
		$sql=$sql.",shelf varchar(100)";//유통기한
		
		$sql=$sql.",theme char(30)";//상품홍보 : 일반,추천,베스트,인기,new
		$sql=$sql.",event char(50)";//이벤트 체크박스
		$sql=$sql.",event_str text";//이벤트 : 특가, 1+1, 창고대방출,재고정리,추석맞이 이벤트
		$sql=$sql.",new char(1)";//new이미지사용
		$sql=$sql.",cnt int";//카운트
		$sql=$sql.",pricec int(9)";//정상가
		$sql=$sql.",prices int(9)";//입고가
		$sql=$sql.",priced int(9)";//할인가
		$sql=$sql.",point float(12)";//포인트
		$sql=$sql.",point_dis char(12)";//포인트 구분
		
		$sql=$sql.",currnum int(10)";//현재수량
		$sql=$sql.",warnnum int(5)";//경고수량
		
		$sql=$sql.",imgl varchar(80)";//상품리스트이미지
		$sql=$sql.",imgm varchar(80)";//중간이미지

		$sql=$sql.",imgb1 varchar(80)";//상세이미지1
		$sql=$sql.",imgb2 varchar(80)";//상세이미지2
		$sql=$sql.",imgb3 varchar(80)";//상세이미지3
		$sql=$sql.",imgb4 varchar(80)";//상세이미지4
		$sql=$sql.",imgb5 varchar(80)";//상세이미지5
		
		$sql=$sql.",detail text";//제품설명
		$sql=$sql.",feature text";//규격설명
		$sql=$sql.",signdate int(10)";//등록날짜
		$sql=$sql.",soldout char(1)";//매진
		$sql=$sql.",rank int(4)";//카테고리 순위
		$sql=$sql.",relation varchar(200)";//관련상품

		$sql=$sql.",option_t1 varchar(100)";//옵션명1
		$sql=$sql.",option_n1 text";//옵션사항1
		$sql=$sql.",option_p1 text";//증차감가격1
		$sql=$sql.",option_k1 text";//포인트
		$sql=$sql.",option_t2 varchar(100)";
		$sql=$sql.",option_n2 text";
		$sql=$sql.",option_p2 text";
		$sql=$sql.",option_k2 text";
		$sql=$sql.",option_t3 varchar(100)";
		$sql=$sql.",option_n3 text";
		$sql=$sql.",option_p3 text";
		$sql=$sql.",option_k3 text";
		$sql=$sql.",option_t4 varchar(100)";
		$sql=$sql.",option_n4 text";
		$sql=$sql.",option_p4 text";
		$sql=$sql.",option_k4 text";
		$sql=$sql.",option_t5 varchar(100)";
		$sql=$sql.",option_n5 text";
		$sql=$sql.",option_p5 text";
		$sql=$sql.",option_k5 text";
		$sql=$sql.",order1 int";//노출우선순위,
		$sql=$sql.",order2 int";
		$sql=$sql.",order3 int";
		$sql=$sql.",order4 int";

		$sql=$sql.",color_opt char(3)";//옵션의 필수 선택
		$sql=$sql.",size_opt char(3)";
		$sql=$sql.",add_opt1 char(3)";
		$sql=$sql.",add_opt2 char(3)";
		$sql=$sql.",add_opt3 char(3)";
		$sql=$sql.",add_opt4 char(3)";
		$sql=$sql.",add_opt5 char(3)";

		$sql=$sql.",price_dis varchar(4)";//현금결제 사용여부
		$sql=$sql.",best char(1)";//new이미지사용
		$sql=$sql.",cut char(1)";//new이미지사용
		$sql=$sql.",recommend char(1)";//new이미지사용

		$sql=$sql.",theme_g char(2)";//상품홍보 : 일반상품
		$sql=$sql.",theme_n char(2)";//상품홍보 : 신상품
		$sql=$sql.",theme_r char(2)";//상품홍보 : 베스트
		$sql=$sql.",theme_f char(2)";//상품홍보 : 특가
		$sql=$sql.",theme_x char(2)";//상품홍보 : 
		$sql=$sql.",theme_y char(2)";//상품홍보 : 
		$sql=$sql.",theme_z char(2)";//상품홍보 : 
		$sql=$sql.",theme_s char(2)";//상품홍보 : 

		$sql=$sql.",rank_g int(4)";//카테고리 순위
		$sql=$sql.",rank_n int(4)";//카테고리 순위
		$sql=$sql.",rank_r int(4)";//카테고리 순위
		$sql=$sql.",rank_f int(4)";//카테고리 순위
		$sql=$sql.",rank_x int(4)";//카테고리 순위
		$sql=$sql.",rank_y int(4)";//카테고리 순위
		$sql=$sql.",rank_z int(4)";//카테고리 순위
		$sql=$sql.",rank_s int(4)";//카테고리 순위

		$sql=$sql.",opt_num varchar(250)";//묶음
		$sql=$sql.",opt_num_str varchar(250)";
		$sql=$sql.",p_id varchar(20)"; //등록아이디
		$sql=$sql.",esigndate int(10)";//이벤트마감일

	
		$sql=$sql.")";
	break;

	// 주문정보 테이블 만들기 
	case ("$shop_order"):
		$sql="create table $shop_order";
		$sql=$sql."(";
		$sql=$sql."ordernum int(10) not null primary key";//주문번호

		$sql=$sql.",id varchar(20)";//주문자 id
		$sql=$sql.",pay_name varchar(40)";//주문자
		$sql=$sql.",pay_tel varchar(20)";//주문자 연락처
		$sql=$sql.",pay_mobile varchar(20)";//주문자 연락처
		$sql=$sql.",pay_zip1 char(6)";//주문자 우편번호
		$sql=$sql.",pay_zip2 char(6)";
		$sql=$sql.",pay_addr varchar(100)";//주문자 주소
		$sql=$sql.",pay_email varchar(40)";//주문자 이메일

		$sql=$sql.",pay_etc text";//판매자에게 남길 말

		$sql=$sql.",receive_name varchar(40)";//수취인 이름
		$sql=$sql.",receive_tel varchar(20)";
		$sql=$sql.",receive_mobile varchar(20)";
		$sql=$sql.",receive_zip1 char(6)";
		$sql=$sql.",receive_zip2 char(6)";
		$sql=$sql.",receive_addr varchar(100)";
		$sql=$sql.",receive_email varchar(40)";
		$sql=$sql.",receive_etc text";//특이사항, 택배원에게 남길 말

		$sql=$sql.",kind char(1)";//입금종류
		$sql=$sql.",bank varchar(40)";//입금계좌

		$sql=$sql.",pointin int(10) ";
		$sql=$sql.",pointout int(10) ";
		$sql=$sql.",in_name varchar(40)";//입금자명
		$sql=$sql.",in_year varchar(4)";//입금예정일
		$sql=$sql.",in_month char(2)";
		$sql=$sql.",in_day char(2)";
		$sql=$sql.",charge int(9) ";//배송비
		$sql=$sql.",char_year varchar(4)";//상품발송일
		$sql=$sql.",char_month char(2)";
		$sql=$sql.",char_day char(2)";

		$sql=$sql.",char_num varchar(20)";//송장번호

		$sql=$sql.",status varchar(80)";//처리상태
		$sql=$sql.",passwd varchar(12)";//비회원
		$sql=$sql.",signdate int(10)";//주문날짜
		$sql=$sql.",tid varchar(60)";//판매자가 다른경우용

		$sql=$sql.",approve varchar(50)";//카드전표
		$sql=$sql.",transaction varchar(100)";//영수증출력
		$sql=$sql.",send_no varchar(6)";//카드전표
		$sql=$sql.",appr_tm varchar(8)";//카드전표
		$sql=$sql.")";
	break;

	// 주문상품정보
	case ("$shop_sell"):
		$sql="create table $shop_sell";
		$sql=$sql."(";
		$sql=$sql."ordernum int(10) not null ";//주문번호
		$sql=$sql.",code varchar(15)";
		$sql=$sql.",title varchar(100)";
		$sql=$sql.",money int(10)";
		$sql=$sql.",point int(9)";
		$sql=$sql.",count mediumint(6)";//주문갯수
		$sql=$sql.",code1 char(2)";
		$sql=$sql.",code2 char(2)";
		$sql=$sql.",code3 char(2)";
		$sql=$sql.",code4 char(2)";
		$sql=$sql.",signdate int(10)";
		$sql=$sql.",opt1 varchar(250)";//색상
		$sql=$sql.",opt2 varchar(250)";//사이즈
		$sql=$sql.",new_opt1 varchar(250)";//옵션명,옵션사항,증차감가격,포인트
		$sql=$sql.",new_opt2 varchar(250)";
		$sql=$sql.",new_opt3 varchar(250)";
		$sql=$sql.",new_opt4 varchar(250)";
		$sql=$sql.",new_opt5 varchar(250)";

		$sql=$sql.",company varchar(30)"; //택배회사
		$sql=$sql.",com_num varchar(30)"; //송장번호

		$sql=$sql.")";
	break;

	// 회원정보 테이블 만들기 
	case ("$member"):
		$sql="create table $member";
		$sql=$sql."(";
		$sql=$sql."id varchar(20) not null primary key";
		$sql=$sql.",passwd varchar(20)";
		$sql=$sql.",name varchar(20)";
		$sql=$sql.",jumin varchar(15)"; //생년월일
		$sql=$sql.",solar int(1)";
		$sql=$sql.",sex char(1)";
		$sql=$sql.",job char(2)";
		$sql=$sql.",email varchar(50)";
		$sql=$sql.",tel varchar(14)";
		$sql=$sql.",handphone varchar(14)";
		$sql=$sql.",zip varchar(8)";
		$sql=$sql.",address varchar(100)";
		$sql=$sql.",info text";//자기소개
		$sql=$sql.",signdate int(10)";
		$sql=$sql.",point int(10)";
		$sql=$sql.",admail int(1)";
		$sql=$sql.",adsms int(1)";
		$sql=$sql.",dis int(1)";//회원구분
		$sql=$sql.",cont varchar(250)";
		$sql=$sql.",dis1 int(1)";//회원승인
		$sql=$sql.",company varchar(50)";//회사명
		$sql=$sql.",recommend varchar(50)"; //추천인
		$sql=$sql.",comnum varchar(30)";//사업자번호
		$sql=$sql.",member_cnt int(11)";
		$sql=$sql.",etc1 text";//이벤트 내역
		$sql=$sql.",etc2 text";//미수내역
		$sql=$sql.")";
	break;
	
	// 이벤트데이타 테이블 만들기 
	case ("$member_p"):
		$sql="create table $member_p";
		$sql=$sql."(";
		$sql=$sql."no int not null primary key auto_increment";
		$sql=$sql.",id varchar(20) not null"; //상품코드
		$sql=$sql.",name varchar(20)"; //이름
		$sql=$sql.",jumin varchar(15)"; //생년월일
		$sql=$sql.",sex char(1)"; //성별
		$sql=$sql.",email varchar(50)"; //이메일
		$sql=$sql.",handphone varchar(14)"; //핸드폰
		$sql=$sql.",zip varchar(8)"; //우편번호
		$sql=$sql.",address varchar(100)"; //주소
		$sql=$sql.",info text";//메모
		$sql=$sql.",signdate int(10)"; //등록일
		$sql=$sql.",Fname varchar(20)"; //첨부파일
		$sql=$sql.",admail int(1)"; //개인정보동의(1,2)
		$sql=$sql.",adsms int(1)"; //이벤트정보(1,2)
		$sql=$sql.",c_jinx varchar(30)";//미수내역
		$sql=$sql.",c_code varchar(30)";//미수내역
		$sql=$sql.")";


		//no,id,name,jumin,sex,email,handphone,zip,address,info,signdate,Fname,admail,adsms
	break;

	// 포인트 테이블 만들기
	case ("$shop_point"):
		$sql="create table $shop_point";
		$sql=$sql."(";
		$sql=$sql."No int not null primary key auto_increment";
		$sql=$sql.",Cid varchar(20)";		
		$sql=$sql.",Cont varchar(200)";
		$sql=$sql.",Point int";
		$sql=$sql.",Wdate datetime";
		$sql=$sql.",Signdate int(10)";//주문날짜
		$sql=$sql.")";
	break;

	// 로그인정보 테이블 만들기 
	case ("$member_log"):
		$sql="create table $member_log";
		$sql=$sql."(";
		$sql=$sql."No int not null primary key auto_increment";
		$sql=$sql.",id varchar(30)";
		$sql=$sql.",wdate int";
		$sql=$sql.")";
	break;

	// 장바구니테이블 만들기 
	case ("$shop_cart"):
		$sql="create table $shop_cart";
		$sql=$sql."(";
		$sql=$sql."no int not null primary key auto_increment";
		$sql=$sql.",cart_id varchar(20)";
		$sql=$sql.",cart_cont text";
		$sql=$sql.")";
	break;

	//  찜하기 테이블 만들기 
	case ("$shop_save"):
		$sql="create table $shop_save";
		$sql=$sql."(";
		$sql=$sql."no int(20) not null primary key auto_increment";
		$sql=$sql.",s_id varchar(20)";
		$sql=$sql.",s_code varchar(30)";
		$sql=$sql.",s_cont text";
		$sql=$sql.",date datetime";
		$sql=$sql.")";
	break;

	// 접속통계 테이블 만들기 
	case ("$state"):
		$sql="create table $state (id varchar(20) not null primary key,passwd varchar(20),name varchar(20),jumin varchar(13),sex char(1),job char(2),email varchar(50),tel varchar(14),handphone varchar(14),zip varchar(6),address varchar(100),info text,signdate int(10),point int(10),admail varchar(4))";	
	break;

	// 아이피통계테이블 만들기 
	case ("$attendance"):
		$sql="create table $attendance";
		$sql=$sql."(";
		$sql=$sql."no int not null primary key auto_increment";
		$sql=$sql.",id varchar(120) not null";
		$sql=$sql.",signdate int(11)";
		$sql=$sql.",ip char(30)";
		$sql=$sql.")";


	break;

	// 상품 코인 가격
	case ("$coin_goods"):
		$sql="create table $coin_goods";
		$sql=$sql."(";
		$sql=$sql."no int not null primary key auto_increment";
		$sql=$sql.",goods_no int(11) not null";
		$sql=$sql.",title varchar(200) not null";
		$sql=$sql.",coin_price int(10) not null";
		$sql=$sql.",signdate int(11)";
		$sql=$sql.")";
	break;

	

	default :
}

$r = mysql_query("$sql");
	if(!$r) {
		echo $sql;
		echo "<center><br><br><H1> 테이블 생성 오류</H1><br>
		<table width='600' cellpadding='5'><tr><td>$sql</td></tr></table>
		<br><BR><a href='index.php'>리스트로 이동</a>";
	} else {
		echo "<center><br><br><H1> 테이블 생성 완료</H1><br>
		<table width='600' cellpadding='5'><tr><td>$sql</td></tr></table>
		<br><BR><a href='index.php'>리스트로 이동</a>";
	}


 
include "../inc/down_menu.php"; 
?>