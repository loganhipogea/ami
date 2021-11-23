<?php
use yii\helpers\Html;
use kartik\grid\GridView;
//use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\helpers\h;
use common\helpers\timeHelper;
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\HighchartsAsset;
use dosamigos\chartjs\ChartJs;
use lo\widgets\modal\ModalAjax;
?>
<div class="box box-body">
    <h4>Usted tiene una deuda de :  <?=h::formato()->asDecimal($deuda, 2)   ?></h4>
<?php


echo ModalAjax::widget([
    'id' => 'buscarvalor',
    'header' => 'Buscar Valor',
    'toggleButton' => false,
    //'mode'=>ModalAjax::MODE_MULTI,
    'size'=>\yii\bootstrap\Modal::SIZE_LARGE,    
    'selector'=>'.botonAbre',
   // 'url' => $url, // Ajax view with form to load
    'ajaxSubmit' => true, // Submit the contained form as ajax, true by default
    //para que no se esconda la ventana cuando presionas una tecla fuera del marco
    //'clientOptions' => ['tabindex'=>'','backdrop' => 'static', 'keyboard' => FALSE]
    // ... any other yii2 bootstrap modal option you need
]);
 
 Pjax::begin(['id'=>'grilla-recibos']); ?>
    
    <?php
      $showResumen=false;
            
      if(array_key_exists('SigiKardexdepaSearch', $params))
      if(array_key_exists('cancelado', $params['SigiKardexdepaSearch'])){
         if($params['SigiKardexdepaSearch']['cancelado']=='0') 
         $showResumen=true; 
      }
      
     $searchModel = new frontend\modules\sigi\models\SigiKardexdepaSearch();
     $dataProvider=$searchModel->searchByResi($unidad->id,$params);
    
    ?>
    
   <?php //var_dump((new SigiApoderadosSearch())->searchByEdificio($model->id)); die(); ?>
    <?= GridView::widget([
        'id'=>'migrilla',
        'dataProvider' =>$dataProvider, 
        /*\yii\data\ActiveDataProvider([
            'query'=> frontend\modules\sigi\models\SigiKardexdepa::find()->andWhere(['unidad_id'=>$unidad->id,'aprobado'=>'1','historico'=>'0']),
        ]),*/
         'summary' => '',
         'showPageSummary'=>$showResumen,
        'pageSummaryRowOptions'=>['style'=>'text-align:right'],
         'filterModel' => $searchModel,
         //'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'columns' => [
               /*[
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{recibo}{clip}',
                'buttons' => [
                     'view' => function($url, $model) { 
                           $url=Url::to(['/sigi/kardexdepa/view','id'=>$model->id]);
                             $options=['data-pjax'=>'0','target'=>'_blank'];
                          return Html::a('<span class="btn btn-danger glyphicon glyphicon-eye-open"></span>',$url,$options);
                       
                         },
                         'clip' => function($url, $model) { 
                            
                             if($model->countFiles()>=1){
                                  $url=\yii\helpers\Url::toRoute(
                                          ['/finder/selectimage','isImage'=>true,
                             'idModal'=>'imagemodal',
                             'modelid'=>$model->id,
                             'extension'=> \yii\helpers\Json::encode(['jpg','png','jpeg','pdf']),
                             'nombreclase'=> str_replace('\\','_',get_class($model))
                                       ]);
                                 $options = [
                           'class'=>'botonAbre btn btn-warning',
                           
                         ];
                          return Html::a('<span class=" fa fa-paperclip" ></span>Adjuntar voucher',$url,$options);
                       
                             }else{
                                 return '';
                             }
                       
                         }        
                      
                    ]
                ],*/
             
            
             [
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                            return GridView::ROW_COLLAPSED;
                                },
                 'detailUrl' =>Url::toRoute(['/sigi/default/ajax-show-recibo']),
                    //'headerOptions' => ['class' => 'kartik-sheet-style'], 
                    'expandOneOnly' => true
                ],
              ['attribute'=>'cancelado',
                'format' => 'raw',
                'filter'=> ['1'=>'Cancelado','0'=>'Pendiente'],
                 'value' => function ($model) {
                    return \yii\helpers\Html::checkbox('cancelado[]', $model->cancelado, [ 'disabled' => true]);

                            },
             ],
            'fecha',
             ['attribute'=>'mes',
                 'format'=>'raw',
                'filter'=> timeHelper::cboMeses(),
                'value'=>function($model){
                     if($model->hasAttachments())
                       return Html::a(timeHelper::mes($model->mes),$model->files[0]->url,['data-pjax'=>'0']); 
                        return timeHelper::mes($model->mes); 
                } 
             ],   
              // 'nombre',   
           
            ['attribute'=>'monto',
                'header'=>'Monto Fact',
                'format' => ['decimal', 2],
                'pageSummary' => true,
                'contentOptions'=>['align'=>'right'],  
             ],
            ['attribute'=>'monto',
                'header'=>'Deuda',
                'format' => ['decimal', 2],
                'pageSummary' => true,
                'contentOptions'=>['align'=>'right'],  
             ],
              //'monto',       
                     
             /* 'descripcion', [
    'attribute' => 'activo',
    'format' => 'raw',
    'value' => function ($model) {
        return \yii\helpers\Html::checkbox('activo[]', $model->activo, [ 'disabled' => true]);

             },
          ],*/
        ],
    ]); 
             
    Pjax::end();         ?>



</div>