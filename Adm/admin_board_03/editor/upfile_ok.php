<?
##-------------------------------------------------------------------##
##  프로그램명 : gmEditor v1.0
##-------------------------------------------------------------------##
##  최초 개발 완료일 : 2006-01-05
##  개발사 및 저작권자 : PHP몬스터
##  웹사이트 : http://www.phpmonster.co.kr
##  개 발 자 : 박요한 (misnam@gmail.com)
##-------------------------------------------------------------------##
##                           카피라이트
##-------------------------------------------------------------------##
##  본 프로그램은 무료 프로그램으로 배포됩니다.
##  gmEditor는 GNU General Public License(GPL) 를 따릅니다.
##  보다 자세한 내용은 LICENSE를 참조하십시요.
##  참고: http://korea.gnu.org/people/chsong/copyleft/gpl.ko.html
##-------------------------------------------------------------------##
##                           개발환경
##-------------------------------------------------------------------##
##  지원 OS : IE 5 이상
##  개발환경 : Win XP
##  IE 외의 환경에서는 올바로 작동하지 않을 수 있습니다.
##-------------------------------------------------------------------##


// 이미지가 저장되는 경로
$dir = "../data";

// 미디어파일 체크확장자
$old = array(
	"mid",
	"rmi",
	"midi",
	"asx",
	"wax",
	"wax",
	"m3u",
	"mvx",
	"mov",
	"qt",
	"asf",
	"wm",
	"wma",
	"wmv",
	"mpeg",
	"mpg",
	"m1v",
	"mp2",
	"mp3",
	"avi",
	"wmv",
	"wav",
	"snd",
	"au",
	"aif",
	"aifc",
	"aiff",
	"rm",
	"ra",
	"ram",
	"swf"
);


/*
*************************   메세지를 보내고 뒤로 이동   *************************
*/
function goBack($message){
	echo"
		<script language='javascript'>
		window.alert('".$message."');
		history.go(-1);
		</script>
	";
	exit;
} // end func


/*
*************************   같은 호스트에서 넘어왔는지 체크   *************************
*/
function referer(){

	$referer = explode('/',preg_replace("/http:\/\//",'',$_SERVER[HTTP_REFERER]));

	if ($referer[0] <> $_SERVER[HTTP_HOST]) {

		echo"
			<script language='javascript'>
				window.alert('Not a possibility of searching the Root');
				history.go(-1);
			</script>
		";
		exit;
	}

} // end func


referer();



if($_SERVER['REQUEST_METHOD'] <> 'POST') {

	goBack('정상적인 방법으로 접근하십시요.');
}



// 업로드 디렉토리가 있는지 체크 
if (!@is_dir($dir)) {
	goBack('업로드 폴더가 존재하지 않습니다.');
}

// 업로드 폴더의 퍼미션 707인지 체크
if(substr(decoct(fileperms($dir)),2) <> 777){
	goBack("업로드 폴더의 퍼미션 777로 변경해 주세요.");
}



/***************************************************************************************
*************************   파일 전송
****************************************************************************************/

if(is_uploaded_file($_FILES['upfile']['tmp_name']) && ($_FILES['upfile']['size'] > 0)) {

	$upfile = time();

	// 이미지이면..
	if($_POST['type']==1){
		$tmp_file = @getimagesize($_FILES['upfile']['tmp_name'],&$type);
		$upfile .= '.img.gm';

		// (1) = gif, (2) = jpg, (3) = png, (4) = swf, (5) = psd, (6) = bmp
		if(($tmp_file[2] != 1) && ($tmp_file[2] != 2) && ($tmp_file[2] != 6)) {
			goBack('GIF,JPG,BMP 확장자가 업로드 가능합니다.');
		}
	}
	// 미디어이면..
	else{
		$ext = substr($_FILES['upfile']['name'],strrpos(stripslashes($_FILES['upfile']['name']),'.')+1);
		$media_chk = '';
		foreach($old as $key => $value){
			if($value == $ext){
				$media_chk = 1;
				break;
			}
		}
		$upfile .= '.midi.'.$ext;

		if($media_chk <> 1) goBack('미디어파일만 업로드해 주세요.');
	} // end if


	if(!@move_uploaded_file($_FILES['upfile']['tmp_name'],$dir.'/'.$upfile)) {
		@unlink($dir.'/'.$upfile);
		goBack('파일을 복사하는데 실패하였습니다.');
	}
	@chmod($dir.'/'.$upfile,0606);
} // end if




/***************************************************************************************
*************************   내용을 에디터에 삽입
****************************************************************************************/
if(is_file($dir.'/'.$upfile)){

	$imgsize = (int)$_POST['imgsize'];
	$title = addslashes($_POST['title']);
	$alignment = $_POST['alignment'];
	$upfile_ok = $dir.'/'.addslashes($upfile);
	$file_path = $_POST['url'].'/'.$upfile_ok;

	ECHO "<script language='javascript'>\n";
	ECHO "<!--\n";
	ECHO "	var val,os;\n";
	ECHO "	var ostmp = navigator.appName.charAt(0);\n";
	ECHO "	if(ostmp=='M') os = '';\n";
	ECHO "	else if(ostmp=='N') os = 1;\n";
	ECHO "	else os = 2;\n";

	if($_POST['type']==1){
		ECHO "	val = '";

		// 이미지 정렬 2-1
		if(!empty($alignment) && ($alignment=='center')) ECHO "<div align=\"".$alignment."\">";

		ECHO "<img src=\"".$file_path."\" ";

		// 이미지 크기
		if(!empty($imgsize)) ECHO " width=\"".$imgsize."\"";

		ECHO ">";

		// 이미지 정렬2-2
		if(!empty($alignment) && ($alignment=='center')) ECHO "</div>";

		ECHO "';\n";
	}
	else{
		$size = $imgsize ? $imgsize : '300';
		ECHO "	val = '";

		// 미디어 정렬 2-1
		if(!empty($alignment)) ECHO "<div align=\"".$alignment."\">";

		ECHO "<embed src=\"".$file_path."\" ";
		ECHO " width=\"".$size."\" height=\"".$size."\"";
		ECHO " autostart=\"true\" loop=\"true\">";

		// 미디어 정렬 2-2
		if(!empty($alignment)) ECHO "</div>";

		ECHO "';\n";
	}

	ECHO "if(os < 2) window.opener.HTMLPaste(val);\n";
	ECHO "self.close();\n";
	ECHO "//-->\n";
	ECHO "</script>\n";
}
else{

	ECHO "<script language='javascript'>\n";
	ECHO "<!--\n";
	ECHO "	window.close();\n";
	ECHO "//-->\n";
	ECHO "</script>\n";
}
?>
