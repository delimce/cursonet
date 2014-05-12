<?php
session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}"); ////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);

$crear = new formulario("db");

if ($_POST['r2nombre']) {
    $crear->insert_data("r", "2", "tbl_equipo", $_POST);
    $id2 = $crear->ultimoID;
    $crear->redirect("asignar.php?id=" . $id2);///redireccionando a asignar los estudiantes
}
?>
<html>
    <head> <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="../../css/style_back.css">

        <script language="JavaScript" type="text/javascript">
            function validar(){

                if(document.form1.r2grupo_id.value==''){

                    alert('<?= LANG_team_error_group ?>');

                    return false;

                }
                
                
                if(document.form1.r2nombre.value==''){

                    alert('<?= LANG_team_error_name ?>');
                    document.form1.r2nombre.focus();

                    return false;

                }

              

                return true;

            }
        </script>

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
                            <td><form name="form1" method="post" action="crear.php" onSubmit="return validar();">
                                    <table width="100%" border="0" cellspacing="4" cellpadding="3">
                                        <tr>
                                            <td colspan="2">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td class="style3"><?php echo LANG_group; ?></td>
                                            <td><? echo $crear->combo_db("r2grupo_id", "select nombre,id from tbl_grupo where curso_id = '{$_SESSION['CURSOID']}' order by nombre", "nombre", "id", LANG_select); ?></td>
                                        </tr>
                                        <tr>
                                            <td width="27%" class="style3"><?php echo LANG_team_name; ?></td>
                                            <td width="73%">
                                                <input name="r2nombre" type="text" id="r2nombre" size="45">  </td>
                                        </tr>
                                        <tr>
                                            <td class="style3"><?php echo LANG_team_desc; ?></td>
                                            <td>
                                                <textarea name="r2descripcion" rows="4" cols="45" class="style1" id="r2descripcion"></textarea>  </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <input type="reset" name="Submit2" value="Reset">
                                                <input type="submit" name="Submit" value="<?= LANG_save ?>"></td>
                                        </tr>
                                    </table>
                                </form></td>
                        </tr>
                    </table>	</td>
            </tr>
        </table>
    </body>
</html>
<?php
$crear->cerrar();
?>
