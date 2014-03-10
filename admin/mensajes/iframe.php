<?php

session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}"); ////lenguaje

$combo = new tools("db");
$defecto = LANG_select;

if($_REQUEST['grupo']==0)
    $extra = "";
else
$extra = "and grupo_id = {$_REQUEST['grupo']} ";

if (isset($_REQUEST['tipo'])) {

    switch ($_REQUEST['tipo']) {
        case 0: ///admin
            $query = "select id, concat(nombre,' ',apellido) as nombre from tbl_admin where id != '{$_SESSION['USERID']}' order by nombre";
            break;
        case 1: //est
            $query = "select id, concat(nombre,' ',apellido,' - ',id_number) as nombre from tbl_estudiante where activo = 1 and id in (select est_id from tbl_grupo_estudiante where curso_id = {$_SESSION['CURSOID']} $extra )  order by nombre ";
            break;
        case 2:
            $query = "select id, nombre from tbl_grupo where curso_id = {$_SESSION['CURSOID']} order by nombre ";
            break;
    }

    $noresul = LANG_noresutlts2 . ' <input name="persona" type="hidden" value="">';

    $grupos = $combo->estructura_db($query);


    $combo1 = '<option value="">' . LANG_select . '</option>';

    for ($i = 0; $i < count($grupos); $i++) {

        $combo1.= '<option value="' . $grupos[$i]['id'] . '">' . $grupos[$i]['nombre'] . '</option>';
    }


    $combo->cerrar();

    echo $combo1;
}


?>
