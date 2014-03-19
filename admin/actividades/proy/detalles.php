<?php
session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../config/setup.php"); ////////setup
include("../../../class/clases.php"); ////////clase
include ("../../../config/lang/{$_SESSION['LENGUAJE']}"); ////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);


$features = array(
    "borde" => array("cellpadding" => 2, "cellspacing" => 1, "style" => "table_bk"),
    //"mostrar_nresult" => array("nombre" =>  '<b>'.LANG_results.'<b>', "style" => "td_whbk", "align" => "left"),
    "no_registers" => '<table bgcolor="#FFFFFF" width="100%"><tr><td align = "center"><b>' . LANG_noresutlts . '</b></td></tr></table>',
    "style_body" => "td_whbk",
    "style_head" => "table_bk",
    "r_header" => 20,
    "formato" => "html",
    "oculto" => 0,
    "orden" => array(1 => "string", 2 => "string", 3 => "date", 4 => "float", 5 => "int", 6 => "int"),
    "conenlace" => array("pos" => 1, "title" => LANG_vdetails, "url" => "enun.php?", "parametro" => 0, "var_parametro" => "id"),
    "separacion" => array(0 => "1%", 1 => "33%", 2 => "25%", 3 => "15%", 4 => "7%"), //separacion de columnas
    "alineacion" => array(0 => "center", 1 => "left", 2 => "center", 3 => "center", 3 => "center", 4 => "center", 5 => "center", 6 => "center"),
    "celda_vacia" => '<div align="center">-</div>',
    "dateformat" => array("pos" => "3", "formato" => $_SESSION['DB_FORMATO']),
    "dateformat" => '3'
);



$grid = new grid2("grid1", "99%", $features);
$grid->autoconexion();
$query = "select id,nombre,ifnull((select nombre from tbl_grupo where id = p.grupo),'" . LANG_all . "') as seccion,fecha_entrega as entrega, concat(format(p.nota,1),'%') as porc,
  (select count(*) from tbl_proyecto_recurso where proy_id = p.id and tipo = 0 ) as archivos,
  (select count(*) from tbl_proyecto_recurso where proy_id = p.id and tipo = 1 ) as enlaces from tbl_proyecto p where p.curso_id = {$_SESSION['CURSOID']} ";
?>
<html>
    <head>

          <script src="../../../js/jquery/jquery-1.7.2.min.js"></script>
        <script src="../../../js/jquery/jquery.grid.functions.js"></script>

        <script type="text/javascript">

            // When document is ready: this gets fired before body onload :)
            $(document).ready(function() {

                $("#grid1").ordenarTabla();

            });


        </script>
        
        <link rel="stylesheet" type="text/css" href="../../../css/style_back.css">
    </head>

    <body>
        <table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td height="26" valign="top"><?php echo $menu->nombre; ?></td>
            </tr>
            <tr>
                <td><?php $menu->mostrar(3); ?></td>
            </tr>
            <tr>
                <td>

                    <table style="border-right:#000000 solid 1px; border-left:#000000 solid 1px; border-bottom:#000000 solid 1px;" width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td><br><?php $grid->cargar($query); ?>&nbsp;</td>
                        </tr>
                    </table>	</td>
            </tr>
        </table>
    </body>
</html>
<?php $grid->cerrar(); ?>