<?php
use yii\helpers\Html;
use kartik\tabs\TabsX;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\Talleres */
ECHO \common\widgets\spinnerWidget\spinnerWidget::widget();
/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\Edificios */

$this->title = Yii::t('sigi.labels', 'Residente', []);
/*$this->params['breadcrumbs'][] = ['label' => Yii::t('sigi.labels', 'Edificios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('sigi.labels', 'Update');*/
?>


    
   <h4><i class="fa fa-edit"></i><?= Html::encode($this->title) ?></h4
   <div class="box box-success">
    <?php 
    $items=[];
    foreach($propietarios as $propietario){
        $unidad=$propietario->unidad;       
           $medidor=$unidad->firstMedidor(\frontend\modules\sigi\models\SigiSuministros::COD_TYPE_SUMINISTRO_DEFAULT);
           
        $items[]=[
            'label'=>'<i class="fa fa-cubes"></i> '.$unidad->numero, //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('panel_residente',['unidad' => $unidad,'medidor'=>$medidor]),
            //'active' => true,
             'options' => ['id' => uniqid()],
            ];
    }
    echo TabsX::widget([
    'position' => TabsX::POS_ABOVE,
     'bordered'=>true,
    'align' => TabsX::ALIGN_LEFT,
      'encodeLabels'=>false,
    'items' => $items,
]);  ?>

</div>
