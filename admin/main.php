<?php
session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../config/setup.php"); ////////setup
include("../class/clases.php");
include ("../config/lang/{$_SESSION['LENGUAJE']}"); ////lenguaje

$datos = new tools('db');

if (isset($_REQUEST['curso'])) {

    $_SESSION['CURSOID'] = $_REQUEST['curso']; ////setea el curso por el seleccionado
}

///////////////////
$datamenu = $datos->simple_db("select (select count(*) from tbl_estudiante) as nest, (select count(*) from tbl_mensaje_admin where para = {$_SESSION['USERID']} ) as nmens,
 (select count(*) from tbl_contenido where curso_id = '{$_SESSION['CURSOID']}') as ntemas, 
 (select count(*) from tbl_recurso where add_by = 'admin') as recursos  ");


$data = $datos->simple_db("select c.id,c.nombre,c.alias,date_format(fecha_creado,'{$_SESSION['DB_FORMATO_DB']}') as fechac,
					 (select concat(nombre,' ',apellido) from tbl_admin where id = c.resp) as creador,duracion,descripcion,notas,
					 (select count(*) from tbl_mensaje_admin where para = '{$_SESSION['USERID']}' and leido = 0 ) as sinleer
					  from tbl_curso c
			  		  where  id = '{$_SESSION['CURSOID']}' ");

$_SESSION['CURSOALIAS'] = $data['alias'];
?>
<html>
    <head> <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="../css/style_back.css">
        <script language="JavaScript" type="text/javascript" src="../js/utils.js"></script>
        <script src="../js/jquery/jquery-1.7.2.min.js"></script>
        <script>
            $(document).on("ready", function() {

                $('#nest', window.parent.document).html(<?= $datamenu['nest'] ?>);
                $('#nmsgs', window.parent.document).html(<?= $datamenu['nmens'] ?>);
                $('#nrecus', window.parent.document).html(<?= $datamenu['recursos'] ?>);

            });

        </script>

    </head>
    <body>

        <div style="background-image:url('../images/backend/main.jpg'); 
             background-repeat: no-repeat; 
             background-position: right, bottom;  height: 460; width: 100%">

            <div class="style1"><?= LANG_curso_actual ?>&nbsp;<span class="style3"><?php echo $data['nombre'] ?></span></div>
            <div class="style1"><?= LANG_content_create ?>:&nbsp;<span class="style3"><?php echo $data['fechac'] ?></span></div>
            <div class="style1"><?= LANG_content_create_by ?>:&nbsp;<span class="style3"><?php echo $data['creador'] ?></span></div>
            <div class="style1"><?= LANG_curso_long ?>:&nbsp;<span class="style3"><?php echo $data['duracion'] ?></span></div>
            <br>
            <div class="notes"><?php echo $data['descripcion'] ?></div>
            <br>
            <?php if (str_word_count($data['notas']) > 1) { ?>
                <div class="notes"><?= $data['notas'] ?></div>
            <? } ?>


            <?php if ($data['sinleer'] > 0) { ?>

                <div class="messages">
                    <table width="100%" border="0" cellspacing="2" cellpadding="2">
                        <tr>
                            <td width="98%" class="style3"><?php echo $data['sinleer'] ?> <? echo ($data['sinleer'] > 1) ? LANG_msgs_unread : LANG_msg_unread ?></td>
                            <td width="2%"><img src="../images/backend/mens2.gif" width="32" height="32"></td>
                        </tr>
                        <tr>
                            <td colspan="2"><a href="mensajes/index.php" class="style3" style="color:#0000FF"><?= LANG_msg_read ?></a></td>
                        </tr>
                    </table>
                </div>

            <? } ?>


        </div>

    </body>
</html>
<?php $datos->cerrar(); ?>