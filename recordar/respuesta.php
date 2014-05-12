<?php session_start();
 include("../config/dbconfig.php");
 include("../class/clases.php");
 $nuevo = new tools('db');

 $val = $nuevo->array_query2("select lenguaje,formato_fecha,envio_email,titulo from tbl_setup");
 
  include("../config/lang/$val[0]"); ///idioma

 $_SESSION['FECHA'] = $val[1];
 $_SESSION['EEMAL'] = $val[2]; ////PARA SABER SI SE ENVIARA EL EMAIL
 $_SESSION['TITULO'] = $val[3]; ////PARA SABER SI SE ENVIARA EL EMAIL
 
 //////////////cambio de imagen
 $images = $nuevo->listar_archivos('../images/frontend/randon_i/');
 $actual = rand(0,count($images)-1);
//////////////////////////////

?>
<html>
<head> <meta charset="utf-8">
<script language="JavaScript" type="text/javascript" src="../js/browser_detect.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/ajax.js"></script>

<script language="JavaScript" type="text/javascript">


function validar(form1) {

  if (document.form1.resp.value.length < 1) {
  	
    	alert("Ingrese una respuesta");
        document.form1.resp.focus();
		
    return (false);
  }
  

	oXML = AJAXCrearObjeto();
	oXML.open('post', 'valida.php');
	oXML.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	oXML.onreadystatechange = function(){
		if (oXML.readyState == 4 && oXML.status == 200) {
		
				if(oXML.responseText==1){
				
					location.replace('final.php');
				
								
				}else{
				
					alert('La respuesta a la pregunta es Incorrecta!, Vuelva a intentarlo');
				
				} 
				
				vaciar(oXML);
           
		}
	 }

	oXML.send('resp='+document.form1.resp.value); 
	

	return (false);

  
 }
</script>


<title><?= $_SESSION['TITULO'] ?></title>
<link rel="stylesheet" type="text/css" href="../css/style_front.css">


</head>
<body>
<br>
<table height="517" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="419" rowspan="3" valign="bottom"><img src="../images/frontend/randon_i/<?=$images[$actual]; ?>" width="419" height="516"></td>
    <td height="209" colspan="2" valign="bottom"><img src="../images/frontend/home02.jpg" width="281" height="208"></td>
  </tr>
  <tr>
    <td width="199" height="0" valign="top" background="../images/frontend/home05.jpg" bgcolor="#A0A0A0">
    
    <form name="form1" method="post" action="" onSubmit = "return validar(this)">
	 
      <table width="100%" height="160" border="0" cellpadding="4" cellspacing="1" class="style1">
        <tr>
          <td width="100%" class="style1">La c&eacute;dula aparece registrada con el nombre <b><?php echo $_SESSION['NOMBRE'] ?></b>  para suministrar sus credenciales de acceso ud debe responder la siguiente pregunta:</td>
        </tr>
        <tr>
          <td height="33" align="center" class="small"><div align="justify"><?php echo $_SESSION['CPREGUNTA']; ?></div></td>
        </tr>
        <tr>
          <td height="33" align="left" class="style1"><input name="resp" type="text" id="resp" style="background:#C0C0C0;" size="30"></td>
        </tr>
        <tr>
          <td height="36" align="center" class="style1"><input style="background:#C0C0C0" type="submit" name="Submit" value="<?php echo LANG_ok ?>"></td>
        </tr>
      </table>
      
      </form>
      
    </td>
    <td width="85" align="left"><img src="../images/frontend/home04.jpg" width="82" height="179"></td>
  </tr>
  <tr>
    <td height="129" colspan="2" valign="bottom"><img src="../images/frontend/home03.jpg" width="281" height="129"></td>
  </tr>
</table>
</body>
</html>
<?php

$nuevo->cerrar();

?>
