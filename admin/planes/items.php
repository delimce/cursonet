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
       "no_registers" => '<table bgcolor="#FFFFFF" width="100%"><tr><td align = "center"><b>'.LANG_planes_noitems.'</b></td></tr></table>',
       "style_body" => "td_whbk",
       "style_head" => "table_bk",
	   "totalizado" => 3,
       "r_header" => 20,
	   "formato"=> "html",
	   "oculto" => 0,
	   "orden" => array("nombre" => "orden1", "defecto" => "id","extras" => "&id={$_REQUEST['id']}"),  
	   "abreviar" =>  array(1 => 60,2 => 20,3 => 16),  
       "nuevo_vinculo1"  => array("nombre" => "&nbsp;", "texto" => "<img border=\"0\" src=\"../../images/backend/button_edit.png\">", "url" => "edit_item.php?","target" => "_self", "parametro" => 0, "var_parametro" => 'id',"popup" => 'editar', "title" => LANG_edit),
	   "nuevo_vinculo2"  => array("nombre" => "&nbsp;", "texto" => "<img border=\"0\" src=\"../../images/backend/button_drop.png\">","url" => "#","target" => "_self", "parametro" => 0, "var_parametro" => 'ItemID', "title" => LANG_drop,"borrar"=>1),
       "separacion"   => array(0 => "1%", 1 => "60%", 2=> "20%",3=> "20%",4=> "13%"), //separacion de columnas
	   "alineacion"   => array(0 => "center", 1 => "left", 2 => "center", 3 => "center", 3 => "center",4 => "center"),
       "celda_vacia"  => '<div align="center">-</div>'
 );
 
 
 
  $grid = new grid("99%","*","center",$features);
  $grid->autoconexion();
  
	  $query = "SELECT 
	  p.id,
	  p.titulo,
	  p.tipo,
	  CONCAT(round(p.porcentaje,2),'%') AS total
	FROM
	  tbl_plan_item p
	WHERE
	  p.plan_id = {$_REQUEST['id']} ";



 $crear = new tools();
 $crear->dbc = $grid->dbc;
 
 $datos = $crear->simple_db("select titulo,id,grupo_id from tbl_plan_evaluador where id = {$_REQUEST['id']}");
 
 $_SESSION['GRUPOPLAN'] = $datos['grupo_id']; ///grupo asignado


?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../../css/style_back.css">
<script type="text/javascript" src="../../js/utils.js"></script>



<script language="JavaScript">
<!--

 function popup2(mylink, windowname)
 {
var alto = 265;
var largo = 500;
var winleft = (screen.width - largo) / 2;
var winUp = (screen.height - alto) / 2;


if (! window.focus)return true;
  var href;
  if(typeof(mylink) == 'string')
    href=mylink;
  else
    href=mylink.href;
    window.open(href, windowname, 'top='+winUp+',left='+winleft+'+,toolbar=0 status=1,resizable=0,Width='+largo+',height='+alto+',scrollbars=1');
    
 return false;

}

//-->
</script>


  <script language="JavaScript" type="text/javascript">
	function borrar(id,nombre){
	
	  if (confirm("<?=LANG_borrar?> "+nombre+" ?")) {
	  
	  		location.replace('borrar_item.php?itemID='+id+'&item=<?php echo $_REQUEST['id'] ?>');
	  
	  }else{
	  
	 	 return false;
	  
	  }
	}
	</script>


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
        <td>
<br>
<table width="100%" border="0" cellspacing="4" cellpadding="3">

  <tr>
    <td width="100%" class="td_whbk2"><?php echo LANG_planes_plan ?>:&nbsp;<span class="style3"><?php echo $datos['titulo'] ?></span></td>
  </tr>
  <tr>
    <td class="style1">&nbsp;</td>
    </tr>
  <tr>
    <td align="center" valign="top" class="style3"><?php $grid->cargar($query);?></td>
    </tr>
  <tr>
    <td align="left" valign="top" class="style3"><?php if($grid->nreg>0) echo LANG_planes_item_poreval.$grid->totalizado.'%'; ?></td>
  </tr>

  <tr>
    <td><input type="button" name="Button" onClick="location.replace('index.php');" value="<?=LANG_back ?>">
      <?php if($grid->totalizado<100){ ?>
      <input type="button" name="Button2" onClick="popup('crear_item.php?id=<?php echo $datos['id'] ?>', 'crear','265','500');" value="<?=LANG_planes_item_create ?>">
      <?php } ?>
      </td>
  </tr>
  <tr>
  <td>&nbsp;</td>
  </tr>
</table>
</td>
      </tr>
    </table>	</td>
  </tr>
</table>
</body>
</html>
