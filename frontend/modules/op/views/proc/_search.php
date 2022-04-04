<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\op\models\OpProcesosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="op-procesos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'numero') ?>

    <?= $form->field($model, 'fechaprog') ?>

    <?= $form->field($model, 'fechaini') ?>

    <?= $form->field($model, 'numoc') ?>

    <?php // echo $form->field($model, 'codpro') ?>

    <?php // echo $form->field($model, 'descripcion') ?>

    <?php // echo $form->field($model, 'tipo') ?>

    <?php // echo $form->field($model, 'codestado') ?>

    <?php // echo $form->field($model, 'textocomercial') ?>

    <?php // echo $form->field($model, 'textointerno') ?>

    <?php // echo $form->field($model, 'textotecnico') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
