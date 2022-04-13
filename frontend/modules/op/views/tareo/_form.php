<?php

use yii\helpers\Html;

 use kartik\date\DatePicker;
  use kartik\time\TimePicker;
 use yii\widgets\ActiveForm;
use common\helpers\h;

 use common\widgets\selectwidget\selectWidget;
  use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
  
/* @var $this yii\web\View */
/* @var $model frontend\modules\op\models\OpTareo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="op-tareo-form">
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
 <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <?php  //h::settings()->invalidateCache();  ?>
                       <?= $form->field($model, 'fecha')->widget(DatePicker::class, [
                             'language' => h::app()->language,
                           // 'readonly'=>true,
                          // 'inline'=>true,
                           'pluginOptions'=>[
                                     'format' => h::gsetting('timeUser', 'date')  , 
                                  'changeMonth'=>true,
                                  'changeYear'=>true,
                                 'yearRange'=>"-99:+0",
                               ],
                           
                            //'dateFormat' => h::getFormatShowDate(),
                            'options'=>['class'=>'form-control','disabled'=>$model->hasChilds()]
                            ]) ?>
</div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'hinicio')->widget(TimePicker::className(), ['pluginOptions' => ['showMeridian' => false]]);?>
     

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'hfin')->widget(TimePicker::className(), ['pluginOptions' => ['showMeridian' => false]]);?>
     

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

 </div>
   <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12"> 
     <?php 
  // $necesi=new Parametros;
    echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'form'=>$form,
            'campo'=>'direcc_id',
         'ordenCampo'=>1,
         'addCampos'=>[2],
        ]);  ?>

 </div>       
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'proc_id')->textInput() ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'os_id')->textInput() ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'detos_id')->textInput() ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'detalle')->textarea(['rows' => 6]) ?>

 </div>
     
    <?php ActiveForm::end(); ?>

</div>
    </div>
