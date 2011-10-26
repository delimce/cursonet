<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);

  $grabar = new tools();
  $grabar->autoconexion(); 
  
  
   if(isset($_GET['itemID'])){
   
   $file = $grabar->array_query("select dir from tbl_recurso where id = '{$_GET['itemID']}'");
    
   $grabar->query("delete from tbl_recurso where id = '{$_GET['itemID']}'");
   $path = "../../".$ADMINPATH.'archivos/'.$file[0];
   @unlink($path);
   $grabar->javaviso(LANG_content_delfiles,"index.php");
  
     
   
  }
  
  
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../../css/style_back.css">
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
        <td>&nbsp;</td>
      </tr>
    </table>	</td>
  </tr>
</table>
<?php 

 $grabar->cerrar(); 

?>

