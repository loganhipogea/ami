<?php
use common\helpers\h;
$formato=h::formato();
?>

             <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr >
                      <th colspan="2">
                          <p class="text-green"><span class="fa fa-money"></span>
                              Detalle por conceptos
                          </p></th> 
                    
                  </tr>
                  <tr>
                      <th>Concepto</th> 
                      <th>Monto</th> 
                    
                  </tr>
                  </thead>
                  <tbody>
                  <?php foreach($datos as $fila) { ?>     
                <tr>                   
                  <td "style"="font-size:0.5em"><?=$fila['descripcion']?> <i style="color:#ccc;"><span class="fa fa-check"></span></i>
                  </td>
                   <td "style"="text-align:right; !important">
                       <div class="sparkbar" data-color="#00a65a" data-height="20", "style"="font-size:0.5em" >S/.<?=$formato->asDecimal($fila['monto'],2)?></div>
                   </td>
                </tr> 
                 <?php } ?>      
                         
                        
                  
                  </tbody>
                </table>
              </div>
<BR>
<BR>
<BR>