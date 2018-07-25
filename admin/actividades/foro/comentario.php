<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../config/setup.php"); ////////setup
include("../../../class/clases.php"); ////////clase
include ("../../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);

$crear = new tools('db');

?>

<!DOCTYPE html>
<html>
<head> <meta charset="utf-8">
<script language="JavaScript" type="text/javascript" src="../../../js/ajax.js"></script>

	<script language="JavaScript" type="text/javascript">
	function cambio(){
	
	var caso = document.getElementById("caso");
	var grupo = document.getElementById("grupo");
	var numero = document.getElementById("num");
	var nuevo = document.getElementById("new");
	var borro = document.getElementById("borron");
	
	
	//alert(document.form1.foro.value);
	
	oXML = AJAXCrearObjeto();
	oXML.open('get', 'info.php?id='+document.form1.foro.value);
	oXML.onreadystatechange = function(){
		if (oXML.readyState == 4 && oXML.status == 200) {
		     var xml  = oXML.responseXML.documentElement; ///devuelve parseado el documento dentro de una var
			grupo.innerHTML = xml.getElementsByTagName('grupo')[0].firstChild.data; 
			caso.innerHTML  = xml.getElementsByTagName('caso')[0].firstChild.data; 
			numero.innerHTML  = xml.getElementsByTagName('numero')[0].firstChild.data; 
			nuevo.innerHTML  = xml.getElementsByTagName('nuevos')[0].firstChild.data; 
			document.getElementById("foroid").value = xml.getElementsByTagName('foroid')[0].firstChild.data; 
           vaciar(oXML);
		}
	 }

	borro.style.display = '';
	oXML.send(null); 
	
	
	
	}
		
	</script>

	
<script language="JavaScript" type="text/javascript">
	function enviar(par){
	

		if(document.form1.foro.value==""){
		
			alert('<?=LANG_foro_tema ?>');
			return false;
		
		}
		
		if(par==1){ document.form1.action = "vercoment.php";
		}else{ document.form1.action = "agregar.php"; 
		}
		
		document.form1.submit();
		return true;
	
	
	}
</script>



<link rel="stylesheet" type="text/css" href="../../../css/style_back.css">
</head>

<body <?php if($_SESSION['tema_id']!='') echo 'onLoad="cambio();"'; ?>>

<form name="form1" method="get" action="">

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
      <tr>
        <td>
		
		<table width="100%" border="0" cellpadding="3" cellspacing="4">
          <tr>
            <td width="24%" class="style3">Seleccione un foro</td>
            <td height="10" colspan="2" class="style1"><?php echo $crear->combo_db("foro","select IF(LENGTH(titulo)>65,concat(SUBSTRING(titulo,1,65),'...'),titulo) as titulo,id from tbl_foro where curso_id = {$_SESSION['CURSOID']}","titulo","id",LANG_select,$_SESSION['tema_id'],"cambio();",'<input name="foro" type="hidden" id="tema" />'.LANG_foro_noitem); ?></td>
          </tr>
          <tr>
            <td><span class="style3"><?php echo LANG_group_nombre; ?></span></td>
            <td height="10" colspan="2" nowrap><div class="style1" id="grupo">
             &nbsp;
            </div></td>
          </tr>
          <tr>
            <td><span class="style3"><?php echo LANG_content_name; ?></span></td>
            <td height="10" colspan="2" nowrap><div class="style1" id="caso">
            &nbsp;
            </div></td>
          </tr>
          <tr>
            <td><span class="style3"><?php echo LANG_foro_n_comm ?></span></td>
            <td height="10" colspan="2" nowrap><div class="style1" id="num"> &nbsp; </div></td>
          </tr>
          <tr>
            <td><span class="style3"><?php echo LANG_foro_comunread ?></span></td>
            <td height="10" colspan="2" nowrap class="style1"><div class="style1" id="new"> &nbsp; </div></td>
          </tr>
          
          <tr>
            <td colspan="3"><input type="button" name="Button" value="<?=LANG_foro_ver ?>" onClick="enviar(1);">&nbsp;<input type="button" name="Button" value="<?=LANG_foro_crear_comm?>" onClick="enviar(2);">
              &nbsp;
            	<span id="borron" style="display:none">
              <input onClick="if (confirm('<?=LANG_foro_deleteallqt ?>')) {
              					 ajaxsend('post','borrartodos.php','id='+document.getElementById('foroid').value); 
                                 document.getElementById('num').innerHTML = '0';
                                 document.getElementById('new').innerHTML = '0';
                               }" type="button" name="button" id="button" value="<?=LANG_foro_deleteall ?>">
              <input type="hidden" name="foroid" id="foroid"></td>
           		</span>
            </tr>
        </table>
          <br>&nbsp;
          
         
          </td>
      </tr>
    </table></td>
  </tr>
</table>

 </form>


</body>
</html>

<? $crear->cerrar(); ?>
