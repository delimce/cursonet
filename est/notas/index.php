<?php session_start();
$profile = 'est'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/tools.php");
include("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

$tool = new tools();
$tool->autoconexion();

$tool->query("SELECT DISTINCT 
  c.nombre,
  c.descripcion as des,
  p.id
FROM
  curso c
  INNER JOIN grupo_estudiante g ON (c.id = g.curso_id)
  INNER JOIN plan_evaluador p ON (g.grupo_id = p.grupo_id)
WHERE
  g.est_id = '{$_SESSION['USER']}'");

?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../../css/style_front.css">
</head>
<body>
<table width="100%" border="0" cellspacing="6" cellpadding="2">
  <tr>
    <td width="56%" align="center" style="border: #9AB1B6 1px solid;">
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
      <td colspan="2" class="welcome">
        <?= LANG_est_cal_main ?>      </td>
    </tr>
      <tr>
      <td height="2" colspan="2"><hr color="#9AB1B6" size="1px"></td>
    </tr>
      <tr>
      <td height="2" colspan="2"><br></td>
    </tr>
      <tr>
        <td height="2" colspan="2" class="style3"><?php echo LANG_est_selectcurso ?></td>
      </tr>
      <tr>
        <td height="2" colspan="2">&nbsp;</td>
      </tr>
      
      <?php while ($row = mysql_fetch_assoc($tool->result)) { ?>
      
      <tr>
        <td height="2" colspan="2" class="style1"><a title="Ver notas" href="notas.php?id=<?php echo $row['id'] ?>"><?php echo stripcslashes($row['nombre']); ?> </a> <?php if(!empty($row['des']))echo '- '.stripcslashes($row['des']); ?></td>
      </tr>
      <?php } ?>
      
    <tr>  
      <td><p class="style3">&nbsp;
        </p>
        <p class="style3">
          <input type="button" name="b1"  value="<?=LANG_back?>" onClick="location.replace('../main.php');">
          
        </p>
        <p></td>
    </tr>
     <tr>  
    <td>&nbsp;</td>
    </tr>
    </table>
    </td>
   </tr> 
   </table>
</body>
</html>
<?

$tool->cerrar();

?>