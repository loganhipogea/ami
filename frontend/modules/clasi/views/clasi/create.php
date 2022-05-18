<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\clasi\models\ClasiClases */

$this->title = Yii::t('app', 'Create Clasi Clases');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Clasi Clases'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clasi-clases-create">

    <h4><?= Html::encode($this->title) ?></h4>
<div class="box box-success">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>