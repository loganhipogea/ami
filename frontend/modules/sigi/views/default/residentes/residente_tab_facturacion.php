<?php
use yii\helpers\Html;
use kartik\grid\GridView;
//use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\helpers\h;
use common\helpers\timeHelper;
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\HighchartsAsset;
use dosamigos\chartjs\ChartJs;
use lo\widgets\modal\ModalAjax;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
?>
<div class="box box-body">
    <h4>Usted tiene una deuda de :  <?=h::formato()->asDecimal($deuda, 2)   ?></h4>
<?php


echo ModalAjax::widget([
    'id' => 'buscarvalor',
    'header' => 'Buscar Valor',
    'toggleButton' => false,
    //'mode'=>ModalAjax::MODE_MULTI,
    'size'=>\yii\bootstrap\Modal::SIZE_LARGE,    
    'selector'=>'.botonAbre',
   // 'url' => $url, // Ajax view with form to load
    'ajaxSubmit' => true, // Submit the contained form as ajax, true by default
    //para que no se esconda la ventana cuando presionas una tecla fuera del marco
    //'clientOptions' => ['tabindex'=>'','backdrop' => 'static', 'keyboard' => FALSE]
    // ... any other yii2 bootstrap modal option you need
]);
 
 Pjax::begin(['id'=>'grilla-recibos']); ?>
    
    <?php
      $showResumen=false;
            
      if(array_key_exists('SigiKardexdepaSearch', $params))
      if(array_key_exists('cancelado', $params['SigiKardexdepaSearch'])){
         if($params['SigiKardexdepaSearch']['cancelado']=='0') 
         $showResumen=true; 
      }
      
     $searchModel = new frontend\modules\sigi\models\SigiKardexdepaSearch();
     $dataProvider=$searchModel->searchByResi($unidad->id,$params);
    
    ?>
    
   <?php //var_dump((new SigiApoderadosSearch())->searchByEdificio($model->id)); die(); ?>
    <?= GridView::widget([
        'id'=>'migrilla',
        'dataProvider' =>$dataProvider, 
        /*\yii\data\ActiveDataProvider([
            'query'=> frontend\modules\sigi\models\SigiKardexdepa::find()->andWhere(['unidad_id'=>$unidad->id,'aprobado'=>'1','historico'=>'0']),
        ]),*/
         'summary' => '',
         'showPageSummary'=>$showResumen,
        'pageSummaryRowOptions'=>['style'=>'text-align:right'],
         'filterModel' => $searchModel,
         //'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'columns' => [
               /*[
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{recibo}{clip}',
                'buttons' => [
                     'view' => function($url, $model) { 
                           $url=Url::to(['/sigi/kardexdepa/view','id'=>$model->id]);
                             $options=['data-pjax'=>'0','target'=>'_blank'];
                          return Html::a('<span class="btn btn-danger glyphicon glyphicon-eye-open"></span>',$url,$options);
                       
                         },
                         'clip' => function($url, $model) { 
                            
                             if($model->countFiles()>=1){
                                  $url=\yii\helpers\Url::toRoute(
                                          ['/finder/selectimage','isImage'=>true,
                             'idModal'=>'imagemodal',
                             'modelid'=>$model->id,
                             'extension'=> \yii\helpers\Json::encode(['jpg','png','jpeg','pdf']),
                             'nombreclase'=> str_replace('\\','_',get_class($model))
                                       ]);
                                 $options = [
                           'class'=>'botonAbre btn btn-warning',
                           
                         ];
                          return Html::a('<span class=" fa fa-paperclip" ></span>Adjuntar voucher',$url,$options);
                       
                             }else{
                                 return '';
                             }
                       
                         }        
                      
                    ]
                ],*/
             
            
             [
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                            return GridView::ROW_COLLAPSED;
                                },
                 'detailUrl' =>Url::toRoute(['/sigi/default/ajax-show-recibo']),
                    //'headerOptions' => ['class' => 'kartik-sheet-style'], 
                    'expandOneOnly' => true
                ],
              [
                    'class' => 'yii\grid\CheckboxColumn',
                     'checkboxOptions' => function($model) {
                    return [
                        'value' => $model->id,
                        'family'=>'hols',
                        'title'=>Url::to(['default/agrega-sesion','id'=>$model->id])
                        ];
                     }
                ],                         
              ['attribute'=>'cancelado',
                'format' => 'raw',
                'filter'=> ['1'=>'Cancelado','0'=>'Pendiente'],
                 'value' => function ($model) {
                    return \yii\helpers\Html::checkbox('cancelado[]', $model->cancelado, [ 'disabled' => true]);

                            },
             ],
            'fecha',
             ['attribute'=>'mes',
                 'format'=>'raw',
                'filter'=> timeHelper::cboMeses(),
                'value'=>function($model){
                             if($model->hasVoucher()) 
                             $link=Html::a("         <i style='color:red;'><span class='fa fa-sticky-note'></span></i>",$model->getVoucher()->files[0]->url,['data-pjax'=>'0']);
                               
                     if($model->hasAttachments()){
                       return Html::a("<i style='color:#3c2f81;'>".timeHelper::mes($model->mes),$model->files[0]->url."</i>",['data-pjax'=>'0']).$link; 
                         
                     }else{
                        return timeHelper::mes($model->mes).$link;  
                     }
                        
                } 
             ],   
              // 'nombre',   
           
            ['attribute'=>'monto',
                'header'=>'Monto Fact',
                'format' => ['decimal', 2],
                'pageSummary' => true,
                'contentOptions'=>['align'=>'right'],  
             ],
            ['attribute'=>'monto',
                'header'=>'Deuda',
                'format' => ['decimal', 2],
                'pageSummary' => true,
                'contentOptions'=>['align'=>'right'],  
             ],
              //'monto',       
                     
             /* 'descripcion', [
    'attribute' => 'activo',
    'format' => 'raw',
    'value' => function ($model) {
        return \yii\helpers\Html::checkbox('activo[]', $model->activo, [ 'disabled' => true]);

             },
          ],*/
        ],
    ])?>
             
     
        <div class="col-md-12">
            <div class="form-group no-margin">
       
                               
         <?php $url=Url::to(['/sigi/'.$this->context->id.'/adj-voucher','idModal'=>'buscarvalor']);  ?>       
          <?=Html::a('<span class="fa fa-book-reader"></span>   '.Yii::t('sta.labels', 'Adjuntar Voucher'),$url, [
              'id'=>'btn-add-test',
              'class'=> 'botonAbre btn btn-warning', 'style'=>'display:none'])?>
            
            </div>
        </div>
    <br>
    <br>
    .
    <br>
    <br>
     <br>
    <br>
    .
    <br>
    <br>
    <?php        
        $string1="$('div[id=\"grilla-recibos\"] [family=\"hols\"]').on( 'click', function() { 
       
    
    if(true){  
       $.ajax({
              url: this.title,
              
              type: 'GET',
              data:{activado:this.checked} ,
              dataType: 'json', 
               error:  function(xhr, textStatus, error){               
                               
                                }, 
              
              success: function(json) {              
                   if ( !(typeof json['sesion']==='undefined' )) {
                         if(json['sesion'].length>0){
                         $('#btn-add-test').show();
                         }else{
                         $('#btn-add-test').hide();
                         }
                             } 
                            }         
                        });
                     }      
                        })";
  $this->registerJs($string1, \yii\web\View::POS_END);
  
   
    Pjax::end();         ?>



</div>