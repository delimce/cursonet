<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../config/setup.php"); ////////setup
include("../../../class/clases.php"); ////////clase
include ("../../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);

 if(isset($_REQUEST['id'])) $_SESSION['PRO_ID2'] = $_REQUEST['id'];

 $prueba = new tools("db");
 $fecha = new fecha($_SESSION['DB_FORMATO']);


	 $queryd = "SELECT
	  concat(est.nombre, ' ', est.apellido) AS nombre,
	  eva.rec_id,
	  eva.correccion,
	  if(eva.nota = '-1', '', eva.nota) AS nota
	FROM
	  proyecto_estudiante eva inner join estudiante est
	  ON (est.id = eva.est_id)  
	  
	WHERE
	   eva.id = '{$_SESSION['PRO_ID2']}'";



  /////////////////////////guarda o consulta

 if(isset($_POST['nota'])){


        $campos[0] = "correccion"; $campos[1] = "nota";
		$vector[0] = $_POST['revi']; $vector[1] = $_POST['nota'];
 		$prueba->update("proyecto_estudiante",$campos,$vector,"id = '{$_SESSION['PRO_ID2']}'");
  	    
		
		//////////////////acompanamiento de proyectos
		include("acomp.php");
		
		
		//////////////////////////////////////////
		
		
		$prueba->cerrar();
		$prueba->javaviso(LANG_proy_saeval,"proys.php");
		
		


 }else{

	  $datos   = $prueba->array_query2($queryd);
	  $recurso = $prueba->array_query2("select dir,fecha from tbl_recurso where id = $datos[1]");
	  
 }

?>
<html>
<head>

<script language="JavaScript" type="text/javascript">
	function validar(){

		 if( isNaN(document.form1.nota.value)|| document.form1.nota.value < 0  ){

		 alert('<?=LANG_eva_cal_value ?>');
		 document.form1.nota.focus();

		 return false;

		 }else{

		 document.form1.submit();

		 }

	 }


	function popup(mylink, windowname){

	var alto = 160;
	var largo = 600;
	var winleft = (screen.width - largo) / 2;
	var winUp = (screen.height - alto) / 2;


	if (! window.focus)return true;
	  var href;
	  if(typeof(mylink) == 'string')
		href=mylink;
	  else
		href=mylink.href;
		window.open(href, windowname,'top='+winUp+',left='+winleft+'+,toolbar=0 status=1,resizable=0,Width='+largo+',height='+alto+',scrollbars=1');

	 return false;

	}




 </script>


<link rel="stylesheet" type="text/css" href="../../../css/style_back.css">
</head>

<body>

<form name="form1" method="POST" action="corregir.php">

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
        <td align="left"><table width="100%" border="0" cellspacing="4" cellpadding="3">
          <tr>
            <td colspan="4" class="style1"><b><?=LANG_est ?>
              &nbsp;</b><?=$datos[0] ?>
              &nbsp;</td>
            </tr>

		   <tr>
		     <td colspan="4" class="table_bk"><? echo LANG_proy_date_e;?></td>
		     </tr>
		   <tr>
		     <td colspan="4"><? echo $fecha->datetime($recurso[1]); ?></td>
		     </tr>
		   <tr>
            <td colspan="4" class="table_bk"><? echo LANG_proy_file;?></td>
          </tr>
          <tr>
            <td colspan="4" align="left"><a href="abrir.php?id=<?php echo $datos[1]  ?>" title="<?=LANG_download ?>"><?php echo $recurso[0]?></a></td>
          </tr>

		  <tr>
            <td colspan="4" align="left" class="td_whbk2"><b>
              <?=LANG_eva_revi ?>
            </b></td>
          </tr>
		  <tr>
		    <td colspan="4" align="center"><textarea name="revi" cols="93" rows="4" class="style1" id="revi"><?=stripslashes($datos[2]); ?></textarea></td>
		    </tr>
		  <tr>
		    <td width="14%" align="left" class="td_whbk2"><b>
		      <?=LANG_eva_cal ?>
		    </b></td>
		    <td colspan="3" align="left" class="td_whbk2"><input name="nota" type="text" id="nota" value="<?=$datos[3]?>" size="5" maxlength="4"></td>
		    </tr>
		  <tr>
		    <td colspan="4" align="left"><input name="b1" type="button" id="b1" onClick="javascript:location.replace('proys.php');"  value="<?=LANG_back?>">
              <input name="guarda" type="button" id="guarda" onClick="javascript:validar();" value="<?=LANG_save?>"></td>
		    </tr>

        </table>
          <br></td>
      </tr>
    </table>	</td>
  </tr>
</table>

</form>

</body>
</html>
<?php

 $prueba->cerrar();

?>