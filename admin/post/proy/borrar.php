<?
session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../config/setup.php"); ////////setup
include("../../../class/clases.php"); ////////clase
include ("../../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje


  $grabar = new tools("db");
  
  
   if(isset($_GET['itemID'])){
  
   $data  = $grabar->simple_db("SELECT DISTINCT 
 								 p.rec_id,
  r.dir
FROM
  tbl_proyecto_estudiante p
  INNER JOIN recurso r ON (p.rec_id = r.id)
WHERE
  p.id = {$_GET['itemID']}");
   
   
   $datos = $grabar->query("delete from tbl_proyecto_estudiante where id = '{$_GET['itemID']}'");
   $datos = $grabar->query("delete from tbl_recurso where id = '{$data['rec_id']}'"); //borra el recurso de la tabla
   @unlink('../../recursos/est/proy'.$data['dir']); //borra el recurso fisicamente
   
   $grabar->cerrar();
   
   $grabar->javaviso(LANG_drop_msg,"proys.php");
  
  
  }
  
  
?>