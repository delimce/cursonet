<?php

session_start();

$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}"); ////lenguaje

$grupo = new tools("db");


$query = "select id, nombre from tbl_grupo where curso_id = {$_SESSION['CURSOID']}";
$grupos = $grupo->estructura_db($query);
$combo = '<option value="">'.LANG_all.'</option>';

for ($i = 0; $i < count($grupos); $i++) {

    $combo.= '<option value="' . $grupos[$i]['id'] . '">' . $grupos[$i]['nombre'] . '</option>';
}


$grupo->cerrar();

echo $combo;
?>
