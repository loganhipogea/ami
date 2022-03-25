<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\mat\models\MatReq */

$this->title = Yii::t('app', 'Crear requerimiento');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Reqerimientos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mat-req-create">

  <h4><i class="fa fa-cube"></i><?= Html::encode($this->title) ?></h4>
<div class="box box-success">
    <?= $this->render('_form', [
        'model' => $model,
       // 'aprobado'=>$aprobado,
    ]) ?>

</div>
</div>