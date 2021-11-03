<?php
use frontend\modules\report\components\NumeroAletras;
use common\models\masters\Monedas;

$i=1;
?>
 
<div style="  
    margin: 0 auto;
     position:absolute; color:black; left:30px;
     top:200px; width:500px; font-size:9px;  font-family:arial;
     font-weight:bold; background-color:yellow; ">
       
       <?php $bloque=$datos[array_keys($datos)[0]] // foreach($datos as $keydato=>$bloque){   ?>
            <?php   $subtotalCuota=Yii::$app->formatter->asDecimal(array_sum(array_column($bloque,'monto')),3);
                    $subtotalTotal=Yii::$app->formatter->asDecimal(array_sum(array_column($bloque,'montototal')),3);
                ?> 
        <table style="">
           <tr>
                <td ><b><?=$bloque[0]['desgrupo']?></b></td>
                 <td ><b>Monto</b></td>
                 <td ><b>Cuota</b></td>
            </tr> 
            
        <?php
        
        foreach($bloque as $clave=>$fila){
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
                 <td width="20%"  align="right" style="padding: 1px;"><?=$codmon.'  '.Yii::$app->formatter->asDecimal($fila['montototal'],3)?></td>
                  <td width="20%"   align="right" style="padding: 1px;"><?=$codmon.'  '.Yii::$app->formatter->asDecimal($fila['monto'],3)?></td>
            </tr>
        <?php }
        }
        ?>
            <tr>
                <td width="70%" align="right" style="padding: 1px;"><b>Total</b></td>
                <td width="20%"  align="right" style="padding: 1px;" ><b><?=$codmon.'  '.$subtotalTotal?></b></td>
                  <td width="20%"   align="right" style="padding: 1px;"><b><?=$codmon.'  '.$subtotalCuota?></b></td>
            </tr>
        </table>
       <?php  ?>
       
  </div>   









   <div style="  
    margin: 0 auto;
     position:absolute; color:black; left:580px;
     top:100px; width:500px; font-size:9px;  font-family:arial;
     font-weight:bold; background-color:yellow; ">
       
       <?php 
       //quitando el primer elemento de los datos , porque ya se renderesixo arriba
       array_shift($datos);
       foreach($datos as $keydato=>$bloque){   ?>
            <?php   $subtotalCuota=Yii::$app->formatter->asDecimal(array_sum(array_column($bloque,'monto')),3);
                    $subtotalTotal=Yii::$app->formatter->asDecimal(array_sum(array_column($bloque,'montototal')),3);
                ?> 
        <table style="">
           <tr>
                <td ><b><?=$bloque[0]['desgrupo']?></b></td>
                 <td ><b>Monto</b></td>
                 <td ><b>Cuota</b></td>
            </tr> 
            
        <?php
        
        foreach($bloque as $clave=>$fila){
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
                 <td width="20%"  align="right" style="padding: 1px;"><?=$codmon.'  '.Yii::$app->formatter->asDecimal($fila['montototal'],3)?></td>
                  <td width="20%"   align="right" style="padding: 1px;"><?=$codmon.'  '.Yii::$app->formatter->asDecimal($fila['monto'],3)?></td>
            </tr>
        <?php }
        }
        ?>
            <tr>
                <td width="70%" align="right" style="padding: 1px;"><b>Total</b></td>
                <td width="20%"  align="right" style="padding: 1px;" ><b><?=$codmon.'  '.$subtotalTotal?></b></td>
                  <td width="20%"   align="right" style="padding: 1px;"><b><?=$codmon.'  '.$subtotalCuota?></b></td>
            </tr>
        </table>
       <?php } ?>
       
  </div>    
     

<div style="padding:3px; border: 1px solid #000;margin-bottom: 17px; font-size:7px;  "  >
    Total Recibo : <?=$totalMes.'   '.
        //Yii::$app->formatter->asSpellout(round($totalMes,3));
        (new NumeroAletras)->toWords(              
              round($totalMesRaw,2)).'  '.
               Monedas::findOne($codmon)->desmon ?>
</div>

