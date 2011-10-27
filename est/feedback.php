<?php session_start();
$profile = 'est'; /////////////// perfil requerido
include("../config/setup.php"); ////////setup
include("../class/clases.php");
include("../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

$est = new tools("db");
$fecha = new fecha($_SESSION['DB_FORMATO']);

$data = $est->simple_db("select * from tbl_estudiante where id = {$_SESSION['USER']}");

?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../css/style_front.css">

<title>

</title>

<script language="JavaScript" type="text/javascript">
	function cambio (valor){
	
		switch (valor){
		   case '1': 
			  document.getElementById('tipo_com').innerHTML = '<?=LANG_est_feed_com1 ?>';
			  break;
		   case '2': 
			  document.getElementById('tipo_com').innerHTML = '<?=LANG_est_feed_com2 ?>';
			  break;
		   case '3': 
			  document.getElementById('tipo_com').innerHTML = '<?=LANG_est_feed_com3 ?>';
			  break;
		} 

	
	}
</script>


</head>
<body>
<form action="<?=$FEEDBACK?>" name="form1" method="post" enctype="application/x-www-form-urlencoded">
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td colspan="2" class="welcome"><?=LANG_est_feed?> </td>
</tr>
<tr>
<td colspan="2">&nbsp;</td>
</tr>
<tr>
<td width="30%" class="style3"><?=LANG_est_feed_type ?></td>
<td width="70%"><select name="com" id="com" onChange="cambio(this.value);">
  <option value="1" selected><?=LANG_est_feed_type_general?></option>
  <option value="2"><?=LANG_est_feed_type_su?></option>
  <option value="3"><?=LANG_est_feed_type_error?></option>
</select></td>
</tr>
<tr>
<td colspan="2">&nbsp;</td>
</tr>
<tr>
<td colspan="2" class="table_bk"><div id="tipo_com">&nbsp;<?=LANG_est_feed_com1 ?> </div></td>
</tr>
<tr>
<td colspan="2">&nbsp;</td>
</tr>
<tr>
<td colspan="2"><textarea name="com1" class="style1" cols="90" rows="5"></textarea></td>
</tr>
<tr>
<td colspan="2">&nbsp;</td>
</tr>
<tr>
<td colspan="2" class="table_bk"><?=LANG_est_feed_pros?> </td>
</tr>
<tr>
<td colspan="2">&nbsp;</td>
</tr>
<tr>
<td colspan="2">
  <textarea name="pros" class="style1" cols="90" rows="5"></textarea></td>
</tr>
<tr>
<td colspan="2">&nbsp;</td>
</tr>
<tr>
<td colspan="2" class="table_bk"><?=LANG_est_feed_contras ?> </td>
</tr>
<tr>
<td colspan="2">&nbsp;</td>
</tr>
<tr>
<td colspan="2"><textarea name="contras" class="style1" cols="90" rows="5"></textarea></td>
</tr>
<tr>
<td colspan="2">&nbsp;</td>
</tr>
<tr>
<td colspan="2"><input type="submit" name="Submit" value="<?=LANG_save?>">
  &nbsp;
  <input type="button" name="Submit2" onClick="window.close();" value="cerrar"></td>
</tr>
</table>
</form>
</body>
</html>
<?

$est->cerrar();

?>