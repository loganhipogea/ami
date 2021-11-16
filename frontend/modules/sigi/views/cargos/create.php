<?php

use yii\helpers\Html;
use frontend\modules\sigi\models\SigiBeneficios;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\SigiCargos */
$esbeneficio=$model instanceof SigiBeneficios;
$ACCION=($esbeneficio)?'Crear centro beneficio':'Crear concepto';
$this->title = Yii::t('sigi.labels', $ACCION);
$this->params['breadcrumbs'][] = ['label' => Yii::t('sigi.labels', 'Conceptos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sigi-cargos-create">

    <h4><?= Html::encode($this->title) ?></h4>
<div class="box box-success">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>