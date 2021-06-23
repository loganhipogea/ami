<div>
 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
    <?= \common\widgets\imagewidget\ImageWidget::widget([
        'name'=>'imagenrepx',
        'isImage'=>false,  
        'model'=>$model,
        'extensions'=>['pdf','doc','docx','png','jpg'],
            ]); ?>
   </div>    
    
<?=(!$model->isNewRecord)? \nemmo\attachments\components\AttachmentsTable::widget([
	'model' => $model,
	//'showDeleteButton' => false, // Optional. Default value is true
]):''?>
    
    
</div>