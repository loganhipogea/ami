<?php
use yii\helpers\Html;
use common\helpers\h;
 use yii\helpers\Url;
 use yii\widgets\Pjax;
use yii\grid\GridView;
use frontend\modules\op\helpers\ComboHelper;
?>
<div class="box-body">
    <br>
   
 
        
    <?php Pjax::begin(['id'=>'pjax-expand','timeout'=>false]); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
    </div>
    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php $form = \yii\widgets\ActiveForm::begin([
        'id'=>'myformulario',
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
        <?= $form->field($model, 'detalle')->textArea(['disabled'=>true,]) ?> 
        
        <?php \yii\widgets\ActiveForm::end();
     ?> 
        
    </div>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
    <p class="text-fuchsia"><i style="font-size:1.5em; font-weight:600"><span class="fa fa-list-ol" ></span><?=Yii::t('sta.labels', 'Documentos anexados')?></p></i>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
    <div style='overflow:auto;'>
    <?= GridView::widget([
        'id'=>'grilla-documentos',
                'dataProvider' =>$dataprovider,
         //'filterModel' => $searchModel,
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        //'filterModel' => New \frontend\modules\op\models\OpOsSearch(),
        'columns' => [
            
          [
                    
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{attach}{edit}{delete}',
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
			    $url= Url::to(['/op/proc/mod-edit-osdet','id'=>$model->id,'gridName'=>'pjax-detmat','idModal'=>'buscarvalor']);
                              return \yii\helpers\Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>'0','class'=>'botonAbre']);
                            },
                        'delete' => function ($url,$model) {
                              
                                $url = \yii\helpers\Url::to([$this->context->id.'/deletemodel-for-ajax','id'=>$model->id]);                              
                                    return \yii\helpers\Html::a('<span class="btn btn-primary glyphicon glyphicon-trash"></span>', '#', ['title'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                             
                              
			    }
                        
                    ]
                ],
                            
                           
        
         ['attribute' => 'descripcion',
                'format'=>'raw',
                'value'=>function($model){
                        return $model->descripcion;                        
                             } 
                
                ],
         
           
             ['attribute' => 'codocu',
                'format'=>'raw',
                'value'=>function($model){
                        return $model->documento->desdocu;                        
                             } 
                
                ],
                
                
          
        ],
    ]); ?>
    <?php
     /* $url= Url::to(['modal-agrega-det-req-libre','id'=>$model->id,'gridName'=>'pjax-detmat','idModal'=>'buscarvalor']);
   echo  Html::button(yii::t('base.verbs','Agregar operación'), 
           ['href' => $url, 'title' => yii::t('sta.labels','Agregar Op'),
               'id'=>'btn_cuentas_edi',
               'class' => 'botonAbre btn btn-primary'
               ]); */
    ?>
   
    
</div>
    
  </div>        
     
    <?php Pjax::end(); ?>

</div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        
        
    </div>   
</div>

