<?php
use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
 use kartik\date\DatePicker;

use common\helpers\h;
use frontend\modules\sigi\helpers\comboHelper;
use frontend\modules\sigi\models\SigiSuministros;
use common\widgets\selectwidget\selectWidget;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\SigiUnidades */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sigi-unidades-form">
    <div class="alert alert-info"><span class='fa fa-building'></span><?='   '.$model->grupo->edificio->nombre.'   '?><span class='fa fa-arrow-right'></span><?='  '.$model->grupo->descripcion?></div>
    
    
    <?php $form = ActiveForm::begin([
        'id'=>'myformulario'/*,'enableAjaxValidation'=>true*/
    ]); ?>
      <div class="box-header">
          
        <div class="col-md-12">
            <div class="form-group no-margin">
          <?= \common\widgets\buttonsubmitwidget\buttonSubmitWidget::widget(
                  ['idModal'=>$idModal,
                    'idForm'=>'myformulario',
                    'title'=>'<span class="fa fa-save"></span>'.'    '.yii::t('base.verbs','Guardar'),
                      'url'=> \yii\helpers\Url::to(['/sigi/'.$this->context->id.'/'.(($model->isNewRecord)?'agrega':'edita').'-concepto-tree','id'=>(($model->isNewRecord)?$id:$model->id)]),
                     'idGrilla'=>$gridName, 
                      ]
                  )?>
         
                  

            </div>
        </div>
    </div>
     
  
      <div class="box-body">
    
 <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">    
  <?php 
  // $necesi=new Parametros;
    echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'form'=>$form,
            'campo'=>'cargo_id',
         'ordenCampo'=>2,
        'filterWhere'=>[['esegreso'=>'1']]
         //'addCampos'=>[2,3],
        ]);  ?>
 </div>
 <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
     <?= 
            $form->field($model, 'tipomedidor')->
            dropDownList(SigiSuministros::comboDataField('tipo') ,
                    ['prompt'=>'--'.yii::t('base.verbs','Seleecione un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    )  ?>
</div>
          
 <div class="col-lg-4 col-md-3 col-sm-12 col-xs-12">    
 <?= $form->field($model, 'tasamora')->textInput([]) ?>
 </div> 
  <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">    
 <?= $form->field($model, 'monto')->textInput([]) ?>
 </div>           
          
<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
     <?= 
            $form->field($model, 'frecuencia')->
            dropDownList($model::frecuencias() ,
                    ['prompt'=>'--'.yii::t('base.verbs','Seleecione un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    )  ?>
</div> 
<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">    
 <?= $form->field($model, 'regular')->checkbox([]) ?>
 </div>    
     <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">    
 <?= $form->field($model, 'montofijo')->checkBox([]) ?>
 </div>
   <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">    
 <?= $form->field($model, 'individual')->checkBox([]) ?>
 </div>
     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">    
 <?= $form->field($model, 'detalle')->textarea([]) ?>
 </div>     
    
        

     
    <?php ActiveForm::end(); ?>

</div>
    </div>
