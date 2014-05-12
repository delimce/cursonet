<?php
session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}"); ////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);

$tool = new tools("db");



if (isset($_POST['id'])) {


    $tool->abrir_transaccion();

    $tool->query("delete from tbl_plan_estudiante where item_id = {$_POST['id']}");

    foreach ($_POST['nota'] as $i => $valor) {

        if ($_POST['nota'][$i] !== "") {
            //echo "Current value of {$_POST['esid'][$i]}: $valor.\n";		

            $valores[0] = $_POST['id'];
            $valores[1] = $_POST['esid'][$i];
            $valores[2] = $valor;

            $tool->insertar2("tbl_plan_estudiante", "item_id,est_id,nota", $valores);
        }
    }

    $tool->cerrar_transaccion();


    $tool->javaviso(LANG_planes_evalok);
    ?>
    <script type="text/javascript">
        history.go(-2);
    </script>
    <?
    die();
} else {

    $query = "SELECT DISTINCT 
						 LOWER(concat(e.apellido, ' ', e.nombre)) AS nombre,
						  e.id_number,
						  e.id,
						  (SELECT round(nota,2) FROM tbl_plan_estudiante WHERE est_id = e.id AND item_id = pi.id) AS nota
						FROM
						  tbl_grupo_estudiante g
						  INNER JOIN tbl_estudiante e ON (g.est_id = e.id)
						  INNER JOIN tbl_plan_evaluador p ON (p.grupo_id = g.grupo_id)
						  INNER JOIN tbl_plan_item `pi` ON (p.id = `pi`.plan_id)
						WHERE
						  `pi`.id = {$_REQUEST['id']}
						  
						  order by e.apellido, e.nombre";

    $tool->query($query);
}
?>
<html>
    <head> <meta charset="utf-8">

        <link rel="stylesheet" type="text/css" href="../../css/style_back.css">
    </head>

    <body>


        <form action="" method="post" name="form1" target="_self">


            <table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td height="26" valign="top"><?php echo $menu->nombre; ?></td>
                </tr>
                <tr>
                    <td><?php $menu->mostrar(2); ?></td>
                </tr>
                <tr>
                    <td>

                        <table style="border-right:#000000 solid 1px; border-left:#000000 solid 1px; border-bottom:#000000 solid 1px;" width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td>

                                    <p><br>    


                                    </p>


                                    <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td class="no_back"><?php echo LANG_planes_item_name . ': ' . $_REQUEST['item'] ?></td>
                                        </tr>
                                        <tr>

                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td class="table_bk"><table width="100%" border="0" align="center" cellpadding="2" cellspacing="1">
                                                    <tr>
                                                        <td width="83%" align="center" class="table_bk"><?php echo LANG_est ?></td>
                                                        <td width="17%" align="center" class="table_bk"><?php echo LANG_nota ?></td>
                                                    </tr>
                                                    <?php
                                                    while ($row = $tool->db_vector_nom($tool->result)) {
                                                        ?>
                                                        <tr class="td_whbk" onMouseOver="this.style.backgroundColor = '#CCCCCC'" onMouseOut="this.style.backgroundColor = '#FFFFFF'">
                                                            <td class="style1" style="text-transform: capitalize"><b><?php echo $row['nombre'] ?></b> - <?php echo $row['id_number'] ?>
                                                                <input name="esid[]" type="hidden" id="esid[]" value="<?= $row['id'] ?>"></td>
                                                            <td align="center"><input name="nota[]" type="text" style="text-align:center" id="nota[]" value="<?= $row['nota'] ?>" size="5" maxlength="6"></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    ?>
                                                </table></td>
                                        </tr>
                                    </table>


                                    <p align="center">
                                        <input type="button" name="Button" onClick="history.back();" value="<?= LANG_back ?>">
                                        <input type="submit" name="Submit" value="<?= LANG_save ?>">
                                        <input name="id" type="hidden" id="id" value="<?= $_REQUEST['id'] ?>">
                                    </p>
                                    <p><br>



                                    </p></td>
                            </tr>
                        </table>	</td>
                </tr>
            </table>

        </form>



    </body>
</html>
<?php $tool->cerrar(); ?>
