<?php
  use yii\helpers\Url;

 use yii\widgets\Pjax;
 use yii\helpers\Html;
use yii\grid\GridView;
      $url= Url::to(['mod-agrega-os','id'=>$model->id,'gridName'=>'grilla-os','idModal'=>'buscarvalor']);
   echo  Html::button(yii::t('base.verbs','Agregar orden'), 
           ['href' => $url, 'title' => yii::t('sta.labels','Agregar Os'),
               'id'=>'btn_cuentas_edi',
               'class' => 'botonAbre btn btn-success'
               ]); 
  
 
?>     

<div class="box-body">
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
    <div style='overflow:auto;'>
    <?= GridView::widget([
        'id'=>'grilla-os',
        'dataProvider' => $dataProviderOs,
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'filterModel' => New \frontend\modules\op\models\OpOsSearch(),
        'columns' => [
            
         
        
         ['attribute' => 'numero',
                'format'=>'raw',
                'value'=>function($model){
                        return Html::a($model->numero, Url::to(['edita-os','id'=>$model->id]),['target'=>'_blank']);                        
                             } 
                
                ],
         
             ['attribute' => 'Proveedor',
                'format'=>'raw',
                'value'=>function($model){
                        return $model->cliente->despro;                        
                             } 
                
                ], 
         

           
            
            'fechaprog',
            'fechaini',
            'descripcion',
            
            //'codpro',
            //'descripcion',
            //'tipo',
            //'codestado',
            //'textocomercial:ntext',
            //'textointerno:ntext',
            //'textotecnico:ntext',

          
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
    </div>
