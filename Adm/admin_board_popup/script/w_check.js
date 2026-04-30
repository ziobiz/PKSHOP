
var Cal_Key_num;
Cal_Key_num = 0;
function check_blank(fm,name,length)
	{
		if(fm.value.substr(0,1)==" ")
			{
				alert(name + " 입력하지 않으셨거나 첫 글자에 공백이 있습니다.\n\n" + name + " 정확히 입력하여 주십시오.");
				fm.focus();
				fm.select();
				return "wrong";
			}
		if(fm.value.length < length)
			{
				alert(name + " " +length +"자 이상 입력하여 주십시오.");
				fm.focus();
				return "wrong";
			}

	}
function check_select(fm,name){
	if(fm.value=="" || fm.value==0){
		alert(name + " 선택하지 않았습니다.\n\n" +  name + " 을 선택하여 주십시오.");
		return "wrong";
	}
}

function check(fm)
	{
		if(check_select(fm.Sub_No,'등록될 게시판을')=='wrong'){return false}
		if(check_blank(fm.Name,'작성자를',1)=='wrong'){return false}
		if(check_blank(fm.P_Name,'팝업명을',1)=='wrong'){return false}
		if(check_blank(fm.Pass,'패스워드를',4)=='wrong'){return false}
		document.form1.keynum.value = Cal_Key_num;
		oEditors.getById["Cont"].exec("UPDATE_CONTENTS_FIELD", []);
		document.form1.submit();
	}

function check_h(fm)
	{
		if(check_select(fm.Sub_No,'등록될 게시판을')=='wrong'){return false}
		if(check_blank(fm.Name,'작성자를',1)=='wrong'){return false}
		//if(check_blank(fm.Pass,'패스워드를',4)=='wrong'){return false}
		if(check_blank(fm.Title,'작가,갤러리명을',2)=='wrong'){return false}
		if(fm.Homepage.value=="http://" || fm.Homepage.value==""){
			alert("홈페이지를 입력하세요")
			return "wrong";
		}
		//document.form1.keynum.value = Cal_Key_num;
		document.form1.submit();
	}