<?php
use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\h;
use frontend\modules\sigi\helpers\comboHelper;
use frontend\modules\sigi\models\SigiBenegrupoedificio;
use frontend\modules\sigi\models\SigiCargosgrupoedificio;
use common\widgets\selectwidget\selectWidget;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\SigiUnidades */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sigi-unidades-form">
<div class="box box-success">
    <div class="box box-body">
    <?php $form = ActiveForm::begin([
        'id'=>'myformulario'/*,'enableAjaxValidation'=>true*/
    ]); ?>
      <div class="box-header">
          
        <div class="col-md-12">
            <div class="form-group no-margin">
          <?PHP 
          if($model instanceof SigiBenegrupoedificio){
             $cadena='-bene' ;
          }else{
             $cadena='-grupo' ; 
          }
          
          ?>
          <?= \common\widgets\buttonsubmitwidget\buttonSubmitWidget::widget(
                  ['idModal'=>$idModal,
                    'idForm'=>'myformulario',
                      'url'=> \yii\helpers\Url::to(['/sigi/'.$this->context->id.'/'.(($model->isNewRecord)?'agrega':'edita').$cadena,'id'=>$id]),
                     'idGrilla'=>$gridName, 
                      ]
                  )?>
         
                  

            </div>
        </div>
    </div>
     
  
      <div class="box-body">
    
 
         
   <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">    
 <?= $form->field($model, 'codgrupo')->textInput() ?>
 </div>
  <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">    
 <?= $form->field($model, 'descripcion')->textInput() ?>
 </div>
 </div>
  <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">    
 <?= $form->field($model, 'activo')->checkbox()?>
 </div> 
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">    
 <?= $form->field($model, 'detalles')->
 textarea([]) ?>
 </div> 
          
     

     
    <?php ActiveForm::end(); ?>

</div>
    </div></div>
