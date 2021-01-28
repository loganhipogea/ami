<?php
//print_r($detalles);
 foreach($grupos as $index=>$grupo){
    // var_dump($grupo);
 ?>
<div style="padding:5px; border: 1px solid #000;margin-bottom: 35px;  "  >
     
    <div style="padding:2px; "  >
        <?php
        $totalMes=Yii::$app->formatter->asDecimal(array_sum(array_column($detalles,'monto')),2);
        $codgrupo=$grupo['codgrupo'];
        $filtrado=array_filter($detalles,function($v,$k)use($codgrupo){
           return  $v['codgrupo']==$codgrupo;
        }, ARRAY_FILTER_USE_BOTH); 
        
       
        
        
                  $subtotalCuota=Yii::$app->formatter->asDecimal(array_sum(array_column($filtrado,'monto')),2);
                  $subtotalTotal=Yii::$app->formatter->asDecimal(array_sum(array_column($filtrado,'montototal')),2);
        ?> 
        <table style="">
           <tr>
                <td width="70%"><b><?=$grupo['desgrupo']?></b></td>
                 <td width="20%"  align="right" ><b>Monto</b></td>
                 <td width="20%"   align="right"><b>Cuota</b></td>
            </tr> 
            
        <?php
        
        foreach($filtrado as $clave=>$fila){
            if($fila['monto']!=0){
             $suministro=(empty(trim($fila['codsuministro'])))?'':'  Cod Suministro : '.(trim($fila['codsuministro']));
     $unidades=(empty(trim($fila['unidades'])))?'':' ( '.(trim($fila['unidades'])).' )  ';
     $lanterior=(empty(trim($fila['lanterior'])))?'':' L. Ant. : '.trim(round($fila['lanterior'],2));
    $lactual=(empty(trim($fila['lectura'])))?'':' L. Act. : '.trim(round($fila['lectura'],2));
     $consumo=(empty(trim($fila['delta'])))?'':'  Consumo: '.trim(round($fila['delta'],2));
         $descripcion= $fila['descargo'].$suministro.$lanterior.$lactual.$consumo.$unidades;
        
       
            
            ?>
            <tr>
                <td width="70%"> <?=$descripcion?></td>
                 <td width="20%"  align="right" ><?=$fila['simbolo'].'  '.Yii::$app->formatter->asDecimal($fila['montototal'],2)?></td>
                  <td width="20%"   align="right"><?=$fila['simbolo'].'  '.Yii::$app->formatter->asDecimal($fila['monto'],2)?></td>
            </tr>
        <?php }
        }
        ?>
            <tr>
                <td width="70%" align="right" ><b>Total</b></td>
                <td width="20%"  align="right" ><b><?=$subtotalTotal?></b></td>
                  <td width="20%"   align="right"><b><?=$subtotalCuota?></b></td>
            </tr>
        </table>
     </div>
    
</div>


<?php    
 }
?>
<div style="padding:5px; border: 1px solid #000;margin-bottom: 35px;  "  >
    Total Recibo : <?=$totalMes  ?>
</div>

