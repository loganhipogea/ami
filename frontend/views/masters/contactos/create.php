<?php

use yii\helpers\Html;


?>
<div class="contactos-create">
<div class="box-success">
    <h4><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,'id'=>$id,
       //'vendorsForCombo'=>$vendorsForCombo,
       //'aditionalParams'=>$aditionalParams
    ]) ?>

</div>
    
    </div>
