<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../config/setup.php"); ////////setup
include("../../../class/clases.php"); ////////clase


$tool = new ObjectDB();
$ide = formulario::getvar("id",$_POST);
$tool->abrir_transaccion(); ////iniciando la transaccion

$tool->setTable("tbl_foro_comentario");
$tool->deleteWhere("foro_id = $ide");

$tool->setTable("tbl_foro");
$tool->setField("leido", 0);
$tool->updateWhere("id = $ide");

//$tool->query("delete from tbl_foro_comentario where foro_id = '{$_POST['id']}'");
//$tool->query("update tbl_foro set leido = '0' where id = '{$_POST['id']}'");

$tool->cerrar_transaccion(); 

$tool->cerrar();

?>