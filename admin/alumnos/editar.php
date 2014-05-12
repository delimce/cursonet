<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);


 $crear = new tools("db");
 $fecha = new fecha($_SESSION['DB_FORMATO']);
 $sexo1 = $crear->llenar_array("".LANG_male.",".LANG_female."");
 $sexo2 = $crear->llenar_array("M,F");

	if(isset($_REQUEST['ItemID'])){
	
	
	 $query = "select nombre,apellido,id_number,sexo,date_format(fecha_nac,'".$_SESSION['DB_FORMATO_DB']."'),email,(select grupo_id from tbl_grupo_estudiante where curso_id = {$_SESSION['CURSOID']} and est_id = {$_REQUEST['ItemID']} ) as grupo,user,activo,carrera,nivel,universidad,id,clave_preg,clave_resp from tbl_estudiante where id = '{$_REQUEST['ItemID']}'";
	 $data = $crear->array_query2($query);
	
	}



 if(isset($_POST['login12'])){
 
     ////edit el estudiante
		 
		 
		$campos = explode(",","id_number, nombre, apellido, sexo, fecha_nac, email, carrera, nivel, universidad, user, fecha_creado,activo,clave_preg,clave_resp");  
		
		$valores2[0]= $_POST['ci'];
		$valores2[1]= $_POST['nombre'];
		$valores2[2]= $_POST['apellido'];
		$valores2[3]= $_POST['sexo'];
		$valores2[4]= $fecha->fecha_db($_POST['fecha_nac']);
		$valores2[5]= $_POST['email'];
		$valores2[6]= $_POST['carrera'];
		$valores2[7]= $_POST['nivel'];
		$valores2[8]= $_POST['universidad'];
		$valores2[9]= $_POST['login12'];
		$valores2[10]= date("Y-m-d h:i:s");
		$valores2[11]= $_POST['activo'];
		$valores2[12]= trim($_POST['spreg']);
		$valores2[13]= trim($_POST['sresp']);
		
                
                
                $crear->abrir_transaccion();
                
                
                //validadndo user y cedula
               
                 $crear->query("select id from tbl_estudiante where (user = '{$_POST['login12']}' and id != {$_POST['id']} ) or (id_number = '{$_POST['ci']}' and id != {$_POST['id']} )   ");
                 if($crear->nreg>0){
                     $crear->cerrar_transaccion(false);
                     $crear->cerrar();
                     $aviso = $_POST['login12'].LANG_VAL_user2;
		     		 $crear->javaviso($aviso);
                     $crear->redirect("editar.php?ItemID=".$_POST['id']);
                     
                 }
                     
                
		$crear->update("tbl_estudiante",$campos,$valores2,"id = '{$_POST['id']}' "); 
		
		////grupo editar
		$crear->query("select id from tbl_grupo_estudiante where est_id = {$_POST['id']} and curso_id = {$_SESSION['CURSOID']} ");
		
		if($crear->nreg>0 && $_POST['grupo']!=0){
		
			$g1[0] = "grupo_id"; $v1[0] = $_POST['grupo'];
			$crear->update("tbl_grupo_estudiante",$g1,$v1,"est_id = '{$_POST['id']}' and curso_id = {$_SESSION['CURSOID']} "); 
		
		
		}else if($_POST['grupo']==0){
		
		
			$crear->query("delete from tbl_grupo_estudiante where est_id = '{$_POST['id']}' and curso_id = {$_SESSION['CURSOID']} ");
		
		
		}else if($_POST['grupo']!=0){///inserta
		
		     
			 $valores4[0]=$_POST['id'];
			 $valores4[1]=$_SESSION['CURSOID'];
			 $valores4[2]=$_POST['grupo'];
			 $crear->insertar2("tbl_grupo_estudiante","est_id, curso_id, grupo_id",$valores4); 
		
		
		}
		/////////////
		
		
		 if($_POST['boton']==1){
	
	        $npass = md5($_POST['pass1']);
	        $crear->query("update tbl_estudiante set pass = '$npass' where id = '{$_POST['id']}'");
		 
		 }
		 		 
		 $crear->cerrar_transaccion();
                 
                 $crear->cerrar();
		 
		 $crear->javaviso(LANG_cambios);
		 
		 ?>
         <script type="text/javascript">
			window.history. go( -2 );
		 </script>

         <?
 		die();
 }


?>
<html>
<head> <meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="../../css/style_back.css">
<script language="JavaScript" type="text/javascript" src="../../js/utils.js"></script>
  
   <script language="JavaScript" type="text/javascript">
	function cambio(boton) {
	
	   if(boton.checked == true)  {
	
			 document.form1.pass1.disabled = false;
			 document.form1.pass12.disabled = false;
	
	   }else{
	
			 document.form1.pass1.disabled = true;
			 document.form1.pass12.disabled = true;
	
	   }
	
	 }
 </script>


	  <script language="JavaScript" type="text/javascript">
		  function validar(){
		  
		  	 //var login2 = document.form1.login12.value;
             var login2 =  document.getElementById("login12").value;
		  			 
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
			 
			 if (document.form1.ci.value == ''){
			   alert("<?=LANG_VAL_ci?>");
			   document.form1.ci.focus();
			   return (false);
			 }
			 
			  if (document.form1.fecha_nac.value == ''){
			   alert("<?=LANG_VAL_dob?>");
			   document.form1.fecha_nac.focus();
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
					 
			   deshabilitar(document.getElementById('submit3'));		 
			   return (true);
		   }
		</script>

	
<script type="text/javascript" src="../../js/calendario/calendar.js"></script>
<script type="text/javascript" src="../../js/calendario/calendar-es.js"></script>
<script type="text/javascript" src="../../js/calendario/calendar-setup.js"></script>
<script type="text/javascript" src="../../js/popup.js"></script>
<LINK href="../../js/calendario/calendario.css" type=text/css rel=stylesheet>

</head>

<BODY>

<table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="26" valign="top"><?php echo $menu->nombre; ?></td>
  </tr>
  <tr>
    <td><?php $menu->mostrar($_REQUEST['orig']); ?></td>
  </tr>
  <tr>
    <td>
	
	<table style="border-right:#000000 solid 1px; border-left:#000000 solid 1px; border-bottom:#000000 solid 1px;" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><form name="form1" method="post" action="<?=$PHP_SELF?>" onSubmit="return validar();">
  <table width="100%" border="0" cellspacing="4" cellpadding="3">
  <tr>
  <td colspan="5" class="bold"><?php echo LANG_edit  ?></td>
</tr>
  <tr>
  <td class="style3"><?php echo LANG_name ?></td>
  <td><input name="nombre" type="text" id="nombre" value="<?=$data[0]?>"></td>
  <td>&nbsp;</td>
  <td class="style3"><?php echo LANG_lastname ?></td>
  <td><input name="apellido" type="text" id="apellido" value="<?=$data[1]?>"></td>
  </tr>
  <tr>
  
  <td width="17%" class="style3"><?php echo LANG_ci ?></td>

  <td width="29%"><input name="ci" type="text" id="ci" value="<?=$data[2]?>"></td>
  <td width="4%">&nbsp;</td>
  <td width="19%" valign="middle" class="style3"><strong>
    <?=LANG_sex ?>
  </strong></td>
  <td width="31%"><?php echo $crear->combo_array("sexo",$sexo1,$sexo2,false,$data[3]); ?></td>
  </tr>
  <tr>
  <td class="style3"><strong>
    <?=LANG_email ?>
  </strong></td>
  <td><input name="email" type="text" id="email" value="<?=$data[5]?>" size="25"></td>
  <td>&nbsp;</td>
  <td class="style3"><strong>
    <?=LANG_fecha_nac ?>
  </strong></td>
  <td><input name="fecha_nac" type="text" id="fecha_nac" onFocus="this.blur()" onClick="alert('<?=LANG_calendar_use?>')" value="<?=$data[4]?>" size="12">
    <img src="../../images/frontend/cal.gif" name="f_trigger_d" width="16" height="16" id="f_trigger_d" style="cursor: hand; border: 0px;" title="<?=LANG_calendar?>">
    <script type="text/javascript">
					Calendar.setup({
						inputField     :    "fecha_nac",     // id of the input field
						ifFormat       :    "<?=strtolower("d/m/Y")?>",    // format of the input field
						button         :    "f_trigger_d",  // trigger for the calendar (button ID)
						singleClick    :    true
					});
				</script></td>
  </tr>
  <tr>
  <td class="style3">&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td class="style3">&nbsp;</td>
  <td class="style3">&nbsp;</td>
  </tr>
  <tr>
    <td class="style3"><strong>
      <?=LANG_login ?>
    </strong></td>
    <td><span class="style3"><strong>
      <input name="login12" type="text" id="login12" value="<?=$data[7]?>">
    </strong></span></td>
    <td>&nbsp;</td>
    <td class="style3"><strong>
      <?= LANG_carreer ?>
    </strong></td>
    <td><input name="carrera" type="text" id="carrera" value="<?=$data[9]?>" size="30"></td>
  </tr>
  <tr>
    <td class="style3"><strong><strong>
      <?=LANG_pass ?>
      <strong><strong><strong><strong>
      <input name="boton" type="checkbox" class="small" onClick="cambio(this);" value="1">
      </strong></strong></strong></strong></strong></strong></td>
    <td><span class="style3"><strong><strong><strong><strong>
      <input name="pass1" type="password" id="pass1" disabled="disabled">
    </strong></strong></strong></strong></span></td>
    <td>&nbsp;</td>
    <td class="style3"><strong>
      <?= LANG_faculty_level ?>
    </strong></td>
    <td><input name="nivel" type="text" id="nivel" value="<?=$data[10]?>"></td>
  </tr>
  <tr>
    <td class="style3"><strong><strong><strong><strong><strong>
      <?=LANG_pass2 ?>
    </strong></strong></strong></strong></strong></td>
    <td><span class="style3"><strong><strong><strong><strong>
      <input name="pass12" type="password" id="pass12" disabled="disabled">
    </strong></strong></strong></strong></span></td>
    <td>&nbsp;</td>
    <td class="style3"><strong>
      <?= LANG_university ?>
    </strong></td>
    <td><input name="universidad" type="text" id="universidad" value="<?=$data[11]?>" size="30"></td>
  </tr>
  <tr>
    <td class="style3"><strong>
      <?=LANG_group ?>
    </strong></td>
    <td><?php echo $crear->combo_db("grupo","select id,nombre from tbl_grupo where curso_id = {$_SESSION['CURSOID']} ","nombre","id",LANG_ungroup,$data[6],FALSE,LANG_nogroup);?></td>
    <td>&nbsp;</td>
    <td class="style3"><strong>
      <?= LANG_squestion ?>
    </strong></td>
    <td align="left"><textarea name="spreg" cols="30" rows="3" class="style1" id="spreg"><?=$data[13]?>
    </textarea></td>
  </tr>
  <tr>
    <td class="style3"><strong>
      <?=LANG_status ?>
    </strong></td>
    <td><span class="style3">
      <input name="activo" type="radio" class="style1" value="1" <?php if($data[8]==1)echo "checked"  ?>>
      <strong>
      <?=LANG_is_active ?>
      <input name="activo" type="radio" class="style1" value="0" <?php if($data[8]==0)echo "checked"  ?>>
      <?=LANG_is_noactive ?>
      </strong></span></td>
    <td>&nbsp;</td>
    <td class="style3"><strong>
      <?= LANG_sanswer ?>
    </strong></td>
    <td align="left"><input name="sresp" type="text" id="sresp" value="<?=$data[14]?>" size="30"></td>
  </tr>
  <tr>
    <td class="style3"><input name="orig" type="hidden" id="orig" value="<?=$_REQUEST['orig'] ?>"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="style3">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" align="center" class="style3">
	  <input name="id" type="hidden" value="<?=$data[12]?>">
	  <br>
	  <input type="button" name="Submit2"  value="<?=LANG_back?>" onClick="javascript:history.back();">
      <input type="submit" name="Submit" id="submit3" value="<?=LANG_save?>">
      <br></td>
    </tr>
</table>
</form></td>
      </tr>
    </table>	</td>
  </tr>
</table>
</div>
</body>
</html>
<?php 

 $crear->cerrar();

?>
