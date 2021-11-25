<?php
use yii\helpers\Html;
use kartik\tabs\TabsX;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\Talleres */
ECHO \common\widgets\spinnerWidget\spinnerWidget::widget();
/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\Edificios */

$this->title = Yii::t('sigi.labels', 'Editar Edificio: {name}', [
    'name' => $model->nombre,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('sigi.labels', 'Edificios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('sigi.labels', 'Update');
?>


    
   <h4><i class="fa fa-edit"></i><?= Html::encode($this->title) ?></h4>
   <div class="box box-success">
    <?php echo TabsX::widget([
    'position' => TabsX::POS_ABOVE,
     'bordered'=>true,
    'align' => TabsX::ALIGN_LEFT,
      'encodeLabels'=>false,
    'items' => [
        [
          'label'=>'<i class="fa fa-hospital"></i> '.yii::t('sta.labels','Edificio'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_form',['model' => $model]),
            'active' => true,
             'options' => ['id' => 'myveryownID3'],
        ],
        [
          'label'=>'<i class="fa fa-cubes"></i> '.yii::t('sta.labels','Unidades'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_unidades',['dataProvider'=>$dataProvider,'searchModel'=>$searchModel, 'model' => $model ]),
            'active' => false,
             'options' => ['id' => 'myveryownID4'],
        ],
        [
          'label'=>'<i class="fa fa-users"></i> '.yii::t('sta.labels','Gr Gestión'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_apoderados',[ 'model' => $model]),
            'active' => false,
             'options' => ['id' => 'dwnID4'],
        ],
       [
          'label'=>'<i class="fa fa-users"></i> '.yii::t('sta.labels','Docs'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_docus',[ 'model' => $model]),
            'active' => false,
             'options' => ['id' => 'cnID4'],
        ],
        [
          'label'=>'<i class="fa fa-users"></i> '.yii::t('sta.labels','Cuentas'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_cuentas',[ 'model' => $model]),
            'active' => false,
             'options' => ['id' => 'cnID6'],
        ],
       [
          'label'=>'<i class="fa fa-users"></i> '.yii::t('sta.labels','Cargos'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_grupocargos',[ 'model' => $model]),
            'active' => false,
             'options' => ['id' => 'cnID7'],
        ],
         [
          'label'=>'<i class="fa fa-users"></i> '.yii::t('sta.labels','Beneficios'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_grupobeneficios',[ 'model' => $model]),
            'active' => false,
             'options' => ['id' => 'cnID7vtgr75'],
        ],
        [
          'label'=>'<i class="fa fa-users"></i> '.yii::t('sta.labels','Usuarios'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_usuarios',[ 'model' => $model]),
            'active' => false,
             'options' => ['id' => 'cnID7x45'],
        ],
    ],
]);  ?>

</div>
