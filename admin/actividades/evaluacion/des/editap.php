<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../../config/setup.php"); ////////setup
include("../../../../class/tools.php"); ////////clase
include ("../../../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);


 $crear = new tools();
 $crear->autoconexion();
 
				  
						/////fecha
						$fecha2 = explode("/",$_SESSION['eva_fecha']);
						if($_SESSION['DB_FORMATO']=="d/m/Y") $FECHA = $fecha2[2].'-'.$fecha2[1].'-'.$fecha2[0]; else $FECHA = $fecha2[2].'-'.$fecha2[0].'-'.$fecha2[1];
					   //////////
					   
					   /////fecha2
						$fecha3 = explode("/",$_SESSION['eva_fecha2']);
						if($_SESSION['DB_FORMATO']=="d/m/Y") $FECHA2 = $fecha3[2].'-'.$fecha3[1].'-'.$fecha3[0]; else $FECHA = $fecha3[2].'-'.$fecha3[0].'-'.$fecha3[1];
					   //////////

						$r=0;
						while(list($key, $value) = each($_POST))
						{

						 if($key!="b1" && $key!="b2"){
							 $valores3[$r] = $value;
							 $ides2[$r] = $key;
						 }
							  $r++;
						}

					   //////////////


				
				   $crear->query("SET AUTOCOMMIT=0"); ////iniciando la transaccion
				   $crear->query("START TRANSACTION");

			       $campos = explode(',',"nombre, contenido_id, grupo_id, fecha, fecha_fin,npreg");

				   $valores[0] = $_SESSION['eva_nombre'];
				   $valores[1] = $_SESSION['eva_caso'];
				   $valores[2] = $_SESSION['eva_seccion'];
				   $valores[3] = $FECHA;
				   $valores[4] = $FECHA2.' 23:59'; ///para que sea todo el dia
				   $valores[5] = $_SESSION['eva_preg'];

				  $crear->update("evaluacion",$campos,$valores,"id = '{$_SESSION['eval_id']}'");
				  $idspreg = $crear->array_query("select id from evaluacion_pregunta where eval_id = '{$_SESSION['eval_id']}' order by id ");

				   ///////////////editar preg


				   for($j=0;$j<$_SESSION['eva_preg'];$j++){

                        if(in_array($ides2[$j],$idspreg)){

						   $campos2[0] = 'pregunta';
						   $valores2[0] = $valores3[$j];
					       $crear->update("evaluacion_pregunta",$campos2,$valores2,"id = '$idspreg[$j]'");

				        }else{

				           $valores4[0] = $valores3[$j];
				           $valores4[1] = $_SESSION['eval_id'];
	 
					      $crear->insertar2("evaluacion_pregunta","pregunta,eval_id",$valores4);


				        }

				   }
				   ////////////////////


				   $crear->query("COMMIT");
				   $crear->javaviso(LANG_cambios,"index.php");

		 



 $crear->cerrar();

?>
