<?php session_start();
$profile = 'est'; /////////////// perfil requerido
include("../config/setup.php"); ////////setup
include("../class/clases.php");
include ("../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje


 $datos = new tools();
 $datos->autoconexion();
 
 if(isset($_REQUEST['curso'])){
  $_SESSION['CURSOID'] = $_REQUEST['curso'];
  $_SESSION['CASOACTUAL'] = '';
 
  	if(empty($_SESSION['CURSOID'])){
  	 	unset($_SESSION['CASOACTUAL']);
		
	} 
  
 }
 
 $infocurso = $datos->simple_db("select nombre,duracion,descripcion from tbl_curso where id = '{$_SESSION['CURSOID']}' ");
 $mensajes = $datos->estructura_db("select id, IF(LENGTH(subject)>60,concat(SUBSTRING(subject,1,60),'...'),subject) as subject, date_format(fecha,'{$_SESSION['DB_FORMATO_DB']}') as fecha from mensaje_est where para = {$_SESSION['USER']} and leido = 0 order by id desc");


?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../css/style_front.css">
<script language="JavaScript" type="text/javascript" src="../js/ajax.js"></script>
<script type="text/javascript" src="../js/utils.js"></script>
<script language="JavaScript" type="text/javascript">
	function contenido(valor){
	
	if(valor!='')document.getElementById("muestra").style.display = ''; else document.getElementById("muestra").style.display = 'none';
	
	var profi,nombrep;
	
	oXML = AJAXCrearObjeto();
	oXML.open('get', 'caso.php?id='+valor);
	oXML.onreadystatechange = function(){
		if (oXML.readyState == 4 && oXML.status == 200) {
		     var xml  = oXML.responseXML.documentElement; ///devuelve parseado el documento dentro de una var
			 
			profi  = Number(xml.getElementsByTagName('profid')[0].firstChild.data); ///id del profesor para ver sus datos 
			nombrep = String(xml.getElementsByTagName('autor')[0].firstChild.data); 
			document.getElementById('cnombre').innerHTML = xml.getElementsByTagName('titulo')[0].firstChild.data; 
		    document.getElementById('cfecha').innerHTML = xml.getElementsByTagName('fecha')[0].firstChild.data; 
			document.getElementById('cautor').innerHTML  = '<a target="content" style="color:#03F; text-decoration:none" href="staff.php?id='+profi+'">'+nombrep+'</a>';
			document.getElementById('cnrec').innerHTML  = xml.getElementsByTagName('rec')[0].firstChild.data; 
			document.getElementById('lecturas').innerHTML  = xml.getElementsByTagName('lee')[0].firstChild.data; 
			
           vaciar(oXML);
		}
	 }

	oXML.send(null); 
	
	
	
	}
	
	</script>

</head>

<body <?php if($_SESSION['CASOACTUAL']!=''){ ?> onLoad="contenido(<?=$_SESSION['CASOACTUAL']?>);" <?php } ?>>
<table width="100%" border="0" cellspacing="6" cellpadding="2">
  <tr>
    <td width="58%" align="center" style="border: #9AB1B6 1px solid;">
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="2" class="welcome">
          <?= LANG_est_info_curso ?></td>
      </tr>
      <tr>
        <td height="2" colspan="2"><hr color="#9AB1B6" size="1px"></td>
      </tr>
      <tr>
        <td width="30%" class="style3">
          <?= LANG_curso_name ?>
        </td>
      <td width="70%" height="26" class="small"><?php 
      
      echo $infocurso['nombre'];
		
      if($infocurso['nombre']==""){
      	
      	echo '<span style="color:red" class="small">'.LANG_est_info_scur.'</span>';
      	$infocurso['duracion'] = '-';
      	$infocurso['descripcion'] = '-';
      	
      }
      
      
      ?></td>
      </tr>
      
	
	  
	  <tr>
	    <td class="style3">
	      <?= LANG_curso_long ?>
	    </td>
	    <td height="24"><?php echo $infocurso['duracion'] ?></td>
	    </tr>
	  
	  <tr>
	    <td height="23" class="small"><span class="style3">
	      <?= LANG_curso_desc ?>
	    </span></td>
	    <td class="small"><?php echo $infocurso['descripcion'] ?></td>
	    </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    </tr>
	  <tr>
	    <td class="style3"> <?= LANG_est_scurso ?></td>
	    <td><span class="style1"><?php echo $datos->combo_db("casos","select  id, IF(LENGTH(titulo)>60,concat(SUBSTRING(titulo,1,60),'...'),titulo) as titulo from contenido c where c.curso_id = '{$_SESSION['CURSOID']}'  and c.borrador = 0","titulo","id",LANG_select,$_SESSION['CASOACTUAL'],'contenido(this.value);',LANG_est_nogroup_cont); ?></span></td>
	    </tr>
	  <tr height="10">
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	  </tr>
	  
	 <tr height="30">
        <td class="style3"><?php echo LANG_est_tcontent ?></td>
      <td><div class="small" id="cnombre">-</div></td>
    </tr>
	  
      <tr>
        <td class="style3"><?php echo LANG_est_cont_fecha ?></td>
      <td><div class="small" id="cfecha">-</div></td>
    </tr>
      <tr>
        <td class="style3"><?php echo LANG_est_cont_autor ?></td>
      <td><div class="small" id="cautor">-</div></td>
    </tr>
      <tr>
        <td class="style3"><?php echo LANG_est_cont_nrec ?></td>
      <td><div class="small" id="cnrec">-</div></td>
    </tr>
      <tr>
        <td class="style3"><?php echo LANG_content_reads ?></td>
        <td>
          <div class="small" id="lecturas">-</div>        </td>
      </tr>
      <tr>
        <td class="small">&nbsp;</td>
        <td class="small">  <div id="muestra" style="display:none"><input style="background:#FFFFFF" type="button" name="Button" onClick="location.replace('contenido/index.php?id='+document.getElementById('casos').value);" value="<?=LANG_est_cont_ver?>">
          
          </div>        </td>
      </tr>
    </table>
    </td>
    <td width="42%" rowspan="2" valign="top" style="border: #9AB1B6 1px solid;"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="100%" height="14" align="left" valign="middle" class="welcome"><?= LANG_est_wall_title ?></td>
      </tr>
      <tr>
        <td height="2" valign="bottom"><hr color="#9AB1B6" size="1px"></td>
      </tr>
     
      <tr valign="top">
        <td class="style1"  height="<?php echo $tamam = 275 + (7*count($mensajes)); ?>">
        <MARQUEE id="mm" height="<?php echo $tamam ?>" align="top"  direction="up" scrolldelay="120">
		<?php $datos->query("select mensaje,date_format(fecha_c,'{$_SESSION['DB_FORMATO_DB']}') as fecha,
		destaca from cartelera 
		where (curso_id = '{$_SESSION['CURSOID']}') and (grupo_id = 0 OR grupo_id in ('{$_SESSION['GRUPOSID']}') ) order by id desc"); ?>
		<?php 
				if($datos->nreg>0){
				  
				  while ($row = mysql_fetch_assoc($datos->result)) {
				  
				  			?>
                            <br>
                            <table style="border-bottom:solid 1px; border-color:#999999;" onMouseOver="mm.stop();" onMouseOut="mm.start();" width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr class="style4">
                                <td>
								<?php echo 'Mensaje publicado el '.$row['fecha'];
									  if($row['destaca']){
									  ?>&nbsp;&nbsp;<span style="text-decoration:blink; color:#FF6600"><?php echo LANG_est_wall_Warning ?></span> <?
									  }
								
								 ?> 
                                </td>
                              </tr>
                              <tr>
                                <td><?php echo $row['mensaje'] ?></td>
                              </tr>
                            </table>
                           <br>

            				<?
				  
				  }
				 
				 }else{
				 
				 	echo '<b>'.LANG_est_wall_notext.'</b>'; //no hay mensajes en cartelera
					
				 }  
				
				
		 ?> 
        </MARQUEE></td>
      </tr>
      
    </table></td>
  </tr>
  <tr>
    <td style="border: #9AB1B6 1px solid;"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td height="14" colspan="3" align="left" valign="middle" class="welcome"><?= LANG_msg_nread ?></td>
        </tr>
      <tr>
        <td height="2" colspan="3" valign="bottom"><hr color="#9AB1B6" size="1px"></td>
      </tr>
	  
	  
	  <?php if(count($mensajes) == 0){ ?>
      <tr>
        <td colspan="3" class="style3"><?=LANG_msg_nmessages?></td>
      </tr>
		<?php }else{ 
		
		for($i=0;$i<count($mensajes);$i++){
		
		?>
		
      <tr onMouseOver="this.bgColor='#F3F7F8'" onMouseOut="this.bgColor='#ffffff'">
        <td width="4%" valign="top" class="small"><img src="../images/frontend/icons/nmessage.gif" width="16" height="12"></td>
        <td width="92%" valign="top" class="small"><a href="mensajes/mensaje.php?id=<?=$mensajes[$i]['id']?>"><?=$mensajes[$i]['subject']?></a></td>
        <td width="4%" align="right" valign="top" class="small"><?=$mensajes[$i]['fecha']?></td>
      </tr>
	  
	  <?php 
	  
	  }
	  
	  }
	  
	  
	  ?>
	  
	  
    </table></td>
  </tr>
</table>
</body>
</html>
<?php $datos->cerrar(); ?>