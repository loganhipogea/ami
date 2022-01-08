<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
use frontend\modules\sigi\models\SigiPropietariosSearch;
use frontend\modules\sigi\models\SigiUnidadesSearch;
USE frontend\modules\sigi\helpers\comboHelper;
?>
<div class="edificios-index_docus">

     <div class="box-body">
  
          <div class="col-md-12">
            <div class="form-group no-margin">
            <div class="btn-group">   
                <?php
                    $url= Url::to(['agrega-hijo','id'=>$model->id,'gridName'=>'grilla-hijos','idModal'=>'buscarvalor']);
                    echo  Html::button(yii::t('base.verbs','Insertar Nuevo'), ['href' => $url, 'title' => yii::t('sta.labels','Agregar Adjunto'),'id'=>'btn_hijos_edi', 'class' => 'botonAbre btn btn-success']); 
                    ?>
                
                <br>
            </div>
          </div>
        </div> 
        

         
    <?php Pjax::begin(['id'=>'grilla-hijos']); ?>
    
   <?php //var_dump((new SigiApoderadosSearch())->searchByEdificio($model->id)); die(); ?>
    <?= GridView::widget([
        'id'=>'grilla-grid-hijos',
        'dataProvider' =>(new SigiUnidadesSearch())->searchByUnidad($model->id),
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'columns' => [
                 [
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{edit}{delete}{desacoplar}',
               'buttons' => [
                    'attach' => function($url, $model) {  
                         $url=\yii\helpers\Url::toRoute(['/finder/selectimage','isImage'=>false,'idModal'=>'imagemodal','modelid'=>$model->id,'nombreclase'=> str_replace('\\','_',get_class($model))]);
                        $options = [
                            'title' => Yii::t('sta.labels', 'Subir Archivo'),
                            //'aria-label' => Yii::t('rbac-admin', 'Activate'),
                            //'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                            'data-method' => 'get',
                            //'data-pjax' => '0',
                        ];
                        return Html::button('<span class="glyphicon glyphicon-paperclip"></span>', ['href' => $url, 'title' => 'Editar Adjunto', 'class' => 'botonAbre btn btn-success']);
                        //return Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', Url::toRoute(['view-profile','iduser'=>$model->id]), []/*$options*/);
                     
                        
                        },
                        'delete' => function ($url,$model) {
			   $url = \yii\helpers\Url::toRoute($this->context->id.'/deletemodel-for-ajax');
                              return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['title'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                            },
                        
                        'desacoplar' => function ($url,$model) {
                                 $url = \yii\helpers\Url::toRoute([$this->context->id.'/desacoplar-unidad','id'=>$model->id]);
                                  return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-lock"></span>', '#', ['title'=>$url,'id'=>$model->id,'family'=>'holas',]);
                            }
                        
                    ]
                ],
            'nombre',
              'numero',              
           
              /* [
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
           'id'=>'widgetytytgruidBancos',
            'idGrilla'=>'grilla-hijos',
            'family'=>'holas',
          'type'=>'POST',
           'evento'=>'click',
       'posicion'=>\yii\web\View::POS_END,
            //'foreignskeys'=>[1,2,3],
        ]); 
   ?>
         
    <?php Pjax::end(); ?>

   <div class="col-md-12">
            <div class="form-group no-margin">
            <div class="btn-group">   
                <?php
                echo Html::dropDownList('mycombo',null, 
                            comboHelper::getCboUnidadesPosiblesHijas($model->id),
                        [
                          'id'=>'mycombito' , 
                            'prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                     'class'=>'form-control',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]);
                    echo  Html::button(yii::t('base.verbs','Insertar  Existente'),
                            ['href' => $url, 
                                'title' => yii::t('sta.labels','Agregar Adjunto'),
                                'id'=>'mybotoncito', 
                                'class' => ' btn btn-success']); 
                        
                    ?> 
                <br>
            </div>
          </div>
        </div>      
         
    </div>
      </div>
<?php 

  $string="$('#mybotoncito').on( 'click', function(){ 
     var valor_combo;
     valor_combo=$('#mycombito').val();
     alert( valor_combo);
       $.ajax({
              url: '".Url::to(['/sigi/unidades/acoplar-unidad','id'=>$model->id])."', 
              type: 'get',
              data:{idhija:valor_combo},
              dataType: 'json', 
              error:  function(xhr, textStatus, error){               
                            var n = Noty('id');                      
                              $.noty.setText(n.options.id, error);
                              $.noty.setType(n.options.id, 'error');       
                                }, 
              success: function(json) {
              var n = Noty('id');
                      
                       if ( !(typeof json['error']==='undefined') ) {
                        $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-trash\'></span>      '+ json['error']);
                              $.noty.setType(n.options.id, 'error');  
                          }    

                             if ( !(typeof json['warning']==='undefined' )) {
                        $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-trash\'></span>      '+ json['warning']);
                              $.noty.setType(n.options.id, 'warning');  
                             } 
                          if ( !(typeof json['success']==='undefined' )) {
                        $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-trash\'></span>      '+ json['success']);
                              $.noty.setType(n.options.id, 'success');  
                               $.pjax.reload({container: '#grilla-hijos', async: false});
                             }      
                   
                        }
                        });


             })";
  
   $this->registerJs($string, \yii\web\View::POS_END);
 
  ?>