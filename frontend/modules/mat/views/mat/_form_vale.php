<?php
 use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\helpers\Url;
USE common\helpers\h;
use yii\widgets\ActiveForm;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
use  common\widgets\selectwidget\selectWidget;
use frontend\modules\mat\helpers\ComboHelper;
use yii\widgets\Pjax;
use yii\grid\GridView;
use common\widgets\inputajaxwidget\inputAjaxWidget;
/* @var $this yii\web\View */
/* @var $model frontend\modules\mat\models\MatReq */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mat-req-form">
    <br>
    <?php $form = ActiveForm::begin([
    'fieldClass'=>'\common\components\MyActiveField'
    ]); 
    $bloqueado=$model->isBloqueado();
   
    ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
                
        <?= Html::submitButton('<span class="fa fa-save"></span>   '.Yii::t('app', 'Grabar'), ['class' => 'btn btn-success']) ?>
           <?php 
            if($model->isCreado())
           echo Html::button(
                                    '<span class="fa fa-chek"></span>   '.Yii::t('sta.labels', 'Aprobar'),
                                     ['class' => 'btn btn-success','href' => '#','id'=>'btn-aprobar']
                 );
          ?> 

            </div>
        </div>
    </div>
      <div class="box-body">
    

  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'numero')->textInput(['maxlength' => true,'disabled'=>true]) ?>

 </div>
 <div class="col-lg-9 col-md-8 col-sm-6 col-xs-12">
     <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true,'disabled'=>(!$bloqueado)?false:true  ]) ?>
     
 </div>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
     <?php 
  // $necesi=new Parametros;
    echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'form'=>$form,
            'campo'=>'codpro',
         'ordenCampo'=>1,
         'addCampos'=>[2,3],
        ]);  ?>

 </div> 
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     
 <?= $form->field($model, 'fecha')->widget(DatePicker::class, [
                            'language' => h::app()->language,
                           'pluginOptions'=>[
                                     'format' => h::gsetting('timeUser', 'date')  , 
                                   'changeMonth'=>true,
                                  'changeYear'=>true,
                                 'yearRange'=>'2014:'.date('Y'),
                               ],
                          
                            //'dateFormat' => h::getFormatShowDate(),
                            'options'=>['class'=>'form-control',
                               'disabled'=>(!$bloqueado)?false:true  
                                ]
                            ]) ?>
 </div>
  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">    
 <?= $form->field($model, 'codmov')->
            dropDownList(ComboHelper::getCboMovAlmacen(),
                  ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                      'disabled'=>(!$bloqueado)?false:true  
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
 </div>  
    
     
    <?php ActiveForm::end(); ?>

    <?php Pjax::begin(['id'=>'grilla-materiales']); ?>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">    
   <?php //var_dump((new SigiApoderadosSearch())->searchByEdificio($model->id)); die(); ?>
    <?= GridView::widget([
        'dataProvider' =>(new \frontend\modules\mat\models\MatDetvaleSearch())->search_by_vale($model->id),
         //'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'columns' => [
                 [
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{edit}{delete}',
               'buttons' => [
                    
                                
                                'edit' => function ($url,$model) use($bloqueado)  {
			    $url= Url::to(['/mat/mat/mod-edit-mat-vale','id'=>$model->id,'gridName'=>'grilla-materiales','idModal'=>'buscarvalor']);
                              if($bloqueado)return '';
                            return \yii\helpers\Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>'0','class'=>'botonAbre']);
                            },
                        'delete' => function ($url,$model) use($bloqueado){
                                 if($bloqueado)return '';
			   $url = \yii\helpers\Url::to([$this->context->id.'/ajax-desactiva-item','id'=>$model->id]);
                              return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['title'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                            }
                        
                    ]
                ],
            'item',
             'um',
              'cant',
              'codart',              
           ['attribute' => 'descripcion',
                'format'=>'raw',
                'value'=>function($model){
                        return $model->material->descripcion;
                              } 
                
                ], 
                        ['attribute' => 'valor',
                'format'=>'raw',
                'value'=>function($model){
                        return h::formato()->asDecimal($model->valor,2);
                              } 
                
                ], 
                        ['attribute' => 'V. Unit',
                'format'=>'raw',
                'value'=>function($model){
                        return h::formato()->asDecimal($model->valor/$model->cant,2);
                              } 
                
                ], 
             ['attribute' => 'imagen',
                'format'=>'raw',
                'value'=>function($model){
                        
                          if(!empty($model->codart)){
                             $material=$model->material;
                            if($material->hasAttachments())
                            return \yii\helpers\Html::img ($material->files[0]->url,['width'=>50,'height'=>50]);
                            
                          }                           
                              } 
                
                ], 
        ],
    ]); ?>
         <?php 
   echo linkAjaxGridWidget::widget([
           'id'=>'widgetgruidBancos',
            'idGrilla'=>'grilla-materiales',
            'family'=>'holas',
          'type'=>'POST',
           'evento'=>'click',
            //'foreignskeys'=>[1,2,3],
        ]); 
   ?>
      <?php 
   echo inputAjaxWidget::widget([
           //'id'=>'widgetgruixxdBancos',
            'idGrilla'=>'grilla-materiales',
            'id'=>'btn-add-material',
          'tipo'=>'POST',
           'evento'=>'click',
         'ruta'=> Url::to([$this->context->id.'/ajax-rellena-ids-from-req','id'=>$model->id]),
            //'foreignskeys'=>[1,2,3],
        ]); 
   ?>
      
      <?php
 $url= Url::to(['mod-agrega-mat-vale','id'=>$model->id,'gridName'=>'grilla-materiales','idModal'=>'buscarvalor']);
  if(!$bloqueado)
   echo  Html::button(yii::t('base.verbs','Agregar material'), ['href' => $url, 'title' => yii::t('sta.labels','Agregar Material'),'id'=>'btn_cuentas_edi', 'class' => 'botonAbre btn btn-success']); 
       ?>   
  </div>
    <?php Pjax::end(); ?>
     
          
 <?php 
 if(!$model->isNewRecord){
  $string="$('#btn-aprobar').on( 'click', function(){ 
     
       $.ajax({
              url: '".Url::to(['/mat/mat/ajax-aprobar-vale','id'=>$model->id])."', 
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
                             }      
                   
                        }
                        });


             })";
  
   $this->registerJs($string, \yii\web\View::POS_END);
 }
  ?>          
</div>
    </div>
