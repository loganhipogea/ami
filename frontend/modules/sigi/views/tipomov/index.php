<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use frontend\modules\sigi\helpers\comboHelper;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\sigi\models\SigiTipomovSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('sigi.labels', 'Tipos movimientos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sigi-tipomov-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <div class="box box-success">
     <div class="box-body">
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('sigi.labels', 'Crear'), ['create'], ['class' => 'btn btn-success']) ?>
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
                'template' => '{update}',
                'buttons' => [
                    'update' => function($url, $model) {                        
                        $options = [
                            'title' => Yii::t('base.verbs', 'Update'),                            
                        ];
                        return Html::a('<span class="btn btn-info btn-sm glyphicon glyphicon-pencil"></span>', $url, $options/*$options*/);
                         },
                    ]
                ],
         
         
         
         
         
            ['attribute'=>'edificio_id',
                'filter'=> comboHelper::getCboEdificios(),
                'value'=>function($model){
                    return $model->edificio->nombre;         
                  }
                ],            
            'codigo',
            'descripcion',
                        [
    'attribute' => 'conciliable',
    'format' => 'raw',
    'value' => function ($model) {
        return \yii\helpers\Html::checkbox('conciliable[]', $model->conciliable, [ 'disabled' => true]);

             },

          ],

          
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
    </div>
</div>
    </div>
       