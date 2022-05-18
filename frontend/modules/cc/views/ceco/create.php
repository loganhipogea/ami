<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\cc\models\CcCc */

$this->title = Yii::t('app', 'Create Cc Cc');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cc Ccs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cc-cc-create">

    <h4><?= Html::encode($this->title) ?></h4>
<div class="box box-success">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>