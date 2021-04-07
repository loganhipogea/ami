<?php
use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
 use kartik\date\DatePicker;
use common\helpers\h;
use yii\widgets\Pjax;
 //use kartik\date\DatePicker;
use common\widgets\spinnerWidget\spinnerWidget;
use frontend\modules\sigi\helpers\comboHelper;
use common\widgets\selectwidget\selectWidget;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\SigiUnidades */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sigi-unidades-form">
 <?= spinnerWidget::widget(); ?>
<div class="box box-success">
    <div class="box box-body">
    <?php $form = ActiveForm::begin([
        'id'=>'myformulario'/*,'enableAjaxValidation'=>true*/
    ]); ?>
      <div class="box-header">
          
        <div class="col-md-12">
            <div class="form-group no-margin">
          <?php if($model->isNewRecord){
              $url= \yii\helpers\Url::to(['/sigi/'.$this->context->id.'/crea-prog-pago','id'=>$id]);
          }else{
             $url= \yii\helpers\Url::to(['/sigi/'.$this->context->id.'/edit-prog-pago','id'=>$id]); 
          } ?>
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
         <?php 
        echo  $form->field($model, 'edificio_id')->textInput(['disabled'=>true,'value'=>$model->edificio->nombre]);
         ?> 
          
   </div>
   
   <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
         <?php 
         echo $form->field($model, 'cuenta_id')->textInput(['disabled'=>true,'value'=>$model->edificio->cuentaActiva()->nombre]);
         ?> 
          
   </div>
          
 <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
         <?php 
         echo $form->field($model, 'monto')->textInput();
         ?> 
          
   </div>
 
  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <?php  //h::settings()->invalidateCache();  ?>
                       <?= $form->field($model, 'fechaprog')->widget(DatePicker::class, [
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
          
   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
      <?php 
         echo $form->field($model, 'detalle')->textarea();
       ?> 
      
 </div> 
          
          
          
 </div>

     
    <?php ActiveForm::end(); ?>
        
<?php echo Html::button('<span class="fa fa-book-reader"></span>   '.Yii::t('sta.labels', 'Refrescar'), ['id'=>'boton_refrescar','class' => 'btn btn-warning']); ?>   
               
<?php Pjax::begin(['id'=>'adjuntos_23E'.$model->id,'timeout'=>90000]); ?>
       <?php  
       if($model->hasAttachments()){
           foreach($model->files as $file){
              echo $this->renderAjax('@frontend/views/comunes/view_pdf', [
                        'urlFile' => $file->urlTempWeb,
                         'width' => 800,
                            'height' => 500,
             ]).'<BR>'; 
           }
       }
       ?> 
        
  <?php Pjax::end(); ?>      
</div>
    </div></div>
<?php 
  $string="$('#boton_refrescar').on( 'click', function(){ 
      
       var Vurl='".Url::to(['/sigi/movimientos/attach-voucher','id'=>$model->id])."';
       $.ajax({
              url:Vurl, 
              type: 'get',
              data:{},
              //dataType: 'json', 
              error:  function(xhr, textStatus, error){               
                            var n = Noty('id');                      
                              $.noty.setText(n.options.id, error);
                              $.noty.setType(n.options.id, 'error');       
                                }, 
              success: function(data) {
               $.pjax.reload({container: '#adjuntos_23E".$model->id."', async: false});
             
                           
                   
                        }
                        });


             })";
  
  $this->registerJs($string, \yii\web\View::POS_END);
       ?>   