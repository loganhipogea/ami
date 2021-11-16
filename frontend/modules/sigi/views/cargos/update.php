<?php

use yii\helpers\Html;
use kartik\tabs\TabsX;
use frontend\modules\sigi\models\SigiBeneficios;

/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\Talleres */
ECHO \common\widgets\spinnerWidget\spinnerWidget::widget();
/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\SigiCargos */
$esbeneficio=$model instanceof SigiBeneficios;
$url=($esbeneficio)?'view-beneficio':'view';
$url_ben=($esbeneficio)?'index-beneficios':'index';
$this->title = Yii::t('sigi.labels', 'Editar: {name}', [
    'name' => $model->codcargo,
]);
$this->params['breadcrumbs'][] = ['label' =>($esbeneficio)?Yii::t('sigi.labels', 'Centros de beneficio'):Yii::t('sigi.labels', 'Cargos'), 'url' => [$url_ben]];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => [$url, 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('sigi.labels', 'Update');
?>
<div class="sigi-cargos-update">
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
          'label'=>'<i class="fa fa-users"></i> '.yii::t('sta.labels','Auditoría'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_segunda',[ 'model' => $model]),
            'active' => false,
             'options' => ['id' => 'myveryownID4'],
        ],
       
        
       
    ],
]);  
?>
</div>
</div>