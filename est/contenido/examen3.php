<?php session_start();
$profile = 'est'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/tools.php");
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje


  $pro = new tools();
  $pro->autoconexion();
  

?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../../css/style_back.css">
<style type="text/css">
<!--
body {
background:none;
background-color:transparent;
	
}

-->
</style>
<style type="text/css" media="print">

body { display: none; }

</style>

<script type="text/javascript">
//form tags to omit in NS6+:
//http://eking.in
var omitformtags=["input", "textarea", "select"]

omitformtags=omitformtags.join("|")

function disableselect(e){
if (omitformtags.indexOf(e.target.tagName.toLowerCase())==-1)
return false
}

function reEnable(){
return true
}

if (typeof document.onselectstart!="undefined")
document.onselectstart=new Function ("return false")
else{
document.onmousedown=disableselect
document.onmouseup=reEnable
}

</script>
                    


</head>

<body>


<?php 

	$data = $pro->simple_db("select nombre, nivel,npreg from evaluacion where id = {$_REQUEST['eval_id']} ");
	
	if($data['nivel']>0) $pperg = " and p.nivel = {$data['nivel']} "; ////para seleccionar preguntas por nivel
	$preguntas = $pro->estructura_db("SELECT 
									  p.pregunta,
									  p.id,
									  p.tipo,
									  RAND() AS numero
									FROM
									  evaluacion_pregunta p
									  INNER JOIN evaluacion e ON (p.eval_id = e.id)
									WHERE
									  e.id = {$_REQUEST['eval_id']} $pperg order by numero limit {$data['npreg']}");
	
	
	
	$npre = $pro->nreg;
	
	if($pro->nreg>0){ 
	
			$opciones = $pro->estructura_db("SELECT 
											  o.id,
											  o.opcion,
											  o.correcta,
											  o.preg_id,
											   RAND() AS numero
											FROM
											  pregunta_opcion o
											  INNER JOIN evaluacion_pregunta p ON (o.preg_id = p.id)
											  INNER JOIN evaluacion e ON (p.eval_id = e.id)
											WHERE
											  e.id = {$_REQUEST['eval_id']} order by numero");
			
	}

?>

<?php if($npre>0){  ?>

<form name="form1" method="post" action="guardarp.php">
<table width="95%" border="0" align="center">
  <tr>
    <td colspan="2" class="no_back"><b><?php echo LANG_eva_name?></b> : <?php echo $data['nombre']; ?></td>
  </tr>
  <tr>
    <td colspan="2"></td>
  </tr>
  <?php 
			
					 
			 for($i=0;$i<count($preguntas);$i++){
			 
			 $np = $i+1;
			 
			
			
			 	
			 	
							 ?>
				  <tr>
					<td colspan="2" class="style3"><?php echo $np.'&nbsp;&nbsp;'.$preguntas[$i]['pregunta'] ?></td>
				  </tr>
				  <?php 
				  
				  
				   if($preguntas[$i]['tipo']==1){
							 
															 for($j=0;$j<count($opciones);$j++){
															
															if($preguntas[$i]['id']==$opciones[$j]['preg_id']){
															 ?>
									  <tr>
										<td width="9%" align="right">&nbsp;
										  <input name="<?php echo 'p_1_'.$preguntas[$i]['id'] ?>" type="radio" value="<?php echo $opciones[$j]['id'] ?>"></td>
										<td width="91%"><?php echo $opciones[$j]['opcion'] ?></td>
									  </tr>
									  <?php 
															 
															 }
												 
															 }
							 
				  
				  }else{
				  
				  
				   ?>
				  <tr>
					<td colspan="2"><textarea name="<?php echo 'p_0_'.$preguntas[$i]['id'] ?>" cols="50" rows="3" wrap="virtual"></textarea></td>
				  </tr>
				  <?php 
				  
				  
				  
				  }
				  
				  
				  
				  
				   ?>
   
   
   
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <?php 
			 
			 
		}
			 
			 
		
			 
  ?>
  <tr>
    <td colspan="2"><input type="submit" name="Submit" value="Guardar">
      <input type="reset" name="Submit2" value="Borrar">
      <input name="eval_id" type="hidden" id="eval_id" value="<?=$_REQUEST['eval_id'] ?>"></td>
  </tr>
</table>

</form>

<?php  


		}else{
		
		
		echo LANG_est_noquestions;
		
		
		} 
?>
</body>
</html>
<?php


 $pro->cerrar();

?>