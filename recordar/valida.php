<?php session_start();
 include("../config/dbconfig.php");
 include("../class/clases.php");

 $i = new formulario('db');

 if(isset($_POST['cedula'])){

		$cedula = $i->getvar("cedula",$_POST);
		 $DATOS = $i->simple_db("select lenguaje,e.id,concat(nombre,' ',apellido) as nombre, e.clave_preg
		 from tbl_estudiante e,setup where id_number = '$cedula'");
		 
		 

			 if($i->nreg>0){
	
			$_SESSION['USERP'] = $DATOS['id']; ////id de usuario provisional
			$_SESSION['NOMBRE']  = $DATOS['nombre'];
			$_SESSION['CPREGUNTA']  = $DATOS['clave_preg'];	 				
				
			echo 1;
	
			}else{
			 
			 echo 0;
			 
			}


 }else if(isset($_POST['resp'])){
 
 			 $resp1 = $i->getvar("resp",$_POST);
 
 			 $DATOS = $i->simple_db("select id_number,user
		 								from tbl_estudiante e 
										where (e.id = {$_SESSION['USERP']} ) and (clave_resp = LOWER('$resp1'))");


			 if($i->nreg>0){
				
				$_SESSION['RCEDULA'] = $cedula1 =  $DATOS['id_number'];
				$_SESSION['RLOGIN'] = $DATOS['user'];
				
				$i->query("update tbl_estudiante set pass = md5('$cedula1') where id = '{$_SESSION['USERP']}' ");				
				
				echo 1;
	
			}else{
			 
				 echo 0;
			 
			}
 
 
 
 }


$i->cerrar();

?>
