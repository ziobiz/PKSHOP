<?

// $mode <- 에디터 모드 (1)텍스트모드, (2)에디터모드
// $editor_Url <- 에디터 경로 ../editor
// $formName <- 폼 이름 <form name="폼이름">
// $contentForm <- 폼 이름2 <textarea name="폼이름2"></textarea>
// $content <- 폼 내용 <textarea>폼 내용</textarea>
// $textWidth <- 폼 width값 (숫자만 입력)
// $textHeight <- 폼 height값 (숫자만 입력)
// $upload_image <- 이미지 업로드 사용 (1은 사용안함)
// $upload_media <- 미디어 업로드 사용 (1은 사용안함)

function myEditor($mode_editor,$editor_Url,$formName,$contentForm,$textWidth,$textHeight){
	global $Cont,$upload_image,$upload_media;

	$mode_editor = $mode_editor;
	$editor_Url = $editor_Url;
	$formName = $formName;
	$contentForm = $contentForm;
	$textWidth = $textWidth;
	$textHeight = $textHeight;


	if($mode_editor==1){
		include $editor_Url.'/editor.html';
	}
	else{
		ECHO "<textarea style='width:".$textWidth.";height:".$textHeight."' name='".$contentForm."' wrap='physical' style='ime-mode: active' class='input'>".$Cont."</textarea>";
	}
}

?>


