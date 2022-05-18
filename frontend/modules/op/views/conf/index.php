<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\op\models\OpPlanestarifaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Planes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="op-planestarifa-index">
  <div class="box box-success">
     <div class="box-body">
    <h4><?= Html::encode($this->title) ?></h4>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Crear'), ['create'], ['class' => 'btn btn-info']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'codigo',
            'porc_dominical',
            'porc_feriado',
            'porc_nocturno',
            //'porc_localizacion',
            //'porc_refrigerio',
            //'porc_hextras',
            //'nhoras',
            //'hinicio_nocturno',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
 </div>
