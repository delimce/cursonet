<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../config/setup.php"); ////////setup
include("../../../class/clases.php"); ////////clase
include ("../../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);

 
  $grid = new tools("db");
  $query = "SELECT  e.id,LOWER(concat(e.nombre,' ',e.apellido)) as nombre,e.id_number,
  (SELECT count(*) FROM tbl_foro_comentario ff WHERE (ff.sujeto_id = e.id) AND (ff.tipo_sujeto = 'est') and (ff.foro_id = f.id)) AS comentarios,
  (select count(*) from tbl_foro_comentario where foro_id = f.id and valido = 1 and tipo_sujeto = 'est' and sujeto_id = e.id) as val,
					
  (select nota from tbl_foro_estudiante where est_id = e.id and foro_id = f.id ) as nota
FROM
  tbl_estudiante e,
  tbl_foro f
WHERE
    (e.id in (select est_id from tbl_grupo_estudiante where grupo_id = f.grupo_id ) or f.grupo_id = 0) and
    f.id = {$_REQUEST['ItemID']} order by e.id ";
	
	
	
	
	
	if(isset($_REQUEST['ItemID'])){
	
		 $data1 = $grid->array_query("select round(nota,1) from tbl_foro_estudiante where foro_id = {$_REQUEST['ItemID']} order by est_id");
		 $grid->query($query);
		 
	}else if(isset($_POST['notas'])){
	
		   $grid->query("SET AUTOCOMMIT=0"); ////iniciando la transaccion
           $grid->query("START TRANSACTION");
	
			for($j=0;$j<count($_POST['notas']);$j++){
			
				$valores[0]=$_POST['est'][$j];
				$valores[1]=$_POST['foroid'];
				$valores[2]=$_POST['notas'][$j];
				
				
				$foroid2 = $grid->simple_db("select id from tbl_foro_estudiante where est_id = '$valores[0]' and foro_id = '$valores[1]' ");
				
					if($grid->nreg==0){
					
						$grid->insertar2("tbl_foro_estudiante","est_id,foro_id,nota",$valores);
						
					}else{
					
					
						$grid->query("update tbl_foro_estudiante set nota = '$valores[2]' where id = '$foroid2'");
					
					
					}	
				
			
			}
			
			
			
			
			$grid->query("COMMIT");
			
			$grid->cerrar();
			
			if(!empty($_REQUEST['item'])){ ///viene desde planes
			
			?>
            <script type="text/javascript">
			history.go(-2);
			</script>

            <?
			
			}else{ $grid->javaviso(LANG_foro_tema_ok,"index.php"); }
			
	
	}	 

?>
<html>
<head>
	<script language="JavaScript" type="text/javascript">
	function validar(){
		var error,pos;

					error=0;
                	for(i=0;i<document.form1.length;i++) {
                		if (document.form1.elements[i].type=="text" && (document.form1.elements[i].value=="" || isNaN(document.form1.elements[i].value)) ){
						   	error=1;
							pos = (i+1)/2;
							break;
                         }
					}
					
					
					if(error==1){
					
					alert('<?=LANG_foro_nonota ?>'+pos);
					return false;
					
					}else{
					
					return true;
					
					}
	
	
	}
	</script>

	
<link rel="stylesheet" type="text/css" href="../../../css/style_back.css">
</head>

<body>

<form name="form1" method="post" action="foro.php" onSubmit="return validar();">
<table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="26" valign="top"><?php echo $menu->nombre; ?>&nbsp;<span class="style3">
      <?=$_REQUEST['item'] ?>
    </span></td>
  </tr>
  <tr>
    <td><?php $menu->mostrar(0); ?></td>
  </tr>
  <tr>
    <td>
	
	<table style="border-right:#000000 solid 1px; border-left:#000000 solid 1px; border-bottom:#000000 solid 1px;" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><br>
		
	   <table width="99%" height="*" align="center" border="0" cellspacing="0" cellpadding="0">
	   <tr>
	    <td>
		  <table class="table_bk" width="100%" height="100%" cellpadding="0"  cellspacing="0">
            <tr><td align="center"><table width="100%" height="100%" class="" border="0" cellspacing="1" cellpadding="2">
			 <tr>  <td width="37%" align="center" class="style3"><?=LANG_name?></td>
			           <td width="24%" align="center" class="style3"><?=LANG_ci?></td>
					   <td width="23%" align="center" class="style3"><?=LANG_comment?></td>
					   <td width="23%" align="center" class="style3"><?=LANG_foro_nval?></td>
					   <td width="16%" align="center" class="style3"><?=LANG_nota?></td>
			</tr> 
			
			<?php 
			$j=0;
			
			
			while ($row = mysql_fetch_assoc($grid->result)) {
			
			?>
			<tr class="td_whbk" onMouseOver="this.style.backgroundColor = '#CCCCCC'" onMouseOut="this.style.backgroundColor = '#FFFFFF'">
				
				<td class="style1" align="left"><?=$row['nombre']?>
				  <input name="est[]" type="hidden" id="est[]" value="<?=$row['id']?>"></td>
				<td title="<?=$row['id_number']?>" class="style1" align="center"><?=$row['id_number']?></td>
				<td class="style1" align="center"><?=$row['comentarios']?></td>
				<td class="style1" align="center"><?=$row['val']?></td>
				<td class="style1" align="center"><input name="notas[]" type="text" id="notas[]" style="text-align:center;" value="<?php echo $data1[$j] ?>" size="6" maxlength="5"></td>
			</tr>
			<?php 
			
			$j++;
			
			}
			
			?>
			
		</table>
        </td></tr></table></td></tr></table>&nbsp;<br>
		  <input type="button" name="Submit2" onClick="history.back();" value="<?=LANG_back?>">
		  <input type="submit" name="Submit" value="<?=LANG_save?>">
		  <input name="foroid" type="hidden" id="foroid" value="<?=$_REQUEST['ItemID'] ?>">
          <input name="item" type="hidden" id="item" value="<?=$_REQUEST['item'] ?>">
		  <br>
		  <br></td>
      </tr>
    </table>	
	</td>
  </tr>
</table>

 </form>

</body>
</html>
<?php 


$grid->cerrar();

?>
