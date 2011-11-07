<?php session_start();
$profile = 'est'; /////////////// perfil requerido
include("../config/setup.php"); ////////setup
include("../class/clases.php");
include ("../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje


 $datos = new tools("db");
 $data = $datos->array_query2("select signature,formato_fecha,formato_fecha_db,titulo,version from tbl_setup");
 $_SESSION['DB_FORMATO_DB'] = $data[2];
 $_SESSION['DB_FORMATO'] = $data[1];

?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="../css/style_front.css">
<script type="text/javascript" src="../js/dynifs.js"></script>
<script type="text/javascript" src="../js/utils.js"></script>

<title><?php echo $data[3].' '.$data[4];  ?></title>
</head>

<body bottommargin="0" leftmargin="0" rightmargin="0" topmargin="0">
<table width="100%" height="100" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="462" height="80" background="../images/frontend/upbackgraund.jpg"><table width="100%" height="80" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="7%" height="40" align="right" valign="top">&nbsp;</td>
        <td width="93%" align="left" valign="top"><img src="../images/frontend/logomini.gif" width="129" height="39"></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td valign="middle" class="small"><b><?=LANG_est?>:</b> <?=$_SESSION['NOMBRE'] ?>
          <br>
          <b>
          <span class="small">
          <?= LANG_curso_id ?>
          </span></b>
          <?
		
		echo $datos->combo_db("curso","select id,alias from tbl_curso where id in ({$_SESSION['CURSOSID']})","alias","id",LANG_select,$_SESSION['CURSOID'],"content.location.replace('main.php?curso='+this.value);",LANG_curso_nocurso);
		
		?></td>
        </tr>
    </table></td>
    <td align="right" background="../images/frontend/upbackgraund.jpg"><table width="100%" height="80" border="0" align="right" cellpadding="0" cellspacing="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="right" nowrap><a href="main.php" target="content" class="linkmenu">
          <?=LANG_est_inicio?>
          </a>&nbsp; <strong>|</strong>&nbsp;<a href="user/index.php" target="content" class="linkmenu">
            <?=LANG_est_myacount?>
            </a>&nbsp; <strong>|</strong> <a href="mensajes/index.php" target="content" class="linkmenu">
              <?=LANG_msg_msgs?>
              </a> &nbsp;<strong>|</strong> <a href="notas/index.php" target="content" class="linkmenu" title="<?=LANG_est_cal_text?>">
                <?=LANG_est_cal_main?>
                </a>&nbsp;<strong>|</strong> <a href="cerrar.php" class="linkmenu" style="color:#FF0000" title="<?=LANG_ADMIN_cerrar?>">
                  <?=LANG_ADMIN_cerrar?>
                </a>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="2" colspan="2" align="center"><iframe scrolling="no" id="content" align="middle" allowtransparency="yes" frameborder="0" name="content" hspace="0" width="99%" src="main.php" onload="DYNIFS.resize('content')"></iframe></td>
  </tr>
  <tr>
    <td colspan="2"><hr size="1px" color="#9AB1B6">
      <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="63%" class="small"><?=LANG_license ?>&nbsp;<?php echo date("Y"); ?></td>
          <td width="37%" align="right" class="linkmenu">
          <a href="main.php" target="content" class="linkmenu">
          <?=LANG_est_inicio?>
          </a>&nbsp;<strong>|</strong>
          <!--&nbsp;<a href="javascript:popup('feedback.php','nuevo',510,500);" target="content" class="linkmenu"><?=LANG_feedback?></a>-->
          <!--&nbsp;<strong>|</strong>-->
          <a href="staff.php" target="content" class="linkmenu">
          <?=LANG_est_viewteachers?>
          </a>&nbsp;<strong>|</strong>&nbsp;<a href="support/index.php" target="content"  class="linkmenu"><?=LANG_ADMIN_help?>
          </a></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<?php $datos->cerrar(); ?>