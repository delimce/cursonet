<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);


 $crear = new tools("db");


 	if(isset($_POST['nombre'])){

	 							  
				  $valores[0] = $_POST['nombre'];
				  $valores[1] = $_POST['grupo'];
				  $valores[2] = $_POST['nota'];
				  $valores[3] = $_POST['redondeo'];

				  $crear->insertar2("tbl_plan_evaluador","titulo,grupo_id,en_base,redondeo",$valores);
				  $id = $crear->ultimoID;
				  $crear->cerrar();
				   
				  $crear->javaviso(LANG_planes_created,"items.php?id=$id");

	}




?>
<html>
<head> <meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="../../css/style_back.css">

	<script language="JavaScript" type="text/javascript">

	


	function validar(){

	 if(document.form1.nombre.value==''){

			 alert('<?=LANG_planes_val_name ?>');
			 document.form1.nombre.focus();
		
			 return false;

	 }
	 
	 
	  if(document.form1.grupo.value==''){

			 alert('<?=LANG_group_noselect ?>');
			 document.form1.grupo.focus();
		
			 return false;

	 }
	 
	 
	   if( isNaN(document.form1.nota.value)|| document.form1.nota.value < 0  ){

			 alert('<?=LANG_eva_cal_value ?>');
			 document.form1.nota.focus();
		
			 return false;

	 }


	 
	 return true;

	}
	</script>


</head>

<body>
<table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="26" valign="top"><?php echo $menu->nombre; ?></td>
  </tr>
  <tr>
    <td><?php $menu->mostrar(1); ?></td>
  </tr>
  <tr>
    <td>

	<table style="border-right:#000000 solid 1px; border-left:#000000 solid 1px; border-bottom:#000000 solid 1px;" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><form name="form1" method="post" action="crear.php" onSubmit="return validar();">
<br>
<table width="100%" border="0" cellspacing="4" cellpadding="3">

  <tr>
    <td colspan="2" class="style1"><?php echo LANG_planes_1 ?></td>
  </tr>
  <tr>
    <td colspan="2" class="style1">&nbsp;</td>
    </tr>
  <tr>
    <td class="style3"><?php echo LANG_planes_name; ?></td>
    <td width="72%"><input name="nombre" type="text" id="nombre" size="45"></td>
  </tr>
  <tr>

    <td width="28%" class="style3"><?php echo LANG_planes_group; ?></td>
  <td><? echo $crear->combo_db("grupo","select id,nombre from tbl_grupo where curso_id = {$_SESSION['CURSOID']}","nombre","id",LANG_select,false,false,LANG_group_nogroup.'<input name="grupo" type="hidden" value="">'); ?></td>
</tr>

  <tr>
    <td class="style3"><?php echo LANG_planes_base ?></td>
    <td><input name="nota" type="text" id="nota" size="5" maxlength="5"></td>
  </tr>
  <tr>
    <td class="style3"><?php echo LANG_planes_round ?></td>
    <td><input name="redondeo" type="checkbox" id="redondeo" value="1"></td>
  </tr>
  <tr>
    <td colspan="2" class="style3">&nbsp;</td>
    </tr>

  <tr>
  <td colspan="2"><input type="button" name="Submit2" onClick="history.back();" value="<?=LANG_back?>">
  <input type="submit" name="Submit" value="<?=LANG_save?>"></td>
  </tr>
</table>
</form></td>
      </tr>
    </table>	</td>
  </tr>
</table>
</body>
</html>
