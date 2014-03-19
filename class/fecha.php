<?php

class fecha {

    var $fecha;
    var $meses;
    var $formato;

    function fecha($formato) {     //costructor
        date_default_timezone_set($_SESSION['TIMEZONE']);
        $this->formato = $formato;

        $ano = @date("Y");
        if ($this->es_bisiesto($ano))
            $bisiesto = '29';
        else
            $bisiesto = '28';

        $this->meses = array(
            1 => array("nombre" => "Enero", "name" => "January", "tdias" => 31),
            2 => array("nombre" => "Febrero", "name" => "February", "tdias" => $bisiesto),
            3 => array("nombre" => "Marzo", "name" => "March", "tdias" => 31),
            4 => array("nombre" => "Abril", "name" => "April", "tdias" => 30),
            5 => array("nombre" => "Mayo", "name" => "May", "tdias" => 31),
            6 => array("nombre" => "Junio", "name" => "June", "tdias" => 30),
            7 => array("nombre" => "Julio", "name" => "July", "tdias" => 31),
            8 => array("nombre" => "Agosto", "name" => "August", "tdias" => 31),
            9 => array("nombre" => "Septiembre", "name" => "September", "tdias" => 30),
            10 => array("nombre" => "Octubre", "name" => "October", "tdias" => 31),
            11 => array("nombre" => "Noviembre", "name" => "November", "tdias" => 30),
            12 => array("nombre" => "Diciembre", "name" => "December", "tdias" => 31)
        );
    }

///// fin constructor
    //// funcion para determinar si el a�o es bisiesto o no devuelve true o false


    function es_bisiesto($ano) {

        if (($ano % 4 == 0) && (($ano % 100 != 0) || ($ano % 400 == 0)))
            return true;
        else
            return false;
    }

///fin es_bisiesto
    // funcion que devuelve el formato correcto datatime de la db
    // dado el formato de la fecha descompone el formato a datatime y lo muestra
    // segun el formato empleado para mostrar las fechas del sistema
    // formato original fecha del sistema 00/00/0000
    // formato  db datatime '0000-00-00 00:00:00'
    // util para adecuar la fecha a operaciones a nivel de la base de datos

    function fecha_db($fecha, $ini = false, $trunca = false) {
        $fecha1 = explode("/", $fecha);
        if ($ini)
            $hora = " 00:00:00";
        else
            $hora = " 23:59:59";
        if ($trunca)
            $hora = '';

        if ($this->formato == "d/m/Y") {

            $final = $fecha1[2] . '-' . $fecha1[1] . '-' . $fecha1[0] . $hora;
        } else {

            $final = $fecha1[2] . '-' . $fecha1[0] . '-' . $fecha1[1] . $hora;
        }

        return $final;
    }

    ////////////////////////////////////////////////////////////////////////////////
    /// funcion para obtener el tiempo unix de una fecha
    ////  ///////////////////////////////////////////////////////////////////////
    function unix_time($fecha) {
        $fecha1 = explode("/", $fecha);


        if ($this->formato == "d/m/Y") {

            $final = mktime(0, 0, 0, $fecha1[1], $fecha1[0], $fecha1[2]);
        } else {

            $final = mktime(0, 0, 0, $fecha1[0], $fecha1[1], $fecha1[2]);
        }

        return $final;
    }

    ////////////////////////////////////////////////////////////////////////////////
    /// conversiones instanteneas
    /// para convertir formatos datatime y timestamp
    ////  ///////////////////////////////////////////////////////////////////////
    ///////////// para fechas de tipo timestamp

    function timestamp($stamp) {
        $pattern = "/^(\d{4})(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})$/i";
        if (preg_match($pattern, $stamp, $st) && checkdate($st[2], $st[3], $st[1])) {
            return @date($this->formato, mktime($st[4], $st[5], $st[6], $st[2], $st[3], $st[1]));
        }
        return $stamp;
    }

    ////////////////// para fechas de tipo db datatime '0000-00-00 00:00:00'

    public function datetime($datetime, $formato = false) {

        if (!$this->formato)
            date_default_timezone_set($_SESSION['TIMEZONE']);
        $date = new DateTime($datetime);
        return ($formato) ? $date->format($formato) : $date->format($this->formato);
    }

    //////////////////// escribe la fecha actual en formato datetime como lo almacena mysql

    function fecha_datetime() {

        return @date("Y-m-d H:m:s");
    }

    static function currentDateDb() {

        return @date("Y-m-d");
    }

    static function currentDateTimeDb() {

        return @date("Y-m-d H:m:s");
    }

}

/////fin de la clase FECHA
?>