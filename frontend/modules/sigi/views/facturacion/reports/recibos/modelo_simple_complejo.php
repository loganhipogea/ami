<?php
use frontend\modules\report\components\NumeroAletras;
use common\models\masters\Monedas;

$i=1;
?>
   <?php 
          $totalMes=0;
          $moneda=Monedas::findOne($codmon);
          $simbolo=$moneda->simbolo;
          $desmon=$moneda->desmon;
          unset($moneda);?>
<div style="  
    margin: 0 auto;
     position:absolute; color:black; left:30px;
     top:100px; width:500px; font-size:9px;  font-family:arial;
     font-weight:bold;  ">
       
     
       <?php    foreach($datos as $bloque){
              $totalMes+=array_sum(array_column($bloque,'monto'));
          }
        $totalMes=Yii::$app->formatter->asDecimal($totalMes,3);
       $bloque=$datos[array_keys($datos)[0]] // foreach($datos as $keydato=>$bloque){   ?>
            <?php   $subtotalCuota=Yii::$app->formatter->asDecimal(array_sum(array_column($bloque,'monto')),3);
                    $subtotalTotal=Yii::$app->formatter->asDecimal(array_sum(array_column($bloque,'montototal')),3);
                ?> 
        <table style="">
           <tr>
                <td style="text-align:center;" ><b><?=$bloque[0]['desgrupo']?></b></td>
                 <td style="text-align:center;" ><b>Monto</b></td>
                 <td style="text-align:center;" ><b>Cuota</b></td>
            </tr> 
            
        <?php
        $formato=\common\helpers\h::formato();
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
                 <td width="20%"  align="right" style="padding: 1px;"><?=$simbolo.'  '.$formato->asDecimal($fila['montototal'],3)?></td>
                  <td width="20%"   align="right" style="padding: 1px;"><?=$simbolo.'  '.$formato->asDecimal($fila['monto'],3)?></td>
            </tr>
        <?php }
        }
        ?>
            <tr>
                <td width="70%" align="right" style="padding: 1px;"><b>Total</b></td>
                <td width="20%"  align="right" style="padding: 1px;" ><b><?=$simbolo.'  '.$subtotalTotal?></b></td>
                <td width="20%"   align="right" style="padding: 1px;"><b><?=$simbolo.'  '.$subtotalCuota?></b></td>
            </tr>
        </table>
       <?php  ?>
       
  </div>   









   <div style="  
    margin: 0 auto;
     position:absolute; color:black; left:580px;
     top:100px; width:500px; font-size:9px;  font-family:arial;
     font-weight:bold; ">
       
       <?php 
       //quitando el primer elemento de los datos , porque ya se renderesixo arriba
       array_shift($datos);
       foreach($datos as $keydato=>$bloque){   ?>
            <?php   $subtotalCuota=$formato->asDecimal(array_sum(array_column($bloque,'monto')),2);
                    $subtotalTotal=$formato->asDecimal(array_sum(array_column($bloque,'montototal')),2);
                ?> 
        <table style="border-style:0px;">
           <tr>
                <td style="text-align:center;" ><b><?=$bloque[0]['desgrupo']?></b></td>
                 <td style="text-align:center;"><b>Monto</b></td>
                 <td style="text-align:center;"><b>Cuota</b></td>
            </tr> 
            
        <?php
        
        foreach($bloque as $clave=>$fila){
            if($fila['monto']!=0){
             $suministro=(empty(trim($fila['codsuministro'])))?'':'  Cod Suministro : '.(trim($fila['codsuministro']));
             $suministroAACC=($fila['aacc']=='1')?' => [AACC] ':' ';
             $unidades=(empty(trim($fila['unidades'])))?'':' ( '.(trim($fila['unidades'])).' )  ';
     $lanterior=(empty(trim($fila['lanterior'])))?'':' L. Ant. : '.trim(round($fila['lanterior'],2));
    $lactual=(empty(trim($fila['lectura'])))?'':' L. Act. : '.trim(round($fila['lectura'],2));
     $consumo=(empty(trim($fila['delta'])))?'':'  Consumo: '.trim(round($fila['delta'],2));
         $descripcion= $fila['descargo'].$suministro.$suministroAACC.$lanterior.$lactual.$consumo.$unidades;
        
       
            
            ?>
            <tr>
                <td width="70%" style="padding: 1px;"> <?=$descripcion?></td>
                 <td width="20%"  align="right" style="padding: 1px;"><?=$simbolo.'  '.$formato->asDecimal($fila['montototal'],2)?></td>
                  <td width="20%"   align="right" style="padding: 1px;"><?=$simbolo.'  '.$formato->asDecimal($fila['monto'],2)?></td>
            </tr>
        <?php }
        }
        ?>
            <tr style="border-style:0px;">
                <td width="70%" align="right" style="border-style: 0px;padding: 1px;"><b>Total</b></td>
                <td width="20%"  align="right" style="border-style: 0px;padding: 1px;" ><b><?=$simbolo.'  '.$subtotalTotal?></b></td>
                  <td width="20%"   align="right" style="border-style: 0px;padding: 1px;"><b><?=$simbolo.'  '.$subtotalCuota?></b></td>
            </tr>
        </table>
       <?php } ?>
       <div style="  text-align:right;
    margin: 0 auto;
     position:relative; color:black; 
     width:500px; font-size:14px;  font-family:arial;
     font-weight:bold; ">
          Total Recibo : <?=$simbolo.'  '.$totalMes ?><?PHP /*.'   '.
        //Yii::$app->formatter->asSpellout(round($totalMes,3));
        (new NumeroAletras)->toWords(              
              round($totalMes,2)).'   '.$desmon */?>
    </div>  
  </div>    
    


