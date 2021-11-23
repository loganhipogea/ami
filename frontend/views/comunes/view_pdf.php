<?php   
use common\helpers\FileHelper;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?PHP 

$ext=FileHelper::extensionFile($urlFile);
//VAR_DUMP($ext,FileHelper::isImage($urlFile), FileHelper::extImages());
//die();
?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<?php if(FileHelper::isImage($urlFile)) { ?>
<div style="overflow:auto">
    <?php echo Html::img($urlFile); ?>
</div>
<?php  }elseif($ext=='pdf') {?>

<embed src="<?=$urlFile?>"  type="application/pdf" 
       width="<?=$width?>" height="<?=$height?>" 
 />
</div>
<?php  }else{ ?>
<?php echo Html::img(FileHelper::UrlEmptyFile()); ; ?>
<?php } ?>
