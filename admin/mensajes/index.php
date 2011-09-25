<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/tools.php"); ////////clase
include("../../class/grid.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje


		if(isset($_REQUEST['delete0'])){ ////borrar todos los mensajes
		
				$tool = new tools();
				$tool->autoconexion();
				$tool->query("delete from mensaje_admin where para = '{$_SESSION['USERID']}' ");
				$tool->cerrar();
				$tool->javaviso("Todos sus mensajes han sido borrados","index.php");
				
		
		}

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);


 $features = array (
       "borde" => array("cellpadding" => 2, "cellspacing" => 1,  "style" => "table_bk"),  
       "mostrar_nresult" => array("nombre" =>  '<b>'.LANG_results.'<b>', "style" => "td_whbk", "align" => "left"),
       "no_registers" => '<table bgcolor="#FFFFFF" width="100%"><tr><td align = "center"><b>'.LANG_msg_nomesage.'</b></td></tr></table>',
       "style_body" => "td_whbk",
       "style_head" => "table_bk",
       "r_header" => 20,
	   "formato"=> "html",
	   "oculto" => 0,
	   "orden" => array("nombre" => "orden1", "defecto" => "Estado,fecha desc"),  
	    "abreviar" =>  array(2 => 30),  
      "conenlace"  => array("pos" => 1, "url" => "mensaje.php?","target" => "_self", "parametro" => 0, "var_parametro"=>"id"),
	  "nuevo_vinculo2"  => array("nombre" => "&nbsp;", "texto" => "<img border=\"0\" src=\"../../images/backend/button_drop.png\">","url" => "#","target" => "_self", "parametro" => 0, "var_parametro" => 'ItemID', "title" => LANG_drop,"borrar"=>1),
       "separacion"   => array(0 => "1%", 1 => "50%", 2=> "26%",3=> "14%",4=> "10%"), //separacion de columnas
	   "alineacion"   => array(0 => "center", 1 => "left", 2 => "center", 3 => "center",4 => "center"),
       "celda_vacia"  => '<div align="center">-</div>'
 );
 
 
 
  $grid = new grid("99%","*","center",$features);
  $grid->autoconexion();
  $query = "select id,subject as titulo,
  IF(tipo=0,(select concat('".LANG_msg_prefa."',nombre,' ',apellido) from admin where id = de ),(select concat('".LANG_msg_prefs."',nombre,' ',apellido) from estudiante where id = de )) as Remite
  ,date_format(fecha,'".$_SESSION['DB_FORMATO_DB']."') as fecha,if(leido=0,'<font color=\"blue\">".LANG_new."</font>','".LANG_old."') as Estado from mensaje_admin where para = '{$_SESSION['USERID']}'";


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
	
	
	function borrartodo(){
	
	  if (confirm("¿Seguro que desea borrar todos los mensajes recibidos?")) {
	  
	  location.replace('index.php?delete0=1');
	  
	  }else{
	  
	  
	  return false;
	  
	  }
	}
	
	</script>
	
	
	<script>
		function copyToDiv() {
		
			parent.document.getElementById('nmessages').innerHTML = '<?php echo LANG_messages; ?> (<?=$grid->nreg ?>)';
		
		}
    </script> 
	
	
<link rel="stylesheet" type="text/css" href="../../css/style_back.css">
</head>

 <BODY OnLoad="copyToDiv();">
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
        <td><p><br>
            <br>
            <?php $grid->cargar($query,false,true);?>
          &nbsp;</p>
          
          <?php if($grid->nreg>0){ ?>
          <p align="center">
            <input type="button" name="button" onClick="borrartodo();" id="button" value="Borrar todos los mensajes">
            <br>
            <br>
          </p>
          
          <?php } ?></td>
      </tr>
    </table>	</td>
  </tr>
</table>
</body>
</html>
