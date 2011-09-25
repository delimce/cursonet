<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/tools.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);

			$toolitem = new tools();
			$toolest  = new tools();
			
			$toolitem->autoconexion();
			$toolest->dbc  = $toolitem->dbc;
			
			
			$planinfo = $toolest->simple_db("select titulo,en_base,redondeo from plan_evaluador where id = {$_REQUEST['id']} ");

			$query_item = "SELECT DISTINCT 
		  p.id,
		  p.titulo,
		  p.tipo,
		  p.id_act,
		  p.porcentaje,
		  p.en_base
		FROM
		  plan_item p
		WHERE
		  p.plan_id = '{$_REQUEST['id']}' order by id";
  
  $iteninfo = $toolest->estructura_db($query_item);
  
		  $query_est = "SELECT DISTINCT 
		  LOWER(concat(e.apellido, ' ', e.nombre)) AS nombre,
		  e.id
		FROM
		  plan_evaluador p
		  INNER JOIN grupo_estudiante ge ON (p.grupo_id = ge.grupo_id)
		  INNER JOIN estudiante e ON (ge.est_id = e.id)
		WHERE
		  p.id = '{$_REQUEST['id']}' order by nombre";
		  
		  $toolest->query($query_est);
		  
		  $APRO=0; $APLA=0;

?>
<html>
<head>
<title><?php echo LANG_planes_evalsheet.' '.$planinfo['titulo'] ?></title>
<link rel="stylesheet" type="text/css" href="../../css/style_back.css">
<script type="text/javascript" src="../../js/ajax.js"></script>
<script type="text/javascript" src="../../js/utils.js"></script>
</head>

<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td class="td_whbk2"><span class="style1"><?php echo LANG_planes_evalsheet.' '.$planinfo['titulo'] ?></span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="table_bk"><table width="100%" border="0" align="center" cellpadding="2" cellspacing="1">
      <tr>
        <td width="25%" align="center" class="table_bk">&nbsp;<b><?php echo LANG_student ?></b></td>
        					
                           <?php 
							 
							    for($i=0;$i<count($iteninfo);$i++) {
								
									?>
										<td width="11%" align="center" class="table_bk"><b><?php echo $iteninfo[$i]['titulo']; ?></b></td>
								   <?php 
				   
								  } 
								   
								 ?> 
                            
        <td width="61%" align="center" class="table_bk"><b><?php echo LANG_planes_total ?></b></td>
      </tr>
      <?php 
				$w=0;
				while ($est = mysql_fetch_assoc($toolest->result)) {
				
				if(is_int($w/2)) $colorf = "#FFFFFF";  else $colorf = "#EAFAFF";
				
				?>
      <tr  bgcolor="<?php echo $colorf ?>">
        <td class="style1" style="cursor:pointer" title="ver detalles de <?php echo $est['nombre'] ?>" onClick="popup('../alumnos/detalles.php?id=<?php echo $est['id'] ?>','est','768','800');""><?php echo $est['nombre']; ?></td>
        					
                            
                            
                            <?php 
							 
							    for($i=0;$i<count($iteninfo);$i++) {
								
										
										include('calculo.php');
																		
										?>
											<td align="center" class="style1"><table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
                                              <tr>
                                                <td width="52%" align="right" style="color:<?php echo $color ?>; font-weight:bold" class="small"><? echo $nota; unset($nota); ?></td>
                                                <td width="48%" align="center" class="small"><? echo $calc; unset($calc); ?></td>
                                              </tr>
                                            </table></td>
							           <?php 
				   
								  } 
								   
								 ?> 
                            
                            
        					<td align="center"><table width="70" border="0" align="right" cellpadding="0" cellspacing="0">
                              <tr>
                              <td align="right">
                                <span style="color:
								<?php $ttotal = ($ptotal*$planinfo['en_base'])/100; if($ttotal>=($planinfo['en_base']/2)){ $color = "#000066"; $APRO++; }else{ $color = "#990000"; echo $color;  $APLA++;} ?>; font-weight:bold" class="small">
								<?   if($planinfo['redondeo']==0) echo $ttotal; else echo round($ttotal);  $tfinal+= $ttotal; unset($ttotal);  ?>
                                </span><span class="small"><? echo $ptotal.'%'; unset($ptotal); ?></span></td>
                              </tr>
                            </table>        					  </td>
        
       
      </tr>
      <?php 
				$w++;   
				  } 
				   
				   ?>
    </table></td>
  </tr>
</table>
<br>
<table width="30%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2" class="table_bk">Resultados de las evaluaciones del Grupo</td>
  </tr>
  <tr>
    <td width="78%">&nbsp;</td>
    <td width="22%">&nbsp;</td>
  </tr>
  <tr>
    <td class="style3">N&ordm; estudiantes Aplazados</td>
    <td align="right" style="color:#990000" class="style3"><?php echo $APLA; ?></td>
  </tr>
  <tr>
    <td class="style3">N&ordm; estudiantes Aprobados</td>
    <td align="right" style="color:#000066" class="style3"><?php echo $APRO; ?></td>
  </tr>
  <tr>
    <td class="style3">Nota Promedio del grupo</td>
    <td align="right" class="style3"><?php echo bcdiv($tfinal,$APLA+$APRO,2); ?></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php $toolitem->cerrar();  ?>
