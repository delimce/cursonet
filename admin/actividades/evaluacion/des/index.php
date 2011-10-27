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
       "no_registers" => '<table bgcolor="#FFFFFF" width="100%"><tr><td align = "center"><b>'.LANG_noresutlts.'</b></td></tr></table>',
       "style_body" => "td_whbk",
       "style_head" => "table_bk",
       "r_header" => 20,
	   "formato"=> "html",
	   "oculto" => '0,7',
	   "orden" => array("nombre" => "orden1", "defecto" => "e.fecha desc"),
	   "abreviar" =>  array(1=> 25,2 => 25,3 => 25),
       "nuevo_vinculo1"  => array("nombre" => "&nbsp;", "texto" => "<img border=\"0\" src=\"../../../../images/backend/button_edit.png\">", "url" => "editar.php?","target" => "_self", "parametro" => 0, "var_parametro" => 'ItemID', "title" => LANG_edit, "condicion"=> 7, "texto_condicion"=>"<img border=\"0\" src=\"../../../../images/backend/button_noedit.png\">"),
	   "nuevo_vinculo2"  => array("nombre" => "&nbsp;", "texto" => "<img border=\"0\" src=\"../../../../images/backend/button_drop.png\">","url" => "#","target" => "_self", "parametro" => 0, "var_parametro" => 'ItemID', "title" => LANG_drop,"borrar"=>1),

	   "separacion"   => array(0 => "1%", 1 => "30%", 2=> "30%",3=> "16%",4=> "10%",5=> "10%",6=> "14%"), //separacion de columnas
	   "alineacion"   => array(0 => "center", 1 => "left", 2 => "center", 3 => "center", 3 => "center",4 => "center",5 => "center",6 => "center"),
       "celda_vacia"  => '<div align="center">-</div>',
	   "dateformat"   => array("pos" => "4,5", "formato" => $_SESSION['DB_FORMATO'])
 );


  $grid = new grid("99%","*","center",$features);
  $grid->autoconexion();
  $query = " select e.id, e.nombre, c.titulo as caso, IFNULL((select nombre from tbl_grupo where id = e.grupo_id),'".LANG_all."') as seccion, e.fecha as inicio, e.fecha_fin as fin,
  (CASE WHEN e.fecha > NOW() THEN '<font color=\"#000099\">Pendiente</font>' WHEN (e.fecha <= NOW() AND NOW() <= e.fecha_fin  )  THEN '<font color=\"#009900\">Aplicandose</font>' ELSE '<font color=\"#FF0000\">aplicada</font>' END) as estatus,
  if(NOW() >= e.fecha_fin,'0','1') as condicion_editar
  from tbl_evaluacion e,tbl_contenido c where e.contenido_id = c.id and e.curso_id = {$_SESSION['CURSOID']} and tipo = 2 ";


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

<link rel="stylesheet" type="text/css" href="../../../../css/style_back.css">
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
<?php


 unset($_SESSION['eva_seccion']);
 unset($_SESSION['eva_caso']);
 unset($_SESSION['eva_nombre']);
 unset($_SESSION['eva_preg']);
 unset($_SESSION['eva_fecha']);
 unset($_SESSION['eva_hora']);
 unset($_SESSION['eva_mins']);
 unset($_SESSION['eval_id']);


 $grid->cerrar();

?>