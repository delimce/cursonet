<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);

 $crear = new tools();
 $crear->autoconexion();
 
 
 $datos = $crear->simple_db("select titulo,en_base from plan_evaluador where id = {$_REQUEST['id']}");
 
 
 $tlabel = $crear->llenar_array("Foro,Proyecto,Evaluación,Otro");
 $tvalor = $crear->llenar_array("foro,proy,eval,otro");
 
 
 		if(!empty($_POST['nombre'])){
		
		
			  	  $valores[0] = $_POST['plan'];
				  $valores[1] = $_POST['nombre'];
				  $valores[2] = $_POST['tipo'];
				  $valores[3] = $_POST['actividad'];
				  $valores[4] = $_POST['nota'];
				  $valores[5] = $_POST['base'];

				  $crear->insertar2("plan_item","plan_id,titulo,tipo,id_act,porcentaje,en_base",$valores);
				  $crear->cerrar();
				  
				  ?>
                   <script language="javascript">
    
					window.opener.location.reload();
					window.close();
					
					</script>
                  
                  <?
		
		}
 
 

?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../../css/style_back.css">
<script type="text/javascript" src="../../js/ajax.js"></script>
	<script language="JavaScript" type="text/javascript">

	function mostar(valor){
	
		if(valor==""||valor=="otro")document.getElementById('acc').style.display='none'; else document.getElementById('acc').style.display='';
	
	}


	function validar(){

	 if(document.form1.nombre.value==''){

			 alert('<?=LANG_planes_val_namei ?>');
			 document.form1.nombre.focus();
		
			 return false;

	 }
	 
	 
	  if(document.form1.tipo.value==''){

			 alert('<?=LANG_planes_val_tipo ?>');
			 document.form1.tipo.focus();
		
			 return false;

	 }
	 
	 
	  if(document.form1.actividad.value==0 && document.form1.tipo.value!="otro"){

			 alert('<?=LANG_planes_val_acc ?>');
		
			 return false;

	 }
	 
	 
	   if( isNaN(document.form1.nota.value)== true || Number(document.form1.nota.value) <= 0 || document.form1.nota.value == ""  ){

			 alert('<?=LANG_eva_cal_value ?>');
			 document.form1.nota.focus();
		
			 return false;

	   }
	   
	   
	    if( isNaN(document.form1.base.value)== true || Number(document.form1.base.value) <= 0 || document.form1.base.value == ""  ){

			 alert('<?=LANG_planes_val_base ?>');
			 document.form1.base.focus();
		
			 return false;

	   }


	 
	 return true;

	}
	</script>


</head>

<body>


<form action="" method="post" name="form1" onSubmit="return validar();">

<table width="100%" border="0" cellspacing="4" cellpadding="3">
  <tr>
    <td colspan="2" class="td_whbk2"><?php echo LANG_planes_item_create ?> <?php echo LANG_planes_plan ?>:&nbsp;<span class="style3"><?php echo $datos['titulo'] ?></span></td>
  </tr>
  <tr>
    <td colspan="2" class="style1">&nbsp;</td>
  </tr>
  <tr>
    <td class="style3"><?php echo LANG_planes_item_name ?></td>
    <td width="72%"><input name="nombre" type="text" id="nombre" size="60"></td>
  </tr>
  <tr>
    <td width="28%" class="style3"><?php echo LANG_planes_item_type ?></td>
    <td><?php echo $crear->combo_array("tipo",$tlabel,$tvalor,LANG_select,false,"ajaxcombo('activ','actividad','iframe.php?tipo='+this.value,'activi','nombre','id'); mostar(this.value);",false); ?>&nbsp;</td>
  </tr>
  <tr id="acc" style="display:none">
    <td class="style3"><?php echo LANG_planes_act ?></td>
    <td>
    
    <div id ="activ">
      <input name="actividad" type="hidden" value="0">
   </div>    </td>
  </tr>
  <tr>
    <td class="style3"><?php echo LANG_foro_por ?></td>
    <td><input name="nota" type="text" id="nota" size="5" maxlength="5">
    % <span class="small">(<?php echo LANG_planes_por ?>)</span></td>
  </tr>
  <tr>
    <td class="style3"><?php echo LANG_planes_base ?></td>
    <td><input name="base" type="text" id="base" size="5" maxlength="5">&nbsp;<span class="small">(<?php echo LANG_planes_enbase ?>)</span></td>
  </tr>
  <tr>
    <td colspan="2" align="center" valign="top" class="style3"><input name="plan" type="hidden" id="plan" value="<?php echo $_REQUEST['id']; ?>"></td>
  </tr>
  <tr>
    <td colspan="2"><input type="button" name="Submit2" onClick="window.close();" value="<?=LANG_close ?>">
      <input type="submit" name="Submit" value="<?=LANG_save?>"></td>
  </tr>
</table>

</form>


</body>
</html>
<?php $crear->cerrar(); ?>
