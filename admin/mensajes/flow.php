<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje


 $crear = new tools("db");
 

     
	 $valores[0] = $_POST['destino'];
	 $valores[1] = $_POST['priori'];
	 $valores[2] = $_SESSION['USERID'];
	 $valores[3] = $_POST['persona'];
	 $valores[4] = $_POST['titulo'];
	 $valores[5] = $_POST["content"];
	 $valores[6] = date("Y-m-d h:i:s");
	 $valores[7] = 0;
	 
 
	 
	 switch ($_POST['destino']) {
	
		case 0: ///admin
		  
		   $crear->insertar2("tbl_mensaje_admin","tipo, urgencia, de, para, subject, content, fecha, leido",$valores);
		   break;
		   
		case 1: //est
		
		   $crear->insertar2("tbl_mensaje_est","tipo, urgencia, de, para, subject, content, fecha, leido",$valores);
		   break;
		   
		case 2:
		
		   $valores[0] = 1;
		   		
		   	
		   			 $est = $crear->array_query("SELECT  distinct e.id
										FROM
 										 tbl_grupo_estudiante g
  										 INNER JOIN tbl_estudiante e ON (g.est_id = e.id)
										WHERE
										 g.grupo_id = '{$_POST['persona']}' AND 
  										 g.curso_id = '{$_SESSION['CURSOID']}' ");
		   			 
		   			$admin1 = $crear->simple_db("SELECT g.prof_id  FROM  tbl_grupo g  WHERE  g.id = {$_POST['persona']}"); 
		   	
		   
		   

		   if(count($est)==0)$crear->javaviso(LANG_msg_error_est);
		   
		  		  
		   $crear->query("SET AUTOCOMMIT=0"); ////iniciando la transaccion
           $crear->query("START TRANSACTION");
		   
		   for($i=0;$i<count($est);$i++){
		   
		   		$valores[3] = $est[$i];
		   		$crear->insertar2("tbl_mensaje_est","tipo, urgencia, de, para, subject, content, fecha, leido",$valores);
		   }
		   
		  		if($admin1>0){
		  					  			
		  			$valores[0] = 0;
		  			$valores[3] = $admin1;		
		   			$crear->insertar2("tbl_mensaje_admin","tipo, urgencia, de, para, subject, content, fecha, leido",$valores);
		
		  		}
		   			   	   
		   $crear->query("COMMIT");
		   break;
	   
	}


   $crear->cerrar();
   $crear->javaviso(LANG_send_sucessfully,"index.php");


?>
