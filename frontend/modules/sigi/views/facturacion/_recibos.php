<?php
 

use yii\helpers\Html;
use yii\helpers\Url;
//use yii\widgets\ActiveForm;
//use frontend\modules\sigi\helpers\comboHelper;
use common\helpers\FileHelper;
use common\helpers\h;
//use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
//use kartik\grid\GridView;
use yii\widgets\Pjax;
//use common\widgets\selectwidget\selectWidget;

/* @var $model frontend\modules\sigi\models\SigiFacturacion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sigi-facturacion-form">

      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
             <?php 
             $aprobado=$model->isAprobado();
             /*var_dump($model->idsToFacturacion());die();*/ ?>   
          <?=(!$aprobado)?Html::button('<span class="fa fa-book-reader"></span>   '.Yii::t('sta.labels', 'Resetear recibos'), ['id'=>'boton_reset_recibos','class' => 'btn btn-warning']):''?>    
             <?=(!$aprobado)?Html::button('<span class="fa fa-book-reader"></span>   '.Yii::t('sta.labels', 'Generar Recibos'), ['id'=>'boton_recibos','class' => 'btn btn-warning']):''?>      
              <?=(!$aprobado)?Html::button('<span class="fa fa-book-reader"></span>   '.Yii::t('sta.labels', 'Compilar Recibos'), ['id'=>'boton_compile_recibos','class' => 'btn btn-warning']):''?>       
           
                     <?=($aprobado)?Html::button('<span class="fa fa-book-reader"></span>   '.Yii::t('sta.labels', 'Enviar recibos'), ['id'=>'boton_recibos_mail','class' => 'btn btn-warning']):''?>    
       
        
                <?php Pjax::begin(['id'=>'mippjax','timeout'=>false]) ?>
                  <?php 
                  $i=1;
                    foreach($model->array_blocks_files() as $ruta){                        
                      echo  Html::a(FileHelper::fileName($ruta),Url::toRoute(['/sigi/facturacion/download-part','id'=>$model->id,'part'=>$i]),['data-pjax'=>'0']).'<br>'; 
                       $i++;
                    }
                  ?>
                <?php Pjax::end() ?>                
            </div>
        </div>
    </div>
      <div class="box-body">


   
          
       

<?php 
  $string="$('#boton_reset_recibos').on( 'click', function(){      
       $.ajax({
              url: '".Url::to(['/sigi/facturacion/clear-recibos','id'=>$model->id])."', 
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
                               $.pjax.reload({container: '#mippjax'});
                             }      
                   
                        }
                        });


             })";
  
  $this->registerJs($string, \yii\web\View::POS_END);
?>  
   
          
          


<?php 
  $string="$('#boton_recibos').on( 'click', function(){      
       $.ajax({
              url: '".Url::to(['/sigi/facturacion/genera-recibos','id'=>$model->id])."', 
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
                   
                        }
                        });


             })";
  
  $this->registerJs($string, \yii\web\View::POS_END);
?>
 
          

<?php 
  $string="$('#boton_compile_recibos').on( 'click', function(){      
       $.ajax({
              url: '".Url::to(['/sigi/facturacion/compile-recibos','id'=>$model->id])."', 
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
                               $.pjax.reload({container: '#mippjax'});
                             }      
                   
                        }
                        });


             })";
  
  $this->registerJs($string, \yii\web\View::POS_END);
?>          
          
          
          
      
  <?php 
  $string="$('#boton_recibos_mail').on( 'click', function(){      
       $.ajax({
              url: '".Url::to(['/sigi/facturacion/send-massive-recibo','id'=>$model->id])."', 
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
                   
                        }
                        });


             })";
  
  $this->registerJs($string, \yii\web\View::POS_END);
?>     
   
      
</div>   
     
    <?php 
  $string="$('#sigifacturacion-edificio_id').on( 'change', function(){ 
       var identidad=$('#sigifacturacion-edificio_id').val();
       //alert(identidad);
       var Vurl='".Url::to(['/sigi/facturacion/ajax-recomendacion','id'=>'parex456'])."';
       Vurl=Vurl.replace('parex456',identidad);
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
              alert(data);
              $('#sigifacturacion-detalles').val(data);
             
                           
                   
                        }
                        });


             })";
  
  $this->registerJs($string, \yii\web\View::POS_END);
?>

</div>
    </div>