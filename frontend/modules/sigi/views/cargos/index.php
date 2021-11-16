<?php
use kartik\export\ExportMenu;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use frontend\modules\sigi\models\SigiBeneficiosSearch;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\sigi\models\SigiCargosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$esbeneficio=$searchModel instanceof SigiBeneficiosSearch;
$nomb=$accion=($esbeneficio)?'Beneficios':'Conceptos'; 
$this->title = Yii::t('sigi.labels', $nomb);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sigi-cargos-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <div class="box box-success">
     <div class="box-body">
    <?php Pjax::begin(['id'=>'gridCargos']); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

     <div class="btn-group">  
         <?PHP 
         $accion=(!$esbeneficio)?'Crear concepto':'Crear Beneficio';
         $url=(!$esbeneficio)?'create':'crea-beneficio';
         $url_ed=(!$esbeneficio)?'update':'update-beneficio';
         ?>
        <?= Html::a(Yii::t('sigi.labels', $accion), [$url], ['class' => 'btn btn-success']) ?>
       <?php 
       $gridColumns= [
            
         ['class' => 'yii\grid\ActionColumn',
                'template'=>'{update}{view}{delete}',
                'buttons'=>[
                    'update'=>function($url,$model) use($url_ed){
                        $url=\yii\helpers\Url::toRoute([$url_ed,'id'=>$model->id]);
                        return \yii\helpers\Html::a(
                                '<span class="btn btn-success glyphicon glyphicon-pencil"></span>',
                                $url,
                                ['data-pjax'=>'0']
                                );
                     },
                     'view'=>function($url,$model){
                        $url=\yii\helpers\Url::toRoute(['view','id'=>$model->id]);
                        return \yii\helpers\Html::a(
                                '<span class="btn btn-success glyphicon glyphicon-search"></span>',
                                $url,
                                ['data-pjax'=>'0']
                                );
                     },
                             'delete' => function ($url,$model) {
			    $url = \yii\helpers\Url::toRoute($this->context->id.'/deletemodel-for-ajax');
                             return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['title'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                            }
                   ]
                ],
         'id',
         'codcargo',
            'descargo',
            
        ];
       
       
       echo ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
    'dropdownOptions' => [
        'label' => yii::t('sta.labels','Exportar'),
        'class' => 'btn btn-success'
    ]
        ]); ?>
     </div>
    <div style='overflow:auto;'>
    <?php echo "<hr>\n".GridView::widget([
        'dataProvider' => $dataProvider,
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'filterModel' => $searchModel,
        'columns'=>$gridColumns ,
    ]); ?>
        
        <?php 
   echo linkAjaxGridWidget::widget([
           'id'=>'widgetgridBancos',
            'idGrilla'=>'gridCargos',
            'family'=>'holas',
          'type'=>'POST',
           'evento'=>'click',
            //'foreignskeys'=>[1,2,3],
        ]); 
   ?>
    <?php Pjax::end(); ?>
</div>
    </div>
</div>
    </div>
       