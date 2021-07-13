<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

use kartik\tabs\TabsX;
 //use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
//use kartik\editable\Editable;
//use kartik\grid\GridView ;
use frontend\modules\sta\helpers\comboHelper;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\Edificios */
/* @var $form yii\widgets\ActiveForm */
?>
<h4><?=yii::t('sigi.labels','Gestionar Suministro').' - '.$model->comboValueField('tipo')?></h4>
<div class="box box-success">
<div class="edificios-form">
    <br>
    <?php $form = ActiveForm::begin([
    //'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
                  <?php
                Pjax::begin(['id'=>'botonpajax']);
                 if($model->activo){
 $url= Url::to(['/sigi/unidades/agrega-lectura','id'=>$model->id,'gridName'=>'botonpajax','idModal'=>'buscarvalor']);
   echo  Html::button(yii::t('base.verbs','Agregar Lectura'), ['href' => $url, 'title' => yii::t('sta.labels','Agregar Lectura'),'id'=>'btn_contacts', 'class' => 'botonAbre btn btn-success']); 
                 } ?>
    <?php
        
      if($model->activo){
            $url= Url::to(['/sigi/unidades/replace-medidor','id'=>$model->id,'gridName'=>'botonpajax','idModal'=>'buscarvalor']);
            echo  Html::button(yii::t('base.verbs','Reemplazar este medidor'), ['href' => $url, 'title' => yii::t('sta.labels','Reemplazar'),'id'=>'btn_contacts', 'class' => 'botonAbre btn btn-warning']); 
                } 
            Pjax::end();
      ?>
            </div>
        </div>
    </div>
      <div class="box-body">
    
 
 <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"> 
      <?= $form->field($model, 'nombre')
                 ->label(yii::t('sigi.labels','Edificio'))
                 ->textInput(['value'=>$model->edificio->nombre,'disabled' => true]) ?>
 </div> 
 <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"> 
      <?= $form->field($model, 'nombre')
                 ->label(yii::t('sigi.labels','Unidad'))
                 ->textInput(['value'=>$model->unidad->nombre,'disabled' => true]) ?>
 </div>
  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
     <?= $form->field($model, 'tipo')->textInput(['value'=>$model->comboValueField('tipo'),'disabled' => true]) ?>

 </div>
<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
     <?= $form->field($model, 'codpro')->textInput(['value'=>$model->clipro->despro,'disabled' => true]) ?>

 </div>
  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
     <?= $form->field($model, 'numerocliente')->textInput(['maxlength' => true,'disabled' => true]) ?>
 </div> 
<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
     <?= $form->field($model, 'codsuministro')->textInput(['maxlength' => true,'disabled' => true]) ?>
 </div>  
  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
     <?= $form->field($model, 'codum')->textInput(['maxlength' => true,'disabled' => true]) ?>
 </div>        
          
  
          
     
    <?php ActiveForm::end(); ?>
          
  
<?php Pjax::begin(['id'=>'grilla-lecturas']);?>
</div>
    </div>
   <?php echo TabsX::widget([
    'position' => TabsX::POS_ABOVE,
     'bordered'=>true,
    'align' => TabsX::ALIGN_LEFT,
      'encodeLabels'=>false,
    'items' => [
        [
          'label'=>'<i class="fa fa-home"></i> '.yii::t('sta.labels','Lecturas'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_lecturas',['model' => $model,'dataProvider'=>$dataProvider]),
            'active' => true,
             'options' => ['id' => 'myveryownID3'],
        ],
        [
          'label'=>'<i class="fa fa-cubes"></i> '.yii::t('sta.labels','Histograma'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_grafico',[ 'model' => $model]),
            'active' => false,
             'options' => ['id' => 'wnID4'],
        ],
       [
          'label'=>'<i class="fa fa-cubes"></i> '.yii::t('sta.labels','Reparto'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_afiliados',[ 'model' => $model]),
            'active' => false,
             'options' => ['id' => 'myvw456'],
        ],
       
    ],
]);  
?>
<?PHP
 Pjax::end();
?>
   
 



    