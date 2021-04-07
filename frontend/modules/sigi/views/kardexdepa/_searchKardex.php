<?php
use yii\helpers\Url;
use yii\helpers\Html;
use common\helpers\h;
use kartik\date\DatePicker;
use yii\widgets\ActiveForm;
use frontend\modules\sigi\models\SigiSuministros;
use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
  use common\widgets\spinnerWidget\spinnerWidget;
    ECHO spinnerWidget::widget();
/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\EdificiosSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="sigi-kardexdepasearch-index">
  

    <?php $form = ActiveForm::begin([
       
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>
   <div class="form-group">
        <?= Html::submitButton("<span class='fa fa-search'></span>     ".Yii::t('sta.labels', 'buscar'), ['class' => 'btn btn-primary']) ?>
        <?php //echo  Html::a(Yii::t('app', 'Create Sigi Kardexdepa'), ['create'], ['class' => 'btn btn-success']) ?>
        
        
    </div>



 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <?php 
      
        echo $form->field($model, 'fecha')->widget(
        DatePicker::classname(), [
         'name' => 'fecha',
            'language' => h::app()->language,
            'options' => ['placeholder' =>yii::t('sta.labels', '--Seleccione un valor--')],
    //'convertFormat' => true,
                'pluginOptions' => [
                'format' => h::getFormatShowDate(),
                //'startDate' => '01-Mar-2014 12:00 AM',
                'todayHighlight' => true
                                ]
                    ]);
                ?>
  </div> 
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <?php 
        echo $form->field($model, 'fecha1')->widget(
        DatePicker::classname(), [
         'name' => 'fecha1',
            'options' => ['placeholder' =>yii::t('sta.labels', '--Seleccione un valor--')],
    //'convertFormat' => true,
                'pluginOptions' => [
                'format' => h::getFormatShowDate(),
                //'startDate' => '01-Mar-2014 12:00 AM',
                'todayHighlight' => true
                                ]
                    ]);
                ?>
  </div>  

    
  
  

<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
<?php 
echo $form->field($model, 'edificio_id')->
            dropDownList(\frontend\modules\sigi\helpers\comboHelper::getCboEdificios(),
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un Valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
 </div>  
    
 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <?php 
             echo $form->field($model, 'numero') ?>
 </div> 
    
    
    
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
<?php 
echo $form->field($model, 'anio')->
            dropDownList(\common\helpers\timeHelper::cboAnnos(),
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un Valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
 </div>  
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <?php echo $form->field($model, 'mes')->
            dropDownList(\common\helpers\timeHelper::cboMeses(),
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un Valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
</div> 
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> 
 <?php echo $form->field($model, 'numerorecibo');?>
</div>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> 
 <?php echo $form->field($model, 'monto');?>
</div>    
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <?php echo $form->field($model, 'deudor')->
            dropDownList(['1'=>yii::t('base.labels','Sólo Deudores')],
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un Valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
</div>   
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    
</div>   
    <?php ActiveForm::end(); ?>
<?php echo "."; ?>
</div>
