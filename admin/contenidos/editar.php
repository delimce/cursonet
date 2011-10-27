<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);


  $crear = new tools('db');

 if(isset($_GET['ItemID'])){

  		$datos = $crear->array_query2("select titulo, contenido, borrador,autor,leido from tbl_contenido where id = '{$_GET['ItemID']}'");

 }


 if(isset($_POST['nombre'])){

	 $campos = explode(",","titulo, contenido, borrador,fecha,autor,leido");
	 $valores[0] = $_POST['nombre'];
	 $valores[1] = $_POST['content'];
	 $valores[2] = $_POST['borrador'];
	 $valores[3] = date("Y-m-d h:i:s");
	 $valores[4] = $_POST['autor'];
	 $valores[5] = $_POST['leido'];

	 $crear->update("tbl_contenido",$campos,$valores,"id = '{$_POST['id']}'");
	 $crear->javaviso(LANG_cambios,"index.php");


 }


?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../../css/style_back.css">

	<script language="JavaScript" type="text/javascript" src="../../editor/tiny_mce.js"></script>

	<script language="javascript" type="text/javascript">
	tinyMCE.init({
	
		mode : "exact",
		elements : "content",
		theme : "advanced",
		plugins : "style,layer,table,charmap,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,flash,searchreplace,print,paste,directionality,fullscreen,noneditable",
		language: "es",
		theme_advanced_buttons1_add_before : "newdocument,print,preview,separator,cut,copy,paste,undo,redo,separator,bold,italic,underline,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,fontsizeselect",
		theme_advanced_buttons1 : ",separator,outdent,indent,bullist,numlist",
		theme_advanced_buttons2 : "link,unlink,anchor,separator,charmap,image,flash,tablecontrols,separator,insertdate,inserttime,separator,forecolor,backcolor,code",
		plugin_insertdate_dateFormat : "%Y-%m-%d",
		plugin_insertdate_timeFormat : "%H:%M:%S",
		theme_advanced_buttons3 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		content_css : "example_word.css",
		extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]"


	});
	</script>

	<script language="JavaScript" type="text/javascript">
	function validar(){

	 if(document.form1.nombre.value==''){

	 alert('<?=LANG_group_error1 ?>');
	 document.form1.nombre.focus();

	 return false;

	 }
	 
	 
	  if(isNaN(document.form1.leido.value)){

	 alert('<?=LANG_VAL_isnan ?>');
	 document.form1.leido.focus();

	 return false;

	 }

	 return true;

	}
	</script>



	<script language="JavaScript">
	<!--

	 function popup(mylink, windowname,alto1,largo1)
	 {
	var alto = alto1;
	var largo = largo1;
	var winleft = (screen.width - largo) / 2;
	var winUp = (screen.height - alto) / 2;


	if (! window.focus)return true;
	  var href;
	  if(typeof(mylink) == 'string')
		href=mylink;
	  else
		href=mylink.href;
		window.open(href, windowname, 'top='+winUp+',left='+winleft+'+,toolbar=0 status=1,resizable=0,Width='+largo+',height='+alto+',scrollbars=1');

	 return false;

	}

	//-->
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
        <td><form name="form1" method="post" action="editar.php" onSubmit="return validar();">
  <table width="100%" border="0" cellspacing="4" cellpadding="3">
  <tr>
  <td colspan="2">&nbsp;</td>
</tr>

  <tr>
    <td><span class="style3"><?php echo LANG_content_reads ?></span></td>
    <td><input name="leido" type="text" id="leido" value="<?=$datos[4]?>" size="4"></td>
  </tr>
  <tr>
    <td><span class="style3"><?php echo LANG_content_autor ?></span></td>
    <td>
    <?php 
	
	$querya = "SELECT 
			  concat(a.nombre,' ',a.apellido) as nombre,
			  a.id
			from tbl_admin a where (a.cursos LIKE '%{$_SESSION['CURSOID']}%')";
			  
	if($_SESSION['PROFILE'] == 'admin')
	$querya.=  " or (es_admin=1)" ;
				
	echo $crear->combo_db("autor",$querya,"nombre","id",false,$datos[3]); 
	
	?>
    </td>
  </tr>


  <tr>
  <td width="24%" valign="middle" class="style3"><?php echo LANG_content_name ?></td>
  <td width="76%"><textarea name="nombre" cols="50" rows="2" id="nombre"><?=$datos[0]?>
  </textarea></td>
  </tr>

  <tr>
  <td colspan="2" class="style3">
    <textarea name="content" cols="73" rows="20" id="content"><?=$datos[1] ?></textarea>
  </td>
</tr>
  <tr>
  <td colspan="2" class="style3">

    <input name="borrador" type="checkbox" id="borrador" <?php if ($datos[2]==1) echo "checked" ?> value="1">
		  <?php echo LANG_content_noactive ?></td>
  </tr>

  <tr>
  <td colspan="2"><input type="button" name="Submit2"  value="<?=LANG_back?>" onClick="javascript:history.back();">
    <input type="submit" name="Submit" value="<?=LANG_save?>">
    <span class="style1">
    <input type="button" name="Submit3" value="<?php echo LANG_content_uploadfiles ?>" onClick="javascript:popup('../recursos/index.php','new',350,500);">
    </span> <input name="id" type="hidden" id="id" value="<?=$_GET['ItemID'] ?>"></td>
  </tr>
</table>
</form></td>
      </tr>
    </table>	</td>
  </tr>
</table>
</body>
</html>
<?php

 $crear->cerrar();

?>
