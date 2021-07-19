<?php
use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
 use kartik\date\DatePicker;
use common\widgets\selectwidget\selectWidget;
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
          <?php 
           if($model->isNewRecord){
               $url=\yii\helpers\Url::to(['/sigi/'.$this->context->id.'/agrega-mail','id'=>$id]);               
           }else{
               $url=\yii\helpers\Url::to(['/sigi/'.$this->context->id.'/edita-mail','id'=>$id]);
           }
           echo \common\widgets\buttonsubmitwidget\buttonSubmitWidget::widget(
                  ['idModal'=>$idModal,
                    'idForm'=>'myformulario',
                      'url'=>$url,
                     'idGrilla'=>$gridName, 
                      ]
                  )?>
         
                  

            </div>
        </div>
    </div>
     
  
      <div class="box-body">
    
 
 
 
  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
     <?= $form->field($model, 'correo')->textInput(['maxlength' => true]) ?>

  </div>

     
    <?php ActiveForm::end(); ?>

</div>
    </div>
