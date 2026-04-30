<?

function exten_appr($ext)
{
   if( !strcasecmp($ext,"gif") || !strcasecmp($ext,"jpg") || !strcasecmp($ext,"jpeg") || !strcasecmp($ext,"html") ||
       !strcasecmp($ext,"htm") || !strcasecmp($ext,"txt") || !strcasecmp($ext,"js") || !strcasecmp($ext,"mid") || 
       !strcasecmp($ext,"swf") || !strcasecmp($ext,"hwp") || !strcasecmp($ext,"doc") || !strcasecmp($ext,"ppt") || 
		 !strcasecmp($ext,"rar") || !strcasecmp($ext,"arj") || !strcasecmp($ext,"pdf") || !strcasecmp($ext,"cla") ||
		 !strcasecmp($ext,"zip")){}
   else {
		echo "<script>alert(\"허용되지않는 이름의 확장자를 사용하였읍니다.\");</script>\n";
  		echo "<script>history.back();</script>\n";
  		exit;
   }
}

function print_title_image($code) {
   $img_title = $code;
   echo("<center><img src=\"$img_title\" border=0></center><p>");
}

function print_htmltag_yesno($allow_html) {
   if($allow_html) {
      echo("<font size=2>(태그사용 <font color=red>가능</font>)</font>");
   } else {
      echo("<font size=2>(태그사용 <font color=red>불가</font>)</font>");
   }
}   

function popup_msg($msg) {
   echo("<script language=\"javascript\"> 
   <!--
   alert('$msg');
   history.back();
   //-->   
   </script>");
}

function error($errcode) {
   switch ($errcode) {
      case ("INVALID_NAME") :
         popup_msg("입력하신 이름은 허용되지 않는 문자열입니다.\\n\\n올바른 이름을 입력하여 주십시오.");
         break;
         
      case ("INVALID_SUBJECT") :
         popup_msg("입력하신 제목은 허용되지 않는 문자열입니다. \\n\\n올바른 제목을 입력하여 주십시오.");
         break;
      
      case ("INVALID_EMAIL") :
         popup_msg("입력하신 주소는 올바른 전자우편주소가 아닙니다. \\n\\n다시 입력하여 주십시오.");
         break;        
         
      case ("INVALID_HOMEPAGE") :
         popup_msg("입력하신 주소는 올바른 홈페이지주소가 아닙니다. \\n\\n다시 입력하여 주십시오.");
         break;                 
         
      case ("INVALID_PASSWD") :
         popup_msg("암호는 최소 6자이상의 영문자 또는 숫자여야 합니다. \\n\\n다시 입력하여 주십시오.");
         break;
      case ("INVALID_ID") :
         popup_msg("아이디는 최소 6자이상의 영문자 또는 숫자여야 합니다. \\n\\n다시 입력하여 주십시오.");
         break;
         
      case ("INVALID_FILE") :
         popup_msg("등록할 파일을 선택하지 않으셨습니다. \\n\\n다시 입력하여 주십시오.");
         break;
                  
      case ("INVALID_COMMENT") :
         popup_msg("본문을 입력하지 않으셨습니다. \\n\\n다시 입력하여 주십시오.");   
         break;
      
      case ("QUERY_ERROR") :      
         $err_no = mysql_errno();
         $err_msg = mysql_error();         
         $error_msg = "ERROR CODE " . $err_no . " : $err_msg";                           
         $error_msg = addslashes($error_msg);         
         popup_msg($error_msg);  
         break;

      case ("DB_ERROR") :      
         $err_no = mysql_errno();
         $err_msg = mysql_error();         
         $error_msg = "ERROR CODE " . $err_no . " : $err_msg";                           
         echo("$error_msg");
         break;
         
      case ("NO_ACCESS_UPLOAD") :   
         popup_msg("해당파일은 업로드가 허용되지 않는 파일입니다");
         break;         
         
      case ("SAME_FILE_EXIST") :   
         popup_msg("동일한 이름의 파일이 이미 등록되어 있습니다. \\n\\n다른 이름으로 업로드하여 주십시오.");
         break;                           
      
      case ("UPLOAD_COPY_FAILURE") :   
         popup_msg("업로드 과정중 오류가 발생하였습니다. \\n\\n파일이 저장될 디렉토리가 없거나 디렉토리의 퍼미션 제한으로 인한 오류일 가능성이 있습니다.");
         break;                           

      case ("UPLOAD_DELETE_FAILURE") :   
         popup_msg("업로드 과정중 오류가 발생하였습니다. \\n\\n관리자에게 문의하여 주십시오.");
         break;
         
      case ("FILE_DELETE_FAILURE") :   
         popup_msg("파일이 삭제되지 않았습니다. \\n\\n관리자에게 문의하여 주십시오.");
         break;         
                        
      case ("NO_ACCESS_MODIFY") :   
         popup_msg("입력하신 암호와 일치하지 않으므로 수정할 수 없습니다. \\n\\n다시 입력하여 주십시오.");
         break;

      case ("NO_ACCESS_DELETE") :   
         popup_msg("입력하신 암호와 일치하지 않으므로 삭제할 수 없습니다. \\n\\n다시 입력하여 주십시오.");
         break;

      case ("NO_DELETE") :  
   	echo("<script language=\"javascript\"> 
   	<!--
   	 alert(\"삭제할 권한이 없습니다. \\n\\n다시 입력하여 주십시오.\");
   	//-->   
   	</script>");
         break;

      case ("FILE_SIZE_OVERFLOW") :   
         popup_msg("할당된 용량이 초과하였읍니다. \\n\\n다른 파일을 삭제후 추가하십시오. ");
         break;
      
      case ("FILE_ONLY_COPY") :   
         popup_msg("디렉토리 복사는 허용이 안됩니다. \\n\\n파일을 선택후 복사하십시오. ");
         break;

      default :
   }
}

?>
