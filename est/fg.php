<?php session_start();
$profile = 'est'; /////////////// perfil requerido
include("../config/setup.php"); ////////setup
include("../class/clases.php");
include("../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

$est = new tools("db");
$fecha = new fecha($_SESSION['DB_FORMATO']);

     $valores[0] = $_SESSION['NOMBRE'];
	 $valores[1] = 'est';
	 $valores[2] = $_SESSION['EMAIL'];
	 $valores[3] = $fecha->fecha_datetime();
	 $valores[4] = $_POST['com'];
	 $valores[5] = $_POST["com1"];
	 $valores[6] = $_POST["pros"];
	 $valores[7] = $_POST["contras"];
	 $valores[8] = '';

     $est->insertar2("feedback","nombre, perfil, email, fecha, tipo_com, comentario, pro, contra, suject_extra_info",$valores);


$est->cerrar();

?>

<script language="JavaScript" type="text/javascript">
window.close();
</script>