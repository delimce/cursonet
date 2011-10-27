<?php session_start();
$profile = 'est'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

 $crear = new tools('db');
 
 
 if(!empty($_POST["content"])){ ///el estudiante debe escribir algo
     
	 $valores[0] = $_POST['destino'];
	 $valores[1] = $_POST['priori'];
	 $valores[2] = $_SESSION['USER'];
	 $valores[3] = $_POST['persona'];
	 $valores[4] = $_POST['titulo'];
	 $valores[5] = $_POST["content"];
	 $valores[6] = date("Y-m-d h:i:s");
	 $valores[7] = 0;
	 
 	 
	$crear->abrir_transaccion(); 
	 
	 switch ($_POST['destino']) {
	
		case 1: ///admin
		  
		   $crear->insertar2("tbl_mensaje_admin","tipo, urgencia, de, para, subject, content, fecha, leido",$valores);
		   break;
		   
		case 0: //est
		
		   $crear->insertar2("tbl_mensaje_est","tipo, urgencia, de, para, subject, content, fecha, leido",$valores);
		   break;
	   
	}
	
	/////INDICADORES: para saber si contabilizo las veces en que el estudiante hace una consulta
	if(isset($_POST['consulta']))  $crear->query("update tbl_log_est set soporte_a = soporte_a+1 where id = {$_SESSION['EST_ACTUAL']} ");
	
	$crear->cerrar_transaccion(); 


 }

   $crear->cerrar();
   
   if(!empty($_REQUEST['cerrar'])) $destiny = 'cerrar'; else $destiny = 'index.php'; 
    
   $crear->javaviso(LANG_send_sucessfully,$destiny);


?>


