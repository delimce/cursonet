<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include("../../class/fecha.php"); ////////clase


	$est = new tools("db");
	$fecha = new fecha($_SESSION['DB_FORMATO']);
	
	if($_POST['desde']!="") $desde = "and fecha_in >= '".$fecha->fecha_db($_POST['desde'],1)."'";
	if($_POST['hasta']!="") $hasta = "and fecha_in <= '".$fecha->fecha_db($_POST['hasta'])."'";
	
	
	$total = $est->array_query("select count(*) from tbl_log_est where id > 0 $desde $hasta  ");
	
	echo $total[0];
	
	$est->cerrar();
	
?>	
