// JavaScript Document

////CREA EL OBJETO AJAX

function AJAXCrearObjeto(){ 
 var obj; 
 if(window.XMLHttpRequest) { // no es IE 
 obj = new XMLHttpRequest(); 
 } else { // Es IE o no tiene el objeto 
 try { 
 obj = new ActiveXObject("Microsoft.XMLHTTP"); 
 } 
 catch (e) { 
 alert('El navegador utilizado no está soportado'); 
 } 
 } 
 return obj; 
} 


////VACIA EL OBJETO AJAX


function vaciar(obj){

   delete obj;
   obj = null;

}



 /**************** FUNCTION Q ENVIA UN REQUEST AJAX A UNA DIR ASINCRONAMENTE*********************
     MEDODO: metodo en el que se pasaran las variables "get"/"post"
	 URL: url al q pasara los parametros ejemplo: prueba.php
	 VARS:  variables, con sus valores separados por ejemplo: var='123'&var2='1234'
 /******************************************************************/

	function ajaxsend(metodo,url,vars){
		
	var is_ok;	
	oXML = AJAXCrearObjeto();
	oXML.open(metodo,url);
	oXML.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	oXML.onreadystatechange = function(){
		if (oXML.readyState == 4 && oXML.status == 200) {

				is_ok = true;
				vaciar(oXML);

		}else{
			
				is_ok = false;
			
			
		}
		
		
	 }

	oXML.send(vars);

	return (is_ok);
		
		
	}



  /**************** FUNCTION Q CREA UN COMBO AJAX*********************
     ID: id del objeto div q sera reemplazado por el combo
	 COMBO: nombre y id del objeto combo generado
	 URL: del archivo request xml q pasara los parametros ejemplo: prueba.php?id=12
	 ELXML:  nombre de la etiqueta que lleva los valores xml del combo
	 OPCION: nombre de la etiqueta de la opcion
	 VALUE: nombre de la etiqueta deL Valor
	 
	 NOTA: EJECUTAR LA FUNCION DENTRO DEL BODY HTML Y ASEGURESE Q EXISTE EL DIV A REEMPLAZAR
	******************************************************************/



     function ajaxcombo(id,combo,url,elXml,opcion,value){
			
			  var combo = '<select name="'+combo+'" id="'+combo+'">';
			  var contenido;
	
				oXML = AJAXCrearObjeto();
				  
				  oXML.open('get', url);
			
						  oXML.onreadystatechange = function(){
							
							if (oXML.readyState == 4 && oXML.status == 200) {
							
								
										  var xml  = oXML.responseXML.documentElement;
										  for (i = 0; i < xml.getElementsByTagName(elXml).length; i++){
										   var item = xml.getElementsByTagName(elXml)[i];
										   
										   ///////////////generando combo 
										   
										   var txt1 = item.getElementsByTagName(opcion)[0].firstChild.data;
										   var txt2 = item.getElementsByTagName(value)[0].firstChild.data;
										 			
											contenido = contenido + '<option value="'+txt2+'">'+txt1+'</option>';									   
										  
										 
										  
										  
										   ////////////////
										   
										  }
										  
										  
										  combo = combo + contenido + '</select>';
								 		 document.getElementById(id).innerHTML = combo;	
							 
							}
							
							
							 vaciar(oXML); ////eliminando objeto ajax	
					  }
				
				
				
								
				oXML.send(null); 
				
				

				
										
			}
