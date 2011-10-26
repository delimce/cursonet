<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);


$crear = new tools();
$crear->autoconexion();



if(isset($_POST['enlace'])){






	if($_POST['fuente']==LANG_local){

		$tama =  bcdiv($_FILES['archivo']['size'],1048576,2); ///tamano en mb


		if($tama < $TMAX && $_FILES['archivo']['size'] > 10){ //////////subiendo la imagen

			$path = "../../".$ADMINPATH.$_FILES['archivo']['name']; //////////subiendo la imagen a la carpeta por defecto
			if(!copy($_FILES['archivo']['tmp_name'], $path)){

				$crear->javaviso(LANG_content_upload_error);

			}else{

			
				$valores[0] = 2;
				$valores[1] = date("Y-m-d h:i:s");
				$valores[2] = $tama.' MB';
				$valores[3] = $_FILES['archivo']['name'];
				$valores[4] = 'admin';
				$valores[5] = $_SESSION['USERID'];
				$valores[6] = $_POST['desc'];
		        $valores[7] = $_POST['fuente'];

				$crear->insertar2("tbl_recurso","tipo, fecha, size, dir, add_by, persona,descripcion,fuente",$valores);
				$crear->javaviso(LANG_cambios,"videos.php");


			}

		}else{


			$crear->javaviso(LANG_content_upload_error);


		}


	}else{

		
		$valores[0] = 2;
		$valores[1] = date("Y-m-d h:i:s");
		$valores[2] = $_POST['enlace'];
		$valores[3] = 'admin';
		$valores[4] = $_SESSION['USERID'];
		$valores[5] = $_POST['desc'];
		$valores[6] = $_POST['fuente'];

		$crear->insertar2("tbl_recurso","tipo, fecha, dir, add_by, persona,descripcion,fuente",$valores);
		$crear->javaviso(LANG_cambios,"videos.php");

	}






}







?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../../css/style_back.css">
<script type="text/javascript" src="../../js/dyntar.js"></script>

	<script language="JavaScript" type="text/javascript">
	function validar(){

		var you;
		you = document.form1.enlace.value;

		if(document.form1.fuente.value=='0'){

			alert('<?=LANG_content_videofvalid ?>');
			document.form1.fuente.focus();

			return false;

		}

		if(document.form1.fuente.value=='<?=LANG_local?>'){

			if(document.form1.archivo.value==''){

				alert('<?=LANG_content_error ?>');

				return false;

			}

		}


		if(document.form1.fuente.value=='youtube'){


			if(you.indexOf("http://www.youtube.com/watch?v=")==-1 || you.indexOf("http://www.youtube.com/watch?v=")>0){

				alert('<?=LANG_content_videoyoutubevalid ?>');

				return false;

			}

		}
		
		
		if(document.form1.fuente.value=='veoh'){


			if(you.indexOf("http://www.veoh.com/videoDetails.html?v=")==-1 || you.indexOf("http://www.veoh.com/videoDetails.html?v=")>0){

				alert('<?=LANG_content_videoveohvalid ?>');

				return false;

			}

		}
		

		return true;

	}
	</script>

</head>

<body>
<table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="26" valign="top"><?php echo $menu->nombre; ?></td>
  </tr>
  <tr>
    <td><?php $menu->mostrar(2); ?></td>
  </tr>
  <tr>
    <td>
	
	<table style="border-right:#000000 solid 1px; border-left:#000000 solid 1px; border-bottom:#000000 solid 1px;" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><form action="addvideo.php" method="post" enctype="multipart/form-data" name="form1" onSubmit="return validar();">
  <table width="100%" border="0" cellspacing="4" cellpadding="3">
  <tr>
  <td colspan="2">&nbsp;</td>
</tr>
    <tr>
  <td width="25%" class="style3"><?php echo LANG_content_videof; ?></td>
  <td width="75%"><select name="fuente">
  <option value="0" onClick="document.getElementById('you').style.display='none';document.getElementById('local').style.display='none';"><?=LANG_select?></option>
  <option value="youtube" onClick="document.getElementById('you').style.display='';document.getElementById('local').style.display='none';">Youtube.com</option>
   <option value="veoh" onClick="document.getElementById('you').style.display='';document.getElementById('local').style.display='none';">VeoH.com</option>
  <option value="<?=LANG_local?>" onClick="document.getElementById('local').style.display='';document.getElementById('you').style.display='none';"><?=LANG_add?></option>
</select></td>
  </tr>
    <tr id="you" style="display:none">
  <td width="19%" class="style3"><?php echo LANG_content_videolink; ?></td>
  <td width="81%"><input name="enlace" type="text" id="enlace" value="http://www." size="70"></td>
  </tr>
   <tr id="local" style="display:none">
  <td width="19%" class="style3"><?php echo LANG_content_videoup; ?></td>
  <td width="81%"><input name="archivo" type="file" id="archivo" size="40"></td>
  </tr>
  <tr>
    <td class="style3"><?php echo LANG_group_desc; ?></td>
    <td><textarea name="desc" cols="60" rows="4" class="style1" id="desc"></textarea></td>
  </tr>
  <tr>
  <td colspan="2">
       <input type="button" name="Submit2"  value="<?=LANG_back?>" onClick="location.replace('videos.php')">
       <input type="submit" name="Submit" value="<?=LANG_save?>">
  </td>     
       </tr>
</table>
</form></td>
      </tr>
    </table>	</td>
  </tr>
</table><br>
</body>
</html>
<?php 

$crear->cerrar();

?>