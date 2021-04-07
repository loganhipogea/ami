<?php  
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
use kartik\grid\GridView;
?>
<div style='overflow:auto;'>
   <?php 
    
   ////$dataTutores= comboHelper::getCboTutoresByProg($model->id);
   //print_r($dataTutores);die();
   $gridColumns = [
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}{attach}',
                'buttons' => [
                          'attach' => function($url, $model) {  
                         $url=\yii\helpers\Url::toRoute(['/finder/selectimage','isImage'=>true,
                             'idModal'=>'imagemodal',
                             'modelid'=>$model->id,
                             'extension'=> \yii\helpers\Json::encode(['jpg','png','jpeg']),
                             'nombreclase'=> str_replace('\\','_',get_class($model))]);
                        $options = [
                            'title' => Yii::t('sta.labels', 'Subir Archivo'),
                            'data-method' => 'get',
                            //'data-pjax' => '0',
                        ];
                        return Html::button('<span class="glyphicon glyphicon-paperclip"></span>', ['href' => $url, 'title' => 'Adjuntar Voucher de pago', 'class' => 'botonAbre btn btn-success']);
                        //return Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', Url::toRoute(['view-profile','iduser'=>$model->id]), []/*$options*/);
                        },
                        'update' => function($url, $model) {  
                       $url= Url::to(['/sigi/unidades/edita-lectura','id'=>$model->id,'gridName'=>'grilla_lecturas','idModal'=>'buscarvalor']);
                         $options = [
                           'class'=>'botonAbre',
                            //'title' => Yii::t('sta.labels', 'Editar'),
                            //'aria-label' => Yii::t('rbac-admin', 'Activate'),
                            //'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                            //'data-method' => 'get',
                           // 'data-pjax' => '0',
                             //'target'=>'_blank'
                        ];
                        //return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['href' => $url, 'title' => 'Editar Adjunto', 'class' => ' btn btn-sm btn-success']);
                       
                         return Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>',$url,$options);
                     
                        
                        },
                                 'delete' => function ($url,$model) {
			   $url = \yii\helpers\Url::toRoute($this->context->id.'/deletemodel-for-ajax');
                           if(!$model->isInFacturacion())
                              return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['title'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                           return '';
                            },
                    ]
                ],
        [
   
    
],                    
                            
[  'attribute' => 'flectura',
    'format'=>'raw',
    'value' => function ($model, $key, $index, $column) {
                    return $model->flectura;
                        }
],
 [  'attribute' => 'lectura',
    'format'=>'raw',
    'value' => function ($model, $key, $index, $column) {
                    return $model->lectura;
                        }
],
[  'attribute' => 'delta',
],
[  'attribute' => 'lecturaant', 
],         
[  'attribute' => 'mes',
],
[  'attribute' => 'anio', 
], 
[
 'attribute' => 'facturable',
'format' => 'raw',
 'value' => function ($model) {
return \yii\helpers\Html::checkbox('facturable[]', $model->facturable, [ 'disabled' => true]);
 },
],

];
   
   
   
   
   ?>
    <?php Pjax::begin(['id'=>'grilla-lecturas','timeout'=>false]); ?>
    
        <?php  
       
        echo GridView::widget([
             'id' => 'kv-grid-demo',
        'dataProvider' => $dataProvider,
         //'summary' => '',
        // 'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
       // 'filterModel' => $searchModel,
        'columns' => $gridColumns,
           //  'pjax' => true, // pjax is set to always true for this demo
            //'toggleDataContainer' => ['class' => 'btn-group mr-2'],
           /* 'panel' => [
        'type' => GridView::TYPE_WARNING,
        //'heading' => $heading,
    ],*/
    
    ]);
        //Pjax::end();
        ?>
        <?php 
   echo linkAjaxGridWidget::widget([
           'id'=>'widgetgruidBancos',
            'idGrilla'=>'grilla-lecturas',
            'family'=>'holas',
          'type'=>'POST',
           'evento'=>'click',
           'posicion'=> \yii\web\View::POS_END,
            //'foreignskeys'=>[1,2,3],
        ]); ?>
    <?php Pjax::end(); ?>
    </div>
