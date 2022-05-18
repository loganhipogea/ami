<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\h;

use common\widgets\selectwidget\selectWidget;
use common\widgets\cbodepwidget\cboDepWidget as ComboDep;

use frontend\modules\op\helpers\ComboHelper;
use frontend\modules\cc\models\CcCc;
use frontend\modules\cc\models\CcOrden;
/* @var $this yii\web\View */
/* @var $model frontend\modules\cc\models\CcCuentas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cc-cuentas-form">
     <div class="box-body">
      <?php $form = ActiveForm::begin([
       'id'=>'myformulario',
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
          
        <div class="col-md-12">
            <div class="form-group no-margin">
            <?php
          $operacion=($model->isNewRecord)?'mod-crea-calificacion':'mod-edita-calificacion';
             IF($model->isNewRecord){
               $url=\yii\helpers\Url::to(['/cc/ceco/'.$operacion,'id'=>$id]);  
                 
             }else{
                $url=\yii\helpers\Url::to(['/cc/ceco/'.$operacion,'id'=>$id]);  
             }
           ?>
           <?= \common\widgets\buttonsubmitwidget\buttonSubmitWidget::widget(
                  ['idModal'=>$idModal,
                    'idForm'=>'myformulario',
                      'url'=> $url,
                     'idGrilla'=>$gridName, 
                      ]
                  )?>
            </div>
        </div>
    </div>
     
  
      <div class="box-body">
          <div class="label-info">Acumulado : <?=$model->comprobante->acumulado()?></div>
   <?php 
    if($model->isAttributeRequired('ceco_id')){
   ?>
    <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">    
        <?php         
  // $necesi=new Parametros;
         IF($model->isScenario('SCE_'.$model->codigo_costo_orden())){
              $tipo= CcOrden::CODIGO_COLECTOR;
         }else{
             
              $tipo= CcCc::CODIGO_COLECTOR;
         }
            echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'form'=>$form,
            'campo'=>'ceco_id',
            'filterWhere'=>[['esorden'=>$tipo],],
         'ordenCampo'=>0,
         'addCampos'=>[1,3],
        ]);  ?>
    </div> 
  <?php 
    }
   ?>
   <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">    
        <?= $form->field($model, 'monto')->textInput() ?>
       <?= $form->field($model, 'tipo')->hiddenInput() ?>
   </div>       
    
     <?php 
     ECHO 'el escenario es '.$model->getScenario();
    if($model->isAttributeRequired('proc_id')){
   ?> 
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
    <?= ComboDep::widget([
               'model'=>$model,               
               'form'=>$form,
               'data'=> comboHelper::procesos() ,
               'campo'=>'proc_id',
               'idcombodep'=>'ccgastos-os_id',
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
                   'source'=>[\frontend\modules\op\models\OpOs::className()=>
                                [
                                  'campoclave'=>'id' , //columna clave del modelo ; se almacena en el value del option del select 
                                        'camporef'=>'descripcion',//columna a mostrar 
                                        'campofiltro'=>'proc_id'  
                                ]
                                ],
                            ]
               
               
        )  ?>
 </div>       
          
          
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
    <?= ComboDep::widget([
               'model'=>$model,               
               'form'=>$form,
               'data'=> ($model->isNewRecord)?[]:ComboHelper::Os(),
               'campo'=>'os_id',
               'idcombodep'=>'ccgastos-detos_id',
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
                    'source'=>[\frontend\modules\op\models\OpOsdet::className()=> 
                                [
                                  'campoclave'=>'id' , //columna clave del modelo ; se almacena en el value del option del select 
                                        'camporef'=>'descripcion',//columna a mostrar 
                                        'campofiltro'=>'os_id'  
                                ]
                                ],
                            ]
                
               
        )  ?>
 </div> 
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     
     
 <?= $form->field($model, 'detos_id')->
            dropDownList(($model->isNewRecord)?[]:ComboHelper::actividadesOs($model->os_id),
                  ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
 </div> 
   <?php 
    }
   ?>      
          
          
          
     
    <?php ActiveForm::end(); ?>
     

</div>
    </div>
</div>
