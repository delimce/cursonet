<?php
session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}"); ////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);

$db = new tools("db");


$team = $db->simple_db("select id,nombre from tbl_equipo where id = {$_GET['id']} ");

$query = "SELECT
est.id,
est.nombre,
est.apellido,
est.id_number AS cedula,
est.foto,
est.`user`
FROM
tbl_equipo AS e
INNER JOIN tbl_equipo_estudiante AS ee ON ee.equipo_id = e.id
INNER JOIN tbl_estudiante AS est ON ee.est_id = est.id
WHERE
e.id = {$_GET['id']}";

$db->query($query);


?>
<!DOCTYPE html>
<html>
    <head> <meta charset="utf-8">
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
                        <tr>
                            <td>

                            <div style="padding:25px; margin-bottom:15px">
                            
                            <b><?=LANG_team_members?>: <?=$team["nombre"] ?></b>

                              <p></p>

                                <?
                                   while ($row = $db->db_vector_nom($db->result)) {
                                   ?>


                               <?php
                                                if (empty($row['foto'])) {
                                                    $link = '../../../recursos/est/fotos/nofoto.png';
                                                } else {

                                                    if ($row['tsujeto'] == "admin")
                                                        $dir = 'admin';
                                                    else
                                                        $dir = 'est';
                                                    $link = "../../../recursos/$dir/fotos/" . $row['foto'];
                                                }
                                 ?>

                              <div style="padding:20px; display: table;">
                                <img class="avatar" style="vertical-align:middle; display: table-cell" src="<?=$link?>">
                                <div style="vertical-align:middle; padding:10px; display: table-cell">
                                    <span><?=$row["nombre"].' '.$row["apellido"] ?></span><br>
                                    <span>CI: <?=$row["cedula"]?></span><br>
                                    <span>Usuario: <?=$row["user"]?></span>
                                </div>
                              </div>

                              <?php } ?>


                               <p></p>
                             <input type="button" name="Submit2"  value="<?=LANG_back?>" onClick="javascript:history.back();">
                            
                            </div>
                           

                         
                            </td>
                        </tr>
                    </table>	</td>
            </tr>
        </table>
    </body>
</html>
<?php
$db->cerrar();
?>
