<?php session_start();
$profile = 'est'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/tools.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

	/////duda o inquietud desde el contenido del tema seleccionado.
	
 $crear = new tools();
 $crear->autoconexion();
 $prioridad = $crear->llenar_array(LANG_msg_priority_l.",".LANG_msg_priority_n.",".LANG_msg_priority_h);

	$data1 = $crear->simple_db("SELECT 
					  concat('".LANG_msg_prefa." ',a.nombre,' ',a.apellido) as nombre,
					  a.id
					  FROM
					  contenido c
					  INNER JOIN admin a ON (c.autor = a.id)
					  where c.id = '{$_SESSION['CASOACTUAL']}' ");
 
?>
<html>
<head>
<title><?php echo LANG_est_mens_h_new ?></title>
<link rel="stylesheet" type="text/css" href="../../css/style_front.css">
<script type="text/javascript" src="../../editor/tiny_mce.js"></script>

	<script language="JavaScript" type="text/javascript">
	function validar(){


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

<table width="100%" border="0" cellspacing="6" cellpadding="2">
  <tr>
    <td width="56%" align="center" style="border: #9AB1B6 1px solid;">
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
      <td colspan="2" class="welcome">
        <?= LANG_est_mens_h_new ?>      </td>
    </tr>
      <tr>
      <td height="2" colspan="2"><hr color="#9AB1B6" size="1px"></td>
    </tr>
      <tr>
      <td height="2" colspan="2">
      
      
    <!-- data aqui -->  


	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
  <form name="form1" method="post" action="flow.php" onSubmit="return validar();">

   <table width="100%" border="0" cellspacing="4" cellpadding="3">

  <tr>
    <td valign="top" class="style3"><?php echo LANG_est_mens_replyto ?></td>
    <td class="style1">

    <div id ="person">

    <?php echo $data1['nombre'] ?>
    <input name="cerrar" type="hidden" value="1">
    <input name="destino" type="hidden" value="1">
    <input name="persona" type="hidden" value="<? echo $data1['id']; ?>">
   </div>     </td>
  </tr>
  <tr>
    <td valign="top" class="style3"><?php echo LANG_msg_priori ?></td>
    <td class="style1"><? echo $crear->combo_array("priori",$prioridad,$prioridad,false,LANG_msg_priority_n); ?>
      <input name="consulta" type="hidden" id="consulta" value="1"></td>
  </tr>
  <tr>
    <td width="12%" valign="top" class="style1"><span class="style3"><?php echo LANG_subjet ?></span></td>
    <td class="style1"><input name="titulo" type="text" id="titulo" value="<?php echo LANG_est_mens_requestmark ?>" size="60">&nbsp;</td>
    </tr>
  <tr>
  <td colspan="2" class="style3"><textarea name="content" cols="75" rows="13" id="content"></textarea></td>
  </tr>

  <tr>
  <td colspan="2">
    <input type="button" name="Submit2"  value="<?=LANG_cancel?>" onClick="window.close();">
    <input type="submit" name="Submit" value="<?=LANG_msg_send?>">   </td>
  </tr>
</table>
</form></td>
      </tr>
    </table>
    
     <!-- data aqui --> 
          
          
          </td>
    </tr>
    </table>
    </td>
   </tr> 
   </table> 
    
</body>
</html>
<?php

 $crear->cerrar();

?>