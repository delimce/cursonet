<?php
session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../config/setup.php"); ////////setup
include("../../../class/clases.php"); ////////clase
include ("../../../config/lang/{$_SESSION['LENGUAJE']}"); ////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);


$prueba = new tools("db");

if (isset($_GET['ItemID']))
    $_SESSION['EVAL_ID'] = $_GET['ItemID'];

$totales = $prueba->array_query2("select (select count(*) from tbl_evaluacion_estudiante where nota = -1 and eval_id = '{$_SESSION['EVAL_ID']}') as sin, (select count(*) from tbl_evaluacion_estudiante where nota != -1 and eval_id = '{$_SESSION['EVAL_ID']}') as listos");

if ($totales[0] > $totales[1])
    $total = $totales[0]; else
    $total = $totales[1];

$pruebas = $prueba->estructura_db("SELECT 
  a.id,
  lower(concat(e.apellido, ' ', e.nombre)) AS nombre,
  e.id_number,
  a.nota
FROM
  tbl_evaluacion_estudiante a,
  tbl_estudiante e
WHERE
  (a.est_id = e.id)  and a.eval_id = {$_SESSION['EVAL_ID']} order by e.apellido, e.nombre");
?>
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
                            <td align="center"><br>
                                <table width="100%" border="0" cellspacing="2" cellpadding="2">
                                    <tr>
                                        <td width="50%" class="table_bk"><? echo LANG_eva_porevaluar;
echo '  ' . $totales[0]; ?></td>
                                        <td width="50%" class="table_bk"><? echo LANG_eva_evaluados;
echo' ' . $totales[1]; ?></td>
                                    </tr>


                                    <tr>
                                        <td class="style1" valign="top">
                                            <?php if ($totales[0] == 0) {
                                                echo '<b>' . LANG_eva_nosin . '</b>';
                                            } else { ?> 
                                                <table width="100%" border="0" cellspacing="1" cellpadding="1">


                                                    <?php
                                                    for ($i = 0; $i < count($pruebas); $i++) {

                                                        if ($pruebas[$i]['nota'] == '-1') {
                                                            ?>
                                                            <tr>
                                                                <td><? echo "<a href=\"corregir.php?id={$pruebas[$i]['id']}\" title=\"" . LANG_eva_corregir . "\">" . $pruebas[$i]['nombre'] . " " . $pruebas[$i]['id_number'] . "</a>"; ?></td>
                                                            </tr>

                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                                </table>


<?php } ?>

                                        </td>
                                        <td class="style1" valign="top">

<?php if ($totales[1] == 0) {
    echo '<b>' . LANG_eva_noeval . '</b>';
} else { ?> 
                                                <table width="100%" border="0" cellspacing="1" cellpadding="1">


                                                    <?php
                                                    for ($i = 0; $i < count($pruebas); $i++) {

                                                        if ($pruebas[$i]['nota'] > '-1') {
                                                            ?>
                                                            <tr>
                                                                <td class="style1" style="text-transform: capitalize"><? echo "<a href=\"corregir.php?id={$pruebas[$i]['id']}\" title=\"" . LANG_eva_corregir . "\">" . $pruebas[$i]['nombre'] . " " . $pruebas[$i]['id_number'] . "</a>"; ?></td>
                                                            </tr>

            <?php
        }
    }
    ?>

                                                </table>

                                                <?php } ?>

                                        </td>
                                    </tr>




                                    <tr>
                                        <td colspan="2" align="left" class="style1"><input name="b1" type="button" id="b1" onClick="location.replace('index.php');"  value="<?= LANG_back ?>"></td>
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
$prueba->cerrar();
?>