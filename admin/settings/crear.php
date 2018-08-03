<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);
include("security.php"); ///seguridad para el admin

$crear = new tools("db");

if (isset($_POST['login12'])) {

    $crear->query("select id from tbl_admin where user = '{$_POST['login12']}'");

    if ($crear->nreg > 0) {

        $aviso = $_POST['login12'] . LANG_VAL_user2;

        $crear->javaviso($aviso);

    } else { ////inserta el estudiante

        $valores2[0] = $_POST['nombre'];
        $valores2[1] = $_POST['apellido'];
        $valores2[2] = trim($_POST['login12']);
        $valores2[3] = md5($_POST['pass1']);
        $valores2[4] = ($_POST['admin']) ?? 0;
        $valores2[5] = $_POST['email'];
        $valores2[6] = $_POST['telefono'];
        $valores2[7] = $_POST['fax'];
        $valores2[8] = date("Y-m-d H:i:s");
        if (count($_POST['curso']) > 0) $valores2[9] = implode(",", $_POST['curso']); else $valores2[9] = 0;
        $valores2[10] = @$_POST['sintesis'];

        $crear->insertar2("tbl_admin", "nombre, apellido, user, pass, es_admin, email, telefono, fax, fecha,cursos,sintesis", $valores2);
        $crear->javaviso(LANG_cambios, "index.php");


    }

} else {


    $cursos = $crear->estructura_db("select id,nombre,alias from tbl_curso");


}


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../../css/style_back.css">
    <script language="JavaScript" type="text/javascript" src="../../js/ajax.js"></script>
    <script language="JavaScript" type="text/javascript" src="../../js/utils.js"></script>
    <script language="JavaScript" type="text/javascript">
        function validar() {


            var login2 = document.form1.login12.value;
            var i;

            if (document.form1.nombre.value == '') {
                alert("<?=LANG_VAL_name?>");
                document.form1.nombre.focus();
                return (false);
            }

            if (document.form1.apellido.value == '') {
                alert("<?=LANG_VAL_lastname?>");
                document.form1.apellido.focus();
                return (false);
            }


            if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(document.form1.email.value) == false) {
                alert("<?=LANG_VAL_email?>");
                document.form1.email.focus();
                return (false);
            }


            if (login2 == '' || login2.indexOf(" ") >= 0) {
                alert("<?=LANG_VAL_login?>");
                document.form1.login12.focus();
                return (false);
            }


            if (document.form1.pass1.value.length < 5) {
                alert("<?=LANG_VAL_pass?>");
                document.form1.pass1.focus();
                return (false);
            }


            if (document.form1.pass1.value != document.form1.pass12.value) {
                alert("<?=LANG_VAL_repass?>");
                document.form1.pass12.focus();
                return (false);
            }

            ////////ajax
            oXML = AJAXCrearObjeto();
            oXML.open('POST', 'validalogin.php');
            oXML.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            oXML.onreadystatechange = function () {
                if (oXML.readyState == 4 && oXML.status == 200) {

                    if (oXML.responseText == "1") {

                        alert('El login ya se encuentra registrado');
                        document.form1.login12.focus();
                        habilitar(document.getElementById('submit3'), '<?=LANG_save?>');
                        return false;

                    } else {

                        document.form1.submit();
                    }
                    vaciar(oXML); ////eliminando objeto ajax
                }


            }

            oXML.send('nombre=' + login2);

            /////////////
        }
    </script>


    <script type="text/javascript" src="../../js/calendario/calendar.js"></script>
    <script type="text/javascript" src="../../js/calendario/calendar-es.js"></script>
    <script type="text/javascript" src="../../js/calendario/calendar-setup.js"></script>
    <script type="text/javascript" src="../../js/popup.js"></script>
    <LINK href="../../js/calendario/calendario.css" type=text/css rel=stylesheet>

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

            <table style="border-right:#000000 solid 1px; border-left:#000000 solid 1px; border-bottom:#000000 solid 1px;"
                   width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td>
                        <form name="form1" method="post" action="crear.php">
                            <table width="100%" border="0" cellspacing="4" cellpadding="3">
                                <tr>
                                    <td colspan="7">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="style3"><?php echo LANG_name ?></td>
                                    <td><input name="nombre" type="text" id="nombre"></td>
                                    <td>&nbsp;</td>
                                    <td colspan="2" class="style3"><?php echo LANG_lastname ?></td>
                                    <td><input name="apellido" type="text" id="apellido"></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="style3"><strong>
                                            <?= LANG_email ?>
                                        </strong></td>
                                    <td width="29%"><input name="email" type="text" id="email" size="25"></td>
                                    <td width="4%">&nbsp;</td>
                                    <td colspan="2" class="style3"><strong>
                                            <?= LANG_phone ?>
                                        </strong></td>
                                    <td width="30%"><input name="telefono" type="text" id="telefono"></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="style3"><strong>
                                            Fax
                                        </strong></td>
                                    <td><input name="fax" type="text" id="fax"></td>
                                    <td colspan="4">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="7" class="table_bk"><strong>
                                            <?php echo LANG_resume ?>
                                        </strong></td>
                                </tr>
                                <tr>
                                    <td colspan="7" class="style3">
        <textarea name="sintesis" cols="80" rows="5" class="style1" id="sintesis">
        </textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="7" class="table_bk"><strong><?php echo LANG_loginfo ?></strong></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="style3"><strong>
                                            <?= LANG_login ?>
                                        </strong></td>
                                    <td><span class="style3"><strong>
      <input name="login12" type="text" id="login12">
    </strong></span></td>
                                    <td>&nbsp;</td>
                                    <td colspan="3" valign="middle" class="small"><?= LANG_be_administrator ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="style3"><strong><strong>
                                                <?= LANG_pass ?>
                                            </strong></strong></td>
                                    <td><span class="style3"><strong><strong>
    <input name="pass1" type="password" id="pass1">
  </strong></strong></span></td>
                                    <td>&nbsp;</td>
                                    <td width="4%" valign="middle" class="style3"><input name="admin" type="checkbox"
                                                                                         id="admin" value="1"></td>
                                    <td width="16%" valign="middle" class="style3"><strong>
                                            <?= LANG_config_admin ?>
                                        </strong></td>
                                    <td valign="middle" class="style3">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="style3"><strong><strong><strong>
                                                    <?= LANG_pass2 ?>
                                                </strong></strong></strong></td>
                                    <td><span class="style3"><strong><strong><strong>
      <input name="pass12" type="password" id="pass12">
    </strong></strong></strong></span></td>
                                    <td>&nbsp;</td>
                                    <td colspan="2" class="style3">&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="7" class="table_bk"><strong>
                                            <?= LANG_ADMIN_cursos ?>
                                        </strong></td>
                                </tr>

                                <?php

                                for ($j = 0; $j < count($cursos); $j++) {

                                    ?>
                                    <tr>
                                        <td width="4%" align="center" valign="top" class="style3"><input name="curso[]"
                                                                                                         type="checkbox"
                                                                                                         value="<?= $cursos[$j]['id'] ?>">
                                        </td>
                                        <td colspan="6">
                                            <span class="style3"><?= $cursos[$j]['nombre'] ?></span> <span
                                                    class="small">
      (<?= $cursos[$j]['alias'] ?>)</span></td>
                                    </tr>

                                    <?php

                                }

                                ?>


                                <tr>
                                    <td colspan="7" class="style3">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="7" align="center" class="style3"><br>
                                        <input type="button" name="Submit2" value="<?= LANG_back ?>"
                                               onClick="javascript:history.back();">
                                        <input type="button" id="submit3" name="Button" value="<?= LANG_save ?>"
                                               onClick="validar();">
                                        <br></td>
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
<?php

$crear->cerrar();

?>
