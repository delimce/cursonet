<?php session_start();
$profile = 'est'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php");
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

 $datos = new tools("db");
 
 $_SESSION['PROY_ID'] = $_REQUEST['idp'];


 $query = "	SELECT
`p`.`id`,
`p`.`nombre`,
ifnull((select concat(nombre,' ',apellido) from tbl_admin where id = p.autor),'".LANG_content_autor_unknow."') as autor,
date_format(`p`.`fecha_entrega`,'{$_SESSION['DB_FORMATO_DB']}'),
`p`.`enunciado`,
DATEDIFF(fecha_entrega,NOW()),
ifnull((select id from tbl_proyecto_estudiante where proy_id = {$_REQUEST['idp']} and est_id = {$_SESSION['USER']} limit 1),0)
FROM
`tbl_proyecto` AS `p`
WHERE
p.id = {$_REQUEST['idp']}

	";

	$pdata = $datos->array_query2($query);
	
		$archivos =	$datos->estructura_db("SELECT r.dir, r.descripcion, r.id,r.tipo FROM
								  tbl_proyecto_recurso p
								  INNER JOIN tbl_recurso r ON (p.rec_id = r.id)
								WHERE
								  p.proy_id = '{$_REQUEST['idp']}' ");
	
?>

<html>
<head>


<link rel="stylesheet" type="text/css" href="../../css/style_front.css">
<script language="JavaScript" type="text/javascript" src="../../js/ajax.js"></script>
<script language="JavaScript" type="text/javascript" src="../../js/utils.js"></script>

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
	 <!-- grid que muestra data-->
	 
	  <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="5" class="td_whbk2"><table width="100%" border="0" cellspacing="1" cellpadding="2">
        <tr>
          <td colspan="2" class="style3"><?=LANG_est_proydata ?></td>
        </tr>
        <tr>
          <td width="17%" bgcolor="#FFFFFF"><span class="style3">
            <?=LANG_name ?>
          </span></td>
          <td width="83%" bgcolor="#FFFFFF" class="style1"><?=$pdata[1] ?>          </td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF"><span class="style3">
            <?= LANG_est_cont_autor ?>
          </span></td>
          <td bgcolor="#FFFFFF" class="style1">
            <?=$pdata[2] ?>          </td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF"><span class="style3">
            <?= LANG_proy_date_e ?>
          </span></td>
          <td bgcolor="#FFFFFF" class="style1"><?=$pdata[3] ?></td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF"><span class="style3"><?= LANG_nota ?></span></td>
          <td bgcolor="#FFFFFF" class="style1"><?
		  
		  
		  if($pdata[6]==0){
		  
			  if($pdata[5]>=0){
			  ////se le suma 1 a los dias para que cuente el dia actual
			  $dias = $pdata[5]+1;
			  echo '<span class="alerta">'.LANG_est_proy_faltan." $dias ".LANG_est_proy_faltan2.'</span>';
			  
			  }else{
			  
			   echo '<span class="alerta">'.LANG_est_proy_tope.'</span>';
			  
			  }
			  
		 }	else {
		 
		 	  echo '<span class="relax">'.LANG_est_proy_uploadsu.'</span>';
		 
		 }  
		  
		  
		  ?></td>
        </tr>
        
        <tr>
          <td colspan="2" bgcolor="#FFFFFF"><?=$pdata[4] ?></td>
          </tr>
        <tr>
          <td bgcolor="#FFFFFF"><span class="style3">
            <?= LANG_fileattach ?>
          </span></td>
          <td valign="top" bgcolor="#FFFFFF" class="style1">
		  
		  <?php 
		  
		  if($datos->nreg==0){
		  
		  	echo LANG_est_proyfilesno;
		  
		  }else{
		  
				  for($i=0;$i<count($archivos);$i++){
				  
				  	
							if($archivos[$i]['tipo']==0){ ////muestra archivos
													 	
								 ?>
								 <a class="style3" tittle="<?=LANG_download ?>" target="_self" href="download.php?rec=<?php echo $archivos[$i]['id'] ?>"><?php echo $archivos[$i]['dir'] ?></a>&nbsp; <span class="linkmenu"><?=$archivos[$i]['descripcion'].'<p>'; ?></span>
								 
								 <? 
							 
							 }else{ ///muestra enlaces
							 	
								 ?>
								 <a class="style3" target="_blank" href="<?php echo $archivos[$i]['dir'] ?>"><?php echo $archivos[$i]['dir'] ?></a>&nbsp; <span class="linkmenu"><?=$archivos[$i]['descripcion'].'<p>'; ?></span>
								 
								 <? 

							 }
				  
				  
				  }
		  
		  }
		  
		  ?>		  </td>
        </tr>
      </table></td>
    </tr>
    
  </table>	
    <br>
    <!-- grid que muestra data-->	<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td><input type="button" name="Button" value="<?=LANG_back?>" onClick="location.replace('proy.php');">
		 <?php if($pdata[6]==0 && $pdata[5]>=0 ){ ?><input type="button" name="Button" value="<?=LANG_est_proy_upload?>" onClick="popup('proy_agregar.php', 'agrega','150','420');"><?php } ?></td>
      </tr>
    </table>
    <br></td>
</tr>
</table>

</body>
</html>
<?php $datos->cerrar(); ?>