<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../../config/setup.php"); ////////setup
include("../../../../class/clases.php"); ////////clase
include("../../../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);

$eva = new tools("db");

///niveles de complejidad
$nivel = $eva->llenar_array(LANG_eva_level2 . ',' . LANG_eva_level3 . ',' . LANG_eva_level4);
$nivelv = $eva->llenar_array('1,2,3');


$datos = $eva->simple_db("select eval_id,pregunta,nivel from tbl_evaluacion_pregunta where id = {$_REQUEST['ItemID']} ");
$datos2 = $eva->estructura_db("select opcion,correcta from tbl_pregunta_opcion where preg_id = {$_REQUEST['ItemID']} ");

for ($j = 0; $j < count($datos2); $j++) {

    $datos3[$j] = $datos2[$j]['opcion'];
    if ($datos2[$j]['correcta'] == 1) $_SESSION['CORRECT'] = $j;

}

$_SESSION['OPCIONES'] = $datos3;
$_SESSION['PREGUNTA_ID'] = $_REQUEST['ItemID'];


?>
    <html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="../../../../css/style_back.css">
        <script language="JavaScript" type="text/javascript" src="../../../../js/jquery/jquery-1.7.2.min.js"></script>

        <script language="JavaScript" type="text/javascript">

            function guardar() {

                if (document.form1.evalu.value == "") {

                    alert('<?=LANG_eva_select_exam ?>');
                    document.form1.evalu.focus();
                    return false;
                }

                if (document.form1.enum.value == "") {

                    alert('<?=LANG_eva_put_enum ?>');
                    document.form1.enum.focus();
                    return false;
                }

                var data1 = $('#form1').serialize();
                var data2 = $('#opciones').contents().find('#opciones').serialize();
                var data_fin = data1 + '&' + data2;


                $.ajax({
                    url: 'editarp.php',
                    type: 'post',
                    data: data_fin,
                    success: function (data) {
                        alert('<?=LANG_cambios ?>');
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });



            }

        </script>


    </head>

    <body>

    <table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td height="26" valign="top"> <span class="menu-title"><?= $menu->nombre; ?></span></td>
        </tr>
        <tr>
            <td><?php $menu->mostrar(2); ?></td>
        </tr>
        <tr>
            <td>

                <table style="border-right:#000000 solid 1px; border-left:#000000 solid 1px; border-bottom:#000000 solid 1px;"
                       width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>

                            <form id="form1" name="form1" method="post" action="">
                                <br>
                                <table width="70%" border="0" align="center" cellpadding="4" cellspacing="4">
                                    <tr>
                                        <td colspan="2" class="no_back"><?php echo LANG_eva_createselq ?></td>
                                    </tr>
                                    <tr>
                                        <td width="35%" class="style3"><?php echo LANG_eva_name_sel ?></td>
                                        <td width="65%"
                                            class="small"><?php echo $eva->combo_db("evalu", "select id,nombre from tbl_evaluacion where tipo = 1 AND curso_id = {$_SESSION['CURSOID']}", "nombre", "id", LANG_select, $datos['eval_id'], false, '<input name="eval" type="hidden" value="">' . LANG_eva_noquestions); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="style3"><?php echo LANG_eva_level; ?></td>
                                        <td class="small"><?php echo $eva->combo_array("nivel", $nivel, $nivelv, false, $datos['nivel']); ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="style3"><?php echo LANG_enun ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><textarea name="enum" cols="80" rows="3" class="style1"
                                                                  id="enum"><?php echo $datos['pregunta'] ?></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="184" colspan="2" valign="top">
                                            <table width="100%" border="0" cellspacing="1" cellpadding="0">
                                                <tr>
                                                    <td width="6%" align="right">&nbsp;<a
                                                                href="javascript:opciones.document.opciones.submit();"><img
                                                                    src="../../../../images/backend/box_add.png"
                                                                    width="16" height="16" border="0"></a>&nbsp;
                                                    </td>
                                                    <td width="88%" align="left"><a
                                                                href="javascript:opciones.document.opciones.submit();"><?php echo LANG_eva_addopcion ?></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" align="center">
                                                        <iframe id="opciones" name="opciones" scrolling="no"
                                                                src="opciones.php" align="middle" frameborder="1"
                                                                width="99%" height="189"></iframe>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><input type="button" name="button2" id="button2"
                                                               onClick="location.replace('preg.php');" value="Regresar">
                                            <input type="button" name="Button" id="Submit" value="Guardar"
                                                   onClick="guardar();"></td>
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
<?php $eva->cerrar(); ?>