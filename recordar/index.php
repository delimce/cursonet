<?php session_start();
 include("../config/dbconfig.php");
 include("../class/clases.php");
 $nuevo = new tools("db");

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
<head>
<script language="JavaScript" type="text/javascript" src="../js/browser_detect.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/ajax.js"></script>

<script language="JavaScript" type="text/javascript">


function validar(form1) {

  if (document.form1.cedula.value.length < 6) {
  	
    	alert("Ingrese una cédula");
        document.form1.cedula.focus();
		
    return (false);
  }
  

	oXML = AJAXCrearObjeto();
	oXML.open('post', 'valida.php');
	oXML.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	oXML.onreadystatechange = function(){
		if (oXML.readyState == 4 && oXML.status == 200) {
		
				if(oXML.responseText==1){
				
				location.replace('respuesta.php');
				
								
				}else{
				
				alert('La Cédula ingresada no se encuentra registrada, Ud  no se encuentra inscrito');
				
				} 
				
				vaciar(oXML);
           
		}
	 }

	oXML.send('cedula='+document.form1.cedula.value); 
	

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
          <td width="100%" class="style1">Para iniciar el proceso de cambio de clave, se necesita validar su inscripci&oacute;n, a continuaci&oacute;n ingrese su n&uacute;mero de C&eacute;dula</td>
        </tr>
        <tr>
          <td height="33" align="center" class="style1"><input name="cedula" type="text" id="cedula" style="background:#C0C0C0; text-align:center;" size="16" maxlength="8"></td>
        </tr>
        <tr>
          <td height="36" align="center" class="style1"><input style="background:#C0C0C0" type="submit" name="Submit" value="<?php echo LANG_ok ?>"></td>
        </tr>
        <tr>
          <td align="center" class="style1"><a href="../index.php" target="_self" title="<?php echo LANG_back ?>"><?php echo LANG_back ?></a></td>
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
