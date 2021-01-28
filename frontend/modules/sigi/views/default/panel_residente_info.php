<?php
use yii\helpers\Html;
//use kartik\grid\GridView;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\helpers\timeHelper;
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\HighchartsAsset;
use dosamigos\chartjs\ChartJs;
?>
<div class="box box-body">
    <h4>Documentos</h4>
<?php
$edificio=$unidad->edificio;
 Pjax::begin(['id'=>'grilla-deudas']); ?>
    
   <?php
   //echo frontend\modules\sigi\models\SigiEdificiodocus::find()->andWhere(['edificio_id'=>$edificio->id])->createCommand()->rawSql;
//var_dump((new SigiApoderadosSearch())->searchByEdificio($model->id)); die(); ?>
    <?= GridView::widget([
        'dataProvider' =>new \yii\data\ActiveDataProvider([
            'query'=> frontend\modules\sigi\models\SigiEdificiodocus::find()
        ]),
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'columns' => [
               'codocu',
              'nombre',              
            'documento.desdocu',
                [
              'attribute' => '',
               'format'=>'raw',
                'value' => function ($model) {
                          $tieneFile= $model->countFiles();
                       IF($tieneFile>0){
                           return Html::a('<span class="btn btn-success glyphicon glyphicon-download"></span>', $model->files[0]->getUrl(), ['data-pjax'=>'0']);
                       }else{
                           return '';
                       }
                    },
                    ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>



<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">

    
</div>
</div>