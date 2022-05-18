<?php

use yii\helpers\Html;
use kartik\tabs\TabsX;


/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\Talleres */
ECHO \common\widgets\spinnerWidget\spinnerWidget::widget();
/* @var $this yii\web\View */
/* @var $model frontend\modules\cc\models\CcCuentas */

$this->title = Yii::t('app', 'Editar comprobante: {name}', [
    'name' => $model->glosa,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Movimientos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view-mov', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Editar');
?>
<div class="cc-cuentas-update">
<h4><i class="fa fa-edit"></i><?= Html::encode($this->title) ?></h4>
   
    <div class="box box-success">
    
    <?php echo TabsX::widget([
    'position' => TabsX::POS_ABOVE,
     'bordered'=>true,
    'align' => TabsX::ALIGN_LEFT,
      'encodeLabels'=>false,
    'items' => [
        [
          'label'=>'<i class="fa fa-home"></i> '.yii::t('sta.labels','Principal'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_form_comprobante',['model' => $model]),
            'active' => true,
             'options' => ['id' => 'myveryownID3'],
        ],
        [
          'label'=>'<i class="fa fa-users"></i> '.yii::t('sta.labels','Calificacion'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_comprobante_calificacion',[ 'model' => $model]),
            'active' => false,
             'options' => ['id' => 'myveryownID4'],
        ],
       
        
       
    ],
]);  
?>
</div>
</div>