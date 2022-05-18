<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\op\models\OpPlanestarifa */

$this->title = Yii::t('app', 'Editar plan: {name}', [
    'name' => $model->codigo,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Planes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->codigo, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Editar');
?>
<div class="op-planestarifa-update">

    <h4><?= Html::encode($this->title) ?></h4>
   <div class="box box-success">
     <div class="box-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div></div>
</div>
