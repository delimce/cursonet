<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);


 $crear = new formulario("db");

	if(isset($_POST['Submit'])){
	
		$_POST['r-fecha_c']  = @date("Y-m-d H:i:s");
		$_POST['r-curso_id'] =  $_SESSION['CURSOID'];
	
		$crear->insert_data("r","-","tbl_cartelera",$_POST);
		
		$crear->javaviso(LANG_wall_created,"index.php");
	
	}


?>
<html>
<head> <meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="../../css/style_back.css">
<script type="text/javascript" src="../../editor/tiny_mce.js"></script>

		<script language="javascript" type="text/javascript">
	tinyMCE.init({
	mode : "textareas",
	theme : "advanced",
	plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",
	theme_advanced_buttons1_add_before : "newdocument,preview,separator,cut,copy,paste,undo,redo,separator,bold,italic,underline,separator,justifyleft,justifycenter,justifyright,justifyfull,separator",
	theme_advanced_buttons1 : ",link,unlink,outdent,indent,bullist,numlist,separator,forecolor,backcolor",
	theme_advanced_buttons2 : "",
	plugin_insertdate_dateFormat : "<?=$_SESSION['DB_FORMATO_DB']?> ",
	plugin_insertdate_timeFormat : "%H:%M:%S",
	theme_advanced_buttons3 : "",
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
    <td height="26" valign="top"><?php echo $menu->nombre; ?></td>
  </tr>
  <tr>
    <td><?php $menu->mostrar(1); ?></td>
  </tr>
  <tr>
    <td>

	<table style="border-right:#000000 solid 1px; border-left:#000000 solid 1px; border-bottom:#000000 solid 1px;" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
 <form name="form1" method="post" action="crear.php">
  <table width="100%" border="0" cellspacing="4" cellpadding="3">

  <tr>
    <td colspan="2" valign="top" class="style3">&nbsp;</td>
    </tr>
  <tr>
    <td width="29%" valign="top" class="style3"><?php echo LANG_seccion_select ?></td>
    <td width="71%"><?php echo $crear->combo_db("r-grupo_id","(select '".LANG_all."' as nombre, 0 as id)union(select nombre,id from tbl_grupo where curso_id = '{$_SESSION['CURSOID']}' order by nombre)","nombre","id",false,false,false,LANG_nogroup);  ?></td>
  </tr>
  <tr>
    <td valign="top" class="style3"><?php echo LANG_wall_desc ?></td>
    <td><input name="r-destaca" type="checkbox" id="r-destaca" value="1" checked></td>
  </tr>
  <tr>
    <td colspan="2" valign="top" class="style3"><?php echo LANG_wall_message ?></td>
    </tr>
  <tr>
  <td colspan="2" class="style3"><textarea name="r-mensaje" cols="73" rows="15" id="r-mensaje"></textarea></td>
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
