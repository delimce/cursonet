<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

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
	   "oculto" => '0,5',
	   "orden" => array("nombre" => "orden1", "defecto" => "id"),
	   "abreviar" =>  array(1 => 55,2 => 30),
       "nuevo_vinculo1"  => array("nombre" => "&nbsp;", "texto" => "<img border=\"0\" src=\"../../images/backend/button_edit.png\">", "url" => "editar.php?","target" => "_self", "parametro" => 0, "var_parametro" => 'ItemID', "title" => LANG_edit),
	   "nuevo_vinculo2"  => array("nombre" => "&nbsp;", "texto" => "<img border=\"0\" src=\"../../images/backend/button_drop.png\">","url" => "#","target" => "_self", "parametro" => 0, "var_parametro" => 'ItemID', "title" => LANG_drop,"borrar"=>1,"condicion"=> 5, "texto_condicion"=>"<img border=\"0\" src=\"../../images/backend/button_nodel.png\">"),
       "separacion"   => array(0 => "1%", 1 => "60%", 2=> "26%",3=> "13%",4=> "13%"), //separacion de columnas
	   "alineacion"   => array(0 => "center", 1 => "left", 2 => "center", 3 => "center", 3 => "center",4 => "center"),
       "celda_vacia"  => '<div align="center">-</div>',
	   "dateformat"   => array("pos" => "4", "formato" => $_SESSION['DB_FORMATO'])
 );



  $grid = new grid("99%","*","center",$features);
  $grid->autoconexion();
  
  $query = "select c.id,c.titulo,
   ifnull((select concat(a.nombre, ' ', a.apellido) from tbl_admin a where a.id = c.autor),'".LANG_content_autor_unknow."') as autor, c.leido as lecturas,
   c.fecha,
   if({$_SESSION['ADMIN']}>2,'1','0') as condicion_editar
   from tbl_contenido c where c.curso_id = {$_SESSION['CURSOID']} ";
   

	$grid->query($query); //////se ejecuta el query

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
        <td><br><?php $grid->cargar($query,false,true);?>&nbsp;</td>
      </tr>
    </table>	</td>
  </tr>
</table>
</body>
</html>
