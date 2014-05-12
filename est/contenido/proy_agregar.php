<?php session_start();
$profile = 'est'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje


   if(isset($_FILES['archivo'])){
	   
  
  				$tama =  bcdiv($_FILES['archivo']['size'],1048576,2); ///tamano en mb
			 
	 	  		 
				 if($tama < $TMAX && $_FILES['archivo']['size'] > 10){ //////////subiendo el archivo
				 
			             $path = "../../".$USERPATH.'proy/'.$_SESSION['CI'].'_'.$_FILES['archivo']['name']; ///para indentificar el archivo del estudiante
						
						
						$crear = new tools();
						
						 if($crear->upload_file($_FILES['archivo'],$path,$TMAX,false,true)==false){
						
		
							   $crear->javaviso(LANG_content_upload_error);
							
			              }else{
							  
							  
						   $crear->autoconexion();
						   $crear->abrir_transaccion();
						  
						  					       	
								 $valores[0] = 0;
								 $valores[1] = date("Y-m-d h:i:s");
								 $valores[2] = $tama.' MB';
								 $valores[3] = $_SESSION['CI'].'_'.$_FILES['archivo']['name']; ///para indentificar el archivo del estudiante
								 $valores[4] = 'est';
								 $valores[5] = $_SESSION['USER'];
								 
								 $crear->insertar2("tbl_recurso","tipo, fecha, size, dir, add_by, persona",$valores);
								 
								
								 $valores2[0] = $_SESSION['PROY_ID'];
								 $valores2[1] = $_SESSION['USER'];
								 $valores2[2] = $crear->ultimoID;

								 $crear->insertar2("tbl_proyecto_estudiante","proy_id,est_id,rec_id",$valores2);

						 $crear->cerrar_transaccion(); 
								 
						 $crear->cerrar();
								 
								 
								 ?>
								 
								     <script language="javascript">
    
									window.opener.location.reload();
									window.close();
									
									</script>
								 
								 <?


						  
						  }
				 
				 }else{
				 
				 
				  $crear->javaviso(LANG_content_upload_error);
				 
				 
				 }
	   
	 
	 }

?>
<html>
<head> <meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="../../css/style_front.css">
<script type="text/javascript" src="../../js/utils.js"></script>

	<script language="JavaScript" type="text/javascript">
		function validar(){
		
		 if(document.form1.archivo.value==''){
		 
		 alert('<?=LANG_content_error ?>');
		 
		 return false;
		 
		 }
		 
		 deshabilitar(document.getElementById('Submit3'));	 
		 return true;
		
		}
	</script>
</head>

<body>
<form action="proy_agregar.php" method="post" enctype="multipart/form-data" name="form1" onSubmit="return validar();">
  <table width="97%" border="0" align="center" cellpadding="3" cellspacing="4">
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
  <td colspan="2"><span class="style3"><?php echo LANG_content_upload2; ?></span></td>
</tr>
  <tr>
  <td width="19%" class="style3"><?php echo LANG_content_upload; ?></td>
  <td width="81%"><input name="archivo" type="file" id="archivo" size="40"></td>
</tr>
  <tr>
  <td colspan="2"><input type="button" name="Submit2"  value="<?=LANG_close?>" onClick="window.close();">
    <input name="Submit3" type="submit" id="Submit3" value="<?=LANG_save?>"></td>
  </tr>
</table>
</form>
</body>
</html>
