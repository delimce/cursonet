<?php session_start(); //sesion generica por user que accede
 
  $profile = 'admin'; /////////////// perfil requerido
  include("../../config/setup.php"); ////////setup
  include("../../class/tools.php"); ////////clase
 
  $val = new tools();
  $val->autoconexion();
  
  
  $algo = $val->array_query("select id from admin where user = trim('{$_REQUEST['nombre']}')  limit 1");
  
  $val->cerrar();
  
 if($algo[0]=="")$algo[0]=0; else $algo[0]=1;
  
 echo $algo[0];

?>
