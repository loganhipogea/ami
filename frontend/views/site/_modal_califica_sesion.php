<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

//use frontend\modules\mat\helpers\ComboHelper;
use frontend\modules\op\helpers\ComboHelper;
 //use kartik\date\DatePicker;

//use common\widgets\selectwidget\selectWidget;
use common\helpers\h;

/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\Edificios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="edificios-form">
    <br>
 <div class="box-body">
    <?php $form = ActiveForm::begin([
        'id'=>'myformulario',
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
           <?PHP 
           
               $url=\yii\helpers\Url::to(['site/califica']);  
                 
             
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
      
     
          <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"> 
    <?= ComboDep::widget([
               'model'=>$model,               
               'form'=>$form,
               'data'=> ComboHelper::procesos(),
               'campo'=>'proc_id',
               'idcombodep'=>'optareo-os_id',
              
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
          
          
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"> 
    <?= ComboDep::widget([
               'model'=>$model,               
               'form'=>$form,
               'data'=> ($model->isNewRecord)?[]:ComboHelper::Os($model->proc_id),
               'campo'=>'os_id',
               'idcombodep'=>'optareo-detos_id',              
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
 <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">    
 <?= $form->field($model, 'detos_id')->
            dropDownList(($model->isNewRecord)?[]:ComboHelper::actividadesOs($model->os_id),
                  ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
 </div> 
     
 
          
     
    <?php ActiveForm::end(); ?>

   </div>
    </div>



