<?php
use kartik\tabs\TabsX;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\clasi\models\ClasiClasesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Clasi Clases');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clasi-clases-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <div class="box box-success">
     
    
    <?php echo TabsX::widget([
    'position' => TabsX::POS_ABOVE,
     'bordered'=>true,
    'align' => TabsX::ALIGN_LEFT,
      'encodeLabels'=>false,
    'items' => [
        [
          'label'=>'<i class="fa fa-home"></i> '.yii::t('sta.labels','Clases'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_clases',[
                'dataprovider' => $dataprovider,
                 'searchModel' => $searchModel,
                    ]),
            'active' => true,
             'options' => ['id' => 'myveryownID3'],
        ],
        [
          'label'=>'<i class="fa fa-users"></i> '.yii::t('sta.labels','Características'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_caracteristicas',[
                'dataproviderCarac' => $dataproviderCarac,
                'searchModelCarac' => $searchModelCarac,
                    ]),
            'active' => false,
             'options' => ['id' => 'myveryownID4'],
        ],
       
        
       
    ],
]);  ?>

 
         
         
         
         
         
         
         
         
         
         
         
         
         
         
         
         
   
       
    </div>
</div>
 
       