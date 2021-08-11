<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\modules\sigi\helpers\comboHelper;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\SigiTipomov */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box-body">
    <br>
    <?php $form = ActiveForm::begin([
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
                
        <?= Html::submitButton('<span class="fa fa-save"></span>   '.Yii::t('sigi.labels', 'Grabar'), ['class' => 'btn btn-success']) ?>
            

            </div>
        </div>
    </div>
      <div class="box-body">
 
 <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
    <?php echo $form->field($model, 'edificio_id')->
            dropDownList(comboHelper::getCboEdificios(),
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        'disabled'=>(!$aprobado)?false:true,
                      ]
                    ) ?>

 </div>         
          
 <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
     <?= $form->field($model, 'codigo',['enableAjaxValidation'=>true])->textInput(['maxlength' => true]) ?>

 </div>
  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
     <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

 </div>
 <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
     <?= $form->field($model, 'conciliable')->checkBox([]) ?>

 </div> 
 <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
     <?php echo $form->field($model, 'signo')->
            dropDownList([1=>'Crédito',-1=>'Débito',0=>'Corte'],
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        'disabled'=>(!$aprobado)?false:true,
                      ]
                    ) ?>

 </div> 
    <?php ActiveForm::end(); ?>

</div>
    </div>
