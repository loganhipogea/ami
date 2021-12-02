<?php
use kartik\datetime\DateTimePicker;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


use frontend\modules\sigi\helpers\comboHelper;
use common\widgets\selectwidget\selectWidget;
use common\helpers\h;


/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\CitasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="citas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
    <div class="form-group">
        <?= Html::submitButton("<span class='fa fa-search'></span>     ".Yii::t('sta.labels', 'buscar'), ['class' => 'btn btn-primary']) ?>
         <?php // Html::resetButton("<span class='fa fa-eye'></span>     ".Yii::t('sta.labels', 'Limpiar'), ['class' => 'btn btn-success']) ?>
       <?php // Html::button("<span class='fa fa-eye'></span>     ".Yii::t('sta.labels', 'Ver'), ['onClick'=>"$('#buscador').toggle()",  'class' => 'btn btn-success']) ?>
         <?= Html::a(Yii::t('sigi.labels', 'Crear documento'), ['crear-pago'], ['data-pjax'=>'0','class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('sigi.labels', 'Crear documento inputadp'), ['crear-pago','inputado'=>'1'], ['data-pjax'=>'0','class' => 'btn btn-success']) ?>
    
    </div>
     </div>
    
   <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12"> 
     <?php 
  // $necesi=new Parametros;
    echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'form'=>$form,
            'campo'=>'codpro',
         'ordenCampo'=>1,
         'addCampos'=>[2],
        ]);  ?>

 </div>      
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'codocu')->dropDownList(
 comboHelper::getCboDocuments(),
             ['prompt'=>yii::t('sigi.labels','--Escoja un valor--')]
             ) ?>
 </div>  
 <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
     <?= $form->field($model, 'edificio_id')->dropDownList(
 comboHelper::getCboEdificios(),
             ['prompt'=>yii::t('sigi.labels','--Escoja un valor--')]
             ) ?>
 </div> 
    
     <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
     <?= $form->field($model, 'glosa')->textInput(['maxlength' => true]) ?>

 </div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
     <?= $form->field($model, 'monto')->textInput(['maxlength' => true]) ?>

 </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
     <?= $form->field($model, 'monto1')->textInput(['maxlength' => true]) ?>

 </div>
 
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <?php 
      
        echo $form->field($model, 'fechaprog')->widget(
        DatePicker::classname(), [
         'name' => 'fechaprog',
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
        echo $form->field($model, 'fechaprog1')->widget(
        DatePicker::classname(), [
         'name' => 'fechaprog1',
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
  
 
   

    <?php ActiveForm::end(); ?>

</div>
