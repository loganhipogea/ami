<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use common\helpers\timeHelper;
use common\helpers\h;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
  //echo frontend\modules\sigi\models\SigiMovimientosPre::find()->complete()->andWhere(['kardex_id'=>$id])->createCommand()->rawSql;die();
//var_dump((new SigiApoderadosSearch())->searchByEdificio($model->id)); die();
$formato=h::formato();
$columns=[
            
            
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
            //'fechaop',
            ['attribute'=>'Numero',
                'value'=>function($model){
                     $kardex=$model->kardex;
                       if($model->isKardex()){
                           return $kardex->numerorecibo;
                       }else{ 
                           return $kardex->numdocu;
                           
                       }  
                    }  
                  
                  ],
           ['attribute'=>'Doc',
              'format'=>'raw',
                'value'=>function($model){
                     $kardex=$model->kardex;
                       if($model->isKardex()){
                          $url=Url::to(['/sigi/kardexdepa/update','id'=>$kardex->id]);
                          $options=['data-pjax'=>'0','target'=>'_blank'];
                           return Html::a('RECIBO DEL MES DE '.timeHelper::mes($kardex->mes).' - '.$kardex->anio,$url,$options);
                       }else{ 
                           $url=Url::to(['/sigi/porpagar/update-cobrar','id'=>$kardex->id]);
                          $options=['data-pjax'=>'0','target'=>'_blank'];
                           return Html::a($kardex->documento->desdocu,$url,$options);
                           
                       }  
                    }  
                  
                  ],
             'tipomov',
              ['attribute'=>'glosa',
                   'header'=>'Descrip',
                  ],                       
             ['attribute'=>'Emisor',
                 
               'format'=>'raw',
                'value'=>function($model){
                               $kardex=$model->kardex;
                       if($model->isKardex()){
                           return $kardex->unidad->nombre;
                       }else{                         
                           if(!empty($kardex->codpro)){
                             return $model->kardex->clipro->despro;  
                           }else{
                              return $model->kardex->unidad->nombre; 
                           }
                          //return $model->kardex->unidad->nombre;
                       }
                           }  
                  
                  ],
              ['attribute'=>'monto',
                  'contentOptions'=>['style'=>'text-align:right;'],
                'value'=>function($model) use($formato){
                     return $formato->asDecimal($model->monto,2);   
                }  
                  
                  ],
            /*['attribute'=>'Monto Doc',
                'contentOptions'=>['style'=>'text-align:right;'],
                'value'=>function($model) use($formato){
                     return $formato->asDecimal($model->kardex->monto,2);   
                   }  
                  
                  ],*/
              
            
        ];
?>
<?php 
$dataProvider=new \yii\data\ActiveDataProvider([
            'query'=> frontend\modules\sigi\models\SigiMovimientosPre::find()->andWhere(['resumen_id'=>$model->id])
        ]);
echo ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
    'dropdownOptions' => [
        'label' => yii::t('sta.labels','Exportar'),
        'class' => 'btn btn-success'
    ]
        ]);  ?>
        
  <?php Pjax::begin([]);  ?>
     <?= GridView::widget([
        'dataProvider' =>$dataProvider,
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'columns' =>$columns, 
    ]); ?>
    
    <?php
      Pjax::end();
    
    
    ?>
