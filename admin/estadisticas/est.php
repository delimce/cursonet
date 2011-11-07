<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje


	$est = new tools("db");
	$query = "select
	
	(select count(*) from tbl_log_est where est_id = '{$_REQUEST['id']}') as totalv,
	ifnull((select DATE_FORMAT(fecha_in,' {$_SESSION['DB_FORMATO_DB']}, ".LANG_hora." %h: %i %p') from tbl_log_est where est_id = '{$_REQUEST['id']}' order by id desc limit 1),'".LANG_npi."') as ultimav,
	ifnull((select info_cliente from tbl_log_est where est_id = '{$_REQUEST['id']}' order by id desc limit 1),'".LANG_npi."') as cliente,
	ifnull((select sum(ndescargas) from tbl_log_est where est_id = '{$_REQUEST['id']}'),'0'),
	ifnull((select sum(ncontenidos) from tbl_log_est where est_id = '{$_REQUEST['id']}'),'0')
	  ";
	
	$dato = $est->array_query2($query);
	
		
	$est->cerrar();
	
	
	header("Content-Type: text/xml"); 
	header("Cache-Control: no-cache, must-revalidate"); 
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");  

	echo "<xml> 
	 <totalv>$dato[0]</totalv> 
	 <ultimav>$dato[1]</ultimav> 
	 <cliente>$dato[2]</cliente>
	 <desc>$dato[3]</desc>
	 <conte>$dato[4]</conte>    
	</xml>";
		
	
?>	
