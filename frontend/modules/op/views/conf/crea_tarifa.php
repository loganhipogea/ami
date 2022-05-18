<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\op\models\OpPlanestarifa */

$this->title = Yii::t('app', 'Crear tarifa');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tarifas'), 'url' => ['masters/trabajadores/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="op-planestarifa-create">

    <h4><?= Html::encode($this->title) ?></h4>
  <div class="box box-success">
     <div class="box-body">
    <?= $this->render('_form_tarifa', [
        'model' => $model,
    ]) ?>

  </div>
    </div>
