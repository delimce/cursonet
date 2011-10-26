<?php session_start();
$profile = 'est'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php");
include("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje
$tool = new tools('db');

$planinfo = $tool->simple_db("select en_base,redondeo from plan_evaluador where id = {$_REQUEST['id']} ");

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
  
  $iteninfo = $tool->estructura_db($query_item);


?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../../css/style_front.css">
</head>
<body>
<table width="100%" border="0" cellspacing="6" cellpadding="2">
  <tr>
    <td width="56%" align="center" style="border: #9AB1B6 1px solid;"><table width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="welcome"><?= LANG_est_cal_main ?>        </td>
      </tr>
      <tr>
        <td height="2"><hr color="#9AB1B6" size="1px"></td>
      </tr>
      <tr>
        <td height="2"><br></td>
      </tr>
      <tr>
        <td width="94%" height="2" class="td_whbk2"><table width="100%" border="0" cellspacing="1" cellpadding="2">
          <tr>
            <td width="42%" align="center" class="style3">Item evaluado</td>
            <td width="6%" align="center" class="style3">Valor %</td>
            <td width="6%" align="center" class="style3">Corregido</td>
            <td width="9%" align="center" class="style3">Nota</td>
            <td width="37%" align="center" class="style3"><?php echo LANG_est_retro ?></td>
            </tr>
          <?php  for($i=0;$i<count($iteninfo);$i++) { 
			
			include('calculo.php');
			
			?>
          <tr>
            <td class="td_whbk"><b><?php echo $iteninfo[$i]['titulo']; ?></b></td>
            <td align="center" class="td_whbk"><?php echo number_format($iteninfo[$i]['porcentaje'],1); ?>%</td>
            <td align="center" class="td_whbk"><?php echo $corregido; ?></td>
            <td align="right" class="td_whbk">
              <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="52%" align="right" style="color:<?php echo $color ?>; font-weight:bold" class="small"><? echo $nota; unset($nota); ?></td>
                  <td width="48%" align="right" class="small"><? echo $calc; unset($calc); ?></td>
                  </tr>
                </table></td>
            <td align="left" class="td_whbk"><?php echo $com; unset($com); ?></td>
            </tr>
          <?php } ?>
          <tr>
            <td colspan="3" align="center" class="no_back">TOTAL ACUMULADO</td>
            <td align="right" class="no_back">
              
              <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="52%" align="right">
                    <span style="color:
								<?php $ttotal = ($ptotal*$planinfo['en_base'])/100; if($ttotal>=($planinfo['en_base']/2)){ $color = "#000066"; }else{ $color = "#990000"; echo $color; } ?>; font-weight:bold" class="small">
                      <?    if($planinfo['redondeo']==0) echo $ttotal; else echo round($ttotal); ?>
                      </span></td>
                  <td width="48%" align="right"><span class="small"><? echo $ptotal.'%'; ?></span></td>
                  </tr>
                </table>              </td>
            <td width="37%" align="right" class="no_back">&nbsp;</td>
            </tr>
        </table></td>
        </tr>
      <tr>
        <td><p class="style3">&nbsp; </p>
            <p class="style3">
              <input type="button" name="b1"  value="<?=LANG_back?>" onClick="history.back();">
            </p>
          <p></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr> 
   </table>
</body>
</html>
<?

$tool->cerrar();

?>