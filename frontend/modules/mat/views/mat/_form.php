<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
use yii\widgets\Pjax;
use common\helpers\h;
use yii\grid\GridView;
 use kartik\date\DatePicker;
 use common\widgets\selectwidget\selectWidget;
/* @var $this yii\web\View */
/* @var $model frontend\modules\mat\models\MatReq */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mat-req-form">
    <br>
    <?php $form = ActiveForm::begin([
   // 'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
                
        <?= Html::submitButton('<span class="fa fa-save"></span>   '.Yii::t('app', 'Grabar'), ['class' => 'btn btn-success']) ?>
          <?=(!$model->isNewRecord)?common\widgets\auditwidget\auditWidget::widget(['model'=>$model]):''?>  

            </div>
        </div>
    </div>
      <div class="box-body">
    

  <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
     <?= $form->field($model, 'numero')->textInput(['maxlength' => true,
         'style'=>"font-weight:600;color:#740fd6;",
         'disabled'=>true]) ?>

 </div>
   <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
      <?php 
      
        echo $form->field($model, 'fechasol')->widget(
        DatePicker::classname(), [
         'name' => 'fechasol',
            'language' => h::app()->language,
            'options' => ['placeholder' =>yii::t('sta.labels', '--Seleccione un valor--')],
    //'convertFormat' => true,
                'pluginOptions' => [
                'format' => h::getFormatShowDate(),
                //'startDate' => '01-Mar-2014 12:00 AM',
                'todayHighlight' => true
                                ]
                    ]);
                ?>
  </div> 
   <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
      <?php 
      
        echo $form->field($model, 'fechaprog')->widget(
        DatePicker::classname(), [
         'name' => 'fechaprog',
            'language' => h::app()->language,
            'options' => ['placeholder' =>yii::t('sta.labels', '--Seleccione un valor--')],
    //'convertFormat' => true,
                'pluginOptions' => [
                'format' => h::getFormatShowDate(),
                //'startDate' => '01-Mar-2014 12:00 AM',
                'todayHighlight' => true
                                ]
                    ]);
                ?>
  </div> 
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?php 
  // $necesi=new Parametros;
    echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'form'=>$form,
            'campo'=>'codtra',
         'ordenCampo'=>2,
         'addCampos'=>[3,4],
        ]);  ?>


 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

 </div>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'texto')->textarea(['rows' => 6]) ?>

 </div>
  
     
    <?php ActiveForm::end(); ?>
  <?php if(!$model->isNewRecord){ ?>
    <?php Pjax::begin(['id'=>'grilla-materiales']); ?>
    
   <?php //var_dump((new SigiApoderadosSearch())->searchByEdificio($model->id)); die(); ?>
    <?= GridView::widget([
        'dataProvider' =>(new \frontend\modules\mat\models\MatDetreqSearch())->search_by_req($model->id),
         //'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'columns' => [
             [
        'class' => 'yii\grid\CheckboxColumn',
                 'checkboxOptions' => function ($model, $key, $index, $column) {
                         $url = \yii\helpers\Url::to([$this->context->id.'/ajax-guarda-id-req-sesion','id'=> $model->id]);                              
                        return ['value' => $model->id,'family'=>'pigmalion', 'title'=>$url,'id'=>$model->id];
                            }
        // you may configure additional properties here
                    ],
                 [
                    
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{edit}{delete}',
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
			    $url= Url::to(['/mat/mat/mod-edit-mat','id'=>$model->id,'gridName'=>'grilla-materiales','idModal'=>'buscarvalor']);
                              return \yii\helpers\Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>'0','class'=>'botonAbre']);
                            },
                        'delete' => function ($url,$model) {
                              IF($model->activo){
                                $url = \yii\helpers\Url::to([$this->context->id.'/ajax-desactiva-item','id'=>$model->id]);
                              
                                    return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['title'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                             
                              }
			    }
                        
                    ]
                ],
              
            'item',
             'um',
             ['attribute' => 'cant',
                'format'=>'raw',
                'value'=>function($model){
                        
                          if(!$model->activo){                            
                           return '<span style="text-decoration:line-through;">'.$model->cant.'</span>';
                          }else{
                             return $model->cant; 
                          }                         
                             } 
                
                ], 
              'codart',              
            ['attribute' => 'descripcion',
                'format'=>'raw',
                'value'=>function($model){
                        
                          if(!$model->activo){                            
                           return '<span style="text-decoration:line-through;">'.$model->descripcion.'</span>';
                          }else{
                             return $model->descripcion; 
                          }                         
                             } 
                
                ], 
             ['attribute' => 'imagen',
                'format'=>'raw',
                'value'=>function($model){
                        
                          if(!empty($model->codart)){
                             $material=$model->material;
                            if($material->hasAttachments())
                            return \yii\helpers\Html::img ($material->files[0]->url,['width'=>50,'height'=>50]);
                            
                          }                           
                              } 
                
                ], 
              'imptacion',
           ['class' => '\common\components\columnGridAudit',],
        ],
    ]); ?>
         <?php 
   echo linkAjaxGridWidget::widget([
           'id'=>'widgetgruidBancos',
            'idGrilla'=>'grilla-materiales',
            'family'=>'holas',
          'type'=>'POST',
           'evento'=>'click',
        'posicion'=>\yii\web\View::POS_END
       
            //'foreignskeys'=>[1,2,3],
        ]); 
   ?>
          
          <?php 
   echo linkAjaxGridWidget::widget([
           'id'=>'widgetgruidBancosss',
            'idGrilla'=>'grilla-materiales',
            'family'=>'pigmalion',
          'type'=>'POST',
           'evento'=>'change',
           'refrescar'=>false,
        'posicion'=>\yii\web\View::POS_END
       
            //'foreignskeys'=>[1,2,3],
        ]); 
   ?>
         
    <?php Pjax::end(); ?>
   <?php
  
      $url= Url::to(['mod-agrega-mat','id'=>$model->id,'gridName'=>'grilla-materiales','idModal'=>'buscarvalor']);
   echo  Html::button(yii::t('base.verbs','Agregar material'), ['href' => $url, 'title' => yii::t('sta.labels','Agregar Material'),'id'=>'btn_cuentas_edi', 'class' => 'botonAbre btn btn-success']); 
  
   }
?>     
          
          
</div>
    </div>
