<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php");

$datos = new formulario('db');

$id = $datos->getvar("id");
$fileProps = $datos->simple_db("select dir,mime,size from tbl_recurso where id = '$id' ");

$datos->cerrar();
$url = 'http://zserver/cursonet2/api/' . 'admin/file/' . $id;

$curl = curl_init();
// Set some options - we are passing in a useragent too here
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => $url,
    CURLOPT_USERAGENT => 'Codular Sample cURL Request'
));
// Send the request & save response to $resp
$resp = curl_exec($curl);
// Close request to clear up some resources
curl_close($curl);


header('Content-Description: File Transfer');
header("Content-Type: {$fileProps['mime']}");
header("Content-Disposition: attachment; filename=" . basename($fileProps['dir']));
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . strlen($resp));
ob_clean();
flush();
echo $resp;
exit;

?>