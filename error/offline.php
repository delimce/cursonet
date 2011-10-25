<?php 
 include("../config/dbconfig.php");
 include("../class/tools.php");
 $nuevo = new tools('db');
 $lengua = $nuevo->simple_db("select lenguaje from tbl_setup"); //// modo
 
 $lenguaje1 = '../config/lang/'.$lengua;///verifico el lenguaje
 include ($lenguaje1); 
 ?>
 
<html>
<head>
<link rel="stylesheet" type="text/css" href="../css/style_back.css">
<title><?=LANG_denegado?></title>
<style type="text/css">
<!--
#Layer1 {
	position:absolute;
	left:382px;
	top:29px;
	width:177px;
	height:32px;
	z-index:1;
}
-->
</style>
</head>

<body topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<table width="2%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="98" style="border-bottom:solid 1px #000000">&nbsp;</td>
  </tr>
  <tr>
    <td width="24%" height="203" align="left" bgcolor="#7A98AD" style="border:solid 1px #000000;"><img src="../images/frontend/offline.jpg" width="435" height="298"></td>
  </tr>
  <tr>
    <td align="center" valign="top" class="style3" style="border-top:solid 1px #000000"><strong class="style2"><span class="style3" style="border-top:solid 1px #000000"><?php echo LANG_system_offline ?></span>s</strong><br>
    <?php echo LANG_license ?> </td>
  </tr>
</table>
</body>
</html>
<?php 

$nuevo->cerrar();

?>
