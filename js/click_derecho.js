document.write('<div id="ie5menu" onMouseover="highlightie5()" onMouseout="lowlightie5()" onClick="jumptoie5();"></div>\n');	

var colorFilaClickeada='#dbeafb';
var colorFilaNormal='#FFFFFF';
var idEnUso='';

function linkea(id, cantElem, link1, nombre1, tipo1,link2, nombre2, tipo2, link3, nombre3, tipo3, link4, nombre4, tipo4, link5, nombre5, tipo5, link6, nombre6, tipo6, link7, nombre7, tipo7){
	
	if(idEnUso!=''){
		document.getElementById(idEnUso).style.backgroundColor=colorFilaNormal;
	}
	
	document.getElementById(id).style.backgroundColor=colorFilaClickeada;
	idEnUso=id;
	
	var url=new Array();

	url[1]=link1; //url del primer link				
	url[2]=link2; //url del segundo link				
	url[3]=link3; //url del tercer link
	url[4]=link4; //url del tercer link
	url[5]=link5; //url del tercer link
	url[6]=link6; //url del tercer link
	url[7]=link7; //url del tercer link
	
	var nombres=new Array();

	nombres[1]=nombre1; //url del primer link				
	nombres[2]=nombre2; //url del segundo link				
	nombres[3]=nombre3; //url del tercer link
	nombres[4]=nombre4; //url del tercer link
	nombres[5]=nombre5; //url del tercer link
	nombres[6]=nombre6; //url del tercer link
	nombres[7]=nombre7; //url del tercer link

	var tipos=new Array();

	tipos[1]=tipo1; //url del primer link				
	tipos[2]=tipo2; //url del segundo link				
	tipos[3]=tipo3; //url del tercer link
	tipos[4]=tipo4; //url del tercer link
	tipos[5]=tipo5; //url del tercer link
	tipos[6]=tipo6; //url del tercer link
	tipos[7]=tipo7; //url del tercer link

	//asocia los links
	document.getElementById('ie5menu').innerHTML='';

	
	for(i=1; i<=cantElem; i++){

		switch(tipos[i]){
				case 1:	document.getElementById('ie5menu').innerHTML+='<div class=\"menuitems\" id=\"menuItem'+i+'\" url=\"'+url[i]+'\">'+nombres[i]+'</div>';
							break;
				case 2:	document.getElementById('ie5menu').innerHTML+='<div class=\"menuitems\" target=\"window\" nvw=\"550\" nvh=\"400\" id=\"menuItem'+i+'\" url=\"'+url[i]+'\">'+nombres[i]+'</div>';
							break;
				case 3:	document.getElementById('ie5menu').innerHTML+='<div class=\"menuitems\" target=\"window\" nvw=\"640\" nvh=\"480\" id=\"menuItem'+i+'\" url=\"'+url[i]+'\">'+nombres[i]+'</div>';
							break;
				case 4:	document.getElementById('ie5menu').innerHTML+='<div class=\"menuitems\" target=\"window\" nvw=\"300\" nvh=\"60\" id=\"menuItem'+i+'\" url=\"'+url[i]+'\">'+nombres[i]+'</div>';
							break;
				case 5:	document.getElementById('ie5menu').innerHTML+='<div class=\"menuitems\" target=\"window\" nvw=\"250\" nvh=\"400\" id=\"menuItem'+i+'\" url=\"'+url[i]+'\">'+nombres[i]+'</div>';
							break;
		}		
	}
	
	var rightedge = document.body.clientWidth-event.clientX;
	var bottomedge = document.body.clientHeight-event.clientY;
	
	//muestra el menu
	if (rightedge < ie5menu.offsetWidth)
		ie5menu.style.left = document.body.scrollLeft + event.clientX - ie5menu.offsetWidth;
	else
		ie5menu.style.left = document.body.scrollLeft + event.clientX;
	if (bottomedge < ie5menu.offsetHeight)
		ie5menu.style.top = document.body.scrollTop + event.clientY - ie5menu.offsetHeight;
	else
		ie5menu.style.top = document.body.scrollTop + event.clientY;
		ie5menu.style.visibility = "visible";
	return false;
}


function linkeaConTamaño(id, cantElem, 
							link1, nombre1, tipo1, alto1, ancho1, 
							link2, nombre2, tipo2, alto2, ancho2, 
							link3, nombre3, tipo3, alto3, ancho3, 
							link4, nombre4, tipo4, alto4, ancho4, 
							link5, nombre5, tipo5, alto5, ancho5, 
							link6, nombre6, tipo6, alto6, ancho6, 
							link7, nombre7, tipo7, alto7, ancho7)
{
	
	if(idEnUso!='')
	{
		document.getElementById(idEnUso).style.backgroundColor=colorFilaNormal;
	}
	
	document.getElementById(id).style.backgroundColor=colorFilaClickeada;
	idEnUso=id;
	
	var url=new Array();

	url[1]=link1; //url del primer link				
	url[2]=link2; //url del segundo link				
	url[3]=link3; //url del tercer link
	url[4]=link4; //url del tercer link
	url[5]=link5; //url del tercer link
	url[6]=link6; //url del tercer link
	url[7]=link7; //url del tercer link
	
	var nombres=new Array();

	nombres[1]=nombre1; //url del primer link				
	nombres[2]=nombre2; //url del segundo link				
	nombres[3]=nombre3; //url del tercer link
	nombres[4]=nombre4; //url del tercer link
	nombres[5]=nombre5; //url del tercer link
	nombres[6]=nombre6; //url del tercer link
	nombres[7]=nombre7; //url del tercer link

	var alto=new Array();

	alto[1]=alto1; //el alto de la ventana en caso de que se abra en otra ventana			
	alto[2]=alto2; //el alto de la ventana en caso de que se abra en otra ventana			
	alto[3]=alto3; //el alto de la ventana en caso de que se abra en otra ventana			
	alto[4]=alto4; //el alto de la ventana en caso de que se abra en otra ventana			
	alto[5]=alto5; //el alto de la ventana en caso de que se abra en otra ventana			
	alto[6]=alto6; //el alto de la ventana en caso de que se abra en otra ventana			
	alto[7]=alto7; //el alto de la ventana en caso de que se abra en otra ventana			
	
	var ancho=new Array();

	ancho[1]=ancho1; //el ancho de la ventana en caso de que se abra en otra ventana			
	ancho[2]=ancho2; //el ancho de la ventana en caso de que se abra en otra ventana			
	ancho[3]=ancho3; //el ancho de la ventana en caso de que se abra en otra ventana			
	ancho[4]=ancho4; //el ancho de la ventana en caso de que se abra en otra ventana			
	ancho[5]=ancho5; //el ancho de la ventana en caso de que se abra en otra ventana			
	ancho[6]=ancho6; //el ancho de la ventana en caso de que se abra en otra ventana			
	ancho[7]=ancho7; //el ancho de la ventana en caso de que se abra en otra ventana	
	
	var tipos=new Array();

	tipos[1]=tipo1; //url del primer link				
	tipos[2]=tipo2; //url del segundo link				
	tipos[3]=tipo3; //url del tercer link
	tipos[4]=tipo4; //url del tercer link
	tipos[5]=tipo5; //url del tercer link
	tipos[6]=tipo6; //url del tercer link
	tipos[7]=tipo7; //url del tercer link

	//asocia los links
	document.getElementById('ie5menu').innerHTML='';

	
	for(i=1; i<=cantElem; i++)
	{

		switch(tipos[i])
		{
				case 1:	document.getElementById('ie5menu').innerHTML+='<div class=\"menuitems\" id=\"menuItem'+i+'\" url=\"'+url[i]+'\">'+nombres[i]+'</div>';
							break;
				case 2:	document.getElementById('ie5menu').innerHTML+='<div class=\"menuitems\" target=\"window\" nvw=\"'+alto[i]+'\" nvh=\"'+ancho[i]+'\" id=\"menuItem'+i+'\" url=\"'+url[i]+'\">'+nombres[i]+'</div>';
							break;
		}		
	}
	
	var rightedge = document.body.clientWidth-event.clientX;
	var bottomedge = document.body.clientHeight-event.clientY;
	
	//muestra el menu
	if (rightedge < ie5menu.offsetWidth)
		ie5menu.style.left = document.body.scrollLeft + event.clientX - ie5menu.offsetWidth;
	else
		ie5menu.style.left = document.body.scrollLeft + event.clientX;
	if (bottomedge < ie5menu.offsetHeight)
		ie5menu.style.top = document.body.scrollTop + event.clientY - ie5menu.offsetHeight;
	else
		ie5menu.style.top = document.body.scrollTop + event.clientY;
		ie5menu.style.visibility = "visible";
	return false;
}

function hidemenuie5() {
	ie5menu.style.visibility = "hidden";
	if(idEnUso!='')document.getElementById(idEnUso).style.backgroundColor=colorFilaNormal;
}

function highlightie5() {
	if (event.srcElement.className == "menuitems") {
		event.srcElement.style.backgroundColor = "highlight";
		event.srcElement.style.color = "white";				
	}
}

function lowlightie5() {
	if (event.srcElement.className == "menuitems") {
		event.srcElement.style.backgroundColor = "";
		event.srcElement.style.color = "black";
		window.status = "";
	}
}

function jumptoie5() {
	if (event.srcElement.className == "menuitems") {
		if (event.srcElement.getAttribute("target") != null)
			//abre una nueva ventana
			nvCustom(event.srcElement.url,event.srcElement.getAttribute("nvw"),event.srcElement.getAttribute("nvh"));						
		else
			window.location = event.srcElement.url;						
	   }
}	

function nada(){				
	return false;
}

if (document.all && window.print) {
	ie5menu.className = "menuClickDerecho";
	document.oncontextmenu = nada;
	document.body.onclick = hidemenuie5;
}