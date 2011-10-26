<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);
$_SESSION['tema_id'] = ''; /////tema


 $features = array (
       "borde" => array("cellpadding" => 2, "cellspacing" => 1,  "style" => "table_bk"),  
       "mostrar_nresult" => array("nombre" =>  '<b>'.LANG_results.'<b>', "style" => "td_whbk", "align" => "left"),
       "no_registers" => '<table bgcolor="#FFFFFF" width="100%"><tr><td align = "center"><b>'.LANG_noresutlts.'</b></td></tr></table>',
       "style_body" => "td_whbk",
       "style_head" => "table_bk",
       "r_header" => 20,
	   "formato"=> "html",
	   "oculto" => 0,
	   "orden" => array("nombre" => "orden1", "defecto" => "id desc"),  
	    "abreviar" =>  array(2 => 20,3 => 60),  
       "nuevo_vinculo1"  => array("nombre" => "&nbsp;", "texto" => "<img border=\"0\" src=\"../../images/backend/button_edit.png\">", "url" => "edit.php?","target" => "_self", "parametro" => 0, "var_parametro" => 'id', "title" => LANG_edit),
	  "nuevo_vinculo2"  => array("nombre" => "&nbsp;", "texto" => "<img border=\"0\" src=\"../../images/backend/button_drop.png\">","url" => "#","target" => "_self", "parametro" => 0, "var_parametro" => 'ItemID', "title" => LANG_drop,"borrar"=>1),
       "separacion"   => array(0 => "1%", 1 => "12%", 2=> "18%",3=> "62%",4=> "20%"), //separacion de columnas
	   "alineacion"   => array(0 => "center", 1 => "center", 2 => "center", 3 => "left",4 => "center"),
       "celda_vacia"  => '<div align="center">-</div>',
	   "dateformat"   => array("pos" => "1", "formato" => $_SESSION['DB_FORMATO'])
 );
 
 
 
  $grid = new grid("99%","*","center",$features);
  $grid->autoconexion();
  $query = "select id,fecha_c as fecha,IFNULL((select nombre from grupo where id = p.grupo_id),'".LANG_all."') as grupo,
  SUBSTRING(mensaje,1,100) as mensaje,
  IF(destaca=1,'<b>".LANG_wall_imp."</b>','".LANG_wall_imp_no."') as destaca
   from cartelera p where p.curso_id = {$_SESSION['CURSOID']} ";



?>
<html>
<head>
	<script language="JavaScript" type="text/javascript">
	function borrar(id,nombre){
	
	  if (confirm("<?=LANG_wall_borrar?> "+nombre+" ?")) {
	  
	  location.replace('borrar.php?itemID='+id);
	  
	  }else{
	  
	  
	  return false;
	  
	  }
	}
	</script>
	
<link rel="stylesheet" type="text/css" href="../../css/style_back.css">
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
