<?php
 use kartik\date\DatePicker;
use yii\helpers\Html;

use common\widgets\selectwidget\selectWidget;
use common\helpers\h;

/* @var $this yii\web\View */
/* @var $model frontend\modules\op\models\OpProcesos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="op-procesos-form">
    <br>
   
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
                
        <?= Html::submitButton('<span class="fa fa-save"></span>   '.Yii::t('app', 'Grabar'), ['class' => 'btn btn-success']) ?>
            

            </div>
        </div>
    </div>
      <div class="box-body">
    
 
  <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'numero')->textInput(['disabled'=>true,'maxlength' => true]) ?>

 </div>
   <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
     <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

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
                               'disabled'=>(!$aprobado)?false:true  
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
                               'disabled'=>(!$aprobado)?false:true  
                                ]
                            ]) ?>
 </div>
  
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
     <?php 
  // $necesi=new Parametros;
    echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'form'=>$form,
            'campo'=>'codpro',
         'ordenCampo'=>1,
         'addCampos'=>[2,3],
        ]);  ?>

 </div> 
 
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'tipo')->textInput(['maxlength' => true]) ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'codestado')->textInput(['maxlength' => true]) ?>

 </div>
  
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
      <?PHP
     echo $form->field($model, 'textointerno')
             ->widget(\dosamigos\ckeditor\CKEditor::className(), [
        'options' => ['rows' => 2],
         'clientOptions'=>['language'=>'es',
             ],
        ]);
      ?>

 </div>
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
     <?PHP
     echo $form->field($model, 'textotecnico')
             ->widget(\dosamigos\ckeditor\CKEditor::className(), [
        'options' => ['rows' => 2],
         'clientOptions'=>['language'=>'es',
             ],
        ]);
      ?>

 </div>
     
   

</div>
    </div>
