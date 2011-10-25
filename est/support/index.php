<?php session_start();
$profile = 'est'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/tools.php");
include("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

$tool = new tools('db');

$data = $tool->simple_db("select id,admin_email from tbl_setup");

?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../../css/style_front.css">
<script type="text/javascript" src="../../js/utils.js"></script>
<script type="text/javascript" src="../../js/ajax.js"></script>
</head>
<body>
<table width="100%" height="400" border="0" cellspacing="6" cellpadding="2">
  <tr>
    <td width="56%" align="center" valign="top" style="border: #9AB1B6 1px solid;"><table width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="welcome"><?php echo LANG_est_support_title ?></td>
      </tr>
      <tr>
        <td height="2"><hr color="#9AB1B6" size="1px"></td>
      </tr>
      <tr>
        <td height="2"><br></td>
      </tr>
      <tr>
        <td height="2"><a  class="style3" href="javascript:popup('ayudacursonet.swf','help','600','800');"><?php echo LANG_est_support_manual ?></a><br>          &nbsp;<span class="style1"><?php echo LANG_est_support_manual_desc ?></span></td>
      </tr>
      
      <tr>
        <td width="65%" height="2"><span onClick="ajaxsend('post','cuenta.php','var=1');"><a  class="style3" href="mailto:<?php echo $data['admin_email']; ?>"><?php echo LANG_est_support_admin ?></a></span><br>
        </a>&nbsp;<span class="style1"><?php echo LANG_est_support_admin_desc ?></span></td>
      </tr>
     
      <tr>
        <td height="2"><a  class="style3" href="preguntas_frecuentes.doc"><?php echo LANG_est_support_questions ?><br>
        </a>&nbsp;<span class="style1"><?php echo LANG_est_support_questions_desc ?></span></td>
      </tr>
      
       <tr>
        <td height="2"><a  class="style3" href="javascript:mostrar('reque');"><?php echo LANG_est_support_requirements ?><br>
        </a>&nbsp;<span class="style1"><?php echo LANG_est_support_requirements_desc ?></span></td>
      </tr>
	  
      <tr class="style1" id="reque" style="display:none">
      	<td><ul>
      	  <li>&nbsp;Procesador CPU Pentum IV</li>
      	  <li>&nbsp;512MB de RAM</li>
      	  <li>&nbsp;32MB de video</li>
      	  <li>&nbsp;Adobe flash plugins (8.x)</li>
      	  <li>&nbsp;Microsoft Office 2003 / Oracle OpenOffice 2.5</li>
      	  <li>&nbsp;5GB de memoria disponibles en disco<br>
      	    &nbsp;<br>
    	    </li>
    	  </ul></td>
      </tr>
      
      
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
    <p>&nbsp;</p></td>
  </tr> 
   </table>
</body>
</html>
<?

$tool->cerrar();

?>