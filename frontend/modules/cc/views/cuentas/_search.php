<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\cc\models\CcCuentasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cc-cuentas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'tipo') ?>

    <?= $form->field($model, 'codmon') ?>

    <?= $form->field($model, 'codpro') ?>

    <?= $form->field($model, 'nombre') ?>

    <?php // echo $form->field($model, 'numero') ?>

    <?php // echo $form->field($model, 'banco_id') ?>

    <?php // echo $form->field($model, 'socio') ?>

    <?php // echo $form->field($model, 'detalles') ?>

    <?php // echo $form->field($model, 'indicaciones') ?>

    <?php // echo $form->field($model, 'indicaciones2') ?>

    <?php // echo $form->field($model, 'activa') ?>

    <?php // echo $form->field($model, 'saldo') ?>

    <?php // echo $form->field($model, 'cci') ?>

    <?php // echo $form->field($model, 'fecult') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
