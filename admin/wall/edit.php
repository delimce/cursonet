<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);


 $crear = new formulario("db");

	if(isset($_POST['Submit'])){
	
		if($_POST['r-destaca']!=1)$_POST['r-destaca']=0;
	
		$crear->update_data("r","-","cartelera",$_POST,"id = '{$_POST['id']}'");
		
		$crear->redirect("index.php");
	
	}else{
	
		$data = $crear->simple_db("select id,mensaje,grupo_id,destaca from cartelera where id = '{$_REQUEST['id']}'");
	
	}


?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../../css/style_back.css">
<script type="text/javascript" src="../../editor/tiny_mce.js"></script>

		<script language="javascript" type="text/javascript">
	tinyMCE.init({
	mode : "textareas",
	theme : "advanced",
	plugins : "style,layer,table,charmap,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,flash,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable",
	language: "es",
	theme_advanced_buttons1_add_before : "newdocument,preview,separator,cut,copy,paste,undo,redo,separator,bold,italic,underline,separator,justifyleft,justifycenter,justifyright,justifyfull,separator",
	theme_advanced_buttons1 : ",outdent,indent,bullist,numlist,separator,forecolor,backcolor",
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
<table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="26" valign="top"><?php echo $menu->nombre; ?></td>
  </tr>
  <tr>
    <td><?php $menu->mostrar(0); ?></td>
  </tr>
  <tr>
    <td>

	<table style="border-right:#000000 solid 1px; border-left:#000000 solid 1px; border-bottom:#000000 solid 1px;" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
 <form name="form1" method="post" action="edit.php">
  <table width="100%" border="0" cellspacing="4" cellpadding="3">

  <tr>
    <td colspan="2" valign="top" class="style3">&nbsp;</td>
    </tr>
  <tr>
    <td width="27%" valign="top" class="style3"><?php echo LANG_seccion_select ?></td>
    <td width="73%"><?php echo $crear->combo_db("r-grupo_id","(select '".LANG_all."' as nombre, 0 as id)union(select nombre,id from grupo where curso_id = '{$_SESSION['CURSOID']}' order by nombre)","nombre","id",false,$data['grupo_id'],false,LANG_nogroup);  ?>
      <input name="id" type="hidden" id="id" value="<?=$data['id'] ?>"></td>
  </tr>
   <tr>
    <td valign="top" class="style3"><?php echo LANG_wall_desc ?></td>
    <td><input name="r-destaca" type="checkbox" id="r-destaca" value="1" <?php if($data['destaca']==1) echo 'checked'; ?>></td>
  </tr>
  
  <tr>
    <td colspan="2" valign="top" class="style3"><?php echo LANG_wall_message ?></td>
    </tr>
  <tr>
  <td colspan="2" class="style3"><textarea name="r-mensaje" cols="73" rows="10" id="r-mensaje"><?=$data['mensaje'] ?>
  </textarea></td>
  </tr>

  <tr>
  <td colspan="2"><input type="button" name="Submit2"  value="<?=LANG_back?>" onClick="javascript:history.back();">
    <input type="submit" name="Submit" value="<?=LANG_save?>"></td>
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
