<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

use frontend\modules\op\helpers\ComboHelper;

 //use kartik\date\DatePicker;
use kartik\datetime\DateTimePicker;
use common\widgets\selectwidget\selectWidget;

use common\helpers\h;

/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\Edificios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="edificios-form">
    <br>
    <?php $form = ActiveForm::begin([
        'id'=>'myformulario',
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
           <?PHP 
           $operacion=($model->isNewRecord)?'modal-agrega-doc':'modal-edita-doc';
             
               $url=\yii\helpers\Url::to(['/op/proc/'.$operacion,'id'=>$id]);  
             
           ?>
           <?= \common\widgets\buttonsubmitwidget\buttonSubmitWidget::widget(
                  ['idModal'=>$idModal,
                    'idForm'=>'myformulario',
                      'url'=> $url,
                     'idGrilla'=>$gridName, 
                      ]
                  )?>
            </div>
        </div>
    </div>

     <div class="box-body">
     
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">    
 <?= $form->field($model, 'codocu')->
            dropDownList(comboHelper::getCboDocuments(),
                  ['prompt'=>'--'.yii::t('base.verbs','Escoja un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
 </div>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true,/*'disabled'=>!$model->activo,*/]) ?>

 </div>

  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'detalles')->textArea(['maxlength' => true,/*'disabled'=>!$model->activo,*/]) ?>
 </div> 
     
    <?php ActiveForm::end(); ?>

</div>


    </div>



