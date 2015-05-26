<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../../config/setup.php"); ////////setup
include("../../../../class/clases.php"); ////////clase
include ("../../../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);

  $pru = new tools("db");

  $query = " select e.nombre, c.titulo as caso, IFNULL((select nombre from tbl_grupo where id = e.grupo_id),'Todas') as seccion, date_format(e.fecha,'{$_SESSION['DB_FORMATO_DB']} %h:%i %p') as fecha
  			from tbl_evaluacion e inner join tbl_contenido c on (e.contenido_id = c.id and e.id = {$_REQUEST['id']})";

 $datos = $pru->array_query2($query);

?>
<html>
<head> <meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="../../../../css/style_back.css">
</head>

<body>

<form name="form1" method="post" action="">

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
        <td><br>
          <table width="100%" border="0" cellspacing="2" cellpadding="2">
            <tr>
              <td width="18%" valign="top" class="style3"><?php echo LANG_eva_name; ?></td>
              <td width="34%" valign="top" class="style1"><?=$datos[0] ?>&nbsp;</td>
              <td width="15%" valign="top" class="style3"><?php echo LANG_seccion; ?></td>
              <td width="33%" valign="top" class="style1"><?=$datos[2] ?></td>
            </tr>
            <tr>
              <td valign="top" class="style3"><?php echo LANG_content_name; ?></td>
              <td valign="top" class="style1"><?=$datos[1] ?></td>
              <td colspan="2" valign="top" class="style1"><span class="style3"><?php echo LANG_eva_fechae ?></span>&nbsp; <?=$datos[3] ?></td>
              </tr>
            <tr>
              <td class="td_whbk2" colspan="4"><span class="style1">
                <?=LANG_eva_questions ?>
              </span></td>
              </tr>
            
			
		<?php 
		
		$query2 = "SELECT pregunta FROM tbl_evaluacion_pregunta e where eval_id = {$_REQUEST['id']}";
		$pru->query($query2);
		$i=1;
		while ($row = mysqli_fetch_array($pru->result)) {
		
		?>	
			
            <tr>
              <td class="style3" colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><? echo LANG_eva_question; echo $i; ?></td>
                    </tr>
                </table></td>
            </tr>
					
            <tr>
              <td colspan="4">
                <textarea name="pru_<?=$i ?>" cols="80" rows="6" class="style1" id="pru_<?=$i ?>"><?=$row[0]; ?>
		        </textarea></td>
            </tr>
			  
		<?php
		
		$i++;
		
		 } ?>
		
			  
            <tr>
              <td colspan="4"><input name="b1" type="button" id="b1" onClick="history.back();"  value="<?=LANG_back?>"></td>
              </tr>
            <tr>
              <td colspan="4">&nbsp;</td>
              </tr>
          </table></td>
      </tr>
    </table>	</td>
  </tr>
</table>

</form>
</body>
</html>
<?php
 $pru->liberar();
 $pru->cerrar();

?>