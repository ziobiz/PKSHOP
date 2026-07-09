<?
########## 입력값에 대한 타당성 검사를 수행한다. ####################
include "../common/dbconn.php";
include_once "../inc/admin_shell_lib.php";
include "../common/user_function.php";

########## 데이터베이스에 연결한다. #################################
include "../../pc/include/core_api.php";

$master_acount = $_POST["addr"];
$master_balance = $_POST["balance"];

?>
<?php pkshop_admin_auto_shell_begin(); ?>
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
							<form name="m_form" method="post" action="master_send_t.php">
							<tr>
									<td colspan=2><img src="../image/icon2.gif" width=45 height=35 border=0> <b>Master 계좌 출금</b></td>
								</tr>
								<tr><td colspan=4 height=2 bgcolor='#88B7DA'></td></tr>
								<tr><td colspan=4 height=5></td></tr>
								<tr>
									<td width=115 height="30"> 
										<div align="center"><font size="2" face="돋움">Master 계좌명</font></div>
									</td>
									<td width=479 height="30" colspan="3" align="left"><input type="text" class="adminbttn" name="c_coin" size="30" value="<?=$mater_wallet?>" readonly /></td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr>
								<tr> 			
									<td width=115 height="30"> 
										<div align="center"><font size="2" face="돋움">Mater 지갑주소</font></div>
									</td>
									<td width=479 height="30" colspan="3" align="left"><font size="2" face="돋움"> 
										&nbsp;
										<input type="text" maxlength=30 name="m_address" value="<?=$master_acount?>"  size=50 class="adminbttn" readonly />
										</font>
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr>
								<tr> 					
									<td width=115 height="30"> 
										<div align="center"><font size="2" face="돋움">Balance</font></div>
									</td>
									<td width=479 height="30" colspan="3" align="left"><font size="2" face="돋움"> 
										&nbsp;
										<input type="text" maxlength=30 name="m_balance" value="<?=$balance?>"  size=50 class="adminbttn" readonly />
										</font>
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr>
								<tr> 	
									<td width=115 height="30"> 
										<div align="center"><font size="2" face="돋움">송금 지갑 주소</font></div>
									</td>
									<td width=479 height="30" colspan="3" align="left"><font size="2" face="돋움"> 
										&nbsp;
										<input type="text" maxlength=100 name="m_receive"  size=50 class="adminbttn">
										</font>
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr>
								<tr> 	
									<td width=115 height="30"> 
										<div align="center"><font size="2" face="돋움">송금 DIOT</font></div>
									</td>
									<td width=479 height="30" colspan="3" align="left"><font size="2" face="돋움"> 
										&nbsp;
										<input type="text" maxlength=100 name="m_amount" size=50 class="adminbttn">
										</font>
									</td>
								</tr>
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
							<input type="button" value="출금하기" class="adminbttn" onClick="javascript:go_send()" style="cursor:pointer">
							<input type="button" value="뒤로가기" class="adminbttn" onClick="href:history.back();" style="cursor:pointer">
						</td>
					</tr>
				</table>


				<script>
				function go_send(){
					if(!document.m_form.m_balance.value){
						alert("Master 지갑잔액이 올바르지 않습니다.");
						return false;
					}
					if(!document.m_form.m_receive.value){
						alert("송금 받을 지갑주소를 입력하세요.");
						return false;
					}
					if(!document.m_form.m_amount.value){
						alert("송금액을 입력하세요.");
						return false;
					}
					document.m_form.submit();
				}
				</script>

<? include "../inc/down_menu.php"; ?>