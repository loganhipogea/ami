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
    <h4>Deudas pendientes</h4>
<?php
 Pjax::begin(['id'=>'grilla-deudas']); ?>
    
   <?php //var_dump((new SigiApoderadosSearch())->searchByEdificio($model->id)); die(); ?>
    <?= GridView::widget([
        'id'=>'migrilla',
        'dataProvider' =>new \yii\data\ActiveDataProvider([
            'query'=> frontend\modules\sigi\models\SigiKardexdepa::find()->andWhere(['unidad_id'=>$unidad->id,'cancelado'=>'0'])
        ]),
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'columns' => [
                 /* [
                'class' => 'yii\grid\ActionColumn',
                 'template' => '{attach}{pdf}',
               'buttons' => [
                    ]
                ],*/
                                
                [
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                            return GridView::ROW_COLLAPSED;
                                },
                     'detailUrl' =>Url::toRoute(['/sigi/default/ajax-show-pagos']),
                    //'headerOptions' => ['class' => 'kartik-sheet-style'], 
                    'expandOneOnly' => true
                ],                  
            
             [
                'attribute'=>'recibo',
                 'format'=>'raw',
                  'value' => function ($model) {
                        if($model->hasAttachments()){
                          // $url=Url::to([]);
                            return Html::a('<span class="fa fa-download" ></span>'.'  '.yii::t('sta.labels',''),$model->files[0]->url,['data-pjax'=>'0','class'=>"btn btn-success"]) ;
                                 
                        }else{
                            return '';
                        }
                    },
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
            'fecha',
             ['attribute'=>'mes',
                'value'=>function($model){
                   return timeHelper::mes($model->mes);            
                } 
             ],   
              // 'nombre',   
           'unidad.numero',
            /*['attribute'=>'montodepa',
                'header'=>'Monto',
                'format' => ['decimal', 3],
                'contentOptions'=>['align'=>'right'],  
             ],*/
              [
                'attribute'=>'montodepa',
                 'format'=>'raw',
                  'header'=>'Monto',
                'format' => ['decimal', 3],
                'contentOptions'=>['align'=>'right'], 
                  'value' => function ($model) {
                       return $model->montoCalculado();
                    },
                ],       
                     
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
<h4>Consumo de agua</h4>
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
    <?php
   $lecturas=$medidor->lastReads(true);
   //var_dump(end($lecturas));die();
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


?>
</div>

<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">

    <?php
   
//echo end(array_values($medidor->lastReads(true)))."<br><br>";
//print_r(array_values($medidor->lastReads(true)));die();
//var_dump($model->lastReads(true));die();
?>
 <?= ChartJs::widget([
    'type' => 'bar',
    'options' => [
        'height' => 330,
        'width' => 400,
       
    ],
    'data' => [
        'labels' =>array_keys($lecturas),
        'datasets' => [
            [
                'label' => yii::t('sta.labels',"Del mes"),
                'backgroundColor' => "rgba(255,157,64,0.9)",
                'borderColor' => "rgba(60,117,9,1)",
                'pointBackgroundColor' => "rgba(179,181,198,1)",
                'pointBorderColor' => "#fff",
                'pointHoverBackgroundColor' => "#fff",
                'pointHoverBorderColor' => "rgba(179,181,198,1)",
                'data' => array_values($lecturas),
            ],
           
        ]
    ]
]);
?>
</div>
</div>