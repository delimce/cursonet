<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php");
include("security.php"); ///seguridad para el admin

 $datos = new tools('db');

	
	if(isset($_POST['table'])){
		
		
		$datos->abrir_transaccion();
	
			///FIXME: cambiar por delete from {$_POST['table']} en mysql version 5.5
			$datos->query("TRUNCATE TABLE {$_POST['table']} ");		
			
			if($_POST['table']=="recurso"){
				////triger en caso de recursos se borran fisicamente
				$datos->del_archivos_dir('../../recursos/admin/archivos'); /// vacia el directorio
				$datos->del_archivos_dir('../../recursos/est/proy'); /// vacia el directorio
			
			}
		 
		 
		 	if($_POST['table']=="tbl_estudiante"){ //////triger en caso de que se vacien los estudiantes, borra las fotos
			
					$datos->del_archivos_dir('../../recursos/est/fotos'); /// vacia el directorio
					$datos->del_archivos_dir('../../recursos/est/proy'); /// vacia el directorio
			
			}
		 
		 	 
			 if($_POST['table']=="grupo"){ //////triger en caso de que se vacien los grupo
				
				//$datos->query("update tbl_estudiante set grupo = ''");
				$datos->query("update tbl_foro set grupo_id = 0");
				$datos->query("update tbl_evaluacion set grupo_id = 0");
				$datos->query("update tbl_proyecto set grupo = 0");
			
			 }
			 
			
			 if($_POST['table']=="evaluacion"){ //////triger que borra las evaluaciones de desarrollo
			 
			 		$datos->query("delete from tbl_evaluacion_pregunta where tipo = 0");
			 
			 }
			 
			 
		$datos->cerrar_transaccion(); 
			  
			 
	}


 $datos->cerrar();
 
?>