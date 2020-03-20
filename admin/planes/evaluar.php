<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);

$tool = new tools("db");

			$tool->query("SELECT DISTINCT p.titulo, p.id, count(i.id) as nitem
								  FROM
								  tbl_plan_evaluador p
								  INNER JOIN tbl_plan_item i ON (p.id = i.plan_id) 
								  where grupo_id in (select id from tbl_grupo where curso_id = {$_SESSION['CURSOID']})
								  group by p.id ");
								  
								  


?>
<!DOCTYPE html>
<html>
<head> <meta charset="utf-8">
	
<link rel="stylesheet" type="text/css" href="../../css/style_back.css">
</head>

<body>
<table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="26" valign="top"> <span class="menu-title"><?= $menu->nombre; ?></span></td>
  </tr>
  <tr>
    <td><?php $menu->mostrar(2); ?></td>
  </tr>
  <tr>
    <td>
	
	<table style="border-right:#000000 solid 1px; border-left:#000000 solid 1px; border-bottom:#000000 solid 1px;" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><br>
          <table width="98%" border="0" align="center" cellpadding="2" cellspacing="2">
          <tr>
            <td class="style3"><?php echo LANG_planes_eval ?>&nbsp;</td>
          </tr>
         
         <?php if ($tool->nreg==0){ ?>
          <tr>
            <td><?php echo LANG_planes_noplan ?></td>
          </tr>
          <?php }else{ 
		  
		  while ($row = $tool->db_vector_nom($tool->result)) {
		  
			  ?>
				  <tr>
					<td><a style="text-decoration:underline" href="eval_items.php?id=<?php echo $row['id']  ?>&plan=<?php echo $row['titulo']  ?>"><?php echo $row['titulo']  ?></a>&nbsp;&nbsp;&nbsp;<span class="small">(<?php echo $row['nitem']  ?> items)</span></td>
				  </tr>
			  
			  <?php 
		  
		  
		  }
		  
		  
		  } ?>
          <tr>
            <td>&nbsp;</td>
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
