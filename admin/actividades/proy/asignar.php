<?php
session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../config/setup.php"); ////////setup
include("../../../class/clases.php"); ////////clase
include("../../../config/lang/{$_SESSION['LENGUAJE']}"); ////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);


$asig = new tools('db');

if (isset($_REQUEST['ItemID'])) {

    $files = $asig->estructura_db("select id,dir,descripcion from tbl_recurso where tipo = 0 and add_by = 'admin'");
    $links = $asig->estructura_db("select id,dir,descripcion from tbl_recurso where tipo = 1 and add_by = 'admin'");
    $arselect = $asig->array_query("select rec_id from tbl_proyecto_recurso where proy_id = '{$_REQUEST['ItemID']}' and tipo = 0"); //archivos
    $linkselect = $asig->array_query("select rec_id from tbl_proyecto_recurso where proy_id = '{$_REQUEST['ItemID']}' and tipo = 1"); //enlaces
}


if (isset($_POST['id'])) {

    $asig->abrir_transaccion(); ////iniciando la transaccion

    $asig->query("delete from tbl_proyecto_recurso where proy_id = '{$_POST['id']}'");

    $valores[0] = $_POST['id'];


    for ($i = 0; $i < count($_POST['archi']); $i++) {
        $valores[1] = $_POST['archi'][$i];
        $valores[2] = 0;
        $asig->insertar2("tbl_proyecto_recurso", "proy_id, rec_id, tipo", $valores);
    }


    for ($j = 0; $j < count($_POST['enlace']); $j++) {

        $valores[1] = $_POST['enlace'][$j];
        $valores[2] = 1;
        $asig->insertar2("tbl_proyecto_recurso", "proy_id, rec_id, tipo", $valores);
    }


    $asig->cerrar_transaccion();

    $asig->javaviso(LANG_cambios, "recursos.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../../../css/style_back.css">
    <script src="../../../js/jquery/jquery-1.7.2.min.js"></script>

    <script>
        // When document is ready: this gets fired before body onload <img src="http://blogs.digitss.com/wp-includes/images/smilies/icon_smile.gif" alt=":)" class="wp-smiley" />
        $(document).ready(function () {
            // Write on keyup event of keyword input element
            $("#kwd_search").keyup(function () {
                // When value of the input is not blank
                if ($(this).val() != "") {
                    // Show only matching TR, hide rest of them
                    $("#recursos tbody>tr").hide();
                    $("#recursos td:contains-ci('" + $(this).val() + "')").parent("tr").show();
                }
                else {
                    // When there is no input or clean again, show everything back
                    $("#recursos tbody>tr").show();
                }
            });
        });
        // jQuery expression for case-insensitive filter
        $.extend($.expr[":"],
            {
                "contains-ci": function (elem, i, match, array) {
                    return (elem.textContent || elem.innerText || $(elem).text() || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
                }
            });

    </script>


</head>

<body>
<table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td height="26" valign="top"><?php echo $menu->nombre; ?></td>
    </tr>
    <tr>
        <td><?php $menu->mostrar(2); ?></td>
    </tr>
    <tr>
        <td>

            <table style="border-right:#000000 solid 1px; border-left:#000000 solid 1px; border-bottom:#000000 solid 1px;"
                   width="100%" border="0" cellspacing="0" cellpadding="0">

                <td>
                    <form name="form1" method="post" action="asignar.php">
                        <div style="padding: 8px; margin-top: 8px; display: inline-block; font-weight: bold">
                            <label for="kwd_search"><?= LANG_search ?></label> <input type="text" id="kwd_search"
                                                                                      value=""/>&nbsp;
                            <input type="button" name="back2" value="<?= LANG_back ?>"
                                   onClick="javascript:history.back();">&nbsp;
                            <input type="submit" name="Submit3" value="<?= LANG_save ?>">&nbsp;
                            <table id="recursos" width="100%" height="104" border="0" cellpadding="3" cellspacing="4"
                                   class="style1">
                        </div>
                        <thead>
                        <tr>
                            <th colspan="2" class="table_bk"><?= LANG_content_files2 ?></th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php
                        for ($i = 0; $i < count($files); $i++) {
                            ?>


                            <tr>
                                <td width="5%" class="style1"><input name="archi[]" type="checkbox" id="archi[]"
                                                                     value="<?= $files[$i]['id'] ?>" <?php if (@in_array($files[$i]['id'], $arselect)) echo 'checked="checked"'; ?>>
                                </td>
                                <td class="style1"><b><?= substr($files[$i]['dir'], 0, 70); ?></b>&nbsp;<br>
                                    <?= $files[$i]['descripcion']; ?></td>
                            </tr>
                            <?php
                        }
                        ?>

                        <thead>
                        <tr>
                            <th colspan="2" class="table_bk"><?= LANG_content_links ?></th>
                        </tr>
                        </thead>

                        <tbody>

                        <?php
                        for ($j = 0; $j < count($links); $j++) {
                            ?>

                            <tr>
                                <td class="style1"><input name="enlace[]" type="checkbox" id="enlace[]"
                                                          value="<?= $links[$j]['id'] ?>" <?php if (@in_array($links[$j]['id'], $linkselect)) echo 'checked="checked"'; ?>>
                                </td>
                                <td class="style1"><b><?= substr($links[$j]['dir'], 0, 70); ?></b>&nbsp; <br>
                                    <?= $links[$j]['descripcion']; ?></td>
                            </tr>

                            <?php
                        }
                        ?>
                        </tbody>

            </table>

            <div>
                <input type="button" name="Submit2" value="<?= LANG_back ?>" onClick="javascript:history.back();">&nbsp;
                <input type="submit" name="Submit" value="<?= LANG_save ?>">&nbsp;
                <input name="id" type="hidden" id="id" value="<?= $_REQUEST['ItemID'] ?>">

            </div>

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
$asig->cerrar();
?>
