<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\helpers\Url;
use yii\helpers\Html;
use common\helpers\h;
use yii\widgets\Pjax;
use yii\grid\GridView; 
use frontend\modules\sigi\helpers\comboHelper;
use common\widgets\selectwidget\selectWidget;
use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
use frontend\modules\cc\models\CcGastos;
     ?> 
<div class="box-body">

     <div class="form-group no-margin">
            <div class="btn-group">   
    <?php
     $url= Url::to(['ceco/mod-crea-calificacion','id'=>$model->id,'tipo'=>$model->codigo_costo_directo(),'gridName'=>'grilla-gastos','idModal'=>'buscarvalor']);
     echo  Html::button(yii::t('sta.labels','Costo directo'), ['href' => $url, 'title' => yii::t('sta.labels','Costo directo'),'id'=>'btn_cuentas_edi', 'class' => 'botonAbre btn btn-success']); 
     $url= Url::to(['ceco/mod-crea-calificacion','id'=>$model->id,'tipo'=>$model->codigo_costo_indirecto(),'gridName'=>'grilla-gastos','idModal'=>'buscarvalor']);
     echo  Html::button(yii::t('sta.labels','Costo indirecto'), ['href' => $url, 'title' => yii::t('sta.labels','Costo indirecto'),'id'=>'btn_cuentas_edi', 'class' => 'botonAbre btn btn-danger']); 
   $url= Url::to(['ceco/mod-crea-calificacion','id'=>$model->id,'tipo'=>$model->codigo_costo_orden(),'gridName'=>'grilla-gastos','idModal'=>'buscarvalor']);
     echo  Html::button(yii::t('sta.labels','Colector'), ['href' => $url, 'title' => yii::t('sta.labels','Agregar a Colector'),'id'=>'btn_cuentas_edi', 'class' => 'botonAbre btn btn-warning']); 
   
   
   ?>
    </DIV>
    </DIV>
    <br>
     <?php Pjax::begin(['id'=>'grilla-gastos']); ?>
     <?php $falta=$model->costoSinCalificar;if($falta>0){ ?>
    <div class="alert label-warning">Existe un monto de : <?=h::formato()->asDecimal($falta,2)?> que no se ha calificado</div>
     <?php }?>
   <?php
   $formato=h::formato();
//var_dump((new SigiApoderadosSearch())->searchByEdificio($model->id)); die(); 
   ?>
    <?= GridView::widget([
        'dataProvider' =>(new \yii\data\ActiveDataProvider([
                        'query'=> \frontend\modules\cc\models\CcGastos::find()
                        ->andWhere(['comprobante_id'=>$model->id])
                        ])),
         //'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'columns' => [
             [
        'class' => 'yii\grid\CheckboxColumn',
                 'checkboxOptions' => function ($model, $key, $index, $column) {
                         $url = \yii\helpers\Url::to([$this->context->id.'/ajax-guarda-id-req-sesion','id'=> $model->id]);                              
                        return ['value' => $model->id,'family'=>'pigmalion', 'title'=>$url,'id'=>$model->id];
                            }
        // you may configure additional properties here
                    ],
                 [
                    
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{edit}{delete}',
               'buttons' => [
                    'attach' => function($url, $model) {  
                         $url=\yii\helpers\Url::toRoute(['/finder/selectimage','isImage'=>false,'idModal'=>'imagemodal','modelid'=>$model->id,'nombreclase'=> str_replace('\\','_',get_class($model))]);
                        $options = [
                            'title' => Yii::t('sta.labels', 'Colocar en el maletín'),
                            //'aria-label' => Yii::t('rbac-admin', 'Activate'),
                            //'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                            'data-method' => 'get',
                            //'data-pjax' => '0',
                        ];
                        return Html::button('<span class="glyphicon glyphicon-paperclip"></span>', ['href' => $url, 'title' => 'Editar Adjunto', 'class' => 'botonAbre btn btn-success']);
                        //return Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', Url::toRoute(['view-profile','iduser'=>$model->id]), []/*$options*/);
                     
                        
                        },
                                
                                'edit' => function ($url,$model) {
			    $url= Url::to(['/cc/ceco/mod-edita-calificacion','id'=>$model->id,'gridName'=>'grilla-gastos','idModal'=>'buscarvalor']);
                              return \yii\helpers\Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>'0','class'=>'botonAbre']);
                            },
                        'delete' => function ($url,$model) {
                             
                                $url = \yii\helpers\Url::to([$this->context->id.'/ajax-desactiva-item','id'=>$model->id]);
                              
                                    return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['title'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                             
                             
			    }
                        
                    ]
                ],
              
             ['attribute' => 'codigo',
                'format'=>'raw',
                'value'=>function($model){ 
                             //RETURN $model->ceco_id;
                             return $model->ceco->codigo.':'.$model->ceco->descripcion;                                                   
                            } 
                
                ], 
             ['attribute' => 'nombre',
                'format'=>'raw',
                'value'=>function($model){                        
                             return $model->ArrayNombresCostos()[$model->tipo];                                                   
                             } 
                
                ], 
                    
            ['attribute' => 'monto',
                'format'=>'raw',
                 'contentOptions'=>['style'=>'text-align:right;'],
                'value'=>function($model) use($formato){
                             return $formato->asDecimal($model->monto,3);
                                                
                             } 
                
                ], 
             
             
           ['class' => '\common\components\columnGridAudit',],
        ],
    ]); ?>
         <?php 
   echo linkAjaxGridWidget::widget([
           'id'=>'widgetgruidBancos',
            'idGrilla'=>'grilla-materiales',
            'family'=>'holas',
          'type'=>'POST',
           'evento'=>'click',
        'posicion'=>\yii\web\View::POS_END
       
            //'foreignskeys'=>[1,2,3],
        ]); 
   ?>
          
          <?php 
   echo linkAjaxGridWidget::widget([
           'id'=>'widgetgruidBancosss',
            'idGrilla'=>'grilla-materiales',
            'family'=>'pigmalion',
          'type'=>'POST',
           'evento'=>'change',
           'refrescar'=>false,
        'posicion'=>\yii\web\View::POS_END
       
            //'foreignskeys'=>[1,2,3],
        ]); 
   ?>
         
    <?php Pjax::end(); ?>
   
  
  </div>