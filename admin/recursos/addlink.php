<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);


$crear = new tools();
$crear->autoconexion();



if(isset($_POST['link'])){


	
	$valores[0] = 1;
	$valores[1] = date("Y-m-d h:i:s");
	$valores[2] = $_POST['link'];
	$valores[3] = 'admin';
	$valores[4] = $_SESSION['USERID'];
	$valores[5] = $_POST['desc'];

	$crear->insertar2("tbl_recurso","tipo, fecha, dir, add_by, persona,descripcion",$valores);
	$crear->javaviso(LANG_cambios,"links.php");

}

?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../../css/style_back.css">
<script type="text/javascript" src="../../js/dyntar.js"></script>

	<script language="JavaScript" type="text/javascript">
	function validar(){

		if(document.form1.archivo.value==''){

			alert('<?=LANG_content_error ?>');
			document.form1.nombre.focus();

			return false;

		}

		return true;

	}
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
        <td><form action="addlink.php" method="post" enctype="multipart/form-data" name="form1" onSubmit="return validar();">
  <table width="100%" border="0" cellspacing="4" cellpadding="3">
  <tr>
  <td colspan="2">&nbsp;</td>
</tr>
  <tr>
  <td width="19%" class="style3"><?php echo LANG_content_link1; ?></td>
  <td width="81%"><input name="link" type="text" id="link" value="http://www." size="43"></td>
  </tr>
  <tr>
    <td class="style3"><?php echo LANG_group_desc; ?></td>
    <td><textarea name="desc" cols="60" rows="4" class="style1" id="desc"></textarea></td>
  </tr>
  <tr>
  <td colspan="2">
       <input type="button" name="Submit2"  value="<?=LANG_back?>" onClick="location.replace('links.php')">
       <input type="submit" name="Submit" value="<?=LANG_save?>">
  </td>     
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
