<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../config/setup.php"); ////////setup
include("../../../class/clases.php"); ////////clase
include("../../../config/lang/{$_SESSION['LENGUAJE']}"); ////lenguaje

$tool = new formulario("db");

$nombre = $_REQUEST['nombre'] ?? '';
$com = $tool->array_query("select content from tbl_foro_respuesta where id = '{$_REQUEST['id']}'");

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit post response </title>
  <link rel="stylesheet" type="text/css" href="../../../css/style_back.css">
  <script src="../../../js/jquery/jquery-3.3.1.min.js"></script>
</head>

<body>
  <form name="form1" id="form1" method="post">
    <table style="width: 100%;">
      <tr>
        <td class="style3">
          <input name="id" type="hidden" id="id" value="<?= $_REQUEST['id'] ?>">
          &nbsp;<?php echo LANG_foro_response . ': ' . $nombre ?>
        </td>
      </tr>
      <tr>
        <td>
          <textarea name="r-content" id="r-content" cols="96" rows="9" class="style3" id="comm"><?php echo $com[0]; ?>
        </textarea>
        </td>
      </tr>
      <tr>
        <td><input type="button" name="Submit2" value="<?= LANG_close ?>" onClick="window.close();">
          <input type="submit" id="Submit" name="Submit" value="<?= LANG_save ?>">
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
<?php $tool->cerrar(); ?>