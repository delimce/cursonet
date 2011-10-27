<?php session_start();
$profile = 'est'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php");
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

 $datos = new formulario('db');

if(isset($_GET['id'])){
	
	$ide = $datos->getvar("id",$_GET);

 
 $datos->abrir_transaccion();
 
	 /////revisar.
	 $datos->query("update tbl_contenido set leido = leido+1 where id = $ide "); 
	 /////////////
	 $caso = $datos->simple_db("select contenido from tbl_contenido c where id = $ide ");

	 	if(empty($_SESSION['CONTARCONT'])){
	
			   $datos->query("update tbl_log_est set ncontenidos = ncontenidos+1 where id = {$_SESSION['EST_ACTUAL']} ");
			   ///////////se agrega el contenido a la lista de contenidos visitados (solo se cuenta 1 vez por sesion)
			   $datos->query("update tbl_log_est set contenidos = concat(contenidos,',',$ide) where id = {$_SESSION['EST_ACTUAL']} ");
			   
			   $_SESSION['CONTARCONT'] = 1; ///PARA ASEGURARME QUE CUENTE SOLO UNA VEZ POR SESION PARA LOS INDICADORES
	 
		}
	 
 
 $datos->cerrar_transaccion();
 
}

?>

<html>
<head>


<link rel="stylesheet" type="text/css" href="../../css/style_front.css">
<script type="text/javascript" src="../../js/utils.js"></script>
<script type="text/javascript" src="../../js/swfobject_modified.js"></script>
<script language="JavaScript" type="text/javascript" src="../../js/dynifs.js"></script>



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
	 <div id="index2" style="margin-right:20; margin-left:15; top:12;"><?php echo $caso; ?></div>
	</td>
</tr>
</table>

</body>
</html>
<?php $datos->cerrar(); ?>