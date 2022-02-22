<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../config/setup.php"); ////////setup
include("../../../class/clases.php"); ////////clase
include("../../../config/lang/{$_SESSION['LENGUAJE']}"); ////lenguaje

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="../../../css/style_back.css">
  <script src="../../../js/jquery/jquery-3.3.1.min.js"></script>
</head>

<body>
  <form name="form1" id="form1" method="post" action="savePostResponse.php">
    <table width="100%" border="0" cellspacing="3" cellpadding="2">
      <tr>
        <td class="style3"><input name="comentario_id" type="hidden" id="comentario_id" value="<?= $_REQUEST['id'] ?>">
          <input name="sujeto_id" type="hidden" id="sujeto_id" value="<?= $_SESSION['USERID'] ?>">
          <input name="tipo_sujeto" type="hidden" id="tipo_sujeto" value="admin">
          &nbsp;<?php echo LANG_foro_response . ': ' . $_REQUEST['nombre'] ?>
        </td>
      </tr>
      <tr>
        <td align="center">
          <textarea name="content" cols="96" rows="9" class="style3" id="content"></textarea>
        </td>
      </tr>
      <tr>
        <td><input type="button" name="Submit2" value="<?= LANG_close ?>" onClick="window.close();">
          <input type="submit" name="Submit" value="<?= LANG_save ?>">
        </td>
      </tr>
    </table>
  </form>
</body>
<script>
  $(function() {
    $('#form1').submit(function(e) {
      let myData = $('#form1').serialize();
      jQuery.ajax({
        type: "POST",
        url: "savePostResponse.php",
        data: myData,
        cache: false,
        success: function(res) {
          window.opener.location.reload();
          window.close();
        }
      })
      e.preventDefault();
    });

  });
</script>


</html>