<?

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
         case ("NO_ACCESS_UPLOAD") :   
         popup_msg("해당파일 형식은 업로드가 허용되지 않는 파일입니다");
         break;         
         
      case ("SAME_FILE_EXIST") :   
         popup_msg("동일한 이름의 파일이 이미 등록되어 있습니다. \\n\\n다른 이름으로 업로드하여 주십시오.");
         break;                           
      
      case ("UPLOAD_COPY_FAILURE") :   
         popup_msg("업로드 과정중 오류가 발생하였습니다. \\n\\n파일이름이 이미 디랙토리에 존재 합니다. \\n\\n파일이름을 바꾸고 다시 시도하세요");
         break;                           

      case ("UPLOAD_DELETE_FAILURE") :   
         popup_msg("업로드 과정중 오류가 발생하였습니다. \\n\\n관리자에게 문의하여 주십시오.");
         break;
    
    
      default :
   }
}

?>
