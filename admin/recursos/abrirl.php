<?php 

	 include("../../config/dbconfig.php"); ////////setup
	 include("../../class/clases.php"); ////////clase
	 $tool = new tools();
	 $tool->autoconexion();
	 $enlace = $tool->simple_db("select dir from tbl_recurso where id = '{$_REQUEST['id']}' ");
	 $tool->cerrar();
	 $tool->redirect($enlace);



?>