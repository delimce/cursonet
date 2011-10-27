<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);

 $crear = new tools("db");
 $prioridad = $crear->llenar_array(LANG_msg_priority_l.",".LANG_msg_priority_n.",".LANG_msg_priority_h);

 
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../../css/style_back.css">
<script type="text/javascript" src="../../editor/tiny_mce.js"></script>

	<script language="JavaScript" type="text/javascript">
	function validar(){

	if(document.form1.persona.value=="0"){

		alert("<?=LANG_select_type?>");
		document.form1.persona.focus();
		return false;

    }

	if(document.form1.titulo.value==''){

		alert("<?=LANG_select_subject?>");
		document.form1.titulo.focus();
		return false;

    }

	 return true;

	}
	</script>


	<script language="javascript" type="text/javascript">
	tinyMCE.init({
	mode : "textareas",
	theme : "advanced",
	plugins : "style,layer,table,charmap,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,flash,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable",
	language: "es",
	theme_advanced_buttons1_add_before : "newdocument,preview,separator,cut,copy,paste,undo,redo,separator,bold,italic,underline,separator,justifyleft,justifycenter,justifyright,justifyfull,separator",
	theme_advanced_buttons1 : ",outdent,indent,bullist,numlist,separator,forecolor,backcolor,separator,help",
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
        
  <form name="form1" method="post" action="flow.php" onSubmit="return validar();">

   <table width="100%" border="0" cellspacing="4" cellpadding="3">

  <tr>
    <td valign="top" class="style3"><?php echo LANG_est_mens_replyto ?></td>
    <td colspan="2" class="style1">

    <div id ="person">

    <?=$_REQUEST['suj'] ?>
    <input name="destino" type="hidden" value="<?=$_REQUEST['tipo'] ?>">
    <input name="persona" type="hidden" value="<?=$_REQUEST['id'] ?>">
   </div>     </td>
  </tr>
  <tr>
    <td valign="top" class="style1"><span class="style3"><?php echo LANG_msg_priori ?></span></td>
    <td width="40%" class="style1"><? echo $crear->combo_array("priori",$prioridad,$prioridad,false,LANG_msg_priority_n); ?></td>
    <td width="40%" class="style1">&nbsp;</td>
  </tr>
  <tr>
    <td width="20%" valign="top" class="style1"><span class="style3"><?php echo LANG_subjet ?></span></td>
    <td colspan="2" class="style1"><input name="titulo" type="text" id="titulo" value="<?=LANG_est_mens_replymark.' '.$_REQUEST['titulo'] ?>" size="70"></td>
    </tr>
  <tr>
  <td colspan="3" class="style3"><textarea name="content" cols="73" rows="13" id="content"></textarea></td>
  </tr>

  <tr>
  <td colspan="3">
    <input type="button" name="Submit2"  value="<?=LANG_cancel?>" onClick="location.replace('index.php');">
    <input type="submit" name="Submit" value="<?=LANG_msg_send?>">   </td>
  </tr>
</table>
</form></td>
      </tr>
    </table>	</td>
  </tr>
</table>
<p>&nbsp;</p>
    
</body>
</html>
<?php

 $crear->cerrar();

?>