<?php session_start();
$profile = 'est'; /////////////// perfil requerido
include("../config/setup.php"); ////////setup
include("../class/clases.php");
include("../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje


?>
<html>
<head> <meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="../css/style_front.css">
</head>
<body>
<table width="100%" border="0" cellspacing="6" cellpadding="2">
  <tr>
    <td width="56%" align="center" style="border: #9AB1B6 1px solid;"><table width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="welcome"><?php echo LANG_est_viewteachers ?></td>
      </tr>
      <tr>
        <td height="2"><hr color="#9AB1B6" size="1px"></td>
      </tr>
      <tr>
        <td height="2"><br></td>
      </tr>
      <tr>
        <td width="65%" height="2" class="td_whbk2"><table width="100%" border="0" cellspacing="1" cellpadding="2">
          <tr>
            <td width="56%" align="center" class="style3">Item evaluado</td>
            <td width="13%" align="center" class="style3">Valor %</td>
            <td width="16%" align="center" class="style3">Corregido</td>
            <td width="15%" align="center" class="style3">Nota</td>
            </tr>
      
          <tr>
            <td class="td_whbk">&nbsp;</td>
            <td align="center" class="td_whbk">&nbsp;</td>
            <td align="center" class="td_whbk">&nbsp;</td>
            <td align="right" class="td_whbk">&nbsp;</td>
            </tr>
        
          <tr>
            <td colspan="3" align="center" class="no_back">&nbsp;</td>
            <td align="right" class="no_back">&nbsp;</td>
            </tr>
        </table></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr> 
   </table>
</body>
</html>
<?

$tool->cerrar();

?>