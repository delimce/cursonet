<?php

session_start();
$profile = 'est'; /////////////// perfil requerido
include("../config/setup.php"); ////////setup
include("../class/clases.php"); ////////clase
include ("../config/lang/{$_SESSION['LENGUAJE']}"); ////lenguaje

$tool = new formulario('db');

$ide = $tool->getvar('id');

if (!empty($ide)) {

    $dato = $tool->simple_db("SELECT 
  date_format(c.fecha, '{$_SESSION['DB_FORMATO_DB']}') AS fecha,
  ifnull((select concat(a.nombre, ' ', a.apellido) from tbl_admin a where a.id = c.autor),'" . LANG_content_autor_unknow . "') as prof,
  (select count(*) from tbl_contenido_recurso where contenido_id = c.id  ) AS cant,
  c.leido,
  trim(c.titulo) as titulo,
  c.autor
  FROM
  tbl_contenido c
  WHERE  (c.id = '$ide')");

    ////VACIA LA VARIABLE PARA CONTAR CASOS
    if (isset($_SESSION['CONTARCONT']))
        unset($_SESSION['CONTARCONT']);


    $_SESSION['CASO_TITULO'] = $dato['titulo']; ////ASIGANDO EL TITULO
    $_SESSION['CASO_FECHA'] = $dato['fecha']; ////ASIGANDO EL FECHA
    $_SESSION['CASO_AUTOR'] = $dato['prof']; ////ASIGANDO EL FECHA
}else {

    $dato['titulo'] = '-';
    $dato['fecha'] = '-';
    $dato['prof'] = '-';
    $dato['cant'] = '-';
    $dato['leido'] = '-';
    $dato['autor'] = '-';
}

$_SESSION['CASOACTUAL'] = $ide; ////ASIGANDO EL ID DEL CONTENIDO

$tool->cerrar();

print json_encode($dato);
?>