<?php

require_once("../../class/menu.php"); ////////clase
$menu_struct = array(
      "nombre" => LANG_content_files, /// mensaje si no se encuentran registros
      "ancho" => "100%", /// mensaje si no se encuentran registros
      "aliniado" => "left", /// el nombre de la clase de estilo class=""
      "padding" => 0, /// el nombre de la clase de estilo class=""
      "spacing" => 0, /////numero de la columna por la cual se desea sacar un total
      "b_color" => "#000000", /////numero de la columna por la cual se desea sacar un total
      "b_color_un" => "#B1C4CF", /////numero de la columna por la cual se desea sacar un total
      "b_color_se" => "#FFFFFF", /////numero de la columna por la cual se desea sacar un total
      "items" =>  array(0 => LANG_content_files2, 1 => LANG_content_links, 2 => LANG_content_video),
      "url"  => array(0 => "index.php", 1 => "links.php", 2 => "videos.php"),
      "ancho_i"  => array(0 => "33%", 1 => "33%", 2 => "*")
);
