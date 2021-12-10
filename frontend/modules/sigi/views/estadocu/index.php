<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\helpers\h;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\sigi\models\SigiEstadocuentasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Estado de cuentas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sigi-estadocuentas-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <div class="box box-success">
     <div class="box-body">
    <?php Pjax::begin(); ?>
    <?php
    $formato=h::formato();
// echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Crear registro'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div style='overflow:auto;'>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'filterModel' => $searchModel,
        'columns' => [
            
         
         [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{view}',
                'buttons' => [
                    'update' => function($url, $model) {                        
                        $options = [
                            'title' => Yii::t('base.verbs', 'Update'),                            
                        ];
                        return Html::a('<span class="btn btn-info btn-sm glyphicon glyphicon-pencil"></span>', $url, $options/*$options*/);
                         },
                          'view' => function($url, $model) {                        
                        $options = [
                            'title' => Yii::t('base.verbs', 'View'),                            
                        ];
                        return Html::a('<span class="btn btn-warning btn-sm glyphicon glyphicon-search"></span>', $url, $options/*$options*/);
                         },
                         
                    ]
                ],
         
         
         
         
         

           
              ['attribute'=>'edificio_id',
                  'filter'=> \frontend\modules\sigi\helpers\comboHelper::getCboEdificios(),
                  'value'=>function($model){
                              return  $model->edificio->codigo;
                           }  
                  ],           
           ['attribute'=>'mes',
                  'filter'=> common\helpers\timeHelper::cboMeses(),                          
                  'value'=>function($model){
                              return  common\helpers\timeHelper::mes($model->mes+0);
                           }  
                  ],
            'anio',
            ['attribute'=>'saldmesant',
                'contentOptions'=>['style'=>'text-align:right;'],
                  'value'=>function($model) use($formato){
                              return $formato->asDecimal($model->saldmesant);
                           }  
                  ],
            ['attribute'=>'ingresos',
                'contentOptions'=>['style'=>'text-align:right;'],
                  'value'=>function($model) use($formato){
                              return $formato->asDecimal($model->ingresos);
                           }  
                  ],
            ['attribute'=>'egresos',
                'contentOptions'=>['style'=>'text-align:right;'],
                  'value'=>function($model) use($formato){
                              return $formato->asDecimal($model->egresos);
                           }  
                  ],
            ['attribute'=>'saldfinal',
                'contentOptions'=>['style'=>'text-align:right;'],
                  'value'=>function($model) use($formato){
                              return $formato->asDecimal($model->saldfinal);
                           }  
                  ],
           ['attribute'=>'saldecuenta',
                'contentOptions'=>['style'=>'text-align:right;'],
                  'value'=>function($model) use($formato){
                              return $formato->asDecimal($model->saldecuenta);
                           }  
                  ],
           
            ['attribute'=>'salddif',
                'contentOptions'=>['style'=>'text-align:right;'],
                  'value'=>function($model) use($formato){
                              return $formato->asDecimal($model->salddif);
                           }  
                  ],
            //'mes',
            //'anio',

          
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
    </div>
</div>
    </div>
       