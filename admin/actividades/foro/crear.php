<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../config/setup.php"); ////////setup
include("../../../class/tools.php"); ////////clase
include("../../../class/fecha.php"); ////////clase
include ("../../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);


 $crear = new tools();
 $fecha = new fecha($_SESSION['DB_FORMATO']);
 $crear->autoconexion();
 
 $horario = $crear->simple_db("select timezone from setup ");
 // @date_default_timezone_set($horario);



 	if(isset($_POST['nombre'])){

	 			  /* ////////////validar
				   $valida1 =  $fecha->unix_time($_POST['inicio']);
				   $valida2 =  $fecha->unix_time($_POST['fin']);
				   if($valida1>=$valida2) $crear->javaviso(LANG_foro_val_fechas,"crear.php");
				   ////////////*/

				  
				   $valores[0] = $_POST['nombre'];
				   $valores[1] = $_POST['caso'];
				   $valores[2] = $_POST['seccion'];
				   $valores[3] = '';
				   $valores[4] = $_POST['content'];
				   $valores[5] = $fecha->fecha_db($_POST['inicio'],1);
				   $valores[6] = $fecha->fecha_db($_POST['fin']);
				   $valores[7] = $_POST['nota'];
				   $valores[8] = $_SESSION['USERID'];
				   $valores[9] = $_SESSION['CURSOID'];

				  $crear->insertar2("foro","titulo,contenido_id, grupo_id, resumen, content, fecha_post, fecha_fin, nota, autor,curso_id",$valores);
 
				  $crear->javaviso(LANG_foro_created,"index.php");

	}





?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../../../css/style_back.css">
<script type="text/javascript" src="../../../editor/tiny_mce.js"></script>

<script language="javascript" type="text/javascript">
	tinyMCE.init({
	mode : "exact",
	elements : "content",
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

	<script language="JavaScript" type="text/javascript">

	function compara_fechas(desde,hasta){

	var formaty = '<?=str_replace("m", "M",strtolower($_SESSION['DB_FORMATO']));?>';

	return compareDates(desde,formaty,hasta,formaty);


	}



	function validar(){

	 if(document.form1.nombre.value==''){

	 alert('<?=LANG_eva_val_nombre ?>');
	 document.form1.nombre.focus();

	 return false;

	 }


	 if(document.form1.caso.value==''){

	 alert('<?=LANG_foro_val_caso ?>');
	 document.form1.caso.focus();

	 return false;

	 }




	 if(compara_fechas('<?=date($_SESSION['DB_FORMATO']);?>',document.form1.inicio.value)==1){

	 alert('<? echo LANG_eva_val_fecha2.' '.date($_SESSION['DB_FORMATO']); ?>');
	 document.form1.inicio.focus();

	 return false;

	 }



	 if(compara_fechas(document.form1.inicio.value,document.form1.fin.value)==1){

	 alert('<? echo LANG_eva_val_fecha2 ?> '+document.form1.inicio.value);
	 document.form1.fin.focus();

	 return false;

	 }



	 if(isNaN(document.form1.nota.value) || document.form1.nota.value>100 || document.form1.nota.value<0 || document.form1.nota.value==''){
	 alert('<?=LANG_eva_val_por ?>');
	 document.form1.nota.focus();
	 return false;

	 }


	       tinyMCE.execCommand("mceCleanup");
           tinyMCE.triggerSave();
          if (tinyMCE.getContent() == "" || tinyMCE.getContent() == null) {

             alert('<?=LANG_foro_val_content ?>');
             document.form1.content.focus();

             return false;

         }
	 
	 
	 
	 return true;

	}
	</script>



	<script type="text/javascript" src="../../../js/calendario/calendar.js"></script>
	<script type="text/javascript" src="../../../js/calendario/calendar-es.js"></script>
	<script type="text/javascript" src="../../../js/calendario/calendar-setup.js"></script>
	<script type="text/javascript" src="../../../js/popup.js"></script>
	<script language="JavaScript" type="text/javascript" src="../../../js/date.js"></script>
	<script language="JavaScript" type="text/javascript" src="../../../js/ajax.js"></script>
	<LINK href="../../../js/calendario/calendario.css" type=text/css rel=stylesheet>

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
        <td><form name="form1" method="post" action="crear.php" onSubmit="return validar();">
<br>
<table width="100%" border="0" cellspacing="4" cellpadding="3">

  <tr>
    <td class="style3">Nombre del foro</td>
    <td width="72%"><input name="nombre" type="text" id="nombre" size="45"></td>
  </tr>
  <tr>

    <td width="28%" class="style3">Capitulo</td>
  <td><? echo $crear->combo_db("caso","select id,IF(LENGTH(titulo)>60,concat(SUBSTRING(titulo,1,50),'...'),titulo) as titulo from contenido where curso_id = {$_SESSION['CURSOID']}","titulo","id",LANG_select,false,"ajaxcombo('grupox','seccion','../../grupos/gruposc.php?ide='+this.value,'seccion','nombre','valor');",'<input name="caso" type="hidden" value="">'); ?></td>
</tr>
  <tr>
  <td class="style3"><?php echo LANG_group_nombre; ?></td>
  <td> <div id="grupox"><?php  echo LANG_group_casoseccion;  ?></div></td>
 </tr>

  <tr>
    <td class="style3"><?php echo LANG_foro_date1; ?></td>
    <td><input name="inicio" type="text" id="inicio" OnFocus="this.blur()" onClick="alert('<?=LANG_calendar_use?>')" value="<? echo date($_SESSION['DB_FORMATO']); ?>" size="12">
      <img src="../../../images/frontend/cal.gif" name="f_trigger_d" width="16" height="16" id="f_trigger_d" style="cursor: hand; border: 0px;" title="<?=LANG_calendar?>">
      <script type="text/javascript">
					Calendar.setup({
						inputField     :    "inicio",     // id of the input field
						ifFormat       :    "<?=strtolower($_SESSION['DB_FORMATO'])?>",    // format of the input field
						button         :    "f_trigger_d",  // trigger for the calendar (button ID)
						singleClick    :    true
					});
				</script></td>
  </tr>
  <tr>
    <td class="style3"><?php echo LANG_foro_date2; ?></td>
    <td><input name="fin" type="text" id="fin" OnFocus="this.blur()" onClick="alert('<?=LANG_calendar_use?>')" value="<? echo date($_SESSION['DB_FORMATO']); ?>" size="12">
      <img src="../../../images/frontend/cal.gif" name="f_trigger_e" width="16" height="16" id="f_trigger_e" style="cursor: hand; border: 0px;" title="<?=LANG_calendar?>">
      <script type="text/javascript">
					Calendar.setup({
						inputField     :    "fin",     // id of the input field
						ifFormat       :    "<?=strtolower($_SESSION['DB_FORMATO'])?>",    // format of the input field
						button         :    "f_trigger_e",  // trigger for the calendar (button ID)
						singleClick    :    true
					});
				</script></td>
  </tr>

  <tr>
    <td class="style3"><?php echo LANG_foro_por ?></td>
    <td><input name="nota" type="text" id="nota" size="5" maxlength="5">
      <span class="bold">%</span></td>
  </tr>

	
	
	
  <tr>
    <td colspan="2" class="td_whbk2"><b><?php echo LANG_foro_contenido ?></b></td>
    </tr>
  <tr>
    <td colspan="2" class="style3"><textarea name="content" cols="96" rows="8" class="style1" id="content"></textarea></td>
    </tr>

  <tr>
  <td colspan="2"><input type="button" name="Submit2" onClick="history.back();" value="<?=LANG_back?>">
  <input type="submit" name="Submit" value="<?=LANG_save?>"></td>
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