<?php
use yii\helpers\Html;
//use kartik\grid\GridView;
use yii\grid\GridView;
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
        'dataProvider' =>new \yii\data\ActiveDataProvider([
            'query'=> frontend\modules\sigi\models\VwSigiKardexdepa::find()->andWhere(['unidad_id'=>$unidad->id])
        ]),
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'columns' => [
                  [
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{attach}{pdf}',
               'buttons' => [
                  'attach' => function($url, $model) {  
                         $url=\yii\helpers\Url::toRoute(['/finder/selectimage','isImage'=>false,
                             'idModal'=>'imagemodal',
                             'modelid'=>$model->id,
                             'extension'=> \yii\helpers\Json::encode(['jpg','png','pdf','jpeg']),
                             'nombreclase'=> str_replace('\\','_',get_class($model->kardexDepa))]);
                        $options = [
                            'title' => Yii::t('sta.labels', 'Subir Archivo'),
                            'data-method' => 'get',
                            //'data-pjax' => '0',
                        ];
                        return Html::button('<span class="glyphicon glyphicon-paperclip"></span>', ['href' => $url, 'title' => 'Adjuntar Voucher de pago', 'class' => 'botonAbre btn btn-success']);
                        //return Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', Url::toRoute(['view-profile','iduser'=>$model->id]), []/*$options*/);
                        },
                        
                        
                       /* 'pdf' => function ($url,$model) {
			   $url = \yii\helpers\Url::toRoute(['/sta/citas/report-inf-psicologico','id'=>$model->id,'gridName'=>'grid_docu','idModal'=>'buscarvalor']);
                              if($model->cita_id > 0 or $model->codocu=='104')
                              return \yii\helpers\Html::a('<span class="btn btn-warning fa fa-file-pdf"></span>', $url, ['data-pjax'=>'0','target'=>'_blank']);
                              return '';
                             } */
                    ]
                ],
            
             [
                'attribute'=>'recibo',
                 'format'=>'raw',
                  'value' => function ($model) {
                    $url=Url::to(['/report/make/creareporte/','id'=>2,'idfiltro'=>$model->identidad]);
                            return Html::a('<span class="fa fa-file-pdf" ></span>'.'  '.yii::t('sta.labels',''),$url,['data-pjax'=>'0','target'=>'_blank','class'=>"btn btn-success"]) ;
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
           'numero',
            ['attribute'=>'montodepa',
                'header'=>'Monto',
                'format' => ['decimal', 3],
                'contentOptions'=>['align'=>'right'],  
             ]
             /* 'descripcion', [
    'attribute' => 'activo',
    'format' => 'raw',
    'value' => function ($model) {
        return \yii\helpers\Html::checkbox('activo[]', $model->activo, [ 'disabled' => true]);

             },
          ],*/
        ],
    ]); ?>
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