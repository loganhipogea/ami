<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
use kartik\export\ExportMenu;
/* @var $searchModel frontend\modules\sigi\models\SigiKardexdepaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Recibos emitidos');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="sigi-kardexdepa-index">

    <h4><?= Html::encode($this->title) ?></h4>
<div class="box box-success">
  <div class="box-body">
       
        
    <?php Pjax::begin(['id'=>'searchKardex','timeout'=>false]); ?>
    <?=$this->render('_searchKardex', ['model' => $searchModel]) ?>
 <hr/>
    
    
    <?php 
    
    $gridColumns=[
            
         
         [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{recibo}{clip}',
                'buttons' => [
                    'update' => function($url, $model) { 
                        $url=Url::to(['update','id'=>$model->id]);
                        $options = [
                            'data-pjax'=>'0',
                            'title' => Yii::t('base.verbs', 'Update'), 
                            'target'=>'_blank'
                        ];
                        return Html::a('<span class="btn btn-info btn-sm glyphicon glyphicon-pencil"></span>', $url, $options/*$options*/);
                         },
                                 
                         'clip' => function($url, $model) { 
                             $modelKardex=$model->kardexDepa;
                             if($model->aprobado && $modelKardex->hasAttachments() ){
                               $url= Url::to([
                                   '/finder/renderpdf',
                                   'idFile'=>\yii\helpers\Json::encode($modelKardex->files[0]->id),
                                 //  'nombreclase'=>str_replace('@','\\',get_class($modelKardex)),
                                   'idModal'=>'buscarvalor']);
                                 $options = [
                           'class'=>'botonAbre',
                           
                         ];
                          return Html::a('<span class="btn btn-danger glyphicon glyphicon-eye-open"></span>',$url,$options);
                       
                             }else{
                                 return '';
                             }
                       
                         }        
                                 ,
                        'recibo' => function ($url,$model) {
			   $url = \yii\helpers\Url::toRoute(['facturacion/recibo-by-kardex','id'=>$model->id]);
                              return \yii\helpers\Html::a('<span class="btn btn-warning glyphicon glyphicon-cog"></span>', '#', ['title'=>$url,'family'=>'holas','id'=>$model->id]);
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
                     'expandOneOnly' => true
                ], */
             ['attribute'=>'edificio_id',
               'filter'=> \frontend\modules\sigi\helpers\comboHelper::getCboEdificios(),
               'value'=>function($model){
                       return $model->edificio->codigo; 
               }
                 
                 ],
            //'numero',
            ['attribute'=>'mes',
               'filter'=> \common\helpers\timeHelper::cboMeses(),
               'value'=>function($model){
                       return \common\helpers\timeHelper::mes($model->mes); 
               }
                 
                 ],
            'nombre',
           // 'facturacion_id',
            //'operacion_id',
            //'edificio_id',
           // 'unidad_id',
           // 'mes',
            'fecha',
            //'anio',
            //'codmon',
           // 'numrecibo',
                       //  'cancelado',
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

          
        ];
    
    echo ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
    'dropdownOptions' => [
        'label' => yii::t('sta.labels','Exportar'),
        'class' => 'btn btn-success'
    ]
]) . "<br><hr>\n". GridView::widget([
        'dataProvider' => $dataProvider,
         //'summary' => '',
        'showPageSummary' => true,
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
       // 'filterModel' => $searchModel,
        'columns' =>$gridColumns, 
    ]); ?>
 <?php //common\helpers\FileHelper::clearTempWeb();?>
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
    
       