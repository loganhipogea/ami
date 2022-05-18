   <?php
   use yii\grid\GridView;
   use yii\helpers\Html;
   use yii\helpers\Url;
   use yii\widgets\Pjax;
   ?>
<div style='overflow:auto;'>
   <?php Pjax::begin(['id'=>'pjax-neote']); ?>
    <?= GridView::widget([
        'dataProvider' => $dataprovider,
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'filterModel' => $searchModel,
        'columns' => [
            
         
         [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}{view}',
                'buttons' => [
                    'update' => function($url,$model) { 
                           $url=\yii\helpers\Url::to(['/clasi/clasi/update-clase','id'=>$model->codigo,]);
                        $options = [
                            'title' => Yii::t('base.verbs', 'Update'), 
                            //'class'=>'botonAbre'
                            'target'=>'_blank'
                        ];
                        return Html::a('<span class="btn btn-info btn-sm glyphicon glyphicon-pencil"></span>', $url, $options/*$options*/);
                         },
                          'view' => function($url, $model) {                        
                        $options = [
                            'title' => Yii::t('base.verbs', 'View'),                            
                        ];
                        return Html::a('<span class="btn btn-warning btn-sm glyphicon glyphicon-search"></span>', $url, $options/*$options*/);
                         },
                         'delete' => function($url, $model) {                        
                        $options = [
                            'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                            'title' => Yii::t('base.verbs', 'Delete'),                            
                        ];
                        return Html::a('<span class="btn btn-danger btn-sm glyphicon glyphicon-remove"></span>', $url, $options/*$options*/);
                         }
                    ]
                ],
         
         
         
         
         

            'codigo',
            'descripcion',
            'user_id',

          
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
 <?= Html::a(Yii::t('app', 'Crear clase'), \yii\helpers\Url::to(['/clasi/clasi/mod-agrega-clase','gridName'=>'pjax-neote','idModal'=>'buscarvalor']), ['class' => 'botonAbre btn btn-success']) ?>
    </p>
 
