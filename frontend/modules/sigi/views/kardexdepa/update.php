<?php

use yii\helpers\Html;
use kartik\tabs\TabsX;


/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\Talleres */
ECHO \common\widgets\spinnerWidget\spinnerWidget::widget();
/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\SigiKardexdepa */

$this->title = Yii::t('app', 'Actualizar kardex: {name}', [
    'name' => $model->id,
    
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sigi Kardexdepas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="sigi-kardexdepa-update">
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
            'content'=> $this->render('_form',['model' => $model]),
            'active' => true,
             'options' => ['id' => 'myveryownID3'],
        ],
        [
          'label'=>'<i class="fa fa-users"></i> '.yii::t('sta.labels','Documentos'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_segunda',[ 'model' => $model]),
            'active' => false,
             'options' => ['id' => 'myveryownID4'],
        ],
        [
          'label'=>'<i class="fa fa-users"></i> '.yii::t('sta.labels','Pagos'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_pagos',[ 'model' => $model]),
            'active' => false,
             'options' => ['id' => 'myvXDEyownID4'],
        ],
        [
          'label'=>'<i class="fa fa-users"></i> '.yii::t('sta.labels','Detalle'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_detalle',['model' => $model]),
            'active' => false,
             'options' => ['id' => 'yownID4'],
        ],
       
    ],
]);  

?>
        
            
        </DIV>
</DIV>