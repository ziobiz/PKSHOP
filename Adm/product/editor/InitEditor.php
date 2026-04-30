var blnInProgress = false;
var blnBodyLoaded = false;
var blnEditorLoaded = false;

function HandleLoad() {
	blnBodyLoaded = true;
	if (blnEditorLoaded == true) {
		init();
	}
}

function init() {
	if (document.all.content.value != "") {
		document.all.editBox.html = document.all.content.value;
	}
}

function setEditMode(sMode) {
   if (document.all.editmode.checked == false) {
      sMode = "html";
      document.all.editBox.editmode = sMode;
      }
   else   		
      document.all.editBox.editmode = sMode;
}
