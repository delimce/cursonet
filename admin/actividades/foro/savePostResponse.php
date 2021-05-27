<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../config/setup.php"); ////////setup
include("../../../class/clases.php"); ////////clase
include("../../../config/lang/{$_SESSION['LENGUAJE']}"); ////lenguaje

$tool = new formulario("db");

if (isset($_POST['id'])) {
    $_POST['r-content'] = $tool->getvar('r-content', $_POST);
    $tool->update_data("r", "-", "tbl_foro_respuesta", $_POST, "id = {$_POST['id']}");
} else {
    $_POST['r-content'] = $tool->getvar('r-content', $_POST);
    $_POST['r-created_at'] = @date("Y-m-d H:i:s");
    $_POST['r-updated_at'] = @date("Y-m-d H:i:s");
    $tool->insert_data("r", "-", "tbl_foro_respuesta", $_POST);
}

$tool->cerrar();
