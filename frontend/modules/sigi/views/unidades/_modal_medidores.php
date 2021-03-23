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
                      'url'=> \yii\helpers\Url::to(['/sigi/'.$this->context->id.'/'.(($model->isNewRecord)?'agrega':'edita').'-medidor','id'=>$id]),
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
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    )  ?>
</div>
   <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
     <?= $form->field($model, 'frecuencia')->textInput(['maxlength' => true]) ?>

 </div>         
          
  <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">  
   <?php 
  // $necesi=new Parametros;
   
    echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'form'=>$form,
            'campo'=>'codpro',
             'addCampos'=>[2,3],
            //'foreignskeys'=>[1,2,3],
        ]);  ?>
    </div>
 
           <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">  
   <?php 
  // $necesi=new Parametros;
   
    echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'form'=>$form,
            'campo'=>'codum',
             'addCampos'=>[1],
            //'foreignskeys'=>[1,2,3],
        ]);  ?>
    </div>
<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
     <?= $form->field($model, 'numerocliente')->textInput(['maxlength' => true]) ?>

 </div>
  <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
     <?= $form->field($model, 'codsuministro')->textInput(['maxlength' => true]) ?>

 </div>        
  <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
     <?= $form->field($model, 'activo')->checkBox([]) ?>

 </div>         
   <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
     <?= $form->field($model, 'plano')->checkBox([]) ?>

 </div>   
 
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'detalles')->textarea(['rows' => 4]) ?>

 </div>

     
    <?php ActiveForm::end(); ?>


    </div>
