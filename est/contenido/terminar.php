<?php session_start();
$profile = 'est'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php");
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

 $datos = new tools();
 $datos->autoconexion();


  ///////////////////////
    
  
						$r=0;
						while(list($key, $value) = each($HTTP_POST_VARS))
						{

						 if($key!="b1" && $key!="b2" && $key!="eval_id" && $key!="tiempo"){
						 
						 		$preg = explode("_",$key);
						 		
							   $pregs_id[$r] = $preg[1];
							   $valores3[$r] = trim($value);
							   
							   unset($preg);
						 }
								  $r++;
						}


		
					   $datos->query("SET AUTOCOMMIT=0"); ////iniciando la transaccion
					   $datos->query("START TRANSACTION");

					   $datos->query("LOCK TABLES evaluacion_revision WRITE, evaluacion_respuesta WRITE");

					   $valores[0] = $_POST['eval_id'];
					   $valores[1] = $_SESSION['USER'];
					   $valores[2] = $_POST['tiempo'];

					  $datos->insertar2("evaluacion_revision","eval_id, estudiante_id, tiempo",$valores);
					  $idexp = $datos->ultimoID;

					   ///////////////insertar preg

					   for($j=0;$j<count($valores3);$j++){

									   
									   $valores2[0] = $idexp;
									   $valores2[1] = $pregs_id[$j];
									   $valores2[2] = $valores3[$j];

									$datos->insertar2("evaluacion_respuesta","rev_id, pregunta_id, respuesta",$valores2);

					   }
					   ////////////////////


					   $datos->query("UNLOCK TABLES");   ///desbloqueo

					   $datos->query("COMMIT");

					   $datos->javaviso(LANG_est_evasuccess,"eval.php");
								   
	////////////////////////////




 $datos->cerrar();
 
 
 ?>
