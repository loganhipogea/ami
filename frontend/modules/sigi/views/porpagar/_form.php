<?php
use frontend\modules\sigi\helpers\comboHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\helpers\h;
 use kartik\date\DatePicker;
 use common\widgets\selectwidget\selectWidget;
  use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
  //ECHO \common\widgets\spinnerWidget\spinnerWidget::widget();
/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\SigiPorpagar */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sigi-porpagar-form">
    <br>
    <?php $form = ActiveForm::begin([
    'fieldClass'=>'\common\components\MyActiveField',
        'id'=>'miform',
    ]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
                
        <?= Html::submitButton('<span class="fa fa-save"></span>   '.Yii::t('sigi.labels', 'Save'), ['class' => 'btn btn-success']) ?>
          <?=(!$model->isNewRecord)?Html::button('<span class="fa fa-money"></span>   '.Yii::t('sta.labels', 'Programar Pago'), ['class' => 'btn btn-warning','href' => '#','id'=>'btn-programa-pago']):''?>   
             
            </div>
        </div>
    </div>
      <div class="box-body">
    
 
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'codocu')->dropDownList(
 comboHelper::getCboDocuments(),
             ['prompt'=>yii::t('sigi.labels','--Escoja un valor--')]
             ) ?>
 </div>
  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"> 
     
    <?= ComboDep::widget([
               'model'=>$model,               
               'form'=>$form,
               'data'=> comboHelper::getCboEdificios(),
               'campo'=>'edificio_id',
               'idcombodep'=>'sigiporpagar-cargoedificio_id',
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
                    'source'=>[\frontend\modules\sigi\models\VwSigiColectores::className()=>
                                [
                                  'campoclave'=>'idcolector' , //columna clave del modelo ; se almacena en el value del option del select 
                                     'camporef'=>'descargo',//columna a mostrar 
                                        'campofiltro'=>'edificio_id'  
                                ]
                                ],
                            ]
               
               
        )  ?>
     


 </div> 
          
 <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
      <?= $form->field($model, 'codmon')->dropDownList(
 comboHelper::getCboMonedas(),
             ['prompt'=>yii::t('sigi.labels','--Escoja un valor--')]
             ) ?>

 </div>
  
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'monto')->textInput(['maxlength' => true,'disabled'=>$model->hasChilds()]) ?>

  </div>
 <div class="col-lg-6 col-md-8 col-sm-6 col-xs-12">
     <?php
     if($model->isNewRecord){
         $dati=[];
     }else{
         $dati= comboHelper::getCboColectores($model->edificio_id);
     }
     ?>
     <?= $form->field($model, 'cargoedificio_id')->dropDownList(
             $dati,
             ['prompt'=>yii::t('sigi.labels','--Escoja un valor--')]
             ) ?>
 </div>
  
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'glosa')->textInput(['maxlength' => true]) ?>

 </div>
   <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12"> 
     <?php 
  // $necesi=new Parametros;
    echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'form'=>$form,
            'campo'=>'codpro',
         'ordenCampo'=>1,
         'addCampos'=>[2],
        ]);  ?>

 </div>            
          
 <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <?php  //h::settings()->invalidateCache();  ?>
                       <?= $form->field($model, 'fechadoc')->widget(DatePicker::class, [
                             'language' => h::app()->language,
                           // 'readonly'=>true,
                          // 'inline'=>true,
                           'pluginOptions'=>[
                                     'format' => h::gsetting('timeUser', 'date')  , 
                                  'changeMonth'=>true,
                                  'changeYear'=>true,
                                 'yearRange'=>"-99:+0",
                               ],
                           
                            //'dateFormat' => h::getFormatShowDate(),
                            'options'=>['class'=>'form-control','disabled'=>$model->hasChilds()]
                            ]) ?>
</div>
          
          <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <?php  //h::settings()->invalidateCache();  ?>
                       <?= $form->field($model, 'fechaprog',['enableAjaxValidation'=>true])->widget(DatePicker::class, [
                             'language' => h::app()->language,
                           // 'readonly'=>true,
                          // 'inline'=>true,
                           'pluginOptions'=>[
                                     'format' => h::gsetting('timeUser', 'date')  , 
                                  'changeMonth'=>true,
                                  'changeYear'=>true,
                                 'yearRange'=>"-99:+0",
                               ],
                           
                            //'dateFormat' => h::getFormatShowDate(),
                            'options'=>['class'=>'form-control']
                            ]) ?>
</div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'codestado')->textInput(['maxlength' => true]) ?>

 </div>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'detalle')->textarea(['rows' => 6]) ?>

 </div>
     
          
          
    <?php ActiveForm::end(); ?>
          
    <?php 
 if(!$model->isNewRecord){
  $string="$('#btn-programa-pago').on( 'click', function(){ 
     
       $.ajax({
              url: '".Url::to(['/sigi/porpagar/programar-pago','id'=>$model->id])."', 
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
