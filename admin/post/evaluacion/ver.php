<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../config/setup.php"); ////////setup
include("../../../class/tools.php"); ////////clase
include ("../../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);

 $tool = new tools('db');
 
 $preguntas = $tool->estructura_db("SELECT DISTINCT 
										  p.pregunta,
										  (CASE p.nivel WHEN 1 THEN '".LANG_eva_level2."'
										  WHEN 2 THEN '".LANG_eva_level3."' ELSE '".LANG_eva_level4."' END) as nivel,
										  r.resp_opc,
										  o.preg_id,
										  o.correcta
										FROM
										  evaluacion_pregunta p
										  INNER JOIN evaluacion_estudiante e ON (p.eval_id = e.eval_id)
										  AND (e.eval_id = p.eval_id)
										  INNER JOIN evaluacion_respuesta_s r ON (p.id = r.preg_id)
										  AND (e.est_id = r.est_id)
										  INNER JOIN pregunta_opcion o ON (r.resp_opc = o.id)
										WHERE
										  e.id = '{$_SESSION['EVAL_REV']}' ");
										  
	
 	$opciones = $tool->estructura_db("select 
									  o.opcion,
									  o.preg_id,
									  o.id
									FROM
									  evaluacion_estudiante e
									  INNER JOIN evaluacion_pregunta p ON (e.eval_id = p.eval_id)
									  INNER JOIN pregunta_opcion o ON (p.id = o.preg_id)
									WHERE
									  e.id = '{$_SESSION['EVAL_REV']}' ");									  


?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../../../css/style_back.css">
</head>

<body>


<table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="26" valign="top"><?php echo $menu->nombre; ?></td>
  </tr>
  <tr>
    <td><?php $menu->mostrar(0); ?></td>
  </tr>
  <tr>
    <td>

	<table style="border-right:#000000 solid 1px; border-left:#000000 solid 1px; border-bottom:#000000 solid 1px;" width="100%" border="0" cellspacing="0" cellpadding="0">
       <tr>
         <td colspan="4" align="left">
         <table width="95%" border="0" align="center">
            <tr>
              <td colspan="2" class="no_back"><b><?php echo LANG_eva_name?></b> : </td>
            </tr>
		    <tr>
		      <td colspan="2"></td>
		      </tr>
			  
			 <?php 
			 
			 for($i=0;$i<count($preguntas);$i++){
			 
			 $np = $i+1;
			 ?> 
			  
		    <tr>
		      <td colspan="2" class="style3"><?php echo $np.'&nbsp;&nbsp;'.$preguntas[$i]['pregunta'] ?>&nbsp;<em style="color:blue"><?php echo $preguntas[$i]['nivel'] ?></em></td>
		     </tr>
		    
					 <?php 
			 
						 for($j=0;$j<count($opciones);$j++){
			 			
						if($preguntas[$i]['preg_id']==$opciones[$j]['preg_id']){
						 ?> 
						<tr>
						  <td width="9%">&nbsp;</td>
						  <td width="91%" <?php if($opciones[$j]['id']==$preguntas[$i]['resp_opc']) echo 'class="style4" style="color:red;"'; ?>><em><?php echo $opciones[$j]['opcion'] ?></em>
                          <?php if($preguntas[$i]['correcta']==1 and $opciones[$j]['id']==$preguntas[$i]['resp_opc']) echo '<img src="../../../images/backend/checkmark.gif" width="11" height="13">'; else if($opciones[$j]['id']==$preguntas[$i]['resp_opc']) echo '<img src="../../../images/backend/x.gif" width="14" height="16">';  ?>
                          </td>
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
         
         </td>
       </tr>
    </table>	</td>
  </tr>
</table>


</body>
</html>
<?php $tool->cerrar(); ?>