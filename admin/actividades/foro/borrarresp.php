<?php  session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../config/setup.php"); ////////setup
include("../../../class/clases.php"); ////////clase
include ("../../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

$tool = new tools("db");

if(isset($_GET['id'])) $tool->query("delete from foro_respuesta where id = {$_GET['id']} ");

$tool->cerrar();
$tool->javaviso(LANG_est_foro_respdeleted,"vercoment.php");

?>