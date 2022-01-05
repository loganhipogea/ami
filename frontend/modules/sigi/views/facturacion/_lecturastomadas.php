<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use frontend\modules\sigi\helpers\comboHelper;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\sigi\models\SigiBasePresupuestoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('sigi.labels', 'Partidas');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="sigi-base-presupuesto-index">
    
         
        
     <div class="box-body">
       <?php
  $consumos=$model->arrayConsumos();
  $denominador=($consumos['AACC']['CONSUMO']+$consumos['IMPUTADOS']['CONSUMO']);
  if($denominador>0){
      $costom3= round(($consumos['AACC']['MONTO']+$consumos['IMPUTADOS']['MONTO'])/
         $denominador ,4);
  }else{
    $costom3=0;  
  }
  
  ?>

   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
           <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr >
                      <th colspan="2"><p class="text-green"><span class="fa fa-chart-line"></span>
                             Costo unitario  <?=$costom3?>(S/./m3) </p></th> 
                    
                  </tr>
                  <tr>
                     <th>Area</th> 
                     <th>Consumo(M3)</th> 
                     <th>Monto</th> 
                  </tr>
                  </thead>
                  <tbody>
                      
                                
              
                 <tr>
                     <td>AREAS COMUNES</td> 
                   <td><?=$consumos['AACC']['CONSUMO']?> </td>
                    <td>
                      <div class="sparkbar" data-color="#00a65a" data-height="20"><?=$consumos['AACC']['MONTO']?></div>
                    </td>
                 </tr> 
                  <tr>
                     <td>UNIDADES </td> 
                   <td><?=$consumos['IMPUTADOS']['CONSUMO']?> </td>
                    <td>
                      <div class="sparkbar" data-color="#00a65a" data-height="20"><?=$consumos['IMPUTADOS']['MONTO']?></div>
                    </td>
                 </tr> 
                  <tr>
                     <td>TOTAL EDIFICIO </td> 
                   <td><?=$consumos['IMPUTADOS']['CONSUMO']+$consumos['AACC']['CONSUMO']?> </td>
                    <td>
                      <div class="sparkbar" data-color="#00a65a" data-height="20"><?=$consumos['IMPUTADOS']['MONTO']+$consumos['AACC']['MONTO']?></div>
                    </td>
                 </tr>     
               
                  
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
    </div>   
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">      
         
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
    <div style='overflow:auto;'>
    <?= GridView::widget([
        'dataProvider' => $dataProviderLecturas,
         'summary' => '',
        'pjax' => true,
    'striped' => true,
    'hover' => true,
       'showPageSummary' => true,
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'filterModel' => $searchModelLecturas,
        'columns' => [
          ['attribute'=>'nombre',],
           ['attribute'=>'codsuministro',], 
             //['attribute'=>'numerocliente',],  
['attribute'=>'codum',], 
             ['attribute'=>'numero',], 
            ['attribute'=>'lecturaant',],
             ['attribute'=>'lectura',
                'format'=>'html',
                 'value'=>function($model) {                        
                        
                        $url=Url::to(['/sigi/edificios/lecturas','id'=>$model->suministro_id]);
                        return Html::a($model->lectura, $url,['target'=>'_blank']);
                         },
                 ],
             ['attribute'=>'delta',],
            ['attribute'=>'flectura',],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
 </div>  
  
   </div>
     </div>