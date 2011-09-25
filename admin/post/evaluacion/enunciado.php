<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../config/setup.php"); ////////setup
include("../../../class/tools.php"); ////////clase
include ("../../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

 $prueba = new tools();
 $prueba->autoconexion();
 
 $dato = $prueba->array_query("select pregunta from evaluacion_pregunta where id = '{$_REQUEST['id']}'");
 

?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../../../css/style_back.css">
</head>

<body topmargin="1">
<div align="center">
  <p>
    <textarea name="textarea" cols="91" rows="6" class="style1"><?=$dato[0] ?></textarea>
  </p>
  <p>
    <input type="button" name="Button" value="<?=LANG_close ?>" onClick="window.close();">
    <br>
    <br>
  </p>
</div>
</body>
</html>
<?php

 $prueba->cerrar();

?>