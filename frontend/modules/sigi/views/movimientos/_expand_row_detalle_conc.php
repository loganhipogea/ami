<?php
use yii\helpers\Html;
//use kartik\grid\GridView;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\helpers\timeHelper;
use common\helpers\h;
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\HighchartsAsset;
use dosamigos\chartjs\ChartJs;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
?>
<div class="box box-body">
    <h4>Pagos</h4>
    <?php //$clave= uniqid();
    $grilla='grilla_'.$id; 
    ?>
    <?php 
    $url= Url::to(['crea-conc','id'=>$id,'gridName'=>$grilla,'idModal'=>'buscarvalor']);
     echo  Html::button(yii::t('base.verbs','Conciliar Recibo'), ['href' => $url, 'title' => yii::t('sta.labels','Agregar Sesión'),'id'=>'btn_sesion', 'class' => 'botonAbre btn btn-warning']); 

    ?>
    <?php 
    $url= Url::to(['crea-conc-doc-inpu','id'=>$id,'gridName'=>$grilla,'idModal'=>'buscarvalor']);
     echo  Html::button(yii::t('base.verbs','Conciliar otro Ingreso'), ['href' => $url, 'title' => yii::t('sta.labels','Agregar Sesión'),'id'=>'btn_sesion', 'class' => 'botonAbre btn btn-warning']); 

    ?>
      <?= Html::a(Yii::t('sigi.labels', 'Crear documento inputado'), Url::to(['/sigi/porpagar/crear-cobro','inputado'=>'1']), ['target'=>'_blank','data-pjax'=>'0','class' => 'btn btn-success']) ?>
    <?= Html::a(Yii::t('sigi.labels', 'Crear documento general'), ['/sigi/porpagar/crear-cobro'], ['target'=>'_blank','data-pjax'=>'0','class' => 'btn btn-success']) ?>
    
    
<?php
$formato=h::formato();
 Pjax::begin(['id'=>$grilla,'timeout'=>false]); ?>
    
   <?php 
   
   
   
  //echo frontend\modules\sigi\models\SigiMovimientosPre::find()->complete()->andWhere(['kardex_id'=>$id])->createCommand()->rawSql;die();
//var_dump((new SigiApoderadosSearch())->searchByEdificio($model->id)); die(); ?>
    <?= GridView::widget([
        'dataProvider' =>new \yii\data\ActiveDataProvider([
            'query'=> frontend\modules\sigi\models\SigiMovimientosPre::find()->andWhere(['idop'=>$id])
        ]),
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'columns' => [
                  [
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{attach}{check}{edit}{uncheck}{delete}',
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
                        'delete' => function ($url,$model) {
			   $url = \yii\helpers\Url::toRoute($this->context->id.'/deletemodel-for-ajax');
                              if(!$model->activo)
                              return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['title'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                              return '';
                              
                             } ,
                                     
                       'edit' => function($url, $model) use($grilla) {  
                         $url=\yii\helpers\Url::toRoute(['/sigi/movimientos/edit-conc','id'=>$model->id,'isImage'=>false,'idModal'=>'buscarvalor','gridName'=>$grilla,'nombreclase'=> str_replace('\\','_',get_class($model))]);
                        $options = [
                            'title' => Yii::t('sta.labels', 'Editar'),
                            //'aria-label' => Yii::t('rbac-admin', 'Activate'),
                            //'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                            'data-method' => 'get',
                            'data-pjax' => '0',
                        ];
                         if(!$model->activo)
                        return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['href' => $url, 'title' => 'Editar ', 'class' => 'botonAbre btn btn-success']);
                        //return Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', Url::toRoute(['view-profile','iduser'=>$model->id]), []/*$options*/);
                        return '';
                        
                        },              
                        
                        'check' => function ($url,$model) {
			   $url = \yii\helpers\Url::toRoute(['/sigi/movimientos/aprobe-pago','id'=>$model->id,'gridName'=>'grilla_m']);
                              if(!$model->activo)
                              return \yii\helpers\Html::a('<span class="btn btn-success fa fa-check"></span>', '#', ['title'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                               return '<i style="color:#60a917; font-size:18px;"><span class="fa fa-check"></span></i>';
                             }, 
                        'uncheck'=>function ($url,$model) {
			   $url = \yii\helpers\Url::toRoute(['/sigi/movimientos/un-aprobe-pago','id'=>$model->id,'gridName'=>'grilla_m']);
                              if($model->activo)
                              return \yii\helpers\Html::a('<span class="btn btn-danger fa fa-undo"></span>', '#', ['title'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                               return '';
                             },
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
              ['attribute'=>'Monto',
                'value'=>function($model) use($formato){
                     return $formato->asDecimal($model->monto,3);   
                }  
                  
                  ],
            ['attribute'=>'Monto Doc',
                'value'=>function($model) use($formato){
                     return $formato->asDecimal($model->kardex->monto,3);   
                   }  
                  
                  ],
              
            
        ],
    ]); ?>
    
    <?php
    
    
    
    ?>
     <?php 
   echo linkAjaxGridWidget::widget([
           'id'=>'widgetgruidBancos',
            'idGrilla'=>'grilla_m',
            'family'=>'holas',
          'type'=>'POST',
           'evento'=>'click',
       'posicion'=>\yii\web\View::POS_END,
            //'foreignskeys'=>[1,2,3],
        ]); 
   ?> 
         
    <?php Pjax::end(); ?>

</div>
