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
       "no_registers" => '<table bgcolor="#FFFFFF" width="100%"><tr><td align = "center"><p><b>'.LANG_noresutlts.'</b></p></td></tr></table>',
       "style_body" => "td_whbk",
       "style_head" => "table_bk",
       "r_header" => 20,
	   "formato"=> "html",
	   "oculto" => 0,
	   "orden" => array("nombre" => "orden1", "defecto" => "e.fecha_post desc","extras" => "&seccion={$_GET['seccion']}"),
	   "abreviar" =>  array(1 => 40,3 => 35),

	   "conenlace"  => array("pos" => 1, "title" => LANG_accomp_ppolitic, "url" => "foro.php?","target" => "_self", "parametro" => 0, "var_parametro"=>"idpro"),
	   "separacion"   => array(0 => "1%", 1 => "47%", 2=> "40%",3=> "20%"), //separacion de columnas
	   "alineacion"   => array(0 => "center", 1 => "left", 2 => "center", 3 => "center", 3 => "center",4 => "center"),
       "celda_vacia"  => '<div align="center">-</div>',
	   "dateformat"   => array("pos" => "3", "formato" => $_SESSION['DB_FORMATO'])
 );

  $combo = new tools("db");
  $grid = new grid("99%","*","center",$features);
  $grid->dbc = $combo->dbc;

  if($_GET['seccion']=="")$filtro = ''; else $filtro = "and e.grupo_id = {$_GET['seccion']}"; ///se asume que el defecto de grupo_id de evaluacion es 0

  $query = "select distinct e.id, e.titulo as nombre, c.titulo as caso, date_format(e.fecha_post,'{$_SESSION['DB_FORMATO_DB']}') as fecha
  from tbl_foro e,tbl_contenido c where e.contenido_id = c.id  $filtro";



?>
<!DOCTYPE html><html>
<head> <meta charset="utf-8">

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
        <td>&nbsp;<?=LANG_group_filter ?> <form name="se" action="index.php" method="get"><? echo  $combo->combo_db("seccion","select id,nombre from tbl_grupo","nombre","id",LANG_all,false,"submit();");  ?></form><br>
          <br><?php  $grid->cargar($query);?>
          <br></td>
      </tr>
    </table>	</td>
  </tr>
</table>
</body>
</html>
<?php

 $grid->cerrar();

?>