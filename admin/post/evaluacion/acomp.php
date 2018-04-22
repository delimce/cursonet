<?php

$datoseval = $prueba->simple_db("SELECT
                                        ee.est_id,
                                        ee.eval_id,
                                        ee.nota,
                                        pi.en_base
                                        FROM
                                        tbl_evaluacion_estudiante AS ee
                                        INNER JOIN tbl_plan_item AS pi ON ee.eval_id = pi.id_act AND pi.tipo = 'prueba'
                                        WHERE ee.id = {$_SESSION['EVAL_REV']}");

if ($prueba->nreg > 0) {


    if ($_POST['nota'] <= round($datoseval["en_base"]/2)) { ///nota min

        $mens = "Ud debe estudiar mas para la próxima actividad";

    } else { /////nota max

        $mens = "Buen trabajo en el examen";

    } ////decide el mensaje


    ///////////mandando mensaje

    $datosmens[0] = '1';
    $datosmens[1] = $_SESSION['USERID'];
    $datosmens[2] = $datoseval["est_id"];
    $datosmens[3] = LANG_accomp_titulomenspru;
    $datosmens[4] = $mens;
    $datosmens[5] = date('Y-m-d H:i:s');

    $prueba->insertar2("tbl_mensaje_est", "tipo,de,para,subject,content,fecha", $datosmens, true);

    //////////////////////////


}

?>