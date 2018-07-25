<?php
session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}"); ////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);

/////trayendome el limite
$limit = formulario::getvar("top");
$top = (empty($limit)) ? 20 : $limit; ///limit por defecto


$db = new ObjectDB();

$query = "SELECT
if(date(fecha_in)=date(NOW()),concat('<strong>" . LANG_today . "</strong>',' ',DATE_FORMAT(fecha_in,'%H:%i %p')),
    DATE_FORMAT(fecha_in,'{$_SESSION['DB_FORMATO_DB']}')) as fecha,
l.ip_acc,
concat(e.nombre,' ',e.apellido,' - ',e.id_number) as nombre,
ifnull(g.nombre,'" . LANG_ungroup . "') as grupo
FROM
tbl_log_est AS l
INNER JOIN tbl_estudiante AS e ON l.est_id = e.id
LEFT JOIN tbl_grupo_estudiante AS ge ON ge.est_id = e.id
LEFT JOIN tbl_grupo AS g ON ge.grupo_id = g.id
WHERE
g.curso_id = {$_SESSION['CURSOID']}
ORDER BY
l.id DESC limit $top";

$db->query($query);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <script src="../../js/jquery/jquery-1.7.2.min.js"></script>
        <script src="../../js/jquery/jquery.fastLiveFilter.js"></script>

        <script>
            $(function() {
                $('#search_input').fastLiveFilter('#search_list', {
                    callback: function(total) {
                        $('#num_results').html(total);
                    }
                });
            });


            $(document).ready(function() {
                $('input[type=radio]').live('change', function() {
                    var limit = $('.shapeButton:checked').val();
                    var limite = '<?= $_SERVER['PHP_SELF'] . '?top=' ?>';
                    limite += limit;
                    location.replace(limite);

                });
            });




        </script>
        <link rel="stylesheet" type="text/css" href="../../css/style_back.css">
    </head>
    <body>
        <div id="curso_wrapper">
            <div style="height: 26px"><?php echo $menu->nombre; ?></div>
            <div id="curso_menu">
                <?php $menu->mostrar(3); ?>
            </div>
            <!--           contenido principal-->
            <div id="curso_content">

                <p>&nbsp;</p>
                <div class="style3" style="margin-left:36;">
                    <div><input id="search_input" placeholder="<?= LANG_search ?>">&nbsp;<?= LANG_total ?>:&nbsp;<span id="num_results"></span></div>
                    <div style="padding-top: 12px; padding-bottom: 10px">
                        <?= LANG_show ?>&nbsp;
                        <input type="radio" name="group1" class="shapeButton" value="20" <? if ($top == 20) echo 'checked'; ?>>20&nbsp;
                        <input type="radio" name="group1" class="shapeButton" value="30" <? if ($top == 30) echo 'checked'; ?>>30&nbsp; 
                        <input type="radio" name="group1" class="shapeButton" value="40" <? if ($top == 40) echo 'checked'; ?>>40&nbsp; 
                        <input type="radio" name="group1" class="shapeButton" value="50" <? if ($top == 50) echo 'checked'; ?>>50&nbsp;


                    </div>

                </div>

                <ul id="search_list" style="list-style-type: none;">
                    <?
                    while ($row = $db->db_vector_nom($db->result)) {
                        ?>

                        <li style="padding: 0px 51px 10px 0px">
                            <span style="width: 40"  class="style1"><?= $row['fecha']; ?>,&nbsp;</span>
                            <span style="width: 40" class="style1" style="text-transform: capitalize"><?= $row['nombre']; ?>, </span>
                            <span style="width: 40"><?= $row['grupo']; ?></span> 
                        </li>

                        <?php
                    }
                    ?>
                </ul> 


            </div>
            <!--           contenido principal-->
        </div>

    </body>
</html>
<?php $db->cerrar(); ?>
