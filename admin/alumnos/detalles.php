<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);


 
 
  $det = new tools();
  $det->autoconexion();
  
  
  
  
 $query = "select *,
 concat(nombre,' ',apellido) as nombre,date_format(fecha_nac,'".$_SESSION['DB_FORMATO_DB']."') as nac,(SELECT 
  g.nombre
FROM
  grupo g
  INNER JOIN grupo_estudiante e ON (g.id = e.grupo_id)
WHERE
  e.est_id = '{$_REQUEST['id']}' and e.curso_id = '{$_SESSION['CURSOID']}' ) as grupo,
  date_format(fecha_creado,'".$_SESSION['DB_FORMATO_DB']."') as creado from estudiante where id = '{$_REQUEST['id']}'";
	 


	$data = $det->simple_db($query); //////se ejecuta el query

?>
<html>
<head>
		
	
	
<link rel="stylesheet" type="text/css" href="../../css/style_back.css">
</head>

   <BODY>

<table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="26" valign="top"><?php echo $menu->nombre; ?></td>
  </tr>
  <tr>
    <td><?php $menu->mostrar($_REQUEST['origen']); ?></td>
  </tr>
  <tr>
    <td>
	
	<table style="border-right:#000000 solid 1px; border-left:#000000 solid 1px; border-bottom:#000000 solid 1px;" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center"><br>&nbsp;<br>
          <table style="border: 1px solid #666;" width="90%" border="0" cellpadding="2" cellspacing="1">
              <tr>
                <td colspan="3" align="left" class="table_bk"><?=LANG_studentdata ?></td>
              </tr>
              <tr>
                <td width="29%" rowspan="5" align="center" class="style3"><table width="85%" border="0" align="center" cellpadding="2" cellspacing="1">
                  <tr>
                    <td align="center" class="style3"><?php echo LANG_profilephoto ?></td>
                  </tr>
                  <tr>
                    <td align="center"><?php if(empty($data['foto'])){ $link = '../../images/frontend/nofoto.png'; $nombre = LANG_nopicture;
	   }else{
	  $link = '../../recursos/est/fotos/'.$data['foto'];  $nombre = $data['foto']; } ?>
                      <img style="border:solid 1px" src="<?=$link ?>"></td>
                  </tr>
                </table></td>
              <td width="25%" class="style1"><span class="style3"><?php echo LANG_name ?></span></td>
              <td width="46%" class="style1"><?php echo $data['nombre'] ?></td>
            </tr>
            <tr>
              <td class="style1"><span class="style3"><?php echo LANG_ci ?></span></td>
              <td class="style1"><?php echo $data['id_number'] ?></td>
            </tr>
            <tr>
              <td class="style1"><span class="style3"><?php echo LANG_sex ?></span></td>
              <td class="style1"><?php echo $data['sexo'] ?></td>
            </tr>
            <tr>
              <td class="style1"><span class="style3"><strong>
                <?=LANG_email ?>
              </strong></span></td>
              <td class="style1"><a style="color:#0000FF" title="<?php echo LANG_email_send ?>" href="mailto:<?php echo $data['email'] ?>"><?php echo $data['email'] ?></a></td>
            </tr>
            <tr>
              <td class="style1"><span class="style3"><strong>
                <?=LANG_fecha_nac ?>
              </strong></span></td>
              <td class="style1"><?php echo $data['nac'] ?></td>
            </tr>
            <tr>
              <td colspan="3" class="style3">&nbsp;</td>
              </tr>
            <tr>
              <td class="style3"><strong>
                <?=LANG_login ?>
              </strong></td>
              <td colspan="2" class="style1"><?php echo $data['user'] ?></td>
            </tr>
            <tr>
              <td class="style3"><strong>
                <?= LANG_university ?>
              </strong></td>
              <td colspan="2" class="style1"><?php echo $data['universidad'] ?></td>
            </tr>
            <tr>
              <td class="style3"><strong>
                <?=LANG_group ?>
              </strong></td>
              <td colspan="2" class="style1"><?php echo $data['grupo'] ?></td>
            </tr>
            <tr>
              <td class="style3"><strong>
                <?=LANG_faculty_level ?>
              </strong></td>
              <td colspan="2" class="style1"><?php echo $data['nivel'] ?></td>
            </tr>
            <tr>
              <td class="style3">&nbsp;</td>
              <td colspan="2" class="style1">&nbsp;</td>
            </tr>
            <tr>
              <td class="style3"><strong>
                <?= LANG_tel1 ?>
              </strong></td>
              <td colspan="2" class="style1"><?php echo $data['telefono_p'] ?></td>
            </tr>
            <tr>
              <td class="style3"><strong>
                <?= LANG_tel2 ?>
              </strong></td>
              <td colspan="2" class="style1"><?php echo $data['telefono_c'] ?></td>
            </tr>
            <tr>
              <td class="style3"><strong>
                <?= LANG_msn ?>
              </strong></td>
              <td colspan="2" class="style1"><?php echo $data['msn'] ?></td>
            </tr>
            <tr>
              <td class="style3"><strong>
                <?= LANG_yahoo ?>
              </strong></td>
              <td colspan="2" class="style1"><?php echo $data['yahoo'] ?></td>
            </tr>
            <tr>
              <td class="style3">&nbsp;</td>
              <td colspan="2" class="style1">&nbsp;</td>
            </tr>
            <tr>
              <td class="style3"><strong>
                <?= LANG_a_internet ?>
              </strong></td>
              <td colspan="2" class="style1"><?php echo $data['internet_acc'] ?></td>
            </tr>
            <tr>
              <td class="style3"><strong>
                <?= LANG_d_internet ?>
              </strong></td>
              <td colspan="2" class="style1"><?php echo $data['internet_zona'] ?></td>
            </tr>
            <tr>
              <td class="style3"><strong>
                <?= LANG_est_cont_fecha ?>
              </strong></td>
              <td colspan="2" class="style1"><?php echo $data['creado'] ?></td>
            </tr>
            <tr>
              <td class="style3">&nbsp;</td>
              <td colspan="2" class="style1">&nbsp;</td>
            </tr>
           
        <?
		
		/////en el caso que el alumno posea un plan de evaluacion asociado
		$queryg = "SELECT 
					p.id,
					p.titulo,
					curso.nombre
				  FROM
					grupo_estudiante g
					INNER JOIN plan_evaluador p ON (g.grupo_id = p.grupo_id)
					INNER JOIN curso ON (g.curso_id = curso.id)
				  WHERE
					g.est_id = '{$data['id']}' order by titulo";
					  
					  
			$det->query($queryg);	
			
			if($det->nreg>0){
		
		?>
           
            <tr>
              <td colspan="3" class="table_bk"><?php echo LANG_notes_plan ?></td>
            </tr>
           
                <?php while ($row = mysql_fetch_assoc($det->result)) { ?>
                <tr>
                  <td class="style3"><a href="notas.php?id=<?php echo $row['id'] ?>&origen=<?=$_REQUEST['origen'];  ?>&estid=<?php echo $data['id'] ?>" title="<?php echo LANG_notes_view ?>"><?php echo $row['titulo'];  ?></a></td>
                  <td colspan="2" class="style1"><?php echo stripcslashes($row['nombre']);  ?></td>
                </tr>
              
            	<?php } ?>
                  <tr>
                  <td class="style3">&nbsp;</td>
                  <td colspan="2" class="style1">&nbsp;</td>
                </tr>
            
            
    <?php    }  ?>     
            
            
            <tr>
              <td colspan="3"><input type="button" name="button" id="button" value="<?php echo LANG_back ?>" onClick="history.back();">
                &nbsp;</td>
              </tr>
          </table>
          <br>&nbsp;</td>
      </tr>
    </table>	</td>
  </tr>
</table>
</body>
</html>
<?

	 $det->cerrar();

?>
