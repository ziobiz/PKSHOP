/*트림*/
var TRIM_PATTERN = /(^\s*)|(\s*$)/g; // 내용의 값을 빈공백을 trim하기 위한것(앞/뒤)
 
String.prototype.trim = function() 
{
	return this.replace(TRIM_PATTERN, "");
};

String.prototype.IsNumber = function()
{
	return this.replace(/[^0-9]/gi,"");	
}


/*이미지 창 띄우기*/
function imgUp(ihid,idiv,iidx,iwid,ihei,cwid,chei,iroot)
{
	var url = "?ihid="+ihid+"&idiv="+idiv+"&iidx="+iidx+"&iwid="+iwid+"&ihei="+ihei+"&cwid="+cwid+"&chei="+chei+"&iroot="+iroot;
	window.open("/img_upload.php"+url,"","top=100,left=100,width=600,height=700");
}
function popupWindow(url,width,height,top,left)
{
	var oOption = "width="+width+",height="+height+",top="+top+",left="+left+"location=no,toolbar=no,menubar=no";
	window.open(url,'',oOption);
}

function versionCheck(evnt)
{
	if(evnt.stopPropagation)
	{
		return "NS";
	}
	else
	{
		return "IE";
	}
}
/*이메일체크*/
function checkMail(str)
{
	var pattern = /^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/i
	return pattern.test(str);
}
/*숫자체크--숫자시 false 문자시 true*/
function chkNumbering(str)
{
	var pattern =/[^0-9]/gi;
	return pattern.test(str);
}
function chkChar(str)
{
	var pattern =/[^a-zA-Z]/gi;
	return pattern.test(str);
}

//spacial char
function chkSpacial(str)
{
	var pattern = /\W|\s/g;
	return pattern.test(str)
}
//attachEvent, addEventLisener;
function addEvent(obj,ent,func)
{
	ie_ns();
	if(browser == "ie")
	{
		ent = ent.replace("","on");
		obj.attachEvent(ent,func);
	}
	else
	{
		obj.addEventLisener(ent,func,false);
	}
}//detachEvent, removeEventLisener;
function delEvent(obj,ent,func)
{
	ie_ns();
	if(browser == "ie")
	{
		ent = ent.replace("","on");
		obj.detachEvent(ent,func);
	}
	else
	{
		obj.removeEventLisener(ent,func,false);
	}
}

var browser = null;

function ie_ns()
{
	return browser = (navigator.userAgent.indexOf('MSIE') != -1) ? "ie" : "ns";
}

function setPng24(obj) 
{
	obj.width=obj.height=1;
	obj.className=obj.className.replace(/\bpng24\b/i,'');
	obj.style.filter =
	"progid:DXImageTransform.Microsoft.AlphaImageLoader(src='"+ obj.src +"',sizingMethod='image');"
	obj.src=''; 
	return '';
}
//구글 번역기

var member_type = '';

var member_type = '';
function check_spon(type){

   var frm  = document.join_form;

	member_type = type;

	
	if (frm.c_username.value != "" && type == "c")
	{

	   var ul = "check_spon.php?id="+frm.c_username.value+"&type="+type;
	   member_type = type;
	   load(ul);  
	}
} 

function check_spon2(type){

   var frm  = document.join_form;

	member_type = type;
	if(type =="center"){
		var ul = "check_spon.php?id="+frm.center.value+"&type="+type;

		member_type = type;
		load(ul);  
	}else if (frm.h_username.value != "" && type == "h")
	{
	   var ul = "check_spon.php?id="+frm.h_username.value+"&type="+type;

	   member_type = type;
	   load(ul);  

	}
} 

function load(url){
     httpRequest = getXMLHttpRequest();
     httpRequest.open("GET", url, true);
     httpRequest.setRequestHeader("If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT"); 
     httpRequest.onreadystatechange = viewMessage;
     httpRequest.send(null);
}


function viewMessage(){
	 var frm = document.join_form;
     if(httpRequest.readyState == 4)
	{
           if(httpRequest.status == 200)
		   {
//               alert(httpRequest.responseText);
				if (member_type == "c")
				{
						  if(httpRequest.responseText == 0 || httpRequest.responseText == 2)
						{
								   frm.c_username.value = "";
								   frm.cidflag.value = "n"; 
								   frm.confirm_cid.value = "";
								   frm.sponsearchc.value= "";

								   frm.c_username.focus();   
							 
						  }
						 
						  else{
								frm.confirm_cid.value = frm.c_username.value; 
								frm.cidflag.value = "y";  
								frm.sponsearchc.value= httpRequest.responseText;
						  } 
				
				}
				else if (member_type == "h")
				{
						  if(httpRequest.responseText == "0")
						{
								   frm.h_username.value = "";
								   frm.hidflag.value = "n"; 
								   frm.confirm_hid.value = "";
								   document.getElementById('sponsearchh').innerHTML = "check your sponser";

								   frm.h_username.focus();   
							 
						  }
						 
						  else{
								frm.confirm_hid.value = frm.h_username.value; 
								frm.hidflag.value = "y";  
								frm.sponsearchch.value = httpRequest.responseText;
							//    document.getElementById('sponsearchh').innerHTML = "sponsor name :"+httpRequest.responseText;
						  } 

				
				}else if(member_type == "center"){
					if(httpRequest.responseText == "0")
					{
							   
							   frm.centerflag.value = "n"; 
							   frm.center.value = "";
							//    document.getElementById('sponsearchh').innerHTML = "check your sponser";

							   frm.center.focus();   
						 
					  }
					 
					  else{
							frm.center.value = frm.center.value; 
							frm.centerflag.value = "y";  
						   
					  } 

				}
           }
		   else
		  {
                   alert("Unavailable : "+httpRequest.status);
           }
     }
}



function getXMLHttpRequest(){
     if(window.ActiveXObject){
        try{
                return new ActiveXObject("Msxml2.XMLHTTP");
        }catch(e){
                try{
                        return new ActiveXObject("Microsoft.XMLHTTP");
                }catch(e1){
                        return(null);
                }
        }
     }else if(window.XMLHttpRequest){
           return new XMLHttpRequest();
     }else{
           return null;
     }
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

function check_id()
{
	var frm = document.join_form;


	

	if (frm.s_username.value != "")
	{
			var url = "check_id.php?uid="+frm.s_username.value;

			idload(url);
	}
}

function idload(_url){
     httpRequest = getXMLHttpRequest();
     httpRequest.open("GET", _url, true);
     httpRequest.setRequestHeader("If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT"); 
     httpRequest.onreadystatechange = check_id_xml_ok;
     httpRequest.send(null);
}


function check_id_xml_ok()
{
	var frm = document.join_form;
	
	if(httpRequest.readyState == 4)
	{
		if(httpRequest.status == 200)
		{
			//alert(httpRequest.responseText);
			if(httpRequest.responseText == 1)
			{
				frm.s_username.value = "";
				frm.userid_confrom.value = "n"; 
				alert("Not available");
				frm.s_username.focus();

			}
			else if(httpRequest.responseText == 66)
			{
				frm.s_username.value = "";
				frm.userid_confrom.value = "n"; 
				alert("ID 4 or more digits, including English numbers");
				frm.s_username.focus();

			}
			else
			{
				alert("ID that can be used");
				frm.userid_confrom.value = "y"; 

			}
		}
	}
}

 



function wrestTrim(fld) 
{
    var pattern = /(^\s*)|(\s*$)/g; // \s 공백 문자
    fld.value = fld.value.replace(pattern, "");
    return fld.value;
}

function wrestAlphaNumeric(fld) 
{ 
	var wrestFld = null;
	if (!wrestTrim(fld)) return; 
	var pattern = /(^[a-zA-Z0-9]+$)/; 
	if (!pattern.test(fld.value)) 
	{ 
	   if (wrestFld == null) 
	   { 
	       //wrestMsg = wrestItemname(fld) + " : 영문 또는 숫자가 아닙니다.\n"; 
	       //wrestFld = fld; 
	       return "f";
	   } 
	} 
} 


function checkchar	(value)
{
	var regexp =/[~!@\#$%^&*\()\=+_<>]/gi;

	if (regexp.test(value))
	{
		return true;
	}
	else
	{
		return false;
	}
	
}

 
 function numcheck(nun)
 {
	var frm = document.all;
	var regexp = /^[0-9]{4,20}$/;
	
	if (!regexp.test(data))
	{
		frm.userid.value ="";
		frm.passwd.value ="";
	}
}

/*  엑셀 출력*/ 
	function excell_out(type)
	{
		if (type == "pay")
		{
			var frm = document.searchwith;
			var query = "excell.php?name=pay&checks="+frm.ccheck.value+"&search="+frm.search_sel.value+"&sqlsearch="+frm.search_txt.value;
			window.open(query,"","top=100,left=300,width=800,height=600");
			
		}
		else if (type == "sudang")
		{
			var frm = document.searchmember;			
			var query = "excell.php?name="+type+"&search="+frm.searchSel.value+"&sqlsearch="+frm.searchText.value;
			window.open(query,"","top=100,left=300,width=800,height=600");
		}
		else if (type=="cust")
		{
			var frm = document.searchmember;
			var query = "excell.php?name=cust&type="+frm.searchText.value+"&search="+frm.searchSel.value;
			window.open(query,"","top=100,left=300,width=800,height=600");
		}
		else if (type == "sell")
		{
			var frm = document.sellfrm;

			if (frm.searDate.value =="" && frm.searDate2.value =="")
			{
				alert('날짜를 선택 하세요');
			}
			else
			{
			var query = "excell.php?name="+type+"&sqlsearch="+frm.searDate.value+"~"+frm.searDate2.value+"&type="+frm.searchsel2.value;
			window.open(query,"","top=100,left=300,width=800,height=600");
			}

		}

	}
		
	

function postWinOpen(data) {
	window.open("post_search.php?method="+data, "","scrollbars=yes, width=500, height=400");
}



function check_mail(){

	var frm = document.join_form;
	
	if (frm.email.value == ""){
		alert('Enter email');
		return false;	
	}

	if (checkMail(frm.email.value) == false){
		frm.email.value = "";
		alert('Mail format invalid.');
		document.getElementById('check_email').innerHTML = "";	
		frm.confirm_email.value = "n"; 	
		return false;	
	}
	
	var url = "check_email.php?uid="+frm.email.value;
	idload_email(url);
	
}

function idload_email(_url){
     httpRequest = getXMLHttpRequest();
     httpRequest.open("GET", _url, true);
     httpRequest.setRequestHeader("If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT"); 
     httpRequest.onreadystatechange = check_email_xml_ok;
     httpRequest.send(null);
}
function check_email_xml_ok()
{
	var frm = document.join_form;
	
	if(httpRequest.readyState == 4)
	{
		if(httpRequest.status == 200)
		{
//			alert(httpRequest.responseText);
			if(httpRequest.responseText == 1)
			{
				frm.confirm_email.value = "y"; 
				document.getElementById('check_email').innerHTML = "<span><img src='image/accept.gif' width='20' height='18' border='0' /><img src='image/white_spacer.gif' width='5' height='2' border='0'><font color='#003909'><b> Available   </b></font></span>";
			}
			else
			{
				frm.confirm_email.value = "n"; 
				document.getElementById('check_email').innerHTML = "<img src='image/delete.gif' width='20' height='18' border='0' /><img src='image/white_spacer.gif' width='5' height='2' border='0'> <font color='#FF0000'><b>Not Valid!</font>";
				frm.v_code.focus();
			}
		}
	}
}


function load_sms()
{
	var frm = document.join_form;


	if (frm.email.value == "")
	{
		alert("Enter Email");

	}
	else
	{
		var url ="send_sms.php?email="+frm.email.value;
		sms_load(url);
	}
}

function load_sms2()
{
	var frm = document.profilefrm;
	// var name = frm.name.value;
	// var hand = frm.hand.value;
	// var addr = frm.addr.value;
	// var verify1 = frm.verify1.value;
		var url ="/send_email3.php";
		sms_load2(url);
	
}

function sms_load2(_url)
{
     httpRequest = getXMLHttpRequest();
     httpRequest.open("GET", _url, true);
     httpRequest.setRequestHeader("If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT"); 
     httpRequest.onreadystatechange = check_sms_xml_ok2;
     httpRequest.send(null);
}

function check_sms_xml_ok2()
{
	var frm = document.join_form;
	
	if(httpRequest.readyState == 4)
	{
		if(httpRequest.status == 200)
		{
				var codes = httpRequest.responseText;
				codes = codes.replace(TRIM_PATTERN, "");

				codes = codes.replace(/\n/g, "");//행바꿈제거

				codes = codes.replace(/\r/g, "");//엔터제거

			if (codes == "0")
			{
				alert("send is fail");
			}
			else
			{
				alert("input Certified Number");
				// frm.phone_code.value		=codes;
			}
		}
	}
}


function sms_load(_url)
{
     httpRequest = getXMLHttpRequest();
     httpRequest.open("GET", _url, true);
     httpRequest.setRequestHeader("If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT"); 
     httpRequest.onreadystatechange = check_sms_xml_ok;
     httpRequest.send(null);
}


function check_sms_xml_ok()
{
	var frm = document.join_form;
	
	if(httpRequest.readyState == 4)
	{
		if(httpRequest.status == 200)
		{
				var codes = httpRequest.responseText;
				codes = codes.replace(TRIM_PATTERN, "");

				codes = codes.replace(/\n/g, "");//행바꿈제거

				codes = codes.replace(/\r/g, "");//엔터제거

			if (codes == "0")
			{
				alert("send is fail");
			}
			else if(codes == "11")
			{
				alert("email check");
			}
			else if(codes == "22")
			{
				alert("Try again after 3 minutes of sending mail");
			}
			else
			{
				alert("input Certified Number");
				frm.phone_code.value		=codes;
			}
		}
	}
}


function send_email()
{
	
	var frm =  document.join_form;
	
	if (frm.email.value == "")
	{
		alert("Enter Eamil");
	}
	else if (checkMail(frm.email.value) == false){

		frm.email.value = "";
		alert("Email format is wrong");
	}
	else
	{
		var url ="send_email.php?send_email="+frm.email.value;
		email_load(url);
	
	}

	
}

function email_load(_url)
{
     httpRequest = getXMLHttpRequest();
     httpRequest.open("GET", _url, true);
     httpRequest.setRequestHeader("If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT"); 
     httpRequest.onreadystatechange = send_email_ok;
     httpRequest.send(null);
}

function send_email_ok()
{
	var frm =  document.join_form;

	if(httpRequest.readyState == 4)
	{
		if(httpRequest.status == 200)
		{
			if (httpRequest.responseText == "")
			{
				alert("try again");
			}
			else
			{
				alert("email was sent. check your email");
 				frm.veri_code.value		= httpRequest.responseText;
			}
		}
	}
	
}





