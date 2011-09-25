<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/tools.php"); ////////clase
include("../../class/fecha.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);


 $crear = new tools();
 $crear->autoconexion();
 


?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../../css/style_back.css">

	

</head>

<body>
<table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="26" valign="top"><?php echo $menu->nombre; ?></td>
  </tr>
  <tr>
    <td><?php $menu->mostrar(2); ?></td>
  </tr>
  <tr>
    <td>

	<table style="border-right:#000000 solid 1px; border-left:#000000 solid 1px; border-bottom:#000000 solid 1px;" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><form name="form1" method="post" action="crear.php" onSubmit="return validar();">
<table width="100%" border="0" cellpadding="3" cellspacing="3">
  <tr>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td class="style3"><?php echo LANG_planes_selectplan ?>&nbsp;</td>
    </tr>
  <tr>
    <td><? echo $crear->combo_db("plan","select id,titulo from plan_evaluador where grupo_id in (select id from grupo where curso_id = {$_SESSION['CURSOID']})","titulo","id",LANG_select,false,false); ?></td>
    </tr>
</table>
<br>
        </form></td>
      </tr>
    </table>	</td>
  </tr>
</table>
</body>
</html>
<?php  $crear->cerrar(); ?>