<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../config/setup.php"); ////////setup
include("../../../class/clases.php"); ////////clase
include("../../../config/lang/{$_SESSION['LENGUAJE']}"); ////lenguaje

$tool = new formulario("db");

if (isset($_POST['Submit'])) {

  $_POST['r-content'] = $tool->getvar('r-content',$_POST);
  $_POST['r-created_at'] = @date("Y-m-d H:i:s");
  $_POST['r-updated_at'] = @date("Y-m-d H:i:s");
  $tool->insert_data("r", "-", "tbl_foro_respuesta", $_POST);
?>
  <script language="JavaScript" type="text/javascript">
    window.opener.location.reload();
    window.close();
  </script>
<?php
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="../../../css/style_back.css">

</head>

<body>
  <form name="form1" method="post" action="respcoment.php">
    <table width="100%" border="0" cellspacing="3" cellpadding="2">
      <tr>
        <td class="style3"><input name="r-comentario_id" type="hidden" id="r-comentario_id" value="<?= $_REQUEST['id'] ?>">
          <input name="r-sujeto_id" type="hidden" id="r-sujeto_id" value="<?= $_SESSION['USERID'] ?>">
          <input name="r-tipo_sujeto" type="hidden" id="r-tipo_sujeto" value="admin">
          &nbsp;<?php echo LANG_foro_response . ': ' . $_REQUEST['nombre'] ?></td>
      </tr>
      <tr>
        <td align="center">
          <textarea name="r-content" cols="96" rows="9" class="style3" id="r-content"></textarea>
        </td>
      </tr>
      <tr>
        <td><input type="button" name="Submit2" value="<?= LANG_close ?>" onClick="window.close();">
          <input type="submit" name="Submit" value="<?= LANG_save ?>"></td>
      </tr>
    </table>
  </form>


</body>

</html>
<?php $tool->cerrar(); ?>