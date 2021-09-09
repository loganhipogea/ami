<?php
use frontend\modules\report\components\NumeroAletras;
use common\models\masters\Monedas;
//print_r($detalles);
 foreach($grupos as $index=>$grupo){
    // var_dump($grupo);
 ?>
<div style="padding:5px; border: 1px solid #000;margin-bottom: 35px;  "  >
     
    <div style="padding:2px; "  >
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
             $suministroAACC=($fila['aacc']=='1')?' => [AACC] ':' ';
             $unidades=(empty(trim($fila['unidades'])))?'':' ( '.(trim($fila['unidades'])).' )  ';
     $lanterior=(empty(trim($fila['lanterior'])))?'':' L. Ant. : '.trim(round($fila['lanterior'],3));
    $lactual=(empty(trim($fila['lectura'])))?'':' L. Act. : '.trim(round($fila['lectura'],3));
     $consumo=(empty(trim($fila['delta'])))?'':'  Consumo: '.trim(round($fila['delta'],3));
         $descripcion= $fila['descargo'].$suministro.$suministroAACC.$lanterior.$lactual.$consumo.$unidades;
        
       
            
            ?>
            <tr>
                <td width="70%"> <?=$descripcion?></td>
                 <td width="20%"  align="right" ><?=$fila['simbolo'].'  '.Yii::$app->formatter->asDecimal($fila['montototal'],3)?></td>
                  <td width="20%"   align="right"><?=$fila['simbolo'].'  '.Yii::$app->formatter->asDecimal($fila['monto'],3)?></td>
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
    Total Recibo : <?=$totalMes.'   '.
        //Yii::$app->formatter->asSpellout(round($totalMes,3));
        (new NumeroAletras)->toWords(              
              round($totalMesRaw,2)).'  '.
               Monedas::findOne($codmon)->desmon ?>
</div>

