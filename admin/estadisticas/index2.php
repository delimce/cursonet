<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);

	$tool = new formulario('db');
	
	$est = $tool->getvar("est");
	
 
?>
<html>
<head>
<script type="text/javascript" src="../../js/utils.js"></script>
<script type="text/javascript" src="../../js/ajax.js"></script>	
 <LINK href="../../js/calendario/calendario.css" type=text/css rel=stylesheet>	
 
<link rel="stylesheet" type="text/css" href="../../css/style_back.css">
</head>

<body>
<table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="26" valign="top"><?php echo $menu->nombre; ?></td>
  </tr>
  <tr>
    <td><?php $menu->mostrar(1); ?></td>
  </tr>
  <tr>
    <td>
	
	<table style="border-right:#000000 solid 1px; border-left:#000000 solid 1px; border-bottom:#000000 solid 1px;" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
        
        <br>
        
        
        <form action="" method="post" name="form1" target="_self">
        <table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr><td colspan="2" class="table_bk"><?php echo LANG_esta_indi ?></td> </tr>
        <tr>
          <td width="26%"><span class="style3">
            <?= LANG_esta_est_select ?>
          </span></td>
          <td width="74%"><span class="style1">
		  <?php
		  	/////ESTUDIANTES DEL CURSO SELECCIONADO
		   echo $tool->combo_db("est","select id,concat(nombre,' ',apellido,' - ',id_number) as nombre from tbl_estudiante e where e.id in (select est_id from tbl_grupo_estudiante where curso_id = '{$_SESSION['CURSOID']}' ) order by nombre,id_number","nombre","id",LANG_select,false,'submit();',LANG_modo_noest);?>
          </span></td>
        </tr>
        
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
       <?php if(!empty($est)){
		   
		   $data = $tool->simple_db("SELECT 
									   sum(soporte_a) AS sa,
									   sum(soporte_t) AS st,
									   GROUP_CONCAT(contenidos) as cont,
									   GROUP_CONCAT(descargas) as des
									   FROM
										tbl_log_est e
										where e.est_id = $est  
										GROUP BY  e.est_id");						
										 
										 
										if($tool->nreg>0){  ////si la persona ha entrado aunque sea 1 vez
										  
											  $temas = explode(',',$data['cont']);
											  $utemas = $tool->estructura_db("select id,titulo from tbl_contenido where id in ({$data['cont']}) ");
											  
											  for($i=0;$i<count($utemas);$i++){
												  
												  $utemas[$i]["nveces"] = $tool->se_repite($temas,$utemas[$i]["id"]);	  
												  
											  }
											  
											  $down = explode(',',$data['des']);
											  $udown = $tool->estructura_db("select id,dir from tbl_recurso where id in ({$data['des']}) ");	  
											  
											   for($i=0;$i<count($udown);$i++){
												  
												  $udown[$i]["nveces"] = $tool->se_repite($down,$udown[$i]["id"]);	  
												  
											  }
										  
										} ///fin if
								   		
		   					if(empty($data['sa'])) $data['sa'] = 0;
							if(empty($data['st'])) $data['st'] = 0;
		    ?> 
        <tr>
          <td colspan="2"><span class="style3"><?php echo LANG_esta_supporta ?></span>&nbsp;<?php  echo $data['sa']; ?></td>
          </tr>
        <tr>
          <td colspan="2"><span class="style3"><?php echo LANG_esta_supporte ?></span>&nbsp;<?php  echo $data['st']; ?></td>
        </tr>
         <?php if(count($utemas)>0){ ?><tr><td colspan="2" class="table_bk"><?php echo LANG_esta_ntemas ?></td> </tr><?php } ?>
         <?php  for($i=0;$i<count($utemas);$i++){ ?>
            <tr>
               <td colspan="2"><span class="style3"><?php echo $utemas[$i]["titulo"] ?></span>&nbsp;<?php echo $utemas[$i]["nveces"] ?></td>
            </tr>
           <?php } ?> 
        
        <?php if(count($udown)>0){ ?><tr><td colspan="2" class="table_bk"><?php echo LANG_esta_ndown ?></td> </tr><?php } ?>
         <?php  for($i=0;$i<count($udown);$i++){ ?>
            <tr>
               <td colspan="2"><span class="style3"><?php echo $udown[$i]["dir"] ?></span>&nbsp;<?php echo $udown[$i]["nveces"] ?></td>
            </tr>
           <?php } ?> 
       
        <tr>
          <td colspan="2" class="style3"></td>
          </tr>
        <?php } ?>
        </table>
        </form>
        
        <br>&nbsp;</td>
      </tr>
    </table>	</td>
  </tr>
</table>
</body>
</html>
<?php 

	$tool->cerrar();

?>
