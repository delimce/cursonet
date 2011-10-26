<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../config/setup.php"); ////////setup
include("../../../class/clases.php"); ////////clase
include ("../../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

$tool = new formulario();
$tool->autoconexion();

        if(!isset($_POST['Submit'])){ 
		
			$com = $tool->array_query("select content from foro_respuesta where id = '{$_REQUEST['id']}'");

        }else{

        $comentario = mysql_escape_string($_POST['comm']);

        $tool->query("update foro_respuesta set content = '$comentario' where id = {$_POST['id2']} ");

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
<form name="form1" method="post" action="editresp.php">
  <table width="100%" border="0" cellspacing="3" cellpadding="2">
    <tr>
      <td class="style3"><input name="id2" type="hidden" id="id2" value="<?=$_REQUEST['id'] ?>">
      &nbsp;<?php echo LANG_foro_response.': '.$_REQUEST['nombre'] ?></td>
    </tr>
    <tr>
      <td align="center"><textarea name="comm" cols="96" rows="9" class="style3" id="comm"><?php echo $com[0]; ?></textarea></td>
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