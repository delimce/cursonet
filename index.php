<?php session_start(); //sesion generica por user que accede
 include("config/dbconfig.php");
 include("class/clases.php");
 $nuevo = new tools('db');
 
 $val = $nuevo->array_query2("select modo,lenguaje,titulo,formato_fecha,formato_fecha_db,version from tbl_setup"); //// modo
 
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
<script language="JavaScript" type="text/javascript" src="js/jquery/jquery-1.7.2.min.js"></script>

<script>
    function onSuccess(data)
    {
        data = $.trim(data);
        
        if(data==1){
            $(location).attr('href','est/index.php');
        }else if(data==2){
            
            alert('<?php echo LANG_noactive; ?>');
            
        }else{
            
            alert('<?php echo LANG_VAL_noentry; ?>');
            
        }    
        
    }
    
    
    $(document).ready(function() {
        
        
        $("#Submit").click(function(){
            
            
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
            
            
            var formData = $("#form1").serialize();
            
            $.ajax({
                type: "POST",
                url: "valida.php",
                cache: false,
                data: formData,
                success: onSuccess
            });
            
            return false;
        });
    });
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
	
        <form name="form1" id="form1" method="post" action="">
	  <table width="100%" border="0" cellpadding="2" cellspacing="2" class="style1">
        <tr>
          <td height="22" colspan="2" class="style1"><?php echo LANG_est_welcome ?>&nbsp;<a href="ins/index.php"><?php echo LANG_content_benter ?></a></td>
        </tr>
        <tr>
          <td width="28%" class="style1"><strong><?php echo LANG_user ?></strong></td>
          <td width="62%"><input style="background:#C0C0C0" size="17" name="login1" type="text" id="login1"></td>
        </tr>
        <tr>
          <td class="style1"><strong><?php echo LANG_pass ?></strong></td>
          <td><input style="background:#C0C0C0" size="17" name="pass1" type="password" id="pass1"></td>
        </tr>
        <tr>
          <td class="style1">&nbsp;</td>
            <td>
                  <button style="background:#C0C0C0;" type="Submit" id="Submit" value="<?php echo LANG_enter ?>"><?php echo LANG_enter ?></button>
            </td>
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