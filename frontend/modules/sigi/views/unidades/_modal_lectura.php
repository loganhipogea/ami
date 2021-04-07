<?php

//use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
 //use kartik\date\DatePicker;
use common\widgets\selectwidget\selectWidget;
use common\helpers\h;
use frontend\modules\sigi\helpers\comboHelper;
 use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\SigiUnidades */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sigi-unidades-form">
  <?php $esFacturado=$model->isInFacturacion(); ?>
    <?php $form = ActiveForm::begin([
        'id'=>'myformulario'/*,'enableAjaxValidation'=>true*/
    ]); ?>
      <div class="box-header">
          
        <div class="col-md-12">
            <div class="form-group no-margin">
          <?= \common\widgets\buttonsubmitwidget\buttonSubmitWidget::widget(
                  ['idModal'=>$idModal,
                    'idForm'=>'myformulario',
                      'url'=> \yii\helpers\Url::to(['/sigi/'.$this->context->id.'/'.(($model->isNewRecord)?'agrega':'edita').'-lectura','id'=>$id]),
                     'idGrilla'=>$gridName, 
                      ]
                  )?>
         
                  

            </div>
        </div>
    </div>
     
  
      <div class="box-body">
   <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
      <?= $form->field($model, 'flectura')->widget(DatePicker::class, [
                            'language' => h::app()->language,
                           'pluginOptions'=>[
                                     'format' => h::gsetting('timeUser', 'date')  , 
                                   'changeMonth'=>true,
                                  'changeYear'=>true,
                                 'yearRange'=>'2014:'.date('Y'),
                               ],
                          
                            //'dateFormat' => h::getFormatShowDate(),
                            'options'=>['class'=>'form-control',
                                'disabled'=>$esFacturado,
                                ]
                            ]) ?>
 </div> 

  <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'lectura')->textInput(['maxlength' => true,'disabled'=>$esFacturado,]) ?>

 </div>
 
   <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
     <?= 
            $form->field($model, 'mes')->
            dropDownList( common\helpers\timeHelper::cboMeses(),
                    ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                    'disabled'=>$esFacturado,
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    )  ?>
</div>
 <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
     <?= 
            $form->field($model, 'anio')->
            dropDownList( common\helpers\timeHelper::cboAnnos(),
                    ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                    'disabled'=>$esFacturado,
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    )  ?>
</div>
<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'facturable')->checkbox(['disabled'=>$esFacturado,]) ?>

 </div>
 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <?php 
        
            if($model->hasAttachments()){
             echo \yii\helpers\Html::img($model->files[0]->url,['width'=>300,'height'=>300]);
            }
     ?>
 

 </div>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    

 </div>

     
    <?php ActiveForm::end(); ?>


    </div>
