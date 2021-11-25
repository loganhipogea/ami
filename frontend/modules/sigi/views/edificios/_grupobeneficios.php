<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
use frontend\modules\sigi\models\SigiBenegrupoedificioSearch;
use frontend\modules\sigi\models\SigiBenegrupoedificio;
?>
<div class="edificios-index_doycus">

     <div class="box-body">
         
<?php
 $url= Url::to(['agrega-bene','id'=>$model->id,'gridName'=>'grilla-grupobene','idModal'=>'buscarvalor']);
   echo  Html::button(yii::t('base.verbs','Insertar'), ['href' => $url, 'title' => yii::t('sta.labels','Agregar Agrupacion'),'id'=>'btn_grupos_edi', 'class' => 'botonAbre btn btn-success']); 
?> 

    <?php Pjax::begin(['id'=>'grilla-grupobene']); ?>
    <?php  //echo SigiBenegrupoedificio::find()->createCommand()->rawSql;  ?>
   <?php //var_dump((new SigiApoderadosSearch())->searchByEdificio($model->id)); die(); ?>
    <?= GridView::widget([
        'dataProvider' =>(new SigiBenegrupoedificioSearch())->searchByEdificio($model->id),
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'columns' => [
                 [
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{update}{delete}',
               'buttons' => [
                  'update' => function($url, $model) {   
                        $url= \yii\helpers\Url::to(['edita-bene','id'=>$model->id,'gridName'=>'grilla-grupobene','idModal'=>'buscarvalor']);
                        $options = [
                            'title' => Yii::t('base.verbs', 'Editar'), 
                            'class'=>'botonAbre',
                            'data-pjax'=>'0'
                        ];
                        return Html::a('<span class="btn btn-info btn-sm glyphicon glyphicon-pencil"></span>', $url, $options/*$options*/);
                         },
                        'delete' => function ($url,$model) {
			   $url = \yii\helpers\Url::toRoute($this->context->id.'/deletemodel-for-ajax');
                              return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['title'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                            }
                        
                    ]
                ],
                [
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                            return GridView::ROW_COLLAPSED;
                                },
                            'detail' => function ($model, $key, $index, $column) {
                            return Yii::$app->controller->renderPartial('/edificios/colectores/_colectores', ['model'=>$model,'grupo_id' => $model->id]);
                            },
                    //'headerOptions' => ['class' => 'kartik-sheet-style'], 
                    'expandOneOnly' => true
                ],
            'codgrupo',
              'descripcion', [
    'attribute' => 'activo',
    'format' => 'raw',
    'value' => function ($model) {
        return \yii\helpers\Html::checkbox('activo[]', $model->activo, [ 'disabled' => true]);

             },
          ],
        ],
    ]); ?>
         <?php 
   echo linkAjaxGridWidget::widget([
           'id'=>'widgetgruidBancos',
            'idGrilla'=>'grilla-grupobene',
            'family'=>'holas',
          'type'=>'POST',
           'evento'=>'click',
            //'foreignskeys'=>[1,2,3],
        ]); 
   ?>
       
   
     
         
    <?php Pjax::end(); ?>

    </div>
      </div>