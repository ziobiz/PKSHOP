<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="Generator" content="EditPlus®">
  <title>Kona Summit Platform</title>
  <link rel="stylesheet" href="../include/reset.css">
  <link rel="stylesheet" href="../include/style.css">
  <link href="../include/css/reset.css" rel="stylesheet" type="text/css" media="all"/>
<link href="../include/css/style.css" rel="stylesheet" type="text/css" media="all"/>
<? include "../include/login_check.php"; ?>
<?
if($valid_user != "") {
	if($kkpoint1<$usepoint && $kkpoint1>0){
	?>
		<SCRIPT LANGUAGE="JavaScript">
		<!--
		alert("사용하실코인이 보유코인을 초과하였습니다.");
		history.back();
		//-->
		</SCRIPT>
	<?
	exit;
	}

	if($usepoint>$total_coin1){
	?>
		<SCRIPT LANGUAGE="JavaScript">
		<!--
		alert("사용가능한 코인을 초과하였습니다.");
		history.back();
		//-->
		</SCRIPT>
	<?
	exit;
	}
	
}


include "cartfunc.php";

$buyselected=='Y'? $session_cart=$session_cart_selected:$session_cart=$session_cart;

  if ($session_cart=="") {
	popup_msg("장바구니에 선택하신 상품이 없습니다.");
	exit;
  }

?>


<script language=javascript src="http://www.allthegate.com/plugin/AGSWallet_utf8.js"></script>
<script language=javascript>
<!--
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 올더게이트 플러그인 설치를 확인합니다.
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

StartSmartUpdate();  

function Pay(form){
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// MakePayMessage() 가 호출되면 올더게이트 플러그인이 화면에 나타나며 Hidden 필드
	// 에 리턴값들이 채워지게 됩니다.
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	if(form.Flag.value == "enable"){
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// 입력된 데이타의 유효성을 검사합니다.
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		if(Check_Common(form) == true){
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////
			// 올더게이트 플러그인 설치가 올바르게 되었는지 확인합니다.
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////
			
			if(document.AGSPay == null || document.AGSPay.object == null){
				alert("플러그인 설치 후 다시 시도 하십시오.");
			}else{
				//////////////////////////////////////////////////////////////////////////////////////////////////////////////
				// 올더게이트 플러그인 설정값을 동적으로 적용하기 JavaScript 코드를 사용하고 있습니다.
				// 상점설정에 맞게 JavaScript 코드를 수정하여 사용하십시오.
				//
				// [1] 일반/무이자 결제여부
				// [2] 일반결제시 할부개월수
				// [3] 무이자결제시 할부개월수 설정
				// [4] 인증여부
				//////////////////////////////////////////////////////////////////////////////////////////////////////////////
				
				//////////////////////////////////////////////////////////////////////////////////////////////////////////////
				// [1] 일반/무이자 결제여부를 설정합니다.
				//
				// 할부판매의 경우 구매자가 이자수수료를 부담하는 것이 기본입니다. 그러나,
				// 상점과 올더게이트간의 별도 계약을 통해서 할부이자를 상점측에서 부담할 수 있습니다.
				// 이경우 구매자는 무이자 할부거래가 가능합니다.
				//
				// 예제)
				// 	(1) 일반결제로 사용할 경우
				// 	form.DeviId.value = "9000400001";
				//
				// 	(2) 무이자결제로 사용할 경우
				// 	form.DeviId.value = "9000400002";
				//
				// 	(3) 만약 결제 금액이 100,000원 미만일 경우 일반할부로 100,000원 이상일 경우 무이자할부로 사용할 경우
				// 	if(parseInt(form.Amt.value) < 100000)
				//		form.DeviId.value = "9000400001";
				// 	else
				//		form.DeviId.value = "9000400002";
				//////////////////////////////////////////////////////////////////////////////////////////////////////////////
				
				form.DeviId.value = "9000400001";
				
				//////////////////////////////////////////////////////////////////////////////////////////////////////////////
				// [2] 일반 할부기간을 설정합니다.
				// 
				// 일반 할부기간은 2 ~ 12개월까지 가능합니다.
				// 0:일시불, 2:2개월, 3:3개월, ... , 12:12개월
				// 
				// 예제)
				// 	(1) 할부기간을 일시불만 가능하도록 사용할 경우
				// 	form.QuotaInf.value = "0";
				//
				// 	(2) 할부기간을 일시불 ~ 12개월까지 사용할 경우
				//		form.QuotaInf.value = "0:3:4:5:6:7:8:9:10:11:12";
				//
				// 	(3) 결제금액이 일정범위안에 있을 경우에만 할부가 가능하게 할 경우
				// 	if((parseInt(form.Amt.value) >= 100000) || (parseInt(form.Amt.value) <= 200000))
				// 		form.QuotaInf.value = "0:2:3:4:5:6:7:8:9:10:11:12";
				// 	else
				// 		form.QuotaInf.value = "0";
				//////////////////////////////////////////////////////////////////////////////////////////////////////////////
				
				//결제금액이 5만원 미만건을 할부결제로 요청할경우 결제실패
				if(parseInt(form.Amt.value) < 50000)
					form.QuotaInf.value = "0";
				else
					form.QuotaInf.value = "0:2:3:4:5:6:7:8:9:10:11:12";
				
				////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				// [3] 무이자 할부기간을 설정합니다.
				// (일반결제인 경우에는 본 설정은 적용되지 않습니다.)
				// 
				// 무이자 할부기간은 2 ~ 12개월까지 가능하며, 
				// 올더게이트에서 제한한 할부 개월수까지만 설정해야 합니다.
				// 
				// 100:BC
				// 200:국민
				// 201:NH 
				// 300:외환
				// 310:하나SK
				// 400:삼성
				// 500:신한
				// 800:현대
				// 900:롯데
				// 
				// 예제)
				// 	(1) 모든 할부거래를 무이자로 하고 싶을때에는 ALL로 설정
				// 	form.NointInf.value = "ALL";
				//
				// 	(2) 국민카드 특정개월수만 무이자를 하고 싶을경우 샘플(2:3:4:5:6개월)
				// 	form.NointInf.value = "200-2:3:4:5:6";
				//
				// 	(3) 외환카드 특정개월수만 무이자를 하고 싶을경우 샘플(2:3:4:5:6개월)
				// 	form.NointInf.value = "300-2:3:4:5:6";
				//
				// 	(4) 국민,외환카드 특정개월수만 무이자를 하고 싶을경우 샘플(2:3:4:5:6개월)
				// 	form.NointInf.value = "200-2:3:4:5:6,300-2:3:4:5:6";
				//	
				//	(5) 무이자 할부기간 설정을 하지 않을 경우에는 NONE로 설정
				//	form.NointInf.value = "NONE";
				//
				//	(6) 전카드사 특정개월수만 무이자를 하고 싶은경우(2:3:6개월)
				//	form.NointInf.value = "100-2:3:6,200-2:3:6,201-2:3:6,300-2:3:6,310-2:3:6,400-2:3:6,500-2:3:6,800-2:3:6,900-2:3:6";
				//
				////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				
				if(form.DeviId.value == "9000400002")
					form.NointInf.value = "ALL";
				   
				if(MakePayMessage(form) == true){										
					Disable_Flag(form);
					
					var openwin = window.open("AGS_progress.php","popup","width=300,height=160"); //"지불처리중"이라는 팝업창연결 부분
					
					form.submit();
				}else{
					alert("지불에 실패하였습니다.");// 취소시 이동페이지 설정부분
				}
			}
		}
	}
}

function Enable_Flag(form){
        form.Flag.value = "enable"
}

function Disable_Flag(form){
        form.Flag.value = "disable"
}

function Check_Common(form){
	if(form.StoreId.value == ""){
		alert("상점아이디를 입력하십시오.");
		return false;
	}
	else if(form.StoreNm.value == ""){
		alert("상점명을 입력하십시오.");
		return false;
	}
	else if(form.OrdNo.value == ""){
		alert("주문번호를 입력하십시오.");
		return false;
	}
	else if(form.ProdNm.value == ""){
		alert("상품명을 입력하십시오.");
		return false;
	}
	else if(form.Amt.value == ""){
		alert("금액을 입력하십시오.");
		return false;
	}
	else if(form.MallUrl.value == ""){
		alert("상점URL을 입력하십시오.");
		return false;
	}
	return true;
}

function Display(form){
	if(form.Job.value == "onlycard" || form.TempJob.value == "onlycard"){
		document.all.card_hp.style.display= "";
		document.all.card.style.display= "";
		document.all.hp.style.display= "none";
		document.all.virtual.style.display= "none";
	}else if(form.Job.value == "onlyhp" || form.TempJob.value == "onlyhp"){
		document.all.card_hp.style.display= "";
		document.all.card.style.display= "none";
		document.all.hp.style.display= "";
		document.all.virtual.style.display= "none";
	}else if(form.Job.value == "onlyvirtual" || form.TempJob.value == "onlyvirtual" ){
		document.all.card_hp.style.display= "none";
		document.all.card.style.display= "";
		document.all.hp.style.display= "none";
		document.all.virtual.style.display= "";
	}else if(form.Job.value == "onlyiche" || form.TempJob.value == "onlyiche"  ){
		document.all.card_hp.style.display= "none";
		document.all.card.style.display= "none";
		document.all.hp.style.display= "none";
		document.all.virtual.style.display= "none";
	}else{
		document.all.card_hp.style.display= "";
		document.all.card.style.display= "";
		document.all.hp.style.display= "";
		document.all.virtual.style.display= "";
	}
}
-->
</script>
 </head>
 <body  <?if($paymentkind=="1"){?>onload="javascript:Enable_Flag(frmAGS_pay);"<?}?>>
	<div id="wrap">	

	<!-- 상단(Top) -->

	 
	  <? include "../include/top.php"; ?>

				
	<!-- 상단(Top) -->

	<!-- 컨텐츠 시작 -->
		
		<div class="content_inner">

			<div class="sp40"></div>
			
			<!-- 카테고리 -->
				
			<? include "../include/category_info.php"; ?>

			<!-- 카테고리 끝 -->

			<div class="content">
				<div class="page_title">
					주문완료
				</div>
	 
				<div class="confrim_title">
					<img src="images/confirm_icon01.png" alt="아이콘"><br/>
					주문이 완료되었습니다!<br/>
					<span class="confrim_title01">이용해주셔서 감사합니다.</span>
				</div>

				<div class="sp40"></div>

				<table class="cart_table">
					<tr>
						<th width="12%">주문번호</th>
						<th width="15%">상품이미지</th>
						<th width="43%">	주문정보</th>
						<th width="10%">가격/인원</th>
						<th width="10%">적립금</th>
						<th width="10%">소계</th>
					</tr>
					<tr class="cart_table_line">
						<td>2017010100868<p class="c_9">2017-01-01</p></td>
						<td class="cart_img"><a href="#"><img src="images/product_img.jpg" alt="상품"/></a></td>
						<td class="align_right">
							<a href="#" class="a_3">[명함]누브지(90 x 50 mm/단면/200매/1명: 12,000원)<p class="font_thin a_9">샘플/레이아웃 의뢰 : 11,000원</p></a>
						</td>
						<td>12,000원/1명<br/>옵션 : 11,000원</td>
						<td class="c_sky">230원</td>
						<td class="c_red">23,000원</td>
					</tr>
					<tr>
						<td colspan="6" class="cart_price">
							<div class="sp5"></div>
							총계 가격 <span class="c_red font_22">23,000</span>원
							<div class="sp5"></div>
						</td>
					</tr>
				</table>

				<div class="sp30"></div>

				<div class="order_table_title">
					주문하시는 분
				</div>

				<table class="order_table">
					<tr>
						<th width="18%">이 름</th>
						<td width="78%">관리자</td>
					</tr>
					<tr>
						<th>핸드폰</th>
						<td>010-1234-5678</td>
					</tr>
					<tr>
						<th>전화번호</th>
						<td>010-1234-5678</td>
					</tr>
					<tr>
						<th>E-Mail</th>
						<td>help@paxm.net</td>
					</tr>
					<tr>
						<th>주 소</th>
						<td>
							대전광역시 중구 중촌동 896-11번지<br/><br/>
							매산빌딩 5층 505호
						</td>
					</tr>
				</table>

				<div class="sp30"></div>

				<div class="order_table_title">
					받으시는 분<input type="checkbox" class="checkbox"> <span class="font_thin font_12">주문자와 동일</span>
				</div>

				<table class="order_table">
					<tr>
						<th width="18%">이 름</th>
						<td width="78%">관리자</td>
					</tr>
					<tr>
						<th>핸드폰</th>
						<td>010-1524-1564</td>
					</tr>
					<tr>
						<th>전화번호</th>
						<td>010-1234-5678</td>
					</tr>
					<tr>
						<th>E-Mail</th>
						<td>help@paxm.net</td>
					</tr>
					<tr>
						<th>주 소</th>
						<td>
							대전광역시 중구 중촌동 896-11번지<br/><br/>
							매산빌딩 5층 505호
						</td>
					</tr>
					<tr>
						<th class="align_top">전하실 말</th>
						<td>
							
						</td>
					</tr>
				</table>

				<div class="sp30"></div>

				<div class="order_table_title">
					결제정보
				</div>

				<table class="order_table">
					<tr>
						<th width="18%">결제수단</th>
						<td width="78%">무통장입금</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<span class="font_b">입금자명</span>관리자<br/><br/>
							국민 71012-45-67890
						</td>
					</tr>
				</table>

				<div class="sp20"></div>

				<div class="view_btn">
					<input type="button" value="메인으로" class="cart_btn01" onclick="location.href='../main/main.php'">
					<input type="button" value="주문내역" class="cart_btn03" onclick="location.href='overview.php'">
				</div>
			</div>
		</div>
		</div>
	<!-- 컨텐츠 종료 -->


	<!-- 하단(Copy) -->

	 <div class="sp50"></div>
	  <? include "../include/bottom.html"; ?>	  
				
				
	<!-- 하단(Copy) -->

	


</div>
</body>
</html>
