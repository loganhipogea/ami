<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\modules\cc\helpers\comboHelper;
/* @var $this yii\web\View */
/* @var $model frontend\modules\cc\models\CcCc */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cc-cc-form">
    <br>
    <?php $form = ActiveForm::begin([
    'fieldClass'=>'\common\components\MyActiveField',
     'id'=>'mui',
      'enableAjaxValidation'=>true
    ]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
                
        <?= Html::submitButton('<span class="fa fa-save"></span>   '.Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
            

            </div>
        </div>
    </div>
      <div class="box-body">
    
 <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
  </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'codigo')->textInput(['maxlength' => true]) ?>

 </div>
   <div class="col-lg-6 col-md-4 col-sm-12 col-xs-12">    
 <?= $form->field($model, 'parent_id',['enableAjaxValidation'=>true])->
            dropDownList(comboHelper::getCboParentCecos($model),
                  ['prompt'=>'--'.yii::t('base.verbs','Escoja un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'activo')->checkbox([]) ?>

 </div>
     
    <?php ActiveForm::end(); ?>

</div>
    </div>
