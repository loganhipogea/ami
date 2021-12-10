<?php
use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
use frontend\modules\sigi\helpers\comboHelper;
use common\helpers\timeHelper;
use common\helpers\h;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\SigiEstadocuentas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sigi-estadocuentas-form">
    <br>
    <?php 
    $formato=h::formato();
    $tieneMov=($model->isNewRecord)?false:$model->hasMovimientos();
    $form = ActiveForm::begin([
       'id'=>'misu','enableAjaxValidation'=>true,
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
                
        <?= Html::submitButton('<span class="fa fa-save"></span>   '.Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
          <?=Html::button('<span class="fa fa-book-reader"></span>   '.Yii::t('sta.labels', 'Refrescar'), ['id'=>'boton_refrescar','class' => 'btn btn-warning'])?>      
           

            </div>
        </div>
    </div>
      <div class="box-body">
 <?php Pjax::begin(['id'=>'letrero']);  ?>
   <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> 
    <?= ComboDep::widget([
               'model'=>$model, 
             'inputOptions'=>['disabled'=>$tieneMov],
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
                      'disabled'=>$tieneMov
                        ]
                    ) ?>
  
     </div> 
  <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
     <?php echo $form->field($model, 'mes')->
            dropDownList(timeHelper::cboMeses(true),
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                    'disabled'=>$tieneMov
                        ]
                    ) ?>
 </div>
  <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
     <?php echo $form->field($model, 'anio')->
            dropDownList(timeHelper::cboAnnos(),
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        'disabled'=>$tieneMov
                      ]
                    ) ?>
 </div>
     <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'estado')->textInput(['style'=>"color:red;font-size:14px;font-weight:800;",'disabled' => true,'maxlength' => true]) ?>
 
 </div> 
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'saldmesant')->textInput(['value'=>$formato->asDecimal($model->saldmesant,2),'disabled' => true,'maxlength' => true,'style'=>'text-align:right;']) ?>

 </div>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
     <?= $form->field($model, 'ingresos')->textInput(['value'=>$formato->asDecimal($model->ingresos,2),'disabled' => true,'maxlength' => true,'style'=>'text-align:right;']) ?>
      <?php 
      echo $this->render('egresos',['datos'=>$model->ingresosArray()]);
      ?>
 </div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
     <?= $form->field($model, 'egresos')->textInput(['value'=>$formato->asDecimal($model->egresos,2),'disabled' => true,'maxlength' => true,'style'=>'text-align:right;']) ?>
      <?php 
      echo $this->render('egresos',['datos'=>$model->egresosArray()]);
      ?>
 </div>
  </div>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'saldfinal')->textInput(['value'=>$formato->asDecimal($model->saldfinal,2),'disabled' => true,'maxlength' => true,'style'=>'text-align:right;']) ?>

 </div>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'saldecuenta')->textInput(['value'=>$formato->asDecimal($model->saldecuenta,2),'disabled' => true,'maxlength' => true,'style'=>'text-align:right;']) ?>

 </div>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'salddif')->textInput(['value'=>$formato->asDecimal($model->salddif,2),'disabled' => true,'maxlength' => true,'style'=>'text-align:right;']) ?>

 </div>
  
     <?php Pjax::end();  ?>
    <?php ActiveForm::end(); ?>

</div>
    </div>
<?php 
  $string="$('#boton_refrescar').on( 'click', function(){      
       $.ajax({
              url: '".Url::to(['/sigi/estadocu/ajax-refresh','id'=>$model->id])."', 
              type: 'get',
              data:{},
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
                              $.pjax.reload({container: '#letrero', async: false});
                        }
                        });


             })";
  
  $this->registerJs($string, \yii\web\View::POS_END);
?> 
    
<?php 
/*print_r($model->find()->movimientosAgrupado()->
            andWhere(['ingreso'=>'0'])->asArray()->all());*/
?>