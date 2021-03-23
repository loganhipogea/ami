<?php
use yii\helpers\Html;
//use kartik\grid\GridView;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\helpers\timeHelper;
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\HighchartsAsset;
use dosamigos\chartjs\ChartJs;
?>
<div class="box box-body">
    <h4>Pagos</h4>
<?php
 Pjax::begin(['id'=>'grilla-deudas-pagos-'.$id]); ?>
    
   <?php 
  //echo frontend\modules\sigi\models\SigiMovimientosPre::find()->complete()->andWhere(['kardex_id'=>$id])->createCommand()->rawSql;die();
//var_dump((new SigiApoderadosSearch())->searchByEdificio($model->id)); die(); ?>
    <?= GridView::widget([
        'dataProvider' =>new \yii\data\ActiveDataProvider([
            'query'=> frontend\modules\sigi\models\SigiMovimientosPre::find()->complete()->andWhere(['kardex_id'=>$id])
        ]),
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'columns' => [
                  [
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{attach}{pdf}',
               'buttons' => [
                  'attach' => function($url, $model) {  
                         $url=\yii\helpers\Url::toRoute(['/finder/selectimage','isImage'=>false,
                             'idModal'=>'imagemodal',
                             'modelid'=>$model->id,
                             'extension'=> \yii\helpers\Json::encode(['jpg','png','pdf','jpeg']),
                              'nombreclase'=> str_replace('\\','_',get_class($model))]);
                        $options = [
                            'title' => Yii::t('sta.labels', 'Subir Archivo'),
                            'data-method' => 'get',
                            //'data-pjax' => '0',
                        ];
                        return Html::button('<span class="fa fa-upload"></span>', ['href' => $url, 'title' => 'Adjuntar Voucher de pago', 'class' => 'botonAbre btn btn-danger']);
                        //return Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', Url::toRoute(['view-profile','iduser'=>$model->id]), []/*$options*/);
                        },
                        
                        
                       /* 'pdf' => function ($url,$model) {
			   $url = \yii\helpers\Url::toRoute(['/sta/citas/report-inf-psicologico','id'=>$model->id,'gridName'=>'grid_docu','idModal'=>'buscarvalor']);
                              if($model->cita_id > 0 or $model->codocu=='104')
                              return \yii\helpers\Html::a('<span class="btn btn-warning fa fa-file-pdf"></span>', $url, ['data-pjax'=>'0','target'=>'_blank']);
                              return '';
                             } */
                    ]
                ],
                                
             
            
            
                /*[
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                            return GridView::ROW_COLLAPSED;
                                },
                            'detail' => function ($model, $key, $index, $column) {
                            return Yii::$app->controller->renderPartial('_detalle_fact_residente', ['kardex_id' => $model->id]);
                            },
                    //'headerOptions' => ['class' => 'kartik-sheet-style'], 
                    'expandOneOnly' => true
                ],*/
            'fechaop',
             'glosa'
        ],
    ]); ?>
    
    <?php
    
    
    
    ?>
    
    <?php Pjax::end(); ?>

</div>
