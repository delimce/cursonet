<?php session_start();
$profile = 'est'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/tools.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje


 $ver = new tools();
 $ver->autoconexion();
 
  $query = "select id,subject as titulo,
  IF(tipo=1,(select concat('".LANG_msg_prefa."',nombre,' ',apellido) from tbl_admin where id = de ),(select concat('".LANG_msg_prefs."',nombre,' ',apellido) from estudiante where id = de )) as Remite,
  IF(tipo=0,(select foto from estudiante where id = de ),(select foto from tbl_admin where id = de )) as foto
  ,date_format(fecha,'".$_SESSION['DB_FORMATO_DB']."') as fecha,leido,content,urgencia,tipo,de from mensaje_est where id = '{$_GET['id']}'";

$datos = $ver->simple_db($query);

?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="../../css/style_front.css">
</head>

<body>

<table width="100%" border="0" cellspacing="6" cellpadding="2">
  <tr>
    <td width="56%" align="center" style="border: #9AB1B6 1px solid;">
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
      <td colspan="2" class="welcome">
        <?= LANG_est_mens_h_read ?>      </td>
    </tr>
      <tr>
      <td height="2" colspan="2"><hr color="#9AB1B6" size="1px"></td>
    </tr>
      <tr>
      <td height="2" colspan="2">
      
      
    <!-- data aqui -->  
      
	
	<table width="100%" border="0" cellspacing="2" cellpadding="1">
      <tr>
        <td>&nbsp;
          <table width="100%" border="0" cellspacing="4" cellpadding="3">
            <tr>
              <td colspan="2" rowspan="4" align="center" valign="middle" class="style3">
			  <?php if(empty($datos['foto'])){ $link = '../../images/frontend/nofoto.png'; 
	   }else{
	   
	  if($datos['tipo']=="1") $dir = 'admin'; else $dir = 'est';  
	  $link = "../../recursos/$dir/fotos/".$datos['foto']; } 
	  
	  ?>
                <img style="border:solid 1px" src="<?=$link ?>"></td>
              <td width="8%" class="style3"><?=LANG_msg_from ?></td>
              <td width="80%" class="style1"><?=$datos['Remite'] ?></td>
              </tr>
            <tr>
              <td class="style3"><?=LANG_date ?></td>
              <td class="style1"><?=$datos['fecha'] ?></td>
              </tr>
            <tr>
              <td class="style3"><span class="style1">
                <?= LANG_msg_priori ?>
              </span></td>
              <td class="style1"><?=$datos['urgencia'] ?></td>
              </tr>
            <tr>
              <td class="style3">&nbsp;</td>
              <td class="style1">&nbsp;</td>
              </tr>
            
            <tr>
              <td width="8%" class="style3"><?=LANG_subjet ?></td>
              <td colspan="3" class="style1"><?=$datos['titulo'] ?></td>
              </tr>
            <tr>
              <td colspan="4" class="no_back"><?=$datos['content'] ?></td>
              </tr>
            <tr>
              <td colspan="4">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="4"><span class="style3">
                <input type="button" name="b1"  value="<?=LANG_back?>" onClick="history.back();">
               <input type="button" name="b2"  value="<?=LANG_est_mens_reply?>" onClick="location.replace('responder.php?titulo=<?=$datos['titulo'] ?>&id=<?=$datos['de'] ?>&suj=<?=$datos['Remite'] ?>&tipo=<?=$datos['tipo'] ?>');">
                </span></td>
            </tr>
          </table>
          
           <!-- data aqui --> 
          
          
          </td>
    </tr>
    </table>
    </td>
   </tr> 
   </table>
          
          
</body>
</html>
<?php 

 if($datos['leido']==0) $ver->query("update mensaje_est set leido = 1 where id = '{$_GET['id']}'");

 $ver->cerrar();

?>