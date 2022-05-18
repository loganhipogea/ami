<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\mat\models\MatOc */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mat-oc-form">
    <br>
    <?php $form = ActiveForm::begin([
    'fieldClass'=>'\common\components\MyActiveField'
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
     <?= $form->field($model, 'numero')->textInput(['maxlength' => true]) ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'fecha')->textInput(['maxlength' => true]) ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'codpro')->textInput(['maxlength' => true]) ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'codtra')->textInput(['maxlength' => true]) ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'textointerno')->textarea(['rows' => 6]) ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'fpago')->textInput(['maxlength' => true]) ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'texto')->textarea(['rows' => 6]) ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'codest')->textInput(['maxlength' => true]) ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'codmon')->textInput(['maxlength' => true]) ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'user_id')->textInput() ?>

 </div>
     
    <?php ActiveForm::end(); ?>

</div>
    </div>
