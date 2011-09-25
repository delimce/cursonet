function nv500x400(url){
	window.open(url,'','fullscreen=no,toolbar=no,status=no,menubar=no,scrollbars=yes,resizable=no,directories=no,location=no,width=500,height=400');
}
function nv640x480(url){
	window.open(url,'','fullscreen=no,toolbar=no,status=no,menubar=no,scrollbars=yes,resizable=no,directories=no,location=no,width=640,height=480');
}
function nvCustom(url,tam1,tam2){
	window.open(url,'','fullscreen=no,toolbar=no,status=no,menubar=no,scrollbars=yes,resizable=no,directories=no,location=no,width='+tam1+',height='+tam2);
}
var arrWindows = new Array('');

function openPopup(strURL, intAncho, intAlto, bolShowBorders, bolScroll, strName){	
	if (arrWindows.length == 1)
		openPopupWindow(strURL, intAncho, intAlto, bolShowBorders, bolScroll, strName, false, false);
	else{
		bolPopupFound = false;
		for (i = 1; i < arrWindows.length; i++){
			if (!arrWindows[i].closed){
				if (arrWindows[i].name == strName){
					arrWindows[i].focus();
					bolPopupFound = true;
					break;
				}
			}
		}
		if (!bolPopupFound)
			openPopupWindow(strURL, intAncho, intAlto, bolShowBorders, bolScroll, strName, false, false);
	}
}

function openPopupWindow(strURL, intAncho, intAlto, bolShowBorders, bolScroll, strName, blnPrintMode, intIndex){
	if (!blnPrintMode){
		strProperties = 'left=' + (screen.availWidth - intAncho) / 2 + ',top=' + (screen.availHeight - intAlto) / 2 + ',width=' + intAncho + ',height=' + intAlto + ',menubar=no,resizable=no,status=no';
		strProperties += (bolScroll) ? ',scrollbars=yes' : ',scrollbars=no';
		strProperties += (bolShowBorders) ? ',fullscreen=yes' : '';
	}else
		//strProperties = 'left=2000,top=2000,width=0,height=0,menubar=no,resizable=no,status=no';
		strProperties = 'left=100,top=50,width=640,height=350,menubar=yes,scrollbars=yes,resizable=no,status=yes';

	intWindow = (intIndex) ? intIndex : arrWindows.length;
	arrWindows[intWindow] = window.open(strURL, strName, strProperties);
	if (bolShowBorders && !blnPrintMode){
//		self.focus();
		setTimeout("arrWindows[" + intWindow + "].resizeTo(" + intAncho + "," + intAlto + ")", 50);
		setTimeout("arrWindows[" + intWindow + "].moveTo(" + (window.screen.width - intAncho) / 2 + ", " + (window.screen.height - intAlto) / 2 + ")", 50);
	}
//	setTimeout("arrWindows[" + intWindow + "].focus()", 50);
}

function openPopupPrint(strURL, strName){
	openPopupWindow(strURL, 0, 0, false, false, strName, true, false);
}