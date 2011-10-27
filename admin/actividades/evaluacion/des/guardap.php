<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../../config/setup.php"); ////////setup
include("../../../../class/clases.php"); ////////clase
include ("../../../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje
 
 
 $crear = new tools("db");
 
 
   			/////fecha
		    $fecha2 = explode("/",$_SESSION['eva_fecha']);
            if($_SESSION['DB_FORMATO']=="d/m/Y") $FECHA = $fecha2[2].'-'.$fecha2[1].'-'.$fecha2[0]; else $FECHA = $fecha2[2].'-'.$fecha2[0].'-'.$fecha2[1];
		   //////////
		   
		   /////fecha2
		    $fecha3 = explode("/",$_SESSION['eva_fecha2']);
            if($_SESSION['DB_FORMATO']=="d/m/Y") $FECHA2 = $fecha3[2].'-'.$fecha3[1].'-'.$fecha3[0]; else $FECHA = $fecha3[2].'-'.$fecha3[0].'-'.$fecha3[1];
		   //////////

                                          ///////////////////////
                                                $r=0;
                                                while(list($key, $value) = each($_POST))
                                                {

                                                 if($key!="b1" && $key!="b2"){
                                                       $valores3[$r] = $value;
                                                 }
                                                          $r++;
                                                }

      

                                   $crear->query("SET AUTOCOMMIT=0"); ////iniciando la transaccion
                                   $crear->query("START TRANSACTION");

                                   $crear->query("LOCK TABLES evaluacion WRITE, evaluacion_pregunta WRITE");

                                   $valores[0] = $_SESSION['eva_nombre'];
                                   $valores[1] = $_SESSION['eva_caso'];
                                   $valores[2] = $_SESSION['eva_seccion'];
                                   $valores[3] =  $FECHA;
								   $valores[4] =  $FECHA2.' 23:59'; ///para que sea todo el dia
                                   $valores[5] = $_SESSION['USERID'];
								   $valores[6] = $_SESSION['CURSOID'];
								   $valores[7] = 2; ///tipo desarrollo
								   $valores[8] = $_SESSION['eva_preg'];

                                  $crear->insertar2("evaluacion","nombre, contenido_id, grupo_id, fecha, fecha_fin, autor,curso_id,tipo,npreg",$valores);
                                  $idexp = $crear->ultimoID;

                                   ///////////////insertar preg

                                   for($j=0;$j<$_SESSION['eva_preg'];$j++){

                                                   $valores2[0] = $idexp;
                                                   $valores2[1] = 0;
                                                   $valores2[2] = $valores3[$j];
												   $valores2[3] = $_SESSION['CURSOID']; ///se guarda la pregunta por curso

                                                $crear->insertar2("evaluacion_pregunta","eval_id,tipo,pregunta,curso_id",$valores2);

                                   }
                                   ////////////////////


                                   $crear->query("UNLOCK TABLES");   ///desbloqueo


                                   $crear->query("COMMIT");

                                   $crear->javaviso(LANG_cambios,"index.php");
								   
	////////////////////////////
                 
 
 $crear->cerrar();

?>