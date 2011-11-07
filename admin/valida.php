<?php session_start();
 include("../config/dbconfig.php");
 include("../class/clases.php");
 
 $i = new formulario('db');
 
 
 if(isset($_POST['user'])){
 
		 $usuario = $i->getvar("user",$_POST);
		 $curso2 = $_POST['curso'];
		 
		 $DATOS = $i->simple_db("select lenguaje,cursos,a.id,CONCAT(nombre,' ',apellido) as nombre,es_admin,date_format(fecha_ult_acc,'%d/%m/%y %h:%i %p') as acc from tbl_admin a,tbl_setup where user = '$usuario' and pass = MD5('{$_POST['pass']}')");
 
		 if($i->nreg>0){
		 
			
				if($DATOS['cursos']!="")$loscursos = explode(',',$DATOS['cursos']);
				$_SESSION['LENGUAJE'] = $DATOS['lenguaje']; //lenguaje
			
				if($DATOS['es_admin']==1){
				
				
							$_SESSION['PROFILE'] = 'admin'; ///perfil de ingreso
							$_SESSION['USERID'] = $DATOS['id'];
							$_SESSION['NOMBRE']  = $DATOS['nombre'];
							$_SESSION['ADMIN']  = $DATOS['es_admin'];
							$_SESSION['CURSOSP']  = $DATOS['cursos'];
							$_SESSION['CURSOID']  = $curso2;
							$_SESSION['FECHACC']  = $DATOS['acc'];
							echo "1"; ///puede entrar
				
				}else if(in_array($curso2,$loscursos)){
				
							$_SESSION['PROFILE'] = 'admin'; ///perfil de ingreso
							$_SESSION['USERID'] = $DATOS['id'];
							$_SESSION['NOMBRE']  = $DATOS['nombre'];
							$_SESSION['ADMIN']  = $DATOS['es_admin'];
							$_SESSION['CURSOSP']  = $DATOS['cursos'];
							$_SESSION['CURSOID']  = $curso2;
							$_SESSION['FECHACC']  = $DATOS['acc'];
							echo "1"; ///puede entrar
					
				}else{
				
							echo "2";
				
				}
				
				$i->query("update tbl_admin set fecha_ult_acc = NOW() where id = {$DATOS['id']}"); ///guarda el ultimo acceso

		
		 
		 }else{
		 
			echo "0";
		 
		 }
		 
		 
 }		 
		 
		 
$i->cerrar();

?>
