<?php session_start();
$profile = 'est'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php");
include("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

$est = new tools('db');
$fecha = new fecha($_SESSION['DB_FORMATO']);

if(isset($_POST['login12'])){
 
     ////edit el estudiante
	 
	 	$fotin = $_POST['image2'];
	 ///////////////subir foto
		if(!empty($_FILES['archivo']['name'])){	
	
					$sesubio = $est->upload_file($_FILES['archivo'],'../../recursos/est/fotos/'.$_FILES['archivo']['name'],1,'image/gif,image/jpeg,image/png,image/pjpeg,image/jpg,image/pjpg');
					if($sesubio == true){
					
						@unlink('../../recursos/est/fotos/'.$_POST['image2']); ///borra la imagen subida original
						
						$prefi = @date("dhis_");
						$ruta = '../../recursos/est/fotos/'.$_FILES['archivo']['name'];
						//$ruta2 = '../../SVcontent/categoria/med/'.$_FILES['archivo']['name'];
						$ruta3 = '../../recursos/est/fotos/'.$prefi.$_FILES['archivo']['name'];
						
						$imagen = new image($ruta);
						$imagen->redimensionar($ruta3, 75, 75, 100); ///redimension
						
						$imagen->destruir();
						
						@unlink($ruta); ///borra la imagen subida original
						
						$fotin = $prefi.$_FILES['archivo']['name'];
				
					}
		}
	  //////////////
		 
		 
		$campos = explode(",","id_number, nombre, apellido, fecha_nac, email, carrera, nivel, universidad, user, internet_acc,internet_zona,telefono_c,telefono_p,msn,yahoo,foto,clave_preg,clave_resp");  
		
		$valores2[0]= $_POST['ci'];
		$valores2[1]= $_POST['nombre'];
		$valores2[2]= $_POST['apellido'];
		$valores2[3]= $fecha->fecha_db($_POST['fecha_nac']);
		$valores2[4]= $_POST['email'];
		$valores2[5]= $_POST['carrera'];
		$valores2[6]= $_POST['nivel'];
		$valores2[7]= $_POST['universidad'];
		$valores2[8]= $_POST['login12'];
		$valores2[9]= $_POST['iacc'];
		$valores2[10]= $_POST['dacc'];
		$valores2[11]= $_POST['tele1'];
		$valores2[12]= $_POST['tele2'];
		$valores2[13]= $_POST['msn'];
		$valores2[14]= $_POST['yahoo'];
		$valores2[15]= $fotin;
		$valores2[16]= $_POST['spreg'];
		$valores2[17]= $_POST['sresp'];
		
		 $est->query("SET AUTOCOMMIT=0"); ////iniciando la transaccion
         $est->query("START TRANSACTION");
		
		$est->update("tbl_estudiante",$campos,$valores2,"id = '{$_SESSION['USER']}' "); 
		
		 if($_POST['boton']==1){
	
	        $npass = md5($_POST['pass1']);
	        $est->query("update tbl_estudiante set pass = '$npass' where id = {$_SESSION['USER']}");
		 
		 }
		 		 
		 $est->query("COMMIT"); 
		 $est->cerrar();
		 $est->javaviso(LANG_cambios,"index.php");
		 
 }
 
 

?>