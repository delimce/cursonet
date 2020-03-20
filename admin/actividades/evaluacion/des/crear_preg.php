<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../../config/setup.php"); ////////setup
include("../../../../class/clases.php"); ////////clase
include ("../../../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);


 $crear = new tools("db");


				 ////////////////////////////////////////////////////////////////////////////
                 if(isset($_GET['nombre'])){

                 $_SESSION['eva_seccion']= $_GET['seccion'];
                 $_SESSION['eva_caso']  = $_GET['caso'];
                 $_SESSION['eva_nombre'] = $_GET['nombre'];
                 $_SESSION['eva_minutos']   = $_GET['minutos'];
                 $_SESSION['eva_preg']  = $_GET['preguntas'];
                 $_SESSION['eva_fecha']  = $_GET['fecha'];
                 $_SESSION['eva_fecha2']  = $_GET['fecha2'];

                 }
                 ///////////////////////////////////////////

?>
<!DOCTYPE html>
<html>
<head> <meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="../../../../css/style_back.css">

        <script language="JavaScript" type="text/javascript">
        function validar(){

        var error,pos;

                                        error=0;
                        for(i=0;i<document.form1.length;i++) {
                                if (document.form1.elements[i].value==""){
                                                           error=1;
                                                        pos = i+1;
                                                        break;
                         }

                        }

                                        if(error==1){

                                        alert("<?=LANG_eva_val_pregn?>"+pos);
                                        document.form1.elements[i].focus();

                                        }else{

                                                document.form1.submit();

                                        }


        }
        </script>


        <script language="JavaScript">
        <!--

         function popup(mylink, windowname,alto1,largo1)
         {
        var alto = alto1;
        var largo = largo1;
        var winleft = (screen.width - largo) / 2;
        var winUp = (screen.height - alto) / 2;


        if (! window.focus)return true;
          var href;
          if(typeof(mylink) == 'string')
                href=mylink;
          else
                href=mylink.href;
                window.open(href, windowname, 'top='+winUp+',left='+winleft+'+,toolbar=0 status=1,resizable=0,Width='+largo+',height='+alto+',scrollbars=1');

         return false;

        }

        //-->
        </script>



</head>

<body>

<form name="form1" method="post" action="guardap.php">

<table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="26" valign="top"> <span class="menu-title"><?= $menu->nombre; ?></span></td>
  </tr>
  <tr>
    <td><?php $menu->mostrar(1); ?></td>
  </tr>
  <tr>
    <td>

        <table style="border-right:#000000 solid 1px; border-left:#000000 solid 1px; border-bottom:#000000 solid 1px;" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
          <table width="100%" border="0" cellspacing="4" cellpadding="3">

                   <?php

                   for($i=0;$i<$_GET['preguntas'];$i++){

                   ?>

                    <tr>
              <td class="style3"><?php echo LANG_enum; echo ' '.$i+1; ?> </td>
            </tr>
            <tr>
              <td><textarea name="preg_<?=$i ?>" cols="92" rows="2" class="style1"></textarea></td>
            </tr>

                        <?php

                        }

                        ?>

                          <tr>
              <td>
                            <input name="b1" type="button" id="b1" onClick="location.replace('crear.php?volver=1');"  value="<?=LANG_back?>">
              <input name="b2" type="button" id="b2" onClick="javascript:validar();" value="<?=LANG_save?>">
              <span class="style1">
              <input type="button" name="Submit3" value="<?php echo LANG_eva_ver_detalles ?>" onClick="javascript:popup('detalles.php','new',450,616);">
              </span>                          </td>
            </tr>

          </table>


        </td>
      </tr>
    </table>        </td>
  </tr>
</table>

</form>

</body>
</html>
<?php

 $crear->cerrar();

?>