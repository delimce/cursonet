<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/tools.php"); ////////clase
include("../../class/fecha.php"); ////////clase


	$est = new tools();
	$fecha = new fecha($_SESSION['DB_FORMATO']);
	$est->autoconexion();
	
	
	if($_POST['desde']!="") $desde = "and fecha_in >= '".$fecha->fecha_db($_POST['desde'],1)."'";
	if($_POST['hasta']!="") $hasta = "and fecha_in <= '".$fecha->fecha_db($_POST['hasta'])."'";
	
	
	$total = $est->array_query("select count(*) from log_est where id > 0 $desde $hasta  ");
	
	echo $total[0];
	
	$est->cerrar();
	
?>	
