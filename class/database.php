<?php
/******************************************************************
SUPER CLASE DATABASE
clase que crea todas las funciones necesarias para trabajr con bases de datos
desde su coneccion hasta cierre de la conexion
 ******************************************************************/
//nombre de la clase

class database {

 //**********************************************************************Atributos de la clase
  var $db_HOST;  //nombre del host de base de datos
  var $db_USER;  // user del sistema
  var $db_PASS;  //  password
  var $dbase;    // base de datos
  var $dbc;      // variable de conexion
  var $result;   /// atributo que tiene el resultado del query
  var $nreg;    //// cantidad de registros insertados
  var $ultimoID; /// ultimo id insertado (auto incremental)
 /***********************************************************************metodos y propiedades*/

 /************************************************************************* PROPIEDADES ****/
//********************************************************cierra conexion y liberar recursos


 ///metodo para cerrar la conexion con la base de datos
  function cerrar()
   {//cierra la conexion

    @mysql_free_result($this->result);
    mysql_close($this->dbc);

   }

  ///metodo para liberar el objeto que retorna el valor del query
   function liberar ()
   {//cierra la conexion

     mysql_free_result($this->result);

   }




   ////autoconexion discreta segun los parametros y la base dedatos especificadas en el archivo de conf

    function autoconexion(){

                 //estructura de autoconexion , variableS global de conexion a la db
                 global $HOSTNAME;
                 global $DBUSER;
                 global $DBPASS;
                 global $DATABASE;

                  $this->conectar($HOSTNAME,$DBUSER,$DBPASS,$DATABASE);
    }


  ///permite utilizar la conexion a una database ya creada sin tener que reconectar;
     function recliclar_conexion($link){  ///enlace a la conexion abierta

          $this->dbc = $link;

    }




    //*****************************************************************************************ejecucion
   // metodo que ejecuta un query de creacion o modificacion o devuelve un error  el segundo parametro es para liberar el recurso de una vez
  //utilizado ideal para sentencias insert, update, delete etc

    function query($sql,$lib=false)
   {// ejecuta un query o devuelve un error
     $this->result = @mysql_query($sql,$this->dbc) or die('<font color=#FF0000> invalid query: </font>'. mysql_error());
     $this->nreg = @mysql_num_rows($this->result);

       if($lib) $this->liberar();
   }


  ///funcion para obtener el valor del registro en tipo numero

   public function db_vector_num(){

        return @mysql_fetch_row($this->result);

   }

  ////funcion para obtener el valor del registro en tipo cadena o nombre

   public function db_vector_nom(){

      return @mysql_fetch_assoc($this->result);


   }



   /// propiedad que cambia la conexion a una nueva database o server  con solo invocarla se
   //// cambia la conexion el ultimo parametro determina si la conexion es persistente o no.

   function conectar($host,$user,$pwd,$db,$persiste=false)
   {

     if($this->dbc!=null)$this->cerrar();
     $this->db_HOST = $host;
     $this->db_USER = $user;
     $this->db_PASS = $pwd;
     $this->dbase   = $db;

    //conexion  persistente o no

   if($persiste)
    $this->dbc = mysql_pconnect($this->db_HOST,$this->db_USER,$this->db_PASS)  or die('<font color=#FF0000> conection failed: </font>'. mysql_error());
   else
    $this->dbc = mysql_connect($this->db_HOST,$this->db_USER,$this->db_PASS)  or die('<font color=#FF0000> conection failed: </font>'. mysql_error());

   //////////////

    $m = @mysql_select_db($this->dbase,$this->dbc) or die('<font color=#FF0000> wrong database name: </font>'. mysql_error());
    return($m);


   }



 //// Metodo que retorna el ultimo id de de un insert

   function ultimo_id()
   {
     return @mysql_insert_id($this->dbc)or die('<font color=#FF0000> Error </font>'. mysql_error());
   }


    function numero_filas_afecc()
   {//retorna el numero de las filas afectadas por el ultimo query
    $tmp = mysql_affected_rows($this->$dbc);
    return($tmp);
   }


 ///lista el numero de registros traidos en el ultimo query
  function total_registros()
   {
     $tmp = mysql_num_rows($this->result)or die('<font color=#FF0000> 0 rows: </font>'. mysql_error());
     return($tmp);
   }



 ///funcion que elimina la base de datos
  function borrar($dbase)
   {//elimina la base de datos
    return mysql_drop_db($dbase,$this->dbc);
   }





///**************************************** METODOS para insertar seguramente  */

// funcion que realiza un insert simple
// tabla, campos, valores y boqueo true o false (opcional)

      function insertar($tabla,$campos,$valores,$block=false){

     $valores2 = explode(",",$valores);



     for($i=0;$i<count($valores2);$i++){
	 
	 	$valori = trim($valores2[$i]);

       $valor = mysql_real_escape_string($valori);  //// me aseguro de que no se inserten valores invalidos
       $valores2[$i] = "'$valor'";

     }



    $valores3 = implode(",",$valores2);

    $query = 'INSERT INTO '.$tabla.' ('.$campos.') VALUES ('.$valores3.')';

    ////////////////// bloqueo de tabla
    if($block) $this->query("LOCK TABLES ".$tabla." WRITE");
    $this->query($query);
    $this->ultimoID = mysql_insert_id();
    if($block) $this->query("UNLOCK TABLES");

    }



   // funcion que realiza un insert simple de los valores ingresados en un vector
   // tabla, campos, valores y boqueo true o false (opcional)
   // esta funcion es una mejora de insertar 1 ya que previene errores si los valores poseen ,


      function insertar2($tabla,$campos,$vector,$block=false){


     for($i=0;$i<count($vector);$i++){

       $valori = trim($vector[$i]);
	   $valor = mysql_real_escape_string($valori);  //// me aseguro de que no se inserten valores invalidos
       $vector[$i] = "'$valor'";
       $valores.= $vector[$i].',';
     }

    $valores = substr($valores, 0, strlen($valores)-1); // elimina la , al final

   $query = 'INSERT INTO '.$tabla.' ('.$campos.') VALUES ('.$valores.')';

    ////////////////// bloqueo de tabla
    if($block) $this->query("LOCK TABLES ".$tabla." WRITE");
    $this->query($query);
    $this->ultimoID = mysql_insert_id();
    if($block) $this->query("UNLOCK TABLES");

    }


   // funcion que realiza un update simple de los valores y campos ingresados en un vector
   // tabla, campos(array), valores(array) where (condicion) y boqueo true o false (opcional)
   //  previene errores si los valores poseen ,


      function update($tabla,$campos,$vector,$where,$block=false){


        for($i=0;$i<count($vector);$i++){

          $valor = mysql_real_escape_string($vector[$i]);  //// me aseguro de que no se inserten valores invalidos
          $data = "$campos[$i] = '$valor'";
          $valores.= $data.',';
        }

       $valores = substr($valores, 0, strlen($valores)-1); // elimina la , al final
       if($where!='')$where = "WHERE ".$where; ///// si se coloca una condicion


       $query = 'UPDATE '.$tabla.' SET '.$valores.' '.$where;



       ////////////////// bloqueo de tabla
       if($block) $this->query("LOCK TABLES ".$tabla." WRITE");
       $this->query($query);
       if($block) $this->query("UNLOCK TABLES");

    }



 //devuelve un arreglo con el nombre de los campos consultados enpezando desde la pos 0

   function campos_query(){

  //  $rowcount=mysql_num_rows($this->result);
    $y = mysql_num_fields($this->result);

   for ($x=0; $x<$y; $x++) $resultado[$x] = (string) mysql_field_name($this->result, $x);

    return $resultado;

  }
  
  
  
    ///////////////////////////////METODOS PARA TRANSACCIONES
  
  public function abrir_transaccion(){
	  
	  	$this->query("SET AUTOCOMMIT=0"); ////iniciando la transaccion
        $this->query("START TRANSACTION");
	  
  }
  
  
  
   public function cerrar_transaccion($result=true){
	  
	  	if($result) $this->query("COMMIT"); else $this->query("ROLLBACK"); ////finalizando la transaccion
	  
  }
  



};   //fin de la super clase

?>