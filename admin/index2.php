<?php
session_start();
$profile = 'admin'; /////////////// perfil requerido
include("../config/setup.php"); ////////setup
include("../class/clases.php");
include ("../config/lang/{$_SESSION['LENGUAJE']}"); ////lenguaje
$datos = new tools('db');
$data = $datos->array_query2("select signature,formato_fecha,formato_fecha_db,titulo_admin,(SELECT alias from tbl_curso WHERE id = '{$_SESSION['CURSOID']}'),version,timezone from tbl_setup");


$_SESSION['DB_FORMATO_DB'] = $data[2];
$_SESSION['DB_FORMATO'] = $data[1];
$_SESSION['CURSOALIAS'] = $data[4];
$_SESSION['TIMEZONE'] = $data[6]; ///zona horaria configurada en la herramienta
?>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo $data[3] . ' ' . $data[5]; ?></title>
        <link rel="stylesheet" type="text/css" href="../css/style_back.css">
        <script type="text/javascript" language="JavaScript1.2" src="../js/stm31.js"></script>
        <script type="text/javascript" src="../js/iframe.js"></script>

        <script language="JavaScript" type="text/javascript">
		
            function nocaso(){
                var answer = confirm("<?= LANG_curso_nocreated ?>");
                if (answer){
				
                    content.location.replace('settings/crearc.php');
					
                }
		
            }
        </script>

    </head>
    <body bgcolor="#858585" bottommargin="0" <? if ($_SESSION['CURSOID'] < 1) { ?>onLoad="nocaso();" <? } ?>>
        <table width="1000" height="550" border="0" align="center" cellpadding="0" cellspacing="0" valign="top">

            <tr>
                <td width="369"><img src="../images/backend/spacer.gif" width="369" height="1" border="0" alt=""></td>
                <td width="239"><img src="../images/backend/spacer.gif" width="189" height="1" border="0" alt=""></td>
                <td width="35"><img src="../images/backend/spacer.gif" width="35" height="1" border="0" alt=""></td>
                <td width="157"><img src="../images/backend/spacer.gif" width="157" height="1" border="0" alt=""></td>
                <td width="1"><img src="../images/backend/spacer.gif" width="1" height="1" border="0" alt=""></td>
            </tr>

            <tr>
                <td height="29" align="right" class="topbar"><span class="style3"><?= LANG_curso_selected ?></span>

                    <?php
                    if ($_SESSION['ADMIN'] == 1) {

                        echo $datos->combo_db("curso", "select id,alias from tbl_curso", "alias", "id", false, $_SESSION['CURSOID'], "content.location.replace('main.php?curso='+this.value)", LANG_curso_nocurso);
                    } else {

                        echo $datos->combo_db("curso", "select id,alias from tbl_curso where id in ({$_SESSION['CURSOSP']})", "alias", "id", false, $_SESSION['CURSOID'], "content.location.replace('main.php?curso='+this.value)", LANG_curso_nocurso);
                    }
                    ?>    </td>
                <td colspan="3" bgcolor="#000000">
                    <!-- Content Code for the top right black box goes here. -->   <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="90%" align="right"><span class="small" style="color:#FFFFFF">&nbsp;<b><?= $_SESSION['NOMBRE'] ?></b>&nbsp;
                                    <?php if ($_SESSION['FECHACC'] != "") { ?><?=LANG_last_access?>&nbsp;<b><?= $_SESSION['FECHACC'] ?><?php } ?></b>
                                    &nbsp;|&nbsp;</span></td>
                            <td width="6%" align="right" class="style2"><a href="cerrar.php" style="color:#FFFFFF; display:compact;"><?php echo LANG_ADMIN_cerrar; ?></a></td>
                            <td width="4%" align="center"><img title="<?php echo LANG_ADMIN_cerrar; ?>" src="../images/backend/cerrar.gif" width="12" height="12" border="0"></td>
                        </tr>
                    </table></td>
                <td><img src="../images/backend/spacer.gif" width="1" height="29" border="0" alt=""></td>
            </tr>
            <tr>
                <td colspan="4"></td>
                <td></td>
            </tr>
            <tr>
                <td height="40" colspan="4" valign="bottom" bgcolor="#7A98AD"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="75%" height="40" align="left"><img src="../images/backend/head_01.jpg" width="600" height="40"></td>
                            <td width="25%" align="right" valign="bottom"><a href="main.php" target="content" title="<?= LANG_mainback ?>"><img src="../images/backend/edunet_r6_c5.gif" width="140" height="40" border="0"></a></td>
                        </tr>
                    </table></td>
                <td><img src="../images/backend/spacer.gif" width="1" height="40" border="0" alt=""></td>
            </tr>
            <tr>
                <td height="19" colspan="2" bgcolor="#F1F2EE">

<script type="text/javascript">
<!--
stm_bm(["menu79ba",900,"","blank.gif",0,"","",0,0,0,0,0,1,0,0,"","",0,0,1,1,"default","hand","",1,25],this);
stm_bp("p0",[0,4,0,0,3,4,0,7,100,"",-2,"",-2,90,0,0,"#000000","#F1F2EE","",3,0,0,"#000000"]);
stm_ai("p0i0",[0,"Actividades","","",-1,-1,0,"","_self","","","","",0,0,0,"arrow_r.gif","arrow_r.gif",7,7,0,0,1,"#F1F2EE",0,"#AABDCA",0,"","",3,3,0,0,"#FFFFF7","#000000","#000000","#000000","7pt Verdana","7pt Verdana",0,0,"","","","",0,0,0]);
stm_bpx("p1","p0",[1,4,0,0,3,4,0,7,100,"",-2,"",-2,90,0,0,"#000000","#F1F2EE","",3,5,1]);
stm_aix("p1i0","p0i0",[0,"Examen","","",-1,-1,0,"","content"]);
stm_bpx("p2","p1",[1,2,0,0,3,4,0,0]);
stm_aix("p2i0","p0i0",[0,"Selección","","",-1,-1,0,"actividades/evaluacion/sel/index.php","content","","","","",0,0,0,"","",0,0]);
stm_aix("p2i1","p2i0",[0,"Desarrollo","","",-1,-1,0,"actividades/evaluacion/des/index.php"]);
stm_ep();
stm_aix("p1i1","p2i0",[0,"Proyectos","","",-1,-1,0,"actividades/proy/index.php"]);
stm_aix("p1i2","p2i0",[0,"Foros","","",-1,-1,0,"actividades/foro/index.php"]);
stm_ep();
stm_ai("p0i1",[6,1,"#000000","",0,0,0]);
stm_aix("p0i2","p0i0",[0,"Gestión"]);
stm_bpx("p3","p1",[1,4,0,0,3,4,0,7,100,"",-2,"",-2,90,0,0,"#000000","#F1F2EE","",3,1]);
stm_aix("p3i0","p2i0",[0,"Temas","","",-1,-1,0,"contenidos/index.php","content","","Temas del curso"]);
stm_aix("p3i1","p0i0",[0,"Grupos","","",-1,-1,0,"grupos/index.php","content","","Grupos de estudiantes"]);
stm_bpx("p4","p2",[]);
stm_aix("p4i0","p2i0",[0,"Equipos","","",-1,-1,0,"equipos/index.php","content","","Equipos de estudiantes para actividades"]);
stm_ep();
stm_aix("p3i2","p2i0",[0,"Recursos","","",-1,-1,0,"recursos/index.php","content","","Recursos del curso"]);
stm_aix("p3i3","p2i0",[0,"Planes","","",-1,-1,0,"planes/index.php","content","","Planes evaluados"]);
stm_aix("p3i4","p2i0",[0,"Cartelera","","",-1,-1,0,"wall/index.php","content","","Cartelera de Mensajes"]);
stm_ep();
stm_aix("p0i3","p0i1",[]);
stm_aix("p0i4","p0i0",[0,"Evaluación"]);
stm_bpx("p5","p3",[1,4,0,0,3,4,0,0]);
stm_aix("p5i0","p2i0",[0,"Proyectos","","",-1,-1,0,"post/proy/index.php"]);
stm_aix("p5i1","p2i0",[0,"Foro","","",-1,-1,0,"post/foro/index.php"]);
stm_aix("p5i2","p2i0",[0,"Pruebas","","",-1,-1,0,"post/evaluacion/index.php"]);
stm_ep();
stm_aix("p0i5","p0i1",[]);
stm_aix("p0i6","p0i0",[0,"Seguimiento"]);
stm_bpx("p6","p5",[]);
stm_aix("p6i0","p2i0",[0,"Pruebas","","",-1,-1,0,"seguir/evaluacion/index.php"]);
stm_aix("p6i1","p2i0",[0,"Proyectos","","",-1,-1,0,"seguir/proy/index.php"]);
stm_aix("p6i2","p2i0",[0,"Foro","","",-1,-1,0,"seguir/foro/index.php"]);
stm_ep();
stm_aix("p0i7","p0i1",[]);
stm_aix("p0i8","p0i0",[0,"Aseroramiento"]);
stm_bpx("p7","p5",[]);
stm_aix("p7i0","p2i0",[0,"Pruebas","","",-1,-1,0,"acomp/evaluacion/index.php"]);
stm_aix("p7i1","p2i0",[0,"Foro","","",-1,-1,0,"acomp/foro/index.php"]);
stm_aix("p7i2","p2i0",[0,"Proyectos","","",-1,-1,0,"acomp/proy/index.php"]);
stm_aix("p7i3","p2i0",[0,"Mensajes personalizados","","",-1,-1,0,"mensajes/index.php"]);
stm_ep();
stm_aix("p0i9","p0i1",[]);
stm_aix("p0i10","p0i0",[0,"Ayuda"]);
stm_bpx("p8","p5",[]);
stm_aix("p8i0","p2i0",[0,"Temas de ayuda","","",-1,-1,0,"ayuda/index.php"]);
stm_aix("p8i1","p2i0",[0,"A cerca de","","",-1,-1,0,"ayuda/about.php"]);
stm_ep();
stm_ep();
stm_em();
//-->
</script>





                </td>
                <td colspan="2" align="right" valign="top" bgcolor="#F1F2EE"><img src="../images/backend/edunet_r4_c3.gif" width="192" height="19"></td>
                <td><img src="../images/backend/spacer.gif" width="1" height="19" border="0" alt=""></td>
            </tr>
            <tr>
                <td height="16" colspan="4" align="right" bgcolor="#FFFFFF"><img src="../images/backend/edunet_r5_c1.gif" width="800" height="16"></td>
                <td><img src="../images/backend/spacer.gif" width="1" height="16" border="0" alt=""></td>
            </tr>
            <tr>
                <td colspan="3" valign="top" background="../images/backend/edunet_r6_c1.gif">
                    <!-- Code for Main Body Content Goes Here -->

                    <iframe  name="content" id="content" width="99%"  scrolling="NO" frameborder="0" onLoad="changeHeight(this);" src="main.php" width="99%"></iframe>


                </td>
                <td class="sitebar" valign="top" align="center">
                    <table width="94%" border="0" align="center" cellpadding="0" cellspacing="2">
                        <tr>
                            <td width="75%" align="right">&nbsp;</td>
                            <td width="25%" align="right">&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="right">
                                <a href="micuenta/index.php" target="content"><?php echo LANG_account; ?></a>
                            </td>
                            <td align="right"><img src="../images/backend/account.gif" width="32" height="32"></td>
                        </tr>

                        <tr>
                            <td align="right" valign="middle"><span class="style1"><a href="alumnos/index.php" target="content"><div id="nestudents"><?php echo LANG_students; ?> (<span id="nest">&nbsp;</span>)</div></a></span></td>
                            <td align="right"><img src="../images/backend/Users.gif" width="32" height="32"></td>
                        </tr>

                        <tr>
                            <td align="right"><a href="mensajes/index.php" target="content"><div id="nmessages" style="line-height:inherit"><?php echo LANG_messages; ?> (<span id="nmsgs">&nbsp;</span>)</div></a></td>
                            <td align="right"><img src="../images/backend/mens.gif" width="32" height="32"></td>
                        </tr>
                        <tr>
                            <td align="right"><a href="recursos/index.php" target="content"><div id="nrecs" style="line-height:inherit"><?php echo LANG_resources; ?> (<span id="nrecus">&nbsp;</span>)</div></a></td>
                            <td align="right"><img src="../images/backend/Recs.png" width="32" height="32"></td>
                        </tr>
                        <tr>
                            <td align="right" class="style1"><span class="style1"><a href="estadisticas/index.php" target="content"><?php echo LANG_estat; ?></a></td>
                            <td align="right"><img src="../images/backend/estad.gif" width="32" height="32"></td>
                        </tr>


                        <?php
                        if ($_SESSION['ADMIN'] == 1) {
                            ?>
                            <tr>
                                <td align="right"><span class="style1"><a href="settings/index.php" target="content"><?php echo LANG_ADMIN_admin; ?></a></span></td>
                                <td align="right"><img src="../images/backend/amini.gif" width="32" height="32"></td>
                            </tr>
                            <?php
                        }
                        ?>


                    </table>
                </td>
                <td><img src="../images/backend/spacer.gif" width="1" height="368" border="0" alt=""></td>
            </tr>
            <tr>
                <td height="20" colspan="5" valign="middle" bgcolor="#000000" class="style2"><?php echo $data[0]; ?></td>
            </tr>
        </table>
        <br>
    </body>
</html>
<?php $datos->cerrar(); ?>