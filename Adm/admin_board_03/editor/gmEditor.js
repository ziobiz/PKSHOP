//-------------------------------------------------------------------//
//  프로그램명 : gmEditor v1.1
//-------------------------------------------------------------------//
//  최초 개발 완료일 : 2006-01-05
//  개발사 및 저작권자 : PHP몬스터
//  웹사이트 : http://www.phpmonster.co.kr
//  개 발 자 : 박요한 (misnam@gmail.com)
//-------------------------------------------------------------------//
//                           카피라이트
//-------------------------------------------------------------------//
//  본 프로그램은 무료 프로그램으로 배포됩니다.
//  gmEditor는 GNU General Public License(GPL) 를 따릅니다.
//  보다 자세한 내용은 LICENSE를 참조하십시요.
//  참고: http://korea.gnu.org/people/chsong/copyleft/gpl.ko.htmll
//-------------------------------------------------------------------//
//                           개발환경
//-------------------------------------------------------------------//
//  Browser: 익스플로러, 파이어폭스, 네스케이프
//  Server : PHP가 지원되는 모든 서버
//-------------------------------------------------------------------//


var str,os,gmFrame;
var ostmp = navigator.appName.charAt(0);

// 브라우저 확인
if(ostmp=='M') os = ''; else if(ostmp=='N') os = 1; else os = 2;

// 프레임 타입
gmFrame = !os ? frames.gmEditor : document.getElementById("gmEditor").contentWindow;

// IE ? Nets
str = !os ? "<STYLE>\np{margin-top:1px;margin-bottom:1px;}\n</STYLE>\n" : '';



// 빈문서 불러오기
function newDoc(){
	gmFrame.document.open("text/html");
	gmFrame.document.write(str);
	gmFrame.document.write("&nbsp;");
	gmFrame.document.close();
	gmFrame.focus();
}

// HTML편집
function editor_html(){
	obj = window.open(_editor_url+'/html_edit.html','_editor_Html','width=650,height=530,scrollbars=no');
}

// 미리보기
function editor_view(){
	obj = window.open(_editor_url+'/preview.html','_editor_view','width=650,height=550,scrollbars=yes');
}

// 이미지,미디어 첨부
function file_upload(id){
	var _tps = '';

	// 미디어 업로드
	if(id > 0){
		// 업로드를 허용 (1은 업로드불가)
		if(_m_uploaded==1) return false;
		_height = 170;
	}
	// 이미지 업로드
	else{
		// 업로드를 허용 (1은 업로드불가)
		if(_i_uploaded==1) return false;
		_tps = '?op=1';
		_height = 350;
	}
	return window.open(_editor_url+'/upfile.html'+_tps,'_editor_tb','staus=no, width=300, height='+_height+',scrollbars=no,toolbar=no,menubar=no');
} // end func

// 모달상자
function createHTML(opt,key){
	var width,height,filename,val;

	switch(key){
		case 1: // 테이블 삽입
			width=!os?358:352; height=!os?260:218; filename = 'table.html';
		break;

		case 2: // 특수문자 삽입
			width=!os?308:304; height=!os?360:330; filename = 'characteristic.html';
		break;

		case 3: // 아이콘 삽입
			width=!os?238:232; height=!os?280:248; filename = 'emotions.html';
		break;

		case 4: // 글꼴 삽입
			width = 250; height=!os?335:300; filename = 'fontname.html';
		break;

		case 5: // 글자색 삽입
			width = 260; height=!os?309:280; filename = 'color.html';
		break;

		case 6: // 글자 배경색 삽입
			var op = (os==1) ? '?op=1' : '';
			width = 260; height=!os?309:280; filename = 'color.html'+op;
		break;

		case 7: // 글자 크기 삽입
			width = 350; height=!os?280:245; filename = 'fontsize.html';
		break;

		case 8: // 하이퍼 링크
			width=!os?400:360; height=!os?180:135; filename = 'hyperLink.html';
		break;
	}

	if(!os)	val = showModalDialog(_editor_url+'/'+filename,null,'dialogWidth:' + width + 'px;dialogHeight:' + height + 'px;dialogLeft:center;diallogTop:center;help:no;status:no;');
	else obj = window.open(_editor_url+'/'+filename,'_editor_tb','staus=no, width='+width+', height='+height+',scrollbars=no,toolbar=no,menubar=no');

	if(val){
		gmFrame.focus();
		if((key==4)||(key==5)||(key==6)||(key==7)) window.htmltrue(opt,val,true);
		// 하이퍼링크 삽입
		else if(key==8) {
			window.htmltrue(opt,val,false);
		}
		// 이모티콘 삽입
		else if(key==3) {
			val = _editor_url + '/img/emotions/' + val;
			window.htmltrue(opt,val,false);
		}
		else window.HTMLPaste(val);
	}
	return false;
}


// 이전 내용이 있으면 가져옴
function Edit_Modify(_contentName,_contentValue){
	return eval("document." + _contentName + "." + _contentValue + ".value");
}

// 폼 전송시 입력받을 값
function SubmitHTML(){
	return !os ? gmFrame.document.body.innerHTML : gmFrame.document.documentElement.innerHTML;
}

// 각종 HTML 삽입
function HTMLPaste(key){
	gmFrame.focus();

	// IE
	if(!os){
		past = gmFrame.document.selection.createRange();
		past.pasteHTML(key);
	}

	// Nets
	else if(os==1) gmFrame.document.execCommand("inserthtml",false,key);
	else return;

} // end if

function htmlfalse(key){
	gmFrame.focus();
	gmFrame.document.execCommand(key,false,null);
	return false;
}

function htmltrue(key,val,mode){
	gmFrame.focus();
	gmFrame.document.execCommand(key,mode,val);
	return false;
}

gmFrame.focus();
gmFrame.document.open("text/html");
gmFrame.document.writeln(str);
gmFrame.document.writeln(Edit_Modify(_contentName,_contentValue));
gmFrame.document.close();

gmFrame.document.designMode = "On";
