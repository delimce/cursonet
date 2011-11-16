<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

?>
<html>
<head>
<script language="JavaScript" type="text/javascript" src="../../js/utils.js"></script>
<link rel="stylesheet" type="text/css" href="../../css/style_back.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
<center>
  <table width="550" border="0" cellspacing="3" cellpadding="0">
    <tr>
      <td colspan="2" align="justify" class="style1"><?php echo LANG_aboutus ?></td>
    </tr>
    <tr style="cursor:pointer;" onClick="top.location.replace('http://twitter.com/cursonet')">
      <td width="193" align="right" valign="baseline"><img src="../../images/common/icon-twitter.png" width="32" height="49"></td>
      <td width="348" class="style3">&nbsp;<?php echo LANG_twitter ?>&nbsp;@cursonet</td>
    </tr>
    <tr>
      <td colspan="2" align="center"><a href="http://delimce.com" target="_blank"><br>
      <img src="../../images/common/delminilogo.gif" width="80" height="15" border="0" title="deliMce.com">&nbsp;<span class="small"><?php echo LANG_license.' '.date("Y"); ?></span></a></td>
    </tr>
  </table>

</center>
</body>
</html>