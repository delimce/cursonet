<?php session_start();
$profile = 'est'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/tools.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje


  $grabar = new tools();
  $grabar->autoconexion(); 
  
  
  
   if(isset($_GET['itemID'])){
   
    $grabar->query("SET AUTOCOMMIT=0"); ////iniciando la transaccion
    $grabar->query("START TRANSACTION");
  
   $grabar->query("delete from mensaje_est where id = {$_GET['itemID']}");
 
   
  
   $grabar->query("COMMIT"); 
   
   
  }
  


 $grabar->cerrar(); 
 
 $grabar->redirect("index.php");

?>