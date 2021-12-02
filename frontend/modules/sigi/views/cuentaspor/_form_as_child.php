<?php
 use kartik\date\DatePicker;
 use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
use yii\helpers\Html;

use yii\grid\GridView;
use yii\widgets\Pjax;
use common\helpers\h;
use yii\widgets\ActiveForm;
use frontend\modules\sigi\helpers\comboHelper;
use common\widgets\selectwidget\selectWidget;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\SigiCuentaspor */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sigi-cuentaspor-form">
   
    <?php
    //$esEditable=$model->facturacion->isEditable();
    $esEditable=($modelFacturacion->isAprobado())?false:true; 
    //var_dump($modelFacturacion->isAprobado());die();
    $form = ActiveForm::begin(['id'=>'myformulario',
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
            <?php
              $url=\yii\helpers\Url::toRoute(['/sigi/'.$this->context->id.'/'.(($model->isNewRecord)?'create-as-child':'edita-cobranza'),'id'=>($model->isNewRecord)?$modelFacturacion->id:$model->id]); 
            //var_dump($url);die();
            ?>
          <?= \common\widgets\buttonsubmitwidget\buttonSubmitWidget::widget(
                  ['idModal'=>$idModal,
                    'idForm'=>'myformulario',
                      //'url'=>null,
                      'url'=> $url,
                     'idGrilla'=>$gridName, 
                      ]
                  )?>
         
                  

            </div>
        </div>
    </div>
      <div class="box-body">
    
 
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"> 
      <?= $form->field($model, 'edificio_id')->dropDownList(
             comboHelper::getCboEdificios(),
             ['disabled'=>'disabled']
             ) ?>
    
 </div> 
          
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
   
     <?= $form->field($model, 'colector_id')->dropDownList(
             comboHelper::getCboColectorMasivo(($model->isNewRecord)?$modelFacturacion->edificio_id:$model->edificio_id),
             ['prompt'=>yii::t('sigi.labels','--Escoja un valor--')]
             ) ?>
 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'codocu')->dropDownList(
 comboHelper::getCboDocuments(),
             ['prompt'=>yii::t('sigi.labels','--Escoja un valor--'),
                  'disabled'=>($esEditable)?false:true 
                 ]
             ) ?>
 </div>
  <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
     <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true, 'disabled'=>($esEditable)?false:true ]) ?>

 </div>
  <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
     <?= $form->field($model, 'numerodoc')->textInput(['maxlength' => true, 'disabled'=>($esEditable)?false:true ]) ?>

 </div>        
          
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
      <?= $form->field($model, 'codmon')->dropDownList(
 comboHelper::getCboMonedas(),
             ['prompt'=>yii::t('sigi.labels','--Escoja un valor--'),
                  'disabled'=>($esEditable)?false:true ]
             ) ?>

 </div>
         
  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <?php  //h::settings()->invalidateCache();  ?>
                       <?= $form->field($model, 'fedoc')->widget(DatePicker::class, [
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
                            'options'=>['class'=>'form-control',
                                 'disabled'=>($esEditable)?false:true ]
                            ]) ?>
</div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
      <?= $form->field($model, 'mes')->dropDownList(
 common\helpers\timeHelper::cboMeses(),
           ['disabled'=>'disabled']
             ) ?>

 </div>
          
<div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
      <?= $form->field($model, 'mesconsumo')->dropDownList(
 common\helpers\timeHelper::cboMeses(),
            ['prompt'=>yii::t('sigi.labels','--Escoja un valor--'),
                 'disabled'=>($esEditable)?false:true ]
             ) ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
      <?= $form->field($model, 'consumo')->textInput([ 'disabled'=>($esEditable)?false:true ]) ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
      <?= $form->field($model, 'anio')->dropDownList(
 common\helpers\timeHelper::cboAnnos(),
            ['disabled'=>'disabled']
             ) ?>

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
   <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'monto')->textInput(['maxlength' => true, 'disabled'=>($esEditable)?false:true ]) ?>

 </div>        
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'detalle')->textarea(['rows' => 6]) ?>

 </div>

 
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'codestado')->textInput(['disabled'=>true,'maxlength' => true]) ?>

 </div>
     
    <?php ActiveForm::end(); ?>

          
    
          
          
</div>
    </div>
