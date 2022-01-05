<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\helpers\h;
use frontend\modules\sigi\models\SigiApoderadosSearch;
?>
<div class="edificios-indexhghg">

     <div class="box-body">
         
<?php
 $url= Url::to(['agrega-apoderado','id'=>$model->id,'gridName'=>'grilla-apoderados','idModal'=>'buscarvalor']);
   echo  Html::button(yii::t('base.verbs','Insertar '), ['href' => $url, 'title' => yii::t('sta.labels','Agregar Apoderado'),'id'=>'btn_apoderado', 'class' => 'botonAbre btn btn-success']); 
?> 
         
    <?php Pjax::begin(['id'=>'grilla-apoderados']); ?>
   <?php $dataprovider= (new SigiApoderadosSearch())->searchByEdificio($model->id);  ?>
   <?php //var_dump((new SigiApoderadosSearch())->searchByEdificio($model->id)); die(); ?>
    <?= GridView::widget([
        'dataProvider' =>$dataprovider,
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'columns' => [
                  [
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{update}',
               'buttons' => [
                    'update' => function($url, $model) {  
                       $url= Url::to(['edita-apoderado','id'=>$model->id,'gridName'=>'grilla-apoderados','idModal'=>'buscarvalor']);
                         $options = [
                           'class'=>'botonAbre',
                            //'title' => Yii::t('sta.labels', 'Editar'),
                            //'aria-label' => Yii::t('rbac-admin', 'Activate'),
                            //'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                            //'data-method' => 'get',
                            'data-pjax' => '0',
                             //'target'=>'_blank'
                        ];
                        //return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['href' => $url, 'title' => 'Editar Adjunto', 'class' => ' btn btn-sm btn-success']);
                        return Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>',$url,$options);
                     
                        
                        },
                      
                        
                    ]
                ],
            'codpro',
            'clipro.despro',
        ],
    ]); ?>
    <?php Pjax::end(); ?>
        <?php 
        $areatotal=$model->area();
        $formato=h::formato();
        $models=$dataprovider->getModels(); 
        ?>
         <?php foreach ($models as $modeli) { ?>
         <div class='table-responsive'>
         <table class='table no-margin'>
             <thead>
                 <tr>
                     <th colspan="4"><p class="text-light-blue"><?=$modeli->clipro->despro?></p>  </th>
                 </tr>
                 <tr style='background-color:#eee'>
                      <th>Descripción</th>
                      <th>Cantidad</th>
                      <th>Area(m2)</th> 
                      <th >Partic(%)</th>                     
                 </tr>
              </thead>
            <tbody>
                 <?php 
                 $contador=0;$area=0;
                 foreach($modeli->
                         resumenUnidadesImputablesPadresPorTipo()
                         as $fila) {
                     $contador+=$fila['cantidad'];
                     $area+=$fila['area'];
                     ?>
                   <tr>
                     <td><?=$fila['desunidad'].'S'?></td>
                     <td><?=$fila['cantidad']?></td>
                     <td><?=$formato->asDecimal($fila['area'],4)?></td>
                     <td><?=$formato->asDecimal($fila['area']*100/$areatotal,4)?></td>                  
                  </tr>
                  
                <?php  }  ?>
                  
                      <tr>
                          <td>UNIDADES AFILIADAS</td>
                          <td><?=$modeli->nUnidadesImputablesHijas()?> </td>                         
                          <td><?=$formato->asDecimal($modeli->areaUnidadesImputablesHijas(),4)?></td> 
                          <td><?=$formato->asDecimal($modeli->areaUnidadesImputablesHijas()*100/$areatotal,4)?></td> 
                          
                      </tr>
                      <tr style='background-color:#eee'>
                       
                          <td><p class='text-orange'>Total:</p></td>
                      <td><p class='text-orange'><?=$contador+$modeli->nUnidadesImputablesHijas()?> </p></td>
                      <td><p class='text-orange'><?=$formato->asDecimal($area+$modeli->areaUnidadesImputablesHijas(),4)?> </p></td>
                      <td><p class='text-orange'><?=$formato->asDecimal(($area+$modeli->areaUnidadesImputablesHijas())*100/$areatotal,4)?> </p></td>  
                      
                     </tr>
             </tbody>
         </table>
         </div>
         <br>
         <br>
         <?php } ?> 
         
         
         
    </div>
 </div>
       