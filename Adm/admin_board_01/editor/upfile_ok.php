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
include '../htm_config/setting.php';

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

##########파일 전송전 temp화일을 크기 변환 후 업로드###############

function thumbnail($file, $save_filename, $max_width, $max_height, $type)
{		
		global $quality_gm;
		//ini_set('memory_limit',-1);
		switch ($type){
			case "gif":
				$src_img = ImageCreateFromGif($file); //GIF파일로부터 이미지를 읽어옵니다
			break;
			case "jpg":
				$src_img = ImageCreateFromJPEG($file); //JPG파일로부터 이미지를 읽어옵니다
			break;
			case "png":
				$src_img = ImageCreateFromPNG($file); //PNG파일로부터 이미지를 읽어옵니다
			break;
			case "bmp":
				$src_img = ImageCreateFromBMP($file); //BMP파일로부터 이미지를 읽어옵니다
			break;
		}

        $img_info = getImageSize($file);//원본이미지의 정보를 얻어옵니다
        $img_width = $img_info[0];
        $img_height = $img_info[1];
 
        if(($img_width/$max_width) == ($img_height/$max_height))
        {//원본과 썸네일의 가로세로비율이 같은경우
            $dst_width=$max_width;
            $dst_height=$max_height;
        }
        elseif(($img_width/$max_width) < ($img_height/$max_height))
        {//세로에 기준을 둔경우
            $dst_width=$max_height*($img_width/$img_height);
            $dst_height=$max_height;
        }
        else{//가로에 기준을 둔경우
            $dst_width=$max_width;
            $dst_height=$max_width*($img_height/$img_width);
        }//그림사이즈를 비교해 원하는 썸네일 크기이하로 가로세로 크기를 설정합니다.
 
        $dst_img = imagecreatetruecolor($dst_width, $dst_height); //타겟이미지를 생성합니다
 
        imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $dst_width, $dst_height, $img_width, $img_height); //타겟이미지에 원하는 사이즈의 이미지를 저장합니다
 
        ImageInterlace($dst_img);
		switch($type){
			case "gif":
			 ImageGif($dst_img,  $save_filename); //실제로 이미지파일을 생성합니다
			break;
		case "jpg":
			ImageJPEG($dst_img,  $save_filename,$quality_gm); //실제로 이미지파일을 생성합니다
			break;
		case "png":
			ImagePNG($dst_img,  $save_filename); //실제로 이미지파일을 생성합니다
			break;
		case "bmp":
			ImageBMP($dst_img,  $save_filename); //실제로 이미지파일을 생성합니다
			break;
		}
		
		$Files=$save_filename;

        ImageDestroy($dst_img);
        ImageDestroy($src_img);
}

if(is_uploaded_file($_FILES['upfile']['tmp_name']) && ($_FILES['upfile']['size'] > 0)) {
	$srcFile=$_FILES['upfile']['tmp_name']; //서버 임시폴더에 저장된 이미지화일을 원본으로 사용
	$targetFile=$srcFile; //서버임시폴더에 저장된 이미지를 사이즈를 줄인 이미지로 그냥 덮어씀

	$img_info = getImageSize($srcFile);//원본이미지의 정보를 얻어옵니다
	$img_width = $img_info[0];
	$img_height = $img_info[1];
	switch ($img_info[2]){
		case 1:
			$img_type="gif";
			break;
		case 2:
			$img_type="jpg";
			break;
		case 3:
			$img_type="png";
			break;
		case 6:
			$img_type="bmp";
			break;
		default :
			goBack('GIF,JPG,PNG,BMP 확장자가 업로드 가능합니다.');
		break;
	}
	//1 = gif, 2 = jpg, 3 = png, 4 = swf, 5 = psd, 6 = bmp

	$imgsize = (int)$_POST['imgsize']; //새로 입력한 이미지 가로 사이즈
	$imgsize=$imgsize ? $imgsize : $U_width_gm; //새로 입력한 사이즈가 없으면 setting.php에 정한 크기로
	
	if($imgsize<$img_width) {//입력한 사이즈가 원본보다 작으면
		
		$imgsize_h=($img_height*$imgsize)/$img_width; //높이크기 계산

		$dst_width=$max_width;
		$dst_height=$max_height;
		thumbnail($srcFile,$targetFile,$imgsize,$imgsize_h,$img_type); 
	}else{
		//입력한 사이즈가 원본보다 크면 사이즈조절 작업 없음
	}
}

#################################################

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
	if($url_editor==""){//ie9 이상을 위한 수정
		$upfile_ok = $dir.'/'.addslashes($upfile);
		$file_path = $_POST['url'].'/'.$upfile_ok;
	}else{
		$upfile_ok = addslashes($upfile);
		$file_path = $url_editor.'/'.$upfile_ok;
	}
	
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
