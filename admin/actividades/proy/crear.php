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


if ($_POST['nombre']) {

    $valores[0] = $_POST['nombre'];
    $valores[1] = $_SESSION['USERID'];
    $valores[2] = $_POST['grupo'];
    $valores[3] = $_POST['enun'];
    $valores[4] = $fecha->fecha_db($_POST['fecha']);
    $valores[5] = date("Y-m-d H:i:s");
    $valores[6] = $_POST['nota'];
    $valores[7] = $_POST['caso'];
    $valores[8] = $_SESSION['CURSOID'];

    $crear->insertar2("tbl_proyecto", "nombre,autor,grupo,enunciado,fecha_entrega,fecha_edit,nota,contenido_id,curso_id", $valores);
    if ($_POST['grupo'] == '')
        $todos = 1; ///si el contenido es para todos


    $crear->javaviso(LANG_cambios, "index.php");
}
?>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="../../../css/style_back.css">
        <link rel="stylesheet" type="text/css" href="../../../css/jquery-ui.min.css">
        <link rel="stylesheet" type="text/css" href="../../../js/calendario/calendario.css"  >

        <script type="text/javascript" src="../../../js/calendario/calendar.js"></script>
        <script type="text/javascript" src="../../../js/calendario/calendar-es.js"></script>
        <script type="text/javascript" src="../../../js/calendario/calendar-setup.js"></script>
        <script type="text/javascript" src="../../../js/popup.js"></script>
        <script type="text/javascript" src="../../../editor/tiny_mce.js"></script>
        <script type="text/javascript" src="../../../js/jquery/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="../../../js/jquery/jquery-ui.min.js"></script>
        <script language="JavaScript" type="text/javascript" src="../../../js/date.js"></script>



        <script>
            $(document).ready(function () {

                ///creando el select dinamicamente
                $("#caso").change(function ()
                {
                    var id = $(this).val();
                    var dataString = 'id=' + id;
                    if (id == "") {
                        $("#grupo").html('<option value="0"><?= LANG_all ?></option>');
                        return false;
                    }

                    $.ajax
                            ({
                                type: "POST",
                                url: "../../grupos/gruposc2.php",
                                data: dataString,
                                cache: false,
                                success: function (html)
                                {
                                    $("#grupo").html(html);
                                }
                            });

                });


            });
        </script>


        <script language="JavaScript" type="text/javascript">


            function compara_fechas(desde, hasta) {

                var formaty = '<?= str_replace("m", "M", strtolower($_SESSION['DB_FORMATO'])); ?>';

                return compareDates(desde, formaty, hasta, formaty);



            }


            function validar() {

                if (document.form1.nombre.value == '') {

                    alert('<?= LANG_val_proy_name ?>');
                    document.form1.nombre.focus();

                    return false;

                }


                if (document.form1.caso.value == '') {

                    alert('<?= LANG_content_create2 ?>');
                    return false;

                }


                if (compara_fechas('<?= date($_SESSION['DB_FORMATO']); ?>', document.form1.fecha.value) == 1) {

                    alert('<? echo LANG_eva_val_fecha2 . ' ' . date($_SESSION['DB_FORMATO']); ?>');
                    document.form1.fecha.focus();

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

                    alert('<?= LANG_val_proy_enun ?>');
                    document.form1.enun.focus();

                    return false;

                }



                return true;

            }
        </script>



        <script language="JavaScript">
<!--

            function popup(mylink, windowname, alto1, largo1)
            {
                var alto = alto1;
                var largo = largo1;
                var winleft = (screen.width - largo) / 2;
                var winUp = (screen.height - alto) / 2;


                if (!window.focus)
                    return true;
                var href;
                if (typeof (mylink) == 'string')
                    href = mylink;
                else
                    href = mylink.href;
                window.open(href, windowname, 'top=' + winUp + ',left=' + winleft + '+,toolbar=0 status=1,resizable=0,Width=' + largo + ',height=' + alto + ',scrollbars=1');

                return false;

            }

//-->
        </script>

        <script language="javascript" type="text/javascript">
            tinyMCE.init({
                mode: "textareas",
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
                            <td><form name="form1" method="post" action="<?= $PHP_SELF ?>" onSubmit="return validar();">
                                    <table width="100%" border="0" cellspacing="4" cellpadding="3">
                                        <tr>
                                            <td colspan="2">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td valign="top" class="style3"><?php echo LANG_proy_name ?></td>
                                            <td width="73%"><input name="nombre" type="text" id="nombre" value="" size="50"></td>
                                        </tr>
                                        <tr>
                                            <td valign="top" class="style1"><span class="style3"><?php echo LANG_content_name; ?></span></td>
                                            <td class="style1" colspan="2"><? echo $crear->combo_db("caso", "select id,IF(LENGTH(titulo)>60,concat(SUBSTRING(titulo,1,50),'...'),titulo) as titulo from tbl_contenido where curso_id = {$_SESSION['CURSOID']} and borrador = 0", "titulo", "id", LANG_select, false); ?></td>
                                        </tr>
                                        <tr>
                                            <td width="27%" valign="top" class="style1"><span class="style3"><?php echo LANG_seccion ?></span></td>
                                            <td class="style1"><select name="grupo" id="grupo"><option value="0"><?= LANG_select ?></option></select></td>
                                        </tr>
                                        <tr>
                                            <td valign="top" class="style1"><span class="style3"><?php echo LANG_proy_date_e ?></span></td>
                                            <td class="style1">

                                                <input name="fecha" type="text" id="fecha" OnFocus="this.blur()" onClick="alert('<?= LANG_calendar_use ?>')" value="<? echo date($_SESSION['DB_FORMATO']); ?>" size="12">
                                                <img src="../../../images/frontend/cal.gif" name="f_trigger_d" width="16" height="16" id="f_trigger_d" style="cursor: hand; border: 0px;" title="<?= LANG_calendar ?>">
                                                <script type="text/javascript">
                                                    Calendar.setup({
                                                        inputField: "fecha", // id of the input field
                                                        ifFormat: "<?= strtolower($_SESSION['DB_FORMATO']) ?>", // format of the input field
                                                        button: "f_trigger_d", // trigger for the calendar (button ID)
                                                        singleClick: true
                                                    });
                                                </script>        </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" class="style1"><span class="style3"><?php echo LANG_proy_porc ?></span></td>
                                            <td class="style1">

                                                <input name="nota" type="text" id="nota" value="<?= $_SESSION['eva_nota'] ?>" size="5" maxlength="5">
                                                <span class="bold"><span class="small">%</span> </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" valign="top" class="style1"><span class="style3"><?php echo LANG_proy_enun ?></span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" align="center"><textarea name="enun" cols="80" rows="15" class="style1" id="enun"></textarea>  </td>
                                        </tr>

                                        <tr>
                                            <td colspan="2"><input type="button" name="Submit2" onClick="history.back();" value="<?= LANG_back ?>">
                                                <input type="submit" name="Submit" value="<?= LANG_save ?>">
                                                <span class="style1">
                                                    <input type="button" name="Submit3" id="Submit3" value="<?php echo LANG_content_files ?>" onClick="javascript:popup('../../recursos/index.php', 'new', 350, 500);">
                                                </span><span class="style1">
                                                    <input type="button" name="Submit32" value="<?php echo LANG_eva_ver_detalles ?>" onClick="javascript:popup('detalles.php', 'new', 450, 616);">
                                                </span></td>
                                        </tr>
                                    </table>
                                </form></td>
                        </tr>
                    </table>        </td>
            </tr>
        </table>


        <div id="dev" style="background-color: #fff">

        </div>


    </body>
</html>
<?php
$crear->cerrar();
?>