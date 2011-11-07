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
	
	 $query = "select nombre,apellido,email,telefono,fax,user,es_admin,cursos,sintesis from tbl_admin where id = '{$_REQUEST['ItemID']}'";
	 $data = $crear->array_query2($query);
	 $cursos2 = @explode(',',$data[7]);
	 $cursos =	$crear->estructura_db("select id,nombre,alias from tbl_curso");
	}



 if(isset($_POST['login12'])){ 
		
		$campos = explode(",","nombre, apellido, user, es_admin, email, telefono, fax, fecha,cursos,sintesis");
		 
		$valores2[0] = $_POST['nombre'];
		$valores2[1] = $_POST['apellido'];
		$valores2[2] = trim($_POST['login12']);
		$valores2[3] = $_POST['admin'];
		$valores2[4] = $_POST['email'];
		$valores2[5] = $_POST['telefono'];
		$valores2[6] = $_POST['fax'];
		$valores2[7] = date("Y-m-d h:i:s");	
		if(count($_POST['curso'])>0)$valores2[8] = implode(",",$_POST['curso']); else $valores2[8] = 0;	
		$valores2[9] = $_POST['sintesis'];
		
		$crear->update("tbl_admin",$campos,$valores2,"id = '{$_POST['id']}'"); 
		
		 if($_POST['boton']==1){
	
	        $npass = md5($_POST['pass1']);
	        $crear->query("update tbl_admin set pass = '$npass' where id = '{$_POST['id']}'");
		 
		 }
		
		
		$crear->javaviso(LANG_cambios,"index.php");
				
 
 }


?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../../css/style_back.css">
<script language="JavaScript" type="text/javascript" src="../../js/ajax.js"></script>

 <script language="JavaScript" type="text/javascript">
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
 
 
	  <script language="JavaScript" type="text/javascript">
		  function validar(){
		  
		  
		   var login2 = document.form1.login12.value;
		   var i;
		  			 
			 if (document.form1.nombre.value == ''){
			   alert("<?=LANG_VAL_name?>");
			   document.form1.nombre.focus();
			   return (false);
			 }
			 
			  if (document.form1.apellido.value == ''){
			   alert("<?=LANG_VAL_lastname?>");
			   document.form1.apellido.focus();
			   return (false);
			 }
			  
			 
			 if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(document.form1.email.value)==false){
			  alert("<?=LANG_VAL_email?>");
			  document.form1.email.focus();
			  return (false);
			 }
			 
			 
			  if (login2 == '' || login2.indexOf(" ")>=0){
			   alert("<?=LANG_VAL_login?>");
			   document.form1.login12.focus();
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
			
			
			
			if(document.form1.anterior.value!=document.form1.login12.value){ 
			
				////////ajax
						oXML = AJAXCrearObjeto();
						oXML.open('POST', 'validalogin.php');
						oXML.setRequestHeader('Content-Type','application/x-www-form-urlencoded');					
						oXML.onreadystatechange = function(){
								if (oXML.readyState == 4 && oXML.status == 200) {
								
									if(oXML.responseText=="1"){
									
										alert('El login ya se encuentra registrado');
										document.form1.login12.focus();
										return false;
																	
									}else{
									
										document.form1.submit();
									
									}
									
									vaciar(oXML); ////eliminando objeto ajax	
										
								}
								
								
						}
						
						oXML.send('nombre='+login2); 
				 /////////////
			}else{
		  
		  		document.form1.submit();
			
		    } 
			 
					 
			 			 
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
    <td><?php $menu->mostrar(0); ?></td>
  </tr>
  <tr>
    <td>
	
	<table style="border-right:#000000 solid 1px; border-left:#000000 solid 1px; border-bottom:#000000 solid 1px;" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><form name="form1" method="post" action="editar.php">
  <table width="100%" border="0" cellspacing="4" cellpadding="3">
  <tr>
  <td colspan="7">&nbsp;</td>
</tr>
  <tr>
  <td colspan="2" class="style3"><?php echo LANG_name ?></td>
  <td><input name="nombre" type="text" id="nombre" value="<?=$data[0]?>"></td>
  <td>&nbsp;</td>
  <td colspan="2" class="style3"><?php echo LANG_lastname ?></td>
  <td><input name="apellido" type="text" id="apellido" value="<?=$data[1]?>"></td>
  </tr>
  <tr>
  <td colspan="2" class="style3"><strong>
    <?=LANG_email ?>
  </strong></td>
  <td width="30%"><input name="email" type="text" id="email" value="<?=$data[2]?>" size="25"></td>
  <td width="4%">&nbsp;</td>
  <td colspan="2" class="style3"><strong>
    <?=LANG_phone ?>
  </strong></td>
  <td width="30%"><input name="telefono" type="text" id="telefono" value="<?=$data[3]?>"></td>
  </tr>
  <tr>
  <td colspan="2" class="style3"><strong>
    <?=Fax ?>
  </strong></td>
  <td><input name="fax" type="text" id="fax" value="<?=$data[4]?>"></td>
  <td>&nbsp;</td>
  <td colspan="2" class="style3">&nbsp;</td>
  <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7" class="table_bk"><strong><?php echo LANG_resume ?></strong></td>
    </tr>
  <tr>
    <td colspan="7" class="style3"><textarea name="sintesis" cols="90" rows="5" class="style1" id="sintesis"><?=$data[8]?>
    </textarea></td>
    </tr>
  <tr>
    <td colspan="7" class="table_bk"><strong><?php echo LANG_loginfo ?></strong></td>
    </tr>
  <tr>
    <td colspan="2" class="style3"><strong>
      <?=LANG_login ?>
    </strong></td>
    <td><span class="style3"><strong>
      <input name="login12" type="text" id="login12" value="<?=$data[5]?>">
      <input name="anterior" type="hidden" id="anterior" value="<?=$data[5]?>">
    </strong></span></td>
    <td>&nbsp;</td>
    <td colspan="3"><span class="small">
      <?=LANG_be_administrator?>
    </span></td>
    </tr>
  <tr>
    <td colspan="2" class="style3"><strong><strong>
      <?=LANG_pass ?>
      <strong><strong><strong><strong>
      <input name="boton" type="checkbox" class="small" onClick="cambio(this);" value="1">
      <font color="#FF0000">
      <?= LANG_chpass ?>
      </font></strong></strong></strong></strong></strong></strong></td>
    <td><span class="style3"><strong><strong><strong><strong>
      <input name="pass1" type="password" id="pass1" disabled="disabled">
    </strong></strong></strong></strong></span></td>
    <td>&nbsp;</td>
    <td class="style3"><input name="admin" type="checkbox" id="admin" value="1" <?php if($data[6]==1) echo "checked"?>></td>
    <td class="style3"><strong>
      <?=LANG_config_admin ?>
    </strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
  <td colspan="2" class="style3"><strong><strong><strong><strong><strong>
    <?=LANG_pass2 ?>
  </strong></strong></strong></strong></strong></td>
  <td><span class="style3"><strong><strong><strong><strong><strong>
    <input name="pass12" type="password" id="pass12" disabled="disabled">
  </strong></strong></strong></strong></strong></span></td>
  <td>&nbsp;</td>
  <td width="7%" valign="middle" class="style3">&nbsp;</td>
  <td width="13%" valign="middle" class="style3">&nbsp;</td>
  <td valign="middle" class="style3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="style3">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" class="style3"><input name="id" type="hidden" value="<?=$_REQUEST['ItemID']?>"></td>
    <td>&nbsp;</td>
  </tr>
  
  
   <tr>
    <td colspan="8" class="table_bk"><strong>
      <?= LANG_ADMIN_cursos ?>
    </strong></td>
    </tr>
	
	<?php 
	
	for($j=0;$j<count($cursos);$j++){
	
	?>
  <tr>
    <td width="6%" align="center" valign="top" class="style3"><input name="curso[]" type="checkbox" value="<?=$cursos[$j]['id']?>" <?php if(@in_array($cursos[$j]['id'],$cursos2)) echo 'checked';  ?>></td>
    <td colspan="7" align="left" class="style3">
      <span class="style3"><?=$cursos[$j]['nombre']?>
      </span> <span class="small">(<?=$cursos[$j]['alias']?>)</span>    </td>
    </tr>
  
  <?php 
  
  }
  
  ?>
  
  
  <tr>
    <td colspan="8" class="style3">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="7" align="center" class="style3"><br>
      <input type="button" name="Submit2"  value="<?=LANG_back?>" onClick="javascript:history.back();">
      <input type="button" name="Button" value="<?=LANG_edit?>" onClick="validar();">
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
