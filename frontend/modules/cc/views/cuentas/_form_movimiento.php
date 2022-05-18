<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\h;
use yii\widgets\Pjax;
use yii\grid\GridView;
use frontend\modules\sigi\helpers\comboHelper;
use common\widgets\selectwidget\selectWidget;
use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
 use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model frontend\modules\cc\models\CcCuentas */
/* @var $form yii\widgets\ActiveForm */
?>


     <div class="box-body">
      <?php $form = ActiveForm::begin([
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
          
        <div class="col-md-12">
            <div class="form-group no-margin">
         
          <?= Html::submitButton('<span class="fa fa-save"></span>   '.Yii::t('app', 'Guardar'), ['class' => 'btn btn-success']) ?>
            

                  

            </div>
        </div>
    </div>
     
  
      <div class="box-body">
          <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">    
                 <?= $form->field($model, 'monto')->textInput([
                     'value'=>$model->cuenta->nombre,
                     'disabled'=>true,
                 ])->label(yii::t('base.labels','Cuenta')) ?>
            </div>
          
          
 <?php //if($model->isScenario($model::SCE_PAGO_RENDIR_PERSONA)){  ?> 
  <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">    
  <?php 
  // $necesi=new Parametros;
    echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'form'=>$form,
            'campo'=>'codtra',
         'ordenCampo'=>1,
         'addCampos'=>[2,3],
        ]);  ?>
 </div>
  <?php  //} ?>  
  <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
      <?= $form->field($model, 'fechaop')->widget(DatePicker::class, [
                            'language' => h::app()->language,
                           'pluginOptions'=>[
                                     'format' => h::gsetting('timeUser', 'date')  , 
                                   'changeMonth'=>true,
                                  'changeYear'=>true,
                                 'yearRange'=>'2014:'.date('Y'),
                               ],
                          
                            //'dateFormat' => h::getFormatShowDate(),
                            'options'=>['class'=>'form-control']
                            ]) ?>
 </div>
  
  

  
  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    
 <?= $form->field($model, 'glosa')->textInput() ?>

</div>  
   <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">    
 <?= $form->field($model, 'monto')->textInput() ?>
 </div>

 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">    
 <?= $form->field($model, 'detalle')->
 textarea([]) ?>
 </div> 
          
     

     
    <?php ActiveForm::end(); ?>
          
       <?php if(!$model->isNewRecord){ ?>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
    <?php Pjax::begin(['id'=>'grilla-materiales']); ?>
    
   <?php //var_dump((new SigiApoderadosSearch())->searchByEdificio($model->id)); die(); ?>
    <?= GridView::widget([
        'dataProvider' =>(new \yii\data\ActiveDataProvider([
                        'query'=> \frontend\modules\cc\models\CcCompras::find()
                        ->andWhere(['movimiento_id'=>$model->id])
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
			    $url= Url::to(['/mat/mat/mod-edit-mat','id'=>$model->id,'gridName'=>'grilla-materiales','idModal'=>'buscarvalor']);
                              return \yii\helpers\Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>'0','class'=>'botonAbre']);
                            },
                        'delete' => function ($url,$model) {
                              IF($model->activo){
                                $url = \yii\helpers\Url::to([$this->context->id.'/ajax-desactiva-item','id'=>$model->id]);
                              
                                    return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['title'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                             
                              }
			    }
                        
                    ]
                ],
              
            'prefijo',
             'numero',
             ['attribute' => 'monto',
                'format'=>'raw',
                'value'=>function($model){                        
                             return $model->monto;                                                   
                             } 
                
                ], 
                    
            ['attribute' => 'glosa',
                'format'=>'raw',
                'value'=>function($model){
                        
                        
                             return $model->glosa; 
                                                
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
   <?php
    $url= Url::to(['mod-crea-comprobante','id'=>$model->id,'gridName'=>'grilla-compras','idModal'=>'buscarvalor']);
    echo  Html::button(yii::t('base.verbs','Agregar comprobante'), ['href' => $url, 'title' => yii::t('sta.labels','Agregar Comprobante'),'id'=>'btn_cuentas_edi', 'class' => 'botonAbre btn btn-success']); 
     ?>
  </div> 
  <?php  } ?>        
     
</div>
    </div>
