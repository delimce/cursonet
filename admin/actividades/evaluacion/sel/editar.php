<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../../config/setup.php"); ////////setup
include("../../../../class/clases.php"); ////////clase
include ("../../../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);

       
 $crear = new tools("db");
 
 
 if(isset($_POST['Submit'])){
 
 					
					    /////fecha
						$fecha2 = explode("/",$_POST['fecha']);
						if($_SESSION['DB_FORMATO']=="d/m/Y") $FECHA = $fecha2[2].'-'.$fecha2[1].'-'.$fecha2[0]; else $FECHA = $fecha2[2].'-'.$fecha2[0].'-'.$fecha2[1];
					   //////////
					   
					   /////fecha2
						$fecha3 = explode("/",$_POST['fecha2']);
						if($_SESSION['DB_FORMATO']=="d/m/Y") $FECHA2 = $fecha3[2].'-'.$fecha3[1].'-'.$fecha3[0]; else $FECHA = $fecha3[2].'-'.$fecha3[0].'-'.$fecha3[1];
					   //////////
							
		           $campos = explode(',',"nombre,contenido_id,grupo_id,fecha,fecha_fin,npreg,nivel");

				   $valores[0] = $_POST['nombre'];
				   $valores[1] = $_POST['caso'];
				   $valores[2] = $_POST['grupo'];
				   $valores[3] = $FECHA;
				   $valores[4] = $FECHA2.' 23:59'; ///para que sea todo el dia
				   $valores[5] = $_POST['preguntas'];
				   $valores[6] = $_POST['nivel'];

				  $crear->update("tbl_evaluacion",$campos,$valores,"id = '{$_SESSION['eval_id']}'");
 				  unset($_SESSION['eval_id']);
				  $crear->javaviso(LANG_cambios,"index.php");
				  
 
 }else{
 
 $_SESSION['eval_id'] = $_GET['ItemID'];
 
 }
 
 


 ///niveles de complejidad
 $nivel  = $crear->llenar_array(LANG_eva_level1.','.LANG_eva_level2.','.LANG_eva_level3.','.LANG_eva_level4);
 $nivelv = $crear->llenar_array('0,1,2,3');


  if(isset($_GET['ItemID'])){


 				$datos = $crear->simple_db("select nombre, contenido_id, grupo_id, date_format(fecha,'{$_SESSION['DB_FORMATO_DB']}') as fecha, date_format(fecha_fin,'{$_SESSION['DB_FORMATO_DB']}') as fecha2,
									  				npreg,nivel from tbl_evaluacion where id = '{$_GET['ItemID']}'");

  }



?>
<!DOCTYPE html>
<html>
<head> <meta charset="utf-8">
<script language="JavaScript" type="text/javascript" src="../../../../js/date.js"></script>
<link rel="stylesheet" type="text/css" href="../../../../css/style_back.css">

        <script language="JavaScript" type="text/javascript">


        function compara_fechas(desde,hasta){

        var formaty = '<?=str_replace("m", "M",strtolower($_SESSION['DB_FORMATO']));?>';

        return compareDates(desde,formaty,hasta,formaty);



        }



         function validar(){

         if(document.form1.nombre.value==''){

         alert('<?=LANG_eva_val_nombre ?>');
         document.form1.nombre.focus();

         return false;

         }


         if(document.form1.caso.value==''){

         alert('<?=LANG_content_create2 ?>');
         return false;

         }


         if(compara_fechas(document.form1.fecha.value,document.form1.fecha2.value)==1 || document.form1.fecha.value=="" || document.form1.fecha2.value==""){

         alert('<? echo LANG_eva_val_fecha2 ?>');
         document.form1.fecha.focus();

         return false;

         }


         if(isNaN(document.form1.preguntas.value) || document.form1.preguntas.value>100 || document.form1.preguntas.value<1 || document.form1.preguntas.value==''){
         alert('<?=LANG_eva_val_npreg ?>');
         document.form1.preguntas.focus();
         return false;

         }


         return true;

        }
		
		
		
		
        </script>



        <script type="text/javascript" src="../../../../js/calendario/calendar.js"></script>
        <script type="text/javascript" src="../../../../js/calendario/calendar-es.js"></script>
        <script type="text/javascript" src="../../../../js/calendario/calendar-setup.js"></script>
        <script type="text/javascript" src="../../../../js/popup.js"></script>
        <LINK href="../../../../js/calendario/calendario.css" type=text/css rel=stylesheet>


                <script type="text/javascript">


                        var weekdaystxt=["Sun", "Mon", "Tues", "Wed", "Thurs", "Fri", "Sat"]

                        function showLocalTime(container, servermode, offsetMinutes, displayversion){
                        if (!document.getElementById || !document.getElementById(container)) return
                        this.container=document.getElementById(container)
                        this.displayversion=displayversion
                        var servertimestring=(servermode=="server-php")? '<? print @date("F d, Y H:i:s", time())?>' : (servermode=="server-ssi")? '<!--#config timefmt="%B %d, %Y %H:%M:%S"--><!--#echo var="DATE_LOCAL" -->' : '<%= Now() %>'
                        this.localtime=this.serverdate=new Date(servertimestring)
                        this.localtime.setTime(this.serverdate.getTime()+offsetMinutes*60*1000) //add user offset to server time
                        this.updateTime()
                        this.updateContainer()
                        }

                        showLocalTime.prototype.updateTime=function(){
                        var thisobj=this
                        this.localtime.setSeconds(this.localtime.getSeconds()+1)
                        setTimeout(function(){thisobj.updateTime()}, 1000) //update time every second
                        }

                        showLocalTime.prototype.updateContainer=function(){
                        var thisobj=this
                        if (this.displayversion=="long")
                        this.container.innerHTML=this.localtime.toLocaleString()
                        else{
                        var hour=this.localtime.getHours()
                        var minutes=this.localtime.getMinutes()
                        var seconds=this.localtime.getSeconds()
                        var ampm=(hour>=12)? "PM" : "AM"
                        var dayofweek=weekdaystxt[this.localtime.getDay()]
                        this.container.innerHTML=formatField(hour, 1)+":"+formatField(minutes)+":"+formatField(seconds)+" "+ampm
                        }
                        setTimeout(function(){thisobj.updateContainer()}, 1000) //update container every second
                        }

                        function formatField(num, isHour){
                        if (typeof isHour!="undefined"){ //if this is the hour field
                        var hour=(num>12)? num-12 : num
                        return (hour==0)? 12 : hour
                        }
                        return (num<=9)? "0"+num : num//if this is minute or sec field
                        }

        </script>


</head>

<body>
<table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="26" valign="top"><?php echo $menu->nombre; ?></td>
  </tr>
  <tr>
    <td><?php $menu->mostrar(0); ?></td>
  </tr>
  <tr>
    <td>

        <table style="border-right:#000000 solid 1px; border-left:#000000 solid 1px; border-bottom:#000000 solid 1px;" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><form name="form1" method="post" action="editar.php" onSubmit="return validar();">
  <table width="100%" border="0" cellspacing="4" cellpadding="3">
  <tr>
  <td colspan="3">&nbsp;</td>
</tr>
  <tr>
    <td class="style3"><?php echo LANG_eva_name; ?></td>
    <td width="72%" colspan="2"><input name="nombre" type="text" id="nombre" value="<?=$datos['nombre']?>" size="45"></td>
  </tr>
  <tr>
  <td width="28%" class="style3"><?php echo LANG_content_name; ?></td>
  <td colspan="2"><? echo $crear->combo_db("caso","select id,titulo from tbl_contenido where curso_id = {$_SESSION['CURSOID']} and borrador = 0","titulo","id",LANG_select,$datos['contenido_id'],false,'<input name="caso" type="hidden" value="">'.LANG_content_theme); ?></td>
 </tr>
   <tr>
    <td class="style3"><?php echo LANG_group_nombre; ?></td>
  <td colspan="2">
    <? echo $crear->combo_db("grupo","select id, nombre from tbl_grupo where curso_id = {$_SESSION['CURSOID']}","nombre","id",LANG_all,$datos['grupo_id'],false,'<input name="grupo" type="hidden" value="">'); ?> </td>
</tr>
  <tr>
  <td class="style3">&nbsp;</td>
  <td colspan="2">
  
  		<span class="style3">
    			<?=LANG_hour_act?>
  		</span>

        <span id="timecontainer"></span>

        <script type="text/javascript">
        new showLocalTime("timecontainer", "server-php", 0, "short")
        </script> 
  
  </td>
</tr>
  <tr>
    <td class="style3"><?php echo LANG_eva_fechae; ?></td>
    <td colspan="2"><input name="fecha" type="text" id="fecha" OnFocus="this.blur()" onClick="alert('<?=LANG_calendar_use?>')" value="<?=$datos['fecha']?>" size="12">
      <img src="../../../../images/frontend/cal.gif" name="f_trigger_d" width="16" height="16" id="f_trigger_d" style="cursor: hand; border: 0px;" title="<?=LANG_calendar?>">
      <script type="text/javascript">
                                        Calendar.setup({
                                                inputField     :    "fecha",     // id of the input field
                                                ifFormat       :    "<?=strtolower($_SESSION['DB_FORMATO'])?>",    // format of the input field
                                                button         :    "f_trigger_d",  // trigger for the calendar (button ID)
                                                singleClick    :    true
                                        });
                                </script></td>
  </tr>
  <tr>
    <td class="style3"><?php echo LANG_eva_fechaf; ?></td>
    <td colspan="2"><input name="fecha2" type="text" id="fecha2" OnFocus="this.blur()" onClick="alert('<?=LANG_calendar_use?>')" value="<?=$datos['fecha2']?>" size="12">
      <img src="../../../../images/frontend/cal.gif" name="f_trigger_d2" width="16" height="16" id="f_trigger_d2" style="cursor: hand; border: 0px;" title="<?=LANG_calendar?>">
      <script type="text/javascript">
                                        Calendar.setup({
                                                inputField     :    "fecha2",     // id of the input field
                                                ifFormat       :    "<?=strtolower($_SESSION['DB_FORMATO'])?>",    // format of the input field
                                                button         :    "f_trigger_d2",  // trigger for the calendar (button ID)
                                                singleClick    :    true
                                        });
                                </script></td>
  </tr>
  
  <tr>
    <td class="style3"><?php echo LANG_eva_npreg; ?></td>
    <td colspan="2"><input name="preguntas" type="text" id="preguntas" value="<?=$datos['npreg']?>" size="5" maxlength="3"></td>
  </tr>
  <tr>
    <td class="style3"><?php echo LANG_eva_level; ?></td>
    <td colspan="2"><?php     echo $crear->combo_array ("nivel",$nivel,$nivelv,false,$datos['nivel']); ?>&nbsp;</td>
  </tr>
  <tr>
    <td class="style3">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
  <td colspan="3"><input type="button" name="Submit2" onClick="history.back();" value="<?=LANG_cancel?>">
  <input type="submit" name="Submit" value="<?=LANG_edit?>"></td>
  </tr>
</table>
</form></td>
      </tr>
    </table>        </td>
  </tr>
</table>
</body>
</html>
<?php

 $crear->cerrar();

?>