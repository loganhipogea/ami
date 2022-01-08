<?php
use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\widgets\selectwidget\selectWidget;
use frontend\modules\sigi\helpers\comboHelper;
use frontend\modules\sigi\models\SigiUnidades;
//use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\SigiUnidades */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sigi-unidades-form">

    <?php $form = ActiveForm::begin([
    'fieldClass'=>'\common\components\MyActiveField',
        'enableAjaxValidation' => true
    ]); ?>
       
      <div class="box-body">
           <?= Html::submitButton('<span class="fa fa-save"></span>'.'  '.Yii::t('sigi.labels', 'Guardar'), ['class' => 'btn btn-success']) ?>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
    <?= $form->field($model, 'edificio_id')->label(yii::t('sta.labels','Edificio'))->textInput(['value'=>$model->edificio->nombre,'disabled'=>true,'maxlength' => true]) ?>

 </div>       
 <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> 
     
    <?php
    $data=($model->isNewRecord)?[]:comboHelper::getCboSameUnits($model->edificio_id);
   echo  $form->field($model, 'parent_id')->
            dropDownList($data,
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                     'disabled'=>true
                        ]
                    ) ?>
  
     </div>      
          
  <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">   
      
 <?= $form->field($model, 'codtipo')->
            dropDownList(comboHelper::getCboTipoUnidades(),
                  ['prompt'=>'--'.yii::t('base.verbs','--Seleccione un valor--')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>'true',
                        ]
                    ) ?>
 </div>
      
           
 <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">   
     <div class="block">
         <?=($model->isNewRecord)?Html::button('<span class="fa fa-refresh"></span>   ', ['id'=>'refresh-apo','class' => 'btn btn-success']):'' ?>
         
 <?php 
$data=($model->isNewRecord)?[]:comboHelper::getCboApoderados($model->edificio_id);
echo $form->field($model, 'codpro')->
            dropDownList($data,
                  ['prompt'=>'--'.yii::t('base.verbs','Escoja un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>true,
                        ]
                    ) ?>
    </div>    
 </div> 
          
     
  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
     <?= $form->field($model, 'nombre')->textInput(['disabled'=>true,'maxlength' => true]) ?>

 </div>     
  <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">    
 <?= $form->field($model, 'npiso')->
            dropDownList(comboHelper::getCboPisos(),
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                  // 'disabled'=>true,
                        ]
                    ) ?>
 </div> 
 <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
     <?= $form->field($model, 'numero')->textInput([/*'disabled'=>true,*/'maxlength' => true]) ?>
  </DIV>
    
         
          
          
          
  
 <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
     <?= $form->field($model, 'area')->textInput([/*'disabled'=>true,*/'maxlength' => true]) ?>

 </div>
  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
     <?= $form->field($model, 'imputable')->checkBox([/*'disabled'=>true,*/]) ?>

 </div>
     <?php if($model->hasManyPropietarios()){  ?>
<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
     <?= $form->field($model, 'resumirprop')->checkBox([/*'disabled'=>true,*/]) ?>

 </div>
  <?php } ?>

  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'detalles')->textarea([/*'disabled'=>true,*/'rows' => 6]) ?>

 </div>
  <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
      <?PHP IF(!$model->isNewRecord){ ?>
     <?=Html::label(yii::t('base.names','Participacion'),'45545rrxet',['class' => 'control-label']) ?>
           
            <?=  Html::textInput('45545rrxet',  $model->participacionArea(),['disabled'=>true,'class' => 'form-control form-group']) ?>
          
 </div>
      <?PHP } ?>
    <?php ActiveForm::end(); ?>

</div>
    </div>
<?php 
  $this->registerJs("$('#refresh-apo').on( 'click', function() { 
     // alert(this.id);
     var identidad=$('#sigiunidades-edificio_id').val();
    if(identidad==''){
                          var n = Noty('id');                      
                              $.noty.setText(n.options.id, '".yii::t('sigi.errors','Seleccione el edificio primero')."');
                              $.noty.setType(n.options.id, 'error'); 
                              return;
    }
      $.ajax({
              url: '".\yii\helpers\Url::to(['/sigi/unidades/fill-apoderados'])."', 
              type: 'get',
              data:{id:identidad},
              dataType: 'html', 
              error:  function(xhr, textStatus, error){               
                            var n = Noty('id');                      
                              $.noty.setText(n.options.id, error);
                              $.noty.setType(n.options.id, 'error');       
                                }, 
              success: function(data) {
              $('#sigiunidades-codpro').html(data);
                   
                        }
                        });


             })", \yii\web\View::POS_READY);
?>