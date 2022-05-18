<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\h;
    use common\helpers\ComboHelper;
use common\widgets\selectwidget\selectWidget;
use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
 use kartik\date\DatePicker;
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
          $operacion=($model->isNewRecord)?'mod-crea-comprobante':'mod-edita-comprobante';
             IF($model->isNewRecord){
               $url=\yii\helpers\Url::to(['/cc/cuentas/'.$operacion,'id'=>$id]);  
                 
             }else{
                $url=\yii\helpers\Url::to(['/cc/cuentas/'.$operacion,'id'=>$id]);  
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
      
   <div class="col-lg-6 col-md-4 col-sm-12 col-xs-12">    
        <?= $form->field($model, 'codocu')->
            dropDownList(ComboHelper::getCboDocuments(),
                  ['prompt'=>'--'.yii::t('base.verbs','Escoja un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
 </div>    
 <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">    
        <?= $form->field($model, 'prefijo')->textInput() ?>
 </div> 
  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">    
        <?= $form->field($model, 'numero')->textInput() ?>
 </div>
 <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
      <?= $form->field($model, 'fecha')->widget(DatePicker::class, [
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
   <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">    
        <?= $form->field($model, 'glosa')->textInput() ?>
 </div>        
    <div class="col-lg-6 col-md-4 col-sm-12 col-xs-12">    
        <?= $form->field($model, 'codmon')->
            dropDownList(ComboHelper::getCboMonedas(),
                  ['prompt'=>'--'.yii::t('base.verbs','Escoja un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
   </div>   
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">    
        <?= $form->field($model, 'rucpro')->textInput() ?>
   </div> 
   <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">    
        <?= $form->field($model, 'monto')->textInput() ?>
   </div>  
            
     
    <?php ActiveForm::end(); ?>
     <?php 
     $url= Url::to(['mod-crea-comprobante','id'=>$model->id,'gridName'=>'grilla-compras','idModal'=>'buscarvalor']);
   echo  Html::button(yii::t('base.verbs','Agregar comprobante'), ['href' => $url, 'title' => yii::t('sta.labels','Agregar Comprobante'),'id'=>'btn_cuentas_edi', 'class' => 'botonAbre btn btn-success']); 
  ?>

</div>
    </div>
</div>
