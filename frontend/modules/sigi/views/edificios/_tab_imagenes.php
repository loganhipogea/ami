<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
use frontend\modules\sigi\models\SigiCuentasSearch;
USE frontend\modules\sigi\models\SigiImgedificio;
?>
<div class="edificios-index_docus">

     <div class="box-body">
         
<?php
 //$url= Url::to(['agrega-cuenta','id'=>$model->id,'gridName'=>'grilla-cuentas','idModal'=>'buscarvalor']);
   echo  Html::button(yii::t('base.verbs','Insertar Imagen'), [ 'title' => yii::t('sta.labels','Agregar imagen'),'id'=>'btn_edi_img', 'class' => 'btn btn-success']); 
?> 
         
    <?php Pjax::begin(['id'=>'grilla-imx']); ?>
    
   <?php //var_dump((new SigiApoderadosSearch())->searchByEdificio($model->id)); die(); ?>
    <?= GridView::widget([
        'dataProvider' =>new \yii\data\ActiveDataProvider([
            'query'=> SigiImgedificio::find()->andWhere(['edificio_id'=>$model->id]),
        ]),
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'columns' => [
                 [
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{attach}{delete}',
               'buttons' => [
                    'attach' => function($url, $model) {  
                         $url=\yii\helpers\Url::toRoute(['/finder/selectimage',
                             'isImage'=>false,'idModal'=>'imagemodal',
                             'modelid'=>$model->id,
                             'nombreclase'=> str_replace('\\','_',get_class($model)),
                              'extension'=>json_encode(['png','jpg']),
                             ]);
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
                              return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['title'=>$url,/*'id'=>$model->codparam,*/'family'=>'fred','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                            }
                        
                    ]
                ],
            'comentario',
             
        ],
    ]); ?>
         <?php 
   echo linkAjaxGridWidget::widget([
           'id'=>'widgetgruidBancos',
            'idGrilla'=>'grilla-imx',
            'family'=>'fred',
          'type'=>'POST',
           'evento'=>'click',
           'posicion'=>\yii\web\View::POS_END
            //'foreignskeys'=>[1,2,3],
        ]); 
   ?>
         
    <?php Pjax::end(); ?>

    </div>
      </div>
<?php 
 
  $string="$('#btn_edi_img').on( 'click', function(){ 
     
       $.ajax({
              url: '".Url::to(['/sigi/edificios/crea-imagen','id'=>$model->id])."', 
              type: 'get',
              data:{id:".$model->id."  },
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
                               $.pjax.reload({container: '#grilla-imx', async: false});
                          
                             }      
                   
                        }
                        });


             })";
  
   $this->registerJs($string, \yii\web\View::POS_END);
 
  ?>