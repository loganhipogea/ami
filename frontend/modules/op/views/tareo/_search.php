<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\op\models\OpTareoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="op-tareo-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'fecha') ?>

    <?= $form->field($model, 'hinicio') ?>

    <?= $form->field($model, 'hfin') ?>

    <?= $form->field($model, 'descripcion') ?>

    <?php // echo $form->field($model, 'direcc_id') ?>

    <?php // echo $form->field($model, 'proc_id') ?>

    <?php // echo $form->field($model, 'os_id') ?>

    <?php // echo $form->field($model, 'detos_id') ?>

    <?php // echo $form->field($model, 'detalle') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
