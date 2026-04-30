<? 
include "../common/dbconn.php";
include "../inc/top_menu.php";
include "../inc/left_menu_db_table.php";
?>


<table width=700 border=0 cellpadding=0 cellspacing=0>
	<tr><td height=30 colspan="2"></td></tr>
	<tr>
		<td width=60 align=center><img src="../image/icon1.gif" width=45 height=35 border=0></td>
		<td class='td14'>&nbsp;<b>데이터베이스 설정</b></td>
	</tr>
	<tr><td height=3 colspan="2"></td></tr>
</table>


									
<?
### 테이블 존재 여부 ##################################################
$tts = mysql_list_tables ($dbname); 
	for($k=0; $k< mysql_num_rows($tts); $k++ ) {
		if ($shop_cate==mysql_tablename($tts, $k)) {$shop_cate_find="ok";}
		if ($shop_goods==mysql_tablename($tts, $k)) {$shop_goods_find="ok";}
		if ($shop_order==mysql_tablename($tts, $k)) {$shop_order_find="ok";}
		if ($shop_sell==mysql_tablename($tts, $k)) {$shop_sell_find="ok";}
		if ($member==mysql_tablename($tts, $k)) {$member_find="ok";}
		if ($member_log==mysql_tablename($tts, $k)) {$member_log_find="ok";}
		if ($shop_point==mysql_tablename($tts, $k)) {$shop_point_find="ok";}
		if ($shop_cart==mysql_tablename($tts, $k)) {$shop_cart_find="ok";}
		if ($shop_save==mysql_tablename($tts, $k)) {$shop_save_find="ok";}
		if ($state==mysql_tablename($tts, $k)) {$state_find="ok";}
		if ($attendance==mysql_tablename($tts, $k)) {$attendance_find="ok";}
		if ($member_p==mysql_tablename($tts, $k)) {$member_p_find="ok";}
		if ($coin_goods==mysql_tablename($tts, $k)) {$last_price_table_find="ok";}

		
	}
	
	echo "<table width=700 border=0 cellpadding=0 cellspacing=0>
		<tr><td colspan=2 height=3 bgcolor='#88B7DA'></td></tr>
		<tr bgcolor='#EBF0F4'>
		<td width=50% height=29 align=center>테이블이름</td>
		<td width=50% align=center>테이블생성/삭제</td>		
		</tr>
		<tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>
		<tr><td colspan=2 height=3></td></tr>";

	### 관리자 테이블 존재 여부 ##################################################

	// 상품분류테이블

	if ($shop_cate_find=="ok") {		
		echo "<tr><td height=27 align=center><B>상품분류테이블</B></td><td align=center><a href='setup.php?delete=drop&drop_table=$shop_cate'>$shop_cate 삭제</a></td></tr><tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>";
	} else {
		echo "<tr><td height=27 align=center><B>상품분류테이블</B></td><td align=center><a href='setup.php?setup=$shop_cate'>$shop_cate 생성하기</a></td></tr><tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>";
	}

	// 상품정보테이블
	if ($shop_goods_find=="ok") {		
		echo "<tr><td height=27 align=center><B>상품정보테이블</B></td><td align=center><a href='setup.php?delete=drop&drop_table=$shop_goods'>$shop_goods 삭제</a></td></tr><tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>";
	} else {
		echo "<tr><td height=27 align=center><B>상품정보테이블</B></td><td align=center><a href='setup.php?setup=$shop_goods'>$shop_goods 생성하기</a></td></tr><tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>";
	}

	// 주문정보테이블
	if ($shop_order_find=="ok") {		
		echo "<tr><td height=27 align=center><B>주문정보테이블</B></td><td align=center><a href='setup.php?delete=drop&drop_table=$shop_order'>$shop_order 삭제</a></td></tr><tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>";
	} else {
		echo "<tr><td height=27 align=center><B>주문정보테이블</B></td><td align=center><a href='setup.php?setup=$shop_order'>$shop_order 생성하기</a></td></tr><tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>";
	}

	// 매출정보테이블
	if ($shop_sell_find=="ok") {		
		echo "<tr><td height=27 align=center><B>매출정보테이블</B></td><td align=center><a href='setup.php?delete=drop&drop_table=$shop_sell'>$shop_sell 삭제</a></td></tr><tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>";
	} else {
		echo "<tr><td height=27 align=center><B>매출정보테이블</B></td><td align=center><a href='setup.php?setup=$shop_sell'>$shop_sell 생성하기</a></td></tr><tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>";
	}

	// 회원정보테이블
	if ($member_find=="ok") {		
		echo "<tr><td height=27 align=center><B>회원정보테이블</B></td><td align=center><a href='setup.php?delete=drop&drop_table=$member'>$member 삭제</a></td></tr><tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>";
	} else {
		echo "<tr><td height=27 align=center><B>회원정보테이블</B></td><td align=center><a href='setup.php?setup=$member'>$member 생성하기</a></td></tr><tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>";
	}

	// 회원로그인테이블
	if ($member_log_find=="ok") {		
		echo "<tr><td height=27 align=center><B>회원로그인테이블</B></td><td align=center><a href='setup.php?delete=drop&drop_table=$member_log'>$member_log 삭제</a></td></tr><tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>";
	} else {
		echo "<tr><td height=27 align=center><B>회원로그인테이블</B></td><td align=center><a href='setup.php?setup=$member_log'>$member_log 생성하기</a></td></tr><tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>";
	}

// 회원포인트테이블
	if ($shop_point_find=="ok") {		
		echo "<tr><td height=27 align=center><B>포인트테이블</B></td><td align=center><a href='setup.php?delete=drop&drop_table=$shop_point'>$shop_point 삭제</a></td></tr><tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>";
	} else {
		echo "<tr><td height=27 align=center><B>포인트테이블</B></td><td align=center><a href='setup.php?setup=$shop_point'>$shop_point 생성하기</a></td></tr><tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>";
	}

	// 장바구니 저장공간
	if ($shop_cart_find=="ok") {		
		echo "<tr><td height=27 align=center><B>장바구니저장공간테이블</B></td><td align=center><a href='setup.php?delete=drop&drop_table=$shop_cart'>$shop_cart 삭제</a></td></tr><tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>";
	} else {
		echo "<tr><td height=27 align=center><B>장바구니저장공간테이블</B></td><td align=center><a href='setup.php?setup=$shop_cart'>$shop_cart 생성하기</a></td></tr><tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>";
	}

		// 찜하기 저장공간
	if ($shop_save_find=="ok") {		
		echo "<tr><td height=27 align=center><B>찜하기저장공간테이블</B></td><td align=center><a href='setup.php?delete=drop&drop_table=$shop_save'>$shop_save 삭제</a></td></tr><tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>";
	} else {
		echo "<tr><td height=27 align=center><B>찜하기저장공간테이블</B></td><td align=center><a href='setup.php?setup=$shop_save'>$shop_save 생성하기</a></td></tr><tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>";
	}

	// 접속통계테이블
	if ($state_find=="ok") {		
		echo "<tr><td height=27 align=center><B>접속통계테이블</B></td><td align=center><a href='setup.php?delete=drop&drop_table=$state'>$state 삭제</a></td></tr><tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>";
	} else {
		echo "<tr><td height=27 align=center><B>접속통계테이블</B></td><td align=center><a href='setup.php?setup=$state'>$state 생성하기</a></td></tr><tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>";
	}

	// 아이피통계테이블
	if ($attendance_find=="ok") {		
		echo "<tr><td height=27 align=center><B>아이피통계테이블</B></td><td align=center><a href='setup.php?delete=drop&drop_table=$attendance'>$attendance 삭제</a></td></tr><tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>";
	} else {
		echo "<tr><td height=27 align=center><B>아이피통계테이블</B></td><td align=center><a href='setup.php?setup=$attendance'>$attendance 생성하기</a></td></tr><tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>";
	}
	
	// 이벤트데이타
	if ($member_p_find=="ok") {		
		echo "<tr><td height=27 align=center><B>이벤트데이타</B></td><td align=center><a href='setup.php?delete=drop&drop_table=$member_p'>$member_p 삭제</a></td></tr><tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>";
	} else {
		echo "<tr><td height=27 align=center><B>이벤트데이타</B></td><td align=center><a href='setup.php?setup=$member_p'>$member_p 생성하기</a></td></tr><tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>";
	}
	// 상품 코인 가격
	if ($last_price_table_find=="ok") {		
		echo "<tr><td height=27 align=center><B>coin_goods</B></td><td align=center><a href='setup.php?delete=drop&drop_table=$coin_goods'>$coin_goods 삭제</a></td></tr><tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>";
	} else {
		echo "<tr><td height=27 align=center><B>coin_goods</B></td><td align=center><a href='setup.php?setup=$coin_goods'>$coin_goods 생성하기</a></td></tr><tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>";
	}
	
	echo "</table>";


?>
<? include "../inc/down_menu.php"; ?>

