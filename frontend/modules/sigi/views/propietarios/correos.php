<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
use common\widgets\spinnerWidget\spinnerWidget;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\sigi\models\SigiPropietariosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="sigi-propietarios-index">
   <?php  
   echo spinnerWidget::widget();
   $nombreGrilla= 'grilla_'.$id;
   $url=Url::to(['propietarios/agrega-mail','id'=>$id,'idGrilla'=>$nombreGrilla,'idModal'=>'buscarvalor']);
   ?>
    <p>
        <?= Html::a(Yii::t('base.labels', 'Agregar mail'),$url, ['class' => 'btn btn-success botonAbre']) ?>
    </p>
     <div class="box-body">
    <?php Pjax::begin(['id'=>$nombreGrilla]); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
    <div style='overflow:auto;'>
    <?= GridView::widget([
        'id'=>'moni',
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
                    'update' => function($url, $model) use($nombreGrilla) {
                        
                        $options = [
                            'class' => 'botonAbre',      
                            
                        ];
                        $url=Url::to(['/sigi/propietarios/edita-mail','id'=>$model->id,'idGrilla'=>$nombreGrilla,
                            'idModal'=>'buscarvalor']);
                        return Html::a('<span class="btn btn-info btn-sm glyphicon glyphicon-pencil"></span>', $url, $options/*$options*/);
                         },                        
                          'delete' => function ($url,$model) {
			   $url = \yii\helpers\Url::toRoute($this->context->id.'/deletemodel-for-ajax');
                              
                              return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['title'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                              
                              
                             } ,
                    ]
                ],
                
                'correo',
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
    </div>
</div>
    <?php 
   echo linkAjaxGridWidget::widget([
           'id'=>'widgetgruidBancos',
            'idGrilla'=>$nombreGrilla,
            'family'=>'holas',
          'type'=>'POST',
           'evento'=>'click',
       'posicion'=>\yii\web\View::POS_END,
            //'foreignskeys'=>[1,2,3],
        ]); 
   ?>          