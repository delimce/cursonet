<?php


	$datoseval = $prueba->array_query2("select est_id,proy_id from tbl_proyecto_estudiante where id = '{$_SESSION['PRO_ID2']}' ");

	$adata = $prueba->array_query2("select nota_min, coment_min, nota_max, coment_max from acomp where tipo = 'proy' and  act_id = $datoseval[1] ");

	if($prueba->nreg>0){


			if($_POST['nota']<=$adata[0]){ ///nota min

					$mens = $adata[1];

			}else if($_POST['nota']>=$adata[2]){ /////nota max

					$mens = $adata[3];

			} ////decide el mensaje

			///////////mandando mensaje

			$datosmens[0] = '1';
			$datosmens[1] = $_SESSION['USERID'];
			$datosmens[2] = $datoseval[0];
			$datosmens[3] = LANG_accomp_titulomensproy;
			$datosmens[4] = $mens;
			$datosmens[5] = date('Y-m-d H:i:s');

			$prueba->insertar2("tbl_mensaje_est","tipo,de,para,subject,content,fecha",$datosmens,true);


			//////////////////////////


	}

?>