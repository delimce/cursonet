<?php session_start();
$profile = 'est'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php");
include("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

$est = new tools('db');
$fecha = new fecha($_SESSION['DB_FORMATO']);

$data = $est->simple_db("select * from tbl_estudiante where id = {$_SESSION['USER']}");

?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../../css/style_front.css">
<script type="text/javascript" src="../../js/calendario/calendar.js"></script>
<script type="text/javascript" src="../../js/calendario/calendar-es.js"></script>
<script type="text/javascript" src="../../js/calendario/calendar-setup.js"></script>
<script type="text/javascript" src="../../js/popup.js"></script>
<script type="text/javascript" src="../../js/utils.js"></script>
<script language="JavaScript" type="text/javascript" src="../../js/ajax.js"></script>
<LINK href="../../js/calendario/calendario.css" type=text/css rel=stylesheet>

<style type="text/css">
<!--
.style4 {color: #FF0000}
.style41 {color: #FF0000}
-->
</style>

	 <script language="JavaScript" type="text/javascript">
			  function validar(){
			  
					
				var login2 = document.form1.login12.value;
						 
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
				
				
				
				
				 ////////ajax
					oXML = AJAXCrearObjeto();
					oXML.open('POST', 'validalogin.php');
					oXML.setRequestHeader('Content-Type','application/x-www-form-urlencoded');					
					oXML.onreadystatechange = function(){
							if (oXML.readyState == 4 && oXML.status == 200) {
							
								if(oXML.responseText=="1"){
								
									alert(login2+' <?=LANG_VAL_user2?>');
									document.form1.login12.focus();
									return (false);
																
								}else{
								
									document.form1.submit();
								
								}
								
								vaciar(oXML); ////eliminando objeto ajax	
									
							}
							
							
					}
					
					oXML.send('nombre='+login2); 
		 		 /////////////
				
				
		
			   }
			   
			</script>
			
			
			
	<script language="JavaScript" type="text/javascript">
	function cambio(boton) {
	
	   if(boton.checked == true)  {
	
			 document.form1.pass1.disabled = false;
			 document.form1.pass12.disabled = false;
			 document.form1.pass1.value = '';
			 document.form1.pass12.value = '';
	
	   }else{
	
			 document.form1.pass1.disabled = true;
			 document.form1.pass12.disabled = true;
			 document.form1.pass1.value = 'gamelotegamelote';
			 document.form1.pass12.value = 'gamelotegamelote';

	
	   }
	
	 }
 	</script>
			

</head>
<body>
<table width="100%" border="0" cellspacing="6" cellpadding="2">
  <tr>
    <td width="56%" align="center" style="border: #9AB1B6 1px solid;">
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
      <td colspan="2" class="welcome">
        <?= LANG_est_userheader ?>      </td>
    </tr>
      <tr>
      <td height="2" colspan="2"><hr color="#9AB1B6" size="1px"></td>
    </tr>
      <tr>
      <td height="2" colspan="2"><br></td>
    </tr>
    <tr>  
    <td>
	
	 <form name="form1" method="post" enctype="multipart/form-data" action="guarda.php">
	
	
	<table width="95%" border="0" align="center" cellpadding="2" cellspacing="1">
      <tr>
        <td width="18%">&nbsp;</td>
        <td width="27%">&nbsp;</td>
        <td width="10%" rowspan="34">&nbsp;</td>
        <td width="19%">&nbsp;</td>
        <td width="26%">&nbsp;</td>
        </tr>
      <tr>
        <td class="style1"><strong>
          <?=LANG_name ?>
          <span class="style4">*</span></strong></td>
        <td><input name="nombre" type="text" id="nombre" value="<?=$data['nombre'] ?>" size="30"></td>
        <td colspan="2" rowspan="6" class="style1"><table width="80%" border="0" align="center" cellpadding="2" cellspacing="1">
          <tr>
            <td align="center" class="style1"><strong><?php echo LANG_profilephoto ?> </strong>
                <input name="image2" type="hidden" id="image2" value="<?=$data['foto']?>">
           </td>
          </tr>
          <tr>
            <td align="center"><?php if(empty($data['foto'])){ $link = '../../images/frontend/nofoto.png'; $nombre = LANG_nopicture;
	   }else{
	  $link = '../../recursos/est/fotos/'.$data['foto'];  $nombre = $data['foto']; } ?>
                <img style="border:solid 1px" src="<?=$link ?>"></td>
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
        <td class="style1"><strong>
          <?=LANG_lastname ?>
          <span class="style4">*</span></strong></td>
        <td><input name="apellido" type="text" id="apellido" value="<?=$data['apellido'] ?>" size="30"></td>
        </tr>
      <tr>
        <td class="style1"><strong>
          <?=LANG_ci ?>
          <span class="style4">*</span></strong></td>
        <td><input name="ci" style="background-color:#E2E2E2" readonly="true" type="text" id="ci" value="<?=$data['id_number'] ?>" size="30"></td>
        </tr>
      <tr>
        <td class="style1"><strong>
          <?=LANG_fecha_nac ?>
          <span class="style4">*</span></strong></td>
        <td><input name="fecha_nac" type="text" id="fecha_nac" size="12" onFocus="this.blur()" value="<?=$fecha->datetime($data['fecha_nac']);?>" onClick="alert('<?=LANG_calendar_use?>')">
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
        <td class="style1"><strong>
          <?=LANG_email ?>
          <span class="style41">*</span></strong></td>
        <td valign="middle"><input name="email" type="text" id="email" value="<?=$data['email'] ?>" size="30"></td>
        </tr>
      <tr>
        <td><span class="style1"><strong>
          <?=LANG_login ?>
          <span class="style41">*</span></strong></span></td>
        <td><input name="login12" type="text" id="login12" value="<?=$data['user'] ?>" size="30"></td>
        </tr>
      <tr>
        <td class="style1">&nbsp;</td>
        <td>&nbsp;</td>
        <td class="style1">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="style1">&nbsp;</td>
        <td>&nbsp;</td>
        <td class="style1">&nbsp;</td>
        <td align="left">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="style1"><input style="vertical-align:bottom" name="boton" type="checkbox" class="small" onClick="cambio(this);" value="1">
          <font color="#FF0000">
          <?= LANG_chpass ?>
          </font></td>
        <td class="style1">&nbsp;</td>
        <td align="left">&nbsp;</td>
      </tr>
      <tr>
        <td class="style1"><strong>
          <?=LANG_pass ?>
          <span class="style4">*</span></strong></td>
        <td><input name="pass1" type="password" disabled="disabled" id="pass1" value="cualquiervaina" size="30"></td>
        <td class="style1"><strong>
          <?=LANG_msn ?>
        </strong></td>
        <td align="left"><span class="style1">
          <input name="msn" type="text" id="msn" value="<?=$data['msn'] ?>" size="30">
        </span></td>
      </tr>
      <tr>
        <td class="style1"><strong>
          <?=LANG_pass2 ?>
        </strong></td>
        <td><input name="pass12" type="password" disabled="disabled" id="pass12" value="cualquiervaina" size="30"></td>
        <td class="style1"><strong>
          <?=LANG_yahoo ?>
        </strong></td>
        <td align="left" class="style1"><input name="yahoo" type="text" id="yahoo" value="<?=$data['yahoo'] ?>" size="30"></td>
      </tr>
      <tr>
        <td><span class="style1"><strong>
          <?= LANG_faculty_level ?>
        </strong></span></td>
        <td><input name="nivel" type="text" id="nivel" value="<?=$data['nivel'] ?>" size="30"></td>
        <td class="style1">&nbsp;</td>
        <td align="left" class="style1">&nbsp;</td>
      </tr>
      <tr>
        <td><span class="style1"><strong><strong><strong>
          <?= LANG_carreer ?>
        </strong></strong></strong></span></td>
        <td align="left"><span class="style1">
          <input name="carrera" type="text" id="carrera" value="<?=$data['carrera'] ?>" size="30">
        </span></td>
        <td class="style1"><strong>
          <?=LANG_a_internet ?>
        </strong></td>
        <td class="style1"><select name="iacc" id="iacc">
          <option value="SI" <?php if($data['internet_acc']=="SI") echo "selected"; ?>>
            <?=LANG_yes?>
            </option>
          <option value="NO" <?php if($data['internet_acc']=="NO") echo "selected"; ?>>
            <?=LANG_no?>
            </option>
        </select></td>
        </tr>
      <tr>
        <td><span class="style1"><strong>
          <?= LANG_university ?>
        </strong></span></td>
        <td><input name="universidad" type="text" id="universidad" value="<?=$data['universidad'] ?>" size="30"></td>
        <td class="style1"><strong>
          <?=LANG_d_internet ?>
        </strong></td>
        <td class="style1"><select name="dacc" id="dacc">
          <option value="<?=LANG_Laboratory?>" <?php if($data['internet_zona']==LANG_Laboratory) echo "selected"; ?>>
            <?=LANG_Laboratory?>
            </option>
          <option value="<?=LANG_cybercafe?>" <?php if($data['internet_zona']==LANG_cybercafe) echo "selected"; ?>>
            <?=LANG_cybercafe?>
            </option>
          <option value="<?=LANG_Home?>" <?php if($data['internet_zona']==LANG_Home) echo "selected"; ?>>
            <?=LANG_Home?>
            </option>
          <option value="<?=LANG_work?>" <?php if($data['internet_zona']==LANG_work) echo "selected"; ?>>
            <?=LANG_work?>
            </option>
        </select></td>
      </tr>
      <tr>
        <td><span class="style1"><strong>
          <?=LANG_tel1 ?>
        </strong></span></td>
        <td><span class="style1">
          <input name="tele1" type="text" id="tele1" value="<?=$data['telefono_c'] ?>" size="30">
        </span></td>
        <td class="style1"><strong>
          <?= LANG_squestion ?>
        </strong></td>
        <td class="style1"><textarea name="spreg" cols="30" rows="2" id="spreg"><?=$data['clave_preg'] ?>
          </textarea></td>
      </tr>
      <tr>
        <td><span class="style1"><strong>
          <?=LANG_tel2 ?>
        </strong></span></td>
        <td><span class="style1">
          <input name="tele2" type="text" id="tele2" value="<?=$data['telefono_p'] ?>" size="30">
        </span></td>
        <td class="style1"><strong>
          <?= LANG_sanswer ?>
        </strong></td>
        <td class="style1"><input name="sresp" type="text" id="sresp" value="<?=$data['clave_resp'] ?>" size="30"></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2" class="style1">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" align="left">&nbsp;</td>
        <td colspan="2" class="style1">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" align="left"><span class="style1"><span class="style3">
          <input type="button" name="b1"  value="<?=LANG_cancel?>" onClick="location.replace('../main.php');">
        </span>
            <input type="button" name="Submit" onClick="validar();" value="<?php echo LANG_save ?>">
        </span></td>
        <td colspan="2" align="center" class="style1">&nbsp;</td>
      </tr>
    </table>  
	
	</form>
	
	  
    <p></td>
    </tr>
     <tr>  
    <td>&nbsp;</td>
    </tr>
    </table>
    </td>
  </tr> 
</table>
</body>
</html>
<?

$est->cerrar();

?>