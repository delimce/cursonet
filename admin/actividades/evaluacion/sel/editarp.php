<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../../config/setup.php"); ////////setup
include("../../../../class/clases.php"); ////////clase
include("../../../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

$eva = new tools("db");

if (isset($_POST['enum'])) {

    $valores[0] = $_POST['evalu'];
    $valores[1] = utf8_decode($_POST['enum']);
    $valores[2] = $_POST['nivel'];
    $campos = explode(',', "eval_id,pregunta,nivel");


    $eva->abrir_transaccion();

    $eva->update("tbl_evaluacion_pregunta", $campos, $valores, "id = '{$_SESSION['PREGUNTA_ID']}'");

    $eva->query("delete from tbl_pregunta_opcion where preg_id = {$_SESSION['PREGUNTA_ID']} ");

    $nuevap = $_SESSION['PREGUNTA_ID'];

    for ($j = 0; $j < count($_POST['respuestas']); $j++) {

        $valores2[0] = $nuevap;
        $valores2[1] = $_POST['respuestas'][$j]; //seleccion
        $valores2[2] = ($j == $_POST['correcta'])?1:0;
        $eva->insertar2("tbl_pregunta_opcion", "preg_id,opcion,correcta", $valores2);
    }

    $eva->cerrar_transaccion();

    unset($_SESSION['PREGUNTA_ID']);

}


$eva->cerrar();

?>