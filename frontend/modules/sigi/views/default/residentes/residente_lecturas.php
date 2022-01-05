<?php
use yii\helpers\Html;
use kartik\tabs\TabsX;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\Talleres */
ECHO \common\widgets\spinnerWidget\spinnerWidget::widget();
/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\Edificios */

$this->title = Yii::t('sigi.labels', 'Facturación', []);
/*$this->params['breadcrumbs'][] = ['label' => Yii::t('sigi.labels', 'Edificios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('sigi.labels', 'Update');*/
?>


    <div class="box box-success"> 
     <?php 
     //echo $useredificio->unidad->numero; die();
     echo $this->render('header',['useredificio'=>$useredificio]);  ?>

        <br>.<BR>
        <h4><span class="fa fa-tint"></span>           Consumo de agua potable</h4>
   
    <?php 
    $items=[];

        $unidad=$useredificio->unidad; 
        if(empty($unidad->parent_id)){
           $medidor=$unidad->firstMedidor(\frontend\modules\sigi\models\SigiSuministros::COD_TYPE_SUMINISTRO_DEFAULT);
           
        $items[]=[
            'label'=>'<i class="fa fa-cubes"></i> '.$unidad->numero, //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render(
                    'residente_tab_lecturas',
                    [
                            //'searchModel' =>$searchModel,
                            //'dataProvider'=> $dataProvider,
                            'unidad' => $unidad,
                        'medidor'=>$medidor,
                        'params'=>$params
                    ]),
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
