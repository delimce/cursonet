<?php session_start();
$profile = 'est'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php");
 
  $val = new tools("db");
  
  $algo = $val->array_query("select id from estudiante where user = trim('{$_REQUEST['nombre']}') and id != {$_SESSION['USER']} limit 1");
  
  $val->cerrar();
  
 if($algo[0]=="")$algo[0]=0; else $algo[0]=1;
  
 echo $algo[0];



?>