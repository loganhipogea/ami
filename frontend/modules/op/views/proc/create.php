<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model frontend\modules\op\models\OpProcesos */

$this->title = Yii::t('app', 'Create Op Procesos');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Op Procesos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="op-procesos-create">

    <h4><?= Html::encode($this->title) ?></h4>
<div class="box box-success">
   <?php $form = ActiveForm::begin([
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
    <?= $this->render('_form', [
        'model' => $model,
          'form' => $form,
    ]) ?>
<?php ActiveForm::end(); ?>
</div>
</div>