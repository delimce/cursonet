<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);


 
  $asig = new tools("db");
  
  if(isset($_REQUEST['ItemID'])) $asig->query("select id,concat(nombre,' ',apellido) as nombre,id_number,concat(nivel,' ',carrera,' ',universidad) as extra,(select grupo_id from grupo_estudiante where est_id = ee.id and curso_id = {$_SESSION['CURSOID']} ) as grupo from estudiante ee
  where id in (select est_id from grupo_estudiante where curso_id = {$_SESSION['CURSOID']} and grupo_id = {$_REQUEST['ItemID']} ) or id not in (select est_id from grupo_estudiante where curso_id = {$_SESSION['CURSOID']}) order by id ");
  
  if(isset($_POST['select']) or isset($_POST['id'])){
  
      $asig->query("SET AUTOCOMMIT=0"); ////iniciando la transaccion
      $asig->query("START TRANSACTION");
  
	  $asig->query("delete from grupo_estudiante where curso_id = {$_SESSION['CURSOID']} and grupo_id = '{$_POST['id']}'");
	  
  
	 	 if(count($_POST['select'])>0){
		 
		 $valores[1] = $_SESSION['CURSOID'];
		 $valores[2] = $_POST['id'];
		 
			 for($z=0;$z<count($_POST['select']);$z++){
			 
				 $valores[0] = $_POST['select'][$z];
			     $asig->insertar2("grupo_estudiante","est_id, curso_id, grupo_id",$valores);
			 
			 }
	  	 
		 }
	 
  
     $asig->query("COMMIT"); 
	 
	 $asig->javaviso(LANG_cambios,"ubicar.php");
	 
  
  }


?>
<html>
<head>

 <script language="javascript">
		function CheckAll()
		{
	    	len = document.form1.elements.length;
	        var i;
	        for (i=0; i < len; i++) 
			{
	        	if (document.form1.elements[i].checked==true) 
				{
	        		document.form1.elements[i].checked=false;
	        	}else
				{
	        		document.form1.elements[i].checked=true;
	        	}
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
    <td><?php $menu->mostrar(2); ?></td>
  </tr>
  <tr>
    <td>
	
	<table style="border-right:#000000 solid 1px; border-left:#000000 solid 1px; border-bottom:#000000 solid 1px;" width="100%" border="0" cellspacing="0" cellpadding="0">
      
	   <td>
		<form name="form1" method="post" action="<?=$PHP_SELF ?>">
          <table width="100%" height="104" border="0" cellpadding="3" cellspacing="4" class="style1">
		   
			 <?php 
			  /////////si no existen registros
			  if($asig->nreg==0){ echo '<p style="margin-left:15;">'.LANG_group_nostudent;
			  
			  }else{
			  
			  
			  ?>
		   <tr>
            <td colspan="4"><div class="style3" style="cursor: hand; margin-left:5;" onClick="javascript:CheckAll();"><?=LANG_select_all?></div></tr>
	       <tr> 
			  <?
			  
			  while ($row = mysql_fetch_assoc($asig->result)) {
			  
			 ?>
		  
            <tr>
              <td width="6%" class="style1"><input name="select[]" type="checkbox" id="select[]" value="<?=$row['id']?>" <?php if($_REQUEST['ItemID']==$row['grupo'])echo 'checked="checked"'; ?>></td>
              <td width="34%" class="style1"><?=$row['nombre'];?></td>
              <td width="17%" class="style1"><?=$row['id_number'];?></td>
              <td width="43%" class="style1"><?=$row['extra'];?></td>
            </tr>
			
			<?php 
			
				}
			
			}
			
			?>
			
            <tr>
              <td colspan="4"><input type="button" name="Submit2"  value="<?=LANG_back?>" onClick="javascript:history.back();">
               <?php if($asig->nreg>0){ ?> <input type="submit" name="Submit" value="<?=LANG_save?>"><?php } ?>
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
