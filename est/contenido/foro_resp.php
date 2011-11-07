<?php session_start();
$profile = 'est'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

 $insert = new tools("db");


if(isset($_POST['Submit'])){ ///se envia el comentario

	
	$valores[0] = $_SESSION['FORO_ID'];
	$valores[1] = 'est';
	$valores[2] = $_SESSION['USER'];
	$valores[3] = trim($_POST['comentario']);
    $valores[4] = date('Y-m-d H:i:s');
    $valores[5] = $_POST['resp'];
    
   
    $insert->insertar2("tbl_foro_comentario","foro_id,tipo_sujeto,sujeto_id,content,fecha_post,response",$valores);
    
    
    ?>
    <script language="javascript">
    
	window.opener.location.reload();
	window.close();
	
    </script>
    
    <?
    

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



<link rel="stylesheet" type="text/css" href="../../css/style_front.css">
<script type="text/javascript" src="../../js/utils.js"></script>
<script type="text/javascript" src="../../editor/tiny_mce.js"></script>

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

<form name="form1" method="post" action="foro_resp.php" onSubmit="return validar();">

<table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
    <td><span class="style3">
    <?= LANG_foro_add ?>
     </span></td>
     </tr>
          <tr>
            <td><span class="style3">
              <textarea name="comentario" cols="111" rows="9" class="style1" id="comentario"></textarea>
            </span></td>
          </tr>
        
          
          <tr>
             <td>
              <input type="button" name="cerrar" onClick="window.close();" value="<?=LANG_close?>">
              <input type="submit" name="Submit" value="<?=LANG_save?>">
              <input type="hidden" name="resp" value="<?=$_REQUEST['ide']?>" />
              </td>
          </tr>
        
</table>

 </form>


</body>
</html>

<?

$insert->cerrar();

?>