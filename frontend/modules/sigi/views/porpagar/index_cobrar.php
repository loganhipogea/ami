<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
  use common\widgets\spinnerWidget\spinnerWidget;
    ECHO spinnerWidget::widget();
$this->title = Yii::t('sigi.labels', 'Documentos por cobrar');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sigi-porpagar-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <div class="box box-success">
     <div class="box-body">
    <?php Pjax::begin(); ?>
    <?php echo $this->render('_search_cobrar', ['model' => $searchModel]); ?>

    <p>
        <?='.'?>
       </p>
    <div style='overflow:auto;'>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
       // 'filterModel' => $searchModel,
        'columns' => [
            
         
         [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{view}',
                'buttons' => [
                    'update' => function($url,$model) {  
                        $url=Url::toRoute(['/sigi/porpagar/update-cobrar','id'=>$model->id]);
                        $options = [
                              'data-pjax'=>'0',
                            'title' => Yii::t('base.verbs', 'Update'),                            
                        ];
                        return Html::a('<span class="btn btn-info btn-sm glyphicon glyphicon-pencil"></span>', $url, $options/*$options*/);
                         },
                          'view' => function($model) {   
                        $url=Url::to(['/sigi/porpagar/view-cobrar','id'=>$model->id]);
                        
                        $options = [
                            'title' => Yii::t('base.verbs', 'View'),                            
                        ];
                        return Html::a('<span class="btn btn-warning btn-sm glyphicon glyphicon-search"></span>', $url, $options/*$options*/);
                         },
                         
                    ]
                ],
         
         
         
         
         

           [    'attribute'=>'Documento',
               'value'=>function($model){
                        return $model->documento->desdocu;
               }
               ],
              'numdocu',
           [    'attribute'=>'Edificio',
               'value'=>function($model){
                        return $model->edificio->codigo;
               }
               ],
            [    'attribute'=>'Proveedor',
               'value'=>function($model){
                        return substr($model->clipro->despro,0,20);
               }
               ],
             'fechadoc', 
             'fechaprog', 
            'codmon',
            'monto',
             [    'attribute'=>'Pagado',
               'value'=>function($model){
                        return $model->montoPagado()*-1;
               }
               ],
            //'igv',
            //'codpresup',
            //'monto_usd',
            //'glosa',
            //'fechadoc',
            //'codestado',
            //'detalle:ntext',

          
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
    </div>
</div>
    </div>
       