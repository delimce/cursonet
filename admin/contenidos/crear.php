<?php
session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include("../../config/lang/{$_SESSION['LENGUAJE']}"); ////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);


$crear = new tools('db');


if (isset($_POST['nombre'])) {

    $valores[0] = $_POST['autor'];
    $valores[1] = $_POST['nombre'];
    $valores[2] = $_POST['content'];
    $valores[3] = intval($_POST['borrador']);
    $valores[4] = date("Y-m-d H:i:s");
    $valores[5] = 0;
    $valores[6] = $_SESSION['CURSOID'];

    $crear->insertar2("tbl_contenido", "autor, titulo, contenido, borrador, fecha, leido,curso_id", $valores);

    $crear->javaviso(LANG_cambios, "index.php");
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../../css/style_back.css">
    <script language="JavaScript" type="text/javascript" src="../../js/jquery/jquery-1.7.2.min.js"></script>
    <script language="JavaScript" type="text/javascript" src="../../editor2/tinymce.min.js"></script>
    <script type="text/javascript">
        tinymce.init({
            selector: "textarea.content",
            language: "es",
            images_upload_url: 'postAcceptor.php',
            automatic_uploads: false,
            plugins: [
                "advlist autolink lists link image charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | media"
        });
    </script>


    <script language="JavaScript" type="text/javascript" src="../../js/utils.js"></script>


</head>

<body>
    <table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td height="26" valign="top"> <span class="menu-title"><?= $menu->nombre; ?></span></td>
        </tr>
        <tr>
            <td><?php $menu->mostrar(1); ?></td>
        </tr>
        <tr>
            <td>

                <table style="border-right:#000000 solid 1px; border-left:#000000 solid 1px; border-bottom:#000000 solid 1px;" width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>
                            <form name="form1" method="post" action="crear.php" onSubmit="return validar();">
                                <table width="100%" border="0" cellspacing="4" cellpadding="3">
                                    <tr>
                                        <td colspan="2">&nbsp;</td>
                                    </tr>

                                    <tr>
                                        <td><span class="style3"><?php echo LANG_content_autor ?></span></td>
                                        <td>
                                            <?php

                                            $querya = "SELECT distinct
                                            concat(a.nombre,' ',a.apellido) as nombre,
                                            a.id
                                            from tbl_admin a 
                                            inner join tbl_admin_curso ac on a.id = ac.admin_id
                                            where ac.curso_id = {$_SESSION['CURSOID']}";

                                            if ($_SESSION['PROFILE'] == 'admin')
                                                $querya .= " or (es_admin=1)";

                                            echo $crear->combo_db("autor", $querya, "nombre", "id", false, $_SESSION['USERID']);

                                            ?>
                                        </td>
                                    </tr>


                                    <tr>
                                        <td width="18%" valign="middle" class="style3"><?php echo LANG_content_name ?></td>
                                        <td width="82%"><textarea name="nombre" cols="80" rows="2" id="nombre"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="style3"><textarea class="content" name="content" cols="100" rows="20" id="content"></textarea></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="style3">

                                            <input name="borrador" type="checkbox" id="borrador" value="1">
                                            <?php echo LANG_content_noactive ?></td>
                                    </tr>

                                    <tr>
                                        <td colspan="2"><input type="button" name="Submit2" value="<?= LANG_back ?>" onClick="javascript:history.back();">
                                            <input type="submit" name="Submit" value="<?= LANG_save ?>">
                                            <span class="style1">
                                                <input type="button" name="Submit3" value="<?php echo LANG_content_uploadfiles ?>" onClick="javascript:popup('../recursos/index.php','new',350,500);">
                                            </span></td>
                                    </tr>
                                </table>
                            </form>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <script language="JavaScript" type="text/javascript">
        function validar() {
            if (document.form1.nombre.value == '') {
                alert('<?= LANG_group_error1 ?>');
                document.form1.nombre.focus();
                return false;
            }
            return true;

        }
    </script>
</body>

</html>
<?php

$crear->cerrar();

?>