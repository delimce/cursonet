<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);
include("security.php"); ///seguridad para el admin

 $modo = new tools();
 $modo->autoconexion();

 //////////////lenguaje
 $lenguajes = $modo->listar_archivos('../../config/lang/');
 for($l=0;$l<count($lenguajes);$l++){ $valorl = explode('.',$lenguajes[$l]); $lenguajes[$l] = $valorl[0]; unset($valorl); }
 //////




 if(isset($_POST['Submit'])){

 $f1 = array("d", "m", "Y");
 $f2   = array("%d", "%m", "%Y");

 $campos[0] = 'titulo'; $vector[0] = $_POST['titulo'];
 $campos[1] = 'titulo_admin'; $vector[1] = $_POST['tituloa'];
 $campos[2] = 'lenguaje'; $_SESSION['LENGUAJE'] = $vector[2] = $_POST['lengua'].'.php';
 $campos[3] = 'formato_fecha'; $_SESSION['DB_FORMATO'] = $vector[3] = $_POST['ffecha'];
 $campos[4] = 'envio_email'; $vector[4] = $_POST['email'];
 $campos[5] = 'signature'; $vector[5] = $_POST['signature'];
 $campos[6] = 'bienvenido_est'; $vector[6] = $_POST['bienvenida'];
 $campos[7] = 'fin_inscripcion'; $vector[7] = $_POST['fin_ins'];
 $campos[8] = 'uni_nombre'; $vector[8] = $_POST['nombre_u'];
 $campos[9] = 'uni_telefono'; $vector[9] = $_POST['tlf_u'];
 $campos[10] = 'uni_fax'; $vector[10] = $_POST['fax_u'];
 $campos[11] = 'uni_website'; $vector[11] = $_POST['web_u'];
 $campos[12] = 'uni_dir'; $vector[12] = $_POST['dir_u'];
 $campos[13] = 'formato_fecha_db'; $_SESSION['DB_FORMATO_DB'] = $vector[13] = str_replace($f1,$f2,$_POST['ffecha']);
 $campos[14] = 'admin_email'; $vector[14] = trim($_POST['emaila']);
 $campos[15] = 'titulo_ins'; $vector[15] = trim($_POST['tituloi']);
 $campos[16] = 'timezone'; $vector[16] = trim($_POST['timezone']);

 $modo->update("tbl_setup",$campos,$vector,"");
 $modo->javaviso(LANG_cambios,"pref.php");


 }

 ///////// los datos

 $datos = $modo->estructura_db("select  admin_email,titulo,titulo_admin,titulo_ins, SUBSTRING_INDEX(lenguaje, '.',1) as lenguaje, formato_fecha,envio_email,signature,bienvenido_est,fin_inscripcion,uni_nombre,uni_telefono,uni_fax,uni_website,uni_dir,timezone    from tbl_setup");

?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../../css/style_back.css">
<script language="JavaScript" type="text/javascript" src="../../js/utils.js"></script>
<script type="text/javascript" src="../../editor/tiny_mce.js"></script>

<script language="javascript" type="text/javascript">
	tinyMCE.init({
	mode : "textareas",
	theme : "advanced",
	plugins : "style,layer,table,charmap,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,flash,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable",
	language: "es",
	theme_advanced_buttons1_add_before : "undo,redo,separator,bold,italic,underline,separator,justifyleft,justifycenter,justifyright,justifyfull,separator",
	theme_advanced_buttons1 : ",outdent,indent,bullist,numlist,separator,charmap,insertdate,inserttime,separator,forecolor,backcolor",
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
    <td><?php $menu->mostrar(3); ?></td>
  </tr>
  <tr>
    <td>

	<table style="border-right:#000000 solid 1px; border-left:#000000 solid 1px; border-bottom:#000000 solid 1px;" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>

		<form name="form1" method="post" action="pref.php">
		<table width="99%" border="0" align="center" cellpadding="3" cellspacing="4">
		  <tr>
			<td colspan="4" class="style1"><?php echo LANG_ADMIN_settings ?></td>
			</tr>
		  <tr>
		    <td colspan="4" class="table_bk">
		      <?=LANG_PREF_gsettings ?>
		    </td>
		    </tr>
		  <tr>
			<td width="14%"><span class="style3"><?=LANG_PREF_title ?>
			</span></td>
			<td width="35%"><input name="titulo" type="text" class="style1" id="titulo" value="<?=$datos[0]['titulo'] ?>" size="25"></td>
			<td width="21%"><span class="style3">
			  <?=LANG_PREF_language ?>
			</span></td>
			<td width="30%"><?php echo $modo->combo_array ("lengua",$lenguajes,$lenguajes,false,$datos[0]['lenguaje'],false,'')?></td>
		  </tr>
		  <tr>
		    <td><span class="style3">
		      <?= LANG_PREF_titlea ?>
		    </span></td>
		    <td><input name="tituloa" type="text" class="style1" id="tituloa" value="<?=$datos[0]['titulo_admin'] ?>" size="25"></td>
		    <td><span class="style3">
		      <?= LANG_PREF_dformat ?>
		    </span></td>
		    <td><select name="ffecha" id="ffecha">
		      <option value="d/m/Y" <?php if($datos[0]['formato_fecha']=="d/m/Y") echo "selected" ?>><?= LANG_PREF_dformat1?></option>
		      <option value="m/d/Y" <?php if($datos[0]['formato_fecha']=="m/d/Y") echo "selected" ?>><?= LANG_PREF_dformat2?></option>
		      </select>	
		     </td>
		    </tr>
		  <tr>
		  
		  
		   <tr>
			<td width="14%"><span class="style3"><?=LANG_PREF_titleins ?>
			</span></td>
			<td width="35%"><input name="tituloi" type="text" class="style1" id="titulo" value="<?=$datos[0]['titulo_ins'] ?>" size="25"></td>
			<td width="21%"><span class="style3">
			  <?=LANG_PREF_timezone ?>
			 
			</span></td>
			<td width="30%"><input name="timezone" type="text" class="style1" id="tituloi" value="<?=$datos[0]['timezone'] ?>" size="21"></td>
		  </tr>
		  
		  
		    <td class="style3"><?php echo LANG_PREF_email ?></td>
		    <td>
		      <input name="email" type="checkbox" class="style1" id="email" value="1" <?php if($datos[0]['envio_email']==1) echo "checked" ?>>
		    &nbsp;<span class="style1"><?= LANG_PREF_email_act ?></span></td>
		    <td class="style3">&nbsp;</td>
		    <td>&nbsp;</td>
		    </tr>
		  <tr>
		  <td class="style3"><?php echo LANG_ADMIN_admin_email ?></td>
		  <td>
		    <input name="emaila" type="text" class="style1" id="emaila" value="<?=$datos[0]['admin_email'] ?>" size="25">
		  </td>
		  <td class="style3">&nbsp;</td>
		  <td>&nbsp;</td>
		  </tr>
		  <tr>
		    <td><span class="style3">
		      <?= LANG_PREF_signature ?>
		    </span></td>
		    <td colspan="3"><textarea name="signature" cols="76" rows="5" class="style1" id="signature"><?=$datos[0]['signature'] ?>
		    </textarea>
		    </td>
		    </tr>
		  <tr>
		    <td><span class="style3">
		      <?= LANG_PREF_wellcome ?>
		    </span></td>
		    <td colspan="3"><textarea name="bienvenida" cols="76" rows="5" class="style1" id="bienvenida"><?=$datos[0]['bienvenido_est'] ?>
		    </textarea>
		    </td>
		    </tr>
		  <tr>
		    <td><span class="style3">
		      <?= LANG_PREF_endi ?>
		    </span></td>
		    <td colspan="3"><textarea name="fin_ins" cols="76" rows="5" class="style1" id="fin_ins"><?=$datos[0]['fin_inscripcion'] ?>
		    </textarea>
		    </td>
		    </tr>
		  <tr>
		  <td colspan="4" class="table_bk">  <?= LANG_PREF_data_i ?></td>
		  </tr>
		  <tr>
		  <td class="style3"><?= LANG_name ?></td>
		  <td>
		    <input name="nombre_u" type="text" id="nombre_u" value="<?=$datos[0]['uni_nombre'] ?>" size="25">
		  </td>
		  <td class="style3"><?= LANG_tel ?></td>
		  <td>
		    <input name="tlf_u" type="text" id="tlf_u" value="<?=$datos[0]['uni_telefono'] ?>" size="21">
		  </td>
		  </tr>
		  <tr>
		  <td class="style3"><?= LANG_fax ?></td>
		  <td>
		    <input name="fax_u" type="text" id="fax_u" value="<?=$datos[0]['uni_fax'] ?>" size="25">
		  </td>
		  <td class="style3"><?= LANG_web ?></td>
		  <td>
		    <input name="web_u" type="text" id="web_u" value="<?=$datos[0]['uni_website'] ?>" size="21">
		  </td>
		  </tr>
		  <tr>
		  <td class="style3"><?= LANG_dir ?></td>
		  <td colspan="3">
		    <textarea name="dir_u" cols="76" rows="5" class="style1" id="dir_u"><?=$datos[0]['uni_dir'] ?>
		    </textarea>
		  </td>
		  </tr>

		  <tr>
			<td colspan="4"><input type="submit" name="Submit" value="<?php echo LANG_save ?>"></td>
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
<?php

$modo->cerrar();

?>
