<?php
use yii\helpers\Url;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;


  use common\models\masters\Clipro;
use common\models\masters\Direcciones;

/* @var $this yii\web\View */
/* @var $model common\models\masters\Clipro */
/* @var $form yii\widgets\ActiveForm */
?>





    <?php $form = ActiveForm::begin([
        'id'=>'mycliproform',
        'enableAjaxValidation' => true]); ?>
    <div class="box-footer">
        <div class="col-md-12">
            <div class="form-group no-margin">
                <?= Html::submitButton("<span class=\"fa fa-cog\"></span>".($model->isNewRecord) ? 'Grabar' : 'Grabar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
       
            </div>
        </div>
    </div>
    <div class="box-body">
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <?= $form->field($model, 'codpro')->textInput(['disabled'=>'disabled','maxlength' => true]) ?>
    </div>
       <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <?= $form->field($model, 'rucpro',['enableAjaxValidation'=>true])->textInput(['maxlength' => true]) ?>
      </div>
         <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <?= $form->field($model, 'telpro')->textInput(['maxlength' => true]) ?>
         </div>
      <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <?= $form->field($model, 'codbanco',['enableAjaxValidation'=>true])->textInput(['maxlength' => true]) ?>
      </div>
         <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'cci')->textInput(['maxlength' => true]) ?>
         </div> 
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'cuenta')->textInput(['maxlength' => true]) ?>
         </div>
         <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'codmon')->textInput(['maxlength' => true]) ?>
         </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'despro')->textInput(['maxlength' => true]) ?>
    </div>
       
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'web')->textInput(['maxlength' => true]) ?>
          </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?= $form->field($model, 'deslarga')->textarea(['rows' => 6]) ?>
        </div>
   </div>
    
    <?php ActiveForm::end(); ?>



