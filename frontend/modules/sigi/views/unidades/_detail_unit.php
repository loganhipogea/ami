<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
use common\helpers\ComboHelper;
use common\widgets\selectwidget\selectWidget;
use frontend\modules\sigi\models\SigiSuministros;
use frontend\modules\sigi\models\VwSigiKardexdepa;
use common\helpers\timeHelper;
use yii\widgets\Pjax;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;

/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\Edificios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="edificios-form">
    <br>
    <?php 
    $model= \frontend\modules\sigi\models\SigiUnidades::findOne($id);
    $form = ActiveForm::begin([
    //'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      
<div class="box-body">
 
 <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?=$model->numero?></h3>

              <p><?=$model->nombre?></p>
            </div>
            <div class="icon">
                <span style="color:white;opacity:0.5;"><i class="fa fa-building"></i></span>
            </div>
            
          </div>
  </div>
 <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
               <?php $prop=$model->currentPropietario();?>
              <h3><?=is_null($prop)?'-':$prop->tipo?></h3>

              <p><?=!is_null($prop)?$prop->nombre:'--'?></p>
            </div>
            <div class="icon">
                <span style="color:white;opacity:0.5;"><i class="fa fa-users"></i></span>
            </div>
            
          </div>
  </div>
  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?=$model->area.' m2'?></h3>

              <p><?php echo yii::t('sta.labels','Area participación').'  '.round($model->areaTotal(),3).' m2';  ?></p>
            </div>
            <div class="icon">
                <span style="color:black;opacity:0.3;"><i class="fa fa-pie-chart"></i></span>
            </div>
            
          </div>
  </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr >
                      <th colspan="5"><p class="text-green"><span class="fa fa-tachometer-alt"></span>      Detalle de unidades hijas</p></th> 
                    
                  </tr>
                  <tr>
                       <th>#</th> 
                        <th></th> 
                      <th>Numero</th> 
                      <th>Nombre</th> 
                      <th>Area</th>
                  </tr>
                  </thead>
                  <tbody>
                      
                   <?php 
                   $i=1;
           foreach($model->childsUnits as $unidad){ 
              
               ?>
              <tr> 
                  <td><?=$i?></td>
                  <td><i style="font-size: 36px; color:#333"><span class="fa fa-<?=$unidad->tipo->icon?>"></span></i></td>
                  <td><?=$unidad->numero?></td>
                   <td><?=$unidad->nombre?></td>
                  <td><?=$unidad->area?></td>
              </tr> 
           <?php $i++;} ?>   
                      
               
                  
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>  
    
    
  <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
     <?= $form->field($model, 'numero')->textInput(['disabled'=>true,'maxlength' => true]) ?>

 </div>
 <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
     <?= $form->field($model, 'area')->textInput(['disabled'=>true,'maxlength' => true]) ?>
 </div> 
<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
     <?= $form->field($model, 'nombre')->textInput(['disabled'=>true,'maxlength' => true]) ?>

 </div>
    
   <?php $medidor=$model->firstMedidor(SigiSuministros::COD_TYPE_SUMINISTRO_DEFAULT);  ?> 
     <?php if(!is_null($medidor)) {  ?>
   
       <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-red-active">
            <div class="inner">
              <h3><?=$medidor->codsuministro?></h3>

              <p><?=$medidor->lastReadValue(null,true). ' '.$medidor->codum?></p>
            </div>
            <div class="icon">
                <span style="color:white;opacity:0.5;"><i class="fa fa-tachometer-alt"></i></span>
            </div>
               <?php 
            
            $url=Url::toRoute(['/sigi/edificios/lecturas','id'=>$medidor->id]);
            echo Html::a(yii::t('sta.labels','Detalles').'<i class="fa fa-arrow-circle-right"></i>',$url, ['data-pjax'=>'0','target'=>'_blank','class'=>"small-box-footer"]);
            ?> 
            
          </div>
       </div>
     <?php }  ?>    
     <?php ActiveForm::end(); ?>
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">   
     <h4><?= yii::t('sta.labels','Facturación') ?></h4>
     <?php
 Pjax::begin(['id'=>'grilla-deudas','timeout'=>false]); ?>
    
   <?php //var_dump((new SigiApoderadosSearch())->searchByEdificio($model->id)); die(); ?>
    <?= GridView::widget([
        'dataProvider' =>new \yii\data\ActiveDataProvider([
            'query'=> frontend\modules\sigi\models\VwSigiKardexdepa::find()->andWhere(['unidad_id'=>$model->id])
        ]),
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'columns' => [
                  [
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{recibo}{mail}',
               'buttons' => [
                  'recibo' => function($url, $model) {
                            $kardex=$model->kardexDepa;
                           if($kardex->hasAttachments()){
                               $url=$kardex->files[0]->url;
                            return Html::a('<span class="glyphicon glyphicon-download-alt" ></span>'.'  '.yii::t('sta.labels',''),$url,['data-pjax'=>'0','class'=>"btn btn-success"]);
                       
                           }else{
                               return '';
                           }
                           },
                    'mail' => function($url, $model) {  
                         $url=\yii\helpers\Url::toRoute(['/sigi/facturacion/send-recibo',
                             
                             'id'=>$model->id,
                            ]);
                          return Html::button('<span class="glyphicon glyphicon-envelope"></span>', ['id'=>$model->id, 'family' =>'holas','title' => $url, 'class' => 'btn btn-danger']);
                        //return Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', Url::toRoute(['view-profile','iduser'=>$model->id]), []/*$options*/);
                     
                          }
                        
                        
                       /* 'pdf' => function ($url,$model) {
			   $url = \yii\helpers\Url::toRoute(['/sta/citas/report-inf-psicologico','id'=>$model->id,'gridName'=>'grid_docu','idModal'=>'buscarvalor']);
                              if($model->cita_id > 0 or $model->codocu=='104')
                              return \yii\helpers\Html::a('<span class="btn btn-warning fa fa-file-pdf"></span>', $url, ['data-pjax'=>'0','target'=>'_blank']);
                              return '';
                             } */
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
            'fecha',
             ['attribute'=>'mes',
                'value'=>function($model){
                   return timeHelper::mes($model->mes);            
                } 
             ],   
              // 'nombre',   
           'numero',
            ['attribute'=>'montodepa',
                'header'=>'Monto',
                'format' => ['decimal', 3],
                'contentOptions'=>['align'=>'right'],  
             ]
             /* 'descripcion', [
    'attribute' => 'activo',
    'format' => 'raw',
    'value' => function ($model) {
        return \yii\helpers\Html::checkbox('activo[]', $model->activo, [ 'disabled' => true]);

             },
          ],*/
        ],
    ]); ?>
     
     <?php 

   echo linkAjaxGridWidget::widget([
           'id'=>'widgetgridBanggcos',
            'idGrilla'=>'grilla-deudas',
            'family'=>'holas',
            'refrescar'=>false,//NO REFRESCAR
          'type'=>'GET',
           'evento'=>'click',
           'posicion'=>\yii\web\View::POS_END
            //'foreignskeys'=>[1,2,3],
        ]); 
   ?>
     
     
     
    <?php Pjax::end(); ?>  
          
 </div>    
   

</div>
    </div>
