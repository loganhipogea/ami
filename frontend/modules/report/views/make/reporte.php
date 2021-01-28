<?php  use yii\grid\GridView;?>

   <?=$contenidoSinGrilla?>
         <div style="position:absolute; width:90%; left:<?php echo $modelo->x_grilla; ?>px; top:<?php echo $modelo->y_grilla; ?>px">
             <?php
                //yii::error($modelo->vistaalterna);
                    if(!empty($modelo->vistaalterna)) { ?>
                        
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
                                $grupos=$dataProvider->query->select(['codgrupo','desgrupo'])->andWhere(['>','montototal',0])->
                                   distinct()->asArray()->all();
                                if(!$resumido){
                                   $detalles=$dataProvider->query->select(['codgrupo',
                                    'desgrupo',
                                    'descargo','codsuministro','unidades','lanterior','lectura','delta',
                                    'monto','montototal','simbolo'])
                                    ->asArray()->all(); 
                                }else{
                                 
                                   $detalles=$dataProvider->query->select(['codgrupo',
                                    'desgrupo',
                                    'descargo','codsuministro','unidades','lanterior','lectura','delta',
                                    'sum(monto) as monto','montototal','simbolo'])
                                    ->groupBy(['codgrupo','desgrupo','descargo','montototal','simbolo'])->asArray()->all();  
                                
                                   // yii::error('Es resumido',__FUNCTION__);
                                   // yii::error($detalles[0]['monto'],__FUNCTION__);
                                }
                                
                                echo $this->render($modelo->vistaalterna,[
                                    'modelo'=>$modelo,
                                    'grupos'=>$grupos,
                                    'detalles'=>$detalles,
                                    ]);
                         
                         ?>
                      
                     <?php    //$this->render($modelo->vistaalterna);
                     /*$grupos=$dataProvider->query->select(['desgrupo'])
                      ->distinct()->asArray()->all();
                     foreach($grupos as $filaGrupo){
                         echo $filaGrupo['desgrupo']."<BR>";
                     }*/
             ?>
<?php }else {    ?> 
            <?php 
                    yii::error(' este render NO ES DE LA VISTA ALTERNA ');
                 ?>
  <?php 
if(count($columnas)>0)
echo GridView::widget([
        'id'=>'detallerepoGrid',
     'showFooter' => true,
    'summary' => '',
    //'showPageSummary' => true,
    //'striped' => true,
    'emptyCell'=>'',
    // 'showFooter' => true,
         // 'tableOptions'=>['class'=>'table no-margin'],
               'dataProvider' => $dataProvider,        
        'columns' =>$columnas ,
    // 'pager' => ['options'=>['visible'=>false]],
        ]
    );  ?>




<?php }?>

</div>