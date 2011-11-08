<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../config/setup.php"); ////////setup
include("../../../class/clases.php"); ////////clase
include ("../../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);

  $pru = new tools("db");


  $seccion = $pru->simple_db("select grupo from tbl_proyecto where id = '{$_GET['id']}'");
  if($seccion>0) $filtro = "and grupo_id = $seccion"; else $filtro = "";


  $query = " SELECT concat(e.nombre,' ',e.apellido,' - ',id_number) as nombre2,
  					ifnull((select id from tbl_proyecto_estudiante where proy_id = '{$_GET['id']}' and est_id = e.id limit 1 ),'NO') as presento,
					ifnull((select nota from tbl_proyecto_estudiante where proy_id = '{$_GET['id']}' and est_id = e.id limit 1),'NO') as revision
					FROM tbl_estudiante e where e.id in (select est_id from tbl_grupo_estudiante where curso_id = {$_SESSION['CURSOID']} $filtro ) order by nombre2";


	$pru->query($query);


?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="../../../css/style_back.css">
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
        <td><br>
          <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td class="table_bk">


			  <?php if($pru->nreg>0){?>

			  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1">
                <tr>
                  <td width="61%" align="center" class="table_bk"><?=LANG_est?></td>
                  <td width="14%" align="center" class="table_bk"><?=LANG_eva_following_pp?></td>
                  <td width="15%" align="center" class="table_bk"><?=LANG_eva_following_eval?></td>
                  <td width="10%" align="center" class="table_bk"><?=LANG_eva_following_nota?></td>
                </tr>

		<?php while ($row = $pru->db_vector_nom($pru->result)) { ?>

                <tr>
                  <td bgcolor="#FFFFFF" class="style1"><?=$row['nombre2']?></td>
                  <td align="center" bgcolor="#FFFFFF">
                    <? if($row['presento']!='NO') echo '<img src="../../../images/backend/checkmark.gif" width="11" height="13">'; else echo '<img src="../../../images/backend/x.gif" width="14" height="16">'; ?>
                  </td>
                  <td align="center" bgcolor="#FFFFFF">
				  <? if($row['revision']!='NO' && $row['revision']>-1) echo '<img src="../../../images/backend/checkmark.gif" width="11" height="13">'; else echo '<img src="../../../images/backend/x.gif" width="14" height="16">'; ?>
				  </td>
                  <td align="center" bgcolor="#FFFFFF">
				   <? if($row['revision']!='NO' && $row['revision']>-1) echo $row['revision']; else echo '<img src="../../../images/backend/x.gif" width="14" height="16">'; ?>
				  </td>
                </tr>


				<?php

				}

				 ?>


              </table>

			  <?php }else{


			  echo LANG_noresutlts2;

			  }?>

			  </td>
            </tr>
			 <tr>
              <td><br>
                <input type="button" name="Submit2" onClick="history.back();" value="<?=LANG_back?>"></td>
            </tr>
          </table>
          <br></td>
      </tr>
    </table>	</td>
  </tr>
</table>

</body>
</html>

<?php

 $pru->cerrar();

?>
