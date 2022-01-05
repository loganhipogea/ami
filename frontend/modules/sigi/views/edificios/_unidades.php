<?php
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use frontend\modules\sigi\models\SigiUnidadesSearch;
    use kartik\export\ExportMenu;

$gridColumns = [
  [
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{update}',
               'buttons' => [
                    'update' => function($url, $model) {  
                         $url = \yii\helpers\Url::to(['/sigi/unidades/update','id'=>$model->id]);
                         $options = [
                            //'title' => Yii::t('sta.labels', 'Editar'),
                            //'aria-label' => Yii::t('rbac-admin', 'Activate'),
                            //'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                            //'data-method' => 'get',
                            'data-pjax' => '0',
                             'target'=>'_blank'
                        ];
                        //return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['href' => $url, 'title' => 'Editar Adjunto', 'class' => ' btn btn-sm btn-success']);
                        return Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>',$url,$options);
                     
                        
                        },
                      
                        
                    ]
                ],
            [
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                            return GridView::ROW_COLLAPSED;
                                },
                     'detailUrl' =>Url::toRoute(['/sigi/edificios/ajax-show-unidad']),
                    //'headerOptions' => ['class' => 'kartik-sheet-style'], 
                    'expandOneOnly' => true
                ], 

[
    
    'attribute' => 'numero',
    'format'=>'raw',
    'value' => function ($model, $key, $index, $column) {
        $formato=($model->isEntregado())?'  <i style="color:#3ead05;font-size:12px"><span class="glyphicon glyphicon-check"></span></i>':
               '  <i style="color:red;font-size:12px"><span class="glyphicon glyphicon-pushpin"></span></i>';
        return $model->numero.$formato;
    },
   
],
            [
             'attribute'=>'parent_id',
             'filter'=>$model->unidadesPadresArray(),
             'format'=>'raw',
             'value'=>function($model){
                   if($model->parent_id>0){
                      return   '<i style="color:#08882f;font-size:14px">    '.$model->padre->numero.'     <span class="fa fa-child"></span></i>' ;
                    
                   }
                    return '';
             
                       
             }
         ],
[
    
    'attribute' => 'nombre',    
   
],
                 
 [
    
    'attribute' => 'imputable',  
     'filter'=>['0'=>'No','1'=>'Sí'],
   
],
[    
    'attribute' => 'area',
],
                 [    
    'attribute' => 'codpro',
],
         [    
    'attribute' => 'tipo',
             'value'=>'tipo.desunidad',
             'group'=>true,
          ],
 [
             'attribute'=>'participacion',
             'format'=>'raw',
             'value'=>function($model){
                   return $model->participacionArea();
             }
         ],                
                 

];
 $url= Url::to(['agrega-unidad','id'=>$model->id,'gridName'=>'grilla-unidades','idModal'=>'buscarvalor']);
   echo  Html::button(yii::t('base.verbs','Agregar Unidad'), ['href' => $url, 'title' => yii::t('sta.labels','Agregar Unidad'),'id'=>'btn_contacts', 'class' => 'botonAbre btn btn-success']); 

 echo ExportMenu::widget([
    'dataProvider' => $dataProvider,
     'filename'=>'unidades',
     'exportConfig'=>[
         ExportMenu::FORMAT_EXCEL=>[
             'filename'=>'Exportacion'
               ],
         ExportMenu::FORMAT_EXCEL_X=>[
             'filename'=>'Exportacion'
               ]
         ],
    'columns' => $gridColumns,
    'dropdownOptions' => [
        'label' => yii::t('sta.labels','Exportar'),
        'class' => 'btn btn-success'
    ]
]) ?>
 
 <hr>
 <?php  
 /*$distribucion_unidades=$model->mapa_depa();

   foreach($distribucion_unidades as $codpro=>$unidades){ ?>
        <table>
            <thead>
            <th colspan="2">
                <?php if(count($unidades)>0){echo $unidades[0]['despro'];}else{} ?>
            </th>
             <th>Cant</th> <th>Unidad</th>
            </thead>
             <?php foreach($unidades as $fila){ ?>
            <tr>  
               <td><?=$fila['desunidad']?></td>
              <td><?=$fila['cantidad']?></td>             
            </tr>
            
             <?php } ?>
            <tr>  
               <td>Total:</td>
              <td><?=$distribucion_unidades[$codpro]['total']?></td>             
            </tr>
        </table>
 <?php   }*/
 ?>
 
 
 
   <?php
   Pjax::begin(['id'=>'grilla-unidades']);
  echo GridView::widget([
   // 'id' => 'kv-grid-demo',
    'dataProvider' => $dataProvider,
      'filterModel' => $searchModel,
    'columns' => $gridColumns, // check the configuration for grid columns by clicking button above
    
    'pjax' => true, // pjax is set to always true for this demo
    // set your toolbar
   
  
   
    // parameters from the demo form
   /* 'bordered' => $bordered,
    'striped' => $striped,
    'condensed' => $condensed,
    'responsive' => $responsive,
    'hover' => $hover,
    'showPageSummary' => $pageSummary,*/
   
    
   
    
]);  

  
  
  Pjax::end();
  
?>
    
  


