<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../../css/style_back.css">
    <script type="text/javascript" src="../../js/dyntar.js"></script>
    <script type="text/javascript" src="../../js/jquery/jquery-3.3.1.min.js"></script>
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
                        <form action="" method="post" enctype="multipart/form-data" id="form1" name="form1">
                            <table width="100%" border="0" cellspacing="4" cellpadding="3">
                                <tr>
                                    <td colspan="2"><span class="style3"><?php echo LANG_content_upload2; ?></span></td>
                                </tr>
                                <tr>
                                    <td width="19%" class="style3"><?php echo LANG_content_upload; ?></td>
                                    <td width="81%"><input name="file" type="file" id="file" size="40"></td>
                                </tr>
                                <tr>
                                    <td class="style3"><?php echo LANG_group_desc; ?></td>
                                    <td><textarea name="descripcion" cols="60" rows="4" class="style1"
                                                  id="descripcion"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input id="persona" name="persona" value="<?= $_SESSION['USERID'] ?>"
                                               type="hidden">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">

                                        <input type="button" name="Submit2" value="<?= LANG_back ?>"
                                               onClick="location.replace('index.php')">
                                        <input id="upload" type="submit"  name="upload" value="<?= LANG_save ?>">
                                    </td>
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

<script>
    $("#form1").submit(function (eve) {

        eve.preventDefault();
        var file_data = $("#file").prop("files")[0];   // Getting the properties of file from file field
        var form_data = new FormData();                  // Creating object of FormData class
        form_data.append("file", file_data)              // Appending parameter named file with properties of file_field to form_data
        form_data.append("persona", $("#persona").val())
        form_data.append("descripcion", $("#descripcion").val())
        var url = '<?= api_url ?>class/file';
        $.ajax({
            url: url,
            type: 'post',
            data: form_data,
            cache       : false,
            contentType : false,
            processData : false,
            success: function (data) {
                alert('<?= LANG_cambios ?>');
                location.replace('index.php');
            },
            error: function (error) {
                var msg = error.responseJSON.message;
                alert(msg);
            }
        });
    })
</script>


</html>