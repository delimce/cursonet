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
   
    $grabar->query("SET AUTOCOMMIT=0"); ////iniciando la transaccion
    $grabar->query("START TRANSACTION");
  
    $grabar->query("delete from plan_item where id = {$_GET['itemID']}");
    $grabar->query("COMMIT"); 
   
   
  }
  


 $grabar->cerrar(); 
 
 $grabar->javaviso(LANG_drop_msg,"items.php?id=".$_GET['item']);

?>

