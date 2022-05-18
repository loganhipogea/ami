<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\op\models\OpPlanestarifaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="op-planestarifa-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'codigo') ?>

    <?= $form->field($model, 'porc_dominical') ?>

    <?= $form->field($model, 'porc_feriado') ?>

    <?= $form->field($model, 'porc_nocturno') ?>

    <?php // echo $form->field($model, 'porc_localizacion') ?>

    <?php // echo $form->field($model, 'porc_refrigerio') ?>

    <?php // echo $form->field($model, 'porc_hextras') ?>

    <?php // echo $form->field($model, 'nhoras') ?>

    <?php // echo $form->field($model, 'hinicio_nocturno') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
