<?php session_start();
$profile = 'est'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php");
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje
unset($_SESSION['FORO_ID']);

 $datos = new tools("db");


 	$query = "

	SELECT f.id,titulo,date_format(fecha_post,'{$_SESSION['DB_FORMATO_DB']}') as fecha1,date_format(fecha_fin,'{$_SESSION['DB_FORMATO_DB']}') as fecha2,resumen,nota,(select count(*) from tbl_foro_comentario where foro_id = f.id) as comentarios

	FROM   tbl_foro f

	WHERE

	(contenido_id= {$_SESSION['CASOACTUAL']} ) AND ((grupo_id in ({$_SESSION['GRUPOSID']})) OR ((grupo_id=0)))


	";


	$datos->query($query);

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
	<td height="21" colspan="2" valign="top" style="background-color:#EEF0F0; color:#000000; border:#999999 solid 1px;">
	  <br> 
	<?php if($datos->nreg==0){
	
	
	echo LANG_est_forono;
	
	
	}else{
	
	
	?> 
	 
	<!-- grid que muestra data-->
	 
	  <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
    <td colspan="5" class="td_whbk2"><table width="100%" border="0" cellspacing="1" cellpadding="2">
    <tr>
    <td width="45%" align="center" class="style3"><?= LANG_est_foroname ?></td>
    <td width="16%" align="center" class="style3"><?= LANG_est_foro_fechaini ?></td>
    <td width="14%" align="center" class="style3"><?= LANG_est_foro_fechafin ?></td>
    <td width="10%" align="center" class="style3"><?= LANG_eva_cal ?>%</td>
    <td width="15%" align="center" class="style3"><?= LANG_est_foro_ncom ?></td>
  </tr>
  
  
  <?php 
  
  while ($row = mysql_fetch_assoc($datos->result)) {
  
  ?>
   <tr>
    <td bgcolor="#FFFFFF" class="style1" style="text-indent:4px;" title="<?=$row['resumen'] ?>"><a href="foro_coments.php?idf=<?=$row['id'] ?>"> <?=$row['titulo'] ?></a></td>
    <td bgcolor="#FFFFFF" class="style1" align="center"><?=$row['fecha1'] ?></td>
    <td bgcolor="#FFFFFF" class="style1" align="center"><?=$row['fecha2'] ?></td>
    <td bgcolor="#FFFFFF" class="style1" align="center"><?=$row['nota'] ?></td>
    <td bgcolor="#FFFFFF" class="style1" align="center"><?=$row['comentarios'] ?></td>
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