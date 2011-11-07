<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../config/setup.php"); ////////setup
include("../../../class/clases.php"); ////////clase
include ("../../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

$tool = new tools("db");

        if(isset($_REQUEST['id'])){ $com = $tool->array_query("select content from tbl_foro_comentario where id = '{$_REQUEST['id']}'");

        }else{

        $comentario = mysql_escape_string($_POST['comm']);

        $tool->query("update tbl_foro_comentario set content = '$comentario' where id = {$_POST['id2']} ");

        ?>

        <script language="JavaScript" type="text/javascript">
                window.opener.location.reload();
                window.close();
        </script>

        <?


        }

?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../../../css/style_back.css">
<script type="text/javascript" src="../../../editor/tiny_mce.js"></script>

<script language="javascript" type="text/javascript">
        tinyMCE.init({
        mode : "textareas",
        theme : "advanced",
        plugins : "style,layer,table,charmap,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,flash,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable",
        language: "es",
        theme_advanced_buttons1_add_before : "preview,separator,cut,copy,paste,undo,redo,separator,bold,italic,underline,separator,justifyleft,justifycenter,justifyright,justifyfull,separator",
        theme_advanced_buttons1 : ",outdent,indent,bullist,numlist,separator,charmap,insertdate,inserttime,separator,forecolor,backcolor,separator,help",
        theme_advanced_buttons2 : "",
        plugin_insertdate_dateFormat : "<?=$_SESSION['DB_FORMATO_DB']?> ",
        plugin_insertdate_timeFormat : "%H:%M:%S",
        theme_advanced_buttons3 : "",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        content_css : "example_word.css",
        extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]"


});
</script>
</head>

<body>
<form name="form1" method="post" action="editcoment.php">
  <table width="100%" border="0" cellspacing="3" cellpadding="2">
    <tr>
      <td class="style3"><?php echo LANG_foro_edit_comment ?>
      <input name="id2" type="hidden" id="id2" value="<?=$_REQUEST['id'] ?>"></td>
    </tr>
    <tr>
      <td align="center"><textarea name="comm" cols="96" rows="9" class="style3" id="comm"><?php echo $com[0]; ?></textarea></td>
    </tr>
    <tr>
      <td><input type="button" name="Submit2" value="<?=LANG_close?>" onClick="window.close();">
      <input type="submit" name="Submit" value="<?=LANG_save?>"></td>
    </tr>
  </table>
</form>


</body>
</html>
<?

$tool->cerrar();

?>