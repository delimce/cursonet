<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../config/setup.php"); ////////setup
include("../../../class/clases.php"); ////////clase
include ("../../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);


  $pru = new tools("db");
  $query = " select p.nombre,ifnull((select nombre from tbl_grupo where id = p.grupo),'".LANG_all."') as seccion, enunciado,(select titulo from tbl_contenido where id = p.contenido_id) as caso from tbl_proyecto p where p.id = {$_REQUEST['id']}";

 $datos = $pru->array_query2($query);

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="../../../css/style_back.css">
<script type="text/javascript" src="../../../editor/tiny_mce.js"></script>

<script language="javascript" type="text/javascript">
	tinyMCE.init({
	mode : "textareas",
	theme : "advanced",
	plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",
	theme_advanced_buttons1_add_before : "preview,separator,cut,copy,paste,separator,bold,italic,underline,separator,justifyleft,justifycenter,justifyright,justifyfull,separator",
	theme_advanced_buttons1 : ",outdent,indent,bullist,numlist,separator,charmap,insertdate,inserttime,separator,forecolor,backcolor,separator,help",
	theme_advanced_buttons2 : "",
	plugin_insertdate_dateFormat : "<?=$_SESSION['DB_FORMATO_DB']?> ",
	plugin_insertdate_timeFormat : "%H:%M:%S",
	theme_advanced_buttons3 : "",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	content_css : "example_word.css",
	extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",

        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true
	
	});
	</script>
</head>

<body>
<table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="26" valign="top"> <span class="menu-title"><?= $menu->nombre; ?></span></td>
  </tr>
  <tr>
    <td><?php $menu->mostrar(3); ?></td>
  </tr>
  <tr>
    <td>

	<table style="border-right:#000000 solid 1px; border-left:#000000 solid 1px; border-bottom:#000000 solid 1px;" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><br>
          <table width="100%" border="0" cellspacing="2" cellpadding="2">
            <tr>
            <td valign="top" class="style3"><?php echo LANG_content_name; ?></td>
            <td colspan="2" valign="top" class="style1"><?=$datos[3] ?></td>
          </tr>
            <tr>
              <td width="25%" valign="top" class="style3"><?php echo LANG_seccion; ?></td>
              <td width="75%" colspan="2" valign="top" class="style1"><?=$datos[1] ?></td>
              </tr>
            <tr>
              <td valign="top" class="style3"><?php echo LANG_proy_name; ?></td>
              <td colspan="2" valign="top" class="style1"><?=$datos[0] ?></td>
              </tr>
            <tr>
              <td colspan="3" class="td_whbk2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><span class="style1">
                    <?=LANG_proy_enun ?>
                  </span></td>
                  </tr>
              </table></td>
              </tr>
            
			
            <tr>
              <td colspan="3">
			  <form name="form1" method="post" action="">
                <textarea name="enunciado" cols="80" rows="15" class="style1" id="enunciado"><?=$datos[2]; ?>
		        </textarea>
                </form>                </td>
            </tr>
			  
            <tr>
              <td colspan="3"><input name="b1" type="button" id="b1" onClick="javascript:history.back();"  value="<?=LANG_back?>"></td>
              </tr>
            <tr>
              <td colspan="3">&nbsp;</td>
              </tr>
          </table>
        </td>
      </tr>
    </table>	</td>
  </tr>
</table>
</body>
</html>
<?php
 $pru->cerrar();
?>