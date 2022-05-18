<?php

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\modules\clasi\helpers\ComboHelper;
use yii\widgets\ActiveForm;
use common\widgets\cbodepwidget\cboDepWidget as ComboDep;

use common\widgets\selectwidget\selectWidget;


/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\Edificios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="edificios-form">
    <br>
    <?php $form = ActiveForm::begin([
        'id'=>'myformulario',
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
           <?PHP 
             IF($model->isNewRecord){
               $url=\yii\helpers\Url::to(['/clasi/clasi/mod-agrega-clase']);  
                 //$operacion=($model->isNewRecord)?'mod-agrega-mat':'mod-edit-mat';
             }else{
                $url=\yii\helpers\Url::to(['/clasi/clasi/mod-edita-clase','id'=>$id]);  
             }
           ?>
           <?= \common\widgets\buttonsubmitwidget\buttonSubmitWidget::widget(
                  ['idModal'=>$idModal,
                    'idForm'=>'myformulario',
                      'url'=> $url,
                     'idGrilla'=>$gridName, 
                      ]
                  )?>
            </div>
        </div>
    </div>
      <div class="box-body">
     
     <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <?= $form->field($model, 'codigo')->textInput(['maxlength' => true]) ?>

    </div>
    
 
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

 </div>
 
  
      
          
     
    <?php ActiveForm::end(); ?>

</div>
    </div>
 <?php 

 
  ?>


