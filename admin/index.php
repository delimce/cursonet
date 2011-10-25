<?php session_start();
 include("../config/dbconfig.php");
 include("../class/clases.php");
 $nuevo = new tools('db');

 ///////////////en caso de que este iniciada la sesion como admin

   if($_SESSION['PROFILE']=="admin" && !empty($_SESSION['USERID']) && !empty($_SESSION['LENGUAJE'])){

   		$nuevo->redirect('./index2.php');

   }
 //////////////////

 $datos = $nuevo->simple_db("select titulo_admin,lenguaje,version from tbl_setup ");

 $_SESSION['LENGUAJE'] = $datos['lenguaje'];

 $lenguaje1 = '../config/lang/'.$_SESSION['LENGUAJE'];///verifico el lenguaje
 include ($lenguaje1);


?>
<html>
<head>
<script language="JavaScript" type="text/javascript" src="../js/browser_detect.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/ajax.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/utils.js"></script>

<title><?php echo $datos['titulo_admin'].' '.$datos['version'];  ?></title>
<link rel="stylesheet" type="text/css" href="../css/style_back.css">

<script language="JavaScript" type="text/javascript">

function validar(form1) {

  if (document.form1.user.value.length < 1) {
    alert("Escriba el Login de usuario en el campo \"Usuario\".");
        document.form1.user.focus();
    return (false);
  }

  if (document.form1.pass.value.length < 1) {
    alert("Escriba el password de usuario en el campo \"Clave\".");
        document.form1.pass.focus();
    return (false);
  }


  	oXML = AJAXCrearObjeto();
	oXML.open('post', 'valida.php');
	oXML.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	oXML.onreadystatechange = function(){
		if (oXML.readyState == 4 && oXML.status == 200) {

				if(oXML.responseText==1){

				location.replace('index2.php');

				}else if(oXML.responseText==2){
				
				alert('<?php echo LANG_VAL_noentry2; ?>');
								
				}else{

				alert('<?php echo LANG_VAL_noentry; ?>');

				}

				vaciar(oXML);

		}
	 }

	oXML.send('user='+document.form1.user.value+'&pass='+document.form1.pass.value+'&curso='+document.form1.curso.value);

  return (false);
 }
</script>

</head>
<body>
<br>
<table width="637" height="307" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="366" rowspan="3" valign="bottom"><img src="../images/backend/p001.jpg" width="366" height="313"></td>
    <td height="170" colspan="2" valign="bottom"><img src="../images/backend/p002.jpg" width="271" height="170"></td>
  </tr>
  <tr>
    <td width="206" height="83" valign="middle" bgcolor="#FFFFFF">
	<form name="form1" method="post" action="" onSubmit="return validar();">
	  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="small" title="<?php echo LANG_enter_admin ?>">

        <tr>
          <td width="31%" class="small"><strong><?php echo LANG_user?></strong></td>
          <td width="69%" align="left"><input name="user" type="text" class="small" id="user"></td>
        </tr>
        <tr>
          <td class="small"><strong><?php echo LANG_pass?></strong></td>
          <td align="left"><input name="pass" type="password" class="small" id="pass"></td>
        </tr>
        <tr>
          <td height="18" align="left" class="small"><strong><?php echo LANG_curso_id?></strong></td>
          <td height="18" align="left" class="small">
		  <?php echo $nuevo->combo_db("curso","select id,alias from tbl_curso","alias","id",false,$_SESSION['CURSOID'],false,LANG_curso_nocurso.'<input name="curso" type="hidden" id="curso" value="-1">'); ?>		  </td>
          </tr>
        <tr>
          <td colspan="2" align="left" class="style3"><?php echo '<input name="Submit" id="submit" type="submit" class="style1" value="'.LANG_enter.'">'; ?></td>
          </tr>
      </table>
    </form>
    </td>
    <td width="65" align="left" valign="bottom"><img src="../images/backend/p004.jpg" width="65" height="94"></td>
  </tr>
  <tr>
    <td height="18" colspan="2" valign="bottom"><img src="../images/backend/p003.jpg" width="271" height="49"></td>
  </tr>
  <tr>
  <td height="18" colspan="3" valign="bottom">&nbsp;</td>
</tr>
  <tr>
  <td height="18" colspan="3" align="center" valign="middle">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
    <td width="23%" align="right"><a href="http://delimce.com" target="_blank"><img src="../images/backend/delminilogo.gif" width="80" height="15" border="0" title="deliMce.com"></a></td>
    <td width="77%" align="left" class="small">&nbsp;      <?php echo LANG_license.' '.date("Y"); ?></td>
  </tr>
  </table>
  </td>
  </tr>
</table>
</body>
</html>
<?php

$nuevo->cerrar();

?>
