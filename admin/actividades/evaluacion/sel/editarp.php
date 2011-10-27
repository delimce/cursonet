<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../../config/setup.php"); ////////setup
include("../../../../class/clases.php"); ////////clase
include ("../../../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

		
		
		
	$eva  = new tools("db");


   if(isset($_POST['enum'])){
	
			
				$valores[0] = $_POST['eva'];
				$valores[1] = utf8_decode($_POST['enum']);
				$valores[2] = $_POST['nivel'];
				$campos = explode(',',"eval_id,pregunta,nivel");
				 
				 $eva->query("SET AUTOCOMMIT=0"); ////iniciando la transaccion
                 $eva->query("START TRANSACTION");
                 $eva->query("LOCK TABLES evaluacion_pregunta WRITE, pregunta_opcion WRITE");
 
				 
				$eva->update("evaluacion_pregunta",$campos,$valores,"id = '{$_SESSION['PREGUNTA_ID']}'");
				
				$eva->query("delete from pregunta_opcion where preg_id = {$_SESSION['PREGUNTA_ID']} ");
				
				$nuevap = $_SESSION['PREGUNTA_ID'];
		
				for($j=0;$j<count($_SESSION['OPCIONES']);$j++){
				
					if($j==$_SESSION['CORRECT']) $correcto = 1; else $correcto = 0;
				
					$valores2[0] = $nuevap;
					$valores2[1] = $_SESSION['OPCIONES'][$j]; //seleccion
					$valores2[2] = $correcto;
				
					$eva->insertar2("pregunta_opcion","preg_id,opcion,correcta",$valores2);
				
				}
				
				$eva->query("UNLOCK TABLES");   ///desbloqueo
                $eva->query("COMMIT");
				
		
		
		unset($_SESSION['OPCIONES']);
		unset($_SESSION['CORRECT']);
		unset($_SESSION['PREGUNTA_ID']);
		
	
	}


	$eva->cerrar();

?>