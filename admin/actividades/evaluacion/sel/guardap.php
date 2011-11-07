<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../../config/setup.php"); ////////setup
include("../../../../class/clases.php"); ////////clase
include ("../../../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

		
		
		
	$eva  = new tools("db");



   if(isset($_POST['enum'])){
	
			
				$valores[0] = $_POST['eva'];
				$valores[1] = 1; //seleccion
				$valores[2] = utf8_decode($_POST['enum']);
				$valores[3] = $_POST['nivel'];
				$valores[4] = $_SESSION['CURSOID']; ///se guarda la pregunta por curso
				
				 
				 $eva->query("SET AUTOCOMMIT=0"); ////iniciando la transaccion
                 $eva->query("START TRANSACTION");
                 $eva->query("LOCK TABLES tbl_evaluacion_pregunta WRITE, tbl_pregunta_opcion WRITE");
 
				 
				$eva->insertar2("tbl_evaluacion_pregunta","eval_id,tipo,pregunta,nivel,curso_id",$valores);
				$nuevap = $eva->ultimoID;
		
				for($j=0;$j<count($_SESSION['OPCIONES']);$j++){
				
					if($j==$_SESSION['CORRECT']) $correcto = 1; else $correcto = 0;
				
					$valores2[0] = $nuevap;
					$valores2[1] = $_SESSION['OPCIONES'][$j]; //seleccion
					$valores2[2] = $correcto;
				
					$eva->insertar2("tbl_pregunta_opcion","preg_id,opcion,correcta",$valores2);
				
				}
				
				$eva->query("UNLOCK TABLES");   ///desbloqueo
                $eva->query("COMMIT");
				
		
		
		unset($_SESSION['OPCIONES']);
		unset($_SESSION['CORRECT']);
		
	
	}


	$eva->cerrar();

?>