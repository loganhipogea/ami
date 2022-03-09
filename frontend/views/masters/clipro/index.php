<?php
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
/* @var $this yii\web\View */
/* @var $searchModel common\models\masters\CliproSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('base.names', 'Clipros');

?>
<div class="box box-success">
<div class="clipro-index"> 

    <h4><?= Html::encode($this->title) ?></h4>
    <?php Pjax::begin(['id'=>'clipropj']); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="btn-group">  
        <?= Html::a('<span class="fa fa-industry"></span>'.'  '.Yii::t('app', 'Crear Empresa'), ['create'], ['class' => 'btn btn-success']) ?>
   
   
    <?php
 echo ExportMenu::widget([
    'dataProvider' => $dataProvider,    
    'columns' => ['codpro',
            'despro',
            'rucpro'],
    'dropdownOptions' => [
        'label' => yii::t('sta.labels','Exportar'),
        'class' => 'btn btn-success'
    ]
]).' 
    </div>
 <hr>
         '.GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        // 'summary' => '',
        //'tableOptions'=>['class'=>".thead-dark table table-condensed table-hover table-bordered table-striped"],
        'columns' => [
           ['class' => 'yii\grid\ActionColumn',
                'template'=>'{update}{view}{delete}',
                'buttons'=>[
                    'update'=>function($url,$model){
                        $url=\yii\helpers\Url::toRoute(['update','id'=>$model->codpro]);
                        return \yii\helpers\Html::a(
                                '<span class="btn btn-success glyphicon glyphicon-pencil"></span>',
                                $url,
                                ['data-pjax'=>'0']
                                );
                     },
                     'view'=>function($url,$model){
                        $url=\yii\helpers\Url::toRoute(['view','id'=>$model->codpro]);
                        return \yii\helpers\Html::a(
                                '<span class="btn btn-success glyphicon glyphicon-search"></span>',
                                $url,
                                ['data-pjax'=>'0']
                                );
                     },
                             'delete' => function ($url,$model) {
			    $url = \yii\helpers\Url::toRoute($this->context->id.'/deletemodel-for-ajax');
                             return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['title'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->codpro,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                            }
                   ]
                ],
           
            'codpro',
            'despro',
            'alias',
            'rucpro',
           ['attribute'=>'deslarga',
               'value'=>function ($model) {
                     return $model->deslarga;
			     }
               
               ]
            //'deslarga:ntext',

              
        ],
    ]); ?>
    
    
    <?php 
   echo linkAjaxGridWidget::widget([
           'id'=>'widgetgridBancos',
            'idGrilla'=>'clipropj',
            'family'=>'holas',
          'type'=>'POST',
           'evento'=>'click',
            //'foreignskeys'=>[1,2,3],
        ]); 
   ?>
    
    <?php Pjax::end(); ?>
</div>
    
</div>

