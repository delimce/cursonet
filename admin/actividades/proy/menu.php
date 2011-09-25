<?php 

require_once("../../../class/menu.php"); ////////clase
      $menu_struct = array (
	   "nombre" => "Prediscusion / Actividades / Proyectos", /// mensaje si no se encuentran registros
       "ancho" => "100%", /// mensaje si no se encuentran registros
       "aliniado" => "left", /// el nombre de la clase de estilo class=""
       "padding" => 0, /// el nombre de la clase de estilo class=""
       "spacing" => 0, /////numero de la columna por la cual se desea sacar un total
	   "b_color" => "#000000", /////numero de la columna por la cual se desea sacar un total
	   "b_color_un" => "#B1C4CF", /////numero de la columna por la cual se desea sacar un total
	   "b_color_se" => "#FFFFFF", /////numero de la columna por la cual se desea sacar un total
       "items" =>  array( 0 => "mostrar",1 => "crear",2 => "Asignar recursos",3 => "Detalles"),
	   "url"  => array(0 => "index.php", 1 => "crear.php", 2 => "recursos.php",3 => "detalles.php"),
	   "ancho_i"  => array(0 => "25%", 1 => "25%", 2 => "25%",3 => "25%")
          );
?>