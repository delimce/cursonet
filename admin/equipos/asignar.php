<?php
session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}"); ////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);


$asig = new tools("db");

$datos = $asig->simple_db("SELECT
                                e.id as equipoId,
                                g.id as grupoId,
                                e.nombre as equipo,
                                g.nombre as grupo
                                FROM
                                tbl_equipo AS e
                                INNER JOIN tbl_grupo AS g ON g.id = e.grupo_id
                                WHERE
                                e.id = {$_REQUEST['id']} AND
                                g.curso_id = {$_SESSION['CURSOID']} ");

if (!empty($_GET['id'])) { ///consultar nombre de equipo y curso.
    ///query para traer los datos de los alumnos que estan en el grupo y si existen en el equipo
    $asig->query("SELECT
                                                est.id,
                                                lower(concat(est.apellido,' ',est.nombre)) AS nombre,
                                                est.id_number,
                                                ifnull((select equipo_id from tbl_equipo_estudiante where est_id = est.id and equipo_id = {$datos['equipoId']} ),0) as existe
                                                FROM
                                                tbl_estudiante AS est
                                                INNER JOIN tbl_grupo_estudiante AS gr ON est.id = gr.est_id
                                                WHERE
                                                gr.grupo_id = {$datos['grupoId']}");
}


if (isset($_POST['select']) or isset($_POST['id'])) {

    $asig->abrir_transaccion();
    $asig->query("delete from tbl_equipo_estudiante where equipo_id = {$datos['equipoId']} ");


    if (count($_POST['select']) > 0) {

        $valores[1] = $datos['equipoId'];

        for ($z = 0; $z < count($_POST['select']); $z++) {
            $valores[0] = $_POST['select'][$z];
            $asig->insertar2("tbl_equipo_estudiante", "est_id, equipo_id", $valores);
        }
    }


    $asig->cerrar_transaccion();

    $asig->javaviso(LANG_cambios, "index.php");
}
?>
<html>
    <head> <meta charset="utf-8">

        <script src="../../js/jquery/jquery-1.7.2.min.js"></script>
        <script src="../../js/jquery/jquery.fastLiveFilter.js"></script>

        <script>
            $(function() {
                $('#search_input').fastLiveFilter('#search_list',{
                    callback: function(total) { $('#num_results').html(total); }
                });
            });
        </script>

        <link rel="stylesheet" type="text/css" href="../../css/style_back.css">
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

                        <td>
                            <form name="form1" method="post" action="<?= $PHP_SELF ?>">
                                <table width="100%" height="104" border="0" cellpadding="3" cellspacing="4" class="style1">

                                    <?php
/////////si no existen registros
                                    if ($asig->nreg == 0) {
                                        echo '<p style="margin-left:15;">' . LANG_group_nostudent;
                                    } else {
                                        ?>

                                        <tr>
                                            <td colspan="4"></tr>
                                        <tr> 
                                        <tr>
                                        <div class="style1" style="margin-left:26; margin-top: 15;">
                                            <?= '<b>' . LANG_group . '</b> ' . $datos['grupo'] ?><br>
                                            <?= '<b>' . LANG_team_name . '</b> ' . $datos['equipo'] ?> 
                                        </div>   

                                        <div class="style3" style="margin-left:26; margin-top: 11;"><input id="search_input" placeholder="<?= LANG_search ?>">&nbsp;<?= LANG_total ?>:&nbsp;<span id="num_results"></span></div>

                                        <ul id="search_list" style="list-style-type: none;">
                                            <?
                                            while ($row = $asig->db_vector_nom($asig->result)) {
                                                ?>

                                                <li>
                                                    <span width="6%" class="style1"><input name="select[]" type="checkbox" id="select[]" value="<?= $row['id'] ?>" <?php if ($datos['equipoId'] == $row['existe']) echo 'checked="checked"'; ?>></span>
                                                    <span width="34%" class="style1" style="text-transform: capitalize"><?= $row['nombre']; ?></span>
                                                    <span style="font-weight: bold" width="17%" class="style1"><?= $row['id_number']; ?></span> 
                                                </li>

                                                <?php
                                            }
                                        }
                                        ?>
                                    </ul> 
                                    </tr>
                                    <tr>
                                        <td colspan="4"><input type="button" name="Submit2"  value="<?= LANG_back ?>" onClick="javascript:history.back();">
                                            <?php if ($asig->nreg > 0) { ?> <input type="submit" name="Submit" value="<?= LANG_save ?>"><?php } ?>
                                            <input name="id" type="hidden" id="id" value="<?= $_REQUEST['id'] ?>"></td>
                                    </tr>
                                </table>

                            </form>
                        </td>
            </tr>
        </table>	</td>
</tr>
</table>
</body>
</html>

<?php
$asig->cerrar();
?>
