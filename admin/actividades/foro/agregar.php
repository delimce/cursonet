<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../config/setup.php"); ////////setup
include("../../../class/clases.php"); ////////clase
include ("../../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);

$crear = new tools();
$crear->autoconexion();

 $horario = $crear->simple_db("select timezone from tbl_setup ");
 // @date_default_timezone_set($horario);

        if(isset($_REQUEST['foro']))$_SESSION['tema_id'] = $_REQUEST['foro'];


        if(isset($_POST['Submit'])){

    
        $valores[0] = $_SESSION['tema_id'];
        $valores[1] = 'admin';
        $valores[2] = $_SESSION['USERID'];
        $valores[3] = $_POST['comentario'];
        $valores[4] = date("Y-m-d H:i:s");
        $valores[5] = 1;

          $crear->insertar2("foro_comentario","foro_id, tipo_sujeto, sujeto_id, content, fecha_post,valido",$valores);
          $crear->javaviso(LANG_foro_com_created,"comentario.php");


        }else{

                $titulo = $crear->array_query("select titulo from foro where id = '{$_SESSION['tema_id']}'");
        }

?>

<html>
<head>

<script language="JavaScript" type="text/javascript">
        function validar(){




           tinyMCE.execCommand("mceCleanup");
           tinyMCE.triggerSave();
          if (tinyMCE.getContent() == "" || tinyMCE.getContent() == null) {

             alert('<?=LANG_foro_val_co ?>');
             document.form1.comentario.focus();

             return false;

         }


                return true;


        }
</script>



<link rel="stylesheet" type="text/css" href="../../../css/style_back.css">
<script type="text/javascript" src="../../../editor/tiny_mce.js"></script>

<script language="javascript" type="text/javascript">
        tinyMCE.init({
        mode : "textareas",
        theme : "advanced",
        plugins : "style,layer,table,charmap,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,flash,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable",
        language: "es",
        theme_advanced_buttons1_add_before : "preview,separator,cut,copy,paste,undo,redo,separator,bold,italic,underline,separator,justifyleft,justifycenter,justifyright,justifyfull,separator",
        theme_advanced_buttons1 : ",outdent,indent,separator,charmap,insertdate,inserttime,separator,forecolor,backcolor,separator,help",
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

<form name="form1" method="post" action="<?=$PHP_SELF ?>" onSubmit="return validar();">

<table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="26" valign="top"><?php echo $menu->nombre; ?></td>
  </tr>
  <tr>
    <td><?php $menu->mostrar(2); ?></td>
  </tr>
  <tr>
    <td>

        <table style="border-right:#000000 solid 1px; border-left:#000000 solid 1px; border-bottom:#000000 solid 1px;" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>

                <table width="100%" border="0" cellpadding="3" cellspacing="4">
          <tr>
            <td width="21%" class="style3"><?=LANG_foro_name ?></td>
            <td width="79%" height="10" colspan="2" class="style1">
              <?=$titulo[0]; ?></td>
          </tr>

          <tr>
            <td colspan="3"><span class="style3">
              <?= LANG_foro_add ?>
            </span></td>
            </tr>
          <tr>
            <td colspan="3"><span class="style3">
              <textarea name="comentario" cols="96" rows="9" class="style1" id="comentario"></textarea>
            </span></td>
          </tr>
          <tr>
            <td colspan="3"><input name="b1" type="button" id="b1" onClick="javascript:history.back();"  value="<?=LANG_back?>">
              &nbsp;
              <input type="submit" name="Submit" value="<?=LANG_save?>"></td>
            </tr>
        </table>
          <br>&nbsp;


          </td>
      </tr>
    </table></td>
  </tr>
</table>

 </form>


</body>
</html>

<?


?>