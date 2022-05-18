<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\modules\sigi\helpers\comboHelper;
use common\widgets\selectwidget\selectWidget;
use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
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
         
          <?= Html::submitButton('<span class="fa fa-save"></span>   '.Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
            

                  

            </div>
        </div>
    </div>
     
  
      <div class="box-body">
    
 
  
   <div class="col-lg-6 col-md-4 col-sm-12 col-xs-12">    
 <?= $form->field($model, 'codmon')->
            dropDownList(comboHelper::getCboMonedas(),
                  ['prompt'=>'--'.yii::t('base.verbs','Escoja un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
 </div>
  
 <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">    
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
   <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
     <?= 
            $form->field($model, 'banco_id')->
            dropDownList(comboHelper::getCboBancos() ,
                    ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    )  ?>
</div>  
  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    
 <?= $form->field($model, 'socio')->textInput() ?>

</div>  
   <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">    
 <?= $form->field($model, 'nombre')->textInput() ?>
 </div>
  <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">    
 <?= $form->field($model, 'numero')->textInput()?>
 </div>
   <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">    
 <?= $form->field($model, 'cci')->textInput()?>
 </div>        
 </div>
  <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">    
 <?= $form->field($model, 'activa')->checkbox()?>
 </div> 
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">    
 <?= $form->field($model, 'detalles')->
 textarea([]) ?>
 </div> 
          
     

     
    <?php ActiveForm::end(); ?>
     
    

</div>
    </div>
