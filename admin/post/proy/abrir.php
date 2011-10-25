<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../config/setup.php"); ////////setup
include("../../../class/formulario.php");

	$datos = new formulario('db');
	
		$id = $datos->getvar("id");
		$dir = $datos->simple_db("select dir from tbl_recurso where id = '$id' ");
	
	$datos->cerrar();
	

$filename = "../../../$USERPATH/proy/".$dir;

// required for IE, otherwise Content-disposition is ignored
if(ini_get('zlib.output_compression'))
ini_set('zlib.output_compression', 'Off');

// addition by Jorg Weske
$file_extension = strtolower(substr(strrchr($filename,"."),1));

if( $filename == "" )
{
echo "<html><body>ERROR: el archivo no esta especificado</body></html>";
exit;
} elseif ( ! file_exists( $filename ) )
{
echo "<html><body>ERROR: El archivo que intenta abrir no existe en el servidor.</body></html>";
exit;
};
switch( $file_extension )
{
case "pdf": $ctype="application/pdf"; break;
case "msi": $ctype="application/octet-stream"; break; /// i am already using this but file is not downloading properly.
case "exe": $ctype="application/octet-stream"; break;
case "zip": $ctype="application/zip"; break;
case "doc": $ctype="application/msword"; break;
case "docx": $ctype="application/msword"; break;
case "xls": $ctype="application/vnd.ms-excel"; break;
case "xlsx": $ctype="application/vnd.ms-excel"; break;
case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
case "pptx": $ctype="application/vnd.ms-powerpoint"; break;
case "gif": $ctype="image/gif"; break;
case "png": $ctype="image/png"; break;
case "jpeg":
case "jpg": $ctype="image/jpg"; break;
default: $ctype="application/force-download";
}
header("Pragma: public"); // required
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false); // required for certain browsers
header("Content-Type: $ctype");
header("Content-Disposition: attachment; filename=".basename($filename).";" );
header("Content-Transfer-Encoding: binary");
header("Content-Length: ".filesize($filename));
readfile("$filename");

exit();



?>