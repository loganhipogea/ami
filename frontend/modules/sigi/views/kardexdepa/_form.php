<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use common\widgets\buttonajaxwidget\buttonAjaxWidget;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\SigiKardexdepa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sigi-kardexdepa-form">
    <br>
        <div class="box-body">
    <?php $form = ActiveForm::begin([
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
     
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
        <?php if($model->aprobado) { ?>        
        <?= Html::submitButton('<span class="fa fa-save"></span>   '.Yii::t('app', 'Grabar'), ['class' => 'btn btn-success']) ?>
            <?php $url=Url::to(['/sigi/default/adj-voucher-user','id'=>$model->id, 'idModal'=>'buscarvalor']);  ?>       
          <?=Html::a('<span class="fa fa-book-reader"></span>   '.Yii::t('sta.labels', 'Adjuntar Voucher'),$url, [
              'id'=>'btn-add-test',
              'class'=> 'botonAbre btn btn-warning',])?>
        <?php } ?> 
            </div>
        </div>
    </div>
    
    
     <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

        <?php Pjax::begin(['id'=>'pjax-cantidad']); 
        echo "Monto cobrado total : <i style='font-weight:800;color:purple'>".Yii::$app->formatter->format($model->facturacion->montoCobrado(), 'decimal')."</i>  de   <i style='font-weight:800;color:purple'>".Yii::$app->formatter->format($model->facturacion->montoFacturado(),'decimal').'</i>';
               ?>
            <div class="progress">
                <?php 
                 $porcentajeCobranza=$model->facturacion->porcentajeCobranza();  ?>
                <div class="progress-bar bg-warning" role="progressbar" style="width: <?=$porcentajeCobranza?>%" aria-valuenow="<?=$porcentajeCobranza?>" aria-valuemin="0" aria-valuemax="100">AVANCE DE COBRANZA  <?=$porcentajeCobranza?>%</div>
            </div>
           <?php Pjax::end();  ?> 
    </DIV>
 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
     <?= $form->field($model, 'facturacion_id')->label(yii::t('sta.labels','Facturación'))->textInput(['value'=>$model->facturacion->descripcion,'disabled'=>true]) ?>
  </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
    <?= $form->field($model, 'edificio_id')->label(yii::t('sta.labels','Unidad negocio'))->textInput(['value'=>$model->edificio->nombre,'disabled'=>true]) ?>
  

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
    <?= $form->field($model, 'unidad_id')->label(yii::t('sta.labels','Unidad'))->textInput(['value'=>$model->unidad->nombre,'disabled'=>true]) ?>
  

 </div>
 
  
 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">    
 <?= $form->field($model, 'mes')->
            dropDownList(\common\helpers\timeHelper::cboMeses(),
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un Valor')."--",
                    // 'class'=>'probandoSelect2',
                    'disabled'=>true,
                        ]
                    ) ?>
 </div> 
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'fecha')->textInput(['maxlength' => true,'disabled'=>true,]) ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'anio')->textInput(['maxlength' => true,'disabled'=>true,]) ?>

 </div>
  
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'numerorecibo')->textInput(['value'=>$model->numeroReciboConsultado(),'disabled'=>true,'maxlength' => true]) ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'montoNominal')->label('Monto a cobrar')->textInput(['value'=>$model->montoCalculado(),'disabled'=>true,'maxlength' => true]) ?>

 </div>
         
  
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'detalles')->textarea(['rows' => 6]) ?>

 </div>
     
    <?php ActiveForm::end(); ?>
          
    
 
     
          
          
  

</div>
    </div>
