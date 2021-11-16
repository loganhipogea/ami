<?php
 use kartik\date\DatePicker;
use kartik\export\ExportMenu;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use frontend\modules\sigi\helpers\comboHelper;
use common\helpers\timeHelper;
use common\helpers\h;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\widgets\selectwidget\selectWidget;

/* @var $model frontend\modules\sigi\models\SigiFacturacion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sigi-facturacion-form">

    <?php $form = ActiveForm::begin([
        'enableAjaxValidation'=>true,
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
             <?php
             $aprobado=($model->isAprobado() or $model->historico);
             /*var_dump($model->idsToFacturacion());die();*/ ?>   
        <?= Html::submitButton('<span class="fa fa-save"></span>   '.Yii::t('sigi.labels', 'Grabar'), ['class' => 'btn btn-success']) ?>
          <?=(!$aprobado)?Html::a('<span class="fa fa-file-pdf" ></span>'.'  '.yii::t('sta.labels','Aprobar'),Url::to(['aprobe','id'=>$model->id]),['data-pjax'=>'0','class'=>"btn btn-success"]):
               Html::a('<span class="fa fa-file-pdf" ></span>'.'  '.yii::t('sta.labels','Desaprobar'),Url::to(['un-aprobe','id'=>$model->id]),['data-pjax'=>'0','class'=>"btn btn-success"])?>   
        <?=(!$aprobado)?Html::button('<span class="fa fa-book-reader"></span>   '.Yii::t('sta.labels', 'Facturar'), ['id'=>'boton_facturacion','class' => 'btn btn-warning']):''?>    
        <?=(!$aprobado)?Html::button('<span class="fa fa-book-reader"></span>   '.Yii::t('sta.labels', 'Resetear'), ['id'=>'boton_resetear','class' => 'btn btn-warning']):''?>      
             <?=Html::a('<span class="fa fa-file-pdf" ></span>'.'  '.yii::t('sta.labels','Ver detalle'),Url::to(['detalle-facturacion','id'=>$model->id]),['target'=>'_blank','data-pjax'=>'0','class'=>"btn btn-success"])?>
       
       <?php
       $columnasF=['kardex_id','dias','grupocobranza',
                'numerorecibo','montototal',
                'codsuministro','aacc',
                'delta','lectura',
                'edificio_id','unidad_id',
                'monto','grupounidad','grupofacturacion','facturacion_id',
                'mes','anio','fecha','fvencimiento','nombreedificio',
                'numero','nombre','area','participacion','descargo','numerodepa',
                'nombredepa','areadepa','participacion'
                ];
       echo ExportMenu::widget([
    'dataProvider' =>new \yii\data\ActiveDataProvider([
        'query'=> \frontend\modules\sigi\models\VwSigiFacturecibo::find()->
            select($columnasF)->andWhere(['facturacion_id'=>$model->id]),
    ]),
    'columns' => $columnasF,
    'dropdownOptions' => [
        'label' => yii::t('sta.labels','Exportar Facturacion'),
        'class' => 'btn btn-success'
                      ]
               ])?>
        
            </div>
        </div>
    </div>
      <div class="box-body">
      <?php Pjax::begin(['id'=>'letrero','timeout'=>true]); ?>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-orange">
            <div class="inner">
              <h3>S/.<?='    '.Yii::$app->formatter->asDecimal($model->montoTotal(),2)?></h3>

              <p>Monto cargado</p>
            </div>
            <div class="icon">
                <span style="color:white;opacity:0.5;"><i class="fa fa-money"></i></span>
            </div>
            
          </div>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>S/.<?='    '.Yii::$app->formatter->asDecimal($model->montoFacturado(),2)?></h3>

              <p>Monto facturado</p>
            </div>
            <div class="icon">
                <span style="color:white;opacity:0.5;"><i class="fa fa-money"></i></span>
            </div>
            
          </div>
  </div>
       <?php Pjax::end(); ?>
  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
    <?php echo $form->field($model, 'edificio_id')->
            dropDownList(comboHelper::getCboEdificios(),
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        'disabled'=>(!$aprobado)?false:true,
                      ]
                    ) ?>

 </div>
<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
     <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

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
     <?php echo $form->field($model, 'ejercicio')->
            dropDownList(timeHelper::cboAnnos(),
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                         'disabled'=>(!$aprobado)?false:true,
                      ]
                    ) ?>
 </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"> 
        <?Php  if(!$model->isNewRecord){ ?>
       <?Php  if($model->hasCobranzaMasiva()){ ?>
           <?php echo $form->field($model, 'unidad_id')->
            dropDownList(comboHelper::getCboUnitsNotImputables($model->edificio_id),
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                         'disabled'=>(!$aprobado)?false:true,
                      ]
                    ) ?>
        <?PHP  } ?>
        <?PHP  } ?>
 </div>   
       <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"> 
      
           <?php echo $form->field($model, 'reporte_id')->
            dropDownList(comboHelper::getCboReportes(),
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                         'disabled'=>(!$aprobado)?false:true,
                      ]
                    ) ?>
      
 </div>   
          

  <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
      <?= $form->field($model, 'fecha')->widget(DatePicker::class, [
                            'language' => h::app()->language,
                           'pluginOptions'=>[
                                     'format' => h::gsetting('timeUser', 'date')  , 
                                   'changeMonth'=>true,
                                  'changeYear'=>true,
                                 'yearRange'=>'2014:'.date('Y'),
                               ],
                          
                            //'dateFormat' => h::getFormatShowDate(),
                            'options'=>['class'=>'form-control',
                               'disabled'=>(!$aprobado)?false:true  
                                ]
                            ]) ?>
 </div>
 <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
      <?= $form->field($model, 'fvencimiento')->widget(DatePicker::class, [
                            'language' => h::app()->language,
                           'pluginOptions'=>[
                                     'format' => h::gsetting('timeUser', 'date')  , 
                                   'changeMonth'=>true,
                                  'changeYear'=>true,
                                 'yearRange'=>'2014:'.date('Y'),
                               ],
                          
                            //'dateFormat' => h::getFormatShowDate(),
                            'options'=>['class'=>'form-control',
                                 'disabled'=>(!$aprobado)?false:true]
                            ]) ?>
 </div>

  <?php echo Html::a('reporte', Url::to(['/report/make/multi-report','id'=>2,'idsToReport'=> \yii\helpers\Json::encode($model->idsToFacturacion())]), ['target'=>'_blank']); ?>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'detalles')->textarea(['rows' => 6]) ?>

 </div>
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'detalleinterno')->textarea(['rows' => 6]) ?>

 </div>
     
    <?php ActiveForm::end(); ?>
          
       <?php if(!$model->isNewRecord) {?>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <?php Pjax::begin(['id'=>'grilla_cargospor']);
      
      $gridColumns=[
         [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}{attach}{generate}',
                'buttons' => [
                     'update' => function ($url, $model) use($aprobado) {  
                       $url= Url::to(['/sigi/cuentaspor/edita-cobranza','id'=>$model->id,'gridName'=>'grilla_cargospor','idModal'=>'buscarvalor']);
                         $options = [
                           'class'=>'botonAbre',
                            //'title' => Yii::t('sta.labels', 'Editar'),
                            //'aria-label' => Yii::t('rbac-admin', 'Activate'),
                            //'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                            //'data-method' => 'get',
                            'data-pjax' => '0',
                             //'target'=>'_blank'
                        ];
                        //return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['href' => $url, 'title' => 'Editar Adjunto', 'class' => ' btn btn-sm btn-success']);
                        if(!$model->colector->isBudget() )
                         return Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>',$url,$options);
                     
                        
                        },
            'attach' => function($url, $model) use($aprobado) {  
                         $url=\yii\helpers\Url::toRoute(['/finder/selectimage',
                             'isImage'=>false,
                             'idModal'=>'imagemodal',
                             'modelid'=>$model->id,
                             'extension'=> \yii\helpers\Json::encode(['png','jpg','jpeg','doc','docx','docxx','pdf']),
                             'nombreclase'=> str_replace('\\','_',get_class($model))]);
                        $options = [
                            'title' => Yii::t('sta.labels', 'Subir Archivo'),
                            //'aria-label' => Yii::t('rbac-admin', 'Activate'),
                            //'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                            'data-method' => 'get',
                            //'data-pjax' => '0',
                        ];
                        if(!$model->colector->isBudget() && !$aprobado)
                        return Html::button('<span class="glyphicon glyphicon-paperclip"></span>', ['href' => $url, 'title' => 'Adjunto', 'class' => 'botonAbre btn btn-success']);
                        //return Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', Url::toRoute(['view-profile','iduser'=>$model->id]), []/*$options*/);
                     
               },   
                                
                                
                                
                          'view' => function($url, $model) use($aprobado) {                        
                        $options = [
                            'title' => Yii::t('base.verbs', 'View'),                            
                        ];
                        return Html::a('<span class="btn btn-warning btn-sm glyphicon glyphicon-search"></span>', $url, $options/*$options*/);
                         },
                                              
                        
                        'delete' => function ($url,$model)use($aprobado) {
                             $options = [
                            'data-confirm' => Yii::t('sigi.labels', 'Esta seguro de eliminar este ítem?'),
                            'title' => Yii::t('base.verbs', 'Borrar'),                            
                        ];
			   $url = \yii\helpers\Url::toRoute($this->context->id.'/deletemodel-for-ajax');
                            if(!$model->colector->isBudget() && !$aprobado )  
                           return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['title'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                            },
                            
                           /* 'generate' => function ($url,$model) {
                             $options = [
                            'data-confirm' => Yii::t('sigi.labels', 'Esta seguro de generar lecturas?'),
                            'title' => Yii::t('base.verbs', 'Generar'),                            
                        ];
			   $url = \yii\helpers\Url::toRoute([$this->context->id.'/crear-lecturas','id'=>$model->id]);
                            $colector=$model->colector;
                           if(!$colector->isBudget() && $colector->isMedidor() && $colector->isMassive())  
                              return \yii\helpers\Html::a('<span class="btn btn-success glyphicon glyphicon-th-list"></span>', '#', ['title'=>$url,'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))])]);
                            },*/
                       'generate' => function($url, $model) {  
                       $url= Url::to(['/sigi/cuentaspor/crea-lecturas','id'=>$model->id,'gridName'=>'grilla_cargospor','idModal'=>'buscarvalor']);
                         $options = [
                           'class'=>'botonAbre',
                            //'title' => Yii::t('sta.labels', 'Editar'),
                            //'aria-label' => Yii::t('rbac-admin', 'Activate'),
                            //'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                            //'data-method' => 'get',
                            'data-pjax' => '0',
                             //'target'=>'_blank'
                        ];
                         $colector=$model->colector;
                        //return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['href' => $url, 'title' => 'Editar Adjunto', 'class' => ' btn btn-sm btn-success']);
                        if(!$colector->isBudget() && $colector->isMedidor() && $colector->isMassive() )  
                         return Html::a('<span class="btn btn-success glyphicon glyphicon-th-list"></span>',$url,$options);
                     
                        
                        },    
                            
                         
                    ]
                ],
          /* ['class' => 'frontend\modules\report\components\columnGridReport',
                   'attribute'=>'report_id'],*/
           // 'id',
              /*['attribute'=>'edificio_id',
                  'filter'=> frontend\modules\sigi\helpers\comboHelper::getCboEdificios(),
                  'value'=>'edificio.codigo'
                  ],*/
           /* ['attribute'=>'codocu',
                  'filter'=> frontend\modules\sigi\helpers\comboHelper::getCboDocuments(),
                  'value'=>'documento.desdocu'
                  ],*/
                            
           /*  ['attribute'=>'colector_id',
                  //'filter'=> frontend\modules\sigi\helpers\comboHelper::getCboColectores($model->edificio_id),
                  'value'=>'colector.cargo.descargo'
                  ],  */             
            'colector.cargo.descargo',
            'descripcion',
           // 'colector.id',
          
           // 'fedoc',
                            
            //'mes',
            //'anio',
            //'detalle:ntext',
            //'fevenc',
            ['attribute'=>'monto',
                            'format' => ['decimal', 2],
                            'pageSummary' => true,
                            ]    ,
            //'igv',
            //'codestado',

          
        ];
      
      ?>
    <?=ExportMenu::widget([
    'dataProvider' => $dataProviderCuentasPor,
    'filename'=>yii::t('sigi.labels','Detalles de facturación'),
    'columns' => $gridColumns,
    'dropdownOptions' => [
        'label' => yii::t('sta.labels','Exportar'),
        'class' => 'btn btn-success'
    ]
]) . "<br><hr>\n".GridView::widget([
        'dataProvider' =>$dataProviderCuentasPor,
         'summary' => '',
         'showPageSummary' => true,
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        //'filterModel' => $searchModel,
        'columns' => $gridColumns,
    ]); ?>
          
       <?php 
   echo linkAjaxGridWidget::widget([
           'id'=>'widgetgruidBancos',
            'idGrilla'=>'grilla_cargospor',
            'family'=>'holas',
          'type'=>'POST',
           'evento'=>'click',
           'posicion'=> \yii\web\View::POS_END,
            //'foreignskeys'=>[1,2,3],
        ]); 
   ?> 
        
          
    <?php Pjax::end(); ?>
      
     
<?php
 $url= Url::to(['/sigi/cuentaspor/create-as-child','id'=>$model->id,'gridName'=>'grilla_cargospor','idModal'=>'buscarvalor']);
 if(!$aprobado)  
 echo  Html::button(yii::t('base.verbs','Agregar concepto masivo'), ['href' => $url, 'title' => yii::t('sta.labels','Agregar Elemento'),'id'=>'btn_apoderado', 'class' => 'botonAbre btn btn-success']); 
?> 
<?php
 $url= Url::to(['/sigi/cuentaspor/create-as-child-interno','id'=>$model->id,'gridName'=>'grilla_cargospor','idModal'=>'buscarvalor']);
  if(!$aprobado)  
 echo  Html::button(yii::t('base.verbs','Agregar concepto individual'), ['href' => $url, 'title' => yii::t('sta.labels','Agregar Elemento'),'id'=>'btn_apoderado', 'class' => 'botonAbre btn btn-success']); 
?> 
<?php
 $urlx= Url::to(['/sigi/facturacion/recupera-docs','id'=>$model->id,'gridName'=>'grilla_cargospor']);
  if(!$aprobado)  
 echo  Html::button(yii::t('base.verbs','Insertar documentos'), ['href' => $url, 'title' => yii::t('sta.labels','Agregar Elemento'),'id'=>'btn_docusx', 'class' => 'btn btn-success']); 
?> 

 <?php 
  $string="$('#boton_facturacion').on( 'click', function(){      
       $.ajax({
              url: '".Url::to(['/sigi/facturacion/facturacion-mes','id'=>$model->id])."', 
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
  $string="$('#btn_docusx').on( 'click', function(){      
       $.ajax({
              url: '".$urlx."', 
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
                            $.pjax.reload({container: '#grilla_cargospor', async: false});
                        }
                        });


             })";
  
  $this->registerJs($string, \yii\web\View::POS_END);
?>
 <?php 
  $string="$('#boton_resetear').on( 'click', function(){      
       $.ajax({
              url: '".Url::to(['/sigi/facturacion/reset-facturacion-mes','id'=>$model->id])."', 
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
      
    
   
      
</div>   
          
       <?php }else{?>  
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
       }?>    

</div>
    </div>