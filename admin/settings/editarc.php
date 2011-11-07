<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);
include("security.php"); ///seguridad para el admin

 $crear = new tools("db");

 
    if(isset($_REQUEST['ItemID'])){
	
	 $query = "select nombre,alias,duracion,descripcion,notas from tbl_curso where id = '{$_REQUEST['ItemID']}'";
	 $data = $crear->simple_db($query);
	
	}
	

 if(isset($_POST['alias'])){
 
     
		$campos = explode(",","nombre,alias,resp,duracion,descripcion,notas"); 
		 
		$valores2[0] = trim($_POST['nombre']);
		$valores2[1] = trim($_POST['alias']);
		$valores2[2] = $_SESSION['USERID'];
		$valores2[3] = $_POST['duracion'];
		$valores2[4] = $_POST['desc'];
		$valores2[5] = $_POST['notas'];
	
		$crear->update("tbl_curso",$campos,$valores2,"id = '{$_POST['id']}'");
		$crear->javaviso(LANG_cambios,"curso.php");

 
 }else{
 	
 	
 	 	
 }


?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../../css/style_back.css">
<script language="JavaScript" type="text/javascript" src="../../js/utils.js"></script>
	  <script language="JavaScript" type="text/javascript">
		  function validar(){
		  	  
		 		 
			 if (document.form1.nombre.value.length < 3){
			   alert("<?=LANG_curso_namev?>");
			   document.form1.nombre.focus();
			   return (false);
			 }
			 
			 
			  if (document.form1.alias.value == ''){
			   alert("<?=LANG_curso_aliasv?>");
			   document.form1.alias.focus();
			   return (false);
			 }
								 			 
		     if (document.form1.duracion.value == ''){
			   alert("<?=LANG_curso_longv?>");
			   document.form1.duracion.focus();
			   return (false);
			 }

					 			 
			   deshabilitar(document.getElementById('Submit3'));
			   return (true);
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
        <td><form name="form1" method="post" action="editarc.php" onSubmit="return validar();">
  <table width="100%" border="0" cellspacing="4" cellpadding="3">
  <tr>
  <td colspan="2">&nbsp;</td>
</tr>
  <tr>
  <td class="style3"><?php echo LANG_curso_name ?></td>
  <td width="80%"><textarea class="style1" name="nombre" cols="45" rows="2" id="nombre"><?=$data['nombre'] ?>
  </textarea></td>
  </tr>
  <tr>
  <td width="20%" class="style3"><?php echo LANG_curso_alias ?></td>
  <td><input name="alias" class="style1" value="<?=$data['alias'] ?>" type="text" id="alias" size="22" maxlength="20"> 
   </td>
  </tr>
  <tr>
  <td class="style3"><strong>
    <?=LANG_curso_long ?>
  </strong></td>
  <td><input name="duracion" value="<?=$data['duracion'] ?>" class="style1" type="text" id="duracion" size="22"></td>
  </tr>
  <tr>
  <td class="style3"><strong>
    <?=LANG_curso_desc ?>
  </strong></td>
  <td>
    <textarea name="desc" class="style1" cols="50" rows="4" id="desc"><?=$data['descripcion'] ?></textarea></td>
  </tr>
  <tr>
    <td class="style3"><strong>
      <?=LANG_curso_notes ?>
    </strong></td>
    <td><textarea name="notas" class="style1" cols="50" rows="4" id="notas"><?=$data['notas'] ?></textarea></td>
    </tr>
  <tr>
    <td colspan="2" align="left" class="style3"><br>
      <input name="id" type="hidden" value="<?=$_REQUEST['ItemID']?>">
      <input type="button" name="Submit2"  value="<?=LANG_back?>" onClick="javascript:history.back();">
      <input name="Submit3" type="submit" id="Submit3" value="<?=LANG_save?>">
      <br></td>
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
