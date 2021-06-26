<?php

use yii\helpers\Html;
use kartik\tabs\TabsX;


/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\Talleres */
ECHO \common\widgets\spinnerWidget\spinnerWidget::widget();
/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\SigiPorpagar */

$this->title = Yii::t('sigi.labels', 'Editar Sanción: {name}', [
    'name' => $model->descripcion,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('sigi.labels', 'Sanciones'), 'url' => ['index-multa']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('sigi.labels', 'Editar');
?>
<div class="sigi-porpagar-update">
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
            'content'=> $this->render('_form_multa',['model' => $model]),
            'active' => true,
             'options' => ['id' => 'myveryownID3'],
        ],
        [
          'label'=>'<i class="fa fa-file"></i> '.yii::t('sta.labels','Adjunto'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_segunda_multa',[ 'model' => $model]),
            'active' => false,
             'options' => ['id' => 'myveryownID4'],
        ],
       
        [
          'label'=>'<i class="fa fa-calendar"></i> '.yii::t('sta.labels','Pagos'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_pagos_multa',[ 'model' => $model]),
            'active' => false,
             'options' => ['id' => 'myveryowttnID4'],
        ], 
       
    ],
]);  
?>
</div> </div>