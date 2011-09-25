<?php session_start();
$profile = 'est'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/tools.php");
include("../../class/grid.php");
include("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje





 
 
 
  $features = array (
       "borde" => array("cellpadding" => 2, "cellspacing" => 1,  "style" => "table_bk"),  
       "mostrar_nresult" => array("nombre" =>  '<b>'.LANG_est_mens_total.'<b>', "style" => "style1", "align" => "left"),
       "no_registers" => '<table bgcolor="#FFFFFF" width="100%"><tr><td align = "center"><b>'.LANG_est_mens_nomessages.'</b></td></tr></table>',
       "style_body" => "td_whbk",
       "style_head" => "table_bk",
       "r_header" => 20,
	   "formato"=> "html",
	   "oculto" => 0,
	   "orden" => array("nombre" => "orden1", "defecto" => "leido,fecha desc"),  
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
  IF(tipo=1,(select concat('".LANG_msg_prefa."',nombre,' ',apellido) from admin where id = de ),(select concat('".LANG_msg_prefs."',nombre,' ',apellido) from estudiante where id = de )) as Remite
  ,date_format(fecha,'".$_SESSION['DB_FORMATO_DB']."') as fecha,if(leido=0,'<font color=\"blue\">".LANG_new."</font>','".LANG_old."') as Estado from mensaje_est where para = '{$_SESSION['USER']}'";

 
 

//$mensajes = $datos->estructura_db("select id, IF(LENGTH(subject)>65,concat(SUBSTRING(subject,1,65),'...'),subject) as subject, date_format(fecha,'{$_SESSION['DB_FORMATO_DB']}') as fecha from mensaje_est where para = {$_SESSION['USER']} and leido = 0 order by id desc");

?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../../css/style_front.css">

  <script language="JavaScript" type="text/javascript">
	function borrar(id,nombre){
	
	  if (confirm("<?=LANG_est_mens_borrar?> \""+nombre+"\" ?")) {
	  
	  location.replace('borrar.php?itemID='+id);
	  
	  }else{
	  
	  
	  return false;
	  
	  }
	}
   </script>

</head>
<body>
<table width="100%" border="0" cellspacing="6" cellpadding="2">
  <tr>
    <td width="56%" align="center" style="border: #9AB1B6 1px solid;">
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
      <td colspan="2" class="welcome">
        <?= LANG_est_mens_header ?>      </td>
    </tr>
      <tr>
      <td height="2" colspan="2"><hr color="#9AB1B6" size="1px"></td>
    </tr>
      <tr>
      <td height="2" colspan="2"><?php $grid->cargar($query);?><br></td>
    </tr>
    <tr>  
    <td><input type="button" name="Submit2"  value="<?=LANG_est_mens_new?>" onClick="location.replace('crear.php');"><p></td>
    </tr>
     <tr>  
    <td>&nbsp;</td>
    </tr>
    </table>
    </td>
   </tr> 
   </table>
</body>
</html>
<?

$grid->cerrar();

?>