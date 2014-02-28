<?php

session_start();

$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}"); ////lenguaje

$grupo = new tools("db");

$ide = formulario::getvar("id", $_POST);

$query = "select id, nombre from tbl_equipo where grupo_id = {$ide}";
$equipos = $grupo->estructura_db($query);
$combo = '<option value="">'.LANG_all.'</option>';

for ($i = 0; $i < count($equipos); $i++) {

    $combo.= '<option value="' . $equipos[$i]['id'] . '">' . $equipos[$i]['nombre'] . '</option>';
}


$grupo->cerrar();

echo $combo;
?>
