<?php
session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../../config/setup.php"); ////////setup
include("../../class/clases.php"); ////////clase
include ("../../config/lang/{$_SESSION['LENGUAJE']}"); ////lenguaje

require_once("menu.php"); ////////menu
$menu = new menu($menu_struct);
include("security.php"); ///seguridad para el admin

$modo = new tools("db");

date_default_timezone_set($_SESSION['TIMEZONE']);

$conn = mysqli_connect($HOSTNAME, $DBUSER, $DBPASS);

function admin_usersonline() {
    $sessionfiles = session_save_path() . "/sess_*";
    $usersonline = count(glob($sessionfiles));
    return $usersonline;
}
?>
<html>
    <head> <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="../../css/style_back.css">


        <script type="text/javascript">

            /***********************************************
             * Local Time script- � Dynamic Drive (http://www.dynamicdrive.com)
             * This notice MUST stay intact for legal use
             * Visit http://www.dynamicdrive.com/ for this script and 100s more.
                             ***********************************************/

                             var weekdaystxt = ["Sun", "Mon", "Tues", "Wed", "Thurs", "Fri", "Sat"]

                             function showLocalTime(container, servermode, offsetMinutes, displayversion){
                            if (!document.getElementById || !document.getElementById(container)) return
                            this.container = document.getElementById(container)
                                    this.displ a yversion = displayversion
                                    var servertimestring = (se r vermode ==  "s erver-php")? '<? print date("F d, Y H:i:s", time()) ?>' : (servermode = =  "server-ssi")? '<!--#config timefmt="%B %d, %Y %H:%M:%S"--><!--#echo var="DATE_LOCAL" -->' : '<%= Now() %>'
                                                                this.localtime = this.serverdate = new Date(servertimestring)
                                                                this.localtime.setTime(this.serverdate.getTime() + offsetMinutes * 60 * 1000) //add user offset to server time
                                                                this.updateTime()
                                                                this.updateContainer()
                                                        }

                                                showLocalTime.prototype.updateTime = function(){
                                                var thisobj = this
                                                        this.localtime.setSeconds(this.localtime.getSeconds() + 1)
                                                        setTimeout(function(){thisobj.updateTime()}, 1000) //update time every second
                                                }

                                                showLocalTime.prototype.updateContainer = function(){
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
                <td><?php $menu->mostrar(4); ?></td>
            </tr>
            <tr>
                <td>

                    <table style="border-right:#000000 solid 1px; border-left:#000000 solid 1px; border-bottom:#000000 solid 1px;" width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td>
                                <table width="99%" border="0" align="center" cellpadding="3" cellspacing="3">
                                    <tr>
                                        <td colspan="2" class="style1"><?php echo LANG_config_system ?>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="table_bk"><?php echo LANG_config_system_server ?></td>
                                    </tr>
                                    <tr>
                                        <td width="27%" valign="top" class="style3"><b>
<?= LANG_config_system_server_name ?>
                                            </b></td>
                                        <td width="73%" class="style1">
<? echo $_SERVER['SERVER_NAME'];
echo ' ';
echo $_SERVER['SERVER_ADDR']; ?>		  </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" class="style3">
                                            <?= LANG_config_system_server_sw ?>
                                        </td>
                                        <td><span class="style1">
                                                <?= $_SERVER['SERVER_SOFTWARE'] ?>
                                            </span></td>
                                    </tr>
                                    <tr>
                                        <td valign="top" class="style3"><b>
                                                <?= LANG_config_system_server_dir ?>
                                            </b></td>
                                        <td class="style1">
                                            <?= $_SERVER['DOCUMENT_ROOT'] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" class="style3"><b>
                                                <?= LANG_config_system_server_port ?>
                                            </b></td>
                                        <td class="style1">
                                            <?= $_SERVER['SERVER_PORT'] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" class="style3"><b>
                                                <?= LANG_config_system_server_php ?>
                                            </b></td>
                                        <td class="style1"><a href="php.php" target="_blank" class="style3">phpinfo()</a></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" valign="top" class="table_bk"><?php echo LANG_config_system_db ?></td>
                                    </tr>
                                    <tr>
                                        <td valign="top" class="style3"><b><b>
                                                    <?= LANG_config_system_server_name ?>
                                                </b></b></td>
                                        <td class="style1"><?= mysql_get_host_info(); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" class="style3"><b>
                                                <?= LANG_config_system_db_ver ?>
                                            </b></td>
                                        <td class="style1">
                                            <?= mysql_get_server_info(); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" class="style3"><b>
                                                <?= LANG_config_system_db_estatus ?>
                                            </b></td>
                                        <td class="style1">
                                            <?
                                            if (mysql_ping($conn))
                                                echo LANG_config_system_db_estatusc;
                                            else
                                                echo LANG_config_system_db_estatusn;

                                            mysql_close($conn);
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" valign="top" class="table_bk"><?php echo LANG_config_system_global ?></td>
                                    </tr>
                                    <tr>
                                        <td valign="top" class="style3">
                                            <?= LANG_config_system_date ?>
                                        </td>
                                        <td valign="top" class="style1">
                                            <?php
                                                    
                                                    echo date("F j, Y");
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" class="style3">
                                            <?= LANG_config_system_time ?>
                                        </td>
                                        <td valign="top" class="style1">

                                            <span id="timecontainer"></span>

                                            <script type="text/javascript">
                                                                                            new showLocalTime("timecontainer", "server-php", 0, "short")
                                            </script>


                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" class="style3">
                                            <?= LANG_config_system_cadmin ?>
                                        </td>
                                        <td valign="top" class="style1"><? echo admin_usersonline(); ?> </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" class="style3">
                                            <?= LANG_config_system_cusers ?>
                                        </td>
                                        <td valign="top" class="style1">&nbsp;</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>	</td>
            </tr>
        </table>
    </body>
</html>
<?php
?>
