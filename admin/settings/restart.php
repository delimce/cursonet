<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);
include("security.php"); ///seguridad para el admin

 $modo = new tools("db");
 $valores = $modo->array_query2("select 
 
 (select count(*) from tbl_estudiante),
 (select count(*) from tbl_grupo),
 (select count(*) from tbl_contenido),
 (select count(*) from tbl_foro), 
 (select count(*) from tbl_evaluacion),
 (select count(*) from tbl_proyecto),
 (select count(*) from tbl_mensaje_est),
 (select count(*) from tbl_mensaje_admin),
 (select count(*) from tbl_recurso where add_by = 'admin'),
 (select count(*) from tbl_plan_evaluador),
 (select count(*) from tbl_evaluacion_pregunta where tipo = 1),
 (select count(*) from tbl_log_est)
 
 ");




?>
<html>
<head> <meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="../../css/style_back.css">
<script language="JavaScript" type="text/javascript" src="../../js/ajax.js"></script>
<script type="text/javascript">
<!--
function resetea(tabla,nombre) {
	var answer = confirm("<?=LANG_RES_rusure?> "+nombre);
	if (answer){
		
		
		oXML = AJAXCrearObjeto();
		oXML.open('post', 'vaciat.php');
		oXML.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		oXML.onreadystatechange = function(){
			if (oXML.readyState == 4 && oXML.status == 200) {


				vaciar(oXML);

			}
		}

		oXML.send('table='+tabla);
		alert(tabla+" <?=LANG_RES_deleted?>");
		location.replace('restart.php');
		
		
		

	}
	
}
//-->
</script>

</head>

<body>
<table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="26" valign="top"><?php echo $menu->nombre; ?></td>
  </tr>
  <tr>
    <td><?php $menu->mostrar(5); ?></td>
  </tr>
  <tr>
    <td>
	
	<table style="border-right:#000000 solid 1px; border-left:#000000 solid 1px; border-bottom:#000000 solid 1px;" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
		
		<table width="99%" border="0" align="center" cellpadding="3" cellspacing="4">
		  <tr>
		    <td colspan="3">&nbsp;</td>
		    </tr>
		  <tr class="no_back">
			<td colspan="2" class="style3"><?php echo LANG_PREF_restart ?></td>
			<td align="center" width="16%" class="style3"><?php echo LANG_nreg?></td>
			</tr>
		  <tr>
			<td width="22%" class="style3"><span class="style1" style="cursor:pointer" onClick="resetea('tbl_estudiante','<?=LANG_RES_stutable?>?');"><?php echo LANG_RES_stutable ?></span></td>
			<td width="62%" class="style1"><?php echo LANG_RES_stutable_des ?></td>
			<td align="center" width="16%" class="style1"><div id="estudiante"><?php echo $valores[0]; ?></div></td>
		  </tr>
		  
		   <tr>
			<td width="22%" class="style3"><span class="style1" style="cursor:pointer" onClick="resetea('tbl_grupo','<?=LANG_RES_group?>?');"><?php echo LANG_RES_group ?></span></td>
			<td width="62%" class="style1"><?php echo LANG_RES_group_des ?></td>
			<td align="center" width="16%" class="style1"><div id="grupo"><?php echo $valores[1]; ?></div></td>
		  </tr>
		  
		  <tr>
			<td class="style3"><span class="style1" style="cursor:pointer" onClick="resetea('tbl_contenido','<?=LANG_RES_content?>?');"><?php echo LANG_RES_content ?></span></td>
			<td class="style1"><?php echo LANG_RES_content_des ?></td>
			<td align="center" class="style1"><div id="contenido"><?php echo $valores[2]; ?></div></td>
		  </tr>
		  <tr>
		    <td colspan="3" class="style3">&nbsp;</td>
		    </tr>
		  <tr>
		    <td class="style3"><span class="style1" style="cursor:pointer" onClick="resetea('tbl_foro','<?=LANG_RES_foro?>?');"><?php echo LANG_RES_foro ?></span></td>
		    <td class="style1"><?php echo LANG_RES_foro_des ?></td>
		    <td align="center" class="style1"><div id="foro"><?php echo $valores[3]; ?></div></td>
		    </tr>
		  <tr>
		    <td class="style3"><span class="style1" style="cursor:pointer" onClick="resetea('tbl_evaluacion_pregunta','<?=LANG_RES_eva ?>?');"><?php echo LANG_RES_eva ?></span></td>
		    <td class="style1"><?php echo LANG_RES_eva_des ?></td>
		    <td align="center" class="style1"><div id="evaluacion"><?php echo $valores[4]; ?></div></td>
		    </tr>
		  <tr>
		    <td class="style3"><span class="style1" style="cursor:pointer" onClick="resetea('tbl_evaluacion_pregunta','<?=LANG_RES_sel ?>?');"><?php echo LANG_RES_sel ?></span></td>
		    <td class="style1"><?php echo LANG_RES_sel_des ?></td>
		    <td align="center" class="style1"><div id="evaluacion_pregunta"><?php echo $valores[10]; ?></div></td>
		    </tr>
		  <tr>
		    <td class="style3"><span class="style1" style="cursor:pointer" onClick="resetea('tbl_proyecto','<?=LANG_RES_proy?>?');"><?php echo LANG_RES_proy ?></span></td>
		    <td class="style1"><?php echo LANG_RES_proy_des ?></td>
		    <td align="center" class="style1"><div id="proyecto"><?php echo $valores[5]; ?></div></td>
		    </tr>
		  <tr>
		    <td colspan="3" class="style3">&nbsp;</td>
		    </tr>
		  <tr>
		    <td class="style3"><span class="style1" style="cursor:pointer" onClick="resetea('tbl_mensaje_est','<?=LANG_RES_mest?>?');"><?php echo LANG_RES_mest ?></span></td>
		    <td class="style1"><?php echo LANG_RES_mest_des ?></td>
		    <td align="center" class="style1"><div id="mensaje_est"><?php echo $valores[6]; ?></div></td>
		    </tr>
		  <tr>
		    <td class="style3"><span class="style1" style="cursor:pointer" onClick="resetea('tbl_mensaje_admin','<?=LANG_RES_madmin?>?');"><?php echo LANG_RES_madmin ?></span></td>
		    <td class="style1"><?php echo LANG_RES_madmin_des ?></td>
		    <td align="center" class="style1"><div id="mensaje_admin"><?php echo $valores[7]; ?></div></td>
		    </tr>
		  <tr>
		    <td colspan="3" class="style3">&nbsp;</td>
		    </tr>
		  <tr>
		    <td class="style3"><span class="style1" style="cursor:pointer" onClick="resetea('tbl_recurso','<?=LANG_RES_rec?>?');"><?php echo LANG_RES_rec ?></span></td>
		    <td class="style1"><?php echo LANG_RES_rec_del ?></td>
		    <td align="center" class="style1"><?php echo $valores[8]; ?></td>
		  </tr>
		  <tr>
		    <td class="style3"><span class="style1" style="cursor:pointer" onClick="resetea('tbl_plan_evaluador','<?=LANG_RES_plan?>?');"><?php echo LANG_RES_plan ?></span></td>
		    <td class="style1"><?php echo LANG_RES_plan_del ?></td>
		    <td align="center" class="style1"><?php echo $valores[9]; ?></td>
		    </tr>
		  <tr>
		    <td colspan="3" class="style1">&nbsp;</td>
		    </tr>
            <tr>
		    <td class="style3"><span class="style1" style="cursor:pointer" onClick="resetea('tbl_log_est','<?php echo LANG_RES_loges ?>?');"><?php echo LANG_RES_loges ?></span></td>
		    <td class="style1"><?php echo LANG_RES_loges_del ?></td>
		    <td align="center" class="style1"><?php echo $valores[11]; ?></td>
		  </tr>
          <tr>
		    <td colspan="3" class="style1">&nbsp;</td>
		    </tr>
		</table>
		
		
		</td>
      </tr>
    </table>	</td>
  </tr>
</table>
</body>
</html>
<?php 

$modo->cerrar();

?>
