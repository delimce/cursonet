<?php session_start();
 include("../config/dbconfig.php");
 include("../class/clases.php");

 
 $i = new tools("db");
 $fecha = new fecha($_SESSION['FECHA']);
 
 $val = $i->array_query2("select modo,lenguaje,timezone from tbl_setup");
 
  
 // @date_default_timezone_set($val[2]);


 
/*permitir inscripcion en modo curso 
 if($val[0]!=0){
 
	$nuevo->cerrar();
	$nuevo->redirect('../error/error.php');

 }
 
 */
 
  include("../config/lang/$val[1]"); ///idioma
 
 ?>
<html>
<head>
<style type="text/css">
<!--
body {
	background-color: #F0F0F0;
}
-->
</style>
</head>

<body>

<?php 

 if(isset($_POST['login1'])){
 
 $i->query("select id from estudiante where user = '{$_POST['login1']}' or id_number = '{$_POST['ci']}'");
 
		 if($i->nreg>0){
		 
			 $mensaje = $_POST['login1'].' '.LANG_VAL_user2; 
			 $i->cerrar();
			 $i->javaviso($mensaje);
			
		 
		 }else{ ////inserta el estudiante
		 
		 
		
		$valores2[0]= $_POST['ci'];
		$valores2[1]= $_POST['nombre'];
		$valores2[2]= $_POST['apellido'];
		$valores2[3]= $_POST['sexo'];
		$valores2[4]= $fecha->fecha_db($_POST['fecha_nac']);
		$valores2[5]= $_POST['tele2'];
		$valores2[6]= $_POST['tele1'];
		$valores2[7]= $_POST['email'];
		$valores2[8]= $_POST['msn'];
		$valores2[9]= $_POST['yahoo'];
		$valores2[10]= $_POST['carrera'];
		$valores2[11]= $_POST['nivel'];
		$valores2[12]= $_POST['universidad'];
		$valores2[13]= $_POST['iacc'];
		$valores2[14]= $_POST['dacc'];
		$valores2[15]= trim($_POST['login1']);
		$valores2[16]= md5($_POST['pass1']);
		$valores2[17]= date("Y-m-d h:i:s");
		$valores2[18]= $_POST['preg'];
		$valores2[19]= strtolower($_POST['resp']); //se guarda en minuscula para comparar en minuscula
		
		
		$i->insertar2("estudiante","id_number, nombre, apellido, sexo, fecha_nac, telefono_p, telefono_c, email, msn, yahoo, carrera, nivel, universidad, internet_acc, internet_zona, user, pass, fecha_creado,clave_preg,clave_resp",$valores2); 
		$_SESSION['USUARIO'] =  $_POST['nombre'];
		
		
		
		/////////////////enviar correo para avisar de la inscripcion con login y password
		
		include('email.php');	
		
		///////////////////////////////////////////////////////////////////////////////
		
		  
		$i->redirect("final.php","parent");
	
		 
		 }
 
 }else{
 
 die();
 
 }


?>


</body>
</html>
<?php 

$i->cerrar();

?>
