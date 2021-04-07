<?php
use kartik\export\ExportMenu;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\sigi\models\SigiFacturacionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('sigi.labels', 'Detalle Lecturas ');
$this->params['breadcrumbs'][] = ['label' => Yii::t('sigi.labels', 'Facturaciones'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => Yii::t('sigi.labels', 'Ir a Facturacion'), 'url' => ['update','id'=>$model->id]];

?>
<div class="sigi-facturacion-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <div class="box box-success">
     <div class="box-body">
         
         
    <?php Pjax::begin(['id'=>'grilla_lecturas']); ?>
    <?php  echo $this->render('_searchLecturas', ['model' => $searchModel]); ?>

  <?php 
  $gridColumns=[
            
         
         [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{attach}',
             
                'buttons' => [
                     'attach' => function($url, $model) {  
                         $url=\yii\helpers\Url::toRoute(['/finder/selectimage','isImage'=>true,
                             'idModal'=>'imagemodal',
                             'modelid'=>$model->id,
                             'extension'=> \yii\helpers\Json::encode(['jpg','png','jpeg']),
                             'nombreclase'=> str_replace('\\','_',get_class($model->registroLectura))]);
                        $options = [
                            'title' => Yii::t('sta.labels', 'Subir Archivo'),
                            'data-method' => 'get',
                            //'data-pjax' => '0',
                        ];
                        return Html::button('<span class="glyphicon glyphicon-paperclip"></span>', ['href' => $url, 'title' => 'Adjuntar Voucher de pago', 'class' => 'botonAbre btn btn-danger']);
                        //return Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', Url::toRoute(['view-profile','iduser'=>$model->id]), []/*$options*/);
                        },
                   'update' => function($url, $model) {  
                       $url= Url::to(['/sigi/unidades/edita-lectura','id'=>$model->id,'gridName'=>'grilla_lecturas','idModal'=>'buscarvalor']);
                         $options = [
                           'class'=>'botonAbre',
                            //'title' => Yii::t('sta.labels', 'Editar'),
                            //'aria-label' => Yii::t('rbac-admin', 'Activate'),
                            //'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                            //'data-method' => 'get',
                           // 'data-pjax' => '0',
                             //'target'=>'_blank'
                        ];
                        //return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['href' => $url, 'title' => 'Editar Adjunto', 'class' => ' btn btn-sm btn-success']);
                       
                         return Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>',$url,$options);
                     
                        
                        },
                    'view' => function($url, $model) {                        
                        $options = [
                            'title' => Yii::t('base.verbs', 'View'),                            
                        ];
                        return Html::a('<span class="btn btn-warning btn-sm glyphicon glyphicon-search"></span>', $url, $options/*$options*/);
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
         
         'codigo',
         'nombre',
        'numero',
           'anio',
                 'mes',                 
            'flectura',
            'codsuministro',
            //'areadepa',
           //'codgrupo',
              'codum',
            'codtipo',
              ['attribute'=>'lectura',
                            'format' => ['decimal', 2],
                            //'pageSummary' => true,
                            ]    ,
             ['attribute'=>'delta',
                            'format' => ['decimal', 2],
                            'pageSummary' => true,
                            ]    ,
             'facturable'
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
    <?php Pjax::end(); ?>

    </div>
</div>
    </div>
       