<?php
session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}"); ////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);

$ver = new tools("db");

$query = "select id,subject as titulo,
   IF(tipo=0,(ifnull((select concat('" . LANG_msg_prefa . "',nombre,' ',apellido) from tbl_admin where id = de),'<b>" . LANG_msg_noadm . "</b>') ),ifnull((select concat('" . LANG_msg_prefs . "',nombre,' ',apellido) from tbl_estudiante where id = de ),'<b>" . LANG_msg_noest . "</b>')) as Remite,
   IF(tipo=0,(select foto from tbl_admin where id = de ),(select foto from tbl_estudiante where id = de )) as foto
  ,date_format(fecha,'" . $_SESSION['DB_FORMATO_DB'] . "') as fecha,leido,content,urgencia,tipo,de from tbl_mensaje_admin where id = '{$_GET['id']}'";

$datos = $ver->simple_db($query);
?>

<html>
    <head> <meta charset="utf-8">
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
                            <td>&nbsp;
                                <table width="100%" border="0" cellspacing="4" cellpadding="3">
                                    <tr>
                                        <td colspan="2" rowspan="3" align="center" class="style3">
                                            <?php
                                            if (empty($datos['foto'])) {
                                                $link = '../../recursos/est/fotos/nofoto.png';
                                            } else {

                                                if ($datos['tipo'] == "0")
                                                    $dir = 'admin';
                                                else
                                                    $dir = 'est';
                                                $link = "../../recursos/$dir/fotos/" . $datos['foto'];
                                            }
                                            ?>
                                            <img style="border:solid 1px" src="<?= $link ?>"></td>
                                        <td colspan="2" class="style3"><span class="style3">
                                                <?= LANG_msg_from ?>
                                            </span></td>
                                        <td width="71%" colspan="2" class="style1"><?= $datos['Remite'] ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="style3"><span class="style3">
                                                <?= LANG_date ?>
                                            </span></td>
                                        <td colspan="2" class="style1"><?= $datos['fecha'] ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="style3"><span class="style3">
                                                <?= LANG_msg_priori ?>
                                            </span></td>
                                        <td colspan="2" class="style1"><?= $datos['urgencia'] ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" class="style3">&nbsp;</td>
                                    </tr>

                                    <tr>
                                        <td width="10%" class="style3"><?= LANG_subjet ?></td>
                                        <td colspan="5" class="style1"><?= $datos['titulo'] ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" class="no_back"><?= $datos['content'] ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="6"><span class="style3">
                                                <input type="button" name="Submit2"  value="<?= LANG_back ?>" onClick="javascript:history.back();">
                                                <input type="button" name="Submit2"  value="<?= LANG_est_mens_reply ?>" onClick="location.replace('responder.php?titulo=<?= $datos['titulo'] ?>&id=<?= $datos['de'] ?>&suj=<?= $datos['Remite'] ?>&tipo=<?= $datos['tipo'] ?>');">
                                            </span></td>
                                    </tr>
                                </table></td>
                        </tr>
                    </table>	</td>
            </tr>
        </table>
    </body>
</html>
<?php
if ($datos['leido'] == 0)
    $ver->query("update tbl_mensaje_admin set leido = 1 where id = '{$_GET['id']}'");

$ver->cerrar();
?>