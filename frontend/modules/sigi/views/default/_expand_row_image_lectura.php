<?php
if($model->hasAttachments()){
  if(\common\helpers\FileHelper::isImage($model->files[0]->path)){
      echo yii\helpers\Html::img($model->files[0]->urlTempWeb,['width'=>300,'height'=>300]);
  }else{
      echo "El registro no tiene imágenes adjuntss";
  }
}else{
    echo "El registro no tiene adjuntos";
}

?>

