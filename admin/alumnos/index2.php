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
    "buscador" => true,
    "formato" => "html",
    "oculto" => '0,6',
    "conenlace" => array("pos" => "1", "title" => LANG_vdetails, "url" => "detalles.php?", "target" => "_self", "parametro" => 0, "var_parametro" => "id", "extras" => "&origen=1"),
    "orden" => array(2 => "int"),
    "abreviar" => array(1 => 46, 3 => 25),
    "decoracion" => array(1 => "capitalize",3=>"lowercase"),
    "nuevo_vinculo1" => array("nombre" => "&nbsp;", "texto" => "<img border=\"0\" src=\"../../images/backend/button_edit.png\">", "url" => "editar.php?orig=1&", "target" => "_self", "parametro" => 0, "var_parametro" => 'ItemID', "title" => LANG_edit),
    "nuevo_vinculo2" => array("nombre" => "&nbsp;", "texto" => "<img border=\"0\" src=\"../../images/backend/button_drop.png\">", "url" => "#", "target" => "_self", "parametro" => 0, "var_parametro" => 'ItemID', "title" => LANG_drop, "borrar" => 1, "condicion" => 6, "texto_condicion" => "<img border=\"0\" src=\"../../images/backend/button_nodel.png\">"),
    "separacion" => array(0 => "1%", 1 => "46%", 2 => "13%", 3 => "17%", 4 => "20%", 5 => "9%"), //separacion de columnas
    "alineacion" => array(0 => "center", 1 => "left", 2 => "center", 3 => "center", 3 => "center", 4 => "center", 5 => "center"),
    "celda_vacia" => '<div align="center"><font color="#CC0000">' . LANG_ungroup . '</font></div>'
);



$grid = new grid2("grid1", "99%", $features);
$grid->autoconexion();

$combo = new tools();
$combo->dbc = $grid->dbc;

$query = "select id,concat(nombre,' ',apellido) as nombre,id_number as cedula,user,
  (SELECT 
  g.nombre
FROM
  `tbl_grupo_estudiante` ge
  INNER JOIN `tbl_grupo` g ON (ge.grupo_id = g.id)
where ge.curso_id = {$_SESSION['CURSOID']} and est_id = e.id )as seccion,
  (if (activo=1,'". LANG_is_active ."','" . LANG_is_noactive . "')) as Activo,
   if({$_SESSION['ADMIN']}>2,'1','0') as condicion_editar
  from tbl_estudiante e where e.id not in (select est_id from tbl_grupo_estudiante where curso_id = '{$_SESSION['CURSOID']}' )";


$grid->query($query); //////se ejecuta el query
?>
<!DOCTYPE html>
<html>
    <head> <meta charset="utf-8">

        <script src="../../js/jquery/jquery-1.7.2.min.js"></script>
        <script src="../../js/jquery/jquery.grid.functions.js"></script>

        <script type="text/javascript">

            // When document is ready: this gets fired before body onload :)
            $(document).ready(function() {
                // Write on keyup event of keyword input element
                buscarGrid('grid1');
                $("#grid1").ordenarTabla();
                  $('#nest', window.parent.document).html(<?=$grid->nreg?>);

            });

        </script>

        <script language="JavaScript" type="text/javascript">
            function borrar(id, nombre) {

                if (confirm("<?= LANG_borrar ?> " + nombre + " ?")) {
                    ///manda la variable v para q retorne al index2.php
                    location.replace('borrar.php?v=2&itemID=' + id);

                } else {


                    return false;

                }
            }
        </script>


        <script language="JavaScript" type="text/javascript" src="../../js/utils.js"></script>

        <link rel="stylesheet" type="text/css" href="../../css/style_back.css">
    </head>

    <body>

        <table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td height="26" valign="top"><?php echo $menu->nombre; ?></td>
            </tr>
            <tr>
                <td><?php $menu->mostrar(1); ?></td>
            </tr>
            <tr>
                <td>

                    <table style="border-right:#000000 solid 1px; border-left:#000000 solid 1px; border-bottom:#000000 solid 1px;" width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td>
                                <br><?php $grid->cargar($query); ?>&nbsp;</td>
                        </tr>
                    </table>	</td>
            </tr>
        </table>
    </body>
</html>
<?
$grid->cerrar();
?>
