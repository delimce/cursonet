<?php
session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}"); ////lenguaje


/////////revisar la version
$file = new File2("../../config/version.info");
$version = $file->readLastLine();

?>
<!DOCTYPE html>
<html>
    <head> <meta charset="utf-8">
        <script language="JavaScript" type="text/javascript" src="../../js/utils.js"></script>
        <link rel="stylesheet" type="text/css" href="../../css/style_back.css">
    </head>

    <body>
    <center>

        <div style="width: 90%">
            <div class="style1" style="text-align: justify">
                <?php echo LANG_versionText . '<b>' . $version . '</b>' ?>
            </div>
            <p>&nbsp;</p>
            <div class="style1" style="text-align: justify">
                <?php echo LANG_aboutus ?>
            </div>
            <p>&nbsp;</p>

            <div style="cursor:pointer;" onClick="location.replace('http://twitter.com/cursonet')">
                <img style="vertical-align:middle" src="../../images/common/icon-twitter.png">
                <span class="style3"><?php echo LANG_twitter ?>&nbsp;@cursonet</span>
            </div>

        </div> 

    </center>
</body>
</html>