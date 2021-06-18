<?php use yii\widgets\ActiveForm;
ECHO \common\widgets\spinnerWidget\spinnerWidget::widget();
use yii\helpers\Html;
?>


    <?php $form = ActiveForm::begin(['id' => 'registration-form',
        'enableAjaxValidation'=>true
        ]); ?>
 <?= \nemmo\attachments\components\AttachmentsInput::widget([
	'id' => 'file-input', // Optional
	'model' => $model,         
	'options' => [ // Options of the Kartik's FileInput widget
                //'language'=>'es-PE', 
		'multiple' => false, // If you want to allow multiple upload, default to false
	//'overwriteInitial'=>false,
            ],
	'pluginOptions' => [ // Plugin options of the Kartik's FileInput widget 
            
    'allowedFileExtensions'=>$allowedExtensions,
    'maxImageWidth'=>10000,
    'maxImageHeight'=>10600,
    'resizePreference'=>'height',
    'maxFileCount'=>1,
    'resizeImage'=>true,
    'resizeIfSizeMoreThan'=>100,
            'previewFileType' => 'any',
		'maxFileCount' => 1 ,// Client max files
           'overwriteInitial'=>false,
             //'maxFileSize'=>800,
            'resizeImages'=>true,
	]
]) ?> 

<div class="form-group">
        
        <?= Html::submitButton('<span class="glyphicon glyphicon-paperclip"></span>'.'   '.Yii::t('report.messages', 'Adjuntar'), ['class' => 'btn btn-success','data-pjax'=>true]) ?>
    </div>
 <?php ActiveForm::end(); ?>