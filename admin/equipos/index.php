<?php
session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}"); ////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);


$features = array(
    "borde" => array("cellpadding" => 2, "cellspacing" => 1, "style" => "table_bk"),
    "mostrar_nresult" => array("nombre" => '<b>' . LANG_results . '<b>', "style" => "td_whbk", "align" => "left"),
    "no_registers" => '<table bgcolor="#FFFFFF" width="100%"><tr><td align = "center"><b>' . LANG_noresutlts . '</b></td></tr></table>',
    "style_body" => "td_whbk",
    "style_head" => "table_bk",
    "r_header" => 20,
    "formato" => "html",
    "oculto" => 0,
    "orden" => array("nombre" => "orden1", "defecto" => "grupo desc"),
    "abreviar" => array(1 => 30, 2 => 40, 3 => 16),
    "nuevo_vinculo1" => array("nombre" => "&nbsp;", "texto" => "<img border=\"0\" src=\"../../images/backend/button_edit.png\">", "url" => "editar.php?", "target" => "_self", "parametro" => 0, "var_parametro" => 'ItemID', "title" => LANG_edit),
    "nuevo_vinculo2" => array("nombre" => "&nbsp;", "texto" => "<img border=\"0\" src=\"../../images/backend/nuevo.gif\">", "url" => "asignar.php?", "target" => "_self", "parametro" => 0, "var_parametro" => 'id', "title" => LANG_team_join),
    "nuevo_vinculo3" => array("nombre" => "&nbsp;", "texto" => "<img border=\"0\" src=\"../../images/backend/button_drop.png\">", "url" => "#", "target" => "_self", "parametro" => 0, "var_parametro" => 'ItemID', "title" => LANG_drop, "borrar" => 1),
    "separacion" => array(0 => "1%", 1 => "40%", 2 => "45%", 3 => "12%"), //separacion de columnas
    "alineacion" => array(0 => "center", 1 => "left", 2 => "center", 3 => "center", 3 => "center"),
    "celda_vacia" => '<div align="center">-</div>'
);


$grid = new grid("94%", "*", "center", $features);
$grid->autoconexion();

$combo = new tools();
$combo->dbc = $grid->dbc;

/////////filtro
if (!empty($_GET['seccion'])) {

    $filtro = "and  g.id  = {$_GET['seccion']} ";
}
////////////
$query = "SELECT
            e.id,
            e.nombre as equipo,
            g.nombre as grupo,
            count(ee.id) as 'total'
            FROM
            tbl_equipo AS e
            left JOIN tbl_equipo_estudiante AS ee ON e.id = ee.equipo_id
            INNER JOIN tbl_grupo AS g ON e.grupo_id = g.id
            WHERE
            g.curso_id = {$_SESSION['CURSOID']} $filtro
            GROUP BY
            e.id";
///////////

$grid->query($query); //////se ejecuta el query
?>
<html>
    <head>
        <script language="JavaScript" type="text/javascript">
            function borrar(id,nombre){
	
                if (confirm("<?= LANG_borrar ?> "+nombre+" ?")) {
	  
                    location.replace('borrar.php?itemID='+id);
	  
                }else{
	  
	  
                    return false;
	  
                }
            }
        </script>

        <link rel="stylesheet" type="text/css" href="../../css/style_back.css">
    </head>

    <body>
        <table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td height="26" valign="top"><?php echo $menu->nombre; ?></td>
            </tr>
            <tr>
                <td><?php $menu->mostrar(0); ?></td>
            </tr>
            <tr>
                <td>

                    <table style="border-right:#000000 solid 1px; border-left:#000000 solid 1px; border-bottom:#000000 solid 1px;" width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td>
                                <br>&nbsp;<?= LANG_group_filter ?> <form name="se" action="index.php" method="get"><? echo $combo->combo_db("seccion", "select nombre,id from tbl_grupo where curso_id = '{$_SESSION['CURSOID']}' order by nombre", "nombre", "id", LANG_all, false, "submit();"); ?></form><br>
                                <br>
                                <? $grid->cargar($query, false, true); ?>&nbsp;
                            </td>
                        </tr>
                    </table>	</td>
            </tr>
        </table>
    </body>
</html>
