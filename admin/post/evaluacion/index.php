<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../config/setup.php"); ////////setup
include("../../../class/clases.php"); ////////clase
include ("../../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);

unset($_SESSION['EVAL_ID']);

 $features = array (
       "borde" => array("cellpadding" => 2, "cellspacing" => 1,  "style" => "table_bk"),
       "mostrar_nresult" => array("nombre" =>  '<b>'.LANG_results.'<b>', "style" => "td_whbk", "align" => "left"),
       "no_registers" => '<table bgcolor="#FFFFFF" width="100%"><tr><td align = "center"><b>'.LANG_eva_noexam.'</b></td></tr></table>',
       "style_body" => "td_whbk",
       "style_head" => "table_bk",
       "r_header" => 20,
	   "formato"=> "html",
	   "oculto" => '0',
	   "orden" => array("nombre" => "orden1", "defecto" => "e.fecha"),
	   "abreviar" =>  array(1=> 25,2 => 25,3 => 20),
       "nuevo_vinculo1"  => array("nombre" => "&nbsp;", "texto" => LANG_eva_evaluate, "url" => "pruebas.php?","target" => "_self", "parametro" => 0, "var_parametro" => 'ItemID', "title" => LANG_eva_pruebas),
	   "separacion"   => array(0 => "1%", 1 => "25%", 2=> "26%",3=> "25%",4=> "10%",5=> "7%"), //separacion de columnas
	   "alineacion"   => array(0 => "center", 1 => "left", 2 => "center", 3 => "center", 3 => "center",4 => "center",5 => "center",6 => "center"),
       "celda_vacia"  => '<div align="center">-</div>',
	   "dateformat"   => array("pos" => "4", "formato" => $_SESSION['DB_FORMATO'])
 );


  $grid = new grid("99%","*","center",$features);
  $grid->autoconexion();
  $query = "SELECT  distinct e.id, e.nombre,
  (select titulo from tbl_contenido where id = e.contenido_id) AS caso,
  ifnull((select nombre from tbl_grupo where id = e.grupo_id),'todas') AS seccion,e.fecha,
  concat((select count(*) from tbl_evaluacion_estudiante where eval_id = e.id and nota != -1),'/',
  (select count(*) from tbl_evaluacion_estudiante where eval_id = e.id)) AS eval
  FROM
  tbl_evaluacion e
  WHERE
  now() > e.fecha_fin ";


?>
<!DOCTYPE html>
<html>
<head> <meta charset="utf-8">

<link rel="stylesheet" type="text/css" href="../../../css/style_back.css">
</head>

<body>
<table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="26" valign="top"> <span class="menu-title"><?= $menu->nombre; ?></span></td>
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
<?php

 $grid->cerrar();

?>