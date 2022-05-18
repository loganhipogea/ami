<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\op\models\OpPlanestarifa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="op-planestarifa-form">
   <?php $form = ActiveForm::begin(); ?>
     <div class="box-header">
            <div class="col-md-12">
             <div class="form-group no-margin">
                
                    <?= Html::submitButton('<span class="fa fa-save"></span>   '.Yii::t('app', 'Grabar'), ['class' => 'btn btn-success']) ?>
            

             </div>
            </div>
     </div>
    
<div class="col-lg-4 col-md-4 col-sm-3 col-xs-12">
    <?= $form->field($model, 'codigo')->textInput(['maxlength' => true]) ?>
</div>
<div class="col-lg-4 col-md-4 col-sm-3 col-xs-12">  
    <?= $form->field($model, 'porc_dominical')->textInput(['maxlength' => true]) ?>
</div>
<div class="col-lg-4 col-md-4 col-sm-3 col-xs-12">
    <?= $form->field($model, 'porc_feriado')->textInput(['maxlength' => true]) ?>
</div>
<div class="col-lg-4 col-md-4 col-sm-3 col-xs-12">
    <?= $form->field($model, 'porc_nocturno')->textInput(['maxlength' => true]) ?>
</div>
<div class="col-lg-4 col-md-4 col-sm-3 col-xs-12">
    <?= $form->field($model, 'porc_localizacion')->textInput(['maxlength' => true]) ?>
</div>
<div class="col-lg-4 col-md-4 col-sm-3 col-xs-12">
    <?= $form->field($model, 'porc_refrigerio')->textInput(['maxlength' => true]) ?>
</div>
<div class="col-lg-4 col-md-4 col-sm-3 col-xs-12">
    <?= $form->field($model, 'porc_hextras')->textInput(['maxlength' => true]) ?>
</div>
<div class="col-lg-4 col-md-4 col-sm-3 col-xs-12">
    <?= $form->field($model, 'nhoras')->textInput() ?>
</div>
<div class="col-lg-4 col-md-4 col-sm-3 col-xs-12">
    <?= $form->field($model, 'hinicio_nocturno')->textInput(['maxlength' => true]) ?>
</div>

   

    <?php ActiveForm::end(); ?>

</div>
