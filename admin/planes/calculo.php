<?php 


switch ($iteninfo[$i]['tipo']) {

				case 'proy':
				 				   
				    $nota = $toolitem->simple_db("select round(nota,2) from tbl_proyecto_estudiante where est_id = {$est['id']} and proy_id = {$iteninfo[$i]['id_act']} ");
				   
				   break;
				case 'foro':
				   
				  $nota = $toolitem->simple_db("select round(nota,2) from tbl_foro_estudiante where est_id = {$est['id']} and foro_id = {$iteninfo[$i]['id_act']} ");
				 
				   
				   break;
				case 'eval':
				///////////////// calculo de las evaluaciones
				  $nota = $toolitem->simple_db("select round(nota,2) from tbl_evaluacion_estudiante where est_id = {$est['id']} and eval_id = {$iteninfo[$i]['id_act']} ");
				
				
				   break;
				  
				  default:
				  
				  $nota = $toolitem->simple_db("select round(nota,2) from tbl_plan_estudiante where est_id = {$est['id']} and item_id = {$iteninfo[$i]['id']} ");
				
			}
			
				  if($nota<0) $nota=0; ///si no se ha corregido	  
			  	  $calc = bcdiv(($nota*$iteninfo[$i]['porcentaje']),$iteninfo[$i]['en_base'],1);
				  $ptotal+=$calc;
				  $calc.='%'; 
				  if($nota>=($iteninfo[$i]['en_base']/2)) $color = "#000066"; else $color = "#990000";
			      



?>
