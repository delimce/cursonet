<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../config/setup.php"); ////////setup
include("../../../class/tools.php"); ////////clase
include ("../../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

$tool = new tools();
$tool->autoconexion();

$dato = $tool->array_query2("select ifnull((select nombre from grupo where id = f.grupo_id),'".LANG_all."'),(select titulo from contenido where id = f.contenido_id),f.resumen, (select count(*) from foro_comentario where foro_id = f.id),f.leido,f.id from foro f where f.id = '{$_REQUEST['id']}' ");
if($tool->nreg==0){

  	for($i=0;$i<5;$i++) $dato[$i] = "-"; ///en caso de que no se halla seleccionado ningun tema
	$leido = '-';

}else{
	
	$leido = $dato[3] - $dato[4]; ///comentarios nuevos
	
}

header("Content-Type: text/xml");
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
echo "<?xml version='1.0' encoding='ISO-8859-1'?>";

echo "<xml>
 <grupo>$dato[0]</grupo>
 <caso>$dato[1]</caso>
 <resume>$dato[2]</resume>
 <numero>$dato[3]</numero>
 <nuevos>$leido</nuevos>
 <foroid>$dato[5]</foroid>
</xml>";


$tool->cerrar();

?>