<?php
use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
 use kartik\date\DatePicker;
use common\helpers\h;

use frontend\modules\sigi\helpers\comboHelper;
use common\widgets\selectwidget\selectWidget;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\SigiUnidades */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sigi-unidades-form">
<div class="box box-success">
    <div class="box box-body">
    <?php $form = ActiveForm::begin([
        'id'=>'myformulario'/*,'enableAjaxValidation'=>true*/
    ]); ?>
      <div class="box-header">
          
        <div class="col-md-12">
            <div class="form-group no-margin">
           <?php if($model->isNewRecord) {
              $url= \yii\helpers\Url::to(['/sigi/'.$this->context->id.'/nuev-mov-banco']);
                    
           }ELSE{
               $url= \yii\helpers\Url::to(['/sigi/'.$this->context->id.'/edit-mov-banco','id'=>$model->id]);
           }  ?>   
          <?= \common\widgets\buttonsubmitwidget\buttonSubmitWidget::widget(
                  ['idModal'=>$idModal,
                    'idForm'=>'myformulario',
                      'url'=>$url,
                     'idGrilla'=>$gridName, 
                      ]
                  )?>
         
                  

            </div>
        </div>
    </div>
     
  
      <div class="box-body">
    
   <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> 
    <?= ComboDep::widget([
               'model'=>$model,               
               'form'=>$form,
               'data'=> ComboHelper::getCboEdificios(),
               'campo'=>'edificio_id',
              // 'idcombodep'=>['sigimovbanco-cuenta_id','sigimovbanco-tipomov'],
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
                   'source'=>[
                                   'sigimovbanco-cuenta_id'=>[                       
                                                \frontend\modules\sigi\models\SigiCuentas::className()=>
                                            [
                                                'campoclave'=>'id' , //columna clave del modelo ; se almacena en el value del option del select 
                                                'camporef'=>'nombre',//columna a mostrar 
                                                'campofiltro'=>'edificio_id'  
                                            ]
                                              ],
                                    'sigimovbanco-tipomov'=>[\frontend\modules\sigi\models\SigiTipomov::className()=>
                                                [
                                                'campoclave'=>'codigo' , //columna clave del modelo ; se almacena en el value del option del select 
                                                'camporef'=>'descripcion',//columna a mostrar 
                                                'campofiltro'=>'edificio_id'  
                                                    ],
                                            ],
                             ],
                    
                            ])  ?>
 </div> 

 <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> 
     
    <?php
    $data=($model->isNewRecord)?[]:comboHelper::getCboCuentasByEdificio($model->edificio_id);
   echo  $form->field($model, 'cuenta_id')->
            dropDownList($data,
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>(!$nuevo)?'disabled':null,
                      //'disabled'=>(!$nuevo)?'disabled':null,
                        ]
                    ) ?>
  
     </div>          
 <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"> 
      
           <?php
            $data=($model->isNewRecord)?[]:comboHelper::getCboTipoMov($model->edificio_id);
          // print_r(\frontend\modules\sigi\helpers\comboHelper::getCboTipoMov());die();
           echo $form->field($model, 'tipomov')->
            dropDownList($data,
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
      
 </div>         
          
          
 
 <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
      <?= $form->field($model, 'fopera')->widget(DatePicker::class, [
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
  
   <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">    
 <?= $form->field($model, 'monto')->textInput(['disabled'=>$model->hasChilds()]) ?>
 </div>
  <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">    
 <?= $form->field($model, 'descripcion')->textInput()?>
 </div> 
 </div>
 
          
     

     
    <?php ActiveForm::end(); ?>

</div>
    </div></div>
