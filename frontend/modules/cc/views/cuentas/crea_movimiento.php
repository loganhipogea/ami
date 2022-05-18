<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\cc\models\CcCuentas */

$this->title = Yii::t('app', 'Crear movimiento');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Movimientos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cc-cuentas-create">

    <h4><?= Html::encode($this->title) ?></h4>
<div class="box box-success">
    <?= $this->render('_form_movimiento', [
        'model' => $model,
    ]) ?>

</div>
</div>