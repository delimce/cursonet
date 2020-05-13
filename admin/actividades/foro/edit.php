<?php
session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../config/setup.php"); ////////setup
include("../../../class/clases.php"); ////////clase
include ("../../../config/lang/{$_SESSION['LENGUAJE']}"); ////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);


$crear = new tools("db");
$fecha = new fecha($_SESSION['DB_FORMATO']);


if (isset($_POST['nombre'])) {

    /////////TODO: tinymce no funciona en chrome (no guarda)

    $campos = explode(",", "titulo, contenido_id, grupo_id, equipo_id, content, fecha_post, fecha_fin, nota");
    $valores[0] = $_POST['nombre'];
    $valores[1] = $_POST['caso'];
    $valores[2] = $_POST['seccion'];
    $valores[3] = $_POST['equipo'];
    $valores[4] = $_POST['content1'];
    $valores[5] = $_POST['inicio'];
    $valores[6] = $_POST['fin'];
    $valores[7] = $_POST['nota'];

    $crear->update("tbl_foro", $campos, $valores, "id = {$_POST['id']}");
    $crear->javaviso(LANG_cambios, "index.php");
} else {


    $datos = $crear->simple_db("select id, titulo, grupo_id, equipo_id, contenido_id, date(fecha_post) as fecha_post, date(fecha_fin) as fecha_fin, nota, resumen, content from tbl_foro where id = '{$_GET['ItemID']}'");
}
?>
<!DOCTYPE html>
<html>
    <head> <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="../../../css/style_back.css">
        <script type="text/javascript" src="../../../editor/tiny_mce.js"></script>
        <script type="text/javascript" src="../../../js/jquery/jquery-1.7.2.min.js"></script>
        
         <script>
            $(document).ready(function() {

                ///creando el select dinamicamente
                $("#caso").change(function()
                {
                    var id = $(this).val();
                    var dataString = 'id=' + id;
                    if (id == "") {
                        $("#seccion").html('<option value="0"><?=LANG_all?></option>');
                        $("#equipo").html('<option value="0"><?=LANG_all?></option>');
                        return false;
                    }

                    $.ajax
                            ({
                                type: "POST",
                                url: "../../grupos/gruposc2.php",
                                data: dataString,
                                cache: false,
                                success: function(html)
                                {
                                    $("#seccion").html(html);
                                    $("#equipo").html('<option value="0"><?=LANG_all?></option>');
                                }
                            });

                });





                 ///creando el select dinamicamente
                $("#seccion").change(function()
                {
                    var id = $(this).val();
                    var dataString = 'id=' + id;
                    if (id == "") {
                        $("#equipo").html('<option value="0"><?=LANG_all?></option>');
                        return false;
                    }

                    $.ajax
                            ({
                                type: "POST",
                                url: "../../grupos/equiposc.php",
                                data: dataString,
                                cache: false,
                                success: function(html)
                                {
                                    $("#equipo").html(html);
                                }
                            });

                });


            });
        </script>
        
        <script language="javascript" type="text/javascript">
            tinyMCE.init({
                mode: "exact",
                elements: "content1",
                theme: "advanced",
                plugins: "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",
                theme_advanced_buttons1_add_before: "preview,separator,cut,copy,paste,separator,bold,italic,underline,separator,justifyleft,justifycenter,justifyright,justifyfull,separator",
                theme_advanced_buttons1: ",outdent,indent,bullist,numlist,separator,charmap,insertdate,inserttime,separator,forecolor,backcolor,separator,help",
                theme_advanced_buttons2: "",
                plugin_insertdate_dateFormat: "<?= $_SESSION['DB_FORMATO_DB'] ?> ",
                plugin_insertdate_timeFormat: "%H:%M:%S",
                theme_advanced_buttons3: "",
                theme_advanced_toolbar_location: "top",
                theme_advanced_toolbar_align: "left",
                content_css: "example_word.css",
                extended_valid_elements: "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
                theme_advanced_toolbar_location : "top",
                        theme_advanced_toolbar_align : "left",
                        theme_advanced_statusbar_location: "bottom",
                theme_advanced_resizing: true

            });
        </script>


        <script language="JavaScript" type="text/javascript">


            function compara_fechas(desde, hasta) {

                var formaty = '<?= str_replace("m", "M", strtolower($_SESSION['DB_FORMATO'])); ?>';

                return compareDates(desde, formaty, hasta, formaty);

            }

            function validar() {

                if (document.form1.nombre.value == '') {

                    alert('<?= LANG_eva_val_nombre ?>');
                    document.form1.nombre.focus();

                    return false;

                }


                if (document.form1.caso.value == '') {

                    alert('<?= LANG_foro_val_caso ?>');
                    document.form1.caso.focus();

                    return false;

                }

   
                if (compareDates2(document.form1.inicio.value, document.form1.fin.value) == 1) {
                    alert('<?php echo LANG_eva_val_fecha2 ?> ' + document.form1.inicio.value);
                    document.form1.fin.focus();
                    return false;

                }


                if (isNaN(document.form1.nota.value) || document.form1.nota.value > 100 || document.form1.nota.value < 0 || document.form1.nota.value == '') {
                    alert('<?= LANG_eva_val_por ?>');
                    document.form1.nota.focus();
                    return false;

                }



                tinyMCE.execCommand("mceCleanup");
                tinyMCE.triggerSave();
                if (tinyMCE.getContent() == "" || tinyMCE.getContent() == null) {

                    alert('<?= LANG_foro_val_content ?>');
                    document.form1.content.focus();

                    return false;

                }





                return true;

            }
        </script>



        <script type="text/javascript" src="../../../js/calendario/calendar.js"></script>
        <script type="text/javascript" src="../../../js/calendario/calendar-es.js"></script>
        <script type="text/javascript" src="../../../js/calendario/calendar-setup.js"></script>
        <script type="text/javascript" src="../../../js/popup.js"></script>
        <script language="JavaScript" type="text/javascript" src="../../../js/date.js"></script>
        <script language="JavaScript" type="text/javascript" src="../../../js/ajax.js"></script>
        <LINK href="../../../js/calendario/calendario.css" type=text/css rel=stylesheet>

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
                            <td><form name="form1" method="post" action="edit.php" onSubmit="return validar();">
                                    <br>
                                    <table width="100%" border="0" cellspacing="4" cellpadding="3">

                                        <tr>
                                            <td class="style3"><?php echo LANG_foro_name ?></td>
                                            <td width="72%"><input name="nombre" type="text" id="nombre" value="<?= $datos['titulo'] ?>" size="45"></td>
                                        </tr>
                                        <tr>

                                            <td width="28%" class="style3"><?php echo LANG_content_name; ?></td>
                                            <td><?php echo $crear->combo_db("caso", "select id,IF(LENGTH(titulo)>60,concat(SUBSTRING(titulo,1,50),'...'),titulo) as titulo from tbl_contenido where curso_id = '{$_SESSION['CURSOID']}' and borrador = 0 ", "titulo", "id", false, $datos['contenido_id']); ?></td>
                                        </tr>
                                        <tr>
                                            <td class="style3"><?php echo LANG_group_nombre; ?></td>
                                            <td>
                                                <?php echo $crear->combo_db("seccion", "select id, nombre from tbl_grupo where curso_id = {$_SESSION['CURSOID']} ", "nombre", "id", LANG_all, $datos['grupo_id']); ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="style3"><?php echo LANG_team_name; ?></td>
                                            <td>
                                              <?php echo $crear->combo_db("equipo", "select id, nombre from tbl_equipo where grupo_id = {$datos['grupo_id']} ", "nombre", "id", LANG_all, $datos['equipo_id'],false,'<select name="equipo" id="equipo"><option value="0">'.LANG_all.'</option></select>'); ?>
                                            </td>
                                        </tr>


                                        <tr>
                                            <td class="style3"><?php echo LANG_foro_date1; ?></td>
                                            <td>
                                                <input name="inicio" type="date" id="inicio" value="<?=$datos['fecha_post'] ?>" size="12">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="style3"><?php echo LANG_foro_date2; ?></td>
                                            <td>
                                                <input name="fin" type="date" id="fin" value="<?=$datos['fecha_fin'] ?>" size="12">
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="style3"><?php echo LANG_foro_por ?></td>
                                            <td><input name="nota" type="text" id="nota" value="<?= $datos['nota'] ?>" size="5" maxlength="5">
                                                <span class="bold">%
                                                    <input name="id" type="hidden" id="id" value="<?= $datos['id'] ?>">
                                                </span></td>
                                        </tr>


                                        <tr>
                                            <td colspan="2" class="td_whbk2"><b><?php echo LANG_foro_contenido ?></b></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="style3">
                                                <textarea name="content1" cols="80" rows="15" class="style1" id="content1">
                                                    <?php echo $datos['content'] ?>
                                                </textarea></td>
                                        </tr>

                                        <tr>
                                            <td colspan="2"><input type="button" name="Submit2" onClick="history.back();" value="<?= LANG_back ?>">
                                                <input type="submit" name="Submit" value="<?= LANG_save ?>"></td>
                                        </tr>
                                    </table>
                                </form>
                                <p>&nbsp;</p>
                            </td>
                        </tr>
                    </table>	</td>
            </tr>
        </table>
    </body>
</html>
<?php
$crear->cerrar();
?>