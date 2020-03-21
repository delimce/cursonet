<?php

if ($_SESSION['ADMIN'] != 1) {
    session_destroy();

    echo ' <script language="JavaScript" type="text/javascript">
top.location.replace(' . $LOGINPAGE . ');
</script>';

    die();
}
