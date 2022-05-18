<?php
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\helpers\Html;
?>
<div style='overflow:auto;'>
     <?php Pjax::begin(['id'=>'pjax-cuadrilla','timeout'=>false]); ?>
    <?= GridView::widget([
        'id'=>'grilla-os',
                'dataProvider' =>$dataProviderCuadrilla,
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        //'filterModel' => New \frontend\modules\op\models\OpOsSearch(),
        'columns' => [
            
          [                    
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{edit}{delete}{attach}',
               'buttons' => [
                    'attach' => function($url, $model) {  
                         $url=\yii\helpers\Url::toRoute(['/finder/selectimage','isImage'=>false,'idModal'=>'imagemodal','modelid'=>$model->id,'nombreclase'=> str_replace('\\','_',get_class($model))]);
                        $options = [
                            'title' => Yii::t('sta.labels', 'Colocar en el maletín'),
                            //'aria-label' => Yii::t('rbac-admin', 'Activate'),
                            //'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                            'data-method' => 'get',
                            //'data-pjax' => '0',
                        ];
                        return Html::button('<span class="glyphicon glyphicon-paperclip"></span>', ['href' => $url, 'title' => 'Editar Adjunto', 'class' => 'botonAbre btn btn-success']);
                        //return Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', Url::toRoute(['view-profile','iduser'=>$model->id]), []/*$options*/);
                     
                        
                        },
                                
                                'edit' => function ($url,$model) {
			    $url= Url::to(['/op/tareo/modal-edita-persona','id'=>$model->id,'gridName'=>'pjax-det','idModal'=>'buscarvalor']);
                              return \yii\helpers\Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>'0','class'=>'botonAbre']);
                            },
                        'delete' => function ($url,$model) {
                              
                                $url = \yii\helpers\Url::to([$this->context->id.'/deletemodel-for-ajax','id'=>$model->id]);                              
                                    return \yii\helpers\Html::a('<span class="btn btn-primary glyphicon glyphicon-trash"></span>', '#', ['title'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                             
                              
			    },
                        'attach' => function($url, $model) {  
                          $url=\yii\helpers\Url::toRoute(['/op/proc/modal-agrega-doc','id'=>$model->id,'gridName'=>'pjax-det','idModal'=>'buscarvalor']);
                        $options = [
                            'title' => Yii::t('sta.labels', 'Subir Archivo'),
                            //'aria-label' => Yii::t('rbac-admin', 'Activate'),
                            //'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                            'data-method' => 'get',
                            //'data-pjax' => '0',
                        ];
                        return Html::button('<span class="glyphicon glyphicon-paperclip"></span>', ['href' => $url, 'title' => 'Editar Adjunto', 'class' => 'botonAbre btn btn-success']);
                        //return Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', Url::toRoute(['view-profile','iduser'=>$model->id]), []/*$options*/);
                     
                        
                        },
                    ]
                ],
        [
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                            return GridView::ROW_COLLAPSED;
                                },
                     'detailUrl' =>Url::toRoute(['/op/proc/ajax-expand-opera']),
                    //'headerOptions' => ['class' => 'kartik-sheet-style'], 
                    'expandOneOnly' => true
                ], 
         ['attribute' => 'hinicio',
                'format'=>'raw',
                'value'=>function($model){
                        return $model->hinicio;                        
                             } 
                
                ],
                         ['attribute' => 'codtra',
                'format'=>'raw',
                'value'=>function($model){
                        return $model->codtra;                        
                             } 
                
                ],
         
                 ['attribute' => 'codtra',
                'format'=>'raw',
                'value'=>function($model){
                        return $model->trabajador->fullName();                        
                             } 
                
                ],          
           
        ],
    ]); ?>
    <?php
      $url= Url::to(['modal-agrega-persona','id'=>$model->id,'gridName'=>'pjax-cuadrilla','idModal'=>'buscarvalor']);
   echo  Html::button(yii::t('base.verbs','Agregar trabajador'), 
           ['href' => $url, 'title' => yii::t('sta.labels','Agregar trabajador'),
               'id'=>'btn_cuentas_edi_df',
               'class' => 'botonAbre btn btn-primary'
               ]); 
    ?>
   <?php Pjax::end(); ?>
    
</div>
