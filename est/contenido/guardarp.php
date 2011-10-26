<?php session_start();
$profile = 'est'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php");
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

$datos = new tools();
$datos->autoconexion();



					$r=0;
						while(list($key, $value) = each($_POST))
						{

						 if($key!="Submit" && $key!="eval_id"){
						 
						 		$preg = explode("_",$key);
						 		
								 $pregs_tipo[$r] = $preg[1]; //tipos
								 $pregs_ids[$r]  = $preg[2]; //ids preg
								 $respuestas[$r] = trim($value); //resp
	
							   
							   unset($preg);
						 }
								  $r++;
						}
						
						
						
//////transaccion
   
 				$datos->query("SET AUTOCOMMIT=0"); ////iniciando la transaccion
                $datos->query("START TRANSACTION");
            			
				
				/////guardando respuestas
				
				for($j=0;$j<count($pregs_tipo);$j++){
				
					if($pregs_tipo[$j]==1){ ///examen de seleccion
					
							$tabla = "evaluacion_respuesta_s";
							$campos = "est_id,preg_id,resp_opc";
									
					}else{
					
						    $tabla = "evaluacion_respuesta";
							$campos = "est_id,preg_id,respuesta";

					}	
					
					$valores3[0] = $_SESSION['USER'];
					$valores3[1] = $pregs_ids[$j]; //seleccion
					$valores3[2] = $respuestas[$j];
					
					$datos->insertar2($tabla,$campos,$valores3);	
				
				}
				
				$valores4[0] = $_SESSION['USER'];
				$valores4[1] = $_REQUEST['eval_id']; //seleccion
				
				//// guardando registro para el plan y correccion, la tabla evaluacion_revision sale
				$datos->insertar2("evaluacion_estudiante","est_id,eval_id",$valores4);
				
				
				//////
				
                $datos->query("COMMIT");

/////////////////						
						
$datos->cerrar();
$datos->javaviso(LANG_est_evalsuccess,"eval.php");


?>
