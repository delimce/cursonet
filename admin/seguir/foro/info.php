<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../config/setup.php"); ////////setup
include("../../../class/clases.php"); ////////clase
include ("../../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);

  $pru = new tools('db');

  $seccion = $pru->simple_db("select grupo_id from tbl_foro where id = '{$_GET['id']}'");
  if($seccion>0) $filtro = "and grupo_id = $seccion"; else $filtro = "";


  $query = " SELECT concat(e.apellido,' ',e.nombre,' - ',id_number) as nombre2,
  					(select count(*) from tbl_foro_comentario where foro_id = '{$_GET['id']}' and tipo_sujeto = 'est' and sujeto_id = e.id ) as com,
					(select count(*) from tbl_foro_comentario where foro_id = '{$_GET['id']}' and valido = 1 and tipo_sujeto = 'est' and sujeto_id = e.id) as val
					FROM tbl_estudiante e where e.id in (select est_id from tbl_grupo_estudiante where curso_id = {$_SESSION['CURSOID']} $filtro ) order by e.apellido,e.nombre";


	$pru->query($query);


?>

<!DOCTYPE html>
<html>
<head> <meta charset="utf-8">
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
                  <td width="67%" align="center" class="table_bk"><?=LANG_est?></td>
                  <td width="17%" align="center" class="table_bk"><?=LANG_foro_ncom?></td>
                  <td width="16%" align="center" class="table_bk"><?=LANG_foro_nval?></td>
                  </tr>

		<?php while ($row = $pru->db_vector_nom($pru->result)) { ?>

                <tr>
                  <td bgcolor="#FFFFFF" class="style1" style="text-transform: capitalize"><?=$row['nombre2']?></td>
                  <td align="center" bgcolor="#FFFFFF">
                    <?=$row['com']; ?>                  </td>
                  <td align="center" bgcolor="#FFFFFF">
				   <?=$row['val']; ?>  			  </td>
                  </tr>


				<?php

				}

				 ?>
              </table>

			  <?php }else{


			  echo LANG_noresutlts2;

			  }?>			  </td>
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
