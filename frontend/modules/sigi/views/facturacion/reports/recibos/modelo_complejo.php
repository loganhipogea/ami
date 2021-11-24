<?php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\modules\sigi\models\VwSigiFacturecibo;
use frontend\modules\sigi\models\SigiUnidades;
use common\models\masters\Clipro;
$detalle=$dataProvider->getModels()[0];
$model=$detalle->facturacion;
?>
<!DOCTYPE html>
    <html lang="es">
    <head>        
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
       <title></title>
        <?php $this->registerCssFile('@web/css/reporte.css') ?>
    </head>
   <body style="overflow-y: scroll;">
   <!--  LOGO DEL RECIBO    !--> 
   <div style="position:absolute;
            width:127px;height:56px;
            padding:0px; top:3px;
            left:3px; border-style:solid; border-width:0px; border-color:#e1e1e1 ">

        <div style="position:absolute; padding:1px;border-style:none;top:3px; left:3px; ">
            <div style="float:right">
                <?=Html::img('@web/sigi/logo_diar.jpg',['width'=>84,'height'=>84])?>
            </div>

        </div>
    </div>
  <!-- FIN DEL   LOGO DEL RECIBO    !--> 
    
    <!--NOMBRE DE COLOR NARANJA DEL DEPARATAMENTO   !--> 
   <div  position:absolute;  left:25px;  top:70px;  font-size:9px;  font-family:arial;  font-weight:bold;  color:#F72; ">
     <?php  
     if(!$detalle->resumido){
        echo $detalle->unidad->nombre;  
     }else{
        /*Si es un recibo compacto */
         $nombre=Clipro::findOne($detalle->grupocobranza)->despro; 
        echo    $nombre;
     }   
      ?>
  </div>
  
  
  <!-- NOMBRE DEL EDIFICIO Y DIRECCION    !--> 

 <div style="background-color: red;text-align:center;width:400px; position:absolute;  left:100px;  top:36px;  font-size:7;  font-family:cour;  font-weight:bold;  color:#000; ">
    <?=$model->edificio->nombre?>
 </div>
 <div style="position:absolute;   left:100px;  top:50px;  font-size:3;  font-family:arial;  font-weight:none;  color:#000; ">
      <?=$model->edificio->direccion?>
 </div>
   
  
   <!-- Recibo :  !--> 
 <div style=" position:absolute;  left:354px;  top:11px;  font-size:8px;  font-family:cour;  color:#000; ">
        Recibo N° :
 </div>
<div style=" position:absolute;  left:450px;  top:11px;  font-size:10px;  font-family:cour; font-weight:bold;  color:#000; ">
    <?=$detalle->numerorecibo?>
 </div>
 
   <!-- fecha:   !--> 
 <div style=" position:absolute;  left:354px;  top:29px;  font-size:7px;  font-family:cour;  color:#000; ">
     Fecha :
 </div>   
 <div style=" position:absolute;  left:450px;  top:29px;  font-size:7px;  font-family:cour;  font-weight:bold;  color:#000; ">
       <?=$model->fecha?>
 </div>   
   
  <!-- F vencimiento :  !--> 
<div style=" position:absolute;  left:354px;  top:39px;  font-size:7px;  font-family:cour;  color:#000; ">
 F Vencimiento :
</div>
<div style=" position:absolute;  left:450px;  top:39px;  font-size:7px;  font-family:cour;  font-weight:bold;  color:#000; ">
                <?=$model->fvencimiento?>
</div>
  
<!-- Dias facturados :  !-->  
<div style=" position:absolute;  left:354px;  top:50px;  font-size:7px;  font-family:cour;  color:#000; ">
       Dias facturados :
</div>
<div style=" position:absolute;  left:450px;  top:50px; width:100px; font-size:7px;  font-family:cour;  font-weight:none;  color:#000; ">
      <?=$detalle->dias?>
</div>
  
    <!-- Datos del propietario :  !-->     
       
       <div style=" position:absolute;  left:25px;  top:106px;  font-size:7px;  font-family:arial;  font-weight:bold;  color:#000; ">
            <div>               
                <div style="width:424px;">
                     <?PHP
                if(!$detalle->resumido){
                 if($detalle->nuevoprop){//si es un recibo partido por 
                 //una trnasferencia de un pepoeario viejo
                   $propietario=$detalle->unidad->propietarioRecibo();   
                 }else{//si no es transferencia normal
                    $propietario=$detalle->unidad->oldPropietario(SigiUnidades::TYP_PROPIETARIO); 
                 }
                ?>
              <div><?=$propietario->nombre?></div>
                <?PHP } ELSE {?>
                 <?PHP echo 'El presente recibo incluye todas las unidades dentro de su propiedad' ?></td>
                    
                <?PHP }    ?>
           </div>
    
                </div>
       </div>
     <!-- Fin de Datos del propietario :  !--> 
     
   
      
         
  
  
  
  
  <div style=" position:absolute; width:269px;
       left:270px;  top:665px; 
       font-size:8;  font-family:cour;
       font-weight:none;  color:#000; text-align:justify ">
   <?=$model->detalles?>
 </div>
     


 <div style=" position:absolute;  left:25px;  top:665px;  font-size:3;  font-family:arial;  font-weight:bold;  color:#000; ">
   <?php
     if(!$detalle->resumido){     
         $areas= $detalle->unidad->arrayParticipaciones();     
        //yii::error( $areas,__FUNCTION__);
        }else{
           
            $Aareas= VwSigiFacturecibo::find()->select(['nombre','numero','area','participacion'])->distinct()->andWhere(['kardex_id'=>$detalle->kardex_id,'resumido'=>'1'])->asArray()->all();
           // $areasOriginales=$Aareas;
            if(count($Aareas)>10){
                $areas= array_sum(array_column($Aareas,'area'));
                 $participacion= array_sum(array_column($Aareas,'participacion' ));
               $Aareas=[['nombre'=>$nombre,'numero'=>'','area'=>$areas,'participacion'=>$participacion]]; 
            }else{
                
            }
            $AreaTotal=$model->edificio->area();
           $areas= ['aareas'=>$Aareas,'atotal'=>$AreaTotal];
        }
     ?>
     
     
    <div>
      <div style="width:212px;">
              <div >
                <table >
                  <thead>
                  <tr>
                    <th>Nombre</th>
                    <th>Area(m2)</th>
                   
                    <th>Participación (%)</th>
                  </tr>
                  </thead>
                  <tbody>
                   <?php
                   $area=0;
                       $parti=0;
                       
                    // var_dump($areas['aareas'],$areas['aareas'][0]['nombre']);die();
                   foreach($areas['aareas'] as $registroArea) { 
                       $area+=$registroArea['area']+0;
                       $parti+=$registroArea['participacion']+0;
                      
                    echo"<tr>\n";
                     echo"<td>\n";
                     echo $registroArea['nombre'];
                      echo"</td>\n";
                    echo"<td>\n";
                    echo round($registroArea['area']+0,3);
                    echo"</td>\n";
                     echo"<td>\n";
                    echo 100*round($registroArea['participacion']+0,4);
                    echo"</td>\n";
                   echo"</tr>\n";
                     } ?>
                  <tr >
                    <td style="font-weight: bold;">Total:</td>
                    <td style="font-weight: bold;">
                     
                    <?=round($area,3)?>
                    </td>
                    <td style="font-weight: bold;">
                    <?=100*round($parti,4)?>
                    </td>
                  </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
    
   </div>
 
 </div>
       
       
      
               
                        <?php
                         /*
                          * Averiguando que identidades son parte de un recibo
                          * de cobranza masiva
                          * $resumido=true: Quiere decir que debe de ersumirse 
                          * ya agrupase en un solo recibo
                          */
                         $array_depas=$dataProvider->query->select(['unidad_id'])->distinct()->column();
                         //yii::error('el toipo',__FUNCTION__);
                         //yii::error($array_depas,__FUNCTION__);
                         $array_depas=array_unique($array_depas);
                            $resumido=(count($array_depas)>1)?true:false;      
                        // var_dump( $resumido);die();
                                $grupos=VwSigiFacturecibo::find()->select(['codgrupo','desgrupo'])->andWhere(['>','montototal',0])->
                                   andWhere(['kardex_id'=>$detalle->kardex_id])->distinct()->asArray()->all();
                                if(!$resumido){
                                   $detalles=VwSigiFacturecibo::find()->select(['codgrupo',
                                    'desgrupo','aacc',
                                    'descargo','codsuministro','unidades','lanterior','lectura','delta',
                                    'monto','montototal','simbolo'])->andWhere(['kardex_id'=>$detalle->kardex_id])
                                    ->asArray()->all(); 
                                }else{
                                 
                                   $detalles=VwSigiFacturecibo::find()->select(['codgrupo',
                                    'desgrupo','aacc',
                                    'descargo',/*'codsuministro','unidades','lanterior','lectura','delta',*/
                                    'sum(monto) as monto','montototal','simbolo'])->andWhere(['kardex_id'=>$detalle->kardex_id])
                                    ->groupBy(['codgrupo','desgrupo','descargo','montototal','simbolo'])->asArray()->all();  
                                
                                   // yii::error('Es resumido',__FUNCTION__);
                                   // yii::error($detalles[0]['monto'],__FUNCTION__);
                                }
                                $vista=($compacto)?'modelo_compacto_complejo':'modelo_simple_complejo';
                                echo $this->render($vista,[
                                    'modelo'=>$model,
                                    'grupos'=>$grupos,
                                    'detalles'=>$detalles,
                                    'codmon'=>$detalle->codmon,
                                    ]);
                         
                         ?>
               
            
   </body>
    </html>
    
