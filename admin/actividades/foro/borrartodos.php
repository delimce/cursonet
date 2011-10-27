<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../config/setup.php"); ////////setup
include("../../../class/clases.php"); ////////clase


$tool = new tools('db');

$tool->abrir_transaccion(); ////iniciando la transaccion

$tool->query("delete from tbl_foro_comentario where foro_id = '{$_POST['id']}'");
$tool->query("update tbl_foro set leido = '0' where id = '{$_POST['id']}'");

$tool->cerrar_transaccion(); 

$tool->cerrar();

?>