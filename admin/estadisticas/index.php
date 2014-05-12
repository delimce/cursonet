<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);

	$est = new tools("db");
	/////////////data general
	$query1 = " select
	(select count(*) from tbl_log_est) as vs,
	(select count(distinct est_id) from tbl_log_est) as vi,
	(select sum(ndescargas) from tbl_log_est) as des
	               ";

	$data_general = $est->array_query2($query1);

	/////// 
 
?>
<html>
<head> <meta charset="utf-8">
<script type="text/javascript" src="../../js/calendario/calendar.js"></script>
<script type="text/javascript" src="../../js/calendario/calendar-es.js"></script>
<script type="text/javascript" src="../../js/calendario/calendar-setup.js"></script>
<script type="text/javascript" src="../../js/popup.js"></script>
<script type="text/javascript" src="../../js/ajax.js"></script>	
 <LINK href="../../js/calendario/calendario.css" type=text/css rel=stylesheet>	
 
<link rel="stylesheet" type="text/css" href="../../css/style_back.css">








<script language="JavaScript" type="text/javascript">


	function fecha_rango(){
	
		oXML = AJAXCrearObjeto();
		oXML.open('post', 'rango.php');
		oXML.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		oXML.onreadystatechange = function(){
			if (oXML.readyState == 4 && oXML.status == 200) {
			
				document.getElementById("vtotal").innerHTML = oXML.responseText;
					
				vaciar(oXML);
			   
			}
		 }
	
		oXML.send('desde='+document.getElementById("fecha_desde").value+'&hasta='+document.getElementById("fecha_hasta").value); 
	}
	



	function info_est(id){
	
		oXML = AJAXCrearObjeto();
		oXML.open('post', 'est.php');
		oXML.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		oXML.onreadystatechange = function(){
			if (oXML.readyState == 4 && oXML.status == 200) {
			
				 var xml  = oXML.responseXML.documentElement; ///devuelve parseado el documento dentro de una var
				totale.innerHTML = xml.getElementsByTagName('totalv')[0].firstChild.data; 
				fechault.innerHTML  = xml.getElementsByTagName('ultimav')[0].firstChild.data; 
				configc.innerHTML  = xml.getElementsByTagName('cliente')[0].firstChild.data; 
				descargasr.innerHTML  = xml.getElementsByTagName('desc')[0].firstChild.data; 
				contenidor.innerHTML  = xml.getElementsByTagName('conte')[0].firstChild.data; 
					
				vaciar(oXML);
			   
			}
		 }
	
		oXML.send('id='+id); 
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
          <table width="100%" border="0" cellspacing="3" cellpadding="2">
          <tr>
          <td colspan="6" class="table_bk"><?=LANG_esta_general ?></td>
        </tr>
          <tr>
          <td width="24%" class="style3">
            <?= LANG_esta_estvtotal ?>
          </td>
          <td width="22%" class="style1"><?=$data_general[0] ?></td>
          <td colspan="2" class="style3">
            <?= LANG_esta_estvisite ?>
          </td>
          <td colspan="2" class="style1">
            <?=$data_general[1]   ?>
          </td>
          </tr>
          <tr>
          <td class="style3">
            <?= LANG_esta_downloads ?>
          </td>
          <td class="style1"> <?=$data_general[2]   ?></td>
          <td class="style3">&nbsp;</td>
          <td class="style3">&nbsp;</td>
          <td colspan="2" class="style1">&nbsp;</td>
        </tr>
          <tr>
          <td class="style3">&nbsp;</td>
          <td class="style3">&nbsp;</td>
          <td class="style3">&nbsp;</td>
          <td class="style3">&nbsp;</td>
          <td colspan="2" class="style1">&nbsp;</td>
        </tr>
          <tr>
          <td class="style3">
            <?= LANG_broser ?>
          </td>
          <td class="style3">Firefox</td>
          <td width="25%" class="style3">MSIE</td>
          <td width="15%" class="style3"><?=LANG_others?></td>
          <td colspan="2" class="style1">&nbsp;</td>
        </tr>
          <tr>
          <td class="style3">
            <?= LANG_os ?>
          </td>
          <td class="style3">GNU Linux </td>
          <td class="style3">MS Windows </td>
          <td class="style3">
            <?=LANG_others?>
          </td>
          <td colspan="2" class="style1">&nbsp;</td>
        </tr>
          <tr>
          <td colspan="6" class="table_bk">
            <?= LANG_esta_daterango ?>
          </td>
          </tr>
          <tr>
          <td colspan="4" valign="middle" class="style3">
            <?= LANG_from ?>
            
            <input name="fecha_desde" type="text" id="fecha_desde" onFocus="this.blur()" onClick="alert('<?=LANG_calendar_use?>')" size="12">
            <img src="../../images/frontend/cal.gif" name="f_trigger_d" width="16" height="16" id="f_trigger_d" style="cursor: hand; border: 0px;" title="<?=LANG_calendar?>">&nbsp;
            <script type="text/javascript">
                                        Calendar.setup({
                                                inputField     :    "fecha_desde",     // id of the input field
                                                ifFormat       :    "<?=strtolower($_SESSION['DB_FORMATO'])?>",    // format of the input field
                                                button         :    "f_trigger_d",  // trigger for the calendar (button ID)
                                                singleClick    :    true
                                        });
                                </script>
          
            <?= LANG_to ?>
          
            <input name="fecha_hasta" type="text" id="fecha_hasta" onFocus="this.blur()" onClick="alert('<?=LANG_calendar_use?>')" size="12">
            <img src="../../images/frontend/cal.gif" name="f_trigger_e" width="16" height="16" id="f_trigger_e" style="cursor: hand; border: 0px;" title="<?=LANG_calendar?>">
            <script type="text/javascript">
                                        Calendar.setup({
                                                inputField     :    "fecha_hasta",     // id of the input field
                                                ifFormat       :    "<?=strtolower($_SESSION['DB_FORMATO'])?>",    // format of the input field
                                                button         :    "f_trigger_e",  // trigger for the calendar (button ID)
                                                singleClick    :    true
                                        });
                                </script>
          &nbsp;
          <input type="button" name="Button" value="<?=LANG_show?>" onClick="fecha_rango();">
          </td>
          <td width="5%" class="style1"><span class="style3">
            <?= LANG_total ?>
          </span></td>
          <td width="9%" class="style1">
            <div id="vtotal">0</div>
          </td>
          </tr>
          <tr>
          <td colspan="6" valign="middle" class="table_bk">
            <?= LANG_esta_est ?>
          </td>
          </tr>
          <tr>
          <td valign="middle" class="style3">
            <?= LANG_esta_est_select ?>
          </td>
          <td colspan="5" valign="middle" class="style1"><?php echo $est->combo_db("est","select id,concat(nombre,' ',apellido,' - ',id_number) as nombre from tbl_estudiante order by nombre,id_number","nombre","id",LANG_select,false,"info_est(this.value)",LANG_modo_noest);?></td>
          </tr>
          <tr>
          <td valign="middle" class="style3">
            <?= LANG_esta_estvtotal ?>
          </td>
          <td valign="middle">
            <div class="style1" id="totale">-</div>
          </td>
          <td valign="middle" class="style3">
            <?= LANG_esta_ultvisit ?>
          </td>
          <td colspan="3" valign="middle">
            <div class="style1" id="fechault">-</div>
          </td>
          </tr>
          <tr>
          <td valign="middle" class="style3">
            <?= LANG_esta_configclient ?>
          </td>
          <td colspan="5" valign="middle">&nbsp;
            
          </td>
          </tr>
          <tr>
          <td colspan="6" valign="middle"><div class="style1" id="configc">&nbsp;</div>
          </td>
          </tr>
          <tr>
          <td valign="middle" class="style3">
            <?= LANG_esta_downloads ?>
          </td>
          <td colspan="5" valign="middle" class="style3">&nbsp;</td>
        </tr>
          <tr>
          <td colspan="6" valign="middle"><div class="style1" id="descargasr">&nbsp;</div>
          </td>
          </tr>
          <tr>
          <td valign="middle" class="style3">
            <?= LANG_esta_contvistos ?>
          </td>
          <td colspan="5" valign="middle" class="style3">&nbsp;</td>
        </tr>
          <tr>
          <td colspan="6" valign="middle"><div class="style1" id="contenidor">&nbsp;</div></td>
          </tr>
        </table>
          <br>&nbsp;</td>
      </tr>
    </table>	</td>
  </tr>
</table>
</body>
</html>
<?php 

	$est->cerrar();

?>
