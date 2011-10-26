<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);


 
 
  $tool = new tools();
  $tool->autoconexion();
  
 
	$planinfo = $tool->simple_db("select en_base from plan_evaluador where id = {$_REQUEST['id']} ");

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
		  p.plan_id = '{$_REQUEST['id']}' order by tipo,titulo";
  
  $iteninfo = $tool->estructura_db($query_item);
 
 
 

?>
<html>
<head>
		
	
	
<link rel="stylesheet" type="text/css" href="../../css/style_back.css">
</head>

   <BODY>

<table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="26" valign="top"><?php echo $menu->nombre; ?></td>
  </tr>
  <tr>
    <td><?php $menu->mostrar($_REQUEST['origen']); ?></td>
  </tr>
  <tr>
    <td>
	
	<table style="border-right:#000000 solid 1px; border-left:#000000 solid 1px; border-bottom:#000000 solid 1px;" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center"><br>&nbsp;<br>
          <table width="90%" border="0" cellpadding="2" cellspacing="2">
            <tr>
              <td width="96%" class="td_whbk2"><table width="100%" border="0" cellspacing="1" cellpadding="2">
                <tr>
                  <td width="56%" align="center" class="style3">Item evaluado</td>
                  <td width="15%" align="center" class="style3">Valor %</td>
                  <td width="11%" align="center" class="style3">Corregido</td>
                  <td width="18%" align="center" class="style3">Nota</td>
                  </tr>
                <?php  for($i=0;$i<count($iteninfo);$i++) { 
			
			include('calculo.php'); ///canculo de notas por estudiante
			
			?>
                <tr>
                  <td class="td_whbk"><b><?php echo $iteninfo[$i]['titulo']; ?></b></td>
                  <td align="center" class="td_whbk"><?php echo number_format($iteninfo[$i]['porcentaje'],1); ?>%</td>
                  <td align="center" class="td_whbk"><?php echo $corregido; ?></td>
                  <td align="right" class="td_whbk"><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="52%" align="right" style="color:<?php echo $color ?>; font-weight:bold" class="small"><? echo $nota; unset($nota); ?></td>
                      <td width="48%" align="right" class="small"><? echo $calc; unset($calc); ?></td>
                      </tr>
                    </table></td>
                  </tr>
                <?php } ?>
                <tr>
                  <td colspan="3" align="center" class="no_back">TOTAL ACUMULADO</td>
                  <td align="right" class="no_back"><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="52%" align="right"><span style="color:
								<?php $ttotal = ($ptotal*$planinfo)/100; if($ttotal>=($planinfo['en_base']/2)){ $color = "#000066"; }else{ $color = "#990000"; echo $color; } ?>; font-weight:bold" class="small">
                        <?   echo $ttotal;  ?>
                        </span></td>
                      <td width="48%" align="right"><span class="small"><? echo $ptotal.'%'; ?></span></td>
                      </tr>
                    </table></td>
                  </tr>
              </table></td>
              </tr>
            <tr>
              <td><br>
                <input type="button" name="button" id="button" value="<?php echo LANG_back ?>" onClick="history.back();">
                &nbsp;</td>
              </tr>
          </table>
          <br>&nbsp;</td>
      </tr>
    </table>	</td>
  </tr>
</table>
</body>
</html>
<?

	 $tool->cerrar();

?>
