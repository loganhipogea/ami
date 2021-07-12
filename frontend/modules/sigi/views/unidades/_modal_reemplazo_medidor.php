<?php
//use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
 //use kartik\date\DatePicker;
use common\widgets\selectwidget\selectWidget;
 use kartik\date\DatePicker;
 use common\helpers\h;
use frontend\modules\sigi\helpers\comboHelper;

/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\SigiUnidades */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sigi-unidades-form">

    <?php $form = ActiveForm::begin([
        'id'=>'myformulario'/*,'enableAjaxValidation'=>true*/
    ]); ?>
      <div class="box-header">
          
        <div class="col-md-12">
            <div class="form-group no-margin">
          <?= \common\widgets\buttonsubmitwidget\buttonSubmitWidget::widget(
                  ['idModal'=>$idModal,
                    'idForm'=>'myformulario',
                      'url'=> \yii\helpers\Url::to(['/sigi/'.$this->context->id.'/'.(($model->isNewRecord)?'replace':'edit-replace').'-medidor','id'=>$id]),
                     'idGrilla'=>$gridName, 
                      ]
                  )?>
         
                  

            </div>
        </div>
    </div>
     
  
      <div class="box-body">
    
 
   
  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
      <?= $form->field($modelAnt, 'codsuministro')->textInput(['disabled'=>true,'maxlength' => true]) ?>

</div>
   <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
     <?= $form->field($modelAnt, 'frecuencia')->textInput(['disabled'=>true,'maxlength' => true]) ?>

 </div>         
          
 <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
     <?= $form->field($modelAnt, 'codpro')->textInput(['value'=>$modelAnt->clipro->despro,'disabled'=>true,'maxlength' => true]) ?>

 </div>   
  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
     <?= $form->field($modelAnt, 'codum')->textInput(['value'=>$modelAnt->um->desum,'disabled'=>true,'maxlength' => true]) ?>

 </div> 
    
 
          
<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
     <?= $form->field($modelAnt, 'numerocliente')->textInput(['disabled'=>true,'maxlength' => true]) ?>

 </div>
  <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
     <?= $form->field($model, 'codsuministro_actual')->textInput(['maxlength' => true]) ?>

 </div>        
  <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
     <?= $form->field($modelAnt, 'activo')->checkBox(['disabled'=>true,]) ?>

 </div>         
   <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
     <?= $form->field($modelAnt, 'plano')->checkBox(['disabled'=>true,]) ?>

 </div>   
 
 
 
  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"> 
      <?= $form->field($model, 'fecha_reemplazo')->widget(DatePicker::class, [
                            'language' => h::app()->language,
                           'pluginOptions'=>[
                                       'format' => h::getFormatShowDate(),
                                   'changeMonth'=>true,
                                  'changeYear'=>true,
                                 'yearRange'=>'2010:'.date('Y'),
                               ],
                          
                            //'dateFormat' => h::getFormatShowDate(),
                            'options'=>['class'=>'form-control']
                            ]) ?>

 </div>
<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'ultima_lectura')->textInput() ?>

 </div>      
  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"> 
      <?= $form->field($model, 'fecha_ultima_lectura')->widget(DatePicker::class, [
                            'language' => h::app()->language,
                           'pluginOptions'=>[
                                       'format' => h::getFormatShowDate(),
                                   'changeMonth'=>true,
                                  'changeYear'=>true,
                                 'yearRange'=>'2010:'.date('Y'),
                               ],
                          
                            //'dateFormat' => h::getFormatShowDate(),
                            'options'=>['class'=>'form-control',]
                            ]) ?>

 </div>  
          
  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"> 
     <?= $form->field($model, 'lectura_actual')->textInput() ?>

 </div>         
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'detalle')->textarea(['rows' => 4]) ?>

 </div>        
          
    <?php ActiveForm::end(); ?>


    </div>
