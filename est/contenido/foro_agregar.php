<?php session_start();
$profile = 'est'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/tools.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje




if(!empty($_POST['comentario'])){ ///se envia el comentario

	$valores[0] = $_SESSION['FORO_ID'];
	$valores[1] = 'est';
	$valores[2] = $_SESSION['USER'];
	$valores[3] = trim(stripcslashes(nl2br($_POST['comentario'])));
    $valores[4] = date('Y-m-d H:i:s');
    
    $insert = new tools();
    $insert->autoconexion();
    $insert->insertar2("foro_comentario","foro_id,tipo_sujeto,sujeto_id,content,fecha_post",$valores);
    $insert->cerrar();
    
    ?>
    <script language="javascript">
    
	window.opener.location.reload();
	window.close();
	
    </script>
    
    <?
    

}



?>

<html>
<head>


<link rel="stylesheet" type="text/css" href="../../css/style_front.css">
<script type="text/javascript" src="../../js/utils.js"></script>
<script language="JavaScript" type="text/javascript">
function validar(){


	if (document.form1.comentario.value == "") {

		alert('<?=LANG_foro_val_co ?>');
		document.form1.comentario.focus();

		habilitar(document.getElementById('Submit3'),'<?=LANG_save?>');
		return false;

	}

    deshabilitar(document.getElementById('Submit3'));
	return true;


}
</script>



</head>

<body>

<form name="form1" method="post" action="foro_agregar.php" onSubmit="return validar();">

<table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
    <td><span class="style3">
    <br>
    <?= LANG_foro_add ?>
     </span></td>
    </tr>
          <tr>
            <td><span class="style3">
              <textarea name="comentario" cols="111" rows="9" class="style1" id="comentario"></textarea>
            </span></td>
          </tr>
        
          
          <tr>
             <td>
              <input type="button" name="cerrar" onClick="window.close();" value="<?=LANG_close?>">
              <input name="Submit3" type="submit" id="Submit3" value="<?=LANG_save?>">
              </td>
          </tr>
        
</table>

 </form>


</body>
</html>
