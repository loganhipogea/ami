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
            width:126px;height:56px;
            padding:0px; top:2px;
            left:2px; border-style:solid; border-width:0px; border-color:#e1e1e1 ">

        <div style="position:absolute; padding:1px;border-style:none;top:5px; left:5px; ">
            <div style="float:right">
                <?=Html::img('@web/sigi/logo_diar.jpg',['width'=>84,'height'=>84])?>
            </div>

        </div>
    </div>
 
  
 <!-- INICIO DE LA PRUEBA   !-->
 <div style=" position:absolute;  left:548px;  top:416px;  font-size:10;  font-family:cour;  color:#000; ">
    POSICION 548px,416px
 </div>
 <!-- FIN DE LA PRUEBA    !-->
 
 <!-- FIN DEL   LOGO DEL RECIBO    !-->
  <!--  FECHA    !--> 
<div style=" position:absolute;  left:385px;  top:28px;  font-size:10;  font-family:cour;  color:#000; ">
    Fecha :
</div>
  <!-- FIN DE LA   FECHA    !--> 
 <div style=" position:absolute;  left:476px;  top:28px;  font-size:10;  font-family:cour;  font-weight:bold;  color:#000; ">
       <?=$model->fecha?>
</div>
  <div style=" position:absolute; width:266px;
       left:266px;  top:658px; 
       font-size:12;  font-family:cour;
       font-weight:none;  color:#000; text-align:justify ">
   <?=$model->detalles?>
 </div>
 <div style="position:absolute;  left:84x;  top:51px;  font-size:9;  font-family:cour;  font-weight:bold;  color:#000; ">
    <?=$model->edificio->nombre?>
 </div>
 <div style="position:absolute;   left:84px;  top:50px;  font-size:8;  font-family:arial;  font-weight:none;  color:#000; ">
      <?=$model->edificio->direccion?>
 </div>
 <div style=" position:absolute;  left:35px;  top:75px;  font-size:9;  font-family:arial;  font-weight:bold;  color:#F72; ">
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
 <div style=" position:absolute;  left:35px;  top:658px;  font-size:8;  font-family:arial;  font-weight:bold;  color:#000; ">
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
      <div style="width: 210px;">
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
       <div style=" position:absolute;  left:350px;  top:11px;  font-size:12;  font-family:cour;  color:#000; ">Recibo N° :<?=$detalle->numerorecibo?></div>

       <div style=" position:absolute;  left:385px;  top:39px;  font-size:9;  font-family:cour;  color:#000; ">F Vencimiento :</div>
       <div style=" position:absolute;  left:476px;  top:39px;  font-size:9;  font-family:cour;  font-weight:bold;  color:#000; "><?=$model->fvencimiento?></div>
       
       
       <div style=" position:absolute;  left:35px;  top:105px;  font-size:8;  font-family:arial;  font-weight:bold;  color:#000; ">
            <div>
               
                <div style="width: 420px;">
                     <?PHP
                if(!$detalle->resumido){
                 if($detalle->nuevoprop){//si es un recibo partido por 
                 //una trnasferencia de un pepoeario viejo
                   $propietario=$detalle->unidad->propietarioRecibo();   
                 }else{//si no es transferencia normal
                    $propietario=$detalle->unidad->oldPropietario(SigiUnidades::TYP_PROPIETARIO); 
                 }
                     
                  
                ?>
              <div>
                        <table>
                            <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Documento</th>
                                        <th>Calificación</th>
                                    </tr>
                            </thead>
                            <tbody>
                                    <tr>
                                            <td><?=$propietario->nombre?></td>
                                            <td><?=$propietario->dni?></td>
                                            <td><?=$propietario->tipo?></td>
                                     </tr>
                           </tbody>
                       </table>
              </div>
                <?PHP } ELSE { 
                   
                    ?>
                  <table>
                            <thead>
                                    <tr>
                                        <th>Nombre</th>
                                       
                                    </tr>
                            </thead>
                            <tbody>
                                    <tr>
                                            <td><?PHP echo 'El presente recibo incluye todas las unidades dentro de su propiedad' ?></td>
                                            
                                     </tr>
                           </tbody>
                       </table>
                    
                <?PHP }    ?>
              <!-- /.table-responsive -->
            </div>
    
                </div>
       </div>
       <div style=" position:absolute;  left:385px;  top:50px;  font-size:9;  font-family:cour;  color:#000; ">Dias facturados :</div>
       <div style=" position:absolute;  left:476px;  top:50px;  font-size:9;  font-family:cour;  font-weight:none;  color:#000; "><?=$detalle->dias?></div>
       
       
       
       
       
       
       <div style="position:absolute; width:132px; left:35px; top:140px">
               
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
                                $vista=($compacto)?'modelo_compacto':'modelo_simple';
                                if($modelo->reporte_id==4)$vista='modelo_complejo';
                                echo $this->render($vista,[
                                    'modelo'=>$model,
                                    'grupos'=>$grupos,
                                    'detalles'=>$detalles,
                                    'codmon'=>$detalle->codmon,
                                    ]);
                         
                         ?>
               
        </div>       
   </body>
    </html>
    
