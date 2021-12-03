<?php
use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
use frontend\modules\sigi\helpers\comboHelper;
use common\helpers\timeHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\widgets\co
/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\SigiEstadocuentas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sigi-estadocuentas-form">
    <br>
    <?php $form = ActiveForm::begin([
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
                
        <?= Html::submitButton('<span class="fa fa-save"></span>   '.Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
            

            </div>
        </div>
    </div>
      <div class="box-body">
 
   <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> 
    <?= ComboDep::widget([
               'model'=>$model, 
             'inputOptions'=>['disabled'=>$model->hasChilds()],
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
                                   'sigiestadocuentas-cuenta_id'=>[                       
                                                \frontend\modules\sigi\models\SigiCuentas::className()=>
                                            [
                                                'campoclave'=>'id' , //columna clave del modelo ; se almacena en el value del option del select 
                                                'camporef'=>'nombre',//columna a mostrar 
                                                'campofiltro'=>'edificio_id'  
                                            ]
                                              ],
                                    'estadocu-tipomov'=>[\frontend\modules\sigi\models\SigiTipomov::className()=>
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
                      'disabled'=>$model->hasChilds()
                        ]
                    ) ?>
  
     </div>  
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'saldmesant')->textInput(['disabled' => true,'maxlength' => true]) ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'ingresos')->textInput(['disabled' => true,'maxlength' => true]) ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'egresos')->textInput(['disabled' => true,'maxlength' => true]) ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'saldfinal')->textInput(['disabled' => true,'maxlength' => true]) ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'saldecuenta')->textInput(['disabled' => true,'maxlength' => true]) ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'salddif')->textInput(['disabled' => true,'maxlength' => true]) ?>

 </div>
  <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
     <?php echo $form->field($model, 'mes')->
            dropDownList(timeHelper::cboMeses(),
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                     'disabled'=>(!$aprobado)?false:true,
                        ]
                    ) ?>
 </div>
  <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
     <?php echo $form->field($model, 'anio')->
            dropDownList(timeHelper::cboAnnos(),
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                         'disabled'=>(!$aprobado)?false:true,
                      ]
                    ) ?>
 </div>
     
    <?php ActiveForm::end(); ?>

</div>
    </div>
