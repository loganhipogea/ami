<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\h;
use yii\widgets\Pjax;
use yii\grid\GridView;
use frontend\modules\sigi\helpers\comboHelper;
use common\widgets\selectwidget\selectWidget;
use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
use common\widgets\inputajaxwidget\inputAjaxWidget;
use common\helpers\FileHelper;
use dosamigos\chartjs\ChartJs;
 use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model frontend\modules\cc\models\CcCuentas */
/* @var $form yii\widgets\ActiveForm */
?>


     <div class="box-body">
      <?php $form = ActiveForm::begin([
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
          
        <div class="col-md-12">
            <div class="form-group no-margin">
            <div class="btn-group">
          <?= Html::submitButton('<span class="fa fa-save"></span>   '.Yii::t('app', 'Guardar'), ['class' => 'btn btn-success']) ?>
           <?php    $url=\yii\helpers\Url::toRoute(['/finder/selectimage',
               'isImage'=>false,
               'idModal'=>'imagemodal',
               'modelid'=>$model->id,
                'extension'=> \yii\helpers\Json::encode(array_merge(['pdf','jpg','png','svg','jpeg'])),
               'nombreclase'=> str_replace('\\','_',get_class($model))
               ]); ?>
            <?=(!$model->isNewRecord)?Html::button('<span class="fa fa-clip"></span>   '.Yii::t('sta.labels', 'Adjuntar imagen'), ['class' => 'botonAbre btn btn-success','href' => $url,'id'=>'btn-add-usuarios']):''?> 
 

                  
              </div>       
            </div>
        </div>
    </div>
         
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
             <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">    
                        <?= $form->field($model, 'codocu')->
                            dropDownList(ComboHelper::getCboDocuments(),
                            ['prompt'=>'--'.yii::t('base.verbs','Escoja un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                                    ]
                                ) ?>
                    </div>    
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">    
                        <?= $form->field($model, 'prefijo')->textInput() ?>
                    </div> 
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">    
                        <?= $form->field($model, 'numero')->textInput() ?>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">   
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
                  <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">      
                        <?= $form->field($model, 'codmon')->
                             dropDownList(ComboHelper::getCboMonedas(),
                            ['prompt'=>'--'.yii::t('base.verbs','Escoja un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                                 ]
                                ) ?>
                    </div>   
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">    
                        <?= $form->field($model, 'glosa')->textInput() ?>
                    </div>        
                   
                   <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> 
                        <?= $form->field($model, 'rucpro')->textInput() ?>
                    </div> 
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                        <div id="234_descri_proveedor" class="alert alert-info">
                            <?= $model->despro()  ?>
                        </div>
                    </div> 
                   <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">     
                            <?= $form->field($model, 'monto')->textInput() ?>
                    </div> 
             </div>
             <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
             
                    <?PHP 
                    
 ECHO ChartJs::widget([
    'type' => 'doughnut',
    'options' => [
        'height' => 150,
        'width' => 150
    ],
    'data' => [
        'labels' =>$model->ArrayLabelsTiposCostos(),
        'datasets' => [
           [
                'data' => array_values($model->ArrayPorcCostosPorTipo()),
                'label' => '',
                'backgroundColor' => array_values($model->ArrayColorsPorTipo()),
                'borderColor' =>  [
                        '#fff',
                        '#fff',
                        '#fff'
                ],
                'borderWidth' => 1,
                'hoverBorderColor'=>["#999","#999","#999"],                
            ]
            
        ]
    ]
]);
   
?>
             
             </div> 
             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <?= $form->field($model, 'detalle')->textArea() ?>
             </div>
      
         </div>      
         
     
    <?php ActiveForm::end(); ?>
    <?php echo inputAjaxWidget::widget([
            'isHtml'=>true,
            'tipo'=>'POST',
            'ruta'=>Url::to(['/masters/clipro/crea-from-api']),
            'id_input'=>'cccompras-rucpro',
            'idGrilla'=>'234_descri_proveedor'
      ])  ?>
     <div>
        <?php if($model->hasAttachments()) { 
       //echo $model::className();die();
       //echo $model->files[0]->urlTempWeb ;
       echo $this->render('@frontend/views/comunes/view_pdf', [
                        'urlFile' => $model->files[0]->urlTempWeb,
                         'width' => 700,
                            'height' => 900,
            ]); ?> 
         <?php } ?>
    </div>
  
     
  
     
</div>
  
