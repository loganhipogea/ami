<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

?>
<div class="sigi-porpagar-index">

   
    <div class="box box-success">
     <div class="box-body">
    <?php
    $grilla='grilla-pagos-programados';
    Pjax::begin(['id'=>$grilla]); ?>
    

    <div style='overflow:auto;'>
    <?= GridView::widget([
        'dataProvider' => new \yii\data\ActiveDataProvider([
            'query'=>$model->getProgramaPagos(),
        ]),
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
       // 'filterModel' => $searchModel,
        'columns' => [
            
         
         [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{edit}{view}',
                'buttons' => [
                                 
                       'edit' => function($url, $model) use($grilla) {  
                         $url=\yii\helpers\Url::toRoute(['/sigi/porpagar/edit-prog-pago','id'=>$model->id,'isImage'=>false,'idModal'=>'buscarvalor','gridName'=>$grilla,'nombreclase'=> str_replace('\\','_',get_class($model))]);
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
                         
                    ]
                ],
         
         
         
         
         

           [    'attribute'=>'Documento',
               'value'=>function($model){
                        return $model->fechaprog;
               }
               ],
          
           
          
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
    </div>
</div>
    </div>
       