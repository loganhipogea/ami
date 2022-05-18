<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use frontend\modules\op\helpers\ComboHelper;
  use kartik\time\TimePicker;
use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
 //use kartik\date\DatePicker;
use kartik\datetime\DateTimePicker;
//use common\widgets\selectwidget\selectWidget;
use common\helpers\h;

/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\Edificios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="edificios-form">
    <br>
    <?php $form = ActiveForm::begin([
        'id'=>'myformulario',
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
           <?PHP 
           $operacion=($model->isNewRecord)?'modal-agrega-libro':'modal-edita-libro';
             IF($model->isNewRecord){
               $url=\yii\helpers\Url::to(['/op/tareo/'.$operacion,'id'=>$id]);  
                 
             }else{
                $url=\yii\helpers\Url::to(['/op/tareo/'.$operacion,'id'=>$id]);  
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
          <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
           <?php echo  $form->field($model, 'tipo')->
            dropDownList($model->comboDataField('tipo'),
                  ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
            </div>
            <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
            <?= $form->field($model, 'hinicio')->widget(TimePicker::className(), ['pluginOptions' => ['showMeridian' => false]]);?>
     

            </div>
            <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
                <?= $form->field($model, 'hfin')->widget(TimePicker::className(), ['pluginOptions' => ['showMeridian' => false]]);?>
     

            </div>
         
     
         
         
         
    
   
 
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true/*,'disabled'=>!$model->activo*/,]) ?>

 </div>
   <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"> 
    <?php echo ComboDep::widget([
               'model'=>$model,               
               'form'=>$form,
               'data'=> ComboHelper::procesos(),
               'campo'=>'proc_id',
               'idcombodep'=>'oplibro-os_id',
              
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
    <?php echo ComboDep::widget([
               'model'=>$model,               
               'form'=>$form,
               'data'=> ($model->isNewRecord)?ComboHelper::Os($model->idProc()):ComboHelper::Os($model->proc_id),
               'campo'=>'os_id',
               'idcombodep'=>'oplibro-detos_id',              
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
     
<?php 
/*$s=$model->ses;
print_r($s->sesion[$model->ses::NOMBRE_SESION]);
echo "<br>";
echo $s->idProceso."=>ID PROCESO<br>";
echo $s->idOs."=>ID OS <br>";
echo $s->idDetos."=>ID detOS <br>";

echo "<br>";
echo "proc_id=>".$model->proc_id."<br>";
echo "os_id=>".$model->os_id."<br>";
echo "detos_id=>".$model->detos_id."<br>";*/
?>
 <?php echo  $form->field($model, 'detos_id')->
            dropDownList(($model->isNewRecord)?ComboHelper::actividadesOs($model->idOs()):ComboHelper::actividadesOs($model->os_id),
                  ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
 </div>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'detalle')->textArea(['maxlength' => true,/*'disabled'=>!$model->activo,*/]) ?>
 </div>        
          
  
  
      
          
     
    <?php ActiveForm::end(); ?>

</div>


    </div>



