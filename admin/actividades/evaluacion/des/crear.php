<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../../config/setup.php"); ////////setup
include("../../../../class/tools.php"); ////////clase
include ("../../../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);

        if(!isset($_GET['volver'])) {

              unset($_SESSION['eva_seccion']);
              unset($_SESSION['eva_caso']);
              unset($_SESSION['eva_nombre']);
              unset($_SESSION['eva_preg']);
              unset($_SESSION['eva_fecha']);
			  unset($_SESSION['eva_fecha2']);
              unset($_SESSION['eval_id']);

        }
		

 $crear = new tools();
 $crear->autoconexion();
 
 $horario = $crear->simple_db("select timezone from tbl_setup ");
 // @date_default_timezone_set($horario);



?>
<html>
<head>
<script language="JavaScript" type="text/javascript" src="../../../../js/date.js"></script>
<script language="JavaScript" type="text/javascript" src="../../../../js/ajax.js"></script>
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
    <td><?php $menu->mostrar(1); ?></td>
  </tr>
  <tr>
    <td>

        <table style="border-right:#000000 solid 1px; border-left:#000000 solid 1px; border-bottom:#000000 solid 1px;" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><form name="form1" method="get" action="crear_preg.php" onSubmit="return validar();">
  <table width="100%" border="0" cellspacing="4" cellpadding="3">
  <tr>
  <td colspan="3">&nbsp;</td>
</tr>
  <tr>
    <td class="style3"><?php echo LANG_eva_name; ?></td>
    <td width="72%" colspan="2"><input name="nombre" type="text" id="nombre" value="<?=$_SESSION['eva_nombre'] ?>" size="45"></td>
  </tr>
  <tr>
  <td width="28%" class="style3"><?php echo LANG_content_name; ?></td>
  <td colspan="2"><? echo $crear->combo_db("caso","select id,titulo from contenido where curso_id = {$_SESSION['CURSOID']} and borrador = 0","titulo","id",LANG_select,$_SESSION['eva_caso'],"ajaxcombo('grupox','seccion','../../../grupos/gruposc.php?ide='+this.value,'seccion','nombre','valor');",'<input name="caso" type="hidden" value="">'.LANG_content_theme); ?></td>
 </tr>
   <tr>
    <td class="style3"><?php echo LANG_group_nombre; ?></td>
  <td colspan="2">
     <div id="grupox">

      <?php if($_SESSION['eva_caso']==""){ echo LANG_group_casoseccion; }else{ echo $crear->combo_db("seccion","select id, nombre from grupo where curso_id = {$_SESSION['CURSOID']}","nombre","id",LANG_all,$_SESSION['eva_seccion'],false,LANG_all.'<input name="seccion" type="hidden" value="0">'); } ?>
     </div>


  </td>
</tr>
  <tr>
  <td class="style3">&nbsp;</td>
  <td colspan="2">&nbsp;</td>
</tr>
  <tr>
    <td class="style3"><?php echo LANG_eva_fechae; ?></td>
    <td colspan="2"><input name="fecha" type="text" id="fecha" OnFocus="this.blur()" onClick="alert('<?=LANG_calendar_use?>')" value="<? if($_SESSION['eva_fecha']=='') echo date($_SESSION['DB_FORMATO']); else echo $_SESSION['eva_fecha'];  ?>" size="12">
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
    <td colspan="2"><input name="fecha2" type="text" id="fecha2" OnFocus="this.blur()" onClick="alert('<?=LANG_calendar_use?>')" value="<? if($_SESSION['eva_fecha']=='') echo date($_SESSION['DB_FORMATO']); else echo $_SESSION['eva_fecha2'];  ?>" size="12">
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
    <td colspan="2"><input name="preguntas" type="text" id="preguntas" value="<?=$_SESSION['eva_preg'] ?>" size="5" maxlength="3"></td>
  </tr>
  <tr>
  <td colspan="3"><input type="submit" name="Submit" value="<?=LANG_next?>"></td>
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