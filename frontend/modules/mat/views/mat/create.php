<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\mat\models\MatReq */

$this->title = Yii::t('app', 'Create Mat Req');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Mat Reqs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mat-req-create">

    <h4><?= Html::encode($this->title) ?></h4>
<div class="box box-success">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>