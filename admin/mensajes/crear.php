<?php
session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}"); ////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);


$crear = new tools("db");
$prioridad = $crear->llenar_array(LANG_msg_priority_l . "," . LANG_msg_priority_n . "," . LANG_msg_priority_h);
?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../../css/style_back.css">
        <script type="text/javascript" src="../../editor/tiny_mce.js"></script>
        <script type="text/javascript" src="../../js/jquery/jquery-1.7.2.min.js"></script>
        <script>
            $(document).ready(function() {


                $("#destinatario").hide();
                $("#seccion").hide();

                $("input[name=destino]:radio").change(function() {
                    var id = $(this).val();
                    var dataString = 'tipo=' + id;
                    if (id == "") {
                        $("#persona").html('<option value="0"><?= LANG_all ?></option>');
                        return false;
                    }

                    if (id == 1) {
                        $("#seccion").show();
                        $("#destinatario").show();
                    } else if (id == 0) {
                        $("#seccion").hide();
                        $("#destinatario").show();

                    } else {
                        $("#seccion").show();
                        $("#destinatario").hide();
                    }

                    $.ajax
                            ({
                                type: "POST",
                                url: "iframe.php",
                                data: dataString,
                                cache: false,
                                success: function(html)
                                {
                                    $("#persona").html(html);
                                }
                            });

                });


                ///creando el select dinamicamente
                $("#secc").change(function()
                {
                    var tipo = 1
                    var grupo = $(this).val();
                    var dataString = 'grupo=' + grupo + "&tipo=" + tipo;
                    $.ajax
                            ({
                                type: "POST",
                                url: "iframe.php",
                                data: dataString,
                                cache: false,
                                success: function(html)
                                {
                                    $("#persona").html(html);
                                }
                            });

                });


            });
        </script>


        <script language="JavaScript" type="text/javascript">
            function validar() {

                if ($("#persona").val() == 0 && $('input:radio[name=destino]:checked').val() != 2) {

                    alert("<?= LANG_select_person ?>");
                    return false;
                }

                if (document.form1.titulo.value == '') {

                    alert("<?= LANG_select_subject ?>");
                    document.form1.titulo.focus();
                    return false;
                }

                return true;

            }
        </script>



        <script language="javascript" type="text/javascript">
            tinyMCE.init({
                mode: "textareas",
                theme: "advanced",
                plugins: "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",
                theme_advanced_buttons1_add_before: "newdocument,preview,separator,cut,copy,paste,undo,redo,separator,bold,italic,underline,separator,justifyleft,justifycenter,justifyright,justifyfull,separator",
                theme_advanced_buttons1: ",outdent,indent,bullist,numlist,separator,forecolor,backcolor",
                theme_advanced_buttons2: "",
                plugin_insertdate_dateFormat: "<?= $_SESSION['DB_FORMATO_DB'] ?> ",
                plugin_insertdate_timeFormat: "%H:%M:%S",
                theme_advanced_toolbar_location: "top",
                theme_advanced_toolbar_align: "left",
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
                            <td><form name="form1" method="post" action="flow.php" onSubmit="return validar();">
                                    <table width="100%" border="0" cellspacing="4" cellpadding="3">

                                        <tr>
                                            <td valign="top" class="style3"><?php echo LANG_msg_to ?></td>
                                            <td width="77%">
                                                <input name="destino" id="destino" type="radio" value="0">
                                                <?= LANG_ADMIN_teacher ?>
                                                <input name="destino" id="destino" type="radio" value="1">
                                                <?= LANG_student ?>
                                                <input name="destino" id="destino" type="radio" value="2">
                                                <?= LANG_group ?>
                                            </td>
                                        </tr>


                                        <tr id="seccion">
                                            <td class="style3"> <?php echo LANG_seccion_select ?></td>
                                            <td>
                                                <?php echo $crear->combo_db("secc", "select nombre,id from tbl_grupo where curso_id = '{$_SESSION['CURSOID']}' order by nombre", "nombre", "id", LANG_all, false, false, LANG_nogroup); ?>
                                            </td>
                                        </tr>

                                        <tr id="destinatario">
                                            <td valign="top" class="style3"><?php echo LANG_person ?></td>
                                            <td>
                                                <select name="persona" id="persona"><option value="0"><?= LANG_all ?></option></select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="23%" valign="top" class="style1"><span class="style3"><?php echo LANG_subjet ?></span></td>
                                            <td class="style1"><input name="titulo" type="text" id="titulo" value="" size="55">      <? echo $crear->combo_array("priori", $prioridad, $prioridad, false, LANG_msg_priority_n); ?>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="style3"><textarea name="content" cols="70" rows="10" id="content"></textarea></td>
                                        </tr>

                                        <tr>
                                            <td colspan="2">
                                                <input type="submit" name="Submit" value="<?= LANG_msg_send ?>">   </td>
                                        </tr>
                                    </table>
                                </form></td>
                        </tr>
                    </table>	</td>
            </tr>
        </table>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
    </body>
</html>
<?php
$crear->cerrar();
?>
