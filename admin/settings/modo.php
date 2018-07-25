<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);
include("security.php"); ///seguridad para el admin

 $modo = new tools("db");

 $valor = $modo->array_query("select modo from tbl_setup");

 if(isset($_POST['modo'])){
 
 $campos[0] = 'modo'; $vector[0] = $_POST['modo']; 
 $modo->update("tbl_setup",$campos,$vector,"");
 $modo->javaviso(LANG_cambios,"modo.php");

 
 }



?>
<!DOCTYPE html>
<html>
<head> <meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="../../css/style_back.css">
<script language="JavaScript" type="text/javascript" src="../../js/utils.js"></script>
</head>

<body>
<table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="26" valign="top"><?php echo $menu->nombre; ?></td>
  </tr>
  <tr>
    <td><?php $menu->mostrar(2); ?></td>
  </tr>
  <tr>
    <td>
	
	<table style="border-right:#000000 solid 1px; border-left:#000000 solid 1px; border-bottom:#000000 solid 1px;" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
		
		<form name="form1" method="post" action="<?=$_SERVER['PHP_SELF']; ?>">
		<table width="99%" border="0" align="center" cellpadding="3" cellspacing="4">
		  <tr>
			<td colspan="2" class="style1"><?php echo LANG_modo_selec ?>&nbsp;</td>
			</tr>
		  <tr>
			<td width="4%" align="center"><input name="modo" type="radio" class="style3" value="0" <?php if($valor[0]==0)echo "checked"; ?>></td>
			<td width="96%" class="style3"><?php echo LANG_modo_i ?></td>
		  </tr>
		  <tr>
			<td align="center"><input name="modo" type="radio" class="style3" value="1" <?php if($valor[0]==1)echo "checked"; ?>></td>
			<td class="style3"><?php echo LANG_modo_e ?></td>
		  </tr>
		  <tr>
		    <td align="center"><input name="modo" type="radio" class="style3" value="2" <?php if($valor[0]==2)echo "checked"; ?>></td>
		    <td class="style3"><?php echo LANG_modo_off ?></td>
		    </tr>
		  <tr>
			<td colspan="2"><input type="submit" id="Submit" name="Submit" value="<?php echo LANG_save ?>"></td>
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
