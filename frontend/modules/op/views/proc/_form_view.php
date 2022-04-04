<?php
 use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\widgets\selectwidget\selectWidget;
use common\helpers\h;

/* @var $this yii\web\View */
/* @var $model frontend\modules\op\models\OpProcesos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="op-procesos-form">
    <br>
    <?php
    $aprobado=false;
    $form = ActiveForm::begin([
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
                
        <?= Html::a(Yii::t('app', 'Editar'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
      
            </div>
        </div>
    </div>
      <div class="box-body">
    
 
  <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'numero')->textInput(['disabled'=>true,'maxlength' => true]) ?>

 </div>
   <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
     <?= $form->field($model, 'descripcion')->textInput(['disabled'=>true,'maxlength' => true]) ?>

   </div>
   <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
      <?= $form->field($model, 'fechaprog')->widget(DatePicker::class, [
                            'language' => h::app()->language,
                           'pluginOptions'=>[
                                     'format' => h::gsetting('timeUser', 'date')  , 
                                   'changeMonth'=>true,
                                  'changeYear'=>true,
                                 'yearRange'=>'2014:'.date('Y'),
                               ],
                          
                            //'dateFormat' => h::getFormatShowDate(),
                            'options'=>['class'=>'form-control',
                               'disabled'=>true,
                                ]
                            ]) ?>
 </div>
   <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
      <?= $form->field($model, 'fechaini')->widget(DatePicker::class, [
                            'language' => h::app()->language,
                           'pluginOptions'=>[
                                     'format' => h::gsetting('timeUser', 'date')  , 
                                   'changeMonth'=>true,
                                  'changeYear'=>true,
                                 'yearRange'=>'2014:'.date('Y'),
                               ],
                          
                            //'dateFormat' => h::getFormatShowDate(),
                            'options'=>['class'=>'form-control',
                              'disabled'=>true,
                                ]
                            ]) ?>
 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'numoc')->textInput(['disabled'=>true,'maxlength' => true]) ?>

 </div>
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
     <?= $form->field($model, 'codpro')->textInput(['disabled'=>true,
         'value'=>$model->cliente->despro,
         'maxlength' => true]) ?>

 </div> 
 
 
 
   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
      <?PHP
     echo $form->field($model, 'textocomercial')
             ->widget(\dosamigos\ckeditor\CKEditor::className(), [
        'options' => ['disabled'=>true,'rows' => 4],
         'clientOptions'=>['language'=>'es',
             ],
        ]);
      ?>
  </div>
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
      <?PHP
     echo $form->field($model, 'textointerno')
             ->widget(\dosamigos\ckeditor\CKEditor::className(), [
        'options' => ['disabled'=>true,'rows' => 4],
         'clientOptions'=>['language'=>'es',
             ],
        ]);
      ?>

 </div>
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
     <?PHP
     echo $form->field($model, 'textotecnico')
             ->widget(\dosamigos\ckeditor\CKEditor::className(), [
        'options' => ['disabled'=>true,'rows' => 4],
         'clientOptions'=>['language'=>'es',
             ],
        ]);
      ?>

 </div>
     
    <?php ActiveForm::end(); ?>

</div>
    </div>
