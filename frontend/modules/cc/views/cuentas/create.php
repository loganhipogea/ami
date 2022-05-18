<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\cc\models\CcCuentas */

$this->title = Yii::t('app', 'Create Cc Cuentas');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cc Cuentas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cc-cuentas-create">

    <h4><?= Html::encode($this->title) ?></h4>
<div class="box box-success">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>