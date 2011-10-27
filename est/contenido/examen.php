<?php session_start();
$profile = 'est'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php");
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

 $datos = new tools("db");
 
 $datosp = $datos->simple_db("SELECT 
  e.nombre,
  date_format(DATE_ADD(e.fecha, INTERVAL e.duracion MINUTE),'%h:%i %p') as fecha,
  date_format(DATE_ADD(e.fecha, INTERVAL e.duracion MINUTE),'%h') as hora,
  date_format(DATE_ADD(e.fecha, INTERVAL e.duracion MINUTE),'%i') as minu,
  date_format(DATE_ADD(e.fecha, INTERVAL e.duracion MINUTE),'%p') as mer,
  
  e.duracion
FROM
  `tbl_evaluacion` e
WHERE
  (e.id = {$_REQUEST['idp']})");
  
  
  $datos->query("SELECT e.id,e.pregunta as preg FROM `tbl_evaluacion_pregunta` e WHERE  (e.eval_id = {$_REQUEST['idp']} ) order by id");
  

?>

<html>
<head>

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
	 
	 
	 
	<!-- grid que muestra data-->
	 
	  <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
    <td colspan="5" class="td_whbk2"><table width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <td width="16%" class="td_whbk"><?php echo LANG_eva_name; ?></td>
        <td width="84%" class="td_whbk"><span class="style3"><?php echo $datosp['nombre']; ?></span></td>
      </tr>
      <tr>
        <td class="td_whbk"><?php echo LANG_eva_hourend; ?></td>
        <td class="td_whbk"><span class="style3"><?php echo $datosp['fecha'].' ('.$datosp['duracion'].' '.LANG_minutes.')'; ?></span></td>
      </tr>
      <tr>
        <td class="td_whbk"><?php echo LANG_eva_trans; ?></td>
        <td class="td_whbk">
		<span class="style3" id="reloj"></span>
		<script  language="javascript"  type="text/javascript">
		/* Visit http://www.yaldex.com/ for full source code
		and get more free JavaScript, CSS and DHTML scripts! */
		<!-- Begin
		function clock() {
		var digital = new Date();
		var hours = digital.getHours();
		var minutes = digital.getMinutes();
		var seconds = digital.getSeconds();
		var amOrPm = "AM";
		if (hours > 11) amOrPm = "PM";
		if (hours > 12) hours = hours - 12;
		if (hours == 0) hours = 12;
		if (minutes <= 9) minutes = "0" + minutes;
		if (seconds <= 9) seconds = "0" + seconds;
		dispTime = hours + ":" + minutes + ":" + seconds + " " + amOrPm+'';
		document.getElementById('reloj').innerHTML = dispTime;
		setTimeout("clock()", 1000);
		document.form1.tiempo.value = dispTime;
		if(hours==Number(<?php echo $datosp['hora']; ?>) && minutes==Number(<?php echo $datosp['minu']; ?>) && amOrPm=='<?php echo $datosp['mer']; ?>' ){
		
		document.form1.submit();
		
		}
		
		
		}
		window.onload=clock;
		//  End -->
		</script>		</td>
      </tr>
      
    </table></td>
    </tr>
    
  </table>	
      <br>
	  
	  <form action="terminar.php" method="post" name="form1" target="_self">
     
	   <?php 
		  
		  $i = 1;
		  
		  while ($row = mysql_fetch_assoc($datos->result)) {
	
		  ?>
	 
	 
	  <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="5" class="td_whbk2">
		
		  <table width="100%" border="0" cellspacing="1" cellpadding="2">
              <tr>
                <td class="td_whbk"><span class="style3"><?php echo $i.' '.$row["preg"]; ?></span></td>
              </tr>
              <tr>
                <td class="td_whbk"><textarea name="preg_<?php echo $row["id"]?>" cols="165" rows="5" class="style1"></textarea></td>
              </tr>
          </table>
		  
		  </td>
        </tr>
      </table>
	   <br>
	  
	    <?php 
		
		$i++;
		  
		  	}
		  
		  ?>
	  
	  
	   <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="5"><input name="b1" type="submit" id="b1" value="<?php echo LANG_est_evasend ?>">
            <input name="b2" type="reset" id="b2" value="Reset"></td>
        </tr>
      </table>
	  <br>
	  <input name="eval_id" type="hidden" value="<?php echo $_REQUEST['idp']; ?>">
	  <input name="tiempo" type="hidden" value="">
	  
	  </form>
	  
	  
     
	
	
	
	</td>
</tr>
</table>


</body>
</html>
<?php $datos->cerrar(); ?>