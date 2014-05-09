<?php  session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../config/setup.php"); ////////setup
include("../../../class/clases.php"); ////////clase
include ("../../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

if(isset($_GET['id'])){
$ide = formulario::getvar("id");    
$db = new ObjectDB();
$db->setTable("tbl_foro_comentario");
$db->deleteWhere("id = $ide");
$db->cerrar();
}


tools::javaviso(LANG_foro_delreg,"vercoment.php");

?>