<?php session_start();
$profile = 'est'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php");
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

$datos = new tools("db");

$query = "SELECT
  r.id,
  r.dir,
  r.descripcion,
  r.fuente
from tbl_recurso r
     inner join tbl_contenido_recurso c on (r.id = c.recurso_id)
where (r.tipo = 2 and c.contenido_id = {$_SESSION['CASOACTUAL']})";


$datos->query($query);


?>

<html>
<head> <meta charset="utf-8">
<script language="JavaScript" type="text/javascript" src="../../js/ajax.js"></script>
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
	<td height="21" colspan="2" valign="top" class="content-est-tools">
	 <div id="index2">&nbsp;
	   <table width="100%" border="0" cellspacing="2" cellpadding="2">
         <tr>
           <td colspan="2"><b>
             <?= LANG_est_dlink ?>
           </b></td>
          </tr>
         <tr>
           <td class="style3"><? if($datos->nreg==0) echo LANG_content_novideos ?></td>
         </tr>

		 <?php

		 while ($row = $datos->db_vector_nom($datos->result)) {

		 	
		 	if($row['fuente'] == "youtube"){

			$VIDEO =	'<object width="425" height="350">
				 <param name="movie" value="'.$row['dir'].'">
				 </param>
				 <param name="wmode" value="transparent">
				 </param>
				 <embed src="'.$row['dir'].'"
				 type="application/x-shockwave-flash" wmode="transparent"
				 width="425" height="350">
				 </embed>
				</object>';

		 	}

		  ?>

         <tr>
           <td>
           <? echo $VIDEO; ?>
           <br> <span class="linkmenu"><?=$row['descripcion']?></span></td>
          </tr>

		 <?php

		 }

		  ?>

         <tr>
           <td>&nbsp;</td>
         </tr>
       </table>
	 </div>
	</td>
</tr>
</table>

</body>
</html>
<?php $datos->cerrar(); ?>