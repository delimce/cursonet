<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

  $grabar = new formulario('db');
  
   if(isset($_GET['itemID'])){
   
    $v = $grabar->getvar("v",$_GET);
    $foto = $grabar->simple_db("select foto from tbl_estudiante where id = '{$_GET['itemID']}' ");
    @unlink('../../recursos/est/fotos/'.$foto); ///borra la imagen
  
   $grabar->abrir_transaccion();
   $grabar->query("delete from tbl_estudiante where id = '{$_GET['itemID']}'");
   $grabar->query("delete from tbl_foro_comentario where sujeto_id = '{$_GET['itemID']}' and tipo_sujeto = 'est' "); //borrar comentarios del foro
   $grabar->cerrar_transaccion();
   
  $grabar->cerrar();
  $grabar->javaviso(LANG_drop_msg,"index$v.php");
  
  
  }
  
  
?>
