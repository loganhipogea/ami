<?php
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
/* @var $this yii\web\View */
/* @var $searchModel common\models\masters\CliproSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('base.names', 'Propietarios');

?>
<div class="box box-success">
<div class="clipro-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <?php Pjax::begin(['id'=>'propietarios']); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="btn-group">  
        
   
   <?php 
   $gridColumns=[
           ['class' => 'yii\grid\ActionColumn',
                'template'=>'{update}{view}',
                'buttons'=>[
                    'update'=>function($url,$model){
                        $url=\yii\helpers\Url::toRoute(['/sigi/propietarios/update','id'=>$model->id]);
                        return \yii\helpers\Html::a(
                                '<span class="btn btn-success glyphicon glyphicon-pencil"></span>',
                                $url,
                                ['data-pjax'=>'0']
                                );
                     },
                     'view'=>function($url,$model){
                        $url=\yii\helpers\Url::toRoute(['/sigi/propietarios/view','id'=>$model->id]);
                        return \yii\helpers\Html::a(
                                '<span class="btn btn-success glyphicon glyphicon-search"></span>',
                                $url,
                                ['data-pjax'=>'0']
                                );
                     },
                           
                   ]
                ],
           [
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                            return GridView::ROW_COLLAPSED;
                                },
                      'detail' => function ($model, $key, $index, $column) {
                            return $this->render('/propietarios/correos', ['model'=>$model,'id'=>$model->id]);
                            },
                    //'headerOptions' => ['class' => 'kartik-sheet-style'], 
                    'expandOneOnly' => true
                ],
            'id',
            ['attribute'=>'unidad_id',
                'value'=>function($model){
                         return $model->unidad->nombre;
                }
               // 'filter'=> \frontend\modules\sigi\helpers\comboHelper::getCboUnitsByEdificio($id_edificio)
             //'group'=>true
             ],
             ['attribute'=>'nombre',
             //'group'=>true
             ],
            'codepa',
            'correo',
            [
    'attribute' => 'edificio_id',
    'value' => 'edificio.nombre',
    'filter' => frontend\modules\sigi\helpers\comboHelper::getCboEdificios(),
  //'group'=>true,
                ],
            
        ];
   ?>

        <?php echo ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
    'dropdownOptions' => [
        'label' => yii::t('sta.labels','Exportar'),
        'class' => 'btn btn-success'
    ]
]) . "<br><hr>\n".GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
         //'summary' => '',
        //'tableOptions'=>['class'=>".thead-dark table table-condensed table-hover table-bordered table-striped"],
        'columns' => $gridColumns,
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

