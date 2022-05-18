<?php
   use yii\grid\GridView;
   use yii\helpers\Html;
   use yii\helpers\Url;
   use yii\widgets\Pjax;
   ?>
<div style='overflow:auto;'>
   <?php Pjax::begin(['id'=>'pjax-neo']); ?>
    <?= GridView::widget([
        'dataProvider' => $dataproviderCarac,
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'filterModel' => $searchModelCarac,
        'columns' => [
            
         
         [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}{view}',
                'buttons' => [
                    'update' => function($url,$model) { 
                           $url=\yii\helpers\Url::to(['/clasi/clasi/mod-edita-cara','id'=>$model->codigo,'gridName'=>'pjax-neo','idModal'=>'buscarvalor']);
                        $options = [
                            'title' => Yii::t('base.verbs', 'Update'), 
                            'class'=>'botonAbre'
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
 <?= Html::a(Yii::t('app', 'Crear característica'), \yii\helpers\Url::to(['/clasi/clasi/mod-agrega-cara','gridName'=>'pjax-neo','idModal'=>'buscarvalor']), ['class' => 'botonAbre btn btn-success']) ?>
    </p>
 
