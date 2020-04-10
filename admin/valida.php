<?php
session_start();
include("../class/clases.php");

if (isset($_POST['user'])) {


    $db = new ObjectDB();
    $usuario = formulario::getvar("user", $_POST);
    $curso2 = formulario::getvar("curso", $_POST);
    $pass1 = formulario::getvar("pass", $_POST);

   $sql = "SELECT
	(select lenguaje from tbl_setup) as lenguaje,
    ifnull(group_concat(ac.curso_id),'') as cursos,
	a.id,
	CONCAT(nombre, ' ', apellido) AS nombre,
	a.es_admin,
	date_format(
		max(l.fecha_in),
		'%d/%m/%y %h:%i %p'
	) AS acc
        FROM
        tbl_admin AS a 
        LEFT JOIN tbl_log_admin AS l ON l.admin_id = a.id
        LEFT JOIN tbl_admin_curso as ac ON a.id = ac.admin_id
        WHERE
        a.`user` = '$usuario' AND
        a.pass = MD5('$pass1') GROUP BY a.id";

    $db->setSql($sql);
    $db->getResultFields();

    if ($db->getNumRows() > 0) {

        $loscursos = ($db->getField("cursos") != "")? explode(',', $db->getField("cursos")):[];
        $_SESSION['LENGUAJE'] = $db->getField("lenguaje"); //lenguaje

        if (($db->getField("es_admin") == 1) or ( in_array($curso2, $loscursos))) {

            $_SESSION['PROFILE'] = 'admin'; ///perfil de ingreso
            $_SESSION['USERID'] = $db->getField("id");
            $_SESSION['NOMBRE'] = $db->getField("nombre");
            $_SESSION['ADMIN'] = $db->getField("es_admin");
            $_SESSION['CURSOSP'] = $db->getField("cursos");
            $_SESSION['CURSOID'] = $curso2;
            $_SESSION['FECHACC'] = $db->getField("acc");

            ////guarda registro
            $db->setTable("tbl_log_admin");
            $db->setField("admin_id", $_SESSION['USERID']);
            $db->setField("fecha_in", @date("Y-m-d H:i:s"));
            $db->setField("ip_acc", $_SERVER['REMOTE_ADDR']);
            $db->setField("info_cliente", $_SERVER['HTTP_USER_AGENT']);
            $db->setField("curso_id", $curso2);
            $db->insertInTo();

            echo "1"; ///puede entrar
        } else {
            echo "2";
        }
    } else {
        echo "0";
    }
}

$db->cerrar();
