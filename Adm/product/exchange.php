<?
########## 입력값에 대한 타당성 검사를 수행한다. ####################
include "../common/dbconn.php";
include "../inc/top_menu.php";
include "../inc/left_menu_product.php";

include "../common/user_function.php";

########## 데이터베이스에 연결한다. #################################
$query = "SELECT coin_price FROM $coin_goods order by no desc";
$DB->get($query,$rs,$rn);
$value = mysql_fetch_row($result);
$exchange = $value[0];

?>
				<table width="700" border="0" cellspacing="0" cellpadding="0">
					<tr><td height=30></td></tr>
					<tr><td>
							<table border=0 cellpadding=0 cellspacing=0>
								
							</table>
					</td></tr>
					<tr><td height=3></td></tr>
					<tr>
						<td>
							<table width="600" border='0' cellspacing='0' cellpadding='0'>
							<form name="m_form" method="post" action="exchange_t.php">
							<tr>
									<td colspan=2><img src="../image/icon2.gif" width=45 height=35 border=0> <b>원 & DIOT 관리</b></td>
								</tr>
								<tr><td colspan=4 height=2 bgcolor='#88B7DA'></td></tr>
								<tr><td colspan=4 height=5></td></tr>
								<tr>
									<td width=115 height="30"> 
										<div align="center"><font size="2" face="돋움"> 1 DIOT &nbsp;=></font></div>
									</td>
									<td width=479 height="30" colspan="3" align="left"><input type="text" class="adminbttn numberic" name="exchange_t" size="10" value="<?=$exchange?>">&nbsp;원</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr>
				</table>
						</td>
					</tr>
						</form>
				</table> 
				<table width="600" border="0" cellspacing="0" cellpadding="4" class="left_margin30">
					<tr><td height="30"></td></tr>
					<tr> 
						<td height="20" align="center"> 
							<input type="button" value="수정하기" class="adminbttn" onClick="javascript:go_send()" style="cursor:pointer">
							<input type="button" value="뒤로가기" class="adminbttn" onClick="href:history.back();" style="cursor:pointer">
						</td>
					</tr>
				</table>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
				<script>
				$(document).ready(function(){
					$( ".numberic" ).keyup(function() {
						this.value = this.value.replace(/[^0-9^.]/g,'');	// 숫자 . 만 입력받기
					})
				});
				function go_send(){
					if(!document.m_form.exchange_t.value){
						alert("비율을 입력하세요.");
						document.m_form.exchange_t.focus();
						return false;
					}
					document.m_form.submit();
				}
				</script>

<? include "../inc/down_menu.php"; ?>