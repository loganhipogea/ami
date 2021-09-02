<?php
use kartik\export\ExportMenu;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
use common\widgets\spinnerWidget\spinnerWidget;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\sigi\models\SigiFacturacionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('sigi.labels', 'Movimientos bancarios');
$this->params['breadcrumbs'][] = ['label' => Yii::t('sigi.labels', 'Movimientos'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => Yii::t('sigi.labels', 'Ir a Facturacion'), 'url' => ['update','id'=>$model->id]];

?>
<div class="sigi-facturacion-index">
<?PHP   ECHO spinnerWidget::widget();    ?>
    <h4><?= Html::encode($this->title) ?></h4>
    <div class="box box-success">
     <div class="box-body">
         
         
    <?php Pjax::begin(['id'=>'grilla_m','timeout'=>false]); ?>
    <?php  echo $this->render('_search_movimientos_bancarios', ['model' => $searchModel]); ?>

  <?php 
  $gridColumns=[
            
         
         [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{edit}{delete}',
                'buttons' => [
                    'edit' => function($url, $model) {  
                         $url=\yii\helpers\Url::toRoute(['/sigi/movimientos/edit-mov-banco','id'=>$model->id,'isImage'=>false,'idModal'=>'buscarvalor','gridName'=>'grilla_m','nombreclase'=> str_replace('\\','_',get_class($model))]);
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
                          'view' => function($url, $model) {                        
                        $options = [
                            'title' => Yii::t('base.verbs', 'View'),                            
                        ];
                        return Html::a('<span class="btn btn-warning btn-sm glyphicon glyphicon-search"></span>', $url, $options/*$options*/);
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
                'extraData'=>['identidad'=>function ($model) {
                            return $model->id;
                                }],
                     'detailUrl' =>Url::toRoute(['/sigi/movimientos/ajax-show-conc']),
                    //'headerOptions' => ['class' => 'kartik-sheet-style'], 
                    'expandOneOnly' => true
                ], 
         
         [
                'attribute'=>'edificio_id',
                //'filter'=>frontend\modules\sigi\helpers\comboHelper::getCboEdificios(),
                'value' => function($model) { 
                        //var_dump($model);die();
                        return $model->edificio->nombre ;
                         },
                // 'group'=>true,   
            ],
         'fopera',
         'descripcion',
         [
                'attribute'=>'tipomov',
                //'filter'=>frontend\modules\sigi\helpers\comboHelper::getCboEdificios(),
                'value' => function($model) { 
                        //var_dump($model);die();
                        //return $model->tipomov;
                        return $model->tipoMov->descripcion ;
                         },
                 //'group'=>true,   
            ],
           'monto',
            'monto_conciliado',  
            'diferencia',
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
      
     'showPageSummary' => true,
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        //'filterModel' => $searchModel,
        'columns' => $gridColumns,
    ]); ?>
         
        <?php 
   echo linkAjaxGridWidget::widget([
           'id'=>'widgetgruidBancos',
            'idGrilla'=>'grilla_m',
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
    </div>
       