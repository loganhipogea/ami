<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\SigiPorpagar */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('sigi.labels', 'Docs por pagar'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="sigi-porpagar-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
        <?= Html::a(Yii::t('sigi.labels', 'Editar pago'), ['update-pagar', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
       
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'codocu',
            'edificio_id',
            'unidad_id',
            'monto',
            'igv',
            'codpresup',
            'monto_usd',
            'glosa',
            'fechadoc',
            'codestado',
            'detalle:ntext',
        ],
    ]) ?>

</div>
