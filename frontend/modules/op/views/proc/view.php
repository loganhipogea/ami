<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\op\models\OpProcesos */

$this->title = $model->numero;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Procesos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="op-procesos-view">

    <h4><?= Html::encode($this->title).'  -  '.Html::encode($model->descripcion) ?></h4>
 <div class="box box-success">
    <?php echo $this->render('_form_view',['model'=>$model]);  ?>
  </div> 

</div>
