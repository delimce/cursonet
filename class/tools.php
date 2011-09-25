<?php

 // llamando la super clase base de datos

 if (!class_exists('database')) {
   require_once('database.php');
 }


 /***************************************************************************
  clase que cosntruye diversas herramientas fopara usar en la construccion de forms
  IMPORTANTE: por defecto se asume que se esta conectado a la base de datos
  en caso de que desee llamar herramientas del tipo database
 ****************************************************************************/

 class tools extends  database {

 //**********************************************atributos


 //********************************************* metodos de tools



/********************************************** CONSTRUCTOR */

  function __construct ($conect=''){ ///constructor de la clase

     if(!empty($conect)){

      		/////conexion de dos vistas
            if($conect=="db") $this->autoconexion();

     }


  }


 //--------------------------------- operaciones con db


   ///////////// Funcion que construye una estrctura tipo registro c++ con todas las tuplas
  /*  las tuplas resultantes de la consulta solo recibe la consulta sql para generar la
  /*  estructura esta se trabaja como si fuera un arreglo asociativo con n elementos
  /*  numero de registros, devuelve una estructura manipulable */

  function estructura_db($query){

      $this->query($query);  //llamando las funciones de la clase database heredada
      $campos = $this->campos_query();

      $i=0;

      while ($row = $this->db_vector_num()) {    //N de registros

           for($j=0;$j<count($campos);$j++){   ////N campos

               $a[$i][$campos[$j]] = stripslashes($row[$j]);

           }

           $i++;
        }

       $this->liberar();
       return $a;

  }




   ///////////// Funcion que construye una fila de datos dentro de un vector asociativo
  /*  las tuplas resultantes de la consulta solo recibe la consulta sql para generar la
  /*  estructura esta se trabaja como si fuera un arreglo asociativo con n elementos
  /*  numero de registros, y solo 1 fila  NOTA: en el caso de un solo valor se puede utilizar el nombre de arreglo sin indice*/

  function simple_db($query){

       $this->query($query);  //llamando las funciones de la clase database heredada
       $campos = $this->campos_query();
       $row = $this->db_vector_num();

      if(count($campos)<=1){

          $a = stripslashes($row[0]);

      }else{

     for($j=0;$j<count($campos);$j++) $a[$campos[$j]] = stripslashes($row[$j]);

    }

       $this->liberar();
       return $a;

  }


	/////////funcion para buscar un elemento en una estructura db, se necesita el arreglo, el elemento y en la columna
	/////////clave donde se desea buscar, retorna el primer valor del elemento en la posicion del valor de la columna a consultar
	///////// en el parametro consultar

	function buscar_estructdb($matriz,$clave,$elemento,$consultar){
	
		 		  
		   for($j=0;$j<count($matriz);$j++){
		   
		    if($matriz[$j][$clave] == $elemento){ $a = $matriz[$j][$consultar]; break;  }
	
		  }   
	
		   return $a;
	
	  }



  /////////////////funcion que crea un objeto combo a partir de una sentencia sql
  //// parametros: 1: id/nombre, 2: query, 3:opcion(campos del query) 4: valor (campos del query)
 /// opcionales: 5: primer valor por defecto (seleccionar ejemplo: cualquiera o seleccione),
  //// 6: seleccion (valor de la variable a seleccionar $id, variable),
  //// 7: on submit();
  //// 8. en caso de no conseguir ningun registro
  //// 9. si se desea seleccion multiple
  //// 10. desabilitar combo true o false

   function combo_db ($id,$query,$option,$value,$select=false,$seleccion=false,$onchange=false,$noreg='',$multiple=false,$desabilita=false,$estilo=false){

      $this->query($query);  //llamando las funciones de la clase database heredada

      if($this->nreg>0){

     $combo = '<select name="'.$id.'" id="'.$id.'"';
     if($onchange)$combo.=' onChange="'.$onchange.'"';
     if($multiple)$combo.=' multiple size = "'.($this->nreg/2+1).'" ';
     if($desabilita)$combo.=' disabled="disabled"';
	 if($estilo)$combo.=' class="'.$estilo.'"';
     $combo.= '>';
     if($select) $combo.= '<option value="">'.$select.'</option>';
     if(!$seleccion)$seleccion = $_REQUEST[$id];

    while ($row = mysql_fetch_assoc($this->result)) {
        $combo.= '<option value="';
        $combo.= stripslashes($row["$value"]);
        $combo.= '"';
        if($seleccion == $row["$value"]) $combo.= ' selected';
        $combo.= '>';
        $combo.= $row["$option"];
        $combo.= '</option>';
     }
    $combo.= '</select>';

    }else{

            $combo = '<b>'.$noreg.'</b>';
    }


      $this->liberar();
      return $combo;

   }



   ///// combo array, construye un comobo select a partir de un vector


    /////////////////funcion que crea un objeto combo a partir de una sentencia sql
  //// parametros: 1: id/nombre, 2: arreglo (option), 3:array 2 (value)
  /// opcionales: 4: primer valor por defecto (seleccionar ejemplo: cualquiera o seleccione),
  //// 5: seleccion (valor de la variable a seleccionar $id, variable),
  //// 6: on submit();
  //// 7. en caso de no conseguir ningun registro
  //// 8. si se desea seleccion multiple
  //// 9. desabilitar combo true o false


  function combo_array ($id,$array,$array2,$select=false,$seleccion=false,$onchange=false,$noreg='',$multiple=false,$desabilita=false,$estilo=false){

      if(count($array)>0){

     $combo = '<select name="'.$id.'" id="'.$id.'"';
      if($onchange)$combo.=' onChange="'.$onchange.'"';
     if($multiple)$combo.=' multiple size = "'.(count($array)/2+1).'" ';
     if($desabilita)$combo.=' readonly="true"';
	 if($estilo)$combo.=' class="'.$estilo.'"';
     $combo.= '>';
     if($select) $combo.= '<option value="">'.$select.'</option>';
     if(!$seleccion)$seleccion = $_REQUEST[$id];
     $i=0;

    while($i<count($array)) {
        $combo.= '<option value="';
        $combo.= $array2[$i];
        $combo.= '"';
        if($seleccion == $array2[$i]) $combo.= ' selected';
        $combo.= '>';
        $combo.= $array[$i];
        $combo.= '</option>';
        $i++;
     }
    $combo.= '</select>';

    }else{

            $combo = '<b>'.$noreg.'</b>';
    }

      return $combo;

   }



   /// construye un vector simple (1 campo n registros) a partir de un query sql

   function array_query($query){

        $i=0;
        $this->query($query); //ejecuta el query
        while ($row = @mysql_fetch_row($this->result)){
                $vector[$i] =  stripslashes($row[0]);
                $i++;
        }
        $this->liberar();
        return $vector;
   }




      /// construye un vector simple ((1 registro n campos) a partir de un query sql

   function array_query2($query){

        $i=0;
        $this->query($query); //ejecuta el query
        $campos = $this->campos_query();
        $row = @mysql_fetch_row($this->result);   ///se trae el primer registro

        while ($i < count($campos)){
                $vector[$i] =  stripslashes($row[$i]);
                $i++;
        }


        $this->liberar();
        return $vector;
   }







 //------------------------------------- operaciones sobre arrays





 ///////////////// encuentra la posicion en donde se encuentra el elemento en el vector
 //////////////// parametros 1: elemento a buscar, 2: vector en donde busca

  function seencuentra($buscar,$en){
        $i=0;
        $pos=false;
    while(($i<count($en))and($pos==false)){
        if($buscar==$en[$i]){
                $pos = true;
                break;
                }
         $i++;
    }
     if($pos) return $i; else return false;
 }



  //////////////////metodos para ARREGLOS

  ///limpia de un vector el elemento deseado, devuelve todo lo distinto a elelemento en sus posiciones

  function limpiar_array($array,$element){
          $j=0;
          for($i=0;$i<count($array);$i++){
                  if($array[$i]!=$element){
                        $nuevo[$j] = $array[$i];
                        $j++;
                  }
          }

          return $nuevo;

  }


  ///Suma todos los elementos de un vector

  function suma_array($array){

       $result = 0;

          for($i=0;$i<count($array);$i++){

                 $result+= $array[$i];
          }

          return $result;

  }




 ///// llena un vector de elementos separados por comas un vector

   function llenar_array($ELEMENTOS){

    $elementos = explode(",",$ELEMENTOS);

   for($i=0;$i<count($elementos);$i++){

      $ARRAY[$i] = $elementos[$i];

   }

     return $ARRAY;

   }


function burbuja($array,$modo=0){

          for ($i=1; $i<count($array); $i++){
               for ($j=0; $j<count($array)-1; $j++){

                    if($modo==0){

                          if ($array[$j]>$array[$j+1]){
                             $temp = $array[$j];
                             $array[$j] = $array[$j+1];
                             $array[$j+1] = $temp;
                          }

                     }else{

                         if ($array[$j]<$array[$j+1]){
                             $temp = $array[$j];
                             $array[$j] = $array[$j+1];
                             $array[$j+1] = $temp;
                          }

                     }


               }
           }

           return  $array;
  }



  ////////////extrae los elementos unicos (elimina los repetidos)

 function unicos($estos){

 $i = 1;
 $j = 1;
  if(count($estos)>0){ ///para saber que por lo menos uno tiene

   $result[0] = $estos[0];
   while($i<count($estos)){  //////while

    if(!in_array($estos[$i],$result)){  $result[$j] = $estos[$i]; $j++;  }

     $i++;

    }////while

   }

   return  $result;

 }


  //// valida se el arreglo tiene elementos repetidos       TRUE O FALSE
  function repetidos ($array){
          $repeat  = @array_unique($array);
          if(count($repeat)!= count($array)) return true; else return false;
  }

  //// retorna el arreglo con el elemento eliminado
  function eliminar_de (&$array,$element){

  	$pos = array_search($element, $array);
  	for($i=$pos;$i<count($array);$i++){
  		
  		$array[$i] = $array[$i+1];
  	}
  	array_pop($array);
  	return $array;
  	
  }
  
  
   //// retorna el numero de veces que se repite un elemento $element dentro de un vector $array
  function se_repite (&$array,$element){

	$veces = 0;
  	for($i=0;$i<count($array);$i++){
  		
  		if($array[$i] == $element) $veces++;
  	}
  	
  	return $veces;
  	
  }

  
  

  /////////////////////////////// otras funciones

  ///function que redirecciona a alguna direccion url, parent (opcional)
  ///nota si se desea cerrar un popup coloque el texto: cerrar

      function redirect($url,$parent=''){

                if($parent!='') $parent.='.';
				
				if($url=="cerrar") $var = "window.close();"; else $var = "$parent"."location.replace('$url');";

                     echo " <script language=\"JavaScript\"
                        type=\"text/javascript\">
                        $var
                         </script>";

                die();

      }


  /////////funcion para mostrar un aviso en javascript y redireccionar si asi se quiere

    function javaviso($aviso,$url=false){

         
         echo "<script language=\"JavaScript\" type=\"text/javascript\">
         alert('$aviso');
         $url
         </script>";

         if($url) $this->redirect($url);


    }



   ///////////devolver el formato original del texto ingresado en la base de datos usando la funcion inserar o update
   ////////// nota esta funcion recibe el campo texto y lo formatea con los caracteres originales usados
   ///////// todos los campos de texto que se repliegan deberian mostrarse con esta funcion

    function format_txt($texto,$textarea=false){

      ///////conversion

      if(!$textarea) $contenido = str_replace('\r\n','<p>', mysql_escape_string ($texto));
      $contenido = str_replace('\\','',$contenido);

      ///////////

      return $contenido;

   }



////// abreviar necesita el texto a abreviar y el numero de caracteres a los que se va a reducir
   function abreviar($texto,$cmax){

      ///////conversion

      $frase = '<span title="'.$texto.'">';
      if(strlen($texto)>$cmax) $frase.= substr($texto, 0, $cmax).'...';
      $frase.= '</span>';
      ///////////

      return $frase;

   }




  ////////////////////////////////////////////////METODOS PARA ARCHIVOS//////////////////////////////
  ///////////////////////////////////////////////////////////////////////////////////////////////////
  
  
  ////subir archivos funcion que sube un archivo de un origen a un destino con ciertas validaciones
  //// parametros
  //// origen: archivo subido con un campo file de un form   $_FILES['archivo']
  //// destino: ruta en donde sera copiado el archivo (incluyendo en nombre del archivo) ej: ../files/nuevo.gif   nota: por defecto sube al mismo dir con el mismo nombre
  //// tmax: tamano maximo del archivo a subir en MB por defecto ilimitado 
  //// tipo: tipos de archivo que acepta por defecto cualquiera separados por comas eje: image/gif,image/jpeg,text/plain,application/octet-stream,application/zip,application/force-download
  ///// para ams informacion o conocer el tipo del archivo que desea subir en http://www.cs.tut.fi/~jkorpela/forms/file.html
  //// overwrite si acepta over write por defecto true
  
   function upload_file($origen,$destino=false,$tmax=false,$tipo=false,$overwrite=true){
  
  	
	if(!$destino) $destino = $origen['name'];
		
	
	//////valida el tamano maximo
	if($tmax){
		$tama =  bcdiv($origen['size'],1048576,2); ///tamano en mb
		if($tama>$tmax){ $this->javaviso("El archivo es demasiado grande");
		return false;
		}
	}
	
	
	//////valida el tipo de archivo
	if($tipo){
		
		$vectortipo = explode(",",strtolower($tipo)); 
		
		if(!in_array(strtolower($origen['type']),$vectortipo)){
			
		$this->javaviso("El tipo de archivo a subir es invalido");
		return false;
			
			
		}
		

	}
	
	
	////////////valida si ya existe
	if($overwrite==false){ ////en caso de que no acepte sobre escribir no guarda el archivo
		
		if (file_exists($destino)) {
			
			$this->javaviso("Ya existe un archivo con el mismo nombre");
			return false;
			
		}
  
		
	}
	
	
	
	  ////////////proceso de subir el archivo
	
	
	///////verificando si en efecto se subio
	
	if (!is_uploaded_file($origen['tmp_name'])) {
	
		$this->javaviso("Error al subir el archivo, Verifique los permisos de escritura en el directorio ' $destino ' ó intente subir otro archivo ");
	 	return false;
		
	}

		

	 if(!move_uploaded_file($origen['tmp_name'], $destino)){

	 	$this->javaviso("Error al subir el archivo, quizas este corrupto");
	 	return false;

	 }else{
		 
		 
		 ///////////////se debe verificar si el archivo en efecto se subio buscandolo en el destino
		 
		 

	 	return true;

	 }


	///////////////////////////
	
  
  }
  
  


  ///// esta funcion devuelve tosdos los elementos de un directorio en un array
  //////// con solo especificar el path

   function listar_archivos($dirname=".") {
     $i=0;
     if($handle = opendir($dirname)) {
       while(false !== ($file = readdir($handle))) {
           if (($file!='..') && ($file!='.') && ($file!='Thumbs.db')){
                     $files[$i] = $file;
                     $i++;
              }
        }
           closedir($handle);
     }
        return($files);
    }


  ////////////////////////////////////////////////////////////////////

   function combo_dir($id,$path,$select=false,$seleccion=false,$submit=false,$noreg,$multiple=false,$desabilita=false){

     $array = $this->listar_archivos($path);

     if(count($array)>0){

     $combo = '<select name="'.$id.'" id="'.$id.'"';
     if($submit)$combo.=' onChange="submit();"';
     if($multiple)$combo.=' multiple size = "'.(count($array)/2+1).'" ';
     if($desabilita)$combo.=' readonly="true"';
     $combo.= '>';
     if($select) $combo.= '<option value="">'.$select.'</option>';
     $i=0;

    while($i<count($array)) {
        $combo.= '<option value="';
        $combo.= $array[$i];
        $combo.= '"';
        if($seleccion == $array[$i]) $combo.= ' selected';
        $combo.= '>';
        $combo.= $array[$i];
        $combo.= '</option>';
        $i++;
     }
    $combo.= '</select>';

    }else{

            $combo = '<b>'.$noreg.'</b>';
    }

      return $combo;


   }
   

   
 ///funcion que borra todos los elementos de un directorio
 ///parametros: $dirname ruta del directorio, y si borra el directorio o no?   
 function del_archivos_dir($dirname,$borra=false) {
    if ($dirHandle = opendir($dirname)) {
        chdir($dirname);
        while ($file = readdir($dirHandle)) {
            if ($file == '.' || $file == '..') continue;
            if (is_dir($file)) rmdir_rf($file);
            else unlink($file);
        }

        if($borra){
        	 chdir('..');
       		 rmdir($dirname);
        }
       
        
        
        closedir($dirHandle);
    }
}



 } //// fin de la clase tool



?>