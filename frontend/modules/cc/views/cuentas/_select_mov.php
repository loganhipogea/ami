<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\modules\cc\helpers\comboHelper;

/* @var $this yii\web\View */
/* @var $model frontend\modules\cc\models\CcCuentas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cc-cuentas-form">
     <div class="box-body">
      <?php $form = ActiveForm::begin([
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
          
        <div class="col-md-12">
            <div class="form-group no-margin">
         
          <?= Html::submitButton('<span class="fa fa-save"></span>   '.Yii::t('app', 'Grabar'), ['class' => 'btn btn-success']) ?>
            

                  

            </div>
        </div>
    </div>
     
  
      <div class="box-body">
    
 
  
   <div class="col-lg-6 col-md-4 col-sm-12 col-xs-12">    
 <?= $form->field($model, 'cuenta_id')->
            dropDownList(comboHelper::getCboCuentas(),
                  ['prompt'=>'--'.yii::t('base.verbs','Escoja un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
 </div>
  
 
  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
     <?= 
            $form->field($model, 'tipo')->
            dropDownList($model->comboDataField('tipo') ,
                    ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    )  ?>
</div>  
   
          
     

     
    <?php ActiveForm::end(); ?>
     
    

</div>
    </div>
