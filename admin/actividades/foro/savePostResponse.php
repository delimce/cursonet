<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../config/setup.php"); ////////setup
include("../../../class/clases.php"); ////////clase
include("../../../config/lang/{$_SESSION['LENGUAJE']}"); ////lenguaje

// $tool = new formulario("db");

$tool = new tools("db");

$valores[0] = $_POST['comentario_id'];
$valores[1] = $_POST['sujeto_id'];
$valores[2] = $_POST['tipo_sujeto'] ?? 0;
$valores[3] = $_POST['content'];
$valores[4] = date("Y-m-d H:i:s");
$valores[5] = date("Y-m-d H:i:s");

$fields = "comentario_id,sujeto_id,tipo_sujeto,content,created_at,updated_at";

if (isset($_POST['id'])) {

    $valores2 = [$valores[3],$valores[5]];
    $campos = ["content","updated_at"];
    $tool->update("tbl_foro_respuesta", $campos, $valores2, "id = {$_POST['id']}");
} else {
    $tool->insertar2("tbl_foro_respuesta", $fields, $valores);
}

$tool->cerrar();
