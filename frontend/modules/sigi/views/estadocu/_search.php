<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\SigiEstadocuentasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sigi-estadocuentas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'edificio_id') ?>

    <?= $form->field($model, 'cuenta_id') ?>

    <?= $form->field($model, 'saldmesant') ?>

    <?= $form->field($model, 'ingresos') ?>

    <?php // echo $form->field($model, 'egresos') ?>

    <?php // echo $form->field($model, 'saldfinal') ?>

    <?php // echo $form->field($model, 'saldecuenta') ?>

    <?php // echo $form->field($model, 'salddif') ?>

    <?php // echo $form->field($model, 'mes') ?>

    <?php // echo $form->field($model, 'anio') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
