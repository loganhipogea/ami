<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
use common\helpers\ComboHelper;
use common\widgets\selectwidget\selectWidget;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\Edificios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="edificios-form">
    <br>
    <?php $form = ActiveForm::begin([
   // 'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
         <?php $url=Url::to(['/sigi/'.$this->context->id.'/verificar-datos','id'=>$model->id]);  ?>       
        <?= Html::submitButton('<span class="fa fa-save"></span>'.'  '.Yii::t('sigi.labels', 'Guardar'), ['class' => 'btn btn-success']) ?>
            <?=(!$model->isNewRecord)?Html::button('<span class="fa fa-book-reader"></span>   '.Yii::t('sta.labels', 'Verificar datos'), ['href' => $url, 'title' => yii::t('sta.labels','Verificar Datos'),'id'=>'btn-add-test','class' => 'botonAbre btn btn-warning']):''?>
            <?=(!$model->isNewRecord)?Html::button('<span class="fa fa-users"></span>   '.Yii::t('sta.labels', 'Generar Usuarios'), ['class' => 'btn btn-success','href' => '#','id'=>'btn-add-usuarios']):''?>
           <?=(!$model->isNewRecord)?common\widgets\auditwidget\auditWidget::widget(['model'=>$model]):''?>
           <?php    $url=\yii\helpers\Url::toRoute(['/finder/selectimage',
               'isImage'=>false,
               'idModal'=>'imagemodal',
               'modelid'=>$model->id,
                'extension'=> \yii\helpers\Json::encode(['jpg']),
               'nombreclase'=> str_replace('\\','_',get_class($model))
               ]); ?>
            <?=(!$model->isNewRecord)?Html::button('<span class="fa fa-clip"></span>   '.Yii::t('sta.labels', 'Adjuntar imagen'), ['class' => 'botonAbre btn btn-success','href' => $url,'id'=>'btn-add-usuarios']):''?> 

            </div>
        </div>
    </div>
      <div class="box-body">
    
 
 <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"> 
     <?php 
  // $necesi=new Parametros;
    echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'form'=>$form,
            'campo'=>'codtra',
         'ordenCampo'=>2,
         'addCampos'=>[3,4],
        ]);  ?>

 </div> 
  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
     <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

 </div>
<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
     <?= $form->field($model, 'proyectista')->textInput(['maxlength' => true]) ?>

 </div>
  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
     <?= $form->field($model, 'direccion')->textInput(['maxlength' => true]) ?>
 </div>        
          
          
              <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"> 
    <?= ComboDep::widget([
               'model'=>$model,               
               'form'=>$form,
               'data'=> ComboHelper::getCboDepartamentos(),
               'campo'=>'coddepa',
               'idcombodep'=>'edificios-codprov',
               /* 'source'=>[ //fuente de donde se sacarn lso datos 
                    /*Si quiere colocar los datos directamente 
                     * para llenar el combo aqui , hagalo coloque la matriz de los datos
                     * aqui:  'id1'=>'valor1', 
                     *        'id2'=>'valor2,
                     *         'id3'=>'valor3,
                     *        ...
                     * En otro caso 
                     * de la BD mediante un modelo  
                     */
                        /*Docbotellas::className()=>[ //NOmbre del modelo fuente de datos
                                        'campoclave'=>'id' , //columna clave del modelo ; se almacena en el value del option del select 
                                        'camporef'=>'descripcion',//columna a mostrar 
                                        'campofiltro'=>'codenvio'/* //cpolumna 
                                         * columna que sirve como criterio para filtrar los datos 
                                         * si no quiere filtrar nada colocwue : false | '' | null
                                         *
                        
                         ]*/
                   'source'=>[\common\models\masters\Ubigeos::className()=>
                                [
                                  'campoclave'=>'codprov' , //columna clave del modelo ; se almacena en el value del option del select 
                                        'camporef'=>'provincia',//columna a mostrar 
                                        'campofiltro'=>'coddepa'  
                                ]
                                ],
                            ]
               
               
        )  ?>
 </div>       
          
          
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"> 
    <?= ComboDep::widget([
               'model'=>$model,               
               'form'=>$form,
               'data'=> ($model->isNewRecord)?[]:ComboHelper::getCboProvincias($model->coddepa),
               'campo'=>'codprov',
               'idcombodep'=>'edificios-coddist',
               /* 'source'=>[ //fuente de donde se sacarn lso datos 
                    /*Si quiere colocar los datos directamente 
                     * para llenar el combo aqui , hagalo coloque la matriz de los datos
                     * aqui:  'id1'=>'valor1', 
                     *        'id2'=>'valor2,
                     *         'id3'=>'valor3,
                     *        ...
                     * En otro caso 
                     * de la BD mediante un modelo  
                     */
                        /*Docbotellas::className()=>[ //NOmbre del modelo fuente de datos
                                        'campoclave'=>'id' , //columna clave del modelo ; se almacena en el value del option del select 
                                        'camporef'=>'descripcion',//columna a mostrar 
                                        'campofiltro'=>'codenvio'/* //cpolumna 
                                         * columna que sirve como criterio para filtrar los datos 
                                         * si no quiere filtrar nada colocwue : false | '' | null
                                         *
                        
                         ]*/
                   'source'=>[\common\models\masters\Ubigeos::className()=>
                                [
                                  'campoclave'=>'coddist' , //columna clave del modelo ; se almacena en el value del option del select 
                                        'camporef'=>'distrito',//columna a mostrar 
                                        'campofiltro'=>'codprov'  
                                ]
                                ],
                            ]
               
               
        )  ?>
 </div> 
 <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">    
 <?= $form->field($model, 'coddist')->
            dropDownList(($model->isNewRecord)?[]:ComboHelper::getCboDistritos($model->codprov),
                  ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
 </div>  
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'latitud')->textInput(['maxlength' => true]) ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'meridiano')->textInput(['maxlength' => true]) ?>

 </div>
  
  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
     <?= 
            $form->field($model, 'tipo')->
            dropDownList($model->comboDataField('tipo') ,
                    ['prompt'=>'--'.yii::t('base.verbs','Seleecione un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    )  ?>
</div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'npisos')->textInput() ?>

 </div>
 <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">         
          <?= 
            $form->field($model, 'codcen')->
            dropDownList(comboHelper::getCboCentros() ,
                    ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    )  ?>
</div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
     <?= Html::label(yii::t('base.names','Area'),'45545rret',['class' => 'control-label']) ?>
           
            <?=  Html::textInput('45545rret',  $model->area(),['disabled'=>true,'class' => 'form-control form-group']) ?>
          
 </div>  
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'codigo')->textInput() ?>

 </div>
          
          
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'detalles')->textarea(['rows' => 6]) ?>

 </div>
   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'facturacion')->textarea(['rows' => 6]) ?>

 </div>
  
      
          
     
    <?php ActiveForm::end(); ?>

</div>
    </div>
 <?php 
 if(!$model->isNewRecord){
  $string="$('#btn-add-usuarios').on( 'click', function(){ 
     
       $.ajax({
              url: '".Url::to(['/sigi/edificios/generate-usuarios','id'=>$model->id])."', 
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