<?php
use yii\helpers\Html;
use common\helpers\h;
 use yii\helpers\Url;
 use yii\widgets\Pjax;
use yii\grid\GridView;
use frontend\modules\op\helpers\ComboHelper;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
?>
<div class="box-body">
    <br>
   
 
        
    <?php Pjax::begin(['id'=>'pjax-detmat','timeout'=>false]); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
    <div style='overflow:auto;'>
    <?= GridView::widget([
        'id'=>'grilla-materiales',
                'dataProvider' =>$dataProviderMateriales,
         'filterModel' => $searchModel,
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        //'filterModel' => New \frontend\modules\op\models\OpOsSearch(),
        'columns' => [
            
          [
                    
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{edit}{delete}{change}',
               'buttons' => [
                    'attach' => function($url, $model) {  
                         $url=\yii\helpers\Url::toRoute(['/finder/selectimage','isImage'=>false,'idModal'=>'imagemodal','modelid'=>$model->id,'nombreclase'=> str_replace('\\','_',get_class($model))]);
                        $options = [
                            'title' => Yii::t('sta.labels', 'Colocar en el maletín'),
                            //'aria-label' => Yii::t('rbac-admin', 'Activate'),
                            //'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                            'data-method' => 'get',
                            //'data-pjax' => '0',
                        ];
                        return Html::button('<span class="glyphicon glyphicon-paperclip"></span>', ['href' => $url, 'title' => 'Editar Adjunto', 'class' => 'botonAbre btn btn-success']);
                        //return Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', Url::toRoute(['view-profile','iduser'=>$model->id]), []/*$options*/);
                     
                        
                        },
                                
                                'edit' => function ($url,$model) {
			    $url= Url::to(['/op/proc/mod-edit-osdet','id'=>$model->id,'gridName'=>'pjax-detmat','idModal'=>'buscarvalor']);
                              return \yii\helpers\Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>'0','class'=>'botonAbre']);
                            },
                        'delete' => function ($url,$model) {
                              
                                $url = \yii\helpers\Url::to([$this->context->id.'/deletemodel-for-ajax','id'=>$model->id]);                              
                                    return \yii\helpers\Html::a('<span class="btn btn-primary glyphicon glyphicon-trash"></span>', '#', ['title'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                             
                              
			    },
                       
                        
                    ]
                ],
                            
                            ['attribute' => 'detos_id',
               'filter'=> ComboHelper::actividadesOs($model->id),
                'value'=>function($model){
                        return $model->detos_id;                        
                             } 
                
                ],
        
         ['attribute' => 'item',
                'format'=>'raw',
                'value'=>function($model){
                        return $model->item;                        
                             } 
                
                ],
         'cant',
            'codart',
            'um',
             ['attribute' => 'descridetalle',
                'format'=>'raw',
                'value'=>function($model){
                        return $model->descridetalle;                        
                             } 
                
                ],
                /*['attribute' => 'codtra',
                'format'=>'raw',
                'value'=>function($model){
                    
                        //return 'hola';
                        return (is_null($model->codtra))?'':$model->trabajador->fullName();                        
                             } 
                
                ],*/
                
          
        ],
    ]); ?>
    <?php
      $url= Url::to(['modal-agrega-det-req-libre','id'=>$model->id,'gridName'=>'pjax-detmat','idModal'=>'buscarvalor']);
   echo  Html::button(yii::t('base.verbs','Agregar operación'), 
           ['href' => $url, 'title' => yii::t('sta.labels','Agregar Op'),
               'id'=>'btn_cuentas_edi',
               'class' => 'botonAbre btn btn-primary'
               ]); 
    ?>
   
    
</div>
    
  </div>        
     
    
    <?php 
   echo linkAjaxGridWidget::widget([
           'id'=>'widgetgruidBancosss',
            'idGrilla'=>'pjax-detmat',
            'family'=>'pigmalion',
          'type'=>'POST',
           'evento'=>'click',
           //'refrescar'=>false,
        'posicion'=>\yii\web\View::POS_END
       
            //'foreignskeys'=>[1,2,3],
        ]); 
   ?>
    <?php Pjax::end(); ?>

</div>
    


