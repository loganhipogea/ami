<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\op\models\OpTareo */

$this->title = Yii::t('app', 'Create Op Tareo');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Op Tareos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="op-tareo-create">

    <h4><?= Html::encode($this->title) ?></h4>
<div class="box box-success">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>