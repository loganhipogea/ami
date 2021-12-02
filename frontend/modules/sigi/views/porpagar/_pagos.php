<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;

?>

   <div class="box box-body">
      <div class="col-md-12">
            <div class="form-group no-margin">                
              <?php  
                   /*if(!$model->isNewRecord) {
                       $url= Url::to(['/sigi/porpagar/crea-prog-pago','id'=>$model->id,'gridName'=>'grilla-pagos-programados','idModal'=>'buscarvalor']);
                         $options = [
                           'class'=>'botonAbre btn btn-success',
                            'data-pjax' => '0',
                        ];
                        echo Html::a('<span class="fa fa-cut"></span>'.yii::t('sigi.labels','Agregar movimiento'),$url,$options);
                   }   */
              ?> 
            </div>
        </div>
   
    
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
         
         
         
         
    <?php
    $grilla='grilla-pagos-programados';
    Pjax::begin(['id'=>$grilla]); ?>
    

    
    <?= GridView::widget([
        'dataProvider' => new \yii\data\ActiveDataProvider([
            'query'=>$model->getMovimientosPago(),
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
         
         
         
         
         'glosa',

           [    'attribute'=>'Oper',
               'value'=>function($model){
                        return $model->movBanco->fopera;
               }
               ],
          [    'attribute'=>'monto',
               'value'=>function($model){
                        return $model->monto;
               }
               ],
           
          
        ],
    ]); ?>
    <?php Pjax::end(); ?>

    </div>
   </div>
       

       