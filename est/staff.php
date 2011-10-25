<?php session_start();
$profile = 'est'; /////////////// perfil requerido
include("../config/setup.php"); ////////setup
include("../class/formulario.php");
include("../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

$tool = new formulario('db');

$ide = $tool->getvar('id',$_GET);
if(!empty($ide)) $extra = "Where a.id = '$ide' ";

$tool->query("SELECT 
  a.id,
  CONCAT(a.apellido,' ',a.nombre) as nombre,
  a.foto,
  a.email,
  a.cursos,
  a.telefono,
  a.sintesis
  from tbl_admin a $extra ");


?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../css/style_front.css"/>
</head>

<body>
<table width="100%" border="0" cellspacing="6" cellpadding="2">
  <tr>
    <td width="56%" align="center" style="border: #9AB1B6 1px solid;"><table width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="65%" class="welcome"><?php echo LANG_est_viewteachers ?></td>
      </tr>
      <tr>
        <td height="2"><hr color="#9AB1B6" size="1px"></td>
      </tr>
      <tr>
        <td height="2">
		
		<?php
		
		if(!empty($_SESSION['CURSOID'])){
		
		while ($row = mysql_fetch_assoc($tool->result)) {
			
			$vc = explode(',',$row["cursos"]);
		
		 /////modificado para que muestre los datos del profesor en el caso de ser admin y no tener cursos asignados
		 if(in_array($_SESSION['CURSOID'],$vc) or $ide == $row["id"]){ ?>
         
         <div class="resultado">
          <table width="800" border="0" align="left" cellpadding="2" cellspacing="1">
          <tr>
            <td colspan="2" align="left" class="style3"><strong><?php echo $row['nombre'] ?> </strong></td>
          </tr>
          <tr>
            <td width="13%" align="center" class="no_back"><?php
			
									if(empty($row['foto'])){ 
											$link = '../images/frontend/nofoto.png'; 
	   								}else{
	  										$link = '../recursos/admin/fotos/'.$row['foto'];  
									} 
								?>
              <img style="border:solid 1px" src="<?php echo $link ?>"></td>
            <td width="87%" align="left" valign="top" class="no_back">
              <?php if(!empty($row['telefono'])) echo '<b>'.LANG_phone.'</b>&nbsp;'.$row['telefono'].'<br>'; ?>
              <?php if(!empty($row['fax'])) echo '<b>'.LANG_fax.'</b>&nbsp;'.$row['fax'].'<br>'; ?>
              <?php if(!empty($row['email'])) echo '<b>'.LANG_email.'</b>&nbsp;<a href="mailto:'.$row['email'].'" target="_self">'.$row['email'].'</a><br>'; ?>
              <?php if(!empty($row['sintesis'])) echo '<b>'.LANG_resume.'</b>&nbsp;'.$row['sintesis'].'<br>'; ?>
              </td>
          </tr>
          </table>
          </div>
          

          <?php   }///if
		  
		  		unset($vc);
		  
				} //while
				
			}else{ echo LANG_curso_noselect; } //if	
		   ?>
          
      
          </td>
      </tr>
       <tr>
        <td height="2"><span class="style3">
          <input type="button" name="b1"  value="<?=LANG_back?>" onClick="location.replace('main.php');">
        </span></td>
      </tr>
    </table></td>
  </tr> 
   </table>
</body>
</html>
<?php $tool->cerrar(); ?>