<?php session_start();
 include("../config/dbconfig.php");
 include("../class/tools.php");
 $nuevo = new tools();
 
 if(!isset($_SESSION['RLOGIN'])) $nuevo->redirect('../index.php');
 
 $nuevo->autoconexion();

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
    <td width="199" height="0" align="center" valign="top" background="../images/frontend/home05.jpg" bgcolor="#A0A0A0">
    
  	 
      <table width="100%" height="96" border="0" cellpadding="4" cellspacing="1" class="style1">
        <tr>
          <td width="100%" height="20" valign="top" class="style1">Sus Datos han sido cambiados con exito! sus nuevas credenciales de acceso son las siguientes:</td>
        </tr>
        <tr>
          <td height="33" align="center" class="small">
          Usuario:&nbsp;<b><?php echo $_SESSION['RLOGIN']  ?></b><br>
          Clave:&nbsp;<b><?php echo $_SESSION['RCEDULA']  ?></b>          </td>
        </tr>
        
        <tr>
          <td height="36" align="left" class="style1">Si lo desea al iniciar su sesi&oacute;n puede cambiar la clave en la opcion <strong>Mi Cuenta</strong></td>
        </tr>
      </table>
      
  
      
      <span class="style1"><span class="small">
      <input style="background:#C0C0C0" type="button" name="Button" onClick="location.replace('../index.php');" value="<?php echo LANG_back ?>">
    </span></span></td>
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
session_destroy(); ///acaba con la sesion anterior

?>
