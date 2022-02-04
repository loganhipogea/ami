<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
/* @var $this yii\web\View */
/* @var $searchModel common\models\masters\MaestrocompoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('base.names', 'Materials');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="maestrocompo-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('base.verbs', 'Create').' '.Yii::t('base.names', 'Material'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
  <?php 
  $gridColumns= [
          
           
            'codart',
            'descripcion',
            'marca',
            'modelo',
            'um.codum',
            ['attribute' => 'imagen',
                'format'=>'raw',
                'value'=>function($model){
                            if($model->hasAttachments())
                            return \yii\helpers\Html::img ($model->files[0]->url,['width'=>50,'height'=>50]);
                            } 
                
                ],
            //'numeroparte',
            //'codum',
            //'peso',
            //'codtipo',
            //'esrotativo',

            ['class' => 'yii\grid\ActionColumn'],
        ];

  ?>
     <?=ExportMenu::widget([
    'dataProvider' => $dataProvider,
          
    'columns' => $gridColumns,
    'dropdownOptions' => [
        'label' => yii::t('sta.labels','Exportar'),
        'class' => 'btn btn-success'
    ]
]) . "<br><hr>\n".GridView::widget([
        'dataProvider' => $dataProvider,
      
    
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'filterModel' => $searchModel,
        'columns' => $gridColumns,
    ]); ?>
    
   
    <?php Pjax::end(); ?>
</div>
