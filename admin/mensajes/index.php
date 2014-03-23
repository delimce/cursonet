<?php
session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}"); ////lenguaje


if (isset($_REQUEST['delete0'])) { ////borrar todos los mensajes
    $tool = new tools("db");
    $tool->query("delete from tbl_mensaje_admin where para = '{$_SESSION['USERID']}' ");
    $tool->cerrar();
    $tool->javaviso("Todos sus mensajes han sido borrados", "index.php");
}

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);


$features = array(
    "borde" => array("cellpadding" => 2, "cellspacing" => 1, "style" => "table_bk"),
    "mostrar_nresult" => array("nombre" => '<b>' . LANG_results . '<b>', "style" => "td_whbk", "align" => "left"),
    "no_registers" => '<table bgcolor="#FFFFFF" width="100%"><tr><td align = "center"><b>' . LANG_msg_nomesage . '</b></td></tr></table>',
    "style_body" => "td_whbk",
    "style_head" => "table_bk",
    "formato" => "html",
    "buscador" => true,
    "oculto" => 0,
    "abreviar" => array(1 => 56, 2 => 36),
    "conenlace" => array("pos" => 1, "url" => "mensaje.php?", "target" => "_self", "parametro" => 0, "var_parametro" => "id"),
    "nuevo_vinculo2" => array("nombre" => "&nbsp;", "texto" => "<img border=\"0\" src=\"../../images/backend/button_drop.png\">", "url" => "#", "target" => "_self", "parametro" => 0, "var_parametro" => 'ItemID', "title" => LANG_drop, "borrar" => 1),
    "separacion" => array(0 => "1%", 1 => "58%", 2 => "27%", 3 => "10%"), //separacion de columnas
    "alineacion" => array(0 => "center", 1 => "left", 2 => "left", 3 => "center"),
    "decoracion" => array(2 => "capitalize"),
    "celda_vacia" => '<div align="center">-</div>',
    "dateformat" => '3'
);


$grid = new grid2("grid1", "99%", $features);
$grid->autoconexion();
$query = "select id,if(leido=0,concat('<b>',subject,'</b>'),subject) as titulo,
  IF(tipo=0,(ifnull((select concat('" . LANG_msg_prefa . "',lower(nombre),' ',lower(apellido)) from tbl_admin where id = de),'<b>" . LANG_msg_noadm . "</b>') ),ifnull((select concat('" . LANG_msg_prefs . "',lower(nombre),' ',lower(apellido)) from tbl_estudiante where id = de ),'<b>" . LANG_msg_noest . "</b>')) as Remite
  ,fecha from tbl_mensaje_admin where para = '{$_SESSION['USERID']}' order by leido,fecha desc ";


$grid->query($query); //////se ejecuta el query
?>
<html>
    <head>


        <script src="../../js/jquery/jquery-1.7.2.min.js"></script>
        <script src="../../js/jquery/jquery.grid.functions.js"></script>

        <script type="text/javascript">

            // When document is ready: this gets fired before body onload :)
            $(document).ready(function() {
                // Write on keyup event of keyword input element
                buscarGrid('grid1');
                $("#grid1").ordenarTabla();
                $('#nmsgs', window.parent.document).html(<?=$grid->nreg?>);

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


            function borrartodo() {

                if (confirm("Seguro que desea borrar todos los mensajes recibidos?")) {

                    location.replace('index.php?delete0=1');

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
                <td height="26" valign="top"><?php echo $menu->nombre; ?></td>
            </tr>
            <tr>
                <td><?php $menu->mostrar(0); ?></td>
            </tr>
            <tr>
                <td>

                    <table style="border-right:#000000 solid 1px; border-left:#000000 solid 1px; border-bottom:#000000 solid 1px;" width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td><p><br>
                                    <br>
                                    <?php $grid->cargar($query); ?>
                                    &nbsp;</p>

                                <?php if ($grid->nreg > 0) { ?>
                                    <p align="center">
                                        <input type="button" name="button" onClick="borrartodo();" id="button" value="Borrar todos los mensajes">
                                        <br>
                                        <br>
                                    </p>

                                <?php } ?></td>
                        </tr>
                    </table>	</td>
            </tr>
        </table>
    </body>
</html>
<?php $grid->cerrar(); ?>
