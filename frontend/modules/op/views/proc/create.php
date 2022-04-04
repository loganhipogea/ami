<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\op\models\OpProcesos */

$this->title = Yii::t('app', 'Create Op Procesos');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Op Procesos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="op-procesos-create">

    <h4><?= Html::encode($this->title) ?></h4>
<div class="box box-success">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>