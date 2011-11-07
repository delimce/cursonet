<?php session_start();
$profile = 'est'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php");

$tool = new tools('db');

/////cuenta las veces que se pide soporte tecnico
$tool->query("update tbl_log_est set soporte_t = soporte_t+1 where id = {$_SESSION['EST_ACTUAL']} ");

$tool->cerrar();
?>