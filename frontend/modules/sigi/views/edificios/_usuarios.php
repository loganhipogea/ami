<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use frontend\modules\sigi\models\SigiApoderadosSearch;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
?>
<div class="edificios-indexhghg">

     <div class="box-body">
         
<?php
 $url= Url::to(['agrega-user','id'=>$model->id,'gridName'=>'grilla-apoderados','idModal'=>'buscarvalor']);
   echo  Html::button(yii::t('base.verbs','Insertar '), ['href' => $url, 'title' => yii::t('sta.labels','Agregar Usuario'),'id'=>'btn_usuario', 'class' => 'botonAbre btn btn-success']); 
?> 
         
    <?php Pjax::begin(['id'=>'grilla-usuarios-edificio']); ?>
    
   <?php //var_dump((new SigiApoderadosSearch())->searchByEdificio($model->id)); die(); ?>
    <?= GridView::widget([
        'dataProvider' =>new yii\data\ActiveDataProvider([
            'query'=> frontend\modules\sigi\models\SigiUserEdificios::find()->where(['edificio_id'=>$model->id])
        ]),
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'columns' => [
                  [
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{delete}',
               'buttons' => [
                    'delete' => function ($url,$model) {
			   $url = \yii\helpers\Url::toRoute($this->context->id.'/deletemodel-for-ajax');
                              return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['title'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                            }
                      
                        
                    ]
                ],
           
            'usuario.username',
            'usuario.email',
        ],
    ]); ?>
         
         
    <?php 
   echo linkAjaxGridWidget::widget([
           'id'=>'widgetgruidBafncos',
            'idGrilla'=>'grilla-usuarios-edificio',
            'family'=>'holas',
          'type'=>'POST',
           'evento'=>'click',
       'posicion'=>\yii\web\View::POS_END,
            //'foreignskeys'=>[1,2,3],
        ]); 
   ?>     
    <?php Pjax::end(); ?>

    </div>
 </div>
       