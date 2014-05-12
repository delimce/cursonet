<?php session_start();
$profile = 'est'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje


 $crear = new tools("db");
 $prioridad = $crear->llenar_array(LANG_msg_priority_l.",".LANG_msg_priority_n.",".LANG_msg_priority_h);

 
?>
<html>
<head> <meta charset="utf-8">
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
	plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",
	theme_advanced_buttons1_add_before : "newdocument,preview,separator,cut,copy,paste,undo,redo,separator,bold,italic,underline,separator,justifyleft,justifycenter,justifyright,justifyfull,separator",
	theme_advanced_buttons1 : ",outdent,indent,bullist,numlist,separator,forecolor,backcolor",
	theme_advanced_buttons2 : "",
	plugin_insertdate_dateFormat : "<?=$_SESSION['DB_FORMATO_DB']?> ",
	plugin_insertdate_timeFormat : "%H:%M:%S",
	
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true
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

    <?=$_REQUEST['suj'] ?>
    <input name="destino" type="hidden" value="<?=$_REQUEST['tipo'] ?>">
    <input name="persona" type="hidden" value="<?=$_REQUEST['id'] ?>">
   </div>     </td>
  </tr>
  <tr>
    <td valign="top" class="style3"><?php echo LANG_msg_priori ?></td>
    <td class="style1"><? echo $crear->combo_array("priori",$prioridad,$prioridad,false,LANG_msg_priority_n); ?></td>
  </tr>
  <tr>
    <td width="12%" valign="top" class="style1"><span class="style3"><?php echo LANG_subjet ?></span></td>
    <td class="style1"><input name="titulo" type="text" id="titulo" value="<?=LANG_est_mens_replymark.' '.$_REQUEST['titulo'] ?>" size="60">&nbsp;</td>
    </tr>
  <tr>
  <td colspan="2" class="style3"><textarea name="content" cols="75" rows="13" id="content"></textarea></td>
  </tr>

  <tr>
  <td colspan="2">
    <input type="button" name="Submit2"  value="<?=LANG_cancel?>" onClick="location.replace('index.php');">
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