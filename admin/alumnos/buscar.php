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
    "no_registers" => '<table bgcolor="#FFFFFF" width="100%"><tr><td align = "center"><b>' . LANG_nofound . '</b></td></tr></table>',
    "style_body" => "td_whbk",
    "style_head" => "table_bk",
    "r_header" => 20,
    "formato" => "html",
    "orden" => array(2 => "int"),
    "oculto" => '0,6',
    "conenlace" => array("pos" => "1", "title" => LANG_vdetails, "url" => "detalles.php?", "target" => "_self", "parametro" => 0, "var_parametro" => "id", "extras" => "&origen=3"),
    "abreviar" => array(1 => 30, 3 => 25),
    "nuevo_vinculo1" => array("nombre" => "&nbsp;", "texto" => "<img border=\"0\" src=\"../../images/backend/button_edit.png\">", "url" => "editar.php?orig=3&", "target" => "_self", "parametro" => 0, "var_parametro" => 'ItemID', "title" => LANG_edit),
    "nuevo_vinculo2" => array("nombre" => "&nbsp;", "texto" => "<img border=\"0\" src=\"../../images/backend/button_drop.png\">", "url" => "#", "target" => "_self", "parametro" => 0, "var_parametro" => 'ItemID', "title" => LANG_drop, "borrar" => 1, "condicion" => 6, "texto_condicion" => "<img border=\"0\" src=\"../../images/backend/button_nodel.png\">"),
    "separacion" => array(0 => "1%", 1 => "37%", 2 => "13%", 3 => "17%", 4 => "26%", 5 => "9%"), //separacion de columnas
    "alineacion" => array(0 => "center", 1 => "left", 2 => "center", 3 => "center", 3 => "center", 4 => "center", 5 => "center"),
    "celda_vacia" => '<div align="center"><font color="#CC0000">' . LANG_ungroup . '</font></div>'
);
$grid = new grid2("grid1", "99%", $features);
$grid->autoconexion();


if (isset($_REQUEST['nombre'])) {


    $form = new formulario();

    $nombre = $form->getvar("nombre", $_POST);
    $ci = $form->getvar("ci", $_POST);

    if (!empty($ci)) {
        $porNombre = 'nombre = ""';
        $porApellido = 'apellido = ""';
    } else {

        $busquedas = explode(" ", $nombre);


        /////busquedas con el nombre
        for ($i2 = 0; $i2 < count($busquedas); $i2++) {

            $porNombre.= "nombre like '%" . $busquedas[$i2] . "%'";
            if ($i2 != count($busquedas) - 1)
                $porNombre.= " or ";
        }


        /////busquedas con el apellido
        for ($i2 = 0; $i2 < count($busquedas); $i2++) {

            $porApellido.= "apellido like '%" . $busquedas[$i2] . "%'";
            if ($i2 != count($busquedas) - 1)
                $porApellido.= " or ";
        }
    }



    $query = "select id,concat(nombre,' ',apellido) as nombre,id_number as cedula,user,
		  (SELECT 
		  g.nombre
		FROM
		  `tbl_grupo_estudiante` ge
		  INNER JOIN `tbl_grupo` g ON (ge.grupo_id = g.id)
		where ge.curso_id = {$_SESSION['CURSOID']} and est_id = e.id )as seccion,
		  (if (activo=1,'". LANG_is_active ."','" . LANG_is_noactive . "')) as Activo,
		   if({$_SESSION['ADMIN']}>2,'1','0') as condicion_editar
		  from tbl_estudiante e where ( ($porNombre) OR ($porApellido) ) OR (id_number = '$ci') order by nombre,apellido,id_number";


    $grid->query($query); //////se ejecuta el query
}
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

    <BODY>

        <table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td height="26" valign="top"> <span class="menu-title"><?= $menu->nombre; ?></span></td>
            </tr>
            <tr>
                <td><?php $menu->mostrar(3); ?></td>
            </tr>
            <tr>
                <td>

                    <table style="border-right:#000000 solid 1px; border-left:#000000 solid 1px; border-bottom:#000000 solid 1px;" width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td align="center"><br>
                                <table width="95%" border="0">
                                    <tr>
                                        <td>

                                            <form name="form1" method="get" action="">

                                                <table width="311" border="0" cellpadding="2" cellspacing="2">
                                                    <tr>
                                                        <td colspan="2" class="style3"><?php echo LANG_lookinfor ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="120"><span class="style1"><?php echo LANG_name ?>:</span></td>
                                                        <td width="181"><input name="nombre" type="text" id="nombre" value="<?php echo $_REQUEST['nombre'] ?>" size="40"></td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="style1"><?php echo LANG_ci ?>:</span></td>
                                                        <td><input type="text" name="ci" id="ci" value="<?php echo $_REQUEST['ci'] ?>"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td><input type="submit" name="button" id="button" value="<?php echo LANG_search ?>"></td>
                                                    </tr>
                                                </table>
                                            </form>                </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td><?php if (isset($_REQUEST['nombre'])) $grid->cargar($query); ?></td>
                                    </tr>
                                </table>
                                <br>&nbsp;<br>
                                <br>
                                &nbsp;</td>
                        </tr>
                    </table>	</td>
            </tr>
        </table>
    </body>
</html>
<?php $grid->cerrar(); ?>

