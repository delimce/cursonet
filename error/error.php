<?php 
 include("../config/dbconfig.php");
 include("../class/clases.php");
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
.style4 {color: #CC0000}
-->
</style>
</head>

<body topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<table width="90%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="98" colspan="2" style="border-bottom:solid 1px #000000">&nbsp;</td>
  </tr>
  <tr>
    <td width="24%" height="203" align="left" bgcolor="#7A98AD" style="border-left:solid 1px #000000;"><img src="../images/backend/lock.jpg" width="365" height="203"></td>
    <td width="76%" valign="top" bgcolor="#7A98AD" style="border-left:solid 1px #000000; border-right:solid 1px #000000;"><table width="99%" border="0" cellspacing="3" cellpadding="5">
      <tr>
        <td colspan="2"><h1><span class="style4">Error: <?php echo strtoupper(LANG_denegado); ?> </span><br>
        </h1></td>
      </tr>
      <tr>
        <td colspan="2" class="style1" style="color:#FFFFFF"><b><?php echo LANG_invalid_enter ?></b></td>
      </tr>
      <tr>
        <td align="center" class="style1" style="color:#FFFFFF"><a href="#" onClick="location.replace('../index.php');" style="color:#FFFFFF; text-transform:capitalize"><?php echo LANG_module_est ?></a></td>
        <td align="center" class="style1" style="color:#FFFFFF"><a href="#" onClick="location.replace('../admin/index.php');" style="color:#FFFFFF; text-transform:capitalize"><?php echo LANG_module_adm ?></a></td>
      </tr>
    </table>      
    </td>
  </tr>
  <tr>
    <td colspan="2" align="center" valign="top" class="style3" style="border-top:solid 1px #000000"><?php echo LANG_license.' '.date("Y"); ?> </td>
  </tr>
</table>
</body>
</html>
<?php 

$nuevo->cerrar();

?>
