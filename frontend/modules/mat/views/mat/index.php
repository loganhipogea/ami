<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\mat\models\MatReqSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Mat Reqs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mat-req-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <div class="box box-success">
     <div class="box-body">
    <?php Pjax::begin(); ?>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php  echo '.';  ?>
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
                    'update' => function($url,$model) {   
                       
                        $options = [
                            'title' => Yii::t('base.verbs', 'Update'),                            
                        ];
                        $url= \yii\helpers\Url::to(['/mat/mat/update','id'=>$model->id]);
                        return Html::a('<span class="btn btn-info btn-sm glyphicon glyphicon-pencil"></span>', $url, $options/*$options*/);
                         },
                        
                    ]
                ],
         
         
         
         
         

            
            'numero',
                            'item',
            'descridetalle',
            'fechaprog',
            'fechasol',
            'codtra',
            'ap',
            'am',
            //'descripcion',
            //'texto:ntext',
            //'codest',

          
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
    </div>
</div>
    </div>
       