<?php


use yii\widgets\ActiveForm;
 use yii\grid\GridView;
   use yii\helpers\Html;
   use yii\helpers\Url;
   use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model frontend\modules\clasi\models\ClasiClases */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('app', 'Clasi Clases');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clasi-clases-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <div class="box box-success">
<div class="clasi-clases-form">
    <br>
    <?php $form = ActiveForm::begin([
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
                
        <?= Html::submitButton('<span class="fa fa-save"></span>   '.Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
            

            </div>
        </div>
    </div>
      <div class="box-body">
    
 <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'codigo')->textInput(['maxlength' => true]) ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'user_id')->textInput() ?>

 </div>
     
    <?php ActiveForm::end(); ?>

     
   <?php Pjax::begin(['id'=>'pjax-neote']); ?>
    <?= GridView::widget([
        'dataProvider' => New \yii\data\ActiveDataProvider([
                'query'=> frontend\modules\clasi\models\ClasiClaseCarac::find()-> 
                  select([
                      'codigo','clase_id','carac_id','tipovalor'
                  ])->andWhere(['clase_id'=>$model->codigo])
                ]),
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        //'filterModel' => $searchModelCarac,
        'columns' => [
            
         
         [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}{view}',
                'buttons' => [
                    'update' => function($url,$model) { 
                           $url=\yii\helpers\Url::to(['/clasi/clasi/mod-edita-cara','id'=>$model->codigo,'gridName'=>'pjax-neo','idModal'=>'buscarvalor']);
                        $options = [
                            'title' => Yii::t('base.verbs', 'Update'), 
                            'class'=>'botonAbre'
                        ];
                        return Html::a('<span class="btn btn-info btn-sm glyphicon glyphicon-pencil"></span>', $url, $options/*$options*/);
                         },
                          'view' => function($url, $model) {                        
                        $options = [
                            'title' => Yii::t('base.verbs', 'View'),                            
                        ];
                        return Html::a('<span class="btn btn-warning btn-sm glyphicon glyphicon-search"></span>', $url, $options/*$options*/);
                         },
                         'delete' => function($url, $model) {                        
                        $options = [
                            'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                            'title' => Yii::t('base.verbs', 'Delete'),                            
                        ];
                        return Html::a('<span class="btn btn-danger btn-sm glyphicon glyphicon-remove"></span>', $url, $options/*$options*/);
                         }
                    ]
                ],
         
         
         
         
         

            'codigo',
            'descripcion',
            'user_id',

          
        ],
    ]); ?>
    <?php Pjax::end(); ?>
    
          
          
          
      <?= Html::a(Yii::t('app', 'Asociar atributo'), \yii\helpers\Url::to(['/clasi/clasi/mod-crea-asocia','id'=>$model->codigo,'gridName'=>'pjax-neote','idModal'=>'buscarvalor']), ['class' => 'botonAbre btn btn-success']) ?>
        
</div>
    </div>
   </div>
       </div>