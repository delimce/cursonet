<?php session_start(); //sesion generica por user que accede
 
  $profile = 'admin'; /////////////// perfil requerido
  include("../../config/setup.php"); ////////setup
  include("../../class/clases.php"); ////////clase
 
  $val = new tools("db");
  $algo = $val->array_query("select id from tbl_admin where user = trim('{$_REQUEST['nombre']}')  limit 1");
  
  $val->cerrar();
  
 if($algo[0]=="")$algo[0]=0; else $algo[0]=1;
  
 echo $algo[0];

?>
