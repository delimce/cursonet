<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../config/setup.php"); ////////setup
include("../../../class/clases.php"); ////////clase
include("../../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje


$foroId = formulario::getvar("id", $_POST);

$db = new ObjectDB();


$db->setSql("SELECT
f.titulo,
if(fc.valido=1,0,1) as valido,
fc.sujeto_id
FROM
tbl_foro_comentario AS fc
INNER JOIN tbl_foro AS f ON fc.foro_id = f.id
WHERE
fc.id = $foroId ");

$db->getResultFields();


$titulo = $db->getField("titulo");
$sujeto = $db->getField("sujeto_id");
$valido = $db->getField("valido");


$db->abrir_transaccion();
////valor del comentario
$db->setTable("tbl_foro_comentario");
$db->setField("valido", $valido);
$db->updateWhere("id = $foroId ");
/////////

if ($valido > 0) { ///se manda el mensaje si fue aprobado

    ////////mensaje al estudiante
    $db->setTable("tbl_mensaje_est");
    $db->setField("tipo", 1);
    $db->setField("de", $_SESSION['USERID']);
    $db->setField("para", $sujeto);///
    $db->setField("subject", LANG_foro_comm1 . $titulo . LANG_foro_cok_title);
    $db->setField("content", LANG_foro_comm1 . $titulo . LANG_foro_cok_title . '<br>' . LANG_foro_cok_thanx);
    $db->setField("fecha", date('Y-m-d H:i:s'));
    $db->setField("urgencia", LANG_msg_priority_n);
    $db->insertInTo();
/////////////////////

}


$db->cerrar_transaccion();

$db->cerrar();


print $valido;


?>