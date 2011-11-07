<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../config/setup.php"); ////////setup
include("../../../class/clases.php"); ////////clase
include ("../../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);

 if(isset($_REQUEST['id'])) $_SESSION['EVAL_REV'] = $_REQUEST['id'];

 $prueba = new tools('db');
 

  /////////////////////////guarda o consulta

 if(isset($_POST['nota'])){


        $campos[0] = "correccion"; $campos[1] = "nota";
		$vector[0] = $_POST['revi']; $vector[1] = $_POST['nota'];
 		$prueba->update("tbl_evaluacion_estudiante",$campos,$vector,"id = '{$_SESSION['EVAL_REV']}'");
  	    
		
		//////////////////acompanamiento de pruebas
		include("acomp.php");
			
		//////////////////////////////////////////
		
		unset($_SESSION['EVAL_REV']);
		$prueba->cerrar();
		$prueba->javaviso(LANG_eva_finish,"pruebas.php");


 }else{
	 
	 
	   $queryd = "SELECT 
		  concat(est.nombre, ' ', est.apellido) AS nombre,
		  eva.correccion,
		  if(eva.nota = '-1', '', eva.nota) AS nota,
		  e.tipo,
		  e.nombre,
		  e.id,
		  eva.est_id,
		  e.npreg
		FROM
		  tbl_evaluacion e
		  INNER JOIN tbl_evaluacion_estudiante eva ON (e.id = eva.eval_id)
		  INNER JOIN tbl_estudiante est ON (eva.est_id = est.id) and eva.id = '{$_SESSION['EVAL_REV']}' ";
		
		$datos = $prueba->array_query2($queryd); ////query para los datos
		
		
		if($datos[3]==2){ ////traigo respuestas de desarrollo
		
			$query1 = "SELECT distinct
						  r.preg_id,
						  r.respuesta
						FROM
						  tbl_evaluacion_pregunta p
						  INNER JOIN tbl_evaluacion_respuesta r ON (p.id = r.preg_id)
						WHERE
						  p.eval_id = $datos[5] and est_id = $datos[6] order by r.preg_id";
		  
		}else{ ////traigo el numero de preguntas buenas de una evaluacion / numero total de preguntas
		
		
			 $query1 = "    SELECT
						    (select count(*)
							FROM
							tbl_evaluacion_pregunta AS e
							Inner Join tbl_evaluacion_respuesta_s AS r ON e.id = r.preg_id
							Inner Join tbl_pregunta_opcion AS o ON e.id = o.preg_id
							where o.correcta = 1 and eval_id = $datos[5] and (o.id = r.resp_opc) and r.est_id = $datos[6] ) as buenas,						 
			  			   (select count(*) from tbl_evaluacion_pregunta where eval_id = $datos[5] ) as total ";
		
		
		}
	 
 }

?>
<html>
<head>

<script language="JavaScript" type="text/javascript">
	function validar(){

		 if( isNaN(document.form1.nota.value)|| document.form1.nota.value < 0  ){

		 alert('<?=LANG_eva_cal_value ?>');
		 document.form1.nota.focus();

		 return false;

		 }else{

		 document.form1.submit();

		 }

	 }

 </script>

<script type="text/javascript" src="../../../js/utils.js"></script>
<link rel="stylesheet" type="text/css" href="../../../css/style_back.css">
</head>

<body>

<form name="form1" method="POST" action="corregir.php">

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
        <td align="left"><table width="100%" border="0" cellspacing="4" cellpadding="3">
          <tr>
            <td colspan="4" class="style1"><b><?=LANG_est ?>
              &nbsp;</b><?=$datos[0] ?></td>
            </tr>

		
        <?php if($datos[3]==2){ ////traigo respuestas de desarrollo ?>
        
          <?php
		  $i=1;
		  
		  $prueba->query($query1);
		  while ($row = $prueba->db_vector_nom()) {
		  ?>
          <tr>
            <td colspan="4" class="table_bk"><? echo LANG_eva_resp;?>&nbsp;<a title="<?=LANG_eva_enum ?>" href="#" style="color:#000000" onClick="popup('enunciado.php?id=<?=$row['preg_id']?>', 'enumpregunta','160','600')"><? echo LANG_eva_question; echo $i?></a></td>
          </tr>
          <tr>
            <td colspan="4" align="center"><textarea name="textarea" cols="93" rows="4" class="style1"><?=stripslashes($row['respuesta']); ?></textarea></td>
          </tr>
		  <?php

          $i++;
		  }

		  ?>
          
          
         <?php }else{ 
		 
		 $res = $prueba->simple_db($query1);
		 
		 ////traigo preguntas de selección ?> 
          
           <tr>
            <td colspan="4" class="table_bk"><? echo LANG_eva_evalinfo;?>&nbsp;<a title="<?=LANG_eva_enum ?>" href="#" style="color:#000000" onClick="popup('../../actividades/evaluacion/sel/prueba.php?id=<?php echo $datos[5]; ?>', 'exam','600','500')"><? echo $datos[4] ?></a></td>
          </tr>
          <tr>
            <td colspan="4" align="left"><?php echo LANG_eva_resultest.' '.$res['buenas'].'/'.$datos[7] //npreg de la evaluacion no el total //$res['total'] ?>&nbsp;<img src="../../../images/common/eval.gif" title="<?php echo LANG_eva_viewresult ?>" style="cursor:pointer" onClick="window.location.href('ver.php');" width="24" height="24"></td>
          </tr>
          
          
          <?php } ?>
		  <tr>
            <td colspan="4" align="left" class="td_whbk2"><b>
              <?=LANG_eva_revi ?>
            </b></td>
          </tr>
		  <tr>
		    <td colspan="4" align="center"><textarea name="revi" cols="93" rows="4" class="style1" id="revi"><?=stripslashes($datos[1]); ?>
		    </textarea></td>
		    </tr>
		  <tr>
		    <td width="9%" align="left" class="td_whbk2"><b>
		      <?=LANG_eva_cal ?>
		    </b></td>
		    <td width="91%" colspan="3" align="left" class="td_whbk2"><input name="nota" type="text" id="nota" value="<?php echo $datos[2]?>" size="5" maxlength="3"></td>
		    </tr>
		  <tr>
		    <td colspan="4" align="left"><input name="b1" type="button" id="b1" onClick="javascript:location.replace('pruebas.php');"  value="<?=LANG_back?>">
              <input name="guarda" type="button" id="guarda" onClick="javascript:validar();" value="<?=LANG_save?>"></td>
		    </tr>

        </table>
          <br></td>
      </tr>
    </table>	</td>
  </tr>
</table>

</form>

</body>
</html>
<?php $prueba->cerrar(); ?>