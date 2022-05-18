<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\mat\models\MatOc */

$this->title = Yii::t('app', 'Create Mat Oc');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Mat Ocs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mat-oc-create">

    <h4><?= Html::encode($this->title) ?></h4>
<div class="box box-success">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>