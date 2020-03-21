<?php
if (!isset($_SESSION['PROFILE'])) { ////valida la sesion si ha sido creada por un usuario valido!!!

    $LOGINPAGE = $_SERVER['HTTP_HOST'] . "/error/error.php";
    session_destroy();
    $LOGINPAGE = "http://$LOGINPAGE";

?>

    <script language="JavaScript" type="text/javascript">
        top.location.replace('<?= $LOGINPAGE ?>');
    </script>

<?php
    die();
}
?>