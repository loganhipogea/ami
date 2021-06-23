<?php
use frontend\modules\sigi\helpers\comboHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\helpers\h;
 use kartik\date\DatePicker;
 use kartik\datetime\DateTimePicker;
 use common\widgets\selectwidget\selectWidget;
  use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
  //ECHO \common\widgets\spinnerWidget\spinnerWidget::widget();
/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\SigiPorpagar */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sigi-porpagar-form">
    <br>
    <?php $form = ActiveForm::begin([
    'fieldClass'=>'\common\components\MyActiveField',
        'id'=>'miform',
    ]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
                
        <?= Html::submitButton('<span class="fa fa-save"></span>   '.Yii::t('sigi.labels', 'Guardar'), ['class' => 'btn btn-success']) ?>
             
            </div>
        </div>
    </div>
      <div class="box-body">
      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
      <?= $form->field($model, 'tipo')->dropDownList(
 $model::comboDataField('tipo'),
             ['prompt'=>yii::t('sigi.labels','--Escoja un valor--')]
             ) ?>

    </div>     
          
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
     <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true,'disabled'=>$model->hasChilds()]) ?>

  </div>
 
  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"> 
     
    <?= ComboDep::widget([
               'model'=>$model,               
               'form'=>$form,
               'data'=> comboHelper::getCboEdificios(),
               'campo'=>'edificio_id',
               'idcombodep'=>'sigisanciones-unidad_id',
               'source'=>[\frontend\modules\sigi\models\SigiUnidades::className()=>
                                [
                                  'campoclave'=>'id' , //columna clave del modelo ; se almacena en el value del option del select 
                                     'camporef'=>'numero',//columna a mostrar 
                                        'campofiltro'=>'edificio_id'  
                                ]
                                ],
                            ]
               
               
        )  ?>
     


 </div> 
    <div class="col-lg-6 col-md-8 col-sm-6 col-xs-12">
     <?php
     if($model->isNewRecord){
         $dati=[];
     }else{
         $dati= comboHelper::getCboUnitsByEdificio($model->edificio_id);
     }
     ?>
     <?= ComboDep::widget([
               'model'=>$model,               
               'form'=>$form,
               'data'=> $dati,
               'campo'=>'unidad_id',
               'idcombodep'=>'sigisanciones-propietario_id',
               'source'=>[\frontend\modules\sigi\models\SigiPropietarios::className()=>
                                [
                                  'campoclave'=>'id' , //columna clave del modelo ; se almacena en el value del option del select 
                                     'camporef'=>'nombre',//columna a mostrar 
                                        'campofiltro'=>'unidad_id'  
                                ]
                                ],
                            ]
               
               
        )  ?>
 </div>      
          
          
          
          
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
       <?php
     if($model->isNewRecord){
         $dati=[];
     }else{
         $dati= comboHelper::getCboPropietarios($model->unidad_id);
     }
     ?>
      
     <?= $form->field($model, 'propietario_id')->dropDownList(
                    $dati,
             ['prompt'=>yii::t('sigi.labels','--Escoja un valor--')]
             ) ?>
 </div>
 
 <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <?php  //h::settings()->invalidateCache();  ?>
                       <?= $form->field($model, 'fecha',['enableAjaxValidation'=>true])->widget(DatePicker::class, [
                             'language' => h::app()->language,
                           // 'readonly'=>true,
                          // 'inline'=>true,
                           'pluginOptions'=>[
                                     'format' => h::gsetting('timeUser', 'date')  , 
                                  'changeMonth'=>true,
                                  'changeYear'=>true,
                                 'yearRange'=>"-99:+0",
                               ],
                           
                            //'dateFormat' => h::getFormatShowDate(),
                            'options'=>['class'=>'form-control']
                            ]) ?>
</div>         
 <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <?php 
         echo $form->field($model, 'focurrencia')->widget(
        DateTimePicker::classname(), [
         'name' => 'focurrencia',
            'language' => h::app()->language,
            'options' => ['placeholder' =>yii::t('sta.labels', '--Seleccione un valor--')],
    //'convertFormat' => true,
                'pluginOptions' => [
                'format' => h::getFormatShowDateTime(),
                //'startDate' => '01-Mar-2014 12:00 AM',
                'todayHighlight' => true
                                ]
                    ]);  
     
       
                 ?>
</div>              
          
          
 
          
          

 
  
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'detalle')->textarea(['rows' => 6]) ?>

 </div>
     
          
          
    <?php ActiveForm::end(); ?>
          
      

</div>
    </div>
