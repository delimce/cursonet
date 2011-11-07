<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);

  $grabar = new tools("db");
  
   if(isset($_GET['itemID'])){
   
      $grabar->query("delete from tbl_mensaje_admin where id = {$_GET['itemID']}");
 
      
  }
  


 $grabar->cerrar(); 
 
 $grabar->javaviso(LANG_drop_msg,"index.php");

?>