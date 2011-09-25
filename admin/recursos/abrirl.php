<?php 

	 include("../../config/dbconfig.php"); ////////setup
	 include("../../class/tools.php"); ////////clase
	 $tool = new tools();
	 $tool->autoconexion();
	 $enlace = $tool->simple_db("select dir from recurso where id = '{$_REQUEST['id']}' ");
	 $tool->cerrar();
	 $tool->redirect($enlace);



?>