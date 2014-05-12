<?php session_start();
 include("../config/dbconfig.php");
 include("../class/clases.php");

 
 $nuevo = new tools("db");
 
  if(!isset($_SESSION['USUARIO'])){
  
 	$nuevo->cerrar();
	$nuevo->redirect('../error/error.php');
 
 }
 
 $val = $nuevo->array_query2("select fin_inscripcion,lenguaje from tbl_setup");
 
 
  include("../config/lang/$val[1]"); ///idioma
 
 

 

?>
<html>
<head> <meta charset="utf-8">
<title><?= $_SESSION['TINSCRIPCION'] ?></title>
<link rel="stylesheet" type="text/css" href="../css/style_front.css">
<style type="text/css">
<!--
.style3 {color: #FF0000}
-->
</style>


</head>

<body vlink="#000080" bgcolor="#FFFFFF">

<table width="755" height="1" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" id="AutoNumber2" style="border-collapse: collapse; border-bottom-width:0">
  <tr>
    <td width="755" style="border-left:1px solid #CCCCCC; border-right-style:solid; border-right-width:1; border-top-style:solid; border-top-width:1; border-bottom-style:none; border-bottom-width:medium" height="59" bgcolor="#3399FF">
    <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse; border-width: 0" bordercolor="#111111" width="100%" id="AutoNumber6" height="72">
      <tr>
        <td width="28%" height="70" align="center" bgcolor="#7A98AD" style="border-style: none; border-width: medium">
          <p style="margin-left: 5"><img src="../images/frontend/logo_corner.gif" width="162" height="75"></td>
        <td width="72%" height="70" bgcolor="#7A98AD" style="border-style: none; border-width: medium">
          <p align="center" style="margin-top: 0; margin-bottom: 0">&nbsp;</p></td>
        </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td width="755" height="1" valign="bottom" bgcolor="#CCCCCC" style="border-left:1px solid #CCCCCC; border-right-style: solid; border-right-width: 1; border-bottom-style: solid; border-bottom-width: 1; border-top-style:none; border-top-width:medium">
	
	  <form name="form1" method="post" action="guarda.php" target="ins" onSubmit="return validar();">
	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="no_back"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td  height="400" align="center"><div class="style1" style="margin-left:30; margin-right:30; margin-bottom:30"><?php echo LANG_thanx; echo ' '; echo $_SESSION['USUARIO']; echo '<br>'; echo $val[0]; ?></div></td>
            </tr>
          
        </table></td>
      </tr>
     </table>

	  </form>
	  
      <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse; border-width: 0" bordercolor="#CCCCCC" width="100%" id="AutoNumber3">
      <tr>
        <td width="229%" style="border-style: none; border-width: medium" valign="top" bgcolor="#7A98AD">
        <p align="center" style="margin-top: 5; margin-bottom: 5"><b>
        <font face="Arial" size="1" color="#FFFFFF"><?=$val[2]?>
        </font></b></td>
      </tr>
    </table>
    </td>
  </tr>
</table>
</body>

</html>
<?php 
unset($_SESSION['USUARIO']);
unset($_SESSION['FECHA']);
unset($_SESSION['EEMAIL']);
unset($_SESSION['TINSCRIPCION']);

$nuevo->cerrar();


?>