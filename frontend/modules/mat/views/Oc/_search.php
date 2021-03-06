<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\mat\models\MatOcSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mat-oc-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'numero') ?>

    <?= $form->field($model, 'fecha') ?>

    <?= $form->field($model, 'codpro') ?>

    <?= $form->field($model, 'codtra') ?>

    <?php // echo $form->field($model, 'descripcion') ?>

    <?php // echo $form->field($model, 'textointerno') ?>

    <?php // echo $form->field($model, 'fpago') ?>

    <?php // echo $form->field($model, 'texto') ?>

    <?php // echo $form->field($model, 'codest') ?>

    <?php // echo $form->field($model, 'codmon') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
