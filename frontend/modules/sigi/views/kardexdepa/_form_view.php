<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use common\widgets\buttonajaxwidget\buttonAjaxWidget;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\SigiKardexdepa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sigi-kardexdepa-form">
    <br>
        <div class="box-body">
    <?php $form = ActiveForm::begin([
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
     <?= $form->field($model, 'facturacion_id')->label(yii::t('sta.labels','Facturación'))->textInput(['value'=>$model->facturacion->descripcion,'disabled'=>true]) ?>
  </div>
  
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
    <?= $form->field($model, 'unidad_id')->label(yii::t('sta.labels','Unidad'))->textInput(['value'=>$model->unidad->nombre,'disabled'=>true]) ?>
  

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'edificio_id')->textInput() ?>

 </div>
  
 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">    
 <?= $form->field($model, 'mes')->
            dropDownList(\common\helpers\timeHelper::cboMeses(),
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un Valor')."--",
                    // 'class'=>'probandoSelect2',
                    'disabled'=>true,
                        ]
                    ) ?>
 </div> 
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'fecha')->textInput(['maxlength' => true,'disabled'=>true,]) ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'anio')->textInput(['maxlength' => true,'disabled'=>true,]) ?>

 </div>
  
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'numerorecibo')->textInput(['value'=>$model->numeroReciboConsultado(),'disabled'=>true,'maxlength' => true]) ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'montoNominal')->label('Monto a cobrar')->textInput(['value'=>$model->montoCalculado(),'disabled'=>true,'maxlength' => true]) ?>

 </div>
         
  
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'detalles')->textarea(['rows' => 6,'disabled'=>true]) ?>

 </div>
     
    <?php ActiveForm::end(); ?>
          
    
 
<?=(!$model->isNewRecord)? \nemmo\attachments\components\AttachmentsTable::widget([
	'model' => $model,
	//'showDeleteButton' => false, // Optional. Default value is true
]):''?>      
          
          
  

</div>
    </div>
