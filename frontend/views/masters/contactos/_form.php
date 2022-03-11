<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\helpers\h;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\masters\Contactos */
/* @var $form yii\widgets\ActiveForm */
// url: '".Url::toRoute('/masters/contactos/datos')."',
?>

<div class="contactos-form">

    <?php  
   // PRINT_r($aditionalParams);DIE();
    $form = ActiveForm::begin(['action'=>h::request()->url]); ?>
    <?= $form->errorSummary($model,['errorOptions' => ['encode' => false,'class' => 'help-block']]); ?>
 
     <div class="box box-body">
        <div class="col-md-12">
            <div class="form-group no-margin">
                <?= Html::submitButton(Yii::t('base.verbs', 'Grabar'), ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    
    
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
   <?= $form->field($model, 'nombres')->textInput(['maxlength' => true]) ?>
  </div>
    
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <?= $form->field($model, 'moviles')->textInput(['maxlength' => true]) ?>
 </div>
    
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <?= $form->field($model, 'mail')->textInput(['maxlength' => true]) ?>
 </div>
     <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
      <?php if(!h::request()->isAjax){
          
          //var_dump($vendorsForCombo);die();
          ?>
     
      <?php } else{ ?>
         <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
           <?=$form->field($model, 'codpro')
                   ->hiddenInput(['value' => $id])
                    ->label(false)?>
       </div> 
          
     <?php } ?>
</div>
    

    <?php ActiveForm::end(); ?>
     <?php 
  // echo \yii\helpers\Html::a('pinchar', \yii\helpers\Url::toRoute(['/masters/clipro/createcontact','id'=>'370003',  'final'=>'si']), []);
  // $this->registerJs("$('#btn_prueba').on('click', function (ev) { $.pjax({container:'grilla-contactos'}); });",View::POS_HEAD); 
   //$this->registerJs("$('#btn_prueba').on('click',  alert('caramba'))",View::POS_READY); 
  // echo Html::button('Press me!', ['onClick' => "$('#mibotonmodal').click();"]) ;
   ?> 
</div>
</div>