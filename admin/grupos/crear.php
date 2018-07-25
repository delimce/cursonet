<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);


 $crear = new tools("db");
 
 
 /////validacion si no hay cursos creados o seleccionados
 if(empty($_SESSION['CURSOID']) or $_SESSION['CURSOID']<1)
     $crear->javaviso(LANG_nogroupselect,"../settings/crearc.php");
 
 ///////

 $turno1 = $crear->llenar_array("Presencial,Semipresencial,A distancia");
 $turno2 = $crear->llenar_array("0,1,2");


 if($_POST['nombre']){

	 
	 $valores[0] = $_POST['nombre'];
	 $valores[1] = $_POST['desc'];
	 $valores[2] = $_POST['prof_id'];
	 $valores[3] = $_POST['turno'];
	 $valores[4] = date("Y-m-d H:i:s");
	 $valores[5] = $_SESSION['CURSOID'];

	 $crear->insertar2("tbl_grupo","nombre, descripcion, prof_id, turno, fecha_creado,curso_id",$valores);
	 $crear->javaviso(LANG_cambios,"index.php");


 }

?>
<!DOCTYPE html>
<html>
<head> <meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="../../css/style_back.css">

	<script language="JavaScript" type="text/javascript">
	function validar(){

	 if(document.form1.nombre.value==''){

	 alert('<?=LANG_group_error1 ?>');
	 document.form1.nombre.focus();

	 return false;

	 }

	 if(document.form1.desc.value==''){
	 alert('<?=LANG_group_error2 ?>');
	 document.form1.desc.focus();
	 return false;

	 }

	 return true;

	}
	</script>

</head>

<body>
<table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="26" valign="top"><?php echo $menu->nombre; ?></td>
  </tr>
  <tr>
    <td><?php $menu->mostrar(1); ?></td>
  </tr>
  <tr>
    <td>

	<table style="border-right:#000000 solid 1px; border-left:#000000 solid 1px; border-bottom:#000000 solid 1px;" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><form name="form1" method="post" action="crear.php" onSubmit="return validar();">
  <table width="100%" border="0" cellspacing="4" cellpadding="3">
  <tr>
  <td colspan="2">&nbsp;</td>
</tr>
  <tr>
  <td class="style3"><?php echo LANG_group_prof; ?></td>
  <td><?php echo $crear->combo_db("prof_id","select id,concat(nombre,' ',apellido) as nombre from tbl_admin","nombre","id",false,$_SESSION['USERID']); ?></td>
</tr>
  <tr>
  <td width="27%" class="style3"><?php echo LANG_group_nombre; ?></td>
  <td width="73%">
    <input name="nombre" type="text" id="nombre" size="50">  </td>
</tr>
  <tr>
  <td class="style3"><?php echo LANG_group_desc; ?></td>
  <td>
    <textarea name="desc" rows="4" cols="60" class="style1" id="desc"></textarea>  </td>
</tr>
  <tr>
  <td class="style3"><?php echo LANG_group_turno; ?></td>
  <td><?php echo $crear->combo_array("turno",$turno1,$turno2); ?></td>
</tr>
  <tr>
  <td colspan="2">
    <input type="reset" name="Submit2" value="Reset">
    <input type="submit" name="Submit" value="<?=LANG_save?>"></td>
  </tr>
</table>
</form></td>
      </tr>
    </table>	</td>
  </tr>
</table>
</body>
</html>
<?php

 $crear->cerrar();

?>
