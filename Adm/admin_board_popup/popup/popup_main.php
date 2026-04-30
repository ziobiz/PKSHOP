<?
include '../db_config/dbcon.php';

$Popurl="../data/";  //이미지 경로 설정

$DBtable="admin_board_popup";      
$query="select No,Name,P_Name,P_Location,P_Size,P_Link,P_Target,Cont,P_Fname from $DBtable where Sub_No='1' and P_Up='1' order by Wdate";  
$result= mysql_query($query,$DB);
$total_record = $rn;
	for($i = 0; $i < $total_record; $i++){ 
		$N_No =$rs[$i][0];
		$N_Name =$rs[$i][1];
		$N_P_Name =$rs[$i][2];
		$N_P_Location =$rs[$i][3];
		$N_P_Size =$rs[$i][4];
		$N_P_Link =$rs[$i][5];
		$N_P_Target =$rs[$i][6];
		$N_Cont =$rs[$i][7];
		$N_P_Fname =$rs[$i][8];

		$Cni_pop="name".$N_No;

		if($N_P_Fname!=""){
			$file = $Popurl.$N_P_Fname; 
			$size = GetImageSize($file); 
			
			$Wi=$size[0];
			$Hi=$size[1]+20;
		}else{
			$size=split("-",$N_P_Size);
			$Wi=$size[0];
			$Hi=$size[1];
		}

		$N_P_Location=split("-",$N_P_Location);
		$Li=$N_P_Location[0];
		$Ti=$N_P_Location[1];		
?>  
<script language='javascript'>
<!--
url="../popup/popup_sub.htm?No=<?=$N_No?>";	//팝업창 파일이름 및 경로
wi="<?=$Wi?>"		//팝업창 가로 사이즈
hi="<?=$Hi?>"		//팝업창 세로 사이즈
li="<?=$Li?>"		//팝업창 가로 위치(가로 또는 세로 위치 값이 없을시 기본 위치에 팝업창이 뜸)
ti="<?=$Ti?>"		//팝업창 세로 위치(가로 또는 세로 위치 값이 없을시 기본 위치에 팝업창이 뜸)

//↓쿠기 저장 여부 확인
function getCookie(name) {
    var Found = false
    var start, end
    var i = 0
    while(i <= document.cookie.length){
         start = i
         end = start + name.length
         if(document.cookie.substring(start, end) == name){
             Found = true
             break
         }
         i++
    }
    if(Found == true){
        start = end + 1
        end = document.cookie.indexOf(";", start)
        if(end < start)
            end = document.cookie.length
        return document.cookie.substring(start, end)
    }
    return ""
}

//↓팝업함수(쿠키 저장여부 확인후)
if (getCookie("<?=$Cni_pop?>")!= "none"){
	if(li.length>0 && ti.length>0){
		liti=',left='+li+',top='+ti;
	}else{
		liti=''
	}
	Smaru=window.open(url,'<?=$Cni_pop?>','scrollbars=yes,width='+wi+',height='+hi+''+liti);
}
//-->
</script>
<?}?>