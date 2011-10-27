<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../config/setup.php"); ////////setup
include("../../../class/clases.php"); ////////clase
include ("../../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);

	$aco = new tools("db");
	
	if(isset($_GET['idpru'])){
	
		$data = $aco->array_query2("select id, nombre, date_format(fecha,'{$_SESSION['DB_FORMATO_DB']}') as fecha, grupo_id from tbl_evaluacion where id = {$_GET['idpru']}");
		$acom = $aco->array_query2("select nota_min,coment_min,nota_max,coment_max,alerta,coment_alerta from acomp where tipo = 'prueba' and act_id = {$_GET['idpru']} ");
		
	}else if(isset($_POST['Submit'])){
	
		/////GUARDAR ACOMPAÑAMIENTO

		$campos = "tipo,act_id,nota_min,coment_min,nota_max,coment_max,alerta,coment_alerta";
		$valores[0] = 'prueba';
		$valores[1] = $_POST['eva'];
		$valores[2] = trim($_POST['nota1']);
		$valores[3] = trim($_POST['mens_menor']);
		$valores[4] = trim($_POST['nota2']);
		$valores[5] = trim($_POST['mens_mayor']);
		$valores[6] = trim($_POST['dias']);
		$valores[7] = trim($_POST['mens_aviso']);
				
			
		$aco->query("select id from acomp where tipo = 'prueba' and act_id = {$_POST['eva']} ");	
			
			if($aco->nreg>0){
			
			$campos2 = explode(',',$campos);
			
			///////////////////////////
			$aco->update("acomp",$campos2,$valores,"tipo = 'prueba' and act_id = {$_POST['eva']}");
						
			///////////////////////////
						
			
			}else{
			
			///////////////////////////
			$aco->insertar2("acomp",$campos,$valores);
			///////////////////////////
	
			}
			
			
			$ira = "index.php?seccion=".$_POST['grupo'];
			$aco->javaviso(LANG_cambios,$ira);
	
	
	}
	

?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../../../css/style_back.css">

<script type="text/javascript" src="../../../editor/tiny_mce.js"></script>

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
            <td width="16%" align="center" class="no_back"><b><?=LANG_eva_name ?></b></td>
            <td width="55%" class="no_back"><?= $data[1] ?></td>
            <td width="14%" align="center" class="no_back"><b><?= LANG_date ?></b></td>
            <td width="15%" class="no_back"><?= $data[2] ?></td>
            </tr>
            <tr>
            <td colspan="4">&nbsp;</td>
          </tr>
            <tr>
          <td colspan="4" class="no_back">Si la nota del estudiante es menor o igual a: 
            <input name="nota1" type="text" id="nota1" size="5" value="<?=$acom[0] ?>">
            entonces enviar el mensaje a continuaci&oacute;n. </td>
          </tr>
          <tr>
          <td colspan="4">
            <textarea name="mens_menor" cols="69" rows="5" id="mens_menor"><?=$acom[1] ?>
            </textarea>
          </td>
        </tr>
          <tr>
          <td colspan="4">&nbsp;</td>
          </tr>
          <tr>
          <td colspan="4" class="no_back">Si la nota del estudiante es Mayor o igual a: 
            <input name="nota2" type="text" id="nota2" value="<?=$acom[2] ?>" size="5">
            entonces enviar el mensaje a continuaci&oacute;n. </td>
          </tr>
          <tr>
          <td colspan="4">
            <textarea name="mens_mayor" cols="69" rows="5" id="mens_mayor"><?=$acom[3] ?>
            </textarea>
          </td>
          </tr>
          <tr>
          <td colspan="4">&nbsp;</td>
          </tr>
          <tr>
          <td colspan="4" class="no_back">Enviar el siguiente mensaje de aviso cuando falten: 
            <input name="dias" type="text" id="dias" value="<?=$acom[4] ?>" size="5">
            dias para presentar la Evaluaci&oacute;n </td>
        </tr>
          <tr>
          <td colspan="4">
            <textarea name="mens_aviso" cols="69" rows="5" id="mens_aviso"><?=$acom[5] ?>
            </textarea>
          </td>
        </tr>
          <tr>
          <td colspan="4">
            <input name="eva" type="hidden" id="eva" value="<?=$data[0] ?>">
            <input name="grupo" type="hidden" id="grupo" value="<?=$data[3] ?>">
          </td>
        </tr>
          <tr>
          <td colspan="4">
            <input type="button" name="Submit2" onClick="history.back();" value="<?=LANG_back?>">
            <input type="submit" name="Submit" value="<?php echo LANG_save ?>">
          </td>
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
