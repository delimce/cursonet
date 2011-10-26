<?php  session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../config/setup.php"); ////////setup
include("../../../class/clases.php"); ////////clase
include ("../../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

$tool = new tools();
$tool->autoconexion();

if(isset($_GET['id'])) $tool->query("delete from foro_comentario where id = {$_GET['id']} ");

$tool->cerrar();
$tool->javaviso(LANG_foro_delreg,"vercoment.php");

?>