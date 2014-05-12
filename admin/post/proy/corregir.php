<?php
session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../config/setup.php"); ////////setup
include("../../../class/clases.php"); ////////clase
include ("../../../config/lang/{$_SESSION['LENGUAJE']}"); ////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);

if (isset($_REQUEST['id']))
    $_SESSION['PRO_ID2'] = $_REQUEST['id'];

$prueba = new tools("db");
$fecha = new fecha($_SESSION['DB_FORMATO']);

$queryd = "SELECT
	  concat(est.nombre, ' ', est.apellido) AS nombre,
	  eva.rec_id,
	  eva.correccion,
          eva.est_id,
	  if(eva.nota = '-1', '', eva.nota) AS nota
	FROM
	  tbl_proyecto_estudiante eva inner join tbl_estudiante est
	  ON (est.id = eva.est_id)  
	  
	WHERE
	   eva.id = '{$_SESSION['PRO_ID2']}'";


/////////////////////////guarda o consulta

if (isset($_POST['nota'])) {


    $prueba->abrir_transaccion();

    $campos[0] = "correccion";
    $campos[1] = "nota";
    $campos[2] = "proy_id";
    $vector[0] = $_POST['revi'];
    $vector[1] = $_POST['nota'];
    $vector[2] = $_SESSION['PRO_ID']; ///id del proyecto

    $prueba->update("tbl_proyecto_estudiante", $campos, $vector, "id = '{$_SESSION['PRO_ID2']}'");

    //////////////////acompanamiento de proyectos
    // include("acomp.php");
    //////////////////////////////////////////

    $equipoSelect = $_POST['equipo'];

    ////////////////////////////////// colocando la correccion y nota a los miembros de los equipos
    if (count($equipoSelect) > 0) {

        ///////////buscando el id del recurso
        $recurso = $_POST['archivo'];

        for ($i = 0; $i < count($equipoSelect); $i++) {

            $estudiantes = $prueba->array_query("SELECT
                                                    e1.est_id
                                                    FROM
                                                    tbl_equipo_estudiante AS e1
                                                    WHERE
                                                    e1.equipo_id = $equipoSelect[$i]");
            $delEquipo = implode(",", $estudiantes);

            $prueba->query("delete from tbl_proyecto_estudiante where proy_id = {$_SESSION['PRO_ID']} and est_id in ($delEquipo) "); ////los borro todos
            /////insertando todos los estudiantes del equipo con nota y correccion

            for ($j = 0; $j < count($estudiantes); $j++) {

                $vector[3] = $estudiantes[$j];
                $vector[4] = $recurso;
                $prueba->insertar2("tbl_proyecto_estudiante", 'correccion,nota,proy_id,est_id,rec_id', $vector);
            }

            //////////////////////////////////
        }
    }
    ////////////////////////////////
    $prueba->cerrar_transaccion();

    $prueba->cerrar();
    $prueba->javaviso(LANG_proy_saeval, "proys.php");
} else {

    $datos = $prueba->simple_db($queryd);
    $recurso = $prueba->array_query2("select dir,fecha from tbl_recurso where id = {$datos['rec_id']} ");

    //////trayendo datos de los equipos del estudiante
    $equipos = $prueba->estructura_db("SELECT
                                    e.id,
                                    e.nombre,
                                    e.descripcion
                                    FROM
                                            tbl_equipo AS e
                                    INNER JOIN tbl_equipo_estudiante AS ee ON ee.equipo_id = e.id
                                    INNER JOIN tbl_proyecto AS p ON e.grupo_id = p.grupo
                                    AND (
                                            e.grupo_id = p.grupo
                                            OR p.grupo = 0
                                    )
                                    WHERE
                                    ee.est_id = {$datos['est_id']}
                                    AND p.curso_id = {$_SESSION['CURSOID']}");
}
?>
<html>
    <head> <meta charset="utf-8">

        <script language="JavaScript" type="text/javascript">
            function validar() {

                if (isNaN(document.form1.nota.value) || document.form1.nota.value < 0) {

                    alert('<?= LANG_eva_cal_value ?>');
                    document.form1.nota.focus();

                    return false;

                } else {

                    document.form1.submit();

                }

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
                                            <td colspan="4" class="style1"><b><?= LANG_est ?>
                                                    &nbsp;</b><?= $datos['nombre'] ?>
                                                &nbsp;</td>
                                        </tr>

                                        <tr>
                                            <td colspan="4" class="table_bk"><? echo LANG_proy_date_e; ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"><? echo $fecha->datetime($recurso[1]); ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="table_bk"><? echo LANG_proy_file; ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" align="left">
                                                <a href="abrir.php?id=<?php echo $datos['rec_id'] ?>" title="<?= LANG_download ?>"><?php echo $recurso[0] ?></a>
                                                <input type="hidden" id="archivo" name="archivo" value="<?php echo $datos['rec_id'] ?>">
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="4" align="left" class="td_whbk2">
                                                <b>
                                                    <?= LANG_eva_revi ?>
                                                </b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" align="center">
                                                <textarea name="revi" cols="93" rows="4" class="style1" id="revi"><?= stripslashes($datos['correccion']); ?></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="14%" align="left" class="td_whbk2">
                                                <b>
                                                    <?= LANG_eva_cal ?>
                                                </b>
                                            </td>
                                            <td colspan="3" align="left" class="td_whbk2">
                                                <input name="nota" type="text" id="nota" value="<?= $datos['nota'] ?>" size="5" maxlength="4">
                                            </td>
                                        </tr>

                                        <!--     mostrar datos de equipos-->
                                        <?php
                                        if (count($equipos > 0)) { ///hay equipos
                                            ?>  

                                            <tr>
                                                <td colspan="4" align="left" class="td_whbk">
                                                    <b>
                                                        <?= LANG_team_to_apply ?>
                                                    </b>
                                                </td>
                                            </tr>  
                                            <?php
                                            for ($i = 0; $i < count($equipos); $i++) {
                                                ?>
                                                <tr>
                                                    <td colspan="4" align="left" class="td_whbk">
                                                        <div style="display: inline">
                                                            <input type="checkbox" name="equipo[]" value="<?= $equipos[$i]['id'] ?>" />
                                                            <b><?= $equipos[$i]['nombre'] ?></b>&nbsp;<span style="font-style: italic"><?= $equipos[$i]['descripcion'] ?></span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?
                                            }
                                            ?>

                                            <?php
                                        }
                                        ?>
                                        <!--     mostrar datos de equipos-->

                                        <tr>
                                            <td colspan="4" align="left">
                                                <input name="b1" type="button" id="b1" onClick="javascript:location.replace('proys.php');"  value="<?= LANG_back ?>">
                                                <input name="guarda" type="button" id="guarda" onClick="javascript:validar();" value="<?= LANG_save ?>">
                                            </td>
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