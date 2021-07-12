<?php
//use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
 //use kartik\date\DatePicker;
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
          <?= \common\widgets\buttonsubmitwidget\buttonSubmitWidget::widget(
                  ['idModal'=>$idModal,
                    'idForm'=>'myformulario',
                      'url'=> \yii\helpers\Url::to(['/sigi/'.$this->context->id.'/'.(($model->isNewRecord)?'replace':'edit-replace').'-medidor','id'=>$id]),
                     'idGrilla'=>$gridName, 
                      ]
                  )?>
         
                  

            </div>
        </div>
    </div>
     
  
      <div class="box-body">
    
 
   
  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
     <?= 
            $form->field($model, 'tipo')->
            dropDownList($model->comboDataField('tipo') ,
                    ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                      'disabled'=>true,
                        ]
                    )  ?>
</div>
   <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
     <?= $form->field($modelAnt, 'frecuencia')->textInput(['disabled'=>true,'maxlength' => true]) ?>

 </div>         
          
 <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
     <?= $form->field($modelAnt, 'codpro')->textInput(['value'=>$modelAnt->clipro->despro,'disabled'=>true,'maxlength' => true]) ?>

 </div>   
  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
     <?= $form->field($modelAnt, 'codum')->textInput(['value'=>$model->um->desum,'disabled'=>true,'maxlength' => true]) ?>

 </div> 
    
 
          
<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
     <?= $form->field($modelAnt, 'numerocliente')->textInput(['disabled'=>true,'maxlength' => true]) ?>

 </div>
  <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
     <?= $form->field($model, 'codsuministro')->textInput(['maxlength' => true]) ?>

 </div>        
  <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
     <?= $form->field($modelAnt, 'activo')->checkBox([]) ?>

 </div>         
   <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
     <?= $form->field($modelAnt, 'plano')->checkBox(['disabled'=>true,]) ?>

 </div>   
 
  
<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
     <?= 
            $form->field($model, 'id_anterior')->
            dropDownList(comboHelper::IdsMedidoresByEdificio($modelAnt->edificio_id) ,
                    ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>true,
                        ]
                    )  ?>
</div>
  <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
     <?= $form->field($model, 'delta_anterior')->textInput(['maxlength' => true]) ?>

 </div> 
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'detalles')->textarea(['rows' => 4]) ?>

 </div>
    <?php ActiveForm::end(); ?>


    </div>
