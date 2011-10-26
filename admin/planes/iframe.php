<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

 $combo = new tools();
 $combo->autoconexion();

 $defecto = LANG_select;


 if(isset($_REQUEST['tipo'])){

	switch ($_REQUEST['tipo']) {
	case 'foro': ///foro
	   $query = "select id, titulo as nombre from foro where curso_id = '{$_SESSION['CURSOID']}' and (grupo_id = '{$_SESSION['GRUPOPLAN']}' or grupo_id = 0) order by titulo";
	   break;
	case 'proy': //proy
	 $query = "select id, nombre from proyecto where curso_id = '{$_SESSION['CURSOID']}' and (grupo = '{$_SESSION['GRUPOPLAN']}' or grupo = 0) order by nombre";
	   break;
	case 'eval':
	  $query = "select id, nombre from evaluacion where curso_id = '{$_SESSION['CURSOID']}' and (grupo_id = '{$_SESSION['GRUPOPLAN']}' or grupo_id = 0) order by nombre";
	   break; 
	}

	$noresul = LANG_noresutlts2.' <input name="act" type="hidden" value="">';

	$grupos = $combo->estructura_db($query);



 	header("Content-Type: text/xml");
    header("Cache-Control: no-cache, must-revalidate");
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    echo "<?xml version='1.0' encoding='ISO-8859-1'?>";

   echo '<xml>';



     echo ' <activi>
	     	  <nombre>'.$defecto.'</nombre>
	       		<id>0</id>
	  		</activi>';

     for($i=0;$i<count($grupos);$i++){


	  echo ' <activi>
	     	  <nombre>'.htmlspecialchars($grupos[$i]['nombre']).'</nombre>
	       		<id>'.$grupos[$i]['id'].'</id>
	  		</activi>';


     }




  echo '</xml>';









 }


 $combo->cerrar();

?>
