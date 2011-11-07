<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../config/setup.php"); ////////setup
include("../../../class/clases.php"); ////////clase
include ("../../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

$tool = new tools("db");

 $id = $tool->array_query2("select valido,sujeto_id,(select titulo from tbl_foro where id = foro_id) from tbl_foro_comentario where id = '{$_REQUEST['id']}'");
 
 

 if($id[0]==1){ $est = 0; 
 
 
 }else{ 
 
 		$est = 1; 
		
			///////////mandando mensaje
			
			$datosmens[0] = '1';
			$datosmens[1] = $_SESSION['USERID'];
			$datosmens[2] = $id[1];
			$datosmens[3] = LANG_foro_comm1.$id[2].LANG_foro_cok_title;
			$datosmens[4] = LANG_foro_comm1.$id[2].LANG_foro_cok_title.'<br>'.LANG_foro_cok_thanx;
			$datosmens[5] = date('Y-m-d H:i:s');
			$datosmens[6] = LANG_msg_priority_n;
						
			$tool->insertar2("tbl_mensaje_est","tipo,de,para,subject,content,fecha,urgencia",$datosmens,true);
		

 
 }
 
 
 $tool->query("update tbl_foro_comentario set valido = $est where id = '{$_REQUEST['id']}' ");
 echo $est;
  

$tool->cerrar();

?>