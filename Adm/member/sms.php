<? 
include "../common/user_function.php";
include "../common/dbconn.php";
include_once "../inc/admin_shell_lib.php";
?>
<?php pkshop_admin_auto_shell_begin(); ?>
 <script language=javascript>
<!--
function HLength() {
  var cnt;
  var len;
  var han;
  len = 0;
  han = 0;

  var varName = document.fmsms.stran_msg.value;
  var varLen = varName.length;

  for( cnt = 0 ; cnt < varLen; cnt++ ) {
    if( varName.charCodeAt(cnt) > 255 ) {
      len += 2;
      han += 2;
    } else {
      len ++;
    }
  }
  if( len > 80 ) {
    alert("메시지는 한번에 80byte(현재:"+len+"byte)까지만 전송이 가능합니다.");		
    return false;
  }
  return true;
}

//-->
</script>
				<table class="pg-table pg-table-form" width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
					<tr><td height=30></td></tr>
						<tr><td height=3></td></tr>
					<tr>
						<td> 
							<?
							$stran_phone1= str_replace("=", ";", $stran_phone1);
							?>
							<table width="700" border='0' cellspacing='0' cellpadding='0'>
						<tr>

						<td valign="top" colspan=2>
							<table width="700" border='0' cellspacing='0' cellpadding='0'>
							<form name="fmsms" method="post" action="smsdo.php" onSubmit="javascript:return HLength()">
								<tr><td colspan=2 height=2 bgcolor='#88B7DA'></td></tr>
								<tr><td colspan=2 height=5></td></tr>
								<tr> 
									<td height="30" width="110" align="center">전체문자</td>
									<td height="30" align="left" width="280">
										&nbsp; <input type="radio" name="dis_kk" value="3" <?if($dis_kk==""||$dis_kk=="3"){?>checked<?}?>>실버&nbsp;
										<input type="radio" name="dis_kk" value="1"<?if($dis_kk=="1"){?>checked<?}?>>골드&nbsp;
										<input type="radio" name="dis_kk" value="2"<?if($dis_kk=="2"){?>checked<?}?>>vip&nbsp;
									</td>
								</tr>
								<tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>	
								<!-- <tr> 
									<td height="30" width="110" align="center">받는사람<br>전화번호</td>
									<td height="30" align="left" width="280">
										&nbsp; 
										<input type="text" name="stran_phone" size="40"  value="<?=$stran_phone1?>" class="adminbttn"><br>(다수발송시 ";"로 구분)
									</td>
								</tr>
								<tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>	 -->		

								<tr> 
									<td height="30"  align="center">개인문자</td>
									<td height="30" align="left" >
										&nbsp; 
										<input type="text" name="stran_phone_kk" size="20" maxlength="20" class="adminbttn">(전화번호입력시 개인에게만 발송됩니다.)
									</td>
								</tr>
								<tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>
							
								<tr> 
									<td height="30"  align="center">보내는사람<br>전화번호</td>
									<td height="30" align="left" >
										&nbsp; 
										<input type="text" name="stran_callback" size="40" maxlength="40" class="adminbttn" value="042-625-1141">
									</td>
								</tr>
								<tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>
								
								<tr> 
									<td height="30"  align="center">전송메시지</td>
									<td height="30" align="left">
										&nbsp; 
										<textarea name="stran_msg" cols="50"  rows="10"></textarea>
									</td>
								</tr>
								<tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>

								 <input type="hidden" name="guest_no" value=""><!--고객번호-->
								 <input type="hidden" name="guest_key" value=""><!--고객키-->
								 <input type="hidden" name="return_value" value="<? print $ret; ?>" readonly>
								
								<tr> 
									<td colspan="2" height="40" align="center"> 
										<input type="submit" value="발송" class="adminbttn">
									</td>
								</tr>
								</form>  
							</table>
							</td>
						</tr>
						</td>
					</tr>
				</table> 
				<br>
<?php pkshop_admin_shell_end(); ?>				
