<?php
       // $totalMesRaw=array_sum(array_column($detalles,'monto'));
        //$totalMes=Yii::$app->formatter->asDecimal(array_sum(array_column($detalles,'monto')),2);
        //$codgrupo=$grupo['codgrupo'];
       /* $filtrado=array_filter($detalles,function($v,$k)use($codgrupo){
           return  $v['codgrupo']==$codgrupo;
        }, ARRAY_FILTER_USE_BOTH); */
        
       
        
        
                 // $subtotalCuota=Yii::$app->formatter->asDecimal(array_sum(array_column($bloque,'monto')),3);
                  //$subtotalTotal=Yii::$app->formatter->asDecimal(array_sum(array_column($bloque,'montototal')),3);
        ?> 
        <table style="">
           <tr>
                <td ><b>cualquier cosa</b></td>
                 <td ><b>Monto</b></td>
                 <td ><b>Cuota</b></td>
            </tr> 
            
        <?php
        
       /* foreach($bloque as $clave=>$fila){
            if($fila['monto']!=0){
             $suministro=(empty(trim($fila['codsuministro'])))?'':'  Cod Suministro : '.(trim($fila['codsuministro']));
             $suministroAACC=($fila['aacc']=='1')?' => [AACC] ':' ';
             $unidades=(empty(trim($fila['unidades'])))?'':' ( '.(trim($fila['unidades'])).' )  ';
     $lanterior=(empty(trim($fila['lanterior'])))?'':' L. Ant. : '.trim(round($fila['lanterior'],3));
    $lactual=(empty(trim($fila['lectura'])))?'':' L. Act. : '.trim(round($fila['lectura'],3));
     $consumo=(empty(trim($fila['delta'])))?'':'  Consumo: '.trim(round($fila['delta'],3));
         $descripcion= $fila['descargo'].$suministro.$suministroAACC.$lanterior.$lactual.$consumo.$unidades;
        
       */
            
            ?>
            <tr>
                <td > descripcion</td>
                 <td >100</td>
                  <td >200</td>
            </tr>
        <?php /*}
        }*/
        ?>
            <tr>
                <td ><b>Total</b></td>
                <td ><b>458</b></td>
                  <td ><b>580</b></td>
            </tr>
        </table>

