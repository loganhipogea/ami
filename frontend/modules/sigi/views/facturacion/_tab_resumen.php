<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
use common\helpers\ComboHelper;
use common\widgets\selectwidget\selectWidget;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\Edificios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="facturacion-form">
    <br>
    <?php $form = ActiveForm::begin([
   // 'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
        
       </div>
      <div class="box-body">
          
          
 
  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
     <?= $form->field($model, 'id')->label(yii::t('sta.labels','MONTO TOTAL FACTURADO :'))->textInput(['disabled' => true,'value'=>$model->montoFacturado()]) ?>

 </div>
  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
     <?= $form->field($model, 'reporte_id')->label(yii::t('sta.labels','CANTIDAD DE RECIBOS :'))->textInput(['disabled' => true,'value'=>$model->numeroRecibos()]) ?>

  </div>
  
    <?php ActiveForm::end(); ?>

</div>
    </div>
 