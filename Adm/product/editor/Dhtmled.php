// DHTML Editing Component Constants for JavaScript
// Copyright 1999 Microsoft Corporation.  All rights reserved.
//

//
// Command IDs
//
DECMD_BOLD =                      5000
DECMD_COPY =                      5002
DECMD_CUT =                       5003
DECMD_DELETE =                    5004
DECMD_DELETECELLS =               5005
DECMD_DELETECOLS =                5006
DECMD_DELETEROWS =                5007
DECMD_FINDTEXT =                  5008
DECMD_FONT =                      5009
DECMD_GETBACKCOLOR =              5010
DECMD_GETBLOCKFMT =               5011
DECMD_GETBLOCKFMTNAMES =          5012
DECMD_GETFONTNAME =               5013
DECMD_GETFONTSIZE =               5014
DECMD_GETFORECOLOR =              5015
DECMD_HYPERLINK =                 5016
DECMD_IMAGE =                     5017
DECMD_INDENT =                    5018
DECMD_INSERTCELL =                5019
DECMD_INSERTCOL =                 5020
DECMD_INSERTROW =                 5021
DECMD_INSERTTABLE =               5022
DECMD_ITALIC =                    5023
DECMD_JUSTIFYCENTER =             5024
DECMD_JUSTIFYLEFT =               5025
DECMD_JUSTIFYRIGHT =              5026
DECMD_LOCK_ELEMENT =              5027
DECMD_MAKE_ABSOLUTE =             5028
DECMD_MERGECELLS =                5029
DECMD_ORDERLIST =                 5030
DECMD_OUTDENT =                   5031
DECMD_PASTE =                     5032
DECMD_REDO =                      5033
DECMD_REMOVEFORMAT =              5034
DECMD_SELECTALL =                 5035
DECMD_SEND_BACKWARD =             5036
DECMD_BRING_FORWARD =             5037
DECMD_SEND_BELOW_TEXT =           5038
DECMD_BRING_ABOVE_TEXT =          5039
DECMD_SEND_TO_BACK =              5040
DECMD_BRING_TO_FRONT =            5041
DECMD_SETBACKCOLOR =              5042
DECMD_SETBLOCKFMT =               5043
DECMD_SETFONTNAME =               5044
DECMD_SETFONTSIZE =               5045
DECMD_SETFORECOLOR =              5046
DECMD_SPLITCELL =                 5047
DECMD_UNDERLINE =                 5048
DECMD_UNDO =                      5049
DECMD_UNLINK =                    5050
DECMD_UNORDERLIST =               5051
DECMD_PROPERTIES =                5052

//
// Enums
//

// OLECMDEXECOPT  
OLECMDEXECOPT_DODEFAULT =         0 
OLECMDEXECOPT_PROMPTUSER =        1
OLECMDEXECOPT_DONTPROMPTUSER =    2

// DHTMLEDITCMDF
DECMDF_NOTSUPPORTED =             0 
DECMDF_DISABLED =                 1 
DECMDF_ENABLED =                  3
DECMDF_LATCHED =                  7
DECMDF_NINCHED =                  11

// DHTMLEDITAPPEARANCE
DEAPPEARANCE_FLAT =               0
DEAPPEARANCE_3D =                 1 

// OLE_TRISTATE
OLE_TRISTATE_UNCHECKED =          0
OLE_TRISTATE_CHECKED =            1
OLE_TRISTATE_GRAY =               2

menuData = new Array()
for (i=0; i < 7; i++) {
	menuData[i] = new Array(40)
	for (j=0; j < 20; j++) {
		menuData[i][j] = new Array(2)
	}
}
	
var br
if(navigator.appName == 'Netscape' && document.layers != null){br="N";}
else if(navigator.appName == 'Microsoft Internet Explorer' && document.all != null){br="IE";}
else{br=null}

function linkTo(form) {
    var myindex=form.nav_menu.selectedIndex
	location=(form.nav_menu.options[myindex].value);
}


function arrmOn(imgName)
{if (document.images) {document[imgName].src=eval(imgName+"on.src");}}
//
function arrmOff(imgName)
{if (document.images) {document[imgName].src=eval(imgName+"off.src");}}
//
if (document.images)
{

img01on=new Image(); img01on.src="images/cut_on.gif";
img01off=new Image(); img01off.src="images/cut_off.gif";

img02on=new Image(); img02on.src="images/copy_on.gif";
img02off=new Image(); img02off.src="images/copy_off.gif";

img03on=new Image(); img03on.src="images/paste_on.gif";
img03off=new Image(); img03off.src="images/paste_off.gif";

img04on=new Image(); img04on.src="images/bold_on.gif";
img04off=new Image(); img04off.src="images/bold_off.gif";

img05on=new Image(); img05on.src="images/italic_on.gif";
img05off=new Image(); img05off.src="images/italic_off.gif";

img06on=new Image(); img06on.src="images/underline_on.gif";
img06off=new Image(); img06off.src="images/underline_off.gif";

img07on=new Image(); img07on.src="images/left_on.gif";
img07off=new Image(); img07off.src="images/left_off.gif";

img08on=new Image(); img08on.src="images/center_on.gif";
img08off=new Image(); img08off.src="images/center_off.gif";

img09on=new Image(); img09on.src="images/right_on.gif";
img09off=new Image(); img09off.src="images/right_off.gif";

img10on=new Image(); img10on.src="images/inp_on.gif";
img10off=new Image(); img10off.src="images/inp_off.gif";

img11on=new Image(); img11on.src="images/outp_on.gif";
img11off=new Image(); img11off.src="images/outp_off.gif";

img12on=new Image(); img12on.src="images/num_on.gif";
img12off=new Image(); img12off.src="images/num_off.gif";

img13on=new Image(); img13on.src="images/li_on.gif";
img13off=new Image(); img13off.src="images/li_off.gif";

img14on=new Image(); img14on.src="images/link_on.gif";
img14off=new Image(); img14off.src="images/link_off.gif";

img15on=new Image(); img15on.src="images/line_on.gif";
img15off=new Image(); img15off.src="images/line_off.gif";

img16on=new Image(); img16on.src="images/table_on.gif";
img16off=new Image(); img16off.src="images/table_off.gif";

img17on=new Image(); img17on.src="images/inpic_on.gif";
img17off=new Image(); img17off.src="images/inpic_off.gif";

img18on=new Image(); img18on.src="images/file_on.gif";
img18off=new Image(); img18off.src="images/file_off.gif";

img19on=new Image(); img19on.src="images/tcolor_on.gif";
img19off=new Image(); img19off.src="images/tcolor_off.gif";

img20on=new Image(); img20on.src="images/tbcolor_on.gif";
img20off=new Image(); img20off.src="images/tbcolor_off.gif";

img21on=new Image(); img21on.src="images/sup_on.gif";
img21off=new Image(); img21off.src="images/sup_off.gif";

img22on=new Image(); img22on.src="images/sub_on.gif";
img22off=new Image(); img22off.src="images/sub_off.gif";
}