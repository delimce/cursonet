<?php session_start();
 include("../config/dbconfig.php");
 include("../class/tools.php");
 $nuevo = new tools();
 $nuevo->autoconexion();

 $val = $nuevo->array_query2("select modo,lenguaje,formato_fecha,envio_email,titulo_ins from setup");
 
  include("../config/lang/$val[1]"); ///idioma

 $_SESSION['FECHA'] = $val[2];
 $_SESSION['EEMAL'] = $val[3]; ////PARA SABER SI SE ENVIARA EL EMAIL
 $_SESSION['TINSCRIPCION'] = $val[4]; ////PARA SABER SI SE ENVIARA EL EMAIL
 


/*permitir inscripcion en modo curso 
 if($val[0]!=0){
 
	$nuevo->cerrar();
	$nuevo->redirect('../error/error.php');

 }
 
 */

 //////////////cambio de imagen
 $images = $nuevo->listar_archivos('../images/frontend/randon_i/');
 $actual = rand(0,count($images)-1);
//////////////////////////////

?>
<html>
<head>
<script language="JavaScript" type="text/javascript" src="../js/browser_detect.js"></script>
<title><?= $_SESSION['TINSCRIPCION'] ?></title>
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
    <td width="199" height="0" background="../images/frontend/home05.jpg" bgcolor="#A0A0A0">
	  <table width="100%" border="0" cellpadding="4" cellspacing="1" class="style1">
        <tr>
          <td width="100%" class="style1">Para dar inicio al proceso de inscripci&oacute;n, a continuaci&oacute;n presione el bot&oacute;n  </td>
        </tr>
        <tr>
          <td align="center" class="style1"><input style="background:#C0C0C0" type="button" name="Button" value="<?=LANG_to_ingress?>" onClick="location.replace('form.php')"></td>
        </tr>
      </table>
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
