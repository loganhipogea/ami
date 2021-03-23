<?php
use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
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
              if(!$model->isNewRecord){
                 $url=['/sigi/'.$this->context->id.'/edita-docu','id'=>$id];   
              }else{
                 $url=['/sigi/'.$this->context->id.'/agrega-docu','id'=>$id]; 
              }
             ?>
          <?= \common\widgets\buttonsubmitwidget\buttonSubmitWidget::widget(
                  ['idModal'=>$idModal,
                    'idForm'=>'myformulario',
                      'url'=> \yii\helpers\Url::to($url),
                     'idGrilla'=>$gridName, 
                      ]
                  )?>
         
                  

            </div>
        </div>
    </div>
     
  
      <div class="box-body">
    
 
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">    
 <?= $form->field($model, 'codocu')->
            dropDownList(comboHelper::getCboDocuments(),
                  ['prompt'=>'--'.yii::t('base.verbs','Escoja un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
 </div>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">    
 <?= $form->field($model, 'nombre')->textInput()?>
 </div>   
   <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
     <?= $form->field($model, 'importante')->checkbox([]) ?>

 </div>
   
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">    
 <?= $form->field($model, 'detalle')->
 textarea([]) ?>
 </div> 
          
     

     
    <?php ActiveForm::end(); ?>

</div>
    </div>
