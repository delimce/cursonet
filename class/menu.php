<?php


  class menu {

 //**********************************************************************Atributos de la clase
  var $estructura;  //vector con la estructura para armar el menu
  var $nombre;

  function menu($estruct){

  $this->estructura = $estruct;
  $this->nombre = $this->estructura['nombre'];


  }

 /*************************************************************/

   function mostrar($actual){
            echo '<table width="'.$this->estructura['ancho'].'" border="0" align="'.$this->estructura['aliniado'].'" cellpadding="'.$this->estructura['padding'].'" cellspacing="'.$this->estructura['spacing'].'">
           	<tr>
		   <td class="no_back" colspan="'.count($this->estructura['items']).'">'.LANG_curso_actual.' <B>'.$_SESSION['CURSOALIAS'].'</B></td>
		   </tr>
		<tr><td colspan="'.count($this->estructura['items']).'">&nbsp;<td> </tr>
		   
		    <tr >';

              for($i=0;$i<count($this->estructura['items']);$i++){

                $vinculo ='';
				$cursor  = '';
				$leftborder = '';
				$colorc = $this->estructura['b_color_se'];
                if($i==count($this->estructura['items'])-1) $rightborder = 'border-right:solid 1px #000000;'; else $rightborder = '';
                if($i!=$actual){ 
				$colorc = $this->estructura['b_color_un']; $leftborder = 'border-bottom:solid 1px #000000;';
				$vinculo = "onClick=\"location.assign('".$this->estructura['url'][$i]."')\"";
				$cursor = "cursor:pointer;";
				}
                
               echo  "<td $vinculo bgcolor=\"".$colorc."\" style=\"border-top:solid 1px #000000; ".$leftborder." ".$rightborder." border-left:solid 1px #000000; $cursor color:".$this->estructura['b_color']."\" width=\"".$this->estructura['ancho_i'][$i]."\"  align=\"left\">&nbsp;".$this->estructura['items'][$i]."</td>";

              }
            echo '</tr>
          </table>';
   }



 } ////fin de la clase menu

?>