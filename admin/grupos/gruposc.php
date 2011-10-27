<?php session_start();

$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

  $grupo = new tools("db");



  $query = "select id, nombre from tbl_grupo where curso_id = {$_SESSION['CURSOID']}";
  $grupos = $grupo->estructura_db($query);



 header("Content-Type: text/xml");
 header("Cache-Control: no-cache, must-revalidate");
 header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
 echo "<?xml version='1.0' encoding='ISO-8859-1'?>";

 echo '<xml>
  <seccion>
        <nombre>'.LANG_all.'</nombre>
        <valor>0</valor>
  </seccion>';


     for($i=0;$i<count($grupos);$i++){


	  echo ' <seccion>
	       <nombre>'.htmlspecialchars($grupos[$i]['nombre']).'</nombre>
	       <valor>'.$grupos[$i]['id'].'</valor>
	  </seccion>';


     }







echo '</xml>';


 $grupo->cerrar();

?>
