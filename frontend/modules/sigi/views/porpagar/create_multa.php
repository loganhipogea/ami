<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\SigiPorpagar */

$this->title = Yii::t('sigi.labels', 'Crear sanción');
$this->params['breadcrumbs'][] = ['label' => Yii::t('sigi.labels', 'Sanciones'), 'url' => ['index-multa']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sigi-porpagar-create">

    <h4><?= Html::encode($this->title) ?></h4>
<div class="box box-success">
    <?= $this->render('_form_multa', [
        'model' => $model,
    ]) ?>

</div>
</div>