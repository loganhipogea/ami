<?php
use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
 use kartik\date\DatePicker;
use common\helpers\h;

use frontend\modules\sigi\helpers\comboHelper;
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
          <?php if($model->isNewRecord){
              $url= \yii\helpers\Url::to(['/sigi/'.$this->context->id.'/crea-conc','id'=>$id]);
          }else{
             $url= \yii\helpers\Url::to(['/sigi/'.$this->context->id.'/edit-conc']); 
          } ?>
          <?= \common\widgets\buttonsubmitwidget\buttonSubmitWidget::widget(
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
         <?php         
            echo  $form->field($model, 'cuenta_id')->textInput(['disabled'=>true,'value'=>$model->cuenta->nombre]);
           ?> 
          
   </div>
   <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
         <?php 
        echo  $form->field($model, 'edificio_id')->textInput(['disabled'=>true,'value'=>$model->edificio->nombre]);
         ?> 
          
   </div>
   <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
         <?php         
             echo $form->field($model, 'idop')->textInput(['disabled'=>true,'value'=>$model->movBanco->monto]);
           ?> 
          
   </div>
   <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
         <?php 
         echo $form->field($model, 'id')->textInput(['disabled'=>true,'value'=>$model->cuenta->nombre]);
         ?> 
          
   </div>
          
 <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
         <?php 
         echo $form->field($model, 'monto')->textInput();
         ?> 
          
   </div>
 <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"> 
      
           <?php echo $form->field($model, 'kardex_id')->
            dropDownList(\frontend\modules\sigi\helpers\comboHelper::getCboKardexPagados($model->edificio_id),
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
      
 </div>   
   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
      <?php 
         echo $form->field($model, 'glosa')->textInput();
       ?> 
      
 </div> 
 </div>

     
    <?php ActiveForm::end(); ?>

</div>
    </div></div>
