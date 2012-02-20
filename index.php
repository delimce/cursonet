<?php session_start(); //sesion generica por user que accede
 include("config/dbconfig.php");
 include("class/clases.php");
 $nuevo = new tools('db');
 
 $val = $nuevo->array_query2("select modo,lenguaje,titulo,formato_fecha,formato_fecha_db,version from setup"); //// modo
 
 $_SESSION['LENGUAJE'] = $val[1];
 $_SESSION['DB_FORMATO_DB'] = $data[4];
 $_SESSION['DB_FORMATO'] = $data[3];
 
 $lenguaje1 = 'config/lang/'.$_SESSION['LENGUAJE'];///verifico el lenguaje
 include ($lenguaje1); 
  
  //////////////////validar el modo
   if($val[0]==0){
 
		$nuevo->redirect("ins/index.php");	
	 
   }else if($val[0]==2){
   
   		$nuevo->redirect("error/offline.php");	
   
   }
 
 
//////////////cambio de imagen
 $images = $nuevo->listar_archivos('images/frontend/randon_i/');
 $actual = rand(0,count($images)-1);
////////////////////////////// 
 
 
?>
<html>
<head>
<title><?php echo $val[2].' '.$val[5];  ?></title>
<link rel="stylesheet" type="text/css" href="css/style_front.css">

<script language="JavaScript" type="text/javascript" src="js/browser_detect.js"></script>
<script language="JavaScript" type="text/javascript" src="js/ajax.js"></script>
<script language="JavaScript" type="text/javascript" src="js/utils.js"></script>


<script language="JavaScript" type="text/javascript">


function validar(form1) {

  if (document.form1.login1.value.length < 1) {
  	
    alert("Escriba el Login de usuario en el campo \"Usuario\".");
        document.form1.login1.focus();
		
    return (false);
  }
  
  if (document.form1.pass1.value.length < 1) {
    
		alert("Escriba el password de usuario en el campo \"Clave\".");
        document.form1.pass1.focus();
		
    return (false);
  }

	oXML = AJAXCrearObjeto();
	oXML.open('post', 'valida.php');
	oXML.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	oXML.onreadystatechange = function(){
		if (oXML.readyState == 4 && oXML.status == 200) {
		
				if(oXML.responseText==1){
				
				location.replace('est/index.php');
				
				}else if(oXML.responseText==2){
				
				alert('<?php echo LANG_noactive; ?>');				
				
				}else{
				
				alert('<?php echo LANG_VAL_noentry; ?>');
				
				} 
				
				vaciar(oXML);
           
		}
	 }

	oXML.send('login1='+document.form1.login1.value+'&pass1='+document.form1.pass1.value); 
	

	return (false);

  
 }
</script>




</head>
<body>
<br>
<table height="517" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="419" rowspan="3" valign="bottom"><img src="images/frontend/randon_i/<?=$images[$actual]; ?>" width="419" height="516" GALLERYIMG="no"></td>
    <td height="209" colspan="2" valign="bottom"><img src="images/frontend/home02.jpg" width="281" height="208" GALLERYIMG="no"></td>
  </tr>
  <tr>
    <td width="199" height="0" valign="top" background="images/frontend/home05.jpg" bgcolor="#A0A0A0">
	<form name="form1" method="post" action="" onSubmit = "return validar(this)">
	  <table width="100%" border="0" cellpadding="2" cellspacing="2" class="style1">
        <tr>
          <td height="22" colspan="2" class="style1"><?php echo LANG_est_welcome ?>&nbsp;<a href="ins/index.php"><?php echo LANG_content_benter ?></a></td>
        </tr>
        <tr>
          <td width="28%" class="style1"><strong><?php echo LANG_user ?></strong></td>
          <td width="72%"><input style="background:#C0C0C0" name="login1" size="17" type="text" id="login1"></td>
        </tr>
        <tr>
          <td class="style1"><strong><?php echo LANG_pass ?></strong></td>
          <td><input style="background:#C0C0C0" name="pass1" size="17" type="password" id="pass1"></td>
        </tr>
        <tr>
          <td class="style1">&nbsp;</td>
          <td><input style="background:#C0C0C0;" type="submit" name="Submit" id="submit" value="<?php echo LANG_enter ?>"></td>
        </tr>
        
        <tr>
          <td height="22" colspan="2" align="center" class="style1"><a href="recordar/index.php" target="_self" title="<?php echo LANG_forgotpass_info ?>"><?php echo LANG_forgotpass ?></a></td>
        </tr>
      </table>
    </form>
    </td>
    <td width="85" align="left"><img src="images/frontend/home04.jpg" width="82" height="179" GALLERYIMG="no"></td>
  </tr>
  <tr>
    <td height="129" colspan="2" valign="bottom"><img src="images/frontend/home03.jpg" width="281" height="129" GALLERYIMG="no"></td>
  </tr>
</table>
</body>
</html>
<?php $nuevo->cerrar(); ?>