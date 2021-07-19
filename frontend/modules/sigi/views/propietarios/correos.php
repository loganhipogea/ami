<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\sigi\models\SigiPropietariosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="sigi-propietarios-index">
   <?php  
   $url=Url::to(['/propietarios/agrega-mail','id'=>$id]);
   ?>
    <p>
        <?= Html::a(Yii::t('base.labels', 'Agregar mail'),$url, ['class' => 'btn btn-success botonAbre']) ?>
    </p>
     <div class="box-body">
    <?php Pjax::begin(['id'=>'grilla_correos']); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
    <div style='overflow:auto;'>
    <?= GridView::widget([
        'dataProvider' =>new \yii\data\ActiveDataProvider([
            'query'=> frontend\modules\sigi\models\SigiMailsprop::find()->andWhere(['propietario_id'=>$id])
        ]),
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        //'filterModel' => $searchModel,
        'columns' => [
            
         
         [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}',
                'buttons' => [
                    'update' => function($url, $model) {                        
                        $options = [
                            'title' => Yii::t('base.verbs', 'Update'),                            
                        ];
                        return Html::a('<span class="btn btn-info btn-sm glyphicon glyphicon-pencil"></span>', $url, $options/*$options*/);
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
                
                'correo',
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
    </div>
</div>
           