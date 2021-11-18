<?php
 //use kartik\date\DatePicker;
 //use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\helpers\h;
use yii\widgets\ActiveForm;
use frontend\modules\sigi\helpers\comboHelper;
use common\widgets\selectwidget\selectWidget;
use common\widgets\auditwidget\auditWidget;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\SigiCuentaspor */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $this->title = Yii::t('sigi.labels', 'Detalle cuenta: {numero}-{nombre}', [
    'numero' => $model->numero,
    'nombre' => $model->nombre,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('sigi.labels', 'Cuentas'), 'url' => ['cuentas-bancarias']];

?>

<h4><i class="fa fa-edit"></i><?= Html::encode($this->title) ?></h4>
 
<div class="box box-succes">
   
    <?php $form = ActiveForm::begin([
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
              <?php  
                $url= Url::to(['/sigi/movimientos/update-saldo','id'=>$model->id,'gridName'=>'grilla_billete','idModal'=>'buscarvalor']);
                         $options = [
                           'class'=>'botonAbre',
                            'data-pjax' => '0',
                        ];
                        echo Html::a('<span class="btn btn-success fa fa-cut"></span>',$url,$options);
                     
             ?> 
               <?php  
             echo auditWidget::widget(['model'=>$model]);
               ?>  
            </div>
        </div>
    </div>
      <div class="box-body">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?= $form->field($model, 'nombre')->textInput(['value'=>$model->edificio->nombre,'disabled' => true])->label('Edificio')?>

     </div> 
   <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
     <?= $form->field($model, 'nombre')->textInput(['value'=>$model->banco->nombre,'disabled' => true])->label('Banco')?>
   </div> 
     
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
                <h3>Saldo </h3>
              <h3>
                  <?php Pjax::begin(['id'=>'grilla_billete','timeout'=>false]);  ?>     
                       <?=$model->moneda->simbolo.'  '.Yii::$app->formatter->asDecimal($model->saldo,3)?>
                   <?php Pjax::end();  ?> 
              </h3>

            </div>
            <div class="icon">
                <span style="color:black;opacity:0.3;"><i class="fa fa-money"></i></span>
            </div>
            
          </div>
  </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
     <?= $form->field($model, 'nombre')->textInput(['value'=>$model->clipro->despro,'disabled' => true])->label('Titular')?>
   </div>     
 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
     <?= $form->field($model, 'numero')->textInput(['disabled' => true])?>
   </div> 
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
     <?= $form->field($model, 'cci')->textInput(['disabled' => true])?>
   </div>  
    <?php ActiveForm::end(); ?>

          
   
          
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">


  
  <?='.'?>
    
    <?php Pjax::begin(); ?>
   
    <div style='overflow:auto;'>
    <?= GridView::widget([
        'dataProvider' => new \yii\data\ActiveDataProvider(
                [
                    'query'=>$model->getSigiMovBancos(),
                ]),
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
       // 'filterModel' => $searchModel,
        'columns' => [  
            'id',
            'fopera',
            'descripcion',
            'noper',
           [
                'attribute'=>'monto',
                'contentOptions'=>['style'=>'text-align:right;'],
                //'filter'=>frontend\modules\sigi\helpers\comboHelper::getCboEdificios(),
                'value' => function($model) { 
                        //var_dump($model);die();
                        return h::formato()->asDecimal($model->monto,2) ;
                         },
                   
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
    </div>
</div>
 </div> 
          
          
          
          
          
          
          
          
          
          
          
          
          
          


