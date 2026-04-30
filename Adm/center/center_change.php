<script language="javascript">
function saveid()
{
	var frm = document.idchange;
	
	if (frm.name.value == "")
	{
		alert('ID를 넣으세요');
		frm.id.focus();
	}
	else
	{
		frm.submit();
	}
}

function delete_center(idsx)
{
	location.href = "delete_center.php?idxs="+idsx;	
}
</script>
		
<br>
<?
$date = date("Y-m-d");
	$idx = $_GET['idx'];	
	$sql_id = "select * from center where idx = '$idx'";
	$DB->get($sql_id,$rs,$rn);

?>
<form action="center_change_ok.php" method="post" name="idchange">
<input type="hidden" name="idx" value="<?=$idx?>">

<table id="ecom-products" class="table table-bordered table-striped table-vcenter">
  <tr>
    <td width="600">
<table id="ecom-products" class="table table-bordered table-striped table-vcenter">
  <tr>
    <td colspan="2" class="style2" align="center">센터 등록</td>
    </tr>
  <tr>
    <td width="146" class="admiddle" >등록일</td>
    <td width="317" class="style6">&nbsp;&nbsp;<input name="date" type="text" id="date" onKeyPress="document.write(event.keyCode);event.keyCode=null;" size="12" value="<?=$date?>">
    <img src="images/date.jpg" alt="날짜 선택" onClick="openCalendar(document.all('date'));" height="20" align="absmiddle"></td>
    </tr>
  <tr>
  <tr>
    <td class="admiddle">센터이름</td>
    <td class="style6">&nbsp;&nbsp;<input type="text" name="id" size="20" maxlength="20" value="<?=$rs[0][c_name]?>"></td>
    </tr>
  
  <tr>
    <td class="admiddle">담당자</td>
    <td class="style6">&nbsp;&nbsp;<input type="text" name="charge" size="20" maxlength="20" value="<?=$rs[0][c_charge]?>"></td>
  </tr>
  <tr>
    <td class="admiddle">연락처</td>
    <td class="style6">&nbsp;&nbsp;<input type="text" name="tel" size="20" maxlength="20" value="<?=$rs[0][c_tell]?>"></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><br><input type="button" name="pradd" value="등록" style="height:25px; width:100px; color:#FFFFFF; background-color:#6699CC;cursor:pointer" onclick="saveid()"> &nbsp; <input type="button" name="pradd" value="삭제" style="height:25px; width:100px; color:#FFFFFF; background-color:#6699CC;cursor:pointer" onclick="delete_center(<?=$idx?>)"></td>
    </tr>
</table>

    </td>
  </tr>
</table>
</form>
