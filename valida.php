<?php session_start();
 include("config/dbconfig.php");
 include("class/clases.php");

 $i = new formulario('db');

 if(isset($_POST['login1'])){
 
 		 $login = $i->getvar("login1",$_POST);
                
		 $DATOS = $i->simple_db("select lenguaje,e.id,concat(nombre,' ',apellido) as nombre,id_number,activo,email,sexo
		 from tbl_estudiante e,tbl_setup where user = '$login' and pass = MD5('{$_POST['pass1']}')");
		 		 
		 $_SESSION['LENGUAJE'] = $DATOS['lenguaje']; //lenguaje

		 if($i->nreg>0 && $DATOS['activo']==1){

		$_SESSION['PROFILE'] = 'est'; //perfil de ingreso
		$_SESSION['USER'] = $DATOS['id'];
		$_SESSION['CI'] = $DATOS['id_number'];
		$_SESSION['NOMBRE']  = $DATOS['nombre'];
		$_SESSION['EMAIL'] = $DATOS['email'];
		$_SESSION['SEXO'] = $DATOS['sexo'];
		
		$CURSOS = $i->array_query("select distinct curso_id from tbl_grupo_estudiante where est_id = {$_SESSION['USER']} ");
		$GRUPOS = $i->array_query("select distinct grupo_id from tbl_grupo_estudiante where est_id = {$_SESSION['USER']} ");
		
		$_SESSION['CURSOSID'] = @implode(',',$CURSOS); 
		$_SESSION['GRUPOSID'] = @implode(',',$GRUPOS);  //////asumiendo que grupo es 0 por defecto
		if(empty($_SESSION['CURSOSID'])) $_SESSION['CURSOSID'] = 0;
                
                //////se elimina el ultimo curso seleccionado
                if(isset($_SESSION['CURSOID']))unset($_SESSION['CURSOID']);
		
                
		///////////////// creando log
		
		$vector[0] = $_SESSION['USER'];
		$vector[1] = @date("Y-m-d h:i:s");
		$vector[2] = $_SERVER['REMOTE_ADDR'];
		$vector[3] = $_SERVER['HTTP_USER_AGENT'];
		
		$i->insertar2("tbl_log_est","est_id,fecha_in,ip_acc,info_cliente",$vector);
		$_SESSION['EST_ACTUAL'] = $i->ultimoID; ////ESTUDIANTE QUE RECIEN INGRESO EN EL LOG
		////////////////////////////

		echo 1;

		}else if($i->nreg>0 && $DATOS['activo']!=1){

		echo 2;

		}else{
		 
		 echo 0;
		 
		}


 }


$i->cerrar();

?>
