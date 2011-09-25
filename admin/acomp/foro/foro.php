<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../config/setup.php"); ////////setup
include("../../../class/tools.php"); ////////clase
include("../../../class/fecha.php"); ////////clase
include ("../../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);
$fecha = new fecha($_SESSION['DB_FORMATO']);

	$aco = new tools();
	$aco->autoconexion();
	
	$horario = $aco->simple_db("select timezone from setup ");
    // @date_default_timezone_set($horario);

	if(isset($_GET['idpro'])){

		$data = $aco->array_query2("select id, titulo, date_format(fecha_post,'{$_SESSION['DB_FORMATO_DB']}') as fecha, grupo_id from foro where id = {$_GET['idpro']}");
		$acom = $aco->array_query2("select id,menos,fecha_menos1,fecha_menos2,mensaje_menos,mas,fecha_mas1,fecha_mas2,mensaje_mas,faltan,mensaje_faltan,mensaje_inicio from edunet_acomp where foro_id = {$_GET['idpro']} ");

	}else if(isset($_POST['Submit'])){

		/////GUARDAR ACOMPAÑAMIENTO

		$campos = "foro_id,menos,fecha_menos1,fecha_menos2,mas,fecha_mas1,fecha_mas2,faltan,mensaje_menos,mensaje_mas,mensaje_inicio,mensaje_faltan";
		$valores[0]  = $_POST['eva'];
		$valores[1]  = trim($_POST['menos']);
		$valores[2]  = $fecha->fecha_db($_POST['fm1']);
		$valores[3]  = $fecha->fecha_db($_POST['fm2']);
		$valores[4]  = trim($_POST['mas']);
		$valores[5]  = $fecha->fecha_db($_POST['ff1']);
		$valores[6]  = $fecha->fecha_db($_POST['ff2']);
		$valores[7]  = trim($_POST['dias']);
		$valores[8]  = trim($_POST['mens_menor']);
		$valores[9]  = trim($_POST['mens_mayor']);
		$valores[10] = trim($_POST['inicio']);
		$valores[11] = trim($_POST['mens_aviso']);


		$aco->query("select id from edunet_acomp where foro_id = {$_POST['eva']} ");

			if($aco->nreg>0){

			$campos2 = explode(',',$campos);

			///////////////////////////
			$aco->update("edunet_acomp",$campos2,$valores," foro_id = {$_POST['eva']}");

			///////////////////////////


			}else{

			///////////////////////////
			$aco->insertar2("edunet_acomp",$campos,$valores);
			///////////////////////////

			}


			$ira = "index.php?seccion=".$_POST['grupo'];
			$aco->javaviso(LANG_cambios,$ira);


	}


?>

<head>


	<script type="text/javascript" src="../../../js/calendario/calendar.js"></script>
	<script type="text/javascript" src="../../../js/calendario/calendar-es.js"></script>
	<script type="text/javascript" src="../../../js/calendario/calendar-setup.js"></script>
	<script type="text/javascript" src="../../../js/popup.js"></script>
	<script language="JavaScript" type="text/javascript" src="../../../js/date.js"></script>
	<script language="JavaScript" type="text/javascript" src="../../../js/ajax.js"></script>
	<LINK href="../../../js/calendario/calendario.css" type=text/css rel=stylesheet>
	
	
<link rel="stylesheet" type="text/css" href="../../../css/style_back.css">

<!--<script type="text/javascript" src="../../../editor/tiny_mce.js"></script>

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
</script>-->

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
        <td><br>
           <form name="form1" method="post" action="<?=$PHP_SELF ?>">
          <table width="89%" border="0" align="center" cellpadding="2" cellspacing="1">
            <tr>
            <td width="16%" align="center" class="no_back"><b>Foro</b></td>
            <td width="55%" class="no_back"><?= $data[1] ?></td>
            <td width="14%" align="center" class="no_back"><b>Fecha </b></td>
            <td width="15%" class="no_back"><?= $data[2] ?></td>
            </tr>
            <tr>
            <td colspan="4">&nbsp;</td>
          </tr>
            <tr>
          <td colspan="4" class="no_back">Si tiene menos de 
            <input name="menos" type="text" id="menos" size="5" value="<?=$acom[1] ?>">
            comentarios entre las fechas 
            <input name="fm1" type="text" id="fm1" size="12" value="<?=$fecha->datetime($acom[2]); ?>">
			 <img src="../../../images/frontend/cal.gif" name="f_trigger_1" width="16" height="16" id="f_trigger_1" style="cursor: hand; border: 0px;" title="<?=LANG_calendar?>">
      <script type="text/javascript">
					Calendar.setup({
						inputField     :    "fm1",     // id of the input field
						ifFormat       :    "<?=strtolower($_SESSION['DB_FORMATO'])?>",    // format of the input field
						button         :    "f_trigger_1",  // trigger for the calendar (button ID)
						singleClick    :    true
					});
				</script>
			
			
y            
<input name="fm2" type="text" id="fm2" size="12" value="<?=$fecha->datetime($acom[3]) ?>">
<img src="../../../images/frontend/cal.gif" name="f_trigger_2" width="16" height="16" id="f_trigger_2" style="cursor: hand; border: 0px;" title="<?=LANG_calendar?>">
      <script type="text/javascript">
					Calendar.setup({
						inputField     :    "fm2",     // id of the input field
						ifFormat       :    "<?=strtolower($_SESSION['DB_FORMATO'])?>",    // format of the input field
						button         :    "f_trigger_2",  // trigger for the calendar (button ID)
						singleClick    :    true
					});
				</script>



entonces enviar el mensaje a continuaci&oacute;n. </td>
          </tr>
          <tr>
          <td colspan="4">
            <textarea name="mens_menor" cols="69" rows="5" id="mens_menor"><?=$acom[4] ?>
            </textarea>          </td>
        </tr>
          <tr>
          <td colspan="4">&nbsp;</td>
          </tr>
          <tr>
          <td colspan="4" class="no_back">Si tiene mas  de
            <input name="mas" type="text" id="mas" size="5" value="<?=$acom[5] ?>">
comentarios entre las fechas
<input name="ff1" type="text" id="ff1" size="12" value="<?=$fecha->datetime($acom[6]) ?>">
<img src="../../../images/frontend/cal.gif" name="f_trigger_3" width="16" height="16" id="f_trigger_3" style="cursor: hand; border: 0px;" title="<?=LANG_calendar?>">
      <script type="text/javascript">
					Calendar.setup({
						inputField     :    "ff1",     // id of the input field
						ifFormat       :    "<?=strtolower($_SESSION['DB_FORMATO'])?>",    // format of the input field
						button         :    "f_trigger_3",  // trigger for the calendar (button ID)
						singleClick    :    true
					});
				</script>


y
<input name="ff2" type="text" id="ff2" size="12" value="<?=$fecha->datetime($acom[7]) ?>">
<img src="../../../images/frontend/cal.gif" name="f_trigger_4" width="16" height="16" id="f_trigger_4" style="cursor: hand; border: 0px;" title="<?=LANG_calendar?>">
      <script type="text/javascript">
					Calendar.setup({
						inputField     :    "ff2",     // id of the input field
						ifFormat       :    "<?=strtolower($_SESSION['DB_FORMATO'])?>",    // format of the input field
						button         :    "f_trigger_4",  // trigger for the calendar (button ID)
						singleClick    :    true
					});
	 </script>

entonces enviar el mensaje a continuaci&oacute;n. </td>
          </tr>
          <tr>
          <td colspan="4">
            <textarea name="mens_mayor" cols="69" rows="5" id="mens_mayor"><?=$acom[8] ?>
            </textarea>          </td>
          </tr>
          <tr>
          <td colspan="4">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="4" class="no_back">Enviar el siguiente mensaje de aviso al iniciar el foro para el tema </td>
          </tr>
          <tr>
            <td colspan="4"><textarea name="inicio" cols="69" rows="5" id="inicio"><?=$acom[11] ?>
            </textarea></td>
          </tr>
          <tr>
            <td colspan="4">&nbsp;</td>
          </tr>
          <tr>
          <td colspan="4" class="no_back">Enviar el siguiente mensaje de aviso cuando falten:
            <input name="dias" type="text" id="dias" value="<?=$acom[9] ?>" size="5">
            dias para terminar el foro </td>
        </tr>
          <tr>
          <td colspan="4">
            <textarea name="mens_aviso" cols="69" rows="5" id="mens_aviso"><?=$acom[10] ?>
            </textarea>          </td>
        </tr>
          <tr>
          <td colspan="4">
            <input name="eva" type="hidden" id="eva" value="<?=$data[0] ?>">
            <input name="grupo" type="hidden" id="grupo" value="<?=$data[3] ?>">          </td>
        </tr>
          <tr>
          <td colspan="4">
            <input type="button" name="Submit2" onClick="history.back();" value="<?=LANG_back?>">
            <input type="submit" name="Submit" value="<?php echo LANG_save ?>">          </td>
        </tr>
          <tr>
          <td colspan="4">&nbsp;</td>
        </tr>
        </table>

          </form>
          </td>
      </tr>
    </table>	</td>
  </tr>
</table>
</body>
</html>
<?

	$aco->cerrar();

?>
