<?php 

require_once("../../class/menu.php"); ////////clase
      $menu_struct = array (
	   "nombre" => LANG_config, /// mensaje si no se encuentran registros
       "ancho" => "100%", /// mensaje si no se encuentran registros
       "aliniado" => "left", /// el nombre de la clase de estilo class=""
       "padding" => 0, /// el nombre de la clase de estilo class=""
       "spacing" => 0, /////numero de la columna por la cual se desea sacar un total
	   "b_color" => "#000000", /////numero de la columna por la cual se desea sacar un total
	   "b_color_un" => "#B1C4CF", /////numero de la columna por la cual se desea sacar un total
	   "b_color_se" => "#FFFFFF", /////numero de la columna por la cual se desea sacar un total
       "items" =>  array( 0 => LANG_est_viewteachers,1=>LANG_curso_cursos, 2 => "Modalidad", 3 => "Preferencias", 4=>"Sistema", 5=>"Reiniciar"),
	   "url"  => array(0 => "index.php",1 => "curso.php", 2 => "modo.php", 3 => "pref.php",4=>"sistema.php",5=>"restart.php"),
	   "ancho_i"  => array(0 => "17%", 1 => "17%", 2 => "17%", 3 => "17%", 4 => "17%", 5 => "*")
          );
?>