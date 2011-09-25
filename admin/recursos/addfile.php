<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/tools.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);


 $crear = new tools();
 $crear->autoconexion();
 

 
   if(isset($_FILES['archivo'])){
  
  				 $path = "../../".$ADMINPATH.'archivos/'.$_FILES['archivo']['name']; //////////subiendo a la  carpeta por defecto
				 if($crear->upload_file($_FILES['archivo'],$path,$TMAX,false,true)){
				 				 
				 				 $tama =  bcdiv($_FILES['archivo']['size'],1048576,2); ///tamano en mb
				 
				 				 
								 $valores[0] = 0;
								 $valores[1] = date("Y-m-d h:i:s");
								 $valores[2] = $tama.' MB';
								 $valores[3] = $_FILES['archivo']['name'];
								 $valores[4] = 'admin';
								 $valores[5] = $_SESSION['USERID'];
								 $valores[6] = $_POST['desc'];
								 
								 $crear->insertar2("recurso","tipo, fecha, size, dir, add_by, persona,descripcion",$valores);
								 $crear->javaviso(LANG_cambios,"index.php");
				 
				 }
				 

	 }

?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../../css/style_back.css">
<script type="text/javascript" src="../../js/dyntar.js"></script>
	<script language="JavaScript" type="text/javascript">
	function validar(){
	
	 if(document.form1.archivo.value==''){
	 
	 alert('<?=LANG_content_error ?>');
	 document.form1.nombre.focus();
	 
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
    <td><?php $menu->mostrar(0); ?></td>
  </tr>
  <tr>
    <td>
	
	<table style="border-right:#000000 solid 1px; border-left:#000000 solid 1px; border-bottom:#000000 solid 1px;" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><form action="addfile.php" method="post" enctype="multipart/form-data" name="form1" onSubmit="return validar();">
  <table width="100%" border="0" cellspacing="4" cellpadding="3">
  <tr>
  <td colspan="2"><span class="style3"><?php echo LANG_content_upload2; ?></span></td>
</tr>
  <tr>
  <td width="19%" class="style3"><?php echo LANG_content_upload; ?></td>
  <td width="81%"><input name="archivo" type="file" id="archivo" size="40"></td>
</tr>
  <tr>
    <td class="style3"><?php echo LANG_group_desc; ?></td>
    <td><textarea name="desc" cols="60" rows="4" class="style1" id="desc"></textarea></td>
  </tr>
  <tr>
  <td colspan="2">
    
    <input type="button" name="Submit2"  value="<?=LANG_back?>" onClick="location.replace('index.php')">
    <input type="submit" name="Submit" value="<?=LANG_save?>">
  </td>  
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
