<?php

 // llamando la super clase base de datos

 /***************************************************************************
  clase que cosntruye un grid formateado a partir de una consulta sql
  IMPORTANTE: por defecto se asume que se esta conectado a la base de datos
  de no ser asi se debe llamar el constructor 2
 ****************************************************************************/

 class grid extends  database {


  //***********************************************formato
  var $campos; //vector de campos que se solicitan en el query
  var $ancho;
  var $largo;
  var $align;
  var $features;
  var $orden; ////atributo para ordenar las columnas el grid
  var $totalizado = 0; /////atributo que muestra el valor del totalizado por colum (si es que existe)
  var $capsula = '';

 //*************************************************** propiedades

 //funciones para descanectarse o liberar recursos


/// funcion que valida si los campos deseados son iguales a los campos por defecto
 function validar_head($campos){

        $campos2 = explode(",",$campos);

        if(count($campos2)!=count($this->campos)){
                echo "<font color=#FF0000>incorrect parameters in function cargar(): fields wrong </font>";
                die();
        }else{
                $this->campos = $campos2;
        }

 }


  /// funcion para saber el total de campos consultados del query
 function total_campos(){

         return count($this->campos);

 }




//********************construccion del grid   parametros
/*
/* ***********************   colocar los siguientes parametros para formar el grid
/*
/*
/*     $estilo: hoja de estilo en cascada (ccs) por defecto
/*     $ancho: medida 100% (default) %/pixels
/*     $largo: medida 100% (default) %/pixels
/*     $aling: alinacion: 1:left(default), 2:center, 3:right
/*     $feature: estructura para darle funcionalidad al grid
/*
/*     (ejemplo para crear las caracteristicas avanzadas del grid
/*
/*
/*    $features = array (
       "borde" => array("cellpadding" => "[%/pixel]", "cellspacing" => [%/pixel],  "style" => "[cadena]"),
       "mostrar_nresult" => array("mesaje" => "[cadena]",////texto que aparecera junto con el numero si existen resultados, "style" => "[cadena]", "align" => [cadena] ///alineacion ),
       "no_registers" => [cadena] /// mensaje si no se encuentran registros
       "style_body" => [cadena] /// el nombre de la clase de estilo class=""
       "style_head" => [cadena] /// el nombre de la clase de estilo class=""
       "totalizado" => [numero] /////numero de la columna por la cual se desea sacar un total
       "r_header" => [numero] /////cada cuantos registros se repite el header
       "formato" => "tipo (html/texto)"    /////el formato de los valores
       "abreviar" =>  array([numero]  (columna a abreviar) pueden ser varias => [numero] cantidad de caracteres permitidos,...);
       "orden" => array("nombre" => [nombre de la var orden], "defecto" => [cadena] campo de ordenamiento por defecto, "extras" => "&variable=valor");
       "nuevo_vinculo1"  => array("nombre" => "[cadena]", "texto" => "[cadena](texto o imagen)", "title" => "[texto] alt", "url" => "[cadena] no olvidar el '?' en caso de que pase un parametro","target" => [cadena], "parametro" => [numero posicion que ocupa la columana que se quiere pasar como parametro], "var_parametro"=>[cadena] nombre de la variable a pasar por parametro , "popup"=>[nombre de la ventana] esta opcion solo funciona si hay una funcion que abra el link en popup, "condicion" posicion del campo de la consulta, "texto_condicion" lo que escribe si se cumple la condicion  ),
       "nuevo_vinculo2"  => array("nombre" => "[cadena]", "texto" => "[cadena](texto o imagen)", "title" => "[texto] alt", "url" => "[cadena] no olvidar el '?' en caso de que pase un parametro","target" => [cadena], "parametro" => [numero posicion que ocupa la columana que se quiere pasar como parametro], "var_parametro"=>[cadena] nombre de la variable a pasar por parametro , "popup"=>[nombre de la ventana] esta opcion solo funciona si hay una funcion que abra el link en popup ),
       "conenlace"  => array("pos" => "[numero] posicion de la columna del grid que lleva el vinculo", "title" => "[texto] alt", "url" => "[cadena] no olvidar el '?' en caso de que pase un parametro","target" => [cadena], "parametro" => [numero posicion que ocupa la columana que se quiere pasar como parametro], "var_parametro"=>[cadena] nombre de la variable a pasar por parametro , "popup"=>[nombre de la ventana] esta opcion solo funciona si hay una funcion que abra el link en popup,"extras" => "&variable=valor" ),
       "separacion" =>  array(0 => [numero  (%/px)], 1 => "[cadena]", 3 => [cadena]...);
       "alineacion"  => array(0 => [cadena  (left,rigt,center)], 1 => "[cadena]", 3 => [cadena]...);
       "celda_vacia" => "[valor lo que se desea que aparezca si la celda es vacia]"
       "nulo" => "[cadena] valor que se desea hacer nulo dentro del grid y en su lugar colocar el valor celda vacia"
       "oculto" =>[cadena] "0,1..." /////numeros de la columnas separadas por comas que se desean ocultar del grid
       "dateformat" =>array("pos" => [cadena] "0,1...", "formato" => "formato") /////NUEVO posiciones a mostrar con formato de fecha x y poder ordenar efectivamente el campo debe ser un valor datetime  

      );
/*
/*
/*
/*
/*
/*
/*
/*
/*
/********************************************************************/


//********************************************* metodos

  function grid($ancho,$largo,$align,$features) {     //costructor

     $this->ancho = $ancho;
     $this->largo = $largo;
     $this->align = $align;
     $this->features = $features;

     if(isset($_GET[$this->features['orden']['nombre']]))
       $this->orden = $_GET[$this->features['orden']['nombre']];  ///variable reservada para ordenar el grid
     else
       $this->orden = $this->features['orden']['defecto'];  ///campo de orden por defecto



    if(!isset($this->features['r_header']))  ///en caso de que el orden sea nulo
       $this->features['r_header'] = -1;


  }



  ////////////////// para fechas de tipo db datatime '0000-00-00 00:00:00' para usar sin heredar la clase fecha

   function datetime($datetime,$formato=false) {

       if($formato) $format = $formato; else $format = $this->formato;

       $pattern = "/^(\d{4})-(\d{2})-(\d{2})\s+(\d{2}):(\d{2}):(\d{2})$/i";

       if($datetime == "0000-00-00 00:00:00" || $datetime == "0000-00-00"){

        return "00/00/0000";

       }else if(preg_match($pattern, $datetime, $dt) && checkdate($dt[2], $dt[3], $dt[1])) {

         return @date($format, mktime($dt[4], $dt[5], $dt[6], $dt[2], $dt[3], $dt[1]));

       } else {

         return $datetime;

       }

    }


  /////////////////// override del metodo query de database.class para el grid
  

   function query($query) {

       if(isset($this->orden))$query.=' ORDER BY '.$this->orden ;
       Database::query($query);

    }




  /******************************************************************************************

     $query: query que se trae los campos que se desean mostrar en el grid
   ///IMPORTANTE: no hace falta en el query mandar a ordenar  (uso de la clausula order by)
   /// el grid permite ordenar por cualquiera de los campos consultados, si se coloca la clausula  order by
   ///dara error!!!


  /* $campos: nombre de las colums(default), nombre de los titulos separados por comas si desea agregarlos ud
 /* $result se pasa el parametro result=true si el query fue ejecutado anteriormente y se almaceno la info sino este se omite por false

  ******************************************************************************************/

  function cargar($query,$campos=false,$result=false){

    
     if($result==false)$this->query($query);  //llamando las funciones de la clase database heredada
     $this->campos = $this->campos_query($this->result);
     if(isset($this->orden))$orden =  $this->campos; ////vector para ordenar columnas
     $registros = 0; ///////////////contador para los registros
     $tamvardb = count($this->campos);
     ////////// para ocultar columnas
     if(isset($this->features['oculto'])) $ocultos = explode(',',$this->features['oculto']);

     ////////// para FORMATEAR FECHAS
     if(isset($this->features['dateformat'])) $fformat = explode(',',$this->features['dateformat']["pos"]);


     /////si no se encuentran registros
     if ($this->nreg == 0){

             echo "<b>{$this->features['no_registers']}</b>";
     }else{


     if($campos)$this->validar_head($campos); ///campos de cabecera

     /////////////////vinculos independientes de los valores del grid (hasta ahora solo 2 permitidos)
     //////////////////////////////////////////// feature nuevo vinculo 1
      if(isset($this->features['nuevo_vinculo1'])) $this->campos[count($this->campos)] = $this->features['nuevo_vinculo1']['nombre'];  ///colocando la posicion del campo
     //////////////////////////////////////////// feature nuevo vinculo 2
      if(isset($this->features['nuevo_vinculo2'])) $this->campos[count($this->campos)] = $this->features['nuevo_vinculo2']['nombre'];  ///colocando la posicion del campo
    ////////////////////////////////////////////////////////////////////////////////////


     echo '<table width="'.$this->ancho.'" height="'.$this->largo.'" align="'.$this->align.'" border="0" cellspacing="0" cellpadding="0">';  ////tabla principal

    ////////////////// si se desea mostrar el numero de registros conseguidos

     if(isset($this->features['mostrar_nresult'])){

      echo '<tr>';

      echo '<td class="'.$this->features['mostrar_nresult']['style'].'" align="'.$this->features['mostrar_nresult']['align'].'">'.$this->features['mostrar_nresult']['nombre'].': '.$this->nreg.'</td>';

      echo '</tr>';

     }

   echo '<tr><td>';

   if(isset($this->features['borde'])){

      echo '<table class="'.$this->features['borde']['style'].'" width="100%" height="100%" cellpadding="0"  cellspacing="0">
   <tr><td align="center">';

      }


     ///armando grid

     echo '<table width="100%" height="100%" class="" border="0" cellspacing="'.$this->features['borde']['cellspacing'].'" cellpadding="'.$this->features['borde']['cellpadding'].'">';

     while($tmp = $this->db_vector_num($this->result)){

       //////////////////inicio fila de datos


      if(!is_float($registros/$this->features['r_header']) && $registros/$this->features['r_header'] >=0  ){   ///condicion para desplegar el header

		echo '<tr>'; 
           ///////////////////////////////////////////////// header
     

       for($i=0;$i<count($this->campos);$i++){

        if(@in_array($i,$ocultos) && isset($this->features['oculto'])){ echo ' <!-- '; $OCU = 1; }  ///ocultando si asi se desea

         if($orden[$i]!=""){

           echo '<td  class="'.$this->features['style_head'].'" width= "'.$this->features['separacion'][$i].'" align="center"><a href="'.$PHP_SELF.'?'.$this->features['orden']['nombre'].'='.$orden[$i].$this->features['orden']['extras'].'" title="'.LANG_orderby.$this->campos[$i].'">'.$this->campos[$i].'</a></td>';  //encabezado

           }else{

                echo '<td align="center">'.$this->campos[$i].'</td>';
           }

          if($OCU==1){ echo ' --> '; $OCU = 0; }  ////ocultando

       }

        echo '</tr>';
 

    ////////////////////////////////////////////////
   

     }
     	
     	echo '<tr class="td_whbk" onmouseover="this.style.backgroundColor = '."'#CCCCCC'".'" onmouseout="this.style.backgroundColor = '."'#FFFFFF'".'">';
     			
		///////////////// si se despliega el header
    

    

      ////////////////////////////////////////mostrando la data de la base de datos
       for($ii=0;$ii<$tamvardb;$ii++){


               if($tmp[$ii]!=''){


                     if($this->features['formato']!="html") $valor =  strip_tags(trim(stripslashes($tmp[$ii])));  else  $valor = trim(stripslashes($tmp[$ii]));
                     if($tmp[$ii]==$this->features['nulo']) $valor = "{$this->features['celda_vacia']}"; /// en caso de que se desee hacer nulo algun valor
                     if(isset($this->features['conenlace']['popup'])) $popup = " onclick=\" return popup2(this,'".$this->features['conenlace']['popup']."');\""; else $popup = '';
                     if(isset($this->features['conenlace']) && $this->features['conenlace']['pos']==$ii){ $enlace = '<a href="'.$this->features['conenlace']['url'].$this->features['conenlace']['var_parametro'].'='.$tmp[$this->features['conenlace']['parametro']].$this->features['conenlace']['extras'].'" target="'.$this->features['conenlace']['target'].'" title="'.$this->features['conenlace']['title'].'"'.$popup.'">'; $enlace2 = '</a>';  }else{ $enlace = ''; $enlace2 = '';  }



               }else{

                    $valor = "{$this->features['celda_vacia']}";

               }



            if(@in_array($ii,$ocultos) && isset($this->features['oculto'])){ echo ' <!-- '; $OCU = 1; }  ///ocultando si asi se desea


             if(!isset( $this->features['abreviar'][$ii])){ //// en caso de abreviacion de clumnas
              
			/////////////FORMATEAR FECHAS
            if(@in_array($ii,$fformat) && isset($this->features['dateformat']))  $valor = $this->datetime($valor,$this->features['dateformat']["formato"]);
 
			 echo '<td class="td_whbk1" align="'.$this->features['alineacion'][$ii].'">'.$enlace.$valor.$enlace2.'</td>';
            
             }else{

                if(strlen($valor)>$this->features['abreviar'][$ii]) $valor = substr($tmp[$ii], 0, $this->features['abreviar'][$ii]).'...';
                echo '<td class="td_whbk1" title="'.strip_tags($tmp[$ii]).'" align="'.$this->features['alineacion'][$ii].'">'.$enlace.$valor.$enlace2.'</td>';

             }

            if($OCU==1){ echo ' --> '; $OCU = 0; }  ////ocultando



      }





      ///////////////////////////////////////mostrando la data del nuevo vinculo 1
      if(isset($this->features['nuevo_vinculo1'])){
          echo '<td align="center">';


           if(!isset($this->features['nuevo_vinculo1']['condicion']) or $tmp[$this->features['nuevo_vinculo1']['condicion']] == 1) {

              if(isset($this->features['nuevo_vinculo1']['popup'])) $popup = " onclick=\" return popup2(this,'".$this->features['nuevo_vinculo1']['popup']."');\""; else $popup = '';
              echo '<a href="'.$this->features['nuevo_vinculo1']['url'].$this->features['nuevo_vinculo1']['var_parametro'].'='.$tmp[$this->features['nuevo_vinculo1']['parametro']].$this->features['nuevo_vinculo1']['extras'].'" target="'.$this->features['nuevo_vinculo1']['target'].'" title="'.$this->features['nuevo_vinculo1']['title'].'"'.$popup.'">'.$this->features['nuevo_vinculo1']['texto'].'</a>';

           }else if(isset($this->features['nuevo_vinculo1']['condicion']) && $tmp[$this->features['nuevo_vinculo1']['condicion']] == 0) { ///no se cumple la condicion

              echo $this->features['nuevo_vinculo1']['texto_condicion'];

           }


        echo '</td>';

      } //////////////// fin mostrando la data del nuevo vinculo 2


       ///////////////////////////////////////mostrando la data del nuevo vinculo 2
      if(isset($this->features['nuevo_vinculo2'])){
          echo '<td align="center">';


              if(isset($this->features['nuevo_vinculo2']['popup'])) $popup = " onclick=\" return popup2(this,'".$this->features['nuevo_vinculo2']['popup']."');\""; else $popup = '';
              if(isset($this->features['nuevo_vinculo2']['borrar'])) $popup = " onclick=\" return borrar('".$tmp[$this->features['nuevo_vinculo2']['parametro']]."','".$tmp[$this->features['nuevo_vinculo2']['borrar']]."');\""; else $popup = '';  //// para borrar un registro del grid experimental
              echo '<a href="'.$this->features['nuevo_vinculo2']['url'].$this->features['nuevo_vinculo2']['var_parametro'].'='.$tmp[$this->features['nuevo_vinculo2']['parametro']].$this->features['nuevo_vinculo2']['extras'].'" target="'.$this->features['nuevo_vinculo2']['target'].'" title="'.$this->features['nuevo_vinculo2']['title'].'"'.$popup.'">'.$this->features['nuevo_vinculo2']['texto'].'</a>';


       echo '</td>';

      } //////////////// fin mostrando la data del nuevo vinculo 2




      echo '</tr>'; ///////////////////////fin fila de datos

      $registros++; ///incrementando contador

      /////////////////////////opera si se desea obtener totalizado
      if(isset($this->features['totalizado'])) $this->totalizado+= $tmp[$this->features['totalizado']];


     } ///////////////////// fin while



     echo '</table>';


      if(isset($this->features['borde'])){

       echo '</td></tr></table>';

      }


     } //si no se encuentran registros

      echo '</td></tr>';
     echo '</table>'; ////tabla principal
    $this->liberar();

  }  //// FIN DEL METODO











     //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
     /////////////////METODO QUE ENCAPSULA EL GRID EN UNA VARIABLE PARA SER OPERADA LUEGO
     ///////////////////crea una variable con todo el contenido del grid para su mejor manipulacion
     ///////////////// cuando se haga un echo de la variable capsula escribira todo el codigo html
     //////////////// ADVERTENCIA : NO USAR PARA ENCAPSULAR GRID DE GRAN TAMA�O LA MEMORIA PUEDE SER MUL LIMITADA






    function encapsular($query,$campos=false,$result=false){     ///////// ENCAPSULA EL GRID EN UNA VARIABLE

     if(isset($this->orden))$query.=' ORDER BY '.$this->orden ;
     if($result==false)$this->query($query);  //llamando las funciones de la clase database heredada
     $this->campos = $this->campos_query($this->result);
     if(isset($this->orden))$orden =  $this->campos; ////vector para ordenar columnas
     $registros = 0; ///////////////contador para los registros
     $tamvardb = count($this->campos);

     $this->capsula = '';

     /////si no se encuentran registros
     if ($this->nreg == 0){

        $this->capsula.=   "<b>{$this->features['no_registers']}</b>";
     }else{


     if($campos)$this->validar_head($campos); ///campos de cabecera

     /////////////////vinculos independientes de los valores del grid (hasta ahora solo 2 permitidos)
     //////////////////////////////////////////// feature nuevo vinculo 1
      if(isset($this->features['nuevo_vinculo1'])) $this->campos[count($this->campos)] = $this->features['nuevo_vinculo1']['nombre'];  ///colocando la posicion del campo
     //////////////////////////////////////////// feature nuevo vinculo 2
      if(isset($this->features['nuevo_vinculo2'])) $this->campos[count($this->campos)] = $this->features['nuevo_vinculo2']['nombre'];  ///colocando la posicion del campo
    ////////////////////////////////////////////////////////////////////////////////////


    $this->capsula.=  '<table width="'.$this->ancho.'" height="'.$this->largo.'" align="'.$this->align.'" border="0" cellspacing="0" cellpadding="0">';  ////tabla principal

    ////////////////// si se desea mostrar el numero de registros conseguidos

     if(isset($this->features['mostrar_nresult'])){

      $this->capsula.=   '<tr class="'.$this->features['mostrar_nresult']['style'].'">';

      $this->capsula.=   '<td align="'.$this->features['mostrar_nresult']['align'].'">'.$this->features['mostrar_nresult']['nombre'].': '.$this->nreg.'</td>';

     $this->capsula.=   '</tr>';

     }

  $this->capsula.=  '<tr><td>';

   if(isset($this->features['borde'])){

     $this->capsula.=  '<table class="'.$this->features['borde']['style'].'" width="100%" height="100%" cellpadding="0"  cellspacing="0">
   <tr><td align="center">';

      }


     ///armando grid

    $this->capsula.=  '<table width="100%" height="100%" class="" border="0" cellspacing="'.$this->features['borde']['cellspacing'].'" cellpadding="'.$this->features['borde']['cellpadding'].'">';

     while($tmp = $this->db_vector_num($this->result)){

      $this->capsula.=  '<tr>';  //////////////////inicio fila de datos


      if(!is_float($registros/$this->features['r_header']) && $registros/$this->features['r_header'] >=0  ){   ///condicion para desplegar el header


           ///////////////////////////////////////////////// header
      $this->capsula.=  '<tr class="'.$this->features['style_head'].'">';

       for($i=0;$i<count($this->campos);$i++){

         if($orden[$i]!=""){

           $this->capsula.=  '<td width= "'.$this->features['separacion'][$i].'" align="center"><a href="'.$PHP_SELF.'?'.$this->features['orden']['nombre'].'='.$orden[$i].$this->features['orden']['extras'].'">'.$this->campos[$i].'</a></td>';  //encabezado

           }else{

                $this->capsula.=  '<td align="center">'.$this->campos[$i].'</td>';
           }

       }

        $this->capsula.=  '</tr>';


    ////////////////////////////////////////////////


     } ///////////////// si se despliega el header

      ////////////////////////////////////////mostrando la data de la base de datos
      for($ii=0;$ii<$tamvardb;$ii++){


               if($tmp[$ii]!=''){


                     if($this->features['formato']!="html") $valor = strip_tags(trim($tmp[$ii]));  else  $valor = trim($tmp[$ii]);
                     if($tmp[$ii]==$this->features['nulo']) $valor = "{$this->features['celda_vacia']}"; /// en caso de que se desee hacer nulo algun valor
                     if(isset($this->features['conenlace']) && $this->features['conenlace']['pos']==$ii) $valor = '<a href="'.$this->features['conenlace']['url'].$this->features['conenlace']['var_parametro'].'='.$tmp[$this->features['conenlace']['parametro']].$this->features['conenlace']['extras'].'" target="'.$this->features['conenlace']['target'].'" title="'.$this->features['conenlace']['title'].'"'.$popup2.'">'.$valor.'</a>';


               }else{

                    $valor = "{$this->features['celda_vacia']}";

               }



             if(!isset( $this->features['abreviar'][$ii])){ //// en caso de abreviacion de clumnas
               $this->capsula.=  '<td class="'.$this->features['style_body'].'" align="'.$this->features['alineacion'][$ii].'">'.$valor.'</td>';
             }else{

                if(strlen($valor)>$this->features['abreviar'][$ii]) $valor = substr($tmp[$ii], 0, $this->features['abreviar'][$ii]).'...';
               $this->capsula.=  '<td title="'.$tmp[$ii].'" class="'.$this->features['style_body'].'" align="'.$this->features['alineacion'][$ii].'">'.$valor.'</td>';

             }
      }




      ///////////////////////////////////////mostrando la data del nuevo vinculo 1
      if(isset($this->features['nuevo_vinculo1'])){
          $this->capsula.=  '<td class="'.$this->features['style_body'].'" align="center">';
              if(isset($this->features['nuevo_vinculo1']['popup'])) $popup = " onclick=\" return popup2(this,'".$this->features['nuevo_vinculo1']['popup']."');\""; else $popup = '';
              $this->capsula.=  '<a href="'.$this->features['nuevo_vinculo1']['url'].$this->features['nuevo_vinculo1']['var_parametro'].'='.$tmp[$this->features['nuevo_vinculo1']['parametro']].$this->features['nuevo_vinculo1']['extras'].'" target="'.$this->features['nuevo_vinculo1']['target'].'" title="'.$this->features['nuevo_vinculo1']['title'].'"'.$popup.'">'.$this->features['nuevo_vinculo1']['texto'].'</a>';
          $this->capsula.=  '</td>';

      } //////////////// fin mostrando la data del nuevo vinculo 1


       ///////////////////////////////////////mostrando la data del nuevo vinculo 2
      if(isset($this->features['nuevo_vinculo2'])){
        $this->capsula.=  '<td class="'.$this->features['style_body'].'" align="center">';
              if(isset($this->features['nuevo_vinculo2']['popup'])) $popup = " onclick=\" return popup2(this,'".$this->features['nuevo_vinculo2']['popup']."');\""; else $popup = '';
              if(isset($this->features['nuevo_vinculo2']['borrar'])) $popup = " onclick=\" return borrar('".$tmp[$this->features['nuevo_vinculo2']['parametro']]."');\""; else $popup = '';  //// para borrar un registro del grid experimental
             $this->capsula.=  '<a href="'.$this->features['nuevo_vinculo2']['url'].$this->features['nuevo_vinculo2']['var_parametro'].'='.$tmp[$this->features['nuevo_vinculo2']['parametro']].$this->features['nuevo_vinculo2']['extras'].'" target="'.$this->features['nuevo_vinculo2']['target'].'" title="'.$this->features['nuevo_vinculo2']['title'].'"'.$popup.'">'.$this->features['nuevo_vinculo2']['texto'].'</a>';
         $this->capsula.=  '</td>';

      } //////////////// fin mostrando la data del nuevo vinculo 2




     $this->capsula.=  '</tr>'; ///////////////////////fin fila de datos

      $registros++; ///incrementando contador

      /////////////////////////opera si se desea obtener totalizado
      if(isset($this->features['totalizado'])) $this->totalizado+= $tmp[$this->features['totalizado']];


     } ///////////////////// fin while



     $this->capsula.=  '</table>';


      if(isset($this->features['borde'])){

      $this->capsula.= '</td></tr></table>';

      }


     } //si no se encuentran registros

     $this->capsula.=  '</td></tr>';
     $this->capsula.=  '</table>'; ////tabla principal
     $this->liberar();

  }    //// FIN DEL METODO




 }  // fin de la clase grid


?>