<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<title>편집기</title>
<style type="text/css">
.toolbar {padding:3;overflow:hidden;background:lightgrey;border:solid 1 #555555}
</style>
<script language="javascript" src="Dhtmled.php"></script>
<script language="javascript">
<!--
var ieVer = navigator.appVersion.match(/MSIE \d+.\d+/)[0].split(" ")[1];
var bLoad = false;
var gSel = null;
var bHeader = "<style>Table {font-size:8pt; font-family:tahoma; color:555555;}\nP {margin-top:2px;margin-bottom:2px;}</style>\n";
var cPicker = null;
var sEditMode = "html"
var public_description = new Editor();
function Editor() {
	this.put_html = put_html;
	this.get_html = get_html;
	this.get_text = get_text;

	this.setColor = setColor;
	this.setBgColor = setBgColor;
	this.setFocus = setFocus;
	this.MakeImage = MakeImage;

	this.put_editmode = put_editmode;
	this.get_editmode = get_editmode;
}

function init() {
	idBox.style.visibility = '';
	document.onmousedown = mouseDown;

	if (ieVer < 5.0) {
		idEdit = EditCtrl;
		idEdit.document.designMode = "On";
		initEditor();
		bLoad = true;
	}
}

function initEditor() {
	idEdit.document.open();
	idEdit.document.write(bHeader);
	idEdit.document.close();

	idEdit.document.body.style.fontSize = "8pt";
	idEdit.document.body.style.fontFamily = "tahoma";
	idEdit.document.body.style.color = "555555";

	window.external.raiseEvent("onafterload", window.document);
}

function mouseDown(e) {
	if (event.button == 2) {
		alert("편집기에서는 마우스의 왼쪽 버튼만 사용됩니다.");
		return false;
	}

	if (event.srcElement.id=='toolbar' || event.srcElement.parentElement.id=='formatSelect') {
		if (idEdit.document.selection.type == 'none') {
			gSel = null;
		}
		else {
			gSel = idEdit.document.selection.createRange();
		}
		return false;
	}
	return true;
}

function put_html(str) {
	idEdit.document.body.innerHTML = str;
}

function get_html() {
	var sBgColor;

	removeMisc();

	if (sEditMode == "html") {
		sBgColor = "";
		if (idEdit.document.body.style.backgroundColor != "") {
			sBgColor = idEdit.document.body.style.backgroundColor;
		}
		else if (idEdit.document.body.bgColor != "") {
			sBgColor = idEdit.document.body.bgColor;
		}

		if (sBgColor != "") {
			return bHeader + "<div id=\"content\" bgcolor=\""+sBgColor+"\">\n" + idEdit.document.body.innerHTML + "</div>";
		}
		else {
			return bHeader + idEdit.document.body.innerHTML;
		}
	}
	else {
		return idEdit.document.body.innerText;
	}
}

function get_text() {
	removeMisc();

	return idEdit.document.body.innerText;
}

function setBgColor() {
	if (idEdit.document.all.content != null) {
		idEdit.document.body.bgColor = idEdit.document.all.content.bgcolor;
		idEdit.document.body.innerHTML = idEdit.document.all.content.innerHTML;
	}
}

function setFocus() {
	idEdit.focus();
}

function format(what, opt) {
	if (opt == "removeFormat") {
		what = opt;
		opt = null;
	}

	if (gSel != null) {
		gSel.select();
	}

	if (opt == null) {
		idEdit.document.execCommand(what);
	}
	else {
		idEdit.document.execCommand(what, "", opt);
	}

	idEdit.focus();
}

function getEl(sTag, start) {
	while ((start!=null) && (start.tagName!=sTag)) {
		start = start.parentElement;
	}
	return start;
}

function backColor(sColor) {
	if (idEdit.document.selection.type == "None") {
		format("backcolor", sColor)
   }
   else {
		var sel = idEdit.document.selection.createRange();
		sel.pasteHTML("<font style=\"background-color:" + sColor + "\">" + sel.text + "</font>");
		sel.select();
   }

   idEdit.focus();
}

function createLink() {
	if (gSel != null) {
		gSel.select();
	}

	var isA = getEl("A", idEdit.document.selection.createRange().parentElement());
	var str = prompt("링크를 입력하여 주십시오.", isA ? isA.href : "http:\/\/");
	if ((str != null) && (str != "http://")) {
		var sel = idEdit.document.selection.createRange();
		if ((idEdit.document.selection.type == "None") && (!isA)) {
			sel.pasteHTML("<a href=\"" + str + "\">" + str + "</a> ");
			sel.select();
		}
		else {
			sel.pasteHTML("<a href=\"" + str + "\" target=\"_blank\">" + sel.text + "</a> ");
			sel.select();
		}
	}
	else {
		idEdit.focus();
	}
}

function colorPicker(which) {
	if (cPicker!=null && !cPicker.closed) {
		return;
	}
	whichCol = which;
	cPicker = window.open("colPicker.htm", "ColorPicker", "fullscreen=no,titlebar=no,toolbar=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,width=320,height=290")
}

function setColor(col) {
	switch (whichCol) {
		case 0:
				if (col=='transparent')	{
					format('forecolor', '#c0c0c0');
				}
				else {
					format('forecolor', col);
				}
				break;
		case 1:
				backColor(col);
				break;
		case 2:
				idEdit.document.body.bgColor = col
				removeMisc();
				break;
	}
}

function removeMisc() {
	var bodyTags = idEdit.document.body.all;
	for (i = bodyTags.tags("FONT").length - 1; i >= 0; i--) {
		if (bodyTags.tags("FONT")[i].style.backgroundColor == "#ffffff") {
			bodyTags.tags("FONT")[i].style.backgroundColor = ""
			if (bodyTags.tags("FONT")[i].outerHTML.substring(0, 6) == "<FONT>") {
				bodyTags.tags("FONT")[i].outerHTML = bodyTags.tags("FONT")[i].innerHTML;
			}
		}
	}
}

function get_editmode()
{
	return sEditMode;
}

function put_editmode(sMode)
{
	var tmp;

	if (sEditMode == sMode) {
		return;
	}

	sEditMode = sMode;

	if (sMode == "text") {
		disableEditBar(true);

		if (ieVer >= 5) {
			tmp = "" + idEdit.document.documentElement.outerHTML + "";
		}
		else {
			tmp = "<HTML>\n<HEAD>\n<STYLE>P {margin-top:2px;margin-bottom:2px;}</STYLE>\n</HEAD>\n" + idEdit.document.body.outerHTML + "</HTML>";
		}
		idEdit.document.open();
		idEdit.document.write(bHeader + formatCode(tmp.replace(/&/g, "&amp;")));
		idEdit.document.close();
	}
	else {
		disableEditBar(false);

		tmp = "" + idEdit.document.body.innerText + "";
		idEdit.document.open();
		idEdit.document.write(tmp);
		idEdit.document.close();
	}

	idEdit.document.body.style.fontSize = "9pt";
	idEdit.document.body.style.fontFamily = "돋움";
	idEdit.focus();

	var s = idEdit.document.body.createTextRange();
	s.collapse(false);
	s.select();
}

function formatCode(s)
{
	var str = "";
	var IN_TEXT = 1;
	var IN_ELEMENT = 2;
	var state = IN_TEXT;

	while (s.length > 0) {
		var endTagBreak, emptyTagBreak;

		if (state == IN_ELEMENT){
			var endIndex = s.indexOf(">");
			var endTag = (s.substring(0,1) == "/");

			if (endIndex != -1){
				str += s.substring(0, endIndex) + "&gt;</span>";
				if (endTag && endTagBreak || emptyTagBreak)
					str += "<br>";
					s = s.substring(endIndex+1, s.length);
					state=IN_TEXT;
			}
			else {
				str += s + "</span>";s="";
			}
		}
		else {
			var startIndex = s.indexOf("<");
			var endTags = new Array("P","DIV","H1","H2","H3","H4","H5","H6","BLOCKQUOTE","OL","LI","PRE","UL","TITLE","BODY","META","HEAD");
			var startTags = new Array("BR","HR","META","HTML","BODY","HEAD");

			if (startIndex != -1){
				var tagName;
				var nameStartIndex;
				var gtIndex = s.indexOf(">");
				var spaceIndex = s.indexOf(" ");
				var slashIndex = s.indexOf("/");

				endTagBreak = false;
				emptyTagBreak = false;
				if (slashIndex != -1 && slashIndex == startIndex+1)
					nameStartIndex = slashIndex+1;
				else
					nameStartIndex = startIndex+1;
				if (spaceIndex != -1 && spaceIndex > startIndex && spaceIndex < gtIndex)
					tagName = s.substring(nameStartIndex,spaceIndex);
				else if (gtIndex != -1)
					tagName = s.substring(nameStartIndex,gtIndex);
				else
					tagName = s.substring(nameStartIndex,s.length);

				for (var i = 0;i < endTags.length; i++){
					if (endTags[i] == tagName) {
						endTagBreak = true;
						break;
					}
				}

				for (var i = 0;i < startTags.length; i++) {
					if (startTags[i] == tagName) {
						emptyTagBreak = true;break;
					}
				}

				str += s.substring(0,startIndex) + "<span style='color:darkblue;'>&lt;";
				s = s.substring(startIndex+1,s.length);
				state=IN_ELEMENT;
			}
			else {
				str += s;
				s = "";
			}
		}
	}

	return str;
}

function disableEditBar(b)
{
	if (b == true) {
		idBox.style.display = "none";
		EditCtrl.style.height = 355;
	}
	else {
		idBox.style.display = "block";
		EditCtrl.style.height = 300;
	}
}

function InsertTable()
{
	var str;
	str = window.showModalDialog('./InsertTable.php', 'InsertTable', 'dialogWidth:400px;dialogHeight:200px;center:yes;dialogHide:no;edge:raised;help:no;resizable:no;scroll:no;status:no;unadorned:no');
	if(str) {
		var sel = idEdit.document.selection.createRange();
		sel.pasteHTML(str);
		sel.select();
	}
	idEdit.focus();
}

function MakeTable(objForm)
{
	var TableString='<table';
	
	if(objForm.TableWidth.value!='') TableString+=' width='+objForm.TableWidth.value;
	if(objForm.TableHeight.value!='') TableString+=' height='+objForm.TableHeight.value;
	if(objForm.TableCellpadding.value!='') TableString+=' cellpadding='+objForm.TableCellpadding.value;
	if(objForm.TableCellspacing.value!='') TableString+=' cellspacing='+objForm.TableCellspacing.value;
	if(objForm.TableBorder.value!='') TableString+=' border='+objForm.TableBorder.value;
	if(objForm.TableAlign.value!='') TableString+=' align='+objForm.TableAlign.value;
	if(objForm.TableBorderColor.value!='') TableString+=' bordercolor='+objForm.TableBorderColor.value;
	if(objForm.TableBgcolor.value!='') TableString+=' bgcolor='+objForm.TableBgcolor.value;
	TableString+='>\n';
	for(var rows=0; rows < objForm.TableRows.value; rows++)
	{
		TableString+='\t<tr>\n';
		for(var columns=0; columns < objForm.TableColumns.value; columns++)
		{
			TableString+='\t\t<td></td>\n';
		}
		TableString+='\t</tr>\n';
	}
	TableString+='</table>\n';
	window.returnValue=TableString;
	self.close();
	return true;
}

function InsertImage()
{
	window.open('./InsertImage.php', 'InsertImage', 'width=400, height=400, scrollbars=yes');
}

function MakeImage(str)
{
	var sel = idEdit.document.selection.createRange();
	sel.pasteHTML(str);
	sel.select();
	idEdit.focus();
}

function InsertFile()
{
	window.open('./InsertFile.php', 'InsertFile', 'width=400, height=400, scrollbars=yes');
}

//-->
</script>
<script LANGUAGE="javascript" FOR="EditCtrl" EVENT="ContextMenuAction(itemIndex)">
	if (itemIndex == 0 ){

		format('copy');
	}
	else if (itemIndex == 1) {
		format ('cut');
	}
	else if (itemIndex == 2) {
		format('paste');
	}
	else if(itemIndex == 3) {
		EditCtrl.execCommand(DECMD_FONT);
	}
	
</script>
<script LANGUAGE="javascript" FOR="EditCtrl" EVENT="ShowContextMenu">
  var menuStrings = new Array();
  var menuStates = new Array();

   	menuStrings[0] = "복사";
  	menuStrings[1] = "잘라내기";
  	menuStrings[2] = "붙여넣기";

  	menuStates[0] = OLE_TRISTATE_UNCHECKED;
  	menuStates[1] = OLE_TRISTATE_UNCHECKED;
  	menuStates[2] = OLE_TRISTATE_UNCHECKED;

  	EditCtrl.SetContextMenu(menuStrings, menuStates);
</script>
<script for="EditCtrl" event="DocumentComplete()">
if (ieVer >= 5.0) {
	if (!bLoad) {
		idEdit = EditCtrl.DOM.parentWindow;
		setTimeout("initEditor()", 0);
	}
	bLoad = true;
}
</script>
</head>
<body onLoad="init();" leftmargin="0" topmargin="0">
<div id="idBox" class="toolbar" style="width:489;height:55;visibility:visible">
<table align=center width=100% id=tb1 cellpadding=0 cellspacing=0 border=0>
	<tr>
		<td>
			<!-- 잘라내기 --><a onfocus='this.blur()'  onMouseover="arrmOn('img01')" onMouseout="arrmOff('img01')" onclick="javascript:format('Cut')" onfocus='this.blur()'><img border=0 src="images/cut_off.gif" name='img01' title='잘라내기' align=absmiddle></a><!-- 복사 --><a onfocus='this.blur()'  onMouseover="arrmOn('img02')" onMouseout="arrmOff('img02')" onclick="javascript:format('Copy')" onfocus='this.blur()'><img border=0 src="images/copy_off.gif" name='img02' title='복사하기' align=absmiddle></a><!-- 붙여넣기 --><a onfocus='this.blur()'  onMouseover="arrmOn('img03')" onMouseout="arrmOff('img03')" onclick="javascript:format('Paste')" onfocus='this.blur()'><img border=0 src="images/paste_off.gif" name='img03' title='붙여넣기' align=absmiddle></a><!-- 구분선 --><img border=0 src="images/line.gif" align=absmiddle hspace=5><!-- 굵게 --><a onfocus='this.blur()'  onMouseover="arrmOn('img04')" onMouseout="arrmOff('img04')" onclick="javascript:format('Bold')" onfocus='this.blur()'><img border=0 src="images/bold_off.gif" name='img04' title='굵게' align=absmiddle></a><!-- 기울이기 --><a onfocus='this.blur()'  onMouseover="arrmOn('img05')" onMouseout="arrmOff('img05')" onclick="javascript:format('Italic')" onfocus='this.blur()'><img border=0 src="images/italic_off.gif" name='img05' title='기울이기' align=absmiddle></a><!-- 밑줄 --><a onfocus='this.blur()'  onMouseover="arrmOn('img06')" onMouseout="arrmOff('img06')" onclick="javascript:format('Underline')" onfocus='this.blur()'><img border=0 src="images/underline_off.gif" name='img06' title='밑줄' align=absmiddle></a><!-- 구분선 --><img border=0 src="images/line.gif" align=absmiddle hspace=5><!-- 왼쪽정렬 --><a onfocus='this.blur()'  onMouseover="arrmOn('img07')" onMouseout="arrmOff('img07')" onclick="javascript:format('JustifyLeft')" onfocus='this.blur()'><img border=0 src="images/left_off.gif" name='img07' title='왼쪽정렬' align=absmiddle></a><!-- 가운데 정렬 --><a onfocus='this.blur()'  onMouseover="arrmOn('img08')" onMouseout="arrmOff('img08')" onclick="javascript:format('JustifyCenter')" onfocus='this.blur()'><img border=0 src="images/center_off.gif" name='img08' title='가운데정렬' align=absmiddle></a><!-- 오른쪽정렬 --><a onfocus='this.blur()'  onMouseover="arrmOn('img09')" onMouseout="arrmOff('img09')" onclick="javascript:format('JustifyRight')" onfocus='this.blur()'><img border=0 src="images/right_off.gif" name='img09' title='오른쪽정렬' align=absmiddle></a><!-- 구분선 --><img border=0 src="images/line.gif" align=absmiddle hspace=5><!-- 들여쓰기 --><a onfocus='this.blur()'  onMouseover="arrmOn('img10')" onMouseout="arrmOff('img10')" onclick="javascript:format('Indent')" onfocus='this.blur()'><img border=0 src="images/inp_off.gif" name='img10' title='들여쓰기' align=absmiddle></a><!-- 내여쓰기 --><a onfocus='this.blur()'  onMouseover="arrmOn('img11')" onMouseout="arrmOff('img11')" onclick="javascript:format('Outdent')" onfocus='this.blur()'><img border=0 src="images/outp_off.gif" name='img11' title='내여쓰기' align=absmiddle></a><!-- 번호있는목록 --><a onfocus='this.blur()'  onMouseover="arrmOn('img12')" onMouseout="arrmOff('img12')" onclick="javascript:format('InsertOrderedList')" onfocus='this.blur()'><img border=0 src="images/num_off.gif" name='img12' title='번호있는 목록' align=absmiddle></a><!-- 번호없는 목록 --><a onfocus='this.blur()'  onMouseover="arrmOn('img13')" onMouseout="arrmOff('img13')" onclick="javascript:format('InsertUnorderedList')" onfocus='this.blur()'><img border=0 src="images/li_off.gif" name='img13' title='번호없는 목록' align=absmiddle></a><!-- 구분선 --><img border=0 src="images/line.gif" align=absmiddle hspace=5><!-- 하이퍼링크 --><a onfocus='this.blur()'  onMouseover="arrmOn('img14')" onMouseout="arrmOff('img14')" onclick="javascript:format('CreateLink')" onfocus='this.blur()'><img border=0 src="images/link_off.gif" name='img14' title='하이퍼링크' align=absmiddle></a><!-- 수평선 --><a onfocus='this.blur()'  onMouseover="arrmOn('img15')" onMouseout="arrmOff('img15')" onclick="javascript:format('InsertHorizontalRule')" onfocus='this.blur()'><img border=0 src="images/line_off.gif" name='img15' title='수평선' align=absmiddle></a><!-- 구분선 --><img border=0 src="images/line.gif" align=absmiddle hspace=5><!-- 테이블넣기 --><a onfocus='this.blur()'  onMouseover="arrmOn('img16')" onMouseout="arrmOff('img16')" onclick="javascript:InsertTable();" onfocus='this.blur()'><img border=0 src="images/table_off.gif" name='img16' title='테이블넣기' align=absmiddle></a>
		</td>
	</tr>
	<tr>
		<td>
			<select onchange="format('FontName', this.value); this.selectedIndex=0;" id=select1 name=select1 style='background-color:f7f7f7;color:555555'>
				<option value="">글꼴</option>
				<option value="굴림">굴림</option>
				<option value="궁서">궁서</option>
				<option value="돋움">돋움</option>
				<option value="바탕">바탕</option>
			</select>
			<select onchange="format('FontSize', this.value); this.selectedIndex=0;" id=select2 name=select2 style='background-color:f7f7f7;color:555555'>
				<option value="">크기</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
				<option value="7">7</option>
			</select>
			<!-- 구분선 --><img border=0 src="images/line.gif" align=absmiddle hspace=5><!-- 글자색 --><a onfocus='this.blur()'  onMouseover="arrmOn('img19')" onMouseout="arrmOff('img19')" onclick="javascript:colorPicker(0);" onfocus='this.blur()'><img border=0 src="images/tcolor_off.gif" name='img19' title='글자색' align=absmiddle></a><!-- 글바탕색 --><a onfocus='this.blur()'  onMouseover="arrmOn('img20')" onMouseout="arrmOff('img20')" onclick="javascript:colorPicker(1);" onfocus='this.blur()'><img border=0 src="images/tbcolor_off.gif" name='img20' title='글바탕색' align=absmiddle></a><!-- 구분선 --><img border=0 src="images/line.gif" align=absmiddle hspace=5><!-- 위첨자 --><a onfocus='this.blur()'  onMouseover="arrmOn('img21')" onMouseout="arrmOff('img21')" onclick="javascript:format('Superscript');" onfocus='this.blur()'><img border=0 src="images/sup_off.gif" name='img21' title='위첨자' align=absmiddle></a><!-- 아래첨자 --><a onfocus='this.blur()'  onMouseover="arrmOn('img22')" onMouseout="arrmOff('img22')" onclick="javascript:format('Subscript');" onfocus='this.blur()'><img border=0 src="images/sub_off.gif" name='img22' title='아래첨자' align=absmiddle></a>
		</td>
	</tr>
</table>
</div>
<script language="javascript">
if (ieVer >= 5.0) {
	document.write("<object id=\"EditCtrl\" width=\"490\" height=\"300\" classid=\"clsid:2D360201-FFF5-11D1-8D03-00A0C959BC0A\"><?=$detail?></object>")
}
else {
	document.write("<iframe name=\"EditCtrl\" width=\"490\" height=\"300\"></iframe>")
}
</script>
</body>
</html>
