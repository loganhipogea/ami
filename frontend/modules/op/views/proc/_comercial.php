<?php 
use yii\widgets\ActiveForm;

?>
<div class="box-body">
<div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'numoc')->textInput(['maxlength' => true]) ?>

 </div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
      <?PHP
     echo $form->field($model, 'textocomercial')
             ->widget(\dosamigos\ckeditor\CKEditor::className(), [
        'options' => ['rows' => 2],
         'clientOptions'=>['language'=>'es',
             ],
        ]);
      ?>
  </div>
     
 </div>
