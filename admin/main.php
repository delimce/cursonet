<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../config/setup.php"); ////////setup
include("../class/clases.php");
include ("../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje
 
 $datos = new tools('db');

 if(isset($_REQUEST['curso'])){

	 $_SESSION['CURSOID'] = $_REQUEST['curso']; ////setea el curso por el seleccionado

 }
 
  	 $data = $datos->simple_db("select c.id,c.nombre,c.alias,date_format(fecha_creado,'{$_SESSION['DB_FORMATO_DB']}') as fechac,
					 (select concat(nombre,' ',apellido) from tbl_admin where id = c.resp) as creador,
					 (select count(*) from tbl_mensaje_admin where para = '{$_SESSION['USERID']}' and leido = 0 ) as sinleer
					  from tbl_curso c
			  		  where  id = '{$_SESSION['CURSOID']}' ");
  	 
	 $_SESSION['CURSOALIAS'] = $data['alias'];


?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../css/style_back.css">
<script language="JavaScript" type="text/javascript" src="../js/utils.js"></script>
</head>
   <body bottommargin="0">
   <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
     <tr>
       <td colspan="2" align="left"><p class="style1"><b class="style3">Curso actual:&nbsp;</b><span class="style1"><?php echo $data['nombre'] ?></span></p>         </td>
     </tr>
     <tr>
       <td height="13" align="left"><span class="small"><b class="style3">Creado el:</b>&nbsp;<?php echo $data['fechac'] ?></span></td>
       <td width="47%" rowspan="7"><img src="../images/backend/main.jpg" width="455" height="426" GALLERYIMG="no"></td>
     </tr>
     <tr>
       <td height="13" align="left"><b class="style3">Creado por:</b>&nbsp;<span class="small"><?php echo $data['creador'] ?></span></td>
     </tr>
       <tr>
       <td height="13"><h>
         ____________________________</td>
     </tr>
     <tr>
       <td height="13">&nbsp;</td>
     </tr>
     <tr>
       <td height="13"><a href="javascript:popup('settings/detallec2.php?id=<?php echo $_SESSION['CURSOID'] ?>', 'detalle','600','600')">Ver mas detalles</a></td>
     </tr>
     <tr>
       <td height="213" valign="bottom">
       
       <?php if($data['sinleer']>0){ ?>
       <table width="100%" border="0" cellspacing="2" cellpadding="2">
         <tr>
           <td width="98%" style="text-decoration:blink" class="large"><strong class="no_back">Ud Posee <?php echo $data['sinleer'] ?> mensajes Nuevos sin leer</strong></td>
           <td width="2%" class="large"><img src="../images/backend/mens2.gif" width="32" height="32"></td>
         </tr>
         <tr>
           <td colspan="2"><a href="mensajes/index.php" class="style3" style="color:#0000FF">Ir a la bandeja de entrada</a></td>
         </tr>
         <tr>
           <td colspan="2">&nbsp;</td>
         </tr>
       </table>
       <?php } ?>
       
       </td>
     </tr>
   </table>
</body>
</html>
<?php $datos->cerrar(); ?>