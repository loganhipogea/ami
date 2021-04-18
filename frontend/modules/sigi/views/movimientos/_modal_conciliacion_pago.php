<?php
use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
 use kartik\date\DatePicker;
use common\helpers\h;
use yii\widgets\Pjax;
use common\widgets\spinnerWidget\spinnerWidget;
use frontend\modules\sigi\helpers\comboHelper;
use common\widgets\selectsimplewidget\selectSimpleWidget;
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
              $url= \yii\helpers\Url::to(['/sigi/'.$this->context->id.'/crea-pago','id'=>$id]);
          }else{
             $url= \yii\helpers\Url::to(['/sigi/'.$this->context->id.'/edit-pago','id'=>$id]); 
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
            echo  $form->field($model, 'cuenta_id')->textInput(['disabled'=>true,'value'=>$model->cuenta->nombre]);
           ?> 
          
   </div>
   <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
         <?php 
        echo  $form->field($model, 'edificio_id')->textInput(['disabled'=>true,'value'=>$model->edificio->nombre]);
         ?> 
          
   </div>
   <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
         <?php         
             echo $form->field($model, 'idop')->textInput(['disabled'=>true,'value'=>$model->movBanco->monto]);
           ?> 
          
   </div>
   <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
         <?php 
         echo $form->field($model, 'id')->textInput(['disabled'=>true,'value'=>$model->cuenta->nombre]);
         ?> 
          
   </div>
          
 <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
         <?php 
         echo $form->field($model, 'monto')->textInput();
         ?> 
          
   </div>
 <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"> 
      <?php 
  // $necesi=new Parametros;
    echo selectSimpleWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'modeloForeign'=>New frontend\modules\sigi\models\VwSigiPorPagar(),
          'foreignField'=>'id',//El campo enlace del modelo forane , en este caso  VwSigiPorPagar(
            'form'=>$form,
            'campo'=>'pago_id',
           'filterWhere'=>['<>','deuda',0],
         'ordenCampo'=>1,
         'addCampos'=>[4,5,8],
        ]);  ?>
      
 </div>   
   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
      <?php 
         echo $form->field($model, 'glosa')->textInput();
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