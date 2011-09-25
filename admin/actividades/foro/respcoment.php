<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../config/setup.php"); ////////setup
include("../../../class/formulario.php"); ////////clase
include ("../../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

$tool = new formulario();
$tool->autoconexion();

        if(isset($_POST['Submit'])){ 
		
		
        $_POST['r-content'] = mysql_escape_string($_POST['r-content']);
		$_POST['r-fecha'] = @date("Y-m-d H:i:s");

        $tool->insert_data("r","-","foro_respuesta",$_POST);

        ?>

        <script language="JavaScript" type="text/javascript">
                window.opener.location.reload();
                window.close();
        </script>

        <?


        }

?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../../../css/style_back.css">

</head>

<body>
<form name="form1" method="post" action="respcoment.php">
  <table width="100%" border="0" cellspacing="3" cellpadding="2">
    <tr>
      <td class="style3"><input name="r-com_id" type="hidden" id="r-com_id" value="<?=$_REQUEST['id'] ?>">
        <input name="r-prof_id" type="hidden" id="r-prof_id" value="<?=$_SESSION['USERID'] ?>">
      &nbsp;<?php echo LANG_foro_response.': '.$_REQUEST['nombre'] ?></td>
    </tr>
    <tr>
      <td align="center"><textarea name="r-content" cols="96" rows="9" class="style3" id="r-content"><?php echo $com[0]; ?></textarea></td>
    </tr>
    <tr>
      <td><input type="button" name="Submit2" value="<?=LANG_close?>" onClick="window.close();">
      <input type="submit" name="Submit" value="<?=LANG_save?>"></td>
    </tr>
  </table>
</form>


</body>
</html>
<?

$tool->cerrar();

?>