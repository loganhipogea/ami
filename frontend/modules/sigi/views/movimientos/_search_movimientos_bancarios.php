<?php
use yii\helpers\Url;
use yii\helpers\Html;
use common\helpers\h;
use frontend\modules\sigi\helpers\comboHelper;
 use kartik\date\DatePicker;
use yii\widgets\ActiveForm;
use frontend\modules\sigi\models\SigiSuministros;
//use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
?>

  

    <?php $form = ActiveForm::begin([
       
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>
   <div class="form-group">
        <?= Html::submitButton("<span class='fa fa-search'></span>     ".Yii::t('sta.labels', 'buscar'), ['class' => 'btn btn-primary']) ?>
        <?php  
                $url= Url::to(['/sigi/movimientos/nuev-mov-banco','gridName'=>'grilla_m','idModal'=>'buscarvalor']);
                         $options = [
                           'class'=>'botonAbre btn btn-success',
                            'data-pjax' => '0',
                        ];
                        echo Html::a('<span class="fa fa-cut"></span>'.'Agregar movimiento',$url,$options);
                     
             ?>   
    </div>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <?php 
      
        echo $form->field($model, 'fopera')->widget(
        DatePicker::classname(), [
         'name' => 'fopera',
            'language' => h::app()->language,
            'options' => ['placeholder' =>yii::t('sta.labels', '--Seleccione un valor--')],
    //'convertFormat' => true,
                'pluginOptions' => [
                'format' => h::getFormatShowDate(),
                //'startDate' => '01-Mar-2014 12:00 AM',
                'todayHighlight' => true
                                ]
                    ]);
                ?>
  </div> 
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <?php 
        echo $form->field($model, 'fopera1')->widget(
        DatePicker::classname(), [
         'name' => 'fopera1',
            'options' => ['placeholder' =>yii::t('sta.labels', '--Seleccione un valor--')],
    //'convertFormat' => true,
                'pluginOptions' => [
                'format' => h::getFormatShowDate(),
                //'startDate' => '01-Mar-2014 12:00 AM',
                'todayHighlight' => true
                                ]
                    ]);
                ?>
  </div> 
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> 
 
    </div>


   <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">  
  
     <?php echo $form->field($model, 'edificio_id')->
            dropDownList(comboHelper::getCboEdificios(),
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        'disabled'=>(!$aprobado)?false:true,
                      ]
                    ) ?>

  
    </div> 
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">


 </div>  





   

<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?= 
            $form->field($model, 'descripcion')->textInput()
           ?>
     <?php //echo cboperiodos::widget(['model'=>$model,'attribute'=>'codperiodo', 'form'=>$form]) ?>
  </div> 
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?= 
            $form->field($model, 'monto')->textInput()
           ?>
     <?php //echo cboperiodos::widget(['model'=>$model,'attribute'=>'codperiodo', 'form'=>$form]) ?>
  </div> 
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?= 
            $form->field($model, 'monto_conciliado')->textInput()
           ?>
     <?php //echo cboperiodos::widget(['model'=>$model,'attribute'=>'codperiodo', 'form'=>$form]) ?>
  </div> 
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?= 
            $form->field($model, 'diferencia')->textInput()
           ?>
     <?php //echo cboperiodos::widget(['model'=>$model,'attribute'=>'codperiodo', 'form'=>$form]) ?>
  </div> 
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?= 
            $form->field($model, 'diferencia')->textInput()
           ?>
     <?php //echo cboperiodos::widget(['model'=>$model,'attribute'=>'codperiodo', 'form'=>$form]) ?>
  </div> 



    <?php ActiveForm::end(); ?>


