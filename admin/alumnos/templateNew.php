<?php
session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}"); ////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);
?>
<html>
    <head>
        <meta charset="UTF-8">
        <script src="../../js/jquery/jquery-1.7.2.min.js"></script>
        <script src="../../js/jquery/jquery.grid.functions.js"></script>
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



            </div>
            <!--           contenido principal-->
        </div>


    </body>
</html>
