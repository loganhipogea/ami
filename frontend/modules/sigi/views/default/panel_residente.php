<?php
use yii\helpers\Html;
use kartik\grid\GridView;
//use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\helpers\timeHelper;
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\HighchartsAsset;
use dosamigos\chartjs\ChartJs;
?>
<div class="box box-body">
    <h4>Recibos emitidos</h4>
<?php
 Pjax::begin(['id'=>'grilla-recibos']); ?>
    
   <?php //var_dump((new SigiApoderadosSearch())->searchByEdificio($model->id)); die(); ?>
    <?= GridView::widget([
        'id'=>'migrilla',
        'dataProvider' =>NEW 
        \yii\data\ActiveDataProvider([
            'query'=> frontend\modules\sigi\models\SigiKardexdepa::find()->andWhere(['unidad_id'=>$unidad->id]),
        ]),
         'summary' => '',
         //'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'columns' => [
               [
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
                ],
             
            
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
            'fecha',
             ['attribute'=>'mes',
                'value'=>function($model){
                   return timeHelper::mes($model->mes);            
                } 
             ],   
              // 'nombre',   
           
            /*['attribute'=>'montodepa',
                'header'=>'Monto',
                'format' => ['decimal', 3],
                'contentOptions'=>['align'=>'right'],  
             ],*/
              'monto',       
                     
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
    <br>
    <h4>Deudas pendientes</h4>
<?php
 Pjax::begin(['id'=>'grilla-deudas']); ?>
    <?php //echo $unidad->misDeudasProvider()->query->createCommand()->rawSql; die();  ?>
   <?php //var_dump((new SigiApoderadosSearch())->searchByEdificio($model->id)); die(); ?>
    <?= GridView::widget([
        'id'=>'migrilla',
        'dataProvider' =>$unidad->misDeudasProvider(),
         'summary' => '',
         //'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'columns' => [
             
             
            'nombre',
            
                /*[
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                            return GridView::ROW_COLLAPSED;
                                },
                            'detail' => function ($model, $key, $index, $column) {
                            return Yii::$app->controller->renderPartial('_detalle_fact_residente', ['kardex_id' => $model->id]);
                            },
                    //'headerOptions' => ['class' => 'kartik-sheet-style'], 
                    'expandOneOnly' => true
                ],*/
            'fecha',
             ['attribute'=>'mes',
                'value'=>function($model){
                   return timeHelper::mes($model->mes);            
                } 
             ],   
              // 'nombre',   
           
            /*['attribute'=>'montodepa',
                'header'=>'Monto',
                'format' => ['decimal', 3],
                'contentOptions'=>['align'=>'right'],  
             ],*/
              'deuda',       
                     
             /* 'descripcion', [
    'attribute' => 'activo',
    'format' => 'raw',
    'value' => function ($model) {
        return \yii\helpers\Html::checkbox('activo[]', $model->activo, [ 'disabled' => true]);

             },
          ],*/
        ],
    ]); ?>
    
    <?php 
    $string1="var v_grid = $('#migrilla');
     v_grid.on('kvexprow:beforeLoad', function (event, ind, key, extra) {
          // alert(key);
               Vurl='".Url::to(['/sigi/kardexdepa/ajax-crea-mov','id'=>'parex456'])."';
                Vurl=Vurl.replace('parex456',key);    
       $.ajax({
              url:Vurl, 
              type: 'get',
              data:{},
              //dataType: 'json', 
              error:  function(xhr, textStatus, error){               
                            var n = Noty('id');                      
                              $.noty.setText(n.options.id, error);
                              $.noty.setType(n.options.id, 'error');       
                                }, 
              success: function(data) {
              //alert(data);
                 
                           
                   
                        }
                        });
        


});";
  $this->registerJs($string1, \yii\web\View::POS_END);
       ?>  
    
    
    <?php 
    $string2="var v_grid = $('#migrilla');
     v_grid.on('kvexprow:kvexprow:loaded', function (event, ind, key, extra) {
        onsole.log('After ajax load completed.'+key);
$.pjax.reload({container: '#grilla-deudas-pagos-'+key});

            });";
  $this->registerJs($string2, \yii\web\View::POS_END);
       ?>  
    
    <?php Pjax::end(); ?>
   <?php
   if(!is_null($medidor)){
   $lecturas=$medidor->lastReads(true);
   
   
   ?>
    <h4>Consumo de agua potable</h4>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

 <?php echo  ChartJs::widget([
    'type' => 'bar',
    'options' => [
        'height' => 350,
       // 'width' => 100%
       
    ],
    'data' => [
        'labels' =>array_keys($lecturas),
        'datasets' => [
            [
                'label' => yii::t('sta.labels',"Consumo (m3)"),
                'backgroundColor' => "rgba(255,157,64,0.9)",
                'borderColor' => "rgba(60,117,9,1)",
                'pointBackgroundColor' => "rgba(179,181,198,1)",
                'pointBorderColor' => "#fff",
                'pointHoverBackgroundColor' => "#fff",
                'pointHoverBorderColor' => "rgba(179,181,198,1)",
                'data' => array_values($lecturas),
                'ticks'=> [
                    'fontColor'=>'#000',
                    'fontStyle'=> 'normal',
                    'fontSize'=> 13,
                   
                ],
            ],
           
        ]
    ]
]);
?>
</div>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <?php /*
   $lecturas=$medidor->lastReads(true);
    HighchartsAsset::register($this)->withScripts(['highcharts-more']);

    echo Highcharts::widget([
   'options' => [
       'chart'=>[
                'type'=>'gauge',
                'plotBackgroundColor'=> null,
                'plotBackgroundImage'=> null,
                'plotBorderWidth'=> 0,
                'plotShadow'=> false
                 ],
      'title' => ['text' => 'Flujómetro'],
       'pane'=>[
                'startAngle'=> -150,
                'endAngle'=> 150,
                'background'=> [
                                [
                        'backgroundColor'=>[
                                        'linearGradient'=>[ 'x1'=> 0, 'y1'=> 0, 'x2'=>0, 'y2'=>1 ],
                                        'stops'=> [
                                            [0, '#FFF'],
                                            [1, '#333']
                                                    ]
                                            ],
                            'borderWidth'=> 0,
                            'outerRadius'=> '109%'
                                    ],
                            [
                            'backgroundColor'=>[
                                            'linearGradient'=>[ 'x1'=> 0, 'y1'=> 0, 'x2'=>0, 'y2'=>1 ],
                                            'stops'=> [
                                                    [0, '#333'],
                                                    [1, '#FFF']
                                                    ]
                                                ],
                                        'borderWidth'=>1,
                                        'outerRadius'=> '107%'
                            ], 
                    [
            // default background
                    ], [
            'backgroundColor'=> '#DDD',
            'borderWidth'=> 0,
            'outerRadius'=> '105%',
            'innerRadius'=> '103%'
                            ]
           ]
       ],
       
      'yAxis'=>[
        'min'=> 0,
        'max'=> 60,

        'minorTickInterval'=> 'auto',
        'minorTickWidth'=> 1,
        'minorTickLength'=> 10,
        'minorTickPosition'=>'inside',
        'minorTickColor'=> '#666',

        'tickPixelInterval'=> 30,
        'tickWidth'=>2,
        'tickPosition'=>'inside',
        'tickLength'=> 10,
        'tickColor'=> '#666',
        'labels'=> [
            'step'=> 2,
            'rotation'=> 'auto'
        ],
        'title'=> [
            'text'=> 'm3'
        ],
        'plotBands'=> [[
            'from'=> 0,
            'to'=> 20,
            'color'=> '#55BF3B' // green
        ], [
            'from'=> 20,
            'to'=> 40,
            'color'=> '#DDDF0D' // yellow
        ], [
            'from'=> 40,
            'to'=> 60,
            'color'=> '#DF5353' // red
        ]]
    ],
     
     'series'=> [[
        'name'=> 'Consumo de Agua',
        'data'=> [end($lecturas)+0],
        'tooltip'=> [
            'valueSuffix'=> ' m3'
        ]
    ]]  
       
     
   ]
]);
*/
Pjax::begin(['id'=>'grilla-deudasvfg']); 
    
 echo \kartik\grid\GridView::widget([
        'id'=>'migrillaxc',
        'dataProvider' =>NEW 
        \yii\data\ActiveDataProvider([
            'query'=>$medidor->getLecturas(),
        ]),
    
         'summary' => '',
         //'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'columns' => [
               
             [
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                            return \kartik\grid\GridView::ROW_COLLAPSED;
                                },
                'extraData'=>['identidad'=>function ($model) {
                            return $model->id;
                                }],
                     'detailUrl' =>Url::toRoute(['/sigi/default/ajax-show-lectura']),
                    //'headerOptions' => ['class' => 'kartik-sheet-style'], 
                    'expandOneOnly' => true
                ],
                /*[
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                            return GridView::ROW_COLLAPSED;
                                },
                            'detail' => function ($model, $key, $index, $column) {
                            return Yii::$app->controller->renderPartial('_detalle_fact_residente', ['kardex_id' => $model->id]);
                            },
                    //'headerOptions' => ['class' => 'kartik-sheet-style'], 
                    'expandOneOnly' => true
                ],*/
            //'fecha',
             ['attribute'=>'mes',
                'value'=>function($model){
                   return timeHelper::mes($model->mes);            
                } 
             ],
                     
              // 'nombre',   
           
            /*['attribute'=>'montodepa',
                'header'=>'Monto',
                'format' => ['decimal', 3],
                'contentOptions'=>['align'=>'right'],  
             ],*/
              'flectura', 
              'lectura',
              'delta'
                     
             /* 'descripcion', [
    'attribute' => 'activo',
    'format' => 'raw',
    'value' => function ($model) {
        return \yii\helpers\Html::checkbox('activo[]', $model->activo, [ 'disabled' => true]);

             },
          ],*/
        ],
    ]);
     Pjax::end();        
             ?>
    
   <?php }   ?>
</div>


</div>