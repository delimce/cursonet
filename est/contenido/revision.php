<?php session_start();
$profile = 'est'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php");
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

$datos = new tools("db");

	$rev = $datos->simple_db("select correccion from evaluacion_revision where id = {$_REQUEST['id']}");

?>
<html>
<head> <meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="../../css/style_front.css">
<title>Revision de la prueba</title>
<style type="text/css">
<!--
#apDiv1 {
	position:absolute;
	left:12px;
	top:16px;
	width:478px;
	height:174px;
	z-index:1;
}
#apDiv2 {
	position:absolute;
	left:363px;
	top:208px;
	width:123px;
	height:15px;
	z-index:2;
}
#apDiv3 {
	position:absolute;
	left:35px;
	top:47px;
	width:432px;
	height:129px;
	z-index:3;
	overflow: auto;
}
-->
</style>
</head>

<body>
<div id="apDiv1">
  <table width="107%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <td height="219">&nbsp;</td>
    </tr>
  </table>
</div>
<div id="apDiv2"><a href="javascript:window.close();">Cerrar ventana</a></div>
<div id="apDiv3">
  <div align="justify"><?php echo $rev ?></div>
</div>
</body>
</html>
<?php $datos->cerrar(); ?>
