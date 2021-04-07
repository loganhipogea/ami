<?PHP
use yii\widgets\pjax;
use yii\grid\GridView;
use kartik\export\ExportMenu;
?>
<div class="box-body"> 



    <?php Pjax::begin(['id'=>'searceehKardex','timeout'=>false]); ?>
   
 <hr/> 
    <?php 
    $dataProvider=New \yii\data\ActiveDataProvider([
        'query'=> frontend\modules\sigi\models\VwSigiFacturecibo::find()->andWhere(['kardex_id'=>$model->id]),
    ]);
    
    $gridColumns=[
           // 'codigo',           
          //  'fecha',
           // 'numero',
           //'codgrupo',
        ['attribute'=>'desgrupo',
              // 'header'=>'Grupo',
                //'format' => ['decimal', 3],
                 //'pageSummary' => true,
               // 'contentOptions'=>['align'=>'right'],
              'value'=>function($model){
                
                 return substr($model->desgrupo,0,30);    
              }  
                ],
           // 'nombre',
           ['attribute'=>'descargo',
               'header'=>'Cargo',
                //'format' => ['decimal', 3],
                 //'pageSummary' => true,
               // 'contentOptions'=>['align'=>'right'],
              'value'=>function($model){
                
                  return substr($model->descargo,0,30);    
              }  
                ],
           ['attribute'=>'Lectura',
               'header'=>'Lect(m3)',
                'format' => ['decimal', 3],
                 //'pageSummary' => true,
                'contentOptions'=>['align'=>'right'],
              'value'=>function($model){
                
                 return $model->lectura;    
              }  
                ],
            ['attribute'=>'delta',
               'header'=>'Cons(m3)',
                'format' => ['decimal', 3],
                 //'pageSummary' => true,
                'contentOptions'=>['align'=>'right'],
              'value'=>function($model){
                
                 return $model->delta;    
              }  
                ],  
         ['attribute'=>'montototal',
                'format' => ['decimal', 3],
                 //'pageSummary' => true,
                'contentOptions'=>['align'=>'right'],
              'value'=>function($model){
                 
                 return $model->montototal;    
              }  
                ],
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
    
    echo ExportMenu::widget([
    'dataProvider' =>$dataProvider,
    'columns' =>  $gridColumns,
    'dropdownOptions' => [
        'label' => yii::t('sta.labels','Exportar'),
        'class' => 'btn btn-success'
                      ]
               ]).'<br><hr>'.GridView::widget([
        'dataProvider' => $dataProvider,
         //'summary' => '',
       // 'showPageSummary' => true,
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        //'filterModel' => $searchModel,
        'columns' =>$gridColumns, 
    ]); ?>
 
 
 
    <?php Pjax::end(); ?>
</div>

