<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
use frontend\modules\sigi\models\SigiPropietariosSearch;
?>
<div class="edificios-index_docus">

     <div class="box-body">
         
<?php
 $url= Url::to(['agrega-residente','id'=>$model->id,'gridName'=>'grilla-residentes','idModal'=>'buscarvalor']);
   echo  Html::button(yii::t('base.verbs','Insertar Residente'), ['href' => $url, 'title' => yii::t('sta.labels','Agregar Residente'),'id'=>'btn_cuentas_edi', 'class' => 'botonAbre btn btn-success']); 
?> 
         
    <?php Pjax::begin(['id'=>'grilla-residentes']); ?>
    
   <?php //var_dump((new SigiApoderadosSearch())->searchByEdificio($model->id)); die(); ?>
    <?= GridView::widget([
        'id'=>'grilla-grid-residentes',
        'dataProvider' =>(new SigiPropietariosSearch())->searchByUnidad($model->id),
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'columns' => [
                 [
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{edit}{main}{delete}',
               'buttons' => [
                    'edit' => function($url, $model) {  
                         $url=\yii\helpers\Url::toRoute(['/sigi/unidades/edita-residente','id'=>$model->id,'isImage'=>false,'idModal'=>'buscarvalor','gridName'=>'grilla-residentes','nombreclase'=> str_replace('\\','_',get_class($model))]);
                        $options = [
                            'title' => Yii::t('sta.labels', 'Editar'),
                            //'aria-label' => Yii::t('rbac-admin', 'Activate'),
                            //'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                            'data-method' => 'get',
                            'data-pjax' => '0',
                        ];
                        return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['href' => $url, 'title' => 'Editar ', 'class' => 'botonAbre btn btn-success']);
                        //return Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', Url::toRoute(['view-profile','iduser'=>$model->id]), []/*$options*/);
                     
                        
                        },
                        'main' => function ($url,$model) {
			   $url = \yii\helpers\Url::toRoute([$this->context->id.'/ajax-main-recibo','id'=>$model->id]);
                              return \yii\helpers\Html::a('<span class="btn btn-warning glyphicon glyphicon-tags"></span>', '#', ['title'=>$url,'family'=>'holas','id'=>$model->id]);
                            },
                        'delete' => function ($url,$model) {
			   $url = \yii\helpers\Url::toRoute($this->context->id.'/deletemodel-for-ajax');
                              return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['title'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                            }
                        
                    ]
                ],
            'nombre',
              'dni',              
            'correo',
            'celulares',
            'fijo',
            'tipo',
            //'finicio',
            //'fcese',
               [
    'attribute' => 'activo',
    'format' => 'raw',
    'value' => function ($model) {
        return \yii\helpers\Html::checkbox('activo[]', $model->activo, [ 'disabled' => true]);

             },

          ],
                     
         [
    'attribute' => 'recibo',
    'format' => 'raw',
    'value' => function ($model) {
        return \yii\helpers\Html::checkbox('recibo[]', $model->recibo, [ 'disabled' => true]);

             },

          ],
        ],
    ]); ?>
         <?php 
   echo linkAjaxGridWidget::widget([
           'id'=>'widgetgruidBancos',
            'idGrilla'=>'grilla-residentes',
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