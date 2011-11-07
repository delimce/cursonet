<?php session_start();
 include("../config/dbconfig.php");
 include("../class/clases.php");

 
 $nuevo = new tools("db");
 
 $val = $nuevo->array_query2("select modo,lenguaje,signature from tbl_setup");

/*permitir inscripcion en modo curso 
 if($val[0]!=0){
 
	$nuevo->cerrar();
	$nuevo->redirect('../error/error.php');

 }
 
 */
 
  include("../config/lang/$val[1]"); ///idioma

?>
<html>
<head>
<title><?= $_SESSION['TINSCRIPCION'] ?></title>
<link rel="stylesheet" type="text/css" href="../css/style_front.css">
<style type="text/css">
<!--
.style3 {color: #FF0000}
-->
</style>

<script type="text/javascript" src="../js/calendario/calendar.js"></script>
<script type="text/javascript" src="../js/calendario/calendar-es.js"></script>
<script type="text/javascript" src="../js/calendario/calendar-setup.js"></script>
<script type="text/javascript" src="../js/popup.js"></script>
<LINK href="../js/calendario/calendario.css" type=text/css rel=stylesheet>

    <script language="JavaScript" type="text/javascript">
		  function validar(){
		  
		  		
			var login2 = document.form1.login1.value;
					 
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
			   document.form1.login1.focus();
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
			 
			 
			  if (document.form1.preg.value==""){
			   alert("Introduzca una pregunta secreta");
			   document.form1.preg.focus();
			   return (false);
			 }
			 
			  if (document.form1.resp.value==""){
			   alert("Introduzca la respuesta a la pregunta secreta");
			   document.form1.resp.focus();
			   return (false);
			 }
					 
			 			 
			   return (true);
		   }
		</script>

 <SCRIPT LANGUAGE="JavaScript">

   function preload() {

   document.getElementById('hidepage').style.display = 'inline';
   document.getElementById('loader').style.display = 'none';

   }
   // End -->
   </script>



   </head>
   <center>
  <BODY OnLoad="preload()" vlink="#000080" bgcolor="#FFFFFF">

<div id="loader" style="display:run-in"><table width=100%
cellpadding="4" cellspacing="4">
     <tr><td align="center" class="style1"><?=LANG_load ?></td></tr></table></div>

   <div id="hidepage" style="display:none">

<table width="755" height="1" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" id="AutoNumber2" style="border-collapse: collapse; border-bottom-width:0">
  <tr>
    <td width="755" style="border-left:1px solid #CCCCCC; border-right-style:solid; border-right-width:1; border-top-style:solid; border-top-width:1; border-bottom-style:none; border-bottom-width:medium" height="59" bgcolor="#3399FF">
    <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse; border-width: 0" bordercolor="#111111" width="100%" id="AutoNumber6" height="72">
      <tr>
        <td width="28%" height="70" align="center" bgcolor="#7A98AD" style="border-style: none; border-width: medium">
          <p style="margin-left: 5"><img src="../images/frontend/logo_corner.gif" width="162" height="75"></td>
        <td width="72%" height="70" bgcolor="#7A98AD" style="border-style: none; border-width: medium">
          <p align="center" style="margin-top: 0; margin-bottom: 0">&nbsp;</p></td>
        </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td width="755" height="1" valign="bottom" bgcolor="#CCCCCC" style="border-left:1px solid #CCCCCC; border-right-style: solid; border-right-width: 1; border-bottom-style: solid; border-bottom-width: 1; border-top-style:none; border-top-width:medium">
	
	  <form name="form1" method="post" action="guarda.php" target="ins" onSubmit="return validar();">
	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
    <td class="no_back"><table width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <td width="7%" rowspan="31">&nbsp;</td>
        <td width="19%">&nbsp;</td>
        <td width="24%">&nbsp;</td>
        <td width="5%" rowspan="31">&nbsp;</td>
        <td width="15%">&nbsp;</td>
        <td width="25%">&nbsp;</td>
        <td width="5%" rowspan="31">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#DDDDFF" class="style1"><strong>
          <?=LANG_name ?>
          <span class="style3">*</span></strong></td>
        <td bgcolor="#DDDDFF"><input name="nombre" type="text" id="nombre"></td>
        <td bgcolor="#DDDDFF" class="style1"><strong>
          <?=LANG_tel1 ?>
        </strong></td>
        <td bgcolor="#DDDDFF"><input name="tele1" type="text" id="tele1"></td>
        </tr>
      <tr>
        <td bgcolor="#DDDDFF" class="style1"><strong>
          <?=LANG_lastname ?>
          <span class="style3">*</span></strong></td>
        <td bgcolor="#DDDDFF"><input name="apellido" type="text" id="apellido"></td>
        <td bgcolor="#DDDDFF" class="style1"><strong>
          <?=LANG_tel2 ?>
        </strong></td>
        <td bgcolor="#DDDDFF"><input name="tele2" type="text" id="tele2"></td>
        </tr>
      <tr>
        <td bgcolor="#DDDDFF" class="style1"><strong>
          <?=LANG_ci ?>
          <span class="style3">*</span></strong></td>
        <td bgcolor="#DDDDFF"><input name="ci" type="text" id="ci"></td>
        <td bgcolor="#DDDDFF" class="style1"><strong>
          <?=LANG_msn ?>
        </strong></td>
        <td bgcolor="#DDDDFF"><input name="msn" type="text" id="msn"></td>
        </tr>
      <tr>
        <td bgcolor="#DDDDFF" class="style1"><strong>
          <?=LANG_sex ?>
        </strong></td>
        <td bgcolor="#DDDDFF"><select name="sexo" id="sexo">
          <option value="M"><?=LANG_male?></option>
          <option value="F"><?=LANG_female?></option>
        </select>        </td>
        <td bgcolor="#DDDDFF" class="style1"><strong>
          <?=LANG_yahoo ?>
        </strong></td>
        <td bgcolor="#DDDDFF"><input name="yahoo" type="text" id="yahoo"></td>
        </tr>
      <tr>
        <td bgcolor="#DDDDFF" class="style1"><strong>
          <?=LANG_fecha_nac ?>
          <span class="style3">*</span></strong></td>
        <td valign="middle" bgcolor="#DDDDFF"><input name="fecha_nac" type="text" id="fecha_nac" size="12" OnFocus="this.blur()" value="01/01/1980" onClick="alert('<?=LANG_calendar_use?>')">
		<img src="../images/frontend/cal.gif" id="f_trigger_d" style="cursor: hand; border: 0px;" title="<?=LANG_calendar?>"> 
				<script type="text/javascript">
					Calendar.setup({
						inputField     :    "fecha_nac",     // id of the input field
						ifFormat       :    "<?=strtolower("d/m/Y")?>",    // format of the input field
						button         :    "f_trigger_d",  // trigger for the calendar (button ID)
						singleClick    :    true
					});
				</script></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td bgcolor="#D7FFD7" class="style1"><strong>
          <?=LANG_email ?>
          <span class="style3">*</span></strong></td>
        <td bgcolor="#D7FFD7"><input name="email" type="text" id="email"></td>
        <td bgcolor="#D7FFD7" class="style1"><strong>
          <?= LANG_carreer ?>
        </strong></td>
        <td bgcolor="#D7FFD7"><input name="carrera" type="text" id="carrera"></td>
      </tr>
      <tr>
        <td bgcolor="#D7FFD7" class="style1"><strong>
          <?=LANG_login ?>
          <span class="style3">*</span></strong></td>
        <td bgcolor="#D7FFD7"><input name="login1" type="text" id="login1"></td>
        <td bgcolor="#D7FFD7" class="style1"><strong>
          <?= LANG_faculty_level ?>
        </strong></td>
        <td bgcolor="#D7FFD7"><input name="nivel" type="text" id="nivel"></td>
      </tr>
      <tr>
        <td bgcolor="#D7FFD7" class="style1"><strong>
          <?=LANG_pass ?>
          <span class="style3">*</span></strong></td>
        <td bgcolor="#D7FFD7"><input name="pass1" type="password" id="pass1"></td>
        <td bgcolor="#D7FFD7" class="style1"><strong>
          <?= LANG_university ?>
        </strong></td>
        <td bgcolor="#D7FFD7"><input name="universidad" type="text" id="universidad"></td>
      </tr>
      <tr>
        <td bgcolor="#D7FFD7" class="style1"><strong>
          <?=LANG_pass2 ?>
          <span class="style3">*</span></strong></td>
        <td bgcolor="#D7FFD7"><input name="pass12" type="password" id="pass12"></td>
        <td bgcolor="#D7FFD7" class="style1"><strong>
          <?=LANG_a_internet ?>
        </strong></td>
        <td bgcolor="#D7FFD7"><select name="iacc" id="iacc">
          <option value="SI">
          <?=LANG_yes?>
          </option>
          <option value="NO">
          <?=LANG_no?>
          </option>
        </select></td>
      </tr>
      <tr>
        <td rowspan="2" bgcolor="#D7FFD7" class="style1"><strong>
          <?=LANG_secretq ?>
          <span class="style3">*</span></strong></td>
        <td rowspan="2" bgcolor="#D7FFD7"><textarea name="preg" maxlength="99" id="preg" cols="30" rows="4"></textarea></td>
        <td bgcolor="#D7FFD7" class="style1"><strong>
          <?=LANG_d_internet ?>
        </strong></td>
        <td bgcolor="#D7FFD7"><select name="dacc" id="dacc">
          <option value="<?=LANG_Laboratory?>">
          <?=LANG_Laboratory?>
          </option>
          <option value="<?=LANG_university?>">
          <?=LANG_university?>
          </option>
          <option value="<?=LANG_cybercafe?>">
          <?=LANG_cybercafe?>
          </option>
          <option value="<?=LANG_Home?>">
          <?=LANG_Home?>
          </option>
          <option value="<?=LANG_work?>">
          <?=LANG_work?>
          </option>
        </select></td>
      </tr>
      <tr>
        <td colspan="2" rowspan="3" class="style1">&nbsp;</td>
        </tr>
      <tr>
        <td bgcolor="#D7FFD7" class="style1"><strong>
          <?=LANG_secreta ?>
          <span class="style3">*</span></strong></td>
        <td bgcolor="#D7FFD7"><input name="resp" type="text" id="resp" maxlength="99"></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      
      
      <tr>
        <td colspan="2" align="right">&nbsp;</td>
        <td colspan="2"><input type="submit" name="Submit" value="<?php echo LANG_save ?>">
          <input type="reset" name="Submit2" value="<?php echo LANG_reset ?>"></td>
        </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
        <td colspan="2"><iframe name="ins" frameborder="0" align="middle" height="1" src="guarda.php"></iframe></td>
      </tr>
      
    </table></td>
      </tr>
     </table>

	  </form>
	  
      <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse; border-width: 0" bordercolor="#CCCCCC" width="100%" id="AutoNumber3">
      <tr>
        <td width="229%" style="border-style: none; border-width: medium" valign="top" bgcolor="#7A98AD">
        <p align="center" style="margin-top: 5; margin-bottom: 5"><b>
        <font face="Arial" size="1" color="#FFFFFF"><?=$val[2]?>
        </font></b></td>
      </tr>
    </table>
    </td>
  </tr>
</table>
</div>
</body>

</html>
<?php 

$nuevo->cerrar();

?>