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
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
?>
<div class="box box-body">
    <h4>Pagos</h4>
    <?php //$clave= uniqid();
    $grilla='grilla_'.$id;
    ?>
    <?php 
    $url= Url::to(['crea-conc','id'=>$id,'gridName'=>$grilla,'idModal'=>'buscarvalor']);
     echo  Html::button(yii::t('base.verbs','Conciliar depósito'), ['href' => $url, 'title' => yii::t('sta.labels','Agregar Sesión'),'id'=>'btn_sesion', 'class' => 'botonAbre btn btn-warning']); 

    ?>
    
    
    
<?php
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
            'template' => '{attach}{check}{edit}{delete}',
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
                              if(!$model->kardex->cancelado)
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
                         if(!$model->kardex->cancelado)
                        return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['href' => $url, 'title' => 'Editar ', 'class' => 'botonAbre btn btn-success']);
                        //return Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', Url::toRoute(['view-profile','iduser'=>$model->id]), []/*$options*/);
                        return '';
                        
                        },              
                        
                        'check' => function ($url,$model) {
			   $url = \yii\helpers\Url::toRoute(['/sigi/movimientos/aprobe-pago','id'=>$model->kardex->id,'gridName'=>'grilla_m']);
                              if(!$model->kardex->cancelado)
                              return \yii\helpers\Html::a('<span class="btn btn-success fa fa-check"></span>', '#', ['title'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                               return '<i style="color:#60a917; font-size:18px;"><span class="fa fa-check"></span></i>';
                             } 
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
           
             'glosa',
             ['attribute'=>'nombre',
               'format'=>'raw',
                'value'=>function($model){
                        
                     return $model->kardex->unidad->nombre;   
                }  
                  
                  ],
              'monto',
             'kardex.monto',
              'kardex.mes',
              ['attribute'=>'diferencia',
                'value'=>function($model){
                     return round($model->monto-$model->kardex->monto,3);   
                }  
                  
                  ]
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
