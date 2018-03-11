<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of grid2
 * nueva implementacion del grid para aguantar mas funciones
 * @author delimce
 */
class grid2 extends database {

    //***********************************************formato
    private $id;
    private $campos; //vector de campos que se solicitan en el query
    private $ancho;
    private $features;
    private $orden; ////atributo para ordenar las columnas el grid
    public $totalizado = 0; /////atributo que muestra el valor del totalizado por colum (si es que existe)

    //*************************************************** propiedades
    //funciones para descanectarse o liberar recursos
/// funcion que valida si los campos deseados son iguales a los campos por defecto

    function validar_head($campos) {

        $campos2 = explode(",", $campos);

        if (count($campos2) != count($this->campos)) {
            echo "<font color=#FF0000>incorrect parameters in function cargar(): fields wrong </font>";
            die();
        } else {
            $this->campos = $campos2;
        }
    }

    /// funcion para saber el total de campos consultados del query
    function total_campos() {

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
      "buscador" => [boolean]
      "style_body" => [cadena] /// el nombre de la clase de estilo class=""
      "style_head" => [cadena] /// el nombre de la clase de estilo class=""
      "totalizado" => [numero] /////numero de la columna por la cual se desea sacar un total
      "r_header" => [numero] /////cada cuantos registros se repite el header
      "formato" => "tipo (html/texto)"    /////el formato de los valores
      "abreviar" =>  array([numero]  (columna a abreviar) pueden ser varias => [numero] cantidad de caracteres permitidos,...);
      "orden" => array(0 => "string,int,float,date", 1 => "string,int,float,date",...);
      "nuevo_vinculo1"  => array("nombre" => "[cadena]", "texto" => "[cadena](texto o imagen)", "title" => "[texto] alt", "url" => "[cadena] no olvidar el '?' en caso de que pase un parametro","target" => [cadena], "parametro" => [numero posicion que ocupa la columana que se quiere pasar como parametro], "var_parametro"=>[cadena] nombre de la variable a pasar por parametro , "popup"=>[nombre de la ventana] esta opcion solo funciona si hay una funcion que abra el link en popup, "condicion" posicion del campo de la consulta, "texto_condicion" lo que escribe si se cumple la condicion  ),
      "nuevo_vinculo2"  => array("nombre" => "[cadena]", "texto" => "[cadena](texto o imagen)", "title" => "[texto] alt", "url" => "[cadena] no olvidar el '?' en caso de que pase un parametro","target" => [cadena], "parametro" => [numero posicion que ocupa la columana que se quiere pasar como parametro], "var_parametro"=>[cadena] nombre de la variable a pasar por parametro , "popup"=>[nombre de la ventana] esta opcion solo funciona si hay una funcion que abra el link en popup ),
      "nuevo_vinculo3"  => array("nombre" => "[cadena]", "texto" => "[cadena](texto o imagen)", "title" => "[texto] alt", "url" => "[cadena] no olvidar el '?' en caso de que pase un parametro","target" => [cadena], "parametro" => [numero posicion que ocupa la columana que se quiere pasar como parametro], "var_parametro"=>[cadena] nombre de la variable a pasar por parametro , "popup"=>[nombre de la ventana] esta opcion solo funciona si hay una funcion que abra el link en popup ),
      "conenlace"  => array("pos" => "[numero] posicion de la columna del grid que lleva el vinculo", "title" => "[texto]/ int (posicion de la columna para mostrar) alt", "url" => "[cadena] no olvidar el '?' en caso de que pase un parametro","target" => [cadena], "parametro" => [numero posicion que ocupa la columana que se quiere pasar como parametro], "var_parametro"=>[cadena] nombre de la variable a pasar por parametro , "popup"=>[nombre de la ventana] esta opcion solo funciona si hay una funcion que abra el link en popup,"extras" => "&variable=valor" ),
      "separacion" =>  array(0 => [numero  (%/px)], 1 => "[cadena]", 3 => [cadena]...);
      "alineacion"  => array(0 => [cadena  (left,rigt,center)], 1 => "[cadena]", 3 => [cadena]...);
      "decoracion"  => array(0 => [cadena  (capitalize,blink,etc...)],...);
      "celda_vacia" => "[valor lo que se desea que aparezca si la celda es vacia]"
      "nulo" => "[cadena] valor que se desea hacer nulo dentro del grid y en su lugar colocar el valor celda vacia"
      "oculto" =>[cadena] "0,1..." /////numeros de la columnas separadas por comas que se desean ocultar del grid
      "dateformat" =>"0,1...") /////NUEVO posiciones a mostrar con el formato de fecha por defecto en la herramienta

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
      /******************************************************************* */

    /**
     * 
     * @param type $id
     * @param type $ancho
     * @param type $features
     */
    public function __construct($id, $ancho, $features) {     //constructor
        $this->id = $id;
        $this->ancho = $ancho;
        $this->features = $features;

        if (isset($_GET[$this->features['orden']['nombre']]))
            $this->orden = $_GET[$this->features['orden']['nombre']];  ///variable reservada para ordenar el grid
        else if (isset($this->features['orden']['defecto']))
            $this->orden = $this->features['orden']['defecto'];  ///campo de orden por defecto



        if (!isset($this->features['r_header']))  ///en caso de que el orden sea nulo
            $this->features['r_header'] = -1;
    }

    /*     * ****************************************************************************************

      $query: query que se trae los campos que se desean mostrar en el grid
      ///IMPORTANTE: no hace falta en el query mandar a ordenar  (uso de la clausula order by)
      /// el grid permite ordenar por cualquiera de los campos consultados, si se coloca la clausula  order by
      ///dara error!!!


      /* $campos: nombre de las colums(default), nombre de los titulos separados por comas si desea agregarlos ud
      /* $result se pasa el parametro result=true si el query fue ejecutado anteriormente y se almaceno la info sino este se omite por false

     * **************************************************************************************** */

    function cargar($query) {


        $this->query($query);  //llamando las funciones de la clase database heredada


        $this->campos = $this->campos_query($this->result);
        if (isset($this->orden))
            $orden = $this->campos; ////vector para ordenar columnas
        $registros = 0; ///////////////contador para los registros
        $tamvardb = count($this->campos);
        ////////// para ocultar columnas
        if (isset($this->features['oculto']))
            $ocultos = explode(',', $this->features['oculto']);

        ////////// para FORMATEAR FECHAS
        if (isset($this->features['dateformat']))
            $fformat = explode(',', $this->features['dateformat']);


        /////si no se encuentran registros
        if ($this->nreg == 0) {

            echo "<b>{$this->features['no_registers']}</b>";
        } else { ////SE CONSTRUYE EL GRID
            echo '<div id="wrapper" style="width:' . $this->ancho . ';">'; ////////contenedor

            if (isset($this->features['mostrar_nresult'])) { ////MOSTRAR NUM DE REGISTROS
                echo '<div class="' . $this->features['mostrar_nresult']['style'] . '" style="text-align:left; margin-bottom:10px; margin-left:8px;">';

                echo '<span align="' . $this->features['mostrar_nresult']['align'] . '">' . $this->features['mostrar_nresult']['nombre'] . ': ' . $this->nreg . '</span>';

                echo '</div>';
            }


            if (isset($this->features['buscador'])) { ////PARA BUSCAR ENTRE LOS REGISTROS
                echo '<div class="' . $this->features['mostrar_nresult']['style'] . '" style="text-align:left; margin-bottom:10px; margin-left:8px; ">';

                echo '<label for="kwd_search">' . LANG_search . '</label> <input type="text" id="kwd_search" value=""/>';

                echo '</div>';
            }


            echo '<div id="gridborder" class="' . $this->features['borde']['style'] . '"  style="width:100%;">'; ///////div de borde
            ///////////////armando la tabla contenedora            
            echo '<table id="' . $this->id . '" style="border-collapse:collapse" width="100%" height="100%" border="0" cellspacing="' . $this->features['borde']['cellspacing'] . '" cellpadding="' . $this->features['borde']['cellpadding'] . '">';

            /////////////creando el header
            echo '<thead><tr>';
            for ($i = 0; $i < count($this->campos); $i++) {

                if (@in_array($i, $ocultos) && isset($this->features['oculto'])) {
                    echo ' <!-- ';
                    $OCU = 1;
                }  ///ocultando si asi se desea


                $orden45 = ($this->features['orden'][$i]) ? $this->features['orden'][$i] : 'string';
                echo '<th class="' . $this->features['style_head'] . '" width= "' . $this->features['separacion'][$i] . '"  title="' . LANG_orderby . $this->campos[$i] . '"  data-sort="' . $orden45 . '">' . $this->campos[$i] . '</th>';


                if ($OCU == 1) {
                    echo ' --> ';
                    $OCU = 0;
                }  ////ocultando
            }
            echo '</tr></thead>';

            //////////////header
            //////body
            echo '<tbody>';

            while ($tmp = $this->db_vector_num($this->result)) {

                //////////////////inicio fila de datos

                echo '<tr class="td_whbk" onmouseover="this.style.backgroundColor = ' . "'#CCCCCC'" . '" onmouseout="this.style.backgroundColor = ' . "'#FFFFFF'" . '">';

                ////////////////////////////////////////mostrando la data de la base de datos
                for ($ii = 0; $ii < $tamvardb; $ii++) {

                    if ($tmp[$ii] != '') {


                        if ($this->features['formato'] != "html")
                            $valor = strip_tags(trim(stripslashes($tmp[$ii])));
                        else
                            $valor = trim(stripslashes($tmp[$ii]));
                        if ($tmp[$ii] == $this->features['nulo'])
                            $valor = "{$this->features['celda_vacia']}"; /// en caso de que se desee hacer nulo algun valor
                        if (isset($this->features['conenlace']['popup']))
                            $popup = " onclick=\" return popup2(this,'" . $this->features['conenlace']['popup'] . "');\"";
                        else
                            $popup = '';
                        if (isset($this->features['conenlace']) && $this->features['conenlace']['pos'] == $ii) {
                            
                            ////verificacion de parametros conenlace
                            if(is_int($this->features['conenlace']['title'])) ///si tiene la posicion de una columna
                                $tituloEnlace = $tmp[$this->features['conenlace']['title']];
                            else 
                                $tituloEnlace = $this->features['conenlace']['title'];
                            
                            
                            $enlace = '<a href="' . $this->features['conenlace']['url'] . $this->features['conenlace']['var_parametro'] . '=' . $tmp[$this->features['conenlace']['parametro']] . $this->features['conenlace']['extras'] . '" target="' . $this->features['conenlace']['target'] . '" title="' . $tituloEnlace . '"' . $popup . '">';
                            $enlace2 = '</a>';
                        } else {
                            $enlace = '';
                            $enlace2 = '';
                        }
                    } else {

                        $valor = "{$this->features['celda_vacia']}";
                    }



                    if (@in_array($ii, $ocultos) && isset($this->features['oculto'])) {
                        echo ' <!-- ';
                        $OCU = 1;
                    }  ///ocultando si asi se desea


                    if (!isset($this->features['abreviar'][$ii])) { //// en caso de abreviacion de clumnas
                        /////////////FORMATEAR FECHAS
                        if (@in_array($ii, $fformat))
                            try {
                                $valor = @fecha::datetime($valor, $_SESSION['DB_FORMATO']);
                            } catch (Exception $e) {
                                $valor = "<b>error!</b>";
                            }

                        echo '<td class="td_whbk1" align="' . $this->features['alineacion'][$ii] . '">' . $enlace . $valor . $enlace2 . '</td>';
                    } else {

                        if (strlen($valor) > $this->features['abreviar'][$ii])
                            $valor = substr($tmp[$ii], 0, $this->features['abreviar'][$ii]) . '...';
                        if (isset($this->features['decoracion'][$ii]))
                            $decoracion = 'style="text-transform: ' . $this->features['decoracion'][$ii] . '"';
                        else
                            $decoracion = '';
                        echo '<td class="td_whbk1" ' . $decoracion . ' title="' . strip_tags($tmp[$ii]) . '" align="' . $this->features['alineacion'][$ii] . '">' . $enlace . $valor . $enlace2 . '</td>';
                    }

                    if ($OCU == 1) {
                        echo ' --> ';
                        $OCU = 0;
                    }  ////ocultando
                }



                ///////////////////////////////////////mostrando la data del nuevo vinculo 1
                if (isset($this->features['nuevo_vinculo1'])) {
                    echo '<td align="center">';


                    if (!isset($this->features['nuevo_vinculo1']['condicion']) or $tmp[$this->features['nuevo_vinculo1']['condicion']] == 1) {

                        if (isset($this->features['nuevo_vinculo1']['popup']))
                            $popup = " onclick=\" return popup2(this,'" . $this->features['nuevo_vinculo1']['popup'] . "');\"";
                        else
                            $popup = '';
                        echo '<a href="' . $this->features['nuevo_vinculo1']['url'] . $this->features['nuevo_vinculo1']['var_parametro'] . '=' . $tmp[$this->features['nuevo_vinculo1']['parametro']] . $this->features['nuevo_vinculo1']['extras'] . '" target="' . $this->features['nuevo_vinculo1']['target'] . '" title="' . $this->features['nuevo_vinculo1']['title'] . '"' . $popup . '">' . $this->features['nuevo_vinculo1']['texto'] . '</a>';
                    }else if (isset($this->features['nuevo_vinculo1']['condicion']) && $tmp[$this->features['nuevo_vinculo1']['condicion']] == 0) { ///no se cumple la condicion
                        echo $this->features['nuevo_vinculo1']['texto_condicion'];
                    }


                    echo '</td>';
                } //////////////// fin mostrando la data del nuevo vinculo 1
                ///////////////////////////////////////mostrando la data del nuevo vinculo 2
                if (isset($this->features['nuevo_vinculo2'])) {
                    echo '<td align="center">';


                    if (isset($this->features['nuevo_vinculo2']['popup']))
                        $popup = " onclick=\" return popup2(this,'" . $this->features['nuevo_vinculo2']['popup'] . "');\"";
                    else
                        $popup = '';
                    if (isset($this->features['nuevo_vinculo2']['borrar']))
                        $popup = " onclick=\" return borrar('" . $tmp[$this->features['nuevo_vinculo2']['parametro']] . "','" . $tmp[$this->features['nuevo_vinculo2']['borrar']] . "');\"";
                    else
                        $popup = '';  //// para borrar un registro del grid experimental
                    echo '<a href="' . $this->features['nuevo_vinculo2']['url'] . $this->features['nuevo_vinculo2']['var_parametro'] . '=' . $tmp[$this->features['nuevo_vinculo2']['parametro']] . $this->features['nuevo_vinculo2']['extras'] . '" target="' . $this->features['nuevo_vinculo2']['target'] . '" title="' . $this->features['nuevo_vinculo2']['title'] . '"' . $popup . '">' . $this->features['nuevo_vinculo2']['texto'] . '</a>';


                    echo '</td>';
                } //////////////// fin mostrando la data del nuevo vinculo 2
                ///////////////////////////////////////mostrando la data del nuevo vinculo 3
                if (isset($this->features['nuevo_vinculo3'])) {
                    echo '<td align="center">';


                    if (isset($this->features['nuevo_vinculo3']['popup']))
                        $popup = " onclick=\" return popup2(this,'" . $this->features['nuevo_vinculo3']['popup'] . "');\"";
                    else
                        $popup = '';
                    if (isset($this->features['nuevo_vinculo3']['borrar']))
                        $popup = " onclick=\" return borrar('" . $tmp[$this->features['nuevo_vinculo3']['parametro']] . "','" . $tmp[$this->features['nuevo_vinculo3']['borrar']] . "');\"";
                    else
                        $popup = '';  //// para borrar un registro del grid experimental
                    echo '<a href="' . $this->features['nuevo_vinculo3']['url'] . $this->features['nuevo_vinculo3']['var_parametro'] . '=' . $tmp[$this->features['nuevo_vinculo3']['parametro']] . $this->features['nuevo_vinculo3']['extras'] . '" target="' . $this->features['nuevo_vinculo3']['target'] . '" title="' . $this->features['nuevo_vinculo3']['title'] . '"' . $popup . '">' . $this->features['nuevo_vinculo3']['texto'] . '</a>';


                    echo '</td>';
                } //////////////// fin mostrando la data del nuevo vinculo 3

                echo '</tr>';

                /////////////////////////opera si se desea obtener totalizado
                if (isset($this->features['totalizado']))
                    $this->totalizado+= $tmp[$this->features['totalizado']];
            } ////loop de columnas

            echo '</tbody>';
            ////body


            echo '</table>';

            //////////////////////////////////////////

            echo '</div>'; //////div de borde

            echo '</div>'; ////////contenedor 
        } ////mostrar data
    }

////metodo cargar
}

////fin de la clase
