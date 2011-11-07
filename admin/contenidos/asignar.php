<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);


 
  $asig = new tools("db");
  
  if(isset($_REQUEST['ItemID'])){
  
   $files = $asig->estructura_db("select id,dir,descripcion from tbl_recurso where tipo = 0 and add_by = 'admin'");
   $links = $asig->estructura_db("select id,dir,descripcion from tbl_recurso where tipo = 1 and add_by = 'admin'");
   $vid   = $asig->estructura_db("select id,dir,descripcion from tbl_recurso where tipo = 2 and add_by = 'admin'");
 
   $arselect = $asig->array_query("select recurso_id from tbl_contenido_recurso where contenido_id = '{$_REQUEST['ItemID']}' and tipo = 0"); //archivos
   $linkselect = $asig->array_query("select recurso_id from tbl_contenido_recurso where contenido_id = '{$_REQUEST['ItemID']}' and tipo = 1"); //enlaces
   $vidselect = $asig->array_query("select recurso_id from tbl_contenido_recurso where contenido_id = '{$_REQUEST['ItemID']}' and tipo = 2"); //videos
  
  }
  
  
  if(isset($_POST['id'])){
  
      $asig->query("SET AUTOCOMMIT=0"); ////iniciando la transaccion
      $asig->query("START TRANSACTION");
  
	  $asig->query("delete from tbl_contenido_recurso where contenido_id = '{$_POST['id']}'");
	  
	  $valores[0] = $_POST['id'];
	  
	  
  
	  for($i=0;$i<count($_POST['archi']);$i++){
	    $valores[1] = $_POST['archi'][$i];
	    $valores[2] = 0;
	  	$asig->insertar2("tbl_contenido_recurso","contenido_id, recurso_id, tipo",$valores);
	  }
	  
	  
	  for($j=0;$j<count($_POST['enlace']);$j++){
	  
	    $valores[1] = $_POST['enlace'][$j];
	    $valores[2] = 1;
	  	$asig->insertar2("tbl_contenido_recurso","contenido_id, recurso_id, tipo",$valores);
	  
	  }
	  
	  
	   for($z=0;$z<count($_POST['videos']);$z++){
	  
	    $valores[1] = $_POST['videos'][$z];
	    $valores[2] = 2;
	  	$asig->insertar2("tbl_contenido_recurso","contenido_id, recurso_id, tipo",$valores);
	  
	  }
	  
  
     $asig->query("COMMIT"); 
	 
	 $asig->javaviso(LANG_cambios,"recursos.php");
	 
  
  }


?>
<html>
<head>
		
<link rel="stylesheet" type="text/css" href="../../css/style_back.css">
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
      
	   <td>
		<form name="form1" method="post" action="asignar.php">
          <table width="100%" height="104" border="0" cellpadding="3" cellspacing="4" class="style1">
		    <tr>
              <td colspan="2">		    </tr>
		    <tr>
		      <td colspan="2" class="small">Nota: debe haber cargado los	recursos	antes de asignarlos a los temas, Para cargar recursos <a href="../recursos/index.php">presione AQUI</a>		    </tr>
	       <tr>
              <td colspan="2" class="table_bk"><?=LANG_content_files2 ?></td>
           </tr>
		   
		   <?php 
		   
		   for($i=0;$i<count($files);$i++){
		   
		   ?>
		   
		   
            <tr>
              <td width="6%" class="style1"><input name="archi[]" type="checkbox" id="archi[]" value="<?=$files[$i]['id']?>" <?php if(@in_array($files[$i]['id'],$arselect))echo 'checked="checked"'; ?>></td>
              <td width="94%" class="style1"><b><?=substr($files[$i]['dir'], 0, 70);?></b><br>
                <?=$files[$i]['descripcion'];?></td>
              </tr>
			<?php 
			
			}
			
			?>
			  
            <tr>
              <td colspan="2" class="table_bk"><?=LANG_content_links ?>&nbsp;</td>
            </tr>
			
			
		  <?php 
		   
		  for($j=0;$j<count($links);$j++){ 
		   
		   ?>
			
            <tr>
              <td class="style1"><input name="enlace[]" type="checkbox" id="enlace[]" value="<?=$links[$j]['id']?>" <?php if(@in_array($links[$j]['id'],$linkselect))echo 'checked="checked"'; ?>></td>
              <td class="style1"><b><?=substr($links[$j]['dir'], 0, 70);?></b>&nbsp;<br>
                <?=$links[$j]['descripcion'];?></td>
              </tr>
			
			<?php 
			
			}
			
			?>
			
			
			  
            <tr>
              <td colspan="2" class="table_bk"><?=LANG_content_video ?>&nbsp;</td>
            </tr>
			
			
		  <?php 
		   
		  for($j=0;$j<count($vid);$j++){ 
		   
		   ?>
			
            <tr>
              <td class="style1"><input name="videos[]" type="checkbox" id="videos[]" value="<?=$vid[$j]['id']?>" <?php if(@in_array($vid[$j]['id'],$vidselect))echo 'checked="checked"'; ?>></td>
              <td class="style1"><b><?=substr($vid[$j]['dir'], 0, 70);?></b>&nbsp;<br>                <?=$vid[$j]['descripcion'];?></td>
              </tr>
			
			<?php 
			
			}
			
			?>
			
			
			
            <tr>
              <td colspan="2"><input type="button" name="Submit2"  value="<?=LANG_back?>" onClick="javascript:history.back();">
                <input type="submit" name="Submit" value="<?=LANG_save?>">
                <input name="id" type="hidden" id="id" value="<?=$_REQUEST['ItemID']?>"></td>
              </tr>
          </table>
          
          </form>
          </td>
      </tr>
    </table>	</td>
  </tr>
</table>
</body>
</html>

<?php 

 $asig->cerrar();

?>
