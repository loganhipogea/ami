<?php

use yii\helpers\Html;
use kartik\tabs\TabsX;


/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\Talleres */
ECHO \common\widgets\spinnerWidget\spinnerWidget::widget();
/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\SigiFacturacion */

$this->title = Yii::t('sigi.labels', 'Editar : {name}', [
    'name' => $model->descripcion,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('sigi.labels', 'Facturacion'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('sigi.labels', 'Editar');
?>
<div class="sigi-facturacion-update">
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
            'content'=> $this->render('_form',['esEditable'=>$esEditable,'model' => $model,'dataProviderCuentasPor' =>$dataProviderCuentasPor,]),
            'active' => true,
             'options' => ['id' => 'myvynID3'],
        ],
        [
          'label'=>'<i class="fa fa-users"></i> '.yii::t('sta.labels','Lecturas pendientes'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_lecturas',[ 'model' => $model,'dataProviderLecturasFaltan' =>$dataProviderLecturasFaltan]),
            'active' => false,
             'options' => ['id' => 'myownID4'],
        ],
       
        [
          'label'=>'<i class="fa fa-users"></i> '.yii::t('sta.labels','Lecturas tomadas'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_lecturastomadas',[ 'searchModelLecturas' => $searchModelLecturas,'model' => $model,'dataProviderLecturas' =>$dataProviderLecturas]),
            'active' => false,
             'options' => ['id' => 'myownI78979hD4'],
        ],
        
        [
          'label'=>'<i class="fa fa-users"></i> '.yii::t('sta.labels','Recibos'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_recibos',['esEditable'=>$esEditable, 'model' => $model]),
            'active' => false,
             'options' => ['id' => 'myownIdgdg78979hD4'],
        ],
       
    ],
]);  

