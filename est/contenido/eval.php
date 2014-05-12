<?php session_start();
$profile = 'est'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php");
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

 $datos = new tools("db");
 $notas = new tools(); //para ver las notas
 $notas->dbc = $datos->dbc;
 
 function statuscolor($estatus){
 
  	switch ($estatus) {
		case 'Aplicandose':
		   $estado = '<font color="#009900">Aplicandose</font>';
		   break;
		case 'Pendiente':
		   $estado = '<font color="#000099">Pendiente</font>';
		   break;
		case 'Aplicada':
		   $estado = '<font color="#FF0000">Aplicada</font>';
		   break;
		
		case 'Realizada':
		   $estado = '<b>Realizada</b>';
		   break;   
		   
		}
		
		
		return $estado;
 
 }


	$query = "

			SELECT id,nombre,date_format(fecha,'{$_SESSION['DB_FORMATO_DB']} %h:%i %p') as fecha, date_format(fecha_fin,'{$_SESSION['DB_FORMATO_DB']} %h:%i %p') as fecha2,
			if((id = (select eval_id from tbl_evaluacion_estudiante where est_id = '{$_SESSION['USER']}' and eval_id = e.id)),'Realizada',
			(case when ( NOW() > e.fecha_fin ) then 'Aplicada'
			when ((NOW()>=e.fecha ) AND (NOW() <= e.fecha_fin ) ) then 'Aplicandose' 
			when (e.fecha > NOW()) then 'Pendiente' end)) as estatus
			FROM   tbl_evaluacion e
			WHERE
			(contenido_id= {$_SESSION['CASOACTUAL']} ) AND ((grupo_id in ({$_SESSION['GRUPOSID']}) ) OR ((grupo_id=0)))

	";
	
	$datos->query($query);
	


?>

<html>
<head> <meta charset="utf-8">

<META HTTP-EQUIV="refresh" CONTENT="30; URL=eval.php">
<link rel="stylesheet" type="text/css" href="../../css/style_front.css">
<script type="text/javascript" src="../../js/utils.js"></script>

</head>

<body style="margin-top: 6px;" bottommargin="0" topmargin="0" leftmargin="0" rightmargin="0">

<table width="98%" height="13%" border="0" align="center" cellpadding="0" cellspacing="0"  style="vertical-align:middle">
<tr>
  <td width="528" height="63" valign="top" class="style1">
   <div style="margin-right:20;">
     <p><b>
       <?=LANG_content_name ?>
       </b>&nbsp;<?php echo $_SESSION['CASO_TITULO']; ?>&nbsp;&nbsp;<b><br>
         <?= LANG_content_create ?>
         </b>&nbsp;<?php echo $_SESSION['CASO_FECHA']; ?>
          <br>
          <b>
          <?=LANG_content_autor ?>
    </b>&nbsp;<?php echo $_SESSION['CASO_AUTOR']; ?>     </div>  </td>

   <td width="320" align="right" valign="top"><div class="menutools">
   <table width="100%" border="0" cellspacing="1" cellpadding="1">
     <tr>
      <?php

	  include("menucont.php");


	  ?>

	  </tr>
   </table>
   </div>


   <p>&nbsp;</p></td>
</tr>
<tr>
	<td height="21" colspan="2" valign="top" style="background-color:#EEF0F0; color:#000000; border:#999999 solid 1px;"><br>
	 
	 
	 
	<?php if($datos->nreg==0){
	
	
	echo LANG_est_evalno;
	
	
	}else{
	
	
	?> 
	 
	<!-- grid que muestra data-->
	 
	  <table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
    <td colspan="5" class="td_whbk2"><table width="100%" border="0" cellspacing="1" cellpadding="2">
    <tr>
    <td width="40%" align="center" class="style3"><?=LANG_est_evaname ?></td>
    <td width="20%" align="center" class="style3"><?= LANG_eva_fechae ?></td>
    <td width="18%" align="center" class="style3"><?= LANG_eva_fechaf ?></td>
    <td width="15%" align="center" class="style3"><?= LANG_state ?></td>
    <td width="7%" align="center" class="style3"><?= LANG_eva_cal ?></td>
    </tr>
  
  
  <?php 
  
  while ($row = $datos->db_vector_nom($datos->result)) {
  
		  ///////link de inicio 
		  if($row['estatus']=="Aplicandose"){
		  
				$inicio = "<a href=\"examen3.php?eval_id={$row['id']}\" title=\"presione el viculo para comenzar la prueba\" target=\"_self\">".$row['nombre'] ."</a>";
				$NOTA = '-';
			
		  }else if($row['estatus']=="Realizada"){
		  
			  $nota2 = $notas->simple_db("select nota,id from tbl_evaluacion_estudiante where eval_id = {$row['id']} and est_id = '{$_SESSION['USER']}' ");
			 
				  if($nota2['nota']=='-1'){ $NOTA = 'Por corregir';  }else{
					
					$NOTA = $nota2['nota']; 
					
					//$NOTA ="<a href=\"javascript:popup('revision.php?id={$nota2['id']}','revisa','250','500')\" title=\"Ver revisi�n\">".$NOTA.'</a>';
				   
				   }
			   
			  $inicio = $row['nombre'];
		  
		  }else{
		  
				$inicio = $row['nombre'];
				$NOTA = '-';
			
		  }
  
  ?>
   <tr>
    <td bgcolor="#FFFFFF" class="style1" style="text-indent:4px;"><?=$inicio ?></td>
    <td align="center" bgcolor="#FFFFFF" class="style1"><?=$row['fecha'] ?></td>
    <td align="center" bgcolor="#FFFFFF" class="style1"><?=$row['fecha2'] ?></td>
    <td align="center" bgcolor="#FFFFFF" class="style1"><?=statuscolor($row['estatus']) ?></td>
    <td align="center" bgcolor="#FFFFFF" class="style1"><?=$NOTA ?></td>
   </tr>
  
 <?php 
  
  }  
  
  ?>
  
  
  </table></td>
    </tr>
    
  </table>	
    <br>
	
	
	<?php }  ?>
	<!-- grid que muestra data-->
	
	</td>
</tr>
</table>

</body>
</html>
<?php $datos->cerrar(); ?>