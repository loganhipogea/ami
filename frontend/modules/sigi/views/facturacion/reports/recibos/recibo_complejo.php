<?php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\modules\sigi\models\VwSigiFacturecibo;
use frontend\modules\sigi\models\SigiUnidades;
use common\models\masters\Clipro;
use frontend\modules\sigi\models\SigiSuministros;
use common\helpers\timeHelper;
$detalle=$kardex->detalleFactu[0];
$unidad=$detalle->unidad;
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
 
 <!-- FIN DEL   LOGO DEL RECIBO    !-->
 
 
  <!--  NUMERO RECIBO FECHA Y FECHA DE VENCIMIENTO   !--> 
    <div style=" position:absolute;  left:350px;  top:11px;  font-size:12px;  font-family:cour;  color:#000; ">Recibo N° :<?=$detalle->numerorecibo?></div>
    <div style=" position:absolute;  left:385px;  top:39px;  font-size:9px;  font-family:cour;  color:#000; ">
         F Vencimiento :
    </div>
    <div style=" position:absolute;  left:476px;  top:39px;  font-size:9px;  font-family:cour;  font-weight:bold;  color:#000; ">
                <?=$model->fvencimiento?>
    </div>
     <div style=" position:absolute;  left:385px;  top:28px;  font-size:10;  font-family:cour;  color:#000; ">
       Fecha emisión :
     </div>
     <div style=" position:absolute;  left:476px;  top:28px;  font-size:10;  font-family:cour;  font-weight:bold;  color:#000; ">
       <?=$model->fecha?>
      </div>
     
       <div style=" position:absolute;  left:385px;  top:50px;  font-size:9px;  font-family:cour;  color:#000; ">
           Dias facturados :
       </div>
       <div style=" position:absolute; width:100px;  left:476px;  top:50px;  font-size:9px;  font-family:cour;  font-weight:none;  color:#000; ">
                <?=$detalle->dias?>
       </div>
       
       
 <!-- FIN NUMERO RECIBO FECHA Y FECHA DE VENCIMIENTO   !--> 
 
    
  
  <!--  NOMBRE Y DIRECCION  DEL EDIFICIO    !--> 
 <div style="text-align:center;width:300px; position:absolute;  left:90x;  top:40px;  font-size:9px;  font-family:cour;  font-weight:bold;  color:#000; ">
    <?=$model->edificio->nombre?>
 </div>
 <div style="text-align:center;width:300px; position:absolute;   left:90px;  top:48px;  font-size:8px;  font-family:arial;  font-weight:none;  color:#000; ">
      <?=$model->edificio->direccion?>
 </div>
  <!-- FIN DEL  NOMBRE Y DIRECCION  DEL EDIFICIO    !--> 

  
<!--  NOMBRE DEL DEPA    !--> 
    <div style=" position:absolute;  left:35px;  top:65px;  font-size:9px;  font-family:arial;  font-weight:bold;  color:#F72; ">
     <?php  
     if(!$detalle->resumido){
        echo $unidad->nombre;  
     }else{
        /*Si es un recibo compacto */
         $nombre=Clipro::findOne($detalle->grupocobranza)->despro; 
        echo    $nombre;
     }    
      ?>
    </div>
<!-- FIN DEL  NOMBRE DEL DEPA    !--> 


       <!-- NOMBRE DEL PROPIESTARIO -->
       <div style=" position:absolute;  left:35px;  top:80px;  font-size:8;  font-family:arial;  font-weight:bold;  color:#000; ">
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
                        <?=$propietario->nombre?>
              </div>
                <?PHP } ELSE { 
                   
                    ?>
                 <?PHP echo 'El presente recibo incluye todas las unidades dentro de su propiedad' ?></td>
                                 
                <?PHP }    ?>
              <!-- /.table-responsive -->
            </div>
    
                </div>
       </div>
        <!-- FIN DEL NOMBRE DEL PROPIESTARIO -->
        
        
        <?php
     if(!$detalle->resumido){     
         $areas= $detalle->unidad->arrayParticipaciones();     
        //yii::error( $areas,__FUNCTION__);
        }else{
           
            $Aareas= VwSigiFacturecibo::find()->
            select(['nombre','numero','area','participacion'])->distinct()->
            andWhere(['kardex_id'=>$detalle->kardex_id,'resumido'=>'1'])->asArray()->all();
           // $areasOriginales=$Aareas;
            if(count($Aareas)>10){
                $areas= array_sum(array_column($Aareas,'area'));
                 $participacion= array_sum(array_column($Aareas,'participacion' ));
               $Aareas=[
                ['nombre'=>$nombre,'numero'=>'','area'=>$areas,'participacion'=>$participacion]
                       ]; 
            }else{
                
            }
            $AreaTotal=$model->edificio->area();
           $areas= ['aareas'=>$Aareas,'atotal'=>$AreaTotal];
        }
     ?>
        
       <!-- IMAGEN DE MEDIDORES     !--> 
        <div style=" display:table; position:absolute; width:120px; left:700px;  top:540px; font-size:8;  font-family:arial;  font-weight:bold;  color:#000;">
           <?php 
               
               $hayimagenmesanterior=false;
              
                if(!is_null($medidor=$unidad->firstMedidor(SigiSuministros::COD_TYPE_SUMINISTRO_DEFAULT))){
                    if(!is_null($lectura=$medidor->readFacturableByMonth($kardex->mes,$kardex->anio))){
                        if($lectura->hasAttachments()){
                           echo 'Lectura actual (m3) '.round($lectura->lectura,2);
                           echo Html::img($lectura->files[0]->urlTempWeb,['width'=>100,'height'=>100]); 
                        }
                    }
                   if(!is_null($lecturaant=$medidor->readFacturableByMonth(timeHelper::previousMonth($kardex->mes),$kardex->anio))){
                        if($lecturaant->hasAttachments()){
                           $hayimagenmesanterior= Html::img($lecturaant->files[0]->urlTempWeb,['width'=>100,'height'=>100]); 
                        }
                    } 
                    
                }
// $unidad->firstMedidor(SigiSuministros::COD_TYPE_SUMINISTRO_DEFAULT)->readFacturableByMonth(9,'2021')->files[0]->url
           ?>
            </div>
        <div style="display:table; position:absolute; width:120px; left:580px;  top:540px;font-size:8;  font-family:arial;  font-weight:bold;  color:#000;">
          <?php if($hayimagenmesanterior){
                echo 'Lectura anterior (m3) '.round($lecturaant->lectura,2);
                echo $hayimagenmesanterior;
          }   ?>
        </div>
       <!-- FIN DE IMAGEN  !--> 
        
         <!-- TABLA DE RESUMEN DE AREAS     !--> 
        <div style="display:table; position:absolute; width:210px; left:580px;  top:658px;  font-size:8;  font-family:arial;  font-weight:bold;  color:#000; ">
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
                    echo round($registroArea['area']+0,4);
                    echo"</td>\n";
                     echo"<td>\n";
                    echo 100*round($registroArea['participacion']+0,6);
                    echo"</td>\n";
                   echo"</tr>\n";
                     } ?>
                  <tr >
                    <td style="font-weight: bold;">Total:</td>
                    <td style="font-weight: bold;">
                     
                    <?=round($area,4)?>
                    </td>
                    <td style="font-weight: bold;">
                    <?=100*round($parti,6)?>
                    </td>
                  </tr>
                  </tbody>
                </table>
              <!-- /.table-responsive -->
       </div>
       <div style="text-align:justify;  display:table; position:absolute; width:300px; left:800px;  top:658px;  font-size:8;  font-family:arial;  font-weight:bold;  color:#000; ">
        
         <?=$model->detalles?>
       </div>
 
    
 </div>
   <!-- FIN DE LA  TABLA DE RESUMEN DE AREAS     !--> 
   
   
   
   
       
       
       
      
       
       
       
       
       
               
                        <?php
                         /*
                          * Averiguando que identidades son parte de un recibo
                          * de cobranza masiva
                          * $resumido=true: Quiere decir que debe de ersumirse 
                          * ya agrupase en un solo recibo
                          */
                        /* $array_depas=$dataProvider->query->select(['unidad_id'])->distinct()->column();
                          $array_depas=array_unique($array_depas);
                            $resumido=(count($array_depas)>1)?true:false;      
                               $grupos=VwSigiFacturecibo::find()->select(['codgrupo','desgrupo','count(codgrupo) as cant'])->andWhere(['>','montototal',0])->
                                   andWhere(['kardex_id'=>$detalle->kardex_id])->
                                    groupBy(['codgrupo','desgrupo'])->distinct()->asArray()->all();
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
                                   /* 'sum(monto) as monto','montototal','simbolo'])->andWhere(['kardex_id'=>$detalle->kardex_id])
                                    ->groupBy(['codgrupo','desgrupo','descargo','montototal','simbolo'])->asArray()->all();  
                                
                                  }
                                $vista=($compacto)?'modelo_compacto':'modelo_simple_complejo';
                               if($modelo->reporte_id==4)$vista='modelo_simple_complejo';
                               /* echo $this->render($vista,[
                                    'modelo'=>$model,
                                    'grupos'=>$grupos,
                                    'detalles'=>$detalles,
                                    'codmon'=>$detalle->codmon,
                                    ]);*/
                        
                         echo $this->render('modelo_simple_complejo',[
                                    'datos'=>$datos,
                                    'codmon'=>$detalle->codmon,
                                    ]);
                         ?>
               
             
   </body>
    </html>
    
