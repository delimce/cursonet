<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of File
 *
 * @author delimce
 */
class File2 {

    //clase para el tratamiento de archivos

    private $filePath;
    private $fileName;
    private $fileXtension;
    private $fileType;
    private $fileSize;
    private $fileTempName;

    public function __construct($path = false) {

        if ($path) {

            $this->filePath = $path;
            $this->fileSize = filesize($this->filePath);
            $this->fileType = filetype($this->filePath);
            $this->fileName = basename($this->filePath);
        }
    }

    ///get tamaño del archivo  
    public function getFileSize() {

        return $this->fileSize;
    }

    ///get nombre del archivo  
    public function getFileName() {

        return $this->fileName;
    }

    ///get tipo del archivo  
    public function getFileType() {

        return $this->fileType;
    }

    /**
     * crea un archivo a traves de un campo de tipo archivo enviado de un formulario
     * necesario $options para validar la carga
     */
    public function load($file, $options = false) {

        $this->fileSize = $_FILES[$file]['size'];
        $this->fileType = $_FILES[$file]['type'];
        $this->fileName = $_FILES[$file]['name'];
        $this->fileTempName = $_FILES[$file]['tmp_name'];
    }

    /*
     * mueve el archivo cargado a una ruta especifica
     */

    public function moveLoadedTo($path) {

        ///////verificando si en efecto se subio
        ///Error al subir el archivo, Verifique los permisos de escritura en el directorio ' $destino ' ó intente subir otro archivo

        if (!is_uploaded_file($this->fileTempName)) {

            return false;
        }

        /**
         * revisar permisos de escritura sobre el directorio
         * Error al subir el archivo, quizas este corrupto
         */
        if (!move_uploaded_file($this->fileTempName, $path)) {

            return false;
        }

        return true;
    }

    /**
     *  esta funcion devuelve todos los elementos de un directorio en un array
     */
    public function ShowFiles() {
        $i = 0;
        if ($handle = opendir($this->filePath)) {
            while (false !== ($file = readdir($handle))) {
                if (($file != '..') && ($file != '.') && ($file != 'Thumbs.db')) {
                    $files[$i] = $file;
                    $i++;
                }
            }
            closedir($handle);
        }
        return($files);
    }

    /**
     * para borrar el archivo 
     */
    public function deleteFile($file = false) {

        if ($file)
            unlink($file);
        else
            unlink($this->filePath);
    }


    /**metodo que lee la ultima linea de un archivo
     * @return string
     */
    public function readLastLine()
    {
        $fp = @fopen($this->filePath, "r");
        $pos = -1;
        $t = " ";
        while ($t != "\n") {
            fseek($fp, $pos, SEEK_END);
            $t = fgetc($fp);
            $pos = $pos - 1;
        }
        $t = fgets($fp);
        fclose($fp);
        return $t;
    }





}

?>
