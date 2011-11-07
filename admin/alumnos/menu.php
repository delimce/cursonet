<?php 

require_once("../../class/menu.php"); ////////clase
      $menu_struct = array (
	   "nombre" => LANG_students, /// mensaje si no se encuentran registros
       "ancho" => "100%", /// mensaje si no se encuentran registros
       "aliniado" => "left", /// el nombre de la clase de estilo class=""
       "padding" => 0, /// el nombre de la clase de estilo class=""
       "spacing" => 0, /////numero de la columna por la cual se desea sacar un total
	   "b_color" => "#000000", /////numero de la columna por la cual se desea sacar un total
	   "b_color_un" => "#B1C4CF", /////numero de la columna por la cual se desea sacar un total
	   "b_color_se" => "#FFFFFF", /////numero de la columna por la cual se desea sacar un total
       "items" =>  array(0 => "Est. Dentro del curso", 1 => "Est. Fuera del curso",2 => "Crear",3 => "Buscar"),
	   "url"  => array(0 => "index.php", 1 => "index2.php", 2 => "crear.php", 3=> "buscar.php"),
	   "ancho_i"  => array(0 => "30%", 1 => "30%", 2 => "20%", 3 => "*")
          );
?>