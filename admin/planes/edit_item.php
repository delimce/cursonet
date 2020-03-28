<?php
session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}"); ////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);

$crear = new tools("db");

$datos = $crear->simple_db("select titulo,tipo,id_act,round(porcentaje,2) as porcentaje ,round(en_base,2) as en_base,plan_id from tbl_plan_item where id = '{$_REQUEST['id']}' ");


////para guardar el id del plan para validacion en iframe.php
$_SESSION['PLANID1'] = $datos['plan_id'];

$tlabel = $crear->llenar_array("Foro,Proyecto,Evaluación,Otro");
$tvalor = $crear->llenar_array("foro,proy,eval,otro");



switch ($datos['tipo']) { ///para saber la actividad
    case 'foro': ///foro
        $query = "select id, titulo as nombre from tbl_foro where curso_id = '{$_SESSION['CURSOID']}' and grupo_id in ({$_SESSION['GRUPOPLAN']},0) order by titulo";
        break;
    case 'proy': //proy
        $query = "select id, nombre from tbl_proyecto where curso_id = '{$_SESSION['CURSOID']}' and (grupo = '{$_SESSION['GRUPOPLAN']}' or grupo = 0) order by nombre";
        break;
    case 'eval':
        $query = "select id, nombre from tbl_evaluacion where curso_id = '{$_SESSION['CURSOID']}' and (grupo_id = '{$_SESSION['GRUPOPLAN']}' or grupo_id = 0) order by nombre";
        break;
}


if ($datos['tipo'] == "otro")
    $activi = '<select name="actividad" id="actividad"><option value="0">' . LANG_select . '</option></select>';
else
    $activi = $crear->combo_db("actividad", $query, "nombre", "id", LANG_select, $datos['id_act']);


if (!empty($_POST['nombre'])) {

    $campos = explode(",", "titulo,tipo,id_act,porcentaje,en_base");

    $valores[0] = $_POST['nombre'];
    $valores[1] = $_POST['tipo'];
    $valores[2] = $_POST['actividad'];
    $valores[3] = $_POST['nota'];
    $valores[4] = $_POST['base'];

    $crear->update("tbl_plan_item", $campos, $valores, "id = '{$_POST['id']}'", true);

    $crear->cerrar();

    $crear->javaviso($aviso, "items.php?id=" . $_SESSION['PLANID1']);
}
?>
<!DOCTYPE html>
<html>
    <head> <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="../../css/style_back.css">

        <script type="text/javascript" src="../../js/jquery/jquery-1.7.2.min.js"></script>
        <script>
            $(document).on("ready", acciones);
            function acciones() {

                $("#tipo").change(function()
                {
                    var tipo = $(this).val();

                    if (tipo != "otro" && tipo != "") {

                        $("#acc").show();
                    } else {
                        $("#acc").hide();
                        return false;
                    }

                    var dataString = "tipo=" + tipo;
                    $.ajax
                            ({
                                type: "POST",
                                url: "iframe.php",
                                data: dataString,
                                cache: false,
                                success: function(html)
                                {
                                    $("#actividad").html(html);
                                }
                            });

                });


            }

        </script>

        <script language="JavaScript" type="text/javascript">


            function validar() {

                if (document.form1.nombre.value == '') {

                    alert('<?= LANG_planes_val_namei ?>');
                    document.form1.nombre.focus();

                    return false;

                }


                if (document.form1.tipo.value == '') {

                    alert('<?= LANG_planes_val_tipo ?>');
                    document.form1.tipo.focus();

                    return false;

                }


                if (document.form1.actividad.value == 0 && document.form1.tipo.value != "otro") {

                    alert('<?= LANG_planes_val_acc ?>');

                    return false;

                }


                if (isNaN(document.form1.nota.value) == true || Number(document.form1.nota.value) <= 0 || document.form1.nota.value == "") {

                    alert('<?= LANG_eva_cal_value ?>');
                    document.form1.nota.focus();

                    return false;

                }


                if (isNaN(document.form1.base.value) == true || Number(document.form1.base.value) <= 0 || document.form1.base.value == "") {

                    alert('<?= LANG_planes_val_base ?>');
                    document.form1.base.focus();

                    return false;

                }



                return true;

            }
        </script>


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
                            <td>
                                <br>

                                <form action="" method="post" name="form1" onSubmit="return validar();">

                                    <table width="100%" height="300px" border="0" cellspacing="4" cellpadding="3">
                                        <tr>
                                            <td colspan="2" class="td_whbk2"><?php echo LANG_planes_edititem ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="style1">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td class="style3"><?php echo LANG_planes_item_name ?></td>
                                            <td width="72%"><input name="nombre" type="text" id="nombre" value="<?= $datos['titulo'] ?>" size="60"></td>
                                        </tr>
                                        <tr>
                                            <td width="28%" class="style3"><?php echo LANG_planes_item_type ?></td>
                                            <td><?php echo $crear->combo_array("tipo", $tlabel, $tvalor, LANG_select, $datos['tipo']); ?>&nbsp;</td>
                                        </tr>
                                        <tr id="acc" <?php if ($datos['tipo'] == "otro") { ?>style="display:none" <?php } ?>>
                                            <td class="style3"><?php echo LANG_planes_act ?></td>
                                            <td>

                                                <div id ="acc">
                                                    <?php echo $activi; ?>
                                                </div> 

                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="style3"><?php echo LANG_foro_por ?></td>
                                            <td><input name="nota" type="text" id="nota" size="5" maxlength="5" value="<?= $datos['porcentaje'] ?>" >
                                                % <span class="small">(<?php echo LANG_planes_por ?>)</span></td>
                                        </tr>
                                        <tr>
                                            <td class="style3"><?php echo LANG_planes_base ?></td>
                                            <td><input name="base" type="text" id="base" size="5" value="<?= $datos['en_base'] ?>"  maxlength="5">&nbsp;<span class="small">(<?php echo LANG_planes_enbase ?>)</span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" align="center" valign="top" class="style3"><input name="id" type="hidden" id="id" value="<?php echo $_REQUEST['id']; ?>"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><input type="button" name="Submit2" onClick="history.back()" value="<?= LANG_back ?>">
                                                <input type="submit" name="Submit" value="<?= LANG_save ?>"></td>
                                        </tr>
                                    </table>

                                </form>

                            </td>
                        </tr>
                    </table>

                </td>
            </tr>
        </table>
    </body>
</html>
<?php $crear->cerrar(); ?>
