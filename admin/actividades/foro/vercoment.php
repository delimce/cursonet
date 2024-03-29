<?php
session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../config/setup.php"); ////////setup
include("../../../class/clases.php"); ////////clase
include("../../../config/lang/{$_SESSION['LENGUAJE']}"); ////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);

$crear = new tools("db");
$fecha = new fecha($_SESSION['DB_FORMATO'] . ' h:m A'); ///fecha con hora


if (!empty($_REQUEST['foro']))
    $_SESSION['tema_id'] = $_REQUEST['foro'];

$titulo = $crear->array_query2("select titulo,content from tbl_foro where id = '{$_SESSION['tema_id']}'");

////cuando se ven los comentarios se actualiza el campo de leido con el numero de comentarios para determinar los nuevos en la seleccion del foro
$crear->query("update tbl_foro set leido = (select count(*) from tbl_foro_comentario where foro_id = '{$_SESSION['tema_id']}' ) where id = '{$_SESSION['tema_id']}'");

$query = "	  ( SELECT DISTINCT 
							   c.id,
							   r.content,
                               ( 
                                if(r.tipo_sujeto='admin',(SELECT concat( ' ', nombre, ' ', apellido ) FROM tbl_admin WHERE id = r.sujeto_id),
                                (SELECT concat( ' ', nombre, ' ', apellido ) FROM tbl_estudiante WHERE id = r.sujeto_id))
                                ) AS sujeto,
							   '' as foto,
							   'No aplica' as grupo,
							   'admin' as tsujeto,
							   r.created_at as fecha,					 
							   'valido' as valido,
							   c.valido as valido2,
							   'respuesta' as tipo,
							   r.id as id2
							FROM
							  tbl_foro_comentario c
							  INNER JOIN tbl_foro_respuesta r ON (c.id = r.comentario_id)
							WHERE
							  c.foro_id = '{$_SESSION['tema_id']}'
					)UNION(	
		
				  SELECT 
				  c.id,
				  c.content,
				  if(c.tipo_sujeto = 'admin',(select concat('" . LANG_msg_prefa . " ',nombre, ' ', apellido) from tbl_admin where id = c.sujeto_id),(select concat('" . LANG_msg_prefs . " ',nombre, ' ', apellido) from tbl_estudiante where id = c.sujeto_id)) AS sujeto,
				  if(c.tipo_sujeto = 'admin',(select img from tbl_admin where id = c.sujeto_id),(select foto from tbl_estudiante where id = c.sujeto_id)) AS foto,
				  (SELECT 
					  g.nombre
					FROM
					  tbl_grupo g
					  INNER JOIN tbl_grupo_estudiante e ON (g.id = e.grupo_id)
					WHERE
					  e.est_id = c.sujeto_id and e.curso_id = '{$_SESSION['CURSOID']}' ) as grupo,
				  c.tipo_sujeto as tsujeto,
				  c.fecha_post as fecha,
				  if(c.valido = 0,'<img src=\"../../../images/backend/x.gif\" title=\"" . LANG_foro_status_nv . "\">','<img src=\"../../../images/backend/checkmark.gif\" title=\"" . LANG_foro_status_v . "\">') as valido, 
				  c.valido as valido2,
				   'comentario' as tipo,
				   0 as id2
				  FROM
				  tbl_foro f
				  INNER JOIN tbl_foro_comentario c ON (f.id = c.foro_id) where f.id = '{$_SESSION['tema_id']}'
				  order by c.fecha_post desc
				  
				  ) order by id desc, tipo, fecha asc
				   ";

$crear->query($query);



?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <script language="JavaScript" type="text/javascript" src="../../../js/jquery/jquery-1.7.2.min.js"></script>
    <script src="../../../js/jquery/jquery.timeago.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="../../../css/style_back.css">

    <script language="JavaScript" type="text/javascript">
        function estatus(id) {

            var estado, estatus;

            estado = $('#escom_' + id).val();
            estatus = (Number(estado) === 1) ? '<?= LANG_foro_status_nv ?>' : '<?= LANG_foro_status_v ?>';

            if (confirm("<?= LANG_foro_status_change ?> " + estatus + " ?")) {

                $.ajax({
                    method: "POST",
                    url: "estatus.php",
                    data: {
                        id: id
                    }
                }).done(function(msg) {

                    if (msg === '0') {
                        $('#estado_' + id).html('<img src="../../../images/backend/x.gif" title="<?= LANG_foro_status_nv ?>">');
                        $('#escom_' + id).val(0);

                    } else {

                        $('#estado_' + id).html('<img src="../../../images/backend/checkmark.gif" title="<?= LANG_foro_status_v ?>">');
                        $('#escom_' + id).val(1);

                    }

                });

            } else {


                return false;

            }

        }
    </script>


    <script language="JavaScript">
        <!--
        function popup(mylink, windowname, alto1, largo1) {
            var alto = alto1;
            var largo = largo1;
            var winleft = (screen.width - largo) / 2;
            var winUp = (screen.height - alto) / 2;


            if (!window.focus)
                return true;
            var href;
            if (typeof(mylink) == 'string')
                href = mylink;
            else
                href = mylink.href;
            window.open(href, windowname, 'top=' + winUp + ',left=' + winleft + '+,toolbar=0 status=0,resizable=0,Width=' + largo + ',height=' + alto + ',scrollbars=1');

            return false;

        }

        //
        -->
    </script>


    <script language="JavaScript" type="text/javascript">
        function borrar(id, nombre) {

            if (confirm("<?= LANG_foro_del_comment ?> " + nombre + " ?")) {

                location.replace('borrarcoment.php?id=' + id);

            } else {


                return false;

            }
        }


        function borrar2(id, nombre) {

            if (confirm("<?= LANG_est_foro_resptodel ?> " + nombre + " ?")) {

                location.replace('borrarresp.php?id=' + id);

            } else {


                return false;

            }
        }
    </script>

</head>

<body>

    <script>
        jQuery(document).ready(function() {
            jQuery("abbr.timeago").timeago();
        });
    </script>



    <table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td height="26" valign="top"> <span class="menu-title"><?= $menu->nombre; ?></span></td>
        </tr>
        <tr>
            <td><?php $menu->mostrar(2); ?></td>
        </tr>
        <tr>
            <td>

                <table style="border-right:#000000 solid 1px; border-left:#000000 solid 1px; border-bottom:#000000 solid 1px;" width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>

                            <table width="100%" border="0" cellpadding="3" cellspacing="4">
                                <tr>
                                    <td height="10" colspan="2" class="style1"><span class="style3"><?= LANG_foro_name ?>
                                            :</span>&nbsp; <?= $titulo[0]; ?></td>
                                </tr>
                                <tr>
                                    <td height="10" colspan="2" class="style1"><?= $titulo[1]; ?></td>
                                </tr>
                                <tr>
                                    <td height="10" colspan="2" class="style3"><?php if ($crear->nreg == 0) echo LANG_foro_nocomments; ?></td>
                                </tr>

                                <tr>
                                    <td colspan="2"><input name="b1" type="button" id="b1" onClick="javascript:location.href = 'comentario.php';" value="<?= LANG_back ?>">
                                        &nbsp;
                                        <input type="button" name="Button" value="<?= LANG_foro_add ?>" onClick="window.location.href = 'agregar.php';">
                                        &nbsp;
                                        <input name="Button2" type="button" class="no_back" onClick="window.location.href = 'vercoment.php';" value="<?= LANG_refresh ?>">
                                        <br>
                                        <br>
                                    </td>
                                </tr>

                                <?php
                                if ($crear->nreg > 0) {

                                    $i = 0;

                                    while ($row = $crear->db_vector_nom($crear->result)) {
                                ?>


                                        <?php if ($row['tipo'] != "respuesta" && $i != 0) { ?>
                                            <tr>
                                                <td height="10" colspan="2" class="style3">
                                                    <hr>
                                                </td>
                                            </tr>

                                        <?php } ?>

                                        <tr>
                                            <td height="10" colspan="2" class="style3"><?php
                                                                                        if ($row['tipo'] != "respuesta") {

                                                                                            echo LANG_name . ' ' . $row['sujeto'];

                                                                                            if ($row['tsujeto'] != 'admin') {
                                                                                                echo '<br>' . LANG_group . ' ' . $row['grupo'];

                                                                                                ///////determinando el numero de palabras por comentario
                                                                                                $tcom1 = trim($row["content"]);
                                                                                                // $tcom2 =  preg_replace("/\n\r|\r\n/", "",$tcom1);
                                                                                                $tcom1 = strip_tags($tcom1);
                                                                                                $tcom2 = explode(" ", $tcom1);
                                                                                                $nwords = count(array_filter($tcom2));


                                                                                                echo '<br>' . LANG_foro_n_words . ' ' . $nwords;

                                                                                                unset($tcom1, $tcom2, $nwords);

                                                                                                ////////////////
                                                                                            }
                                                                                        } else {
                                                                                            echo LANG_est_foro_respto;
                                                                                        ?>:&nbsp;<?php echo $row['sujeto'];
                                                                                                    if ($row['tipo'] == "respuesta")

                                                                                                        //  echo ' ' . LANG_foro_publicado . ' ' . $fecha->datetime($row['fecha']);

                                                                                                        echo ' ' . LANG_foro_publicado

                                                                                                    ?>
                                                <abbr class="timeago" title="<?= $row['fecha'] ?>"><?= $fecha->datetime($row['fecha']) ?></abbr>
                                                <?php

                                                ?><?php } ?>



                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="10" colspan="2" class="<?php if ($row['tipo'] != "respuesta") echo 'no_back';
                                                                                else echo 'style4'; ?>">

                                                <?php if ($row['tipo'] != "respuesta") { ?>

                                                    <!--foto-->

                                                    <?php
                                                    if (empty($row['foto'])) {
                                                        $link = '../../../recursos/est/fotos/nofoto.png';
                                                    } else {
                                                        $link = $row['foto'];
                                                    }
                                                    ?>
                                                    <img class="avatar" style="border:solid 1px" hspace="7" vspace="7" align="left" src="<?= $link ?>">
                                                    <!--fin foto-->

                                                <?php } ?>

                                                <div id="com_<?= $row['id'] ?>"><?php echo $row["content"] ?></div>
                                            </td>
                                        </tr>

                                        <?php if ($row['tipo'] == "respuesta") { ?>
                                            <tr>
                                                <td height="10" colspan="2" align="right" class="<?php if ($row['tipo'] != "respuesta") echo 'no_back';
                                                                                                    else echo 'style4'; ?>">
                                                    <table width="4%" border="0" cellpadding="2" cellspacing="0" class="style1">
                                                        <tr>
                                                            <td width="26%" align="center"><a href="#" onClick="javascript:popup('editresp.php?id=<?= $row['id2'] ?>', 'new', 300, 640);"><img border="0" src="../../../images/backend/button_edit.png" width="12" height="13" title="<?= LANG_est_foro_resptoupdate ?>"></a></td>
                                                            <td width="20%" align="center"><a href="#" onClick="javascript:borrar2('<?= $row['id2'] ?>', '<?= strip_tags($row['sujeto']) ?>');"><img border="0" src="../../../images/backend/button_drop.png" width="11" height="13"></a></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        <?php } ?>

                                        <?php if ($row['tipo'] != "respuesta") { ?>
                                            <tr>
                                                <td width="13%" height="10" align="center" class="style3">

                                                    <table width="81%" border="0" cellpadding="2" cellspacing="0" class="style1">
                                                        <tr>

                                                            <?php if ($row['tsujeto'] != "admin") { ?>
                                                                <td width="25%" align="center">
                                                                    <div id="estado_<?= $row['id'] ?>" onClick="estatus(<?= $row['id'] ?>);">
                                                                        <?= $row['valido'] ?>
                                                                    </div>
                                                                </td>
                                                            <?php } ?>
                                                            <td width="26%" align="center">
                                                                <a href="#" onClick="javascript:popup('editcoment.php?id=<?= $row['id'] ?>', 'new', 300, 640);"><img border="0" src="../../../images/backend/button_edit.png" width="12" height="13" title="<?= LANG_edit ?>"></a>
                                                            </td>
                                                            <td width="20%" align="center"><a href="#" onClick="javascript:borrar('<?= $row['id'] ?>', '<?= strip_tags($row['sujeto']) ?>');"><img border="0" src="../../../images/backend/button_drop.png" width="11" height="13"></a></td>
                                                            <td width="29%" align="center"><?php if ($row['tsujeto'] != "admin") { ?>
                                                                    <img style="cursor:pointer" title="<?= LANG_foro_response ?>" onClick="popup('respcoment.php?id=<?= $row['id'] ?>&nombre=<?= $row['sujeto'] ?>', 'new', 300, 640);" src="../../../images/backend/icon-prod-copy.gif" width="16" height="16"><?php } ?>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td height="10" align="right" class="style1">
                                                    <span class="style3"><?= LANG_foro_publicado ?></span>
                                                    <abbr class="timeago" title="<?= $row['fecha'] ?>"><?php echo $fecha->datetime($row['fecha']) ?></abbr>
                                                    <?php //echo $fecha->datetime($row['fecha']) 
                                                    ?>
                                                    <input name="escom_<?= $row['id'] ?>" type="hidden" id="escom_<?= $row['id'] ?>" value="<?php if ($row['valido2'] == 1) echo 1;
                                                                                                                                            else 0; ?>">

                                                </td>
                                            </tr>

                                        <?php } ?>



                                <?php
                                        $i++;
                                    }
                                }
                                ?>


                                <tr>
                                    <td height="10" colspan="2" class="style3">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="2"><input name="b1" type="button" id="b1" onClick="javascript:location.href = 'comentario.php';" value="<?= LANG_back ?>">
                                        &nbsp;
                                        <input type="button" name="Button" value="<?= LANG_foro_add ?>" onClick="window.location.href = 'agregar.php';">
                                        &nbsp;
                                        <input name="Button3" type="button" class="no_back" onClick="window.location.href = 'vercoment.php';" value="<?= LANG_refresh ?>">
                                    </td>
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

<?php $crear->cerrar(); ?>