<?PHP
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

?>
<div class="box-body"> 
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>S/.<?='    '.\yii::$app->formatter->asDecimal($model->deudaKardex(),3)?></h3>

              <p>Deuda Registrada</p>
            </div>
            <div class="icon">
                <span style="color:white;opacity:0.5;"><i class="fa fa-money"></i></span>
            </div>
            
          </div>
  </div>


    <?php Pjax::begin(['id'=>'searchKardex','timeout'=>false]); ?>

    <?php 
    $dataProvider=New \yii\data\ActiveDataProvider([
        'query'=>frontend\modules\sigi\models\SigiMovimientosPre::find()->andWhere(['kardex_id'=>$model->id,'activo'=>'1']),
    ]);
    
    $gridColumns=[
        
         
               /*[
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                            return GridView::ROW_COLLAPSED;
                                },
                'extraData'=>['identidad'=>function ($model) {
                            return $model->id;
                                }],
                     'detailUrl' =>Url::toRoute(['/sigi/kardexdepa/ajax-show-pagos']),
                     'expandOneOnly' => true
                ], */
             
           // 'numero',
            'glosa',
           // 'facturacion_id',
            //'operacion_id',
            //'edificio_id',
           // 'unidad_id',
           // 'mes',
            'fechaop',
            //'anio',
            //'codmon',
           // 'numrecibo',
                       //  'cancelado',
            ['attribute'=>'monto',
                'format' => ['decimal', 3],
                 //'pageSummary' => true,
                'contentOptions'=>['align'=>'right'],
              'value'=>function($model){
                 return $model->monto;    
              }  
                ],
                 
             
           // 'igv',
            //'detalles:ntext',

          
        ];
    
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => '',
       // 'showPageSummary' => true,
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        //'filterModel' => $searchModel,
        'columns' =>$gridColumns, 
    ]); ?>
 
 
 
    <?php Pjax::end(); ?>
</div>

