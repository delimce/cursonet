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


 if(isset($_POST['login12'])){
 
      $crear->query("select id from tbl_estudiante where user = '{$_POST['login12']}' or id_number = '{$_POST['ci']}'");
 
		 if($crear->nreg>0){
		 
		  $aviso = $_POST['login12'].LANG_VAL_user2;
		 
		 $crear->javaviso($aviso);
		 
		
		 
		 }else{ ////inserta el estudiante
		 
		 
		$valores2[0]= $_POST['ci'];
		$valores2[1]= $_POST['nombre'];
		$valores2[2]= $_POST['apellido'];
		$valores2[3]= $_POST['sexo'];
		$valores2[4]= $fecha->fecha_db($_POST['fecha_nac']);
		$valores2[5]= $_POST['tele2'];
		$valores2[6]= $_POST['tele1'];
		$valores2[7]= $_POST['email'];
		$valores2[8]= $_POST['msn'];
		$valores2[9]= $_POST['twitter'];
		$valores2[10]= $_POST['carrera'];
		$valores2[11]= $_POST['nivel'];
		$valores2[12]= $_POST['universidad'];
		$valores2[13]= $_POST['iacc'];
		$valores2[14]= $_POST['dacc'];
		$valores2[15]= $_POST['login12'];
		$valores2[16]= md5($_POST['pass1']);
		$valores2[17]= date("Y-m-d H:i:s");
		$valores2[18]= $_POST['activo'];
		$valores2[19]= trim($_POST['spreg']);
		$valores2[20]= trim($_POST['sresp']);
		
		
		$crear->insertar2("tbl_estudiante","id_number, nombre, apellido, sexo, fecha_nac, telefono_p, telefono_c, email, msn, twitter, carrera, nivel, universidad, internet_acc, internet_zona, user, pass, fecha_creado,activo,clave_preg,clave_resp",$valores2); 
		
		if($_POST['grupo']>0){
		
			 $valores4[0]=$crear->ultimoID;
			 $valores4[1]=$_SESSION['CURSOID'];
			 $valores4[2]=$_POST['grupo'];
			 $crear->insertar2("tbl_grupo_estudiante","est_id, curso_id, grupo_id",$valores4); 
			 
		} 
		
		$crear->javaviso(LANG_cambios,"index.php");
				
	
		 
		 }
 
 }


?>
<!DOCTYPE html>
<html>
<head> <meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="../../css/style_back.css">
<script language="JavaScript" type="text/javascript" src="../../js/utils.js"></script>

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
			 
			 if (document.form1.ci.value == '' || isNaN(document.form1.ci.value) == true){
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
    <td height="26" valign="top"> <span class="menu-title"><?= $menu->nombre; ?></span></td>
  </tr>
  <tr>
    <td><?php $menu->mostrar(2); ?></td>
  </tr>
  <tr>
    <td>
	
	<table style="border-right:#000000 solid 1px; border-left:#000000 solid 1px; border-bottom:#000000 solid 1px;" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><form name="form1" method="post" action="<?=$_SERVER['PHP_SELF']?>" onSubmit="return validar();">
  <table width="100%" border="0" cellspacing="4" cellpadding="3">
  <tr>
  <td colspan="5"><span class="bold"><?php echo LANG_add ?></span></td>
</tr>
  <tr>
  <td class="style3"><?php echo LANG_name ?></td>
  <td><input name="nombre" type="text" id="nombre" value="<?=$_POST['nombre']?>"></td>
  <td>&nbsp;</td>
  <td class="style3"><?php echo LANG_lastname ?></td>
  <td><input name="apellido" type="text" id="apellido" value="<?=$_POST['apellido']?>"></td>
  </tr>
  <tr>
  <td width="17%" class="style3"><?php echo LANG_ci ?></td>
  <td width="29%"><input name="ci" type="text" id="ci" value="<?=$_POST['ci']?>"  maxlength="15"></td>
  <td width="4%">&nbsp;</td>
  <td width="20%" class="style3"><strong>
    <?=LANG_sex ?>
  </strong></td>
  <td width="30%"><?php echo $crear->combo_array("sexo",$sexo1,$sexo2); ?></td>
  </tr>
  <tr>
  <td class="style3"><strong>
    <?=LANG_email ?>
  </strong></td>
  <td><input name="email" type="text" id="email" value="<?=$_POST['email']?>" size="25"></td>
  <td>&nbsp;</td>
  <td class="style3"><strong>
    <?=LANG_fecha_nac ?>
  </strong></td>
  <td><input name="fecha_nac" type="text" id="fecha_nac" onFocus="this.blur()" onClick="alert('<?=LANG_calendar_use?>')" value="01/01/1980" size="12">
    <img src="../../images/frontend/cal.gif" name="f_trigger_d" width="16" height="16" id="f_trigger_d" style="cursor: hand; border: 0px;" title="<?=LANG_calendar?>"></td>
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
      <input name="login12" type="text" id="login12" value="<?=$_POST['login12']?>">
    </strong></span></td>
    <td>&nbsp;</td>
    <td class="style3"><strong>
      <?= LANG_carreer ?>
    </strong></td>
    <td><input name="carrera" type="text" id="carrera" value="<?=$_POST['carrera']?>" size="30"></td>
  </tr>
  <tr>
    <td class="style3"><strong><strong>
      <?=LANG_pass ?>
    </strong></strong></td>
    <td><span class="style3"><strong><strong>
      <input name="pass1" type="password" id="pass1">
    </strong></strong></span></td>
    <td>&nbsp;</td>
    <td class="style3"><strong>
      <?= LANG_faculty_level ?>
    </strong></td>
    <td><input name="nivel" type="text" id="nivel" value="<?=$_POST['nivel']?>"></td>
  </tr>
  <tr>
    <td class="style3"><strong><strong><strong>
      <?=LANG_pass2 ?>
    </strong></strong></strong></td>
    <td><span class="style3"><strong><strong><strong>
      <input name="pass12" type="password" id="pass12">
    </strong></strong></strong></span></td>
    <td>&nbsp;</td>
    <td class="style3"><strong>
      <?= LANG_university ?>
    </strong></td>
    <td><input name="universidad" type="text" id="universidad" value="<?=$_POST['universidad']?>" size="30"></td>
  </tr>
  <tr>
    <td class="style3"><strong>
      <?=LANG_group ?>
    </strong></td>
    <td><?php echo $crear->combo_db("grupo","select id,nombre from tbl_grupo where curso_id = {$_SESSION['CURSOID']}","nombre","id",LANG_ungroup,false,false,LANG_nogroup);?></td>
    <td>&nbsp;</td>
    <td class="style3"><strong>
      <?= LANG_squestion ?>
    </strong></td>
    <td><textarea name="spreg" cols="30" rows="3" class="style1" id="spreg"><?php echo $_POST['spreg'] ?>
    </textarea></td>
  </tr>
  <tr>
    <td class="style3"><strong>
      <?=LANG_status ?>
    </strong></td>
    <td><script type="text/javascript">
					Calendar.setup({
						inputField     :    "fecha_nac",     // id of the input field
						ifFormat       :    "<?=strtolower("d/m/Y")?>",    // format of the input field
						button         :    "f_trigger_d",  // trigger for the calendar (button ID)
						singleClick    :    true
					});
				</script>
				  <span class="style3">
				  <input name="activo" type="radio" class="style1" value="1" checked>
                  <strong>
                  <?=LANG_is_active ?>
                  <input name="activo" type="radio" class="style1" value="0">
                  <?=LANG_is_noactive ?>
                  </strong></span></td>
    <td>&nbsp;</td>
    <td class="style3"><strong>
      <?= LANG_sanswer ?>
    </strong></td>
    <td><input name="sresp" type="text" id="sresp" value="<?php echo $_POST['sresp'] ?>" size="30"></td>
  </tr>
  <tr>
    <td colspan="5" align="center" class="style3"><br>
      <input type="button" name="Submit2"  value="<?=LANG_back?>" onClick="location.replace('index.php')">
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
