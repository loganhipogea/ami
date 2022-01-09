<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\sigi\models\SigiTransferenciasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('sigi.labels', 'Transferencias');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sigi-transferencias-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <div class="box box-success">
     <div class="box-body">
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('sigi.labels', 'Crear Transferencia'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div style='overflow:auto;'>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'filterModel' => $searchModel,
        'columns' => [
         [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                          'view' => function($url, $model) {                        
                        $options = [
                            'title' => Yii::t('base.verbs', 'View'),                            
                        ];
                        return Html::a('<span class="btn btn-warning btn-sm glyphicon glyphicon-search"></span>', $url, $options/*$options*/);
                         },
                    ]
                ],
            ['attribute'=>'edificio_id',
                'filter'=> frontend\modules\sigi\helpers\comboHelper::getCboEdificios(),
                'value'=>function($model){
                    return $model->edificio->nombre;         
                  }
                ],
           ['attribute'=>'unidad.numero',],
            'fecha',
            'nombre',
           
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
    </div>
</div>
    </div>
       