<?php
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use frontend\modules\sigi\models\SigiUnidadesSearch;
    use kartik\export\ExportMenu;

$gridColumns = [
  [
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{update}',
               'buttons' => [
                    'update' => function($url, $model) {  
                         $url = \yii\helpers\Url::to(['/sigi/unidades/update','id'=>$model->id]);
                         $options = [
                            //'title' => Yii::t('sta.labels', 'Editar'),
                            //'aria-label' => Yii::t('rbac-admin', 'Activate'),
                            //'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                            //'data-method' => 'get',
                            'data-pjax' => '0',
                             'target'=>'_blank'
                        ];
                        //return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['href' => $url, 'title' => 'Editar Adjunto', 'class' => ' btn btn-sm btn-success']);
                        return Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>',$url,$options);
                     
                        
                        },
                      
                        
                    ]
                ],
            [
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                            return GridView::ROW_COLLAPSED;
                                },
                     'detailUrl' =>Url::toRoute(['/sigi/edificios/ajax-show-unidad']),
                    //'headerOptions' => ['class' => 'kartik-sheet-style'], 
                    'expandOneOnly' => true
                ], 

[
    
    'attribute' => 'unidad_id',
    'format'=>'raw',
    'filter'=> \frontend\modules\sigi\helpers\comboHelper::getCboUnitsFacturadas($model->id),
    'value' => function ($model) {
            return $model->unidad->nombre;
    },
   
],
           
[
    
    'attribute' => 'monto',    
   
],
                 
 [
    
    'attribute' => 'numerorecibo',  
     
   
],
            
                 

];
 
 echo ExportMenu::widget([
    'dataProvider' => $dataProvider,
     'filename'=>'unidades',
     'exportConfig'=>[
         ExportMenu::FORMAT_EXCEL=>[
             'filename'=>'Exportacion'
               ],
         ExportMenu::FORMAT_EXCEL_X=>[
             'filename'=>'Exportacion'
               ]
         ],
    'columns' => $gridColumns,
    'dropdownOptions' => [
        'label' => yii::t('sta.labels','Exportar'),
        'class' => 'btn btn-success'
    ]
]) ?>
 
 <hr>
   <?php
   Pjax::begin(['id'=>'grilla-kardex']);
  echo GridView::widget([
   // 'id' => 'kv-grid-demo',
    'dataProvider' => $dataProvider,
      'filterModel' => $searchModel,
    'columns' => $gridColumns, // check the configuration for grid columns by clicking button above
    
    'pjax' => true, // pjax is set to always true for this demo
    // set your toolbar
   
  
   
    // parameters from the demo form
   /* 'bordered' => $bordered,
    'striped' => $striped,
    'condensed' => $condensed,
    'responsive' => $responsive,
    'hover' => $hover,
    'showPageSummary' => $pageSummary,*/
   
    
   
    
]);  

  
  
  Pjax::end();
  
?>
    
  



 