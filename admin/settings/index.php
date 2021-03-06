<?php
session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}"); ////lenguaje

include("security.php"); ///seguridad para el admin
require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);


$features = array(
    "borde" => array("cellpadding" => 2, "cellspacing" => 1, "style" => "table_bk"),
    "mostrar_nresult" => array("nombre" => '<b>' . LANG_results . '<b>', "style" => "td_whbk", "align" => "left"),
    "no_registers" => '<table bgcolor="#FFFFFF" width="100%"><tr><td align = "center"><b>' . LANG_noresutlts . '</b></td></tr></table>',
    "style_body" => "td_whbk",
    "style_head" => "table_bk",
    "buscador" => true,
    "formato" => "html",
    "oculto" => 0,
    "abreviar" => array(1 => 40, 2 => 30, 3 => 40),
    "decoracion" => array(1 => "capitalize", 2 => "lowercase"),
    "nuevo_vinculo1" => array("nombre" => "&nbsp;", "texto" => "<img border=\"0\" src=\"../../images/backend/button_edit.png\">", "url" => "editar.php?", "target" => "_self", "parametro" => 0, "var_parametro" => 'ItemID', "title" => LANG_edit),
    "nuevo_vinculo2" => array("nombre" => "&nbsp;", "texto" => "<img border=\"0\" src=\"../../images/backend/button_drop.png\">", "url" => "#", "target" => "_self", "parametro" => 0, "var_parametro" => 'ItemID', "title" => LANG_drop, "borrar" => 1),
    "separacion" => array(0 => "1%", 1 => "33%", 2 => "22%", 3 => "37%", 4 => "7%"), //separacion de columnas
    "alineacion" => array(0 => "center", 1 => "left", 2 => "center", 3 => "center", 3 => "center", 4 => "center"),
    "celda_vacia" => '<div align="center">-</div>'
);


$grid = new grid2("grid1", "99%", $features);
$grid->autoconexion();
$query = "select id, concat(nombre,' ',apellido) as nombre, user as usuario, email,
   if(es_admin=1,'" . LANG_yes . "','" . LANG_no . "') as admin
   from tbl_admin where id != {$_SESSION['USERID']} ";
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

            });

        </script>

        <script language="JavaScript" type="text/javascript">
            function borrar(id, nombre) {

                if (confirm("<?= LANG_borrar ?> " + nombre + " ?")) {

                    location.replace('borrar.php?itemID=' + id);

                } else {


                    return false;

                }
            }
        </script>

        <link rel="stylesheet" type="text/css" href="../../css/style_back.css">
    </head>

    <body>
        <table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td height="26" valign="top"> <span class="menu-title"><?= $menu->nombre; ?></span></td>
            </tr>
            <tr>
                <td><?php $menu->mostrar(0); ?></td>
            </tr>
            <tr>
                <td>

                    <table style="border-right:#000000 solid 1px; border-left:#000000 solid 1px; border-bottom:#000000 solid 1px;" width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td><br>
                                <a href="crear.php" class="style1"> <img src="../../images/backend/nuevo.gif" width="16" height="16" border="0" align="left"><?= LANG_add ?></a><br>
                                <br>
                                <?php $grid->cargar($query); ?>&nbsp;</td>
                        </tr>
                    </table>	</td>
            </tr>
        </table>
    </body>
</html>
<?php
$grid->cerrar();
?>
