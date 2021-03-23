<?php
use kartik\export\ExportMenu;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use frontend\modules\sigi\helpers\comboHelper;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
use frontend\modules\sigi\models\SigiSuministrosSearch;
  use common\widgets\spinnerWidget\spinnerWidget;
    ECHO spinnerWidget::widget();
?>
<div class="edificios-index_docus">
<h4><?= Html::encode($this->title) ?></h4>
    <div class="box box-success">
     <div class="box-body">
     
   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">  
 <?php Pjax::begin(['id'=>'grilla-medidores','timeout'=>false]); ?>

 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">          
<?php
echo $this->render('_searchSuministros',['model'=>$searchModel]);
 ?>        
     <div>  
     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">  
   <?php 
    $gridColumns=[
                 [
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{edit}{delete}{view}',
               'buttons' => [
                     'edit' => function($url, $model) {  
                         $url=\yii\helpers\Url::toRoute(['/sigi/unidades/edita-medidor','id'=>$model->id,'isImage'=>false,'idModal'=>'buscarvalor','gridName'=>'grilla-medidores','nombreclase'=> str_replace('\\','_',get_class($model))]);
                        $options = [
                            'title' => Yii::t('sta.labels', 'Editar'),
                            //'aria-label' => Yii::t('rbac-admin', 'Activate'),
                            //'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                            'data-method' => 'get',
                            'data-pjax' => '0',
                        ];
                        return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['href' => $url, 'title' => 'Editar ', 'class' => 'botonAbre btn btn-success']);
                        //return Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', Url::toRoute(['view-profile','iduser'=>$model->id]), []/*$options*/);
                     
                        
                        },
                        'delete' => function ($url,$model) {
			   $url = \yii\helpers\Url::toRoute($this->context->id.'/deletemodel-for-ajax');
                              return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['title'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                            },
                        'view' => function($url, $model) {  
                           $url = \yii\helpers\Url::toRoute([$this->context->id.'/lecturas','id'=>$model->id]);       
                        $options = [
                            'data-pjax' => '0',
                            'target'=>'_blank',
                            'title' => Yii::t('base.verbs', 'Lecturas'),                            
                        ];
                        return Html::a('<span class="btn btn-warning btn-sm glyphicon glyphicon-time"></span>', $url, $options/*$options*/);
                         }, 
                    ]
                ],
                                 'codsuministro',    
               ['attribute'=>'edificio_id',
                    'filter'=>comboHelper::getCboEdificios(),
                   'value'=> function ($model) {
			   //$url = \yii\helpers\Url::toRoute($this->context->id.'/deletemodel-for-ajax');
                             return $model->edificio->nombre;
                            }
                   ],
           ['attribute'=>'Unidad',
                    'filter'=>comboHelper::getCboEdificios(),
                   'value'=> function ($model) {
			   //$url = \yii\helpers\Url::toRoute($this->context->id.'/deletemodel-for-ajax');
                             return $model->unidad->numero;
                            }
                   ],
           ['attribute'=>'tipo',
                    'filter'=>$searchModel::comboDataField('tipo'),
                   'value'=> function ($model) {
			   //$url = \yii\helpers\Url::toRoute($this->context->id.'/deletemodel-for-ajax');
                             return $model->comboValueField('tipo');
                            }
                   ],
                  'id',
            'numerocliente',
                        
            'clipro.despro',
            
               [
    'attribute' => 'ultimalectura',
    'format' => 'raw',
    'value' => function ($model) {
        return $model->ultimaLectura();
             },

          ],
        ];
   
   
   ?>
      <div style='overflow:auto;'>      
 <?php echo ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
    'dropdownOptions' => [
        'label' => yii::t('sta.labels','Exportar'),
        'class' => 'btn btn-success'
    ]
]) . "<hr>\n".GridView::widget([
        'id'=>'grilla-grid-frtrymedidores',
        'dataProvider' =>$dataProvider,
        // 'summary' => '',
        //'filterModel' => $searchModel,
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'columns' =>$gridColumns,
    ]); ?>
         <?php 
   echo linkAjaxGridWidget::widget([
           'id'=>'widgetgruidBancos',
            'idGrilla'=>'grilla-medidores',
            'family'=>'holas',
          'type'=>'POST',
           'evento'=>'click',
            'posicion'=> \yii\web\View::POS_END,
        ]); 
   ?>
         
    <?php Pjax::end(); ?>
   </div>
</div>
    </div>
      </div>
      </div>
    </div>
            </div>
    </div>