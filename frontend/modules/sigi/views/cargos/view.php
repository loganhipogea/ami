<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use frontend\modules\sigi\models\SigiCargos;
use frontend\modules\sigi\models\SigiBeneficios;

/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\SigiCargos */
$esbeneficio=$model instanceof SigiBeneficios;
$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' =>($esbeneficio)?Yii::t('sigi.labels', 'Centro beneficios'):Yii::t('sigi.labels', 'Conceptos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="sigi-cargos-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
        <?php if($model instanceof SigiCargos){ ?>
        <?= Html::a(Yii::t('sigi.labels', 'Editar cargo'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php } ?>
         <?php if($model instanceof SigiBeneficios){ ?>
        <?= Html::a(Yii::t('sigi.labels', 'Editar beneficio'), ['update-beneficio', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php } ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'codcargo',
            'descargo',
            'esegreso',
            'regular',
        ],
    ]) ?>

</div>
