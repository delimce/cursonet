<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/tools.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

 $combo = new tools();
 $combo->autoconexion();

 $defecto = LANG_select;

	if($_REQUEST['grupo']!="") $extra = "and grupo_id = {$_REQUEST['grupo']} "; else $extra = "";

 if(isset($_REQUEST['tipo'])){

	switch ($_REQUEST['tipo']) {
	case 0: ///admin
	   $query = "select id, concat(nombre,' ',apellido) as nombre from tbl_admin where id != '{$_SESSION['USERID']}' order by nombre";
	   break;
	case 1: //est
	 $query = "select id, concat(nombre,' ',apellido,' - ',id_number) as nombre from estudiante where activo = 1 and id in (select est_id from grupo_estudiante where curso_id = {$_SESSION['CURSOID']} $extra )  order by nombre ";
	   break;
	case 2:
	  $query = "select id, nombre from grupo where curso_id = {$_SESSION['CURSOID']} order by nombre ";
	   break; 
	}

	$noresul = LANG_noresutlts2.' <input name="persona" type="hidden" value="">';

	$grupos = $combo->estructura_db($query);



 	header("Content-Type: text/xml");
    header("Cache-Control: no-cache, must-revalidate");
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    echo "<?xml version='1.0' encoding='ISO-8859-1'?>";

   echo '<xml>';



     echo ' <personas>
	     	  <nombre>'.$defecto.'</nombre>
	       		<id>0</id>
	  		</personas>';

     for($i=0;$i<count($grupos);$i++){


	  echo ' <personas>
	     	  <nombre>'.htmlspecialchars($grupos[$i]['nombre']).'</nombre>
	       		<id>'.$grupos[$i]['id'].'</id>
	  		</personas>';


     }




  echo '</xml>';









 }


 $combo->cerrar();

?>
