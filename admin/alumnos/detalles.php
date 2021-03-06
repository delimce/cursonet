<?php
session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include("../../config/lang/{$_SESSION['LENGUAJE']}"); ////lenguaje

date_default_timezone_set($_SESSION['TIMEZONE']);

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);

$det = new tools("db");

$query = "SELECT
e.id,
e.id_number,
concat(e.nombre,' ',e.apellido) AS nombre,
e.foto,
e.sexo,
e.fecha_nac,
e.telefono_p,
e.telefono_c,
e.email,
e.msn,
e.twitter,
e.carrera,
e.nivel,
e.universidad,
e.internet_acc,
e.internet_zona,
e.`user`,
e.pass,
DATE_FORMAT(e.fecha_creado,'%d/%m/%Y %H:%i %p') AS fecha_creado,
ifnull(g.nombre,'" . LANG_nogroupto . "') AS grupo,
(select DATE_FORMAT(MAX(l.fecha_in),'%d/%m/%Y %H:%i %p') from tbl_log_est l where l.est_id = e.id GROUP BY l.est_id  ) AS ult_in,

GROUP_CONCAT(eq.nombre) equipos
FROM
tbl_estudiante AS e
LEFT JOIN tbl_grupo_estudiante AS ge ON (ge.curso_id = {$_SESSION['CURSOID']} AND ge.est_id = e.id)
LEFT JOIN tbl_grupo AS g ON ge.grupo_id = g.id
LEFT JOIN tbl_equipo_estudiante AS ee ON ee.est_id = e.id
LEFT JOIN tbl_equipo AS eq ON eq.grupo_id = g.id AND ee.equipo_id = eq.id
where e.id = {$_REQUEST['id']}
GROUP BY e.id";



$data = $det->simple_db($query); //////se ejecuta el query

$fecha = new fecha($_SESSION['DB_FORMATO'] . ' h:m A'); ///fecha con hora
?>
<html>

<head>
    <meta charset="utf-8">



    <link rel="stylesheet" type="text/css" href="../../css/style_back.css">
</head>

<BODY>

    <table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td height="26" valign="top"> <span class="menu-title"><?= $menu->nombre; ?></span></td>
        </tr>
        <tr>
            <td><?php $menu->mostrar($_REQUEST['origen']); ?></td>
        </tr>
        <tr>
            <td>

                <table style="border-right:#000000 solid 1px; border-left:#000000 solid 1px; border-bottom:#000000 solid 1px;" width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="center"><br>&nbsp;<br>
                            <table style="border: 1px solid #666;" width="90%" border="0" cellpadding="2" cellspacing="1">
                                <tr>
                                    <td colspan="3" align="left" class="table_bk"><?= LANG_studentdata ?></td>
                                </tr>
                                <tr>
                                    <td width="29%" rowspan="5" align="center" class="style3">
                                        <table width="85%" border="0" align="center" cellpadding="2" cellspacing="1">
                                            <tr>
                                                <td align="center" class="style3"><?php echo LANG_profilephoto ?></td>
                                            </tr>
                                            <tr>
                                                <td align="center">
                                                    <?php
                                                    if (empty($data['foto'])) {
                                                        $link = '../../recursos/est/fotos/nofoto.png';
                                                        $nombre = LANG_nopicture;
                                                    } else {
                                                        $link = '../../recursos/est/fotos/' . $data['foto'];
                                                        $nombre = $data['foto'];
                                                    }
                                                    ?>
                                                    <img class="avatar" style="border:solid 1px" src="<?= $link ?>"></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td width="25%" class="style1"><span class="style3"><?php echo LANG_name ?></span></td>
                                    <td width="46%" class="style1"><?php echo $data['nombre'] ?></td>
                                </tr>
                                <tr>
                                    <td class="style1"><span class="style3"><?php echo LANG_ci ?></span></td>
                                    <td class="style1"><?php echo $data['id_number'] ?></td>
                                </tr>
                                <tr>
                                    <td class="style1"><span class="style3"><?php echo LANG_sex ?></span></td>
                                    <td class="style1"><?php echo $data['sexo'] ?></td>
                                </tr>
                                <tr>
                                    <td class="style1"><span class="style3"><strong>
                                                <?= LANG_email ?>
                                            </strong></span></td>
                                    <td class="style1"><a style="color:#0000FF" title="<?php echo LANG_email_send ?>" href="mailto:<?php echo $data['email'] ?>"><?php echo $data['email'] ?></a></td>
                                </tr>
                                <tr>
                                    <td class="style1"><span class="style3"><strong>
                                                <?= LANG_fecha_nac ?>
                                            </strong></span></td>
                                    <td class="style1"><?php echo $data['fecha_nac'] ?></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="style3">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class="style3"><strong>
                                            <?= LANG_login ?>
                                        </strong></td>
                                    <td colspan="2" class="style1"><?php echo $data['user'] ?></td>
                                </tr>
                                <tr>
                                    <td class="style3"><strong>
                                            <?= LANG_university ?>
                                        </strong></td>
                                    <td colspan="2" class="style1"><?php echo $data['universidad'] ?></td>
                                </tr>

                                <tr>
                                    <td class="style3"><strong>
                                            <?= LANG_faculty_level ?>
                                        </strong></td>
                                    <td colspan="2" class="style1"><?php echo $data['nivel'] ?></td>
                                </tr>

                                <tr>
                                    <td class="style3"><strong>
                                            <?= LANG_group ?>
                                        </strong></td>
                                    <td colspan="2" class="style1"><b><?php echo $data['grupo'] ?></b></td>
                                </tr>

                                <?php if (!empty($data['equipos'])) { ?>
                                    <tr>
                                        <td class="style3"><strong>
                                                <?= LANG_teams ?>
                                            </strong></td>
                                        <td colspan="2" class="style1"><?php
                                                                        $teams = explode(',', $data['equipos']);
                                                                        foreach ($teams as $value)
                                                                            echo $value . '<br>';
                                                                        ?></td>
                                    </tr>
                                <?php } ?>

                                <tr>
                                    <td class="style3">&nbsp;</td>
                                    <td colspan="2" class="style1">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class="style3"><strong>
                                            <?= LANG_tel1 ?>
                                        </strong></td>
                                    <td colspan="2" class="style1"><?php echo $data['telefono_p'] ?></td>
                                </tr>
                                <tr>
                                    <td class="style3"><strong>
                                            <?= LANG_tel2 ?>
                                        </strong></td>
                                    <td colspan="2" class="style1"><?php echo $data['telefono_c'] ?></td>
                                </tr>
                                <tr>
                                    <td class="style3"><strong>
                                            <?= LANG_msn ?>
                                        </strong></td>
                                    <td colspan="2" class="style1"><?php echo $data['msn'] ?></td>
                                </tr>
                                <tr>
                                    <td class="style3"><strong>
                                            <?= LANG_twitter ?>
                                        </strong></td>
                                    <td colspan="2" class="style1"><?php echo $data['twitter'] ?></td>
                                </tr>
                                <tr>
                                    <td class="style3">&nbsp;</td>
                                    <td colspan="2" class="style1">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class="style3"><strong>
                                            <?= LANG_a_internet ?>
                                        </strong></td>
                                    <td colspan="2" class="style1"><?php echo $data['internet_acc'] ?></td>
                                </tr>
                                <tr>
                                    <td class="style3"><strong>
                                            <?= LANG_d_internet ?>
                                        </strong></td>
                                    <td colspan="2" class="style1"><?php echo $data['internet_zona'] ?></td>
                                </tr>
                                <tr>
                                    <td class="style3"><strong>
                                            <?= LANG_est_cont_fecha ?>
                                        </strong></td>
                                    <td colspan="2" class="style1"><?php echo $data['fecha_creado'] ?></td>
                                </tr>

                                <tr>
                                    <td class="style3"><strong>
                                            <?= LANG_last_access ?>
                                        </strong></td>
                                    <td colspan="2" class="style1"><?php echo $data['ult_in'] ?></td>
                                </tr>

                                <tr>
                                    <td class="style3">&nbsp;</td>
                                    <td colspan="2" class="style1">&nbsp;</td>
                                </tr>

                                <?php
                                /////en el caso que el alumno posea un plan de evaluacion asociado
                                $queryg = "SELECT 
					p.id,
					p.titulo,
					c.nombre
				  FROM
					tbl_grupo_estudiante g
					INNER JOIN tbl_plan_evaluador p ON (g.grupo_id = p.grupo_id)
					INNER JOIN tbl_curso c ON (g.curso_id = c.id)
				  WHERE
					g.est_id = '{$data['id']}' order by titulo";


                                $det->query($queryg);

                                if ($det->nreg > 0) {
                                ?>

                                    <tr>
                                        <td colspan="3" class="table_bk"><?php echo LANG_notes_plan ?></td>
                                    </tr>

                                    <?php while ($row = $det->db_vector_nom($det->result)) { ?>
                                        <tr>
                                            <td class="style3"><a href="notas.php?id=<?php echo $row['id'] ?>&origen=<?= $_REQUEST['origen']; ?>&estid=<?php echo $data['id'] ?>" title="<?php echo LANG_notes_view ?>"><?php echo $row['titulo']; ?></a></td>
                                            <td colspan="2" class="style1"><?php echo stripcslashes($row['nombre']); ?></td>
                                        </tr>

                                    <?php } ?>
                                    <tr>
                                        <td class="style3">&nbsp;</td>
                                        <td colspan="2" class="style1">&nbsp;</td>
                                    </tr>


                                <?php } ?>


                                <tr>
                                    <td colspan="3"><input type="button" name="button" id="button" value="<?php echo LANG_back ?>" onClick="history.back();">
                                        &nbsp;</td>
                                </tr>
                            </table>
                            <br>&nbsp;
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
<?php $det->cerrar(); ?>