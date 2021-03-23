<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\sigi\models\SigiKardexdepaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Sigi Kardexdepas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sigi-kardexdepa-index">

    <h4><?= Html::encode($this->title) ?></h4>
<div class="box box-success">
  <div class="box-body">
       
        
    <?php Pjax::begin(['id'=>'searchKardex','timeout'=>false]); ?>
    <?=$this->render('_searchKardexPagos', ['model' => $searchModel]) ?>
 <hr/>
    
    
    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
         //'summary' => '',
        'showPageSummary' => true,
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
       // 'filterModel' => $searchModel,
        'columns' => [
            
         
         [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{recibo}',
                'buttons' => [
                    'update' => function($url, $model) { 
                        $url=Url::to(['update','id'=>$model->id]);
                        $options = [
                            'title' => Yii::t('base.verbs', 'Update'),                            
                        ];
                        return Html::a('<span class="btn btn-info btn-sm glyphicon glyphicon-pencil"></span>', $url, $options/*$options*/);
                         },
                        'recibo' => function ($url,$model) {
			   $url = \yii\helpers\Url::toRoute(['facturacion/recibo-by-kardex','id'=>$model->id]);
                              return \yii\helpers\Html::a('<span class="btn btn-warning glyphicon glyphicon-tags"></span>', '#', ['title'=>$url,'family'=>'holas','id'=>$model->id]);
                            }, 
                    ]
                ],
         
               /*[
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                            return GridView::ROW_COLLAPSED;
                                },
                'extraData'=>['identidad'=>function ($model) {
                            return $model->id;
                                }],
                     'detailUrl' =>Url::toRoute(['/sigi/kardexdepa/ajax-show-pagos']),
                    //'headerOptions' => ['class' => 'kartik-sheet-style'], 
                    'expandOneOnly' => true
                ], */
            /* ['attribute'=>'edificio_id',
               'filter'=> \frontend\modules\sigi\helpers\comboHelper::getCboEdificios(),
               'value'=>function($model){
                       return $model->codigo; 
               }
                 
                 ],*/
            'anio',
            'mes',
           // 'facturacion_id',
            //'operacion_id',
            //'edificio_id',
           // 'unidad_id',
           // 'mes',
            //'monto',
            //'anio',
            //'codmon',
            'numerorecibo',
             'nombre',
            ['attribute'=>'monto',
                'format' => ['decimal', 3],
                 'pageSummary' => true,
                'contentOptions'=>['align'=>'right'],
              'value'=>function($model){
                 return $model->monto;    
              }  
                ],
                        
                ['attribute'=>'deuda',
                'format' => ['decimal', 3],
                 'pageSummary' => true,
                'contentOptions'=>['align'=>'right'],
              'value'=>function($model){
                 return $model->deuda;    
              }  
                ],        
                        
                        
            
           // 'igv',
            //'detalles:ntext',

          
        ],
    ]); ?>
 <?php 
   echo linkAjaxGridWidget::widget([
           'id'=>'searchKardexdsd',
            'idGrilla'=>'searchKardex',
            'family'=>'holas',
          'type'=>'POST',
           'evento'=>'click',
       'posicion'=>\yii\web\View::POS_END,
            //'foreignskeys'=>[1,2,3],
        ]); 
   ?>
 
    <?php Pjax::end(); ?>
</div>
    </div>
</div>
    
       