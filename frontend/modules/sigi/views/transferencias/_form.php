<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\widgets\ActiveForm;
use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
use frontend\modules\sigi\helpers\comboHelper;
use frontend\modules\sigi\models\SigiUnidades;
use common\widgets\inputajaxwidget\inputAjaxWidget;
use yii\widgets\Pjax;
 use kartik\date\DatePicker;
 use common\helpers\h;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\SigiTransferencias */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sigi-transferencias-form">
    
    <br>
    <?php 
    $nuevo=$model->isNewRecord;
    $form = ActiveForm::begin([
    'fieldClass'=>'\common\components\MyActiveField',
     'enableAjaxValidation'=>true,
    ]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
                
        <?= Html::submitButton('<span class="fa fa-save"></span>   '.Yii::t('sigi.labels', 'Save'), ['class' => 'btn btn-success']) ?>
         <?= Html::buttonInput(Yii::t('sigi.labels', 'Anular'), ['id'=>'btn-anular','class' => 'btn btn-danger']) ?>    

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
               'idcombodep'=>'sigitransferencias-unidad_id',
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
                   'source'=>[SigiUnidades::className()=>
                                [
                                        'campoclave'=>'id' , //columna clave del modelo ; se almacena en el value del option del select 
                                        'camporef'=>'nombre',//columna a mostrar 
                                        'campofiltro'=>'edificio_id'  
                                ]
                                ],
                    'inputOptions'=>['disabled'=>(!$nuevo)?'disabled':null]
                            ]
               
               
        )  ?>
 </div> 

 <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> 
     
    <?php
    $data=($model->isNewRecord)?[]:comboHelper::getCboSameUnits($model->edificio_id);
   echo  $form->field($model, 'unidad_id')->
            dropDownList($data,
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>(!$nuevo)?'disabled':null,
                      'disabled'=>(!$nuevo)?'disabled':null,
                        ]
                    ) ?>
  
     </div> 
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
    <div class="alert alert-warning"><?= yii::t('sta.labels','Propietario')?>:<div id="propi"><?php echo $model->unidad->oldPropietario($model->unidad::TYP_PROPIETARIO);   ?></div></div>
</div>
  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"> 
      <?= $form->field($model, 'fecha')->widget(DatePicker::class, [
                            'language' => h::app()->language,
                           'pluginOptions'=>[
                                       'format' => h::getFormatShowDate(),
                                   'changeMonth'=>true,
                                  'changeYear'=>true,
                                 'yearRange'=>'2010:'.date('Y'),
                               ],
                          
                            //'dateFormat' => h::getFormatShowDate(),
                            'options'=>['class'=>'form-control','disabled'=>(!$nuevo)?'disabled':null,]
                            ]) ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
    <?php
    $data=($model->isNewRecord)?[]:comboHelper::getCboApoderados($model->edificio_id);
   echo  $form->field($model, 'codpro')->
            dropDownList($data,
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                    'disabled'=>(!$nuevo)?'disabled':null,
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
  

 </div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
     <?= $form->field($model, 'nombre')->textInput(['maxlength' => true,'disabled'=>(!$nuevo)?'disabled':null,]) ?>

 </div>
 
          
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'correo')->textInput(['maxlength' => true,'disabled'=>(!$nuevo)?'disabled':null,]) ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'dni')->textInput(['maxlength' => true,'disabled'=>(!$nuevo)?'disabled':null,]) ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?=$form->field($model, 'parent_id')->
            dropDownList( ($model->isNewRecord)?[]:comboHelper::getCboSameUnits($model->edificio_id),
  
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                    'disabled'=>(!$nuevo)?'disabled':null,
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>

 </div>
     
    <?php ActiveForm::end(); ?>

</div>
    </div>

<?php 
    Pjax::begin(['id'=>'mipjaxcv']);
        echo inputAjaxWidget::widget([
      'id'=>'btn-anular',
            'tipo'=>'get',
            'evento'=>'click',
      'isHtml'=>false,
            'idGrilla'=>'mipjaxcv',
            'ruta'=>Url::to(['/sigi/transferencias/ajax-anula-transf','id'=>$model->id]),          
           //'posicion'=> \yii\web\View::POS_END           
        
            ]);
       Pjax::end();
?>

<?php 
$source=[SigiUnidades::className()=>
         [
          'campoclave'=>'id' , //columna clave del modelo ; se almacena en el value del option del select 
          'camporef'=>'nombre',//columna a mostrar 
           'campofiltro'=>'edificio_id'  
           ]
        ];
  $string="$('#sigitransferencias-edificio_id').on( 'change', function(){  
      var valor=$('#sigitransferencias-edificio_id').val();
       $.ajax({
              url: '".Url::toRoute('/finder/combodependiente')."', 
              type:'post',
                dataType:'html',
              data:{isremotesource:'yes',filtro:valor,source:".Json::encode($source)."},
              
 error: function (data) {// success callback function
           $('#sigitransferencias-parent_id').html(data);
    },            
success: function (data) {// success callback function
           $('#sigitransferencias-parent_id').html(data);
    }
                        });


             })";
  
  $this->registerJs($string, \yii\web\View::POS_END);
?>

<?php 

  $string="$('#sigitransferencias-edificio_id').on( 'change', function(){  
      var valor=$('#sigitransferencias-edificio_id').val();
     // alert(valor);
       $.ajax({
              url: '".Url::toRoute('/sigi/transferencias/apoderados')."', 
              type:'post',
                dataType:'html',
              data:{id:'".$model->id."',edificio: valor },
              
 error: function (data) {// success callback function
           $('#sigitransferencias-codpro').html(data);
    },            
success: function (data) {// success callback function
           $('#sigitransferencias-codpro').html(data);
    }
                        });


             })";
  
  $this->registerJs($string, \yii\web\View::POS_END);
?>

<?php 

  $string="$('#sigitransferencias-unidad_id').on( 'change', function(){  
      var valor=$('#sigitransferencias-unidad_id').val();
     // alert(valor);
       $.ajax({
              url: '".Url::toRoute('/sigi/transferencias/propietario')."', 
              type:'post',
                dataType:'html',
              data:{id:'".$model->id."',unidad: valor },
              
 error: function (data) {// success callback function
           $('#propi').html(data);
    },            
success: function (data) {// success callback function
           $('#propi').html(data);
    }
                        });


             })";
  
  $this->registerJs($string, \yii\web\View::POS_END);
?>