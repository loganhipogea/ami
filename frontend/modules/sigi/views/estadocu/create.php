<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\SigiEstadocuentas */

$this->title = Yii::t('app', 'Create Sigi Estadocuentas');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sigi Estadocuentas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sigi-estadocuentas-create">

    <h4><?= Html::encode($this->title) ?></h4>
<div class="box box-success">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>