<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../../config/setup.php"); ////////setup
include("../../../../class/clases.php"); ////////clase
include ("../../../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);


  $pro = new tools("db");
 	
	$data = $pro->simple_db("select nombre from tbl_evaluacion where id = {$_REQUEST['id']} ");
	
	$preguntas = $pro->estructura_db("SELECT 
									  p.pregunta,
									  p.id
									FROM
									  tbl_evaluacion_pregunta p
									  INNER JOIN tbl_evaluacion e ON (p.eval_id = e.id)
									WHERE
									  e.id = {$_REQUEST['id']}");
	
	$opciones = $pro->estructura_db("SELECT 
									  o.opcion,
									  o.correcta,
									  o.preg_id
									FROM
									  tbl_pregunta_opcion o
									  INNER JOIN tbl_evaluacion_pregunta p ON (o.preg_id = p.id)
									  INNER JOIN tbl_evaluacion e ON (p.eval_id = e.id)
									WHERE
									  e.id = {$_REQUEST['id']}");
									  
	

?>
<html>
<head> <meta charset="utf-8">
<title><?php echo LANG_eva_name?> <?php echo $data; ?></title>
<link rel="stylesheet" type="text/css" href="../../../../css/style_back.css">
<style type="text/css">
<!--
.style4 {
	color: #0000FF;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="26" valign="top"> <span class="menu-title"><?= $menu->nombre; ?></span></td>
  </tr>
  <tr>
    <td><?php $menu->mostrar(0); ?></td>
  </tr>
  <tr>
    <td>

	<table style="border-right:#000000 solid 1px; border-left:#000000 solid 1px; border-bottom:#000000 solid 1px;" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><br>
          <table width="95%" border="0" align="center">
            <tr>
              <td colspan="2" class="no_back"><b><?php echo LANG_eva_name?></b> : <?php echo $data; ?></td>
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
			 
						 for($j=0;$j<count($opciones);$j++){
			 			
						if($preguntas[$i]['id']==$opciones[$j]['preg_id']){
						 ?> 
						<tr>
						  <td width="9%">&nbsp;</td>
						  <td width="91%" <?php if($opciones[$j]['correcta']==1) echo 'class="style4"'; ?>><em><?php echo $opciones[$j]['opcion'] ?></em></td>
						</tr>
						 <?php 
						 
						 }
			 
						 }
			 
						 ?>
						
			<tr>
		      <td colspan="2">&nbsp;</td>
		      </tr>
			 <?php 
			 
			 }
			 
			 ?>
			
            <tr>
              <td colspan="2"><input type="button" name="Button" value="<?php echo LANG_back ?>" onClick="history.back();"></td>
            </tr>
          </table>
          <br></td>
      </tr>
    </table>	</td>
  </tr>
</table>
</body>
</html>
<?php


 $pro->cerrar();

?>