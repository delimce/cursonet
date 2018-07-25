<?php
session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../config/setup.php"); ////////setup
include("../../../class/clases.php"); ////////clase
include ("../../../config/lang/{$_SESSION['LENGUAJE']}"); ////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);

//TODO: arreglar cuando se va a corregir un foro desde planes, que solo muestre alumnos de la seccion de ese plan

$grid = new tools("db");
$query = "SELECT 
e.id,
concat(e.apellido,' ',e.nombre) AS nombre,
e.id_number,
count(distinct FC.id) AS comentarios,
Sum(FC.valido) AS val,
round(FE.nota,1) AS nota
FROM
tbl_estudiante AS e
INNER JOIN tbl_grupo_estudiante AS ge ON ge.est_id = e.id
INNER JOIN tbl_foro AS f ON ge.curso_id = f.curso_id and (f.grupo_id = ge.grupo_id OR f.grupo_id = 0)
LEFT JOIN tbl_foro_comentario AS FC ON FC.foro_id = f.id  AND FC.tipo_sujeto = 'est' AND e.id = FC.sujeto_id
LEFT JOIN tbl_foro_estudiante AS FE ON FE.est_id = e.id AND FE.foro_id = f.id
WHERE
f.id = {$_REQUEST['ItemID']}
GROUP BY
e.id
order by e.apellido,e.nombre";


if (isset($_REQUEST['ItemID'])) {

    $grid->query($query);
} else if (isset($_POST['notas'])) {

    $grid->abrir_transaccion();

    for ($j = 0; $j < count($_POST['notas']); $j++) {

        $valores[0] = $_POST['est'][$j];
        $valores[1] = $_POST['foroid'];
        $valores[2] = $_POST['notas'][$j];


        $foroid2 = $grid->simple_db("select id from tbl_foro_estudiante where est_id = '$valores[0]' and foro_id = '$valores[1]' ");

        if ($grid->nreg == 0) {

            $grid->insertar2("tbl_foro_estudiante", "est_id,foro_id,nota", $valores);
        } else {


            $grid->query("update tbl_foro_estudiante set nota = '$valores[2]' where id = $foroid2 ");
        }
    }


    $grid->cerrar_transaccion();

    $grid->cerrar();

    if (!empty($_REQUEST['item'])) { ///viene desde planes
        ?>
        <script type="text/javascript">
            history.go(-2);
        </script>

        <?
    } else {
        $grid->javaviso(LANG_foro_tema_ok, "index.php");
    }
}
?>
<!DOCTYPE html>
<html>
    <head> <meta charset="utf-8">
        <script language="JavaScript" type="text/javascript">
            function validar() {
                var error, pos;

                error = 0;
                for (i = 0; i < document.form1.length; i++) {
                    if (document.form1.elements[i].type == "text" && (document.form1.elements[i].value == "" || isNaN(document.form1.elements[i].value))) {
                        error = 1;
                        pos = (i + 1) / 2;
                        break;
                    }
                }


                if (error == 1) {

                    alert('<?= LANG_foro_nonota ?>' + pos);
                    return false;

                } else {

                    return true;

                }


            }
        </script>


        <link rel="stylesheet" type="text/css" href="../../../css/style_back.css">
    </head>

    <body>

        <form name="form1" method="post" action="foro.php" onSubmit="return validar();">
            <table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td height="26" valign="top"><?php echo $menu->nombre; ?>&nbsp;<span class="style3">
                            <?= $_REQUEST['item'] ?>
                        </span></td>
                </tr>
                <tr>
                    <td><?php $menu->mostrar(0); ?></td>
                </tr>
                <tr>
                    <td>

                        <table style="border-right:#000000 solid 1px; border-left:#000000 solid 1px; border-bottom:#000000 solid 1px;" width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td><br>

                                    <table width="99%" height="*" align="center" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td>
                                                <table class="table_bk" width="100%" height="100%" cellpadding="0"  cellspacing="0">
                                                    <tr><td align="center"><table width="100%" height="100%" class="" border="0" cellspacing="1" cellpadding="2">
                                                                <tr>  <td width="45%" align="center" class="style3"><?= LANG_name ?></td>
                                                                    <td width="16%" align="center" class="style3"><?= LANG_ci ?></td>
                                                                    <td width="16%" align="center" class="style3"><?= LANG_comment ?></td>
                                                                    <td width="16%" align="center" class="style3"><?= LANG_foro_nval ?></td>
                                                                    <td width="*" align="center" class="style3"><?= LANG_nota ?></td>
                                                                </tr> 

                                                                <?php
                                                                $j = 0;


                                                                while ($row = $grid->db_vector_nom($grid->result)) {
                                                                    ?>
                                                                    <tr class="td_whbk" onMouseOver="this.style.backgroundColor = '#CCCCCC'" onMouseOut="this.style.backgroundColor = '#FFFFFF'">

                                                                        <td class="style1" align="left" style="text-transform:capitalize "><?= $row['nombre'] ?>
                                                                            <input name="est[]" type="hidden" id="est[]" value="<?= $row['id'] ?>"></td>
                                                                        <td title="<?= $row['id_number'] ?>" class="style1" align="center"><?= $row['id_number'] ?></td>
                                                                        <td class="style1" align="center"><?= $row['comentarios'] ?></td>
                                                                        <td class="style1" align="center"><?= $row['val'] ?></td>
                                                                        <td class="style1" align="center"><input name="notas[]" type="text" id="notas[]" style="text-align:center;" value="<?= $row['nota'] ?>" size="6" maxlength="5"></td>
                                                                    </tr>
                                                                    <?php
                                                                    $j++;
                                                                }
                                                                ?>

                                                            </table>
                                                        </td></tr></table></td></tr></table>&nbsp;<br>
                                    <input type="button" name="Submit2" onClick="history.back();" value="<?= LANG_back ?>">
                                    <input type="submit" name="Submit" value="<?= LANG_save ?>">
                                    <input name="foroid" type="hidden" id="foroid" value="<?= $_REQUEST['ItemID'] ?>">
                                    <input name="item" type="hidden" id="item" value="<?= $_REQUEST['item'] ?>">
                                    <br>
                                    <br></td>
                            </tr>
                        </table>	
                    </td>
                </tr>
            </table>

        </form>

    </body>
</html>
<?php
$grid->cerrar();
?>
