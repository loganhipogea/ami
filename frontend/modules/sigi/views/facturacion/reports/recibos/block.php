<div style="padding:1px; border: 0px solid #000;margin-bottom: 5px;"  >
     
    <div style="padding:1px; font-size:5px !important;"  >
        <?php
        $totalMesRaw=array_sum(array_column($detalles,'monto'));
        $totalMes=Yii::$app->formatter->asDecimal(array_sum(array_column($detalles,'monto')),2);
        $codgrupo=$grupo['codgrupo'];
        $filtrado=array_filter($detalles,function($v,$k)use($codgrupo){
           return  $v['codgrupo']==$codgrupo;
        }, ARRAY_FILTER_USE_BOTH); 
        
       
        
        
                  $subtotalCuota=Yii::$app->formatter->asDecimal(array_sum(array_column($filtrado,'monto')),3);
                  $subtotalTotal=Yii::$app->formatter->asDecimal(array_sum(array_column($filtrado,'montototal')),3);
        ?> 
        <table style="padding: 0px; margin: 0px; border-style:none;  ">
           <tr>
                <td width="70%" style="padding: 1px;"><b><?=$grupo['desgrupo']?></b></td>
                 <td width="20%"  align="right" style="padding: 1px;"><b>Monto</b></td>
                 <td width="20%"   align="right" style="padding: 1px;"><b>Cuota</b></td>
            </tr> 
            
        <?php
        
        foreach($filtrado as $clave=>$fila){
            if($fila['monto']!=0){
             $suministro=(empty(trim($fila['codsuministro'])))?'':'  Cod Suministro : '.(trim($fila['codsuministro']));
             $suministroAACC=($fila['aacc']=='1')?' => [AACC] ':' ';
             $unidades=(empty(trim($fila['unidades'])))?'':' ( '.(trim($fila['unidades'])).' )  ';
     $lanterior=(empty(trim($fila['lanterior'])))?'':' L. Ant. : '.trim(round($fila['lanterior'],3));
    $lactual=(empty(trim($fila['lectura'])))?'':' L. Act. : '.trim(round($fila['lectura'],3));
     $consumo=(empty(trim($fila['delta'])))?'':'  Consumo: '.trim(round($fila['delta'],3));
         $descripcion= $fila['descargo'].$suministro.$suministroAACC.$lanterior.$lactual.$consumo.$unidades;
        
       
            
            ?>
            <tr>
                <td width="70%" style="padding: 1px;"> <?=$descripcion?></td>
                 <td width="20%"  align="right" style="padding: 1px;"><?=$fila['simbolo'].'  '.Yii::$app->formatter->asDecimal($fila['montototal'],3)?></td>
                  <td width="20%"   align="right" style="padding: 1px;"><?=$fila['simbolo'].'  '.Yii::$app->formatter->asDecimal($fila['monto'],3)?></td>
            </tr>
        <?php }
        }
        ?>
            <tr>
                <td width="70%" align="right" style="padding: 1px;"><b>Total</b></td>
                <td width="20%"  align="right" style="padding: 1px;" ><b><?=$fila['simbolo'].'  '.$subtotalTotal?></b></td>
                  <td width="20%"   align="right" style="padding: 1px;"><b><?=$fila['simbolo'].'  '.$subtotalCuota?></b></td>
            </tr>
        </table>
     </div>
    
</div>
