<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);

$tool = new tools("db");


			$tool->query("SELECT DISTINCT 
								  p.id,
								  p.titulo,
								  p.tipo,
								  p.id_act
								FROM
								  plan_item p
								WHERE
								  p.plan_id = '{$_REQUEST['id']}' order by id");
								  
								  


?>
<html>
<head>
	
<link rel="stylesheet" type="text/css" href="../../css/style_back.css">
<script type="text/javascript" src="../../js/utils.js"></script>

</head>

<body>
<table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="26" valign="top"><?php echo $menu->nombre; ?></td>
  </tr>
  <tr>
    <td><?php $menu->mostrar(2); ?></td>
  </tr>
  <tr>
    <td>
	
	<table style="border-right:#000000 solid 1px; border-left:#000000 solid 1px; border-bottom:#000000 solid 1px;" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><br>
          <table width="90%" border="0" align="center" cellpadding="2" cellspacing="2">
          <tr>
            <td colspan="3" class="style3"><?php echo LANG_planes_itemsplan.$_REQUEST['plan'] ?>&nbsp;</td>
          </tr>
         
            <?		  
		  
		  	while ($row = mysql_fetch_assoc($tool->result)) {
			
			
			///creando el link
			
			switch ($row['tipo']) { ///para saber la actividad
			
				case 'foro': ///foro
				
				  $link = "../post/foro/foro.php?ItemID={$row['id_act']}&item={$row['titulo']}";  
				  
					break;
				case 'proy': //proy
				
					$link = "../post/proy/proys.php?ItemID={$row['id_act']}&item={$row['titulo']}"; 
				
				   break;
				case 'eval': ///eval
					
					$link = "../post/evaluacion/pruebas.php?ItemID={$row['id_act']}&item={$row['titulo']}"; 
			 
			 
			  break; 
			  
			  default:
			  
			   $link = "otro_item.php?id={$row['id']}&item={$row['titulo']}";
			
			}
	
			
			
			
		  
			  ?>
				  <tr>
					<td width="69%" class="style1"><?php echo $row['titulo']  ?></td>
			        <td width="15%" align="center" class="style3" <?php if($row['tipo']=="otro") echo 'style="color:#0000FF"'; ?>><?php echo $row['tipo']  ?></td>
			        <td width="16%" align="center"><span class="style1"><a title="<?php echo LANG_planes_evaluatei ?>" href="<?php echo $link ?>"><?php echo LANG_planes_evaluate ?></a></td>
			  </tr>
			  
			  <?php 
		  
		  
		  }
		  
		  
		   ?>
              <tr>
                <td colspan="3" class="style1">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="3" class="style3"><a href="#" onClick="popup('sabana.php?id=<?php echo $_REQUEST['id'] ?>','eval','800','1100');"><?php echo LANG_planes_evalsheet_view ?></a></td>
              </tr>
              <tr>
                <td colspan="3" class="style1">&nbsp;</td>
              </tr>
              <tr>
            <td colspan="3"><input type="button" name="Button" onClick="location.replace('evaluar.php');" value="<?=LANG_back ?>"></td>
          </tr>
        </table>
          <br></td>
      </tr>
    </table>	</td>
  </tr>
</table>
</body>
</html>
<?php $tool->cerrar(); ?>
