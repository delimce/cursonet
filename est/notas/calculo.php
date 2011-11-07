<?php 


switch ($iteninfo[$i]['tipo']) {

				case 'proy':
				   
				   
				  $tool->query("select id from tbl_proyecto_estudiante where est_id = {$_SESSION['USER']} and proy_id = {$iteninfo[$i]['id_act']} ") ;
				  if($tool->nreg>0){
				  		 
							 $data = $tool->simple_db("select round(nota,2) as nota,correccion from tbl_proyecto_estudiante where est_id = {$_SESSION['USER']} and proy_id = {$iteninfo[$i]['id_act']} ");
				   			 $corregido = 'SI';	
							 $nota = $data['nota'];	
							 $com = $data['correccion'];
							 if($nota<0){ $nota=0; $corregido = 'NO'; }///si no se ha corregido	  
				    }else{
					
							 $nota = 0;
							 $corregido = 'NO';
				  }
				   
				   
				   
				   break;
			
			
				case 'foro':
				   
				  $tool->query("select id from tbl_foro_estudiante where est_id = {$_SESSION['USER']} and foro_id = {$iteninfo[$i]['id_act']} ") ;
				  if($tool->nreg>0){
				  		 
							 $data = $tool->simple_db("select round(nota,2) as nota,correccion from tbl_foro_estudiante where est_id = {$_SESSION['USER']} and foro_id = {$iteninfo[$i]['id_act']} ");
				   			 $corregido = 'SI';	
							 $nota = $data['nota'];	
							 $com = $data['correccion']; 
							 if($nota<0){ $nota=0; $corregido = 'NO'; }///si no se ha corregido	  
				    }else{
					
							 $nota = 0;
							 $corregido = 'NO';
				  }
				   
				   break;
				   
				  case 'eval':
				  
					 $tool->query("select id from tbl_evaluacion_estudiante where est_id = {$_SESSION['USER']} and eval_id = {$iteninfo[$i]['id_act']} ") ;
					if($tool->nreg>0){
						   
							   $data = $tool->simple_db("select round(nota,2) as nota,correccion from tbl_evaluacion_estudiante where est_id = {$_SESSION['USER']} and eval_id = {$iteninfo[$i]['id_act']} ");
							   $corregido = 'SI';
							   $nota = $data['nota'];
							   $com = $data['correccion'];
							   if($nota<0){ $nota=0; $corregido = 'NO'; }///si no se ha corregido	   
					  }else{
					  
							   $nota = 0;
							   $corregido = 'NO';
					}
				  
				  break;
				  
				  default:
				  
				  $tool->query("select id from tbl_plan_estudiante where est_id = {$_SESSION['USER']} and item_id = {$iteninfo[$i]['id']} ") ;
				  if($tool->nreg>0){
				  				  
				     $data = $tool->simple_db("select round(nota,2) as nota,correccion from tbl_plan_estudiante where est_id = {$_SESSION['USER']} and item_id = {$iteninfo[$i]['id']} "); 
				  	 $corregido = 'SI';
					 $nota = $data['nota'];
					 $com = $data['correccion'];
					 if($nota<0){ $nota=0; $corregido = 'NO'; }///si no se ha corregido
					 	
					 
				   }else{
				   
					 $nota = 0;
					 $corregido = 'NO';
					}
				
			}
				  
			  	  $calc = bcdiv(($nota*$iteninfo[$i]['porcentaje']),$iteninfo[$i]['en_base'],1);
				  $ptotal+=$calc;
				  $calc.='%'; 
				  if($nota>=($iteninfo[$i]['en_base']/2)) $color = "#000066"; else $color = "#990000";
			      



?>
