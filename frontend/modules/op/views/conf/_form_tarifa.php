<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\widgets\selectwidget\selectWidget;
USE frontend\modules\op\helpers\ComboHelper;
/* @var $this yii\web\View */
/* @var $model frontend\modules\op\models\OpPlanestarifa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="op-planestarifa-form">
   <?php $form = ActiveForm::begin([
       'id'=>'miform',
       'enableAjaxValidation'=>true
   ]); ?>
     <div class="box-header">
            <div class="col-md-12">
             <div class="form-group no-margin">
                
                    <?= Html::submitButton('<span class="fa fa-save"></span>   '.Yii::t('app', 'Grabar'), ['class' => 'btn btn-success']) ?>
            

             </div>
            </div>
     </div>
    
<div class="col-lg-4 col-md-4 col-sm-3 col-xs-12">
       <?php 
  // $necesi=new Parametros;
    echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'form'=>$form,
            'campo'=>'codtra',
         'ordenCampo'=>1,
         'addCampos'=>[2,3],
        ]);  ?>
</div>
<div class="col-lg-4 col-md-4 col-sm-3 col-xs-12">  
    <?= 
            $form->field($model, 'tarifa_id')->
            dropDownList(ComboHelper::planes(),
                    ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>!$model->activo,
                        ]
                    )  ?>
</div>
<div class="col-lg-4 col-md-4 col-sm-3 col-xs-12">
    <?= $form->field($model, 'costohora')->textInput(['maxlength' => true]) ?>
</div>
<div class="col-lg-4 col-md-4 col-sm-3 col-xs-12">
    <?= $form->field($model, 'activo')->checkbox([]) ?>
</div>




   

    <?php ActiveForm::end(); ?>

</div>
