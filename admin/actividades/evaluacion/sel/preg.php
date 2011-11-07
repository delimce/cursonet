<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../../config/setup.php"); ////////setup
include("../../../../class/clases.php"); ////////clase
include ("../../../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);


 $features = array (
       "borde" => array("cellpadding" => 2, "cellspacing" => 1,  "style" => "table_bk"),  
       "mostrar_nresult" => array("nombre" =>  '<b>'.LANG_results.'<b>', "style" => "td_whbk", "align" => "left"),
       "no_registers" => '<table bgcolor="#FFFFFF" width="100%"><tr><td align = "center"><b>'.LANG_eva_noquestions.'</b></td></tr></table>',
       "style_body" => "td_whbk",
       "style_head" => "table_bk",
       "r_header" => 20,
	   "formato"=> "html",
	 //  "conenlace"  => array("pos" => "1", "title" => LANG_open_file, "url" => "../../recursos/".$valor,"target" => "_blank"),
	   "oculto" => 0,
	   "orden" => array("nombre" => "orden1", "defecto" => "e.id desc"),  
	    "abreviar" =>  array(2 => 40),  
      "nuevo_vinculo1"  => array("nombre" => "&nbsp;", "texto" => "<img border=\"0\" src=\"../../../../images/backend/button_edit.png\">", "url" => "simple_update.php?","target" => "_self", "parametro" => 0, "var_parametro" => 'ItemID', "title" => LANG_edit),
	  "nuevo_vinculo2"  => array("nombre" => "&nbsp;", "texto" => "<img border=\"0\" src=\"../../../../images/backend/button_drop.png\">","url" => "#","target" => "_self", "parametro" => 0, "var_parametro" => 'ItemID', "title" => LANG_drop,"borrar"=>1),
       "separacion"   => array(0 => "1%", 1 => "55%", 2=> "34%", 3=> "14%"), //separacion de columnas
	   "alineacion"   => array(0 => "center", 1 => "left", 2 => "center", 3 => "center",4 => "center"),
       "celda_vacia"  => '<div align="center">-</div>',
	   "dateformat"   => array("pos" => "3", "formato" => $_SESSION['DB_FORMATO'])
 );
 
 
 
  $grid = new grid("99%","*","center",$features);
  $grid->autoconexion();
  $query = "SELECT
			p.id,
			p.pregunta as enunciado,
			ifnull(e.nombre,'-') as evaluación,
			(CASE WHEN p.nivel = 1 THEN '".LANG_eva_level2."' WHEN p.nivel = 2  THEN '".LANG_eva_level3."' ELSE '".LANG_eva_level4."' END) as nivel
			FROM
			tbl_evaluacion_pregunta p
			left Join tbl_evaluacion e  ON e.id = p.eval_id
			WHERE
			p.tipo =  '1'
			AND p.curso_id = {$_SESSION['CURSOID']} ";



?>
<html>
<head>
	<script language="JavaScript" type="text/javascript">
	function borrar(id,nombre){
	
	  if (confirm('<?=LANG_eva_delsel?> "'+nombre+'" ?')) {
	  
	  location.replace('borrarp.php?itemID='+id);
	  
	  }else{
	  
	  
	  return false;
	  
	  }
	}
	</script>
	
<link rel="stylesheet" type="text/css" href="../../../../css/style_back.css">
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
          <a href="simple_insert.php" class="style1"> <img src="../../../../images/backend/nuevo.gif" width="16" height="16" border="0" align="left"><?=LANG_add2 ?></a><br>
          <br>
          <?php $grid->cargar($query);?>&nbsp;</td>
      </tr>
    </table>	</td>
  </tr>
</table>
</body>
</html>
