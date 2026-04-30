<?include "../include/top_session.php";?>
<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="Generator" content="EditPlus®">
  <? include "../../Adm/common/dbconn.php";



  $id = $_SESSION[valid_user];
  $query = "SELECT passwd,name,jumin,sex,job,email,tel,handphone,zip,address,info,point,dis,dis1,company,recommend,comnum,etc1,etc2,cont,solar,admail,adsms from $member_table WHERE id='$id'";

$result = mysql_query($query,$DBconn);
if(!$result) {
  	error("QUERY_ERROR");
  	exit;
}
$row = mysql_fetch_row($result);
$real_pass = $row[0];
$name = $row[1];
$jumin = $row[2];
$sex = $row[3];
$job = $row[4];
$email = $row[5];
$tel = $row[6];
$handphone = $row[7];
$zipcorde = $row[8];
$address = $row[9];
$info = $row[10];
$point = $row[11];
$dis = $row[12];
$dis1 = $row[13];
$company = $row[14];
$recommend = $row[15];
$comnum = $row[16];
$etc1 = $row[17];
$etc2 = $row[18];
$cont = $row[19];
$solar = $row[20];
$admail = $row[21];
$adsms = $row[22];

  $handphone = explode("-",$handphone);

  $handphone1 = $handphone[0];
  $handphone2 = $handphone[1];
  $handphone3 = $handphone[2];
  ?>
  <script language="javascript">
	<!--
	function go_modify() {      
		if(document.form.passwd.value != "") {
			if(document.form.passwd.value.length < 4) {
				alert('비밀번호는 최소 4자 이상 입력하세요!');
				document.form.newpasswd.focus();
				return;
			}
			if(!document.form.passwd2.value) {
				alert('새 비밀번호 확인를 입력하세요!');
				document.form.passwd2.focus();
				return;
			}
			if(document.form.passwd.value != document.form.passwd2.value) {
				alert('새 비밀번호와 새 비밀번호확인이 일치하지 않습니다.');
				document.form.passwd2.focus();
				return;
			}
		}
		document.form.action="member_modify_ok.php";
		document.form.submit();
	}
	function go_reset() {      
		document.form.passwd.value="";
		document.form.passwd2.value="";

		document.form.sex[0].checked=true;
		document.form.belt[0].selected=true;
		document.form.job[0].selected=true;
		document.form.email.value="";
		document.form.homepage.value="";
		document.form.tel.value="";
		document.form.handphone.value="";
		document.form.zipcode.value="";

		document.form.addrss.value="";	
	}

	function go_list() {
		document.form.action="member.php";
		document.form.submit();
	}
	function open_addr(url){
		window.open(url,"window","width=466,height=230,toolbar=no,location=no,directorys=no,status=no,menubar=no,scrollbars=yes,resizable=no,left=100,top=100")
	}

	//-->
	</script> 
 </head>
 <body>
	<div id="wrap">	

	<!-- 상단(Top) -->

	 
	  <? include "../include/top.php"; ?>

				
	<!-- 상단(Top) -->

	<!-- 컨텐츠 시작 -->
	<div id="content">
		
		<div class="content_inner">

			<div class="sp40"></div>

				<!-- 카테고리 -->

				<? include "../include/category_info.php"; ?>

				<!-- 카테고리 끝 -->

			<form name="form" method="post" class="content">
				<div class="page_title">
					내정보수정
				</div>

				<table class="board_write">
					<tr>
						<th width="20%" class="bg">아이디</th>
						<td class="bg"><input type="text" name="id" value="<?=$id?>" class="input_writer" readonly></td>
					</tr>
					<tr>
						<th>이 름</th>
						<td><input type="text" name="name" value="<?=$name?>" class="input_writer"></td>
					</tr>
					<tr>
						<th>새 비밀번호</th>
						<td><input type="password" name="passwd" id="passwd" value="" class="input_writer"></td>
					</tr>
					<tr>
						<th>비밀번호 확인</th>
						<td><input type="password" name="passwd2" id="passwd2" class="input_writer"></td>
					</tr>
					<tr>
						<th>이메일</th>
						<td><input type="text" name="email" value="<?=$email?>" class="input_writer"></td>
					</tr>
					<tr>
						<th>연락처</th>
						<td>
							<select name="handphone1" class="join_tel">
								<option <?if($handphone1 =="010"){?> selected <?}?> value="010">010</option>
								<option <?if($handphone1 =="011"){?> selected <?}?> value="011">011</option>
								<option <?if($handphone1 =="019"){?> selected <?}?> value="019">019</option>
								<option <?if($handphone1 =="018"){?> selected <?}?> value="018">018</option>
								<option <?if($handphone1 =="017"){?> selected <?}?> value="017">017</option>
								<option <?if($handphone1 =="016"){?> selected <?}?> value="016">016</option>
							</select> - 
							<input type="text" name="handphone2" value="<?=$handphone2?>" class="input_w_tel"> - <input type="text" name="handphone3" value="<?=$handphone3?>" class="input_w_tel"></td>
					</tr>
					<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
						<script>
							function openDaumPostcode() {							
							new daum.Postcode({
								oncomplete: function(data) {
									// 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

									// 도로명 주소의 노출 규칙에 따라 주소를 조합한다.
									// 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
									var fullRoadAddr = data.roadAddress; // 도로명 주소 변수
									var extraRoadAddr = ''; // 도로명 조합형 주소 변수

									// 법정LANX MALL이 있을 경우 추가한다. (법정리는 제외)
									// 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
									if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
										extraRoadAddr += data.bname;
									}
									// 건물명이 있고, 공동주택일 경우 추가한다.
									if(data.buildingName !== '' && data.apartment === 'Y'){
									   extraRoadAddr += (extraRoadAddr !== '' ? ', ' + data.buildingName : data.buildingName);
									}
									// 도로명, 지번 조합형 주소가 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
									if(extraRoadAddr !== ''){
										extraRoadAddr = ' (' + extraRoadAddr + ')';
									}
									// 도로명, 지번 주소의 유무에 따라 해당 조합형 주소를 추가한다.
									if(fullRoadAddr !== ''){
										fullRoadAddr += extraRoadAddr;
									}

									// 우편번호와 주소 정보를 해당 필드에 넣는다.
									document.getElementById('zipcorde').value = data.zonecode; //5자리 새우편번호 사용
									document.getElementById('address').value = fullRoadAddr;
									//document.getElementById('address').value = data.jibunAddress;

									
								}
							}).open();	
							}
						</script>
					<tr>
						<th>주소</th>
						<td>
						<input type="text" name="zipcorde" value="<?=$zipcorde?>" id="zipcorde" class="input_w_email"> <input type="button" value="Find Address" class="modi_btn_addr" onclick="javascript:openDaumPostcode();">
						<div class="sp5"></div>
						<input type="text" name="address" value="<?=$address?>" id="address" class="input_writer">					
									
						</td>
					</tr>

					<!-- <tr>
						<th>추천인</th>
						<td><input type="text" name="recommend" value="<?=$recommend?>" class="input_writer"></td>
					</tr> -->
<!-- 					<tr> -->
<!-- 						<th>후원자</th> -->
<!-- 						<td><input type="text" name="recommend2" value="<?=$recommend2?>" class="input_writer"></td> -->
<!-- 					</tr> -->
				</table>

				<div class="sp20"></div>

				<div class="write_btn_box">
					<input type="button" value="확 인" class="cart_btn04" onClick="javscript:go_modify();">
				</div>

				<div class="sp20"></div>
<!-- 				<table class="board_write"> -->
<!-- 					<tr> -->
<!-- 						<th width="20%" class="bg">회사명</th> -->
<!-- 						<td class="bg"><input type="text"  name="company" value="" class="input_writer"></td> -->
<!-- 					</tr> -->
<!-- 					<tr> -->
<!-- 						<th>대표자명</th> -->
<!-- 						<td><input type="text" name="cname" value="" class="input_writer"></td> -->
<!-- 					</tr> -->
<!-- 					<tr> -->
<!-- 						<th>사업자등록번호</th> -->
<!-- 						<td><input type="text" name="cnumber" value="" class="input_writer"><br>예시) 796-04-00676</td> -->
<!-- 					</tr> -->
<!-- 					<tr> -->
<!-- 						<th>업태</th> -->
<!-- 						<td><input type="cup" name="cup" value="" class="input_writer"></td> -->
<!-- 					</tr> -->
<!-- 					<tr> -->
<!-- 						<th>종목</th> -->
<!-- 						<td><input type="text" name="cjung" value="" class="input_writer"></td> -->
<!-- 					</tr> -->
<!-- 					<tr> -->
<!-- 						<th>세금계산서발행여부</th> -->
<!-- 						<td><input type="radio" name="cdis" value="0"> 발행<input type="radio" name="cdis" value="1">미발행</td> -->
<!-- 					</tr> -->
<!-- 					 -->
<!-- 					<tr> -->
<!-- 						<th>주소</th> -->
<!-- 						<td> -->
<!-- 						<input type="text" name="czip" value="" id="czip" class="input_w_email"> <input type="button" value="Find Address" class="modi_btn_addr" onclick=""> -->
<!-- 						<div class="sp5"></div> -->
<!-- 						<input type="text" name="caddr" value="" id="caddr" class="input_writer">					 -->
<!-- 						<div class="sp5"></div> -->
<!-- 						</td> -->
<!-- 					</tr> -->
<!-- 					 -->
<!-- 				</table> -->
<!--  -->
<!-- 				<div class="sp20"></div> -->
<!--  -->
<!-- 				<div class="write_btn_box"> -->
<!-- 					<input type="button" value="확 인" class="cart_btn04" onClick=""> -->
<!-- 				</div> -->
<!-- 			</form> -->

		</div>			
			
	</div>
	<!-- 컨텐츠 종료 -->


	<!-- 하단(Copy) -->

	 <div class="sp50"></div>
	  <? include "../include/bottom.php"; ?>	  
				
				
	<!-- 하단(Copy) -->

	


</div>
</body>
</html>
