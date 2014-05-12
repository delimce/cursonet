<? session_start();
include ("../../../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje
	 
	 if(isset($_POST['subir'])){
	 
		 $_SESSION['OPCIONES'] = $_POST['respuestas']; 
		 $_SESSION['CORRECT'] = $_POST['correcta']; 
		 
		 	 
	 }	 
	 
	 $total = count($_SESSION['OPCIONES']);
	
	
	if($_POST['subir']!=2 && isset($_POST['subir'])){
	
			if($_SESSION['OPCIONES'][0]!='')$total = count($_SESSION['OPCIONES'])+1; else $total = 1;
			
			
			if($_REQUEST['borrar']!='-1' and $_REQUEST['borrar']!=''){
			
				
					for($i=$_REQUEST['borrar'];$i<count($_SESSION['OPCIONES']);$i++){
			
			
					   $_SESSION['OPCIONES'][$i] = $_SESSION['OPCIONES'][$i+1];
			
			
				   }
				
				$total = $total-2;
			
			
			}
			
	}		
	
?>
<head> <meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="../../../../css/style_back.css">
</head>

<body leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0">


<form name="opciones" method="post" action="">

<table width="100%" border="0" cellpadding="0" cellspacing="1">
  <tr>
    <td colspan="2" align="center" class="table_bk"><?php echo LANG_eva_right_opc ?></td>
    <td width="81%" align="center" class="table_bk"><?php echo LANG_eva_amsopc ?></td>
    <td width="7%" align="center" class="table_bk"><input name="subir" type="hidden" id="subir" value="1">
      <input name="borrar" type="hidden" id="borrar" value="-1"></td>
  </tr>
 <?php for($i=0;$i<$total;$i++){ ?>
 
  <tr>
    <td colspan="2" align="center"><input name="correcta" type="radio" id="radio" value="<?php echo $i ?>" <?php if($i==$_SESSION['CORRECT']) echo 'checked'; ?>></td>
    <td align="center"><input name="respuestas[]" type="text" class="small" id="respuestas[]" value="<?php echo $_SESSION['OPCIONES'][$i]; ?>" size="75"></td>
    <td align="center"><a href="#" onClick="document.opciones.borrar.value='<?php echo $i ?>'; document.opciones.submit();"><img title="borrar opción" src="../../../../images/backend/cube_yellow_delete.png" width="16" height="16" border="0"></a></td>
  </tr>
  <?php } ?>
</table>
</form>
</body>
</html>
