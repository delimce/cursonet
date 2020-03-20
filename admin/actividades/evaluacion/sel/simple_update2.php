<?php session_start();
include("../../../../config/setup.php");
include("../../../../clases/clases.php");

$util  = new ut_Tool();
$eva = new neg_Evaluacion();


	$eva->autoconexion();
	
	$eva->mostrar_preg_desarrollo($_REQUEST['id']);
	
	$datos = $util->simple_db($eva->result);


   if(isset($_POST['enum'])){
	
			
		 		$eva->editar_pregunta($_POST['id'],1,$_POST['enum']);
				$eva->borrar_opcion($_POST['id']);
			
		
				for($j=0;$j<count($_SESSION['OPCIONES']);$j++){
				
					if($j==$_SESSION['CORRECT']) $correcto = 1; else $correcto = 0;
				
					$eva->guardar_opcion($_SESSION['OPCIONES'][$j],$correcto,$_POST['id']);
				
				}
		
		
		unset($_SESSION['OPCIONES']);
		
		unset($_SESSION['CORRECT']);
		
		?>   
        <script type="text/javascript">
		alert('Pregunta de seleccion simple Guardada!');
		location.replace('../eval_preguntas.php');
		</script>
        <?	
		
		die();
	
	}else{
	
		$eva->ver_preg_opciones($_REQUEST['id']);
	
	    $datos2 = $util->estructura_db($eva->result);
		
		for($j=0;$j<count($datos2);$j++){
		
			$datos3[$j] = $datos2[$j]['enumciado'];
			if($datos2[$j]['correcto']==1) $_SESSION['CORRECT'] = $j;
		
		}

			$_SESSION['OPCIONES'] = $datos3;
	
	}


		

?>
<html>
<head> <meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Untitled Document</title>

<style type="text/css">
<!--
@import url("../../../../css/style_back.css");
-->

body {
    background-image:none;
	background-color:transparent;
}

</style>
</head>

<body>
<form name="form1" method="post" action="">
<table width="70%" border="0" align="center" cellpadding="4" cellspacing="4">
  <tr>
    <td colspan="2" class="dyntar-resizer">Editar pregunta de Selección Simple</td>
    </tr>
  <tr>
    <td width="22%" class="style3">Curso actual:</td>
    <td width="78%"><?php echo $_SESSION['CURSOALIAS'] ?></td>
  </tr>
  <tr>
    <td class="style3">Tema del curso:</td>
    <td><?php echo $_SESSION['TEMA_NOMBRE']; ?>&nbsp;</td>
  </tr>
  <tr>
    <td class="style3">Enunciado</td>
    <td><input name="id" type="hidden" id="id" value="<?php echo $_REQUEST['id']; ?>"></td>
  </tr>
  <tr>
    <td colspan="2"><textarea name="enum" cols="80" rows="3" class="style1" id="enum"><?php echo $datos['enunciado'] ?></textarea></td>
  </tr>
  <tr>
    <td height="184" colspan="2" valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td width="6%" align="right">&nbsp;<a href="javascript:opciones.document.opciones.submit();"><img src="../../../../imagenes/box_add.png" width="16" height="16" border="0"></a>&nbsp;</td>
        <td width="88%" align="left"><a href="javascript:opciones.document.opciones.submit();">agregar opción de respuesta</a></td>
        </tr>
      <tr>
        <td colspan="2" align="center"><iframe name="opciones" src="opciones.php" align="middle" frameborder="1" width="99%" height="189"></iframe> </td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2"><input type="button" name="Button" id="Submit" value="Guardar" onClick="opciones.document.opciones.subir.value='2';opciones.document.opciones.submit();document.form1.submit();">
      <input type="button" name="button2" id="button2" onClick="location.replace('../eval_preguntas.php');" value="Cancelar"></td>
  </tr>
</table>
</form>
</body>
</html>
<?php $eva->cerrar(); ?>