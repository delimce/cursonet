<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje


require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);


 $crear = new formulario("db");


 if(isset($_POST['r4user'])){
 		 
		 
        $_POST['r4user'] = trim($_POST['r4user']);
		$valores2[4] = md5($_POST['pass1']);

		$_POST['r4fecha'] = date("Y-m-d h:i:s");
		if(!empty($_POST['pass1'])) $_POST['r4pass'] = md5($_POST['pass1']);
		
		
		///////////////subir foto
		if(!empty($_FILES['archivo']['name'])){	
	
					$sesubio = $crear->upload_file($_FILES['archivo'],'../../recursos/admin/fotos/'.$_FILES['archivo']['name'],1,'image/gif,image/jpeg,image/png,image/pjpeg,image/jpg,image/pjpg');
					if($sesubio == true){
					
						@unlink('../../recursos/admin/fotos/'.$_POST['image2']); ///borra la imagen subida original
						
						$prefi = @date("dhis_");
						$ruta = "../../recursos/admin/fotos/".$_FILES['archivo']['name'];
						//$ruta2 = '../../SVcontent/categoria/med/'.$_FILES['archivo']['name'];
						$ruta3 = "../../recursos/admin/fotos/".$prefi.$_FILES['archivo']['name'];
						
						$imagen = new image($ruta);
						$imagen->redimensionar($ruta3, 75, 75, 100); ///redimension
						
						$imagen->destruir();
						
						@unlink($ruta); ///borra la imagen subida original
						
						$_POST['r4foto'] = $prefi.$_FILES['archivo']['name'];
				
					}else{
					
						$_POST['r4foto'] = $_POST['image2'];
					
					}
		}
	  //////////////
		
		

		
		$crear->update_data('r','4','tbl_admin',$_POST,"id = '{$_SESSION['USERID']}'");
		$crear->javaviso(LANG_cambios,"index.php");
				
 
 }else{
 
 		$data = $crear->simple_db("select * from tbl_admin where id = '{$_SESSION['USERID']}' ");
 
 
 }


?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../../css/style_back.css">
<script language="JavaScript" type="text/javascript" src="../../js/ajax.js"></script>
<script language="JavaScript" type="text/javascript" src="../../js/utils.js"></script>
	  <script language="JavaScript" type="text/javascript">
		  function validar(){
		  
		  
		  var login2 = document.form1.r4user.value;
		  var i;
		  			 
			 if (document.form1.r4nombre.value == ''){
			   alert("<?=LANG_VAL_name?>");
			   document.form1.r4nombre.focus();
			   return (false);
			 }
			 
			  if (document.form1.r4apellido.value == ''){
			   alert("<?=LANG_VAL_lastname?>");
			   document.form1.r4apellido.focus();
			   return (false);
			 }
			  
			 
			 if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(document.form1.r4email.value)==false){
			  alert("<?=LANG_VAL_email?>");
			  document.form1.r4email.focus();
			  return (false);
			 }
			 
			 
			 if (login2 == '' || login2.indexOf(" ")>=0){
			   alert("<?=LANG_VAL_login?>");
			   document.form1.r4user.focus();
			   return (false);
			 }
			 
			 			 
		     if(document.form1.boton.checked==true){ 
						 
				if (document.form1.pass1.value.length < 5){
				   alert("<?=LANG_VAL_pass?>");
				   document.form1.pass1.focus();
				   return (false);
				 }
				 
				 
				 if (document.form1.pass1.value != document.form1.pass12.value){
				   alert("<?=LANG_VAL_repass?>");
				   document.form1.pass12.focus();
				   return (false);
				 }
				 
				 
			}
			 
			return true;					 
			  
		   }
		   
		   
		   function cambio(boton) {
	
			   if(boton.checked == true)  {
			
					 document.form1.pass1.disabled = false;
					 document.form1.pass1.value = '';
					 document.form1.pass12.disabled = false;
					 document.form1.pass12.value = '';
					 
					 
			
			   }else{
			
					 document.form1.pass1.disabled = true;
					 document.form1.pass12.disabled = true;
			
			   }
			
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
        <td><form action="index.php" onSubmit="return validar();" method="post" enctype="multipart/form-data" name="form1">
  <table width="100%" border="0" cellspacing="4" cellpadding="3">
  <tr>
  <td colspan="6"><input name="id" type="hidden" id="id" value="<?=$data['id']?>"></td>
</tr>
  <tr>
  <td width="388" class="style3"><?php echo LANG_name ?></td>
  <td><input name="r4nombre" type="text" id="r4nombre" value="<?=$data['nombre']?>"></td>
  <td width="391" colspan="3" rowspan="3" valign="top"><table width="85%" border="0" align="center" cellpadding="2" cellspacing="1">
    <tr>
      <td align="center" class="style3"><?php echo LANG_profilephoto ?>
        <input name="image2" type="hidden" id="image2" value="<?=$data['foto']?>"></td>
      </tr>
    <tr>
      <td align="center">
	  <?php if(empty($data['foto'])){ $link = '../../images/frontend/nofoto.png'; $nombre = LANG_nopicture;
	   }else{
	  $link = '../../recursos/admin/fotos/'.$data['foto'];  $nombre = $data['foto']; } ?><img style="border:solid 1px" src="<?=$link ?>"></td>
      </tr>
    <tr>
      <td align="center" class="no_back"><?php echo $nombre; ?></td>
      </tr>
    <tr>
      <td align="center"><input type="file" name="archivo" id="archivo"></td>
    </tr>
  </table></td>
  </tr>
  <tr>
  <td class="style3"><strong><?php echo LANG_lastname ?></strong></td>
  <td width="225"><input name="r4apellido" type="text" id="r4apellido" value="<?=$data['apellido']?>"></td>
  </tr>
  <tr>
  <td class="style3"><strong>
    <?=LANG_email ?>
  </strong></td>
  <td><input name="r4email" type="text" id="r4email" value="<?=$data['email']?>" size="25"></td>
  </tr>
  <tr>
    <td class="style3"><strong><strong>
      <?=LANG_phone ?>
      </strong></strong></td>
    <td><input name="r4telefono" type="text" id="r4telefono" value="<?=$data['telefono']?>"></td>
    <td width="391" colspan="3" valign="top"><strong class="style3"><strong>
      <?=LANG_resume ?>
    </strong></strong></td>
    </tr>
  <tr>
    <td class="style3"><strong>
      <?=Fax ?>
    </strong></td>
    <td><input name="r4fax" type="text" id="r4fax" value="<?=$data['fax']?>"></td>
    <td width="391" colspan="3" rowspan="4" valign="top"><textarea name="r4sintesis" id="r4sintesis" cols="35" rows="8"><?php echo $data['sintesis']?></textarea></td>
    </tr>
  <tr>
    <td class="style3"><strong>
      <?=LANG_login ?>
    </strong></td>
    <td><span class="style3"><strong>
      <input name="r4user" type="text" id="r4user" value="<?=$data['user']?>">
    </strong></span></td>
    </tr>
  <tr>
  <td class="style3">
    <?=LANG_pass ?>
    <input name="boton" type="checkbox" class="small" onClick="cambio(this);" value="1">
    <span class="small"><font color="#FF0000">
    <?= LANG_chpass ?>
    </font></span></td>
  <td><span class="style3"><strong><strong>
    <input name="pass1" type="password" id="pass1" value="<?=$data['pass']?>" disabled>
  </strong></strong></span></td>
  </tr>
  <tr>
    <td class="style3"><strong><strong><strong>
      <?=LANG_pass2 ?>
    </strong></strong></strong></td>
    <td><span class="style3"><strong><strong><strong>
      <input name="pass12" type="password" id="pass12" value="<?=$data['pass']?>" disabled>
    </strong></strong></strong></span></td>
    </tr>

  <tr>
    <td height="70" colspan="6" align="left" class="style3"><br>
      <input type="submit" id="submit3" name="Submit" value="<?=LANG_edit?>">
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
