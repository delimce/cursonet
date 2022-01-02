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

class image extends  Database
{



	var $path;
	var $nombre;
	var $formato;
	var $alto;
	var $ancho;
	var $img;
	var $datos;


	public function __construct($path)
	{     //costructor

		$this->path =  $path;
		$this->nombre = basename($path);
		$this->datos = getimagesize($this->path);
		$this->formato = $this->datos["mime"];


		if ($this->formato == 'image/gif') {
			$this->img = @imagecreatefromgif($this->path);
		}
		if ($this->formato == 'image/jpeg') {
			$this->img = @imagecreatefromjpeg($this->path);
		}
		if ($this->formato == 'image/png') {
			$this->img = @imagecreatefrompng($this->path);
		}


		$this->ancho = ImageSX($this->img);
		$this->alto = ImageSY($this->img);
	}  ///// fin constructor


	///////////////////////////// metodos

	//// funcion que redimensiona una imagen solo se especifica la ruta donde se creara con el
	/////// nombre del archivo eje: "./archivos/image/new.jpg"
	//// las medidas y la calidad de la imagen original,   (pixles y porcentaje)
	///// el parametro porcentual (opcional) es para hacer el redimensionamiento maneteniendo
	////// la proporcionalidad de la imagen en porcentaje

	function redimensionar($ruta, $anchura, $altura, $calidad, $porcentual = true)
	{

		if ($porcentual) {
			if ($this->alto > $this->ancho) {
				//////redimensiona por porcentaje de alto
				$altura =  round(($anchura * $this->alto) / $this->ancho);
			} else {
				//////redimensiona por porcentaje de ancho
				$anchura =  round(($altura * $this->ancho) / $this->alto);
			}
		}

		$imagen = imagecreatetruecolor($anchura, $altura);
		// redimensiona la imagen original copiandola en la imagen
		ImageCopyResampled($imagen, $this->img, 0, 0, 0, 0, $anchura, $altura, $this->ancho, $this->alto);
		// guardar la nueva imagen redimensionada donde indicia $img_nueva

		if ($this->formato == 'image/jpeg') {
			imagejpeg($imagen, $ruta, 100);
		} else if ($this->formato == 'image/gif') {
			imagegif($imagen, $ruta, 100);
		} else {
			$quality = round(abs((90 - 100) / 11.111111));
			imagepng($imagen, $ruta, $quality);
		}
	}  ///// fin redimensionar


	///////////////// destruye el objeto imagen

	function destruir()
	{

		ImageDestroy($this->img);
	}
} //// fin de la clase image
