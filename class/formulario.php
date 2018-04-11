<?php

 // llamando la super clase base de datos

 /***************************************************************************
  clase para la construccion de formularios y volcamiento de data proveniente de los mismos
  IMPORTANTE: por defecto se asume que se esta conectado a la base de datos
  en caso de que desee llamar herramientas del tipo database
 ****************************************************************************/


 class formulario extends  tools  {

 //**********************************************atributos


 /********************************************** CONSTRUCTOR */

	function __construct ($conect=''){ ///constructor de la clase

               if(!empty($conect)){

                      /////conexion de dos vistas
                      if($conect=="db") $this->autoconexion();

               }
		
	}

 //********************************************* metodos de formulario


  /* metodo para obtener variables de formularios de manera segura
  * de tal manera de evitar ataques de inyeccion de sql etc
  * solo hacer la llamada al metodo con el nombre de la variable que se pasa por formulario
  * el parametro $only es para limitar el tipo de variable que se desea recibir ej: $_GET o $_POST
  * el parametro secure aplica la seguridad a la variable que es enviada por url esta por defecto true
  */

 public static function getvar($var,$only="",$secure=true){

     /////////////////////validar el only
     if(!$only){

         $var2 = @$_REQUEST[$var];

     }else{
         $var2 = ($only==$_GET)?@$_GET[$var]:@$_POST[$var];

     }

     //////////quitando las comillas simples y dobles
     $seguro = trim($var2); ///fuera espacios en blanco
	 
    if($secure){
		 $seguro = str_replace('"','', $seguro); ///fuera comillas dobles
     	 $seguro = str_replace("'","", $seguro); ///fuera comillas simples
	}

     return $seguro;

 } /////fin del metodo getvar


 /*metodo insert_data, que inserta valores de un formulario en una tabla de la base de datos
   $pref: toma el prefijo de cada campo que seran los valores que se van a insertar ejemplo r-nombre "r" 
   $sep es el caracter que separa al nombre del campo y el prefiejo ejemplo r_nombre nota la separacion debe ser un "_"
   $tabla: la tabla de la base de datos que sufrir los cambios
   $metodo: vectores globales segun el metodo por el cual vienen los valores del formulario "$_GET" o "$_POST"
	IMPOTANTE: EL NOMBRE DE LOS CAMPOS DEBE SER EL NOMBRE DE LAS VARIABLES DE FORMULARIO PASADAS 

 */
 public function insert_data($pref,$sep,$tabla,$variables){
 
 			
						$r=0;
							while(list($key, $value) = each($variables))
							{
							
								
								$value = $this->getvar($key,$variables,false); ///hay confianza y no aplica la seguridad
								//$value = trim($_POST[$key]);
								
								if(!empty($value)){  ///si el campo no es vacio lo inserto
									 $nuevo = explode($sep,$key);
	  
									   if($nuevo[0]==$pref){
											   $valores[$r] = $value;
											   $campos[$r] = $nuevo[1];
											   $r++;
									   }
										 
								}
								  
							}
							
							$lista = implode(',',$campos);														
							if(count($campos)>0) $this->insertar2($tabla,$lista,$valores);
 
 } 
 
 
 /*metodo edit_data, que edita valores de un formulario en una tabla de la base de datos
   $pref: toma el prefijo de cada campo que seran los valores que se van a insertar ejemplo r-nombre "r" 
   $sep es el caracter que separa al nombre del campo y el prefiejo ejemplo r_nombre nota la separacion debe ser un "_"
   $tabla: la tabla de la base de datos que sufrira los cambios
   $metodo: vectores globales segun el metodo por el cual vienen los valores del formulario "$_GET" o "$_POST"
   $where: condicion de edicion ejemplo id='1'
	IMPOTANTE: EL NOMBRE DE LOS CAMPOS DEBE SER EL NOMBRE DE LAS VARIABLES DE FORMULARIO PASADAS
 */
 public function update_data($pref,$sep,$tabla,$variables,$where=""){
 
 			
						$r=0;
							while(list($key, $value) = each($variables))
							{
							
							
									$value = $this->getvar($key,$variables,false); ///hay confianza y no aplica la seguridad
									//$value = trim($_POST[$key]);
										$nuevo = explode($sep,$key);
		
										 if($nuevo[0]==$pref){
												 $valores[$r] = $value;
												 $campos[$r] = $nuevo[1];
												 $r++;
										 }
								
								  
							}
												
							if(count($campos)>0) $this->update($tabla,$campos,$valores,$where);
 
 } 






 

 } //// fin de la clase formulario



?>