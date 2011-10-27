<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../config/setup.php"); ////////setup
include("../../../class/clases.php"); ////////clase
include ("../../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);


 $features = array (
       "borde" => array("cellpadding" => 2, "cellspacing" => 1,  "style" => "table_bk"),  
       "mostrar_nresult" => array("nombre" =>  '<b>'.LANG_results.'<b>', "style" => "td_whbk", "align" => "left"),
       "no_registers" => '<table bgcolor="#FFFFFF" width="100%"><tr><td align = "center"><b>'.LANG_proy_noexist.'</b></td></tr></table>',
       "style_body" => "td_whbk",
       "style_head" => "table_bk",
       "r_header" => 20,
	   "formato"=> "html",
	   "oculto" => 0,
	   "orden" => array("nombre" => "orden1", "defecto" => "fecha_edit desc"),  
	    "abreviar" =>  array(1 => 35,2 => 20),  
       "nuevo_vinculo1"  => array("nombre" => "&nbsp;", "texto" => LANG_eva_evaluate, "url" => "proys.php?","target" => "_self", "parametro" => 0, "var_parametro" => 'ItemID', "title" => LANG_proy_eval),
       "separacion"   => array(0 => "1%", 1 => "45%", 2=> "34%",3=> "12%"), //separacion de columnas
	   "alineacion"   => array(0 => "center", 1 => "left", 2 => "center", 3 => "center", 3 => "center"),
       "celda_vacia"  => '<div align="center">-</div>'
 );
 
 
  unset($_SESSION['PRO_ID']);
  unset($_SESSION['PRO_ID2']);
  
  $grid = new grid("99%","*","center",$features);
  $grid->autoconexion();
  $query = "select distinct p.id,nombre,IFNULL((select nombre from tbl_grupo where id = p.grupo),'".LANG_all."') as seccion, concat((select count(*) from tbl_proyecto_estudiante where proy_id = p.id and nota > -1),'/',(select count(*) from tbl_proyecto_estudiante where proy_id = p.id )) as evaluados
   from tbl_proyecto p inner join tbl_proyecto_estudiante e on (p.id = e.proy_id) and p.curso_id = {$_SESSION['CURSOID']}";



?>
<html>
<head>
	<script language="JavaScript" type="text/javascript">
	function borrar(id,nombre){
	
	  if (confirm("<?=LANG_borrar?> "+nombre+" ?")) {
	  
	  location.replace('borrar.php?itemID='+id);
	  
	  }else{
	  
	  
	  return false;
	  
	  }
	}
	</script>
	
<link rel="stylesheet" type="text/css" href="../../../css/style_back.css">
</head>

<body>
<table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="26" valign="top"><?php echo $menu->nombre; ?></td>
  </tr>
  <tr>
    <td><?php $menu->mostrar(0); ?></td>
  </tr>
  <tr>
    <td>
	
	<table style="border-right:#000000 solid 1px; border-left:#000000 solid 1px; border-bottom:#000000 solid 1px;" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><br><?php $grid->cargar($query);?>&nbsp;</td>
      </tr>
    </table>	</td>
  </tr>
</table>
</body>
</html>
<?php $grid->cerrar(); ?>
