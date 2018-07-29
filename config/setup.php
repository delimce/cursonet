<?
	  
  /**************** PARAMETROS MODIFICABLES************************/
 $DIRAPP = "cursonet"; //// nombre del directorio de la aplicacion, en caso de que sea el raiz se obvia por ""
 $FEEDBACK = "http://cursonet.net/est/fg.php"; ///la direccion a donde va el post del formulario de feedback es unico para todas las versiones de cursonet
	
 //////////////CORREO SMTP///////////////////////////////////////////////
 $HOSTSMTP = ''; ///smtp1.example.com;smtp2.example.com";  // specify main and backup server
 $SMTPAUTH = true;     // turn on SMTP authentication
 $SMTPUSER= "DELIMCE";  // SMTP username
 $SMTPPASS = "secret"; // SMTP password

 date_default_timezone_set('America/Caracas');

 const api_url = 'http://zserver/cursonet2/api/admin/'; //ruta para consumir servicios rest

 /*************************************************************************/

  /****************** NO ALTERE ESTE BLOQUE **************************/
    	  
  require('redirect.php');    	  
  require_once('dbconfig.php');

 /******************PARA SUBIR ARCHIVOS*************************/
 $ADMINPATH = "/recursos/admin/";
 $USERPATH = "recursos/est/";
 $TMAX = "20" ////TAMANO MAXIMO DE ARCHIVOS A SUBIR EN MB

?>
