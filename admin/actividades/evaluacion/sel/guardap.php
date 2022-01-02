<?php 
session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../../config/setup.php"); ////////setup
include("../../../../class/clases.php"); ////////clase
include("../../../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

$eva = new tools("db");

if (isset($_POST['enum'])) {

    $valores[0] = $_POST['eval'];
    $valores[1] = 1; //seleccion
    $valores[2] = utf8_decode($_POST['enum']);
    $valores[3] = $_POST['nivel'];
    $valores[4] = $_SESSION['CURSOID']; ///se guarda la pregunta por curso

    try{

        $eva->abrir_transaccion();
        $eva->insertar2("tbl_evaluacion_pregunta", "eval_id,tipo,pregunta,nivel,curso_id", $valores);
        $nuevap = $eva->ultimoID;
    
        for ($j = 0; $j < count($_POST['respuestas']); $j++) {
            $valores2[0] = $nuevap;
            $valores2[1] = $_POST['respuestas'][$j]; //seleccion
            $valores2[2] = ($j == $_POST['correcta']) ? 1 : 0;
            $eva->insertar2("tbl_pregunta_opcion", "preg_id,opcion,correcta", $valores2);
        }
        $eva->cerrar_transaccion();

    }catch(Exception $ex){
        throw new Exception($ex->getMessage(),500);
    }
  

    unset($_SESSION['OPCIONES']);
    unset($_SESSION['CORRECT']);

}

$eva->cerrar();
