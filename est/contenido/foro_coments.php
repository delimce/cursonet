<?php session_start();
$profile = 'est'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/tools.php");
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

		////si viene el id del foro
		if(!empty($_REQUEST['idf'])) $_SESSION['FORO_ID'] = $_REQUEST['idf'];

 $datos = new tools();
 $resp = new tools();
 $datos->autoconexion();
 
 ///objeto para las respuestas
 $resp->dbc = $datos->dbc;



 	$query = "

	SELECT titulo,content,date_format(fecha_post,'{$_SESSION['DB_FORMATO_DB']}') as fecha1,date_format(fecha_fin,'{$_SESSION['DB_FORMATO_DB']}') as fecha2,
	if(fecha_post <= NOW() and fecha_fin >= NOW(),0,1) as finalizo

	FROM   foro f

	WHERE

	f.id = '{$_SESSION['FORO_ID']}'


	";


	$principal = $datos->estructura_db($query);

?>

<html>
<meta http-equiv="Content-Type"  
content="text/html; charset=iso-8859-1"> 
<head>


<link rel="stylesheet" type="text/css" href="../../css/style_front.css">

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
	<td height="21" colspan="2" align="center" valign="top" style="background-color:#EEF0F0; color:#000000; border:#999999 solid 1px;">
	  <br>
	  <!-- grid que muestra data-->
	 
	  <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
    <td colspan="5" class="td_whbk2"><table width="100%" border="0" cellspacing="1" cellpadding="2">
    <tr>
    <td width="12%" bgcolor="#FFFFFF" align="left" class="style3" style="text-indent:4px;"><?= LANG_est_foroname ?></td>
    <td width="40%" bgcolor="#FFFFFF" class="style1" style="text-indent:4px;"><?php echo $principal[0]['titulo'] ?></td>
    <td width="12%" bgcolor="#FFFFFF" align="left" class="style3" style="text-indent:4px;"><?= LANG_est_foro_fechaini ?></td>
    <td width="23%" align="center" bgcolor="#FFFFFF" class="style1" style="text-indent:4px;">
      <?=$principal[0]['fecha1'] ?>
    -
    <?=$principal[0]['fecha2'] ?>    </td>
    </tr>
  
   <tr>
    <td colspan="4" bgcolor="#FFFFFF" class="no_back" style="text-indent:4px;"><span class="style1"><?=$principal[0]['content']; ?></span></td>
    </tr>
   <tr>
     <td bgcolor="#FFFFFF" class="style3" style="text-indent:4px;"><span class="style1" style="text-indent:4px;">
       <?= LANG_est_foro_status ?>
     </span></td>
     <td colspan="3" bgcolor="#FFFFFF" class="style1" style="text-indent:4px;"><b>
	 
	 <?php 
	 
	 if($principal[0]['finalizo']==0){
	 
	 	echo LANG_is_active;
	 
	 
	 }else{
	 
	 	echo LANG_is_noactive;
	 
	 }
	 
	 
	 ?>
	 </b>
	 </td>
     </tr>

  
  
  </table></td>
    </tr>
  </table>	
  
  
  
      <br>
      <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td><input type="button" name="Button2" value="<?=LANG_back?>" onClick="location.replace('foro.php');">
              <?php if($principal[0]['finalizo']==0){ ?>
            <input type="button" name="Button2" value="<?=LANG_est_foro_new?>" onClick="popup('foro_agregar.php', 'agrega','195','620');">
            &nbsp;
            <input name="Button3" type="button" class="td_whbk3" onClick="location.replace('<?=$PHP_SELF?>');" value="<?=LANG_refresh?>">
            <?php } ?></td>
        </tr>
      </table>
      <?php

   
		$query2 = "SELECT 
				  c.content, c.id,
				  if(c.tipo_sujeto = 'admin',(select concat('<b>".LANG_ADMIN_teacher."</b> ',nombre, ' ', apellido) from tbl_admin where id = c.sujeto_id),(select concat('<b>".LANG_est."</b> ',nombre, ' ', apellido) from estudiante where id = c.sujeto_id)) AS sujeto,
				  if(c.tipo_sujeto = 'admin',(select foto from tbl_admin where id = c.sujeto_id),(select foto from estudiante where id = c.sujeto_id)) AS foto, c.tipo_sujeto as tsujeto,
				  date_format(c.fecha_post,'{$_SESSION['DB_FORMATO_DB']} %h:%i %p') as fecha_post, if(c.valido = 0,'<img style=\"vertical-align:bottom\" src=\"../../images/backend/x.gif\" title=\"".LANG_foro_status_nv."\">','<img style=\"vertical-align:bottom\" src=\"../../images/backend/checkmark.gif\" title=\"".LANG_foro_status_v."\">') as valido,
				  (select count(*) from foro_respuesta where com_id = c.id) as nresp
				  FROM 
				  foro f
				  INNER JOIN foro_comentario c ON (f.id = c.foro_id) where f.id = '{$_SESSION['FORO_ID']}' 
				  
				  order by id desc";
   
   $datos->query($query2);
   
   if($datos->nreg==0){
	
	
	echo '<br><span class="style3">'.LANG_foro_nocomments.'</span><br>';
		
	}else{
	
	
		while ($row = mysql_fetch_assoc($datos->result)){
		
	?>
        <br>
      
      <table class="style1" width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
      <td class="td_whbk2"><table width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
      <td  width="63%" bgcolor="#FFFFFF" class="style1"><b><?=LANG_name ?>:</b> <?=$row['sujeto'] ?></td>
      <td width="37%" bgcolor="#FFFFFF" class="style1"><b><?=LANG_date ?>:</b> <?=$row['fecha_post'] ?></td>
      </tr>
      <tr>
      <td colspan="3" bgcolor="#FFFFFF" class="no_back">
      
       	<!--foto-->
			
			 <?php if(empty($row['foto'])){ $link = '../../images/frontend/nofoto.png'; 
	   }else{
	   
	  if($row['tsujeto']=="admin") $dir = 'admin'; else $dir = 'est';  
	  $link = "../../recursos/$dir/fotos/".$row['foto']; } 
	  
	  ?>
                <img style="border:solid 1px" hspace="7" vspace="7" align="left" src="<?=$link ?>">
			<!--fin foto-->
            
      <span class="style1"><?=html_entity_decode($row['content']); ?></span>
      
     <?php if($row['nresp']>0){ 
	 
	 echo '<p>';
	 
	 $respuestas = $resp->estructura_db("
		
							   SELECT DISTINCT 
							   r.content,
							   (select concat('".LANG_msg_prefa." ',nombre, ' ', apellido) from tbl_admin where id = r.prof_id) as sujeto,
							   date_format(r.fecha,'{$_SESSION['DB_FORMATO_DB']} %h:%i %p') as fecha				 
							  FROM
							  foro_respuesta r 	WHERE
							  r.com_id = '{$row['id']}'");
	 
		 
			 foreach($respuestas as $ii => $valor){
			 
				echo '<br><b>';
				echo LANG_est_foro_respto.' '.$respuestas[$ii]['sujeto'].' '.LANG_foro_publicado.' '.$respuestas[$ii]['fecha'];
				echo '<br></b>';
				echo '<span class="style4">';
				echo $respuestas[$ii]['content'];
				echo '</span>';
				echo '<br>';
				
						 
			 
			 }
	 
	 
	  } ?>	
        
        </td>
      <!-- post de respuesta --->
      
      
       <!-- post de respuesta --->
      </tr>

      <tr>
      <td colspan="2" bgcolor="#FFFFFF" class="style1"><? echo LANG_est_foro_comrev; echo ' '; echo $row['valido']; ?></td>
      </tr>
    </table></td>
      </tr>
    </table>
    
	
	
      
      
	    <?php 
		
		} ////fin while
		
		}  ?>
	    <!-- grid que muestra data--><br>
      <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
      <td>
      <input type="button" name="Button" value="<?=LANG_back?>" onClick="location.replace('foro.php');">
      <?php if($principal[0]['finalizo']==0){ ?><input type="button" name="Button" value="<?=LANG_est_foro_new?>" onClick="popup('foro_agregar.php', 'agrega','195','620');">
&nbsp;
<input name="Button4" type="button" class="td_whbk3" onClick="window.location.href='<?=$PHP_SELF?>';" value="<?=LANG_refresh?>">
&nbsp;<?php } ?></td>
      </tr>
    </table>      
    <br></td>
</tr>

</table>

</body>
</html>
<?php $datos->cerrar(); ?>