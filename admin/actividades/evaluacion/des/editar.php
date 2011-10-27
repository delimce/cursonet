<?php session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../../../config/setup.php"); ////////setup
include("../../../../class/clases.php"); ////////clase
include ("../../../../config/lang/{$_SESSION['LENGUAJE']}");////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);


 $crear = new tools("db");
 

 if(isset($_GET['ItemID'])){


    $_SESSION['eval_id'] = $_GET['ItemID'];

 	$datos = $crear->array_query2("select nombre, contenido_id, grupo_id, date_format(fecha,'{$_SESSION['DB_FORMATO_DB']}') as fecha, date_format(fecha_fin,'{$_SESSION['DB_FORMATO_DB']}') as fecha2,
											npreg as preg from tbl_evaluacion where id = '{$_SESSION['eval_id']}'");

 	$_SESSION['eva_nombre']    = $datos[0];
	$_SESSION['eva_caso']      = $datos[1];
	$_SESSION['eva_seccion']   = $datos[2];
	$_SESSION['eva_fecha']     = $datos[3];
	$_SESSION['eva_fecha2']    = $datos[4];
	$_SESSION['eva_preg']      = $datos[5];
	
 }



?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../../../../css/style_back.css">
<script language="JavaScript" type="text/javascript" src="../../../../js/date.js"></script>
<script language="JavaScript" type="text/javascript" src="../../../../js/ajax.js"></script>

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

			/***********************************************
			* Local Time script- © Dynamic Drive (http://www.dynamicdrive.com)
			* This notice MUST stay intact for legal use
			* Visit http://www.dynamicdrive.com/ for this script and 100s more.
			***********************************************/

			var weekdaystxt=["Sun", "Mon", "Tues", "Wed", "Thurs", "Fri", "Sat"]

			function showLocalTime(container, servermode, offsetMinutes, displayversion){
			if (!document.getElementById || !document.getElementById(container)) return
			this.container=document.getElementById(container)
			this.displayversion=displayversion
			var servertimestring=(servermode=="server-php")? '<? print date("F d, Y H:i:s", time())?>' : (servermode=="server-ssi")? '<!--#config timefmt="%B %d, %Y %H:%M:%S"--><!--#echo var="DATE_LOCAL" -->' : '<%= Now() %>'
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
        <td><form name="form1" method="get" action="edit_preg.php" onSubmit="return validar();">
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
  <td colspan="2"><? echo $crear->combo_db("caso","select id,titulo from tbl_contenido where borrador = 0","titulo","id",false,$_SESSION['eva_caso'],"ajaxcombo('grupox','seccion','../../../grupos/gruposc.php?ide='+this.value,'seccion','nombre','valor');"); ?></td>
</tr>
  <tr>
  <td class="style3"><?php echo LANG_group_nombre; ?></td>
  <td colspan="2">
  <div id="grupox">
  	<?php echo $crear->combo_db("seccion","select id, nombre from tbl_grupo where curso_id = {$_SESSION['CURSOID']} ","nombre","id",LANG_all,$_SESSION['eva_seccion']); ?>

  	</div>
  </td>
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
    <td colspan="2"><input name="fecha" type="text" id="fecha" OnFocus="this.blur()" onClick="alert('<?=LANG_calendar_use?>')" value="<?=$_SESSION['eva_fecha']?>" size="12">
      <img src="../../../../images/frontend/cal.gif" name="f_trigger_d" width="16" height="16" id="f_trigger_d" style="cursor: hand; border: 0px;" title="<?=LANG_calendar?>">
      <script type="text/javascript">
					Calendar.setup({
						inputField     :    "fecha",     // id of the input field
						ifFormat       :    "<?=strtolower("d/m/Y")?>",    // format of the input field
						button         :    "f_trigger_d",  // trigger for the calendar (button ID)
						singleClick    :    true
					});
				</script></td>
  </tr>
  <tr>
    <td class="style3"><?php echo LANG_eva_fechaf; ?></td>
    <td colspan="2"><input name="fecha2" type="text" id="fecha2" OnFocus="this.blur()" onClick="alert('<?=LANG_calendar_use?>')" value="<?=$_SESSION['eva_fecha2']?>" size="12">
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
  <td colspan="3">
   <input name="b1" type="button" id="b1" onClick="location.replace('index.php');"  value="<?=LANG_back?>">
  <input type="submit" name="Submit" value="<?=LANG_next?>"></td>
  </tr>
</table>
</form></td>
      </tr>
    </table>	</td>
  </tr>
</table>
</body>
</html>
<?php

 $crear->cerrar();

?>