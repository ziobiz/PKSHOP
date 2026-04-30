
function MM_findObj(n, d) { //v4.0
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && document.getElementById) x=document.getElementById(n); return x;
}

function MM_showHideLayers() { //v3.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v='hide')?'hidden':v; }
    obj.visibility=v; }
}
var x =0 
var y=0 
drag = 0 
move = 0 
window.document.onmousemove = mouseMove 
window.document.onmousedown = mouseDown 
window.document.onmouseup = mouseUp 
window.document.ondragstart = mouseStop 
function mouseUp() { 
	move = 0 
} 
function mouseDown() { 
	if (drag) { 
		clickleft = window.event.x - parseInt(dragObj.style.left) 
		clicktop = window.event.y - parseInt(dragObj.style.top) 
		dragObj.style.zIndex += 1 
		move = 1 
	} 
} 
function mouseMove() { 
	if (move) { 
		dragObj.style.left = window.event.x - clickleft 
		dragObj.style.top = window.event.y - clicktop 
	} 
} 
function mouseStop() { 
	window.event.returnValue = false 
}

function swapReadOnly() {		
var obj = document.all('test');		
if (obj.readOnly) {			
obj.readOnly = false;		
} 
else {			
obj.readOnly = true;		
}	
}
//--------------------------------------------------------------------
		function Edit_Ok()
			{
				frm   = document.Edit
				
			if(frm.PassWord.value == "")
				{
					alert("해당글 비밀번호를 입력해 주세요.");
					frm.PassWord.focus();
					return;
				}   
				frm.action = "pass_check.php"
				frm.submit()
			}
			function Del_Ok()
			{
				frm   = document.Delete
				
			if(frm.PassWord.value == "")
				{
					alert("해당글 비밀번호를 입력해 주세요.");
					frm.PassWord.focus();
					return;
				}   
				frm.action = "pass_check.php"
				frm.submit()
			}
			
			
			function Key_Press_Del()
				{
					if(window.event.keyCode ==13)
					Del_Ok();
				}
			function Key_Press_Edit()
				{
					if(window.event.keyCode ==13)
					Edit_Ok();
				}
			
				
				function admin_del(k1){
					go=confirm('\n정말로 데이터를 삭제 하시겠습니까?\n')
					if(go==true){
					url='erase.php?No='+k1;
					window.open(url,'_self');
				}else{return false;}
				}
					
				function admin_memodel(No,Comm_No,page){
					go=confirm('\n정말로 데이터를 삭제 하시겠습니까?\n')
					if(go==true){
					url='erase.php?Memo=Y&No='+No+'&Comm_No='+Comm_No+'&page='+page;
					window.open(url,'_self');
				}else{return false;}
				}  

function Memo_del(No,Comm_No,page)
	{
		url="comm_del.php?No="+No+"&Comm_No="+Comm_No+"&page="+page;	//팝업창 파일이름 및 경로
		wi="200"		//팝업창 가로 사이즈
		hi="80"		//팝업창 세로 사이즈
		li="420"		//팝업창 가로 위치(가로 또는 세로 위치 값이 없을시 기본 위치에 팝업창이 뜸)
		ti="480"		//팝업창 세로 위치(가로 또는 세로 위치 값이 없을시 기본 위치에 팝업창이 뜸)
				
		liti=',left='+li+',top='+ti;
		window.open(url,'delete','width='+wi+',height='+hi+''+liti);
	}
//커맨드 입력 시키기
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

function check(fm)
	{
		if(check_blank(fm.Comm_Writer,'이름을',1)=='wrong'){return false}
		if(check_blank(fm.Comm_Cont,'내용을',2)=='wrong'){return false}
		if(check_blank(fm.Comm_Pass,'패스워드를',4)=='wrong'){return false}
		document.form1.submit();
	}

function board_zoom(kk){
	window.open('board01_zoom.htm?Fname_Zoom='+kk,'bbs_01','width=900,height=700,top=0,left=0,resizable=yes');
}
