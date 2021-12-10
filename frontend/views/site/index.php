<?php
use dosamigos\chartjs\ChartJs;
use frontend\modules\sigi\models\VwKardexPagos;
use frontend\modules\sigi\models\SigiEstadocuentas;
use common\helpers\h;

$formato=h::formato();
$deudas=VwKardexPagos::find()->resumenDeudasByEdificio()->asArray()->all();
$facturado=VwKardexPagos::find()->resumenMontosACobrarByEdificio()->asArray()->all();
$edificios= array_column($deudas, 'codigo');
$deudas= array_column($deudas, 'deuda');
$facturados= array_column($facturado, 'facturado');
$cobrado=[];
foreach($facturados as $clave=>$facturado){
    $cobrado[]=$facturado-$deudas[$clave];
}
if (Yii::$app->session->hasFlash('info')): ?>
    <div class="alert alert-warning">
         
         <?= Yii::$app->session->getFlash('info') ?>
    </div>
<?php endif; ?>
<?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="alert alert-danger">
         
         <?= Yii::$app->session->getFlash('error') ?>
    </div>
<?php endif; ?>
<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success">
         
         <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>



    
      

          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              
            
              <div class="card-header">
                  <h4>Cobranzas</h4>
                
              </div>
              <!-- /.card-header -->
           
                  
                 
                   

          
                      <!-- Sales Chart Canvas -->
                      
                    <?= ChartJs::widget([
    'type' => 'bar',
    'options' => [
        'height' => 180,
        'width' => 400
    ],
    'data' => [
        'labels' => $edificios,
        'datasets' => [
            [
                'label' => yii::t('sta.labels',"Cobrado"),
                'backgroundColor' => "rgba(255,157,64,0.9)",
                'borderColor' => "rgba(60,117,9,1)",
                'pointBackgroundColor' => "rgba(179,181,198,1)",
                'pointBorderColor' => "#fff",
                'pointHoverBackgroundColor' => "#fff",
                'pointHoverBorderColor' => "rgba(179,181,198,1)",
                'data' => $cobrado
            ],
            [
                'label' =>  yii::t('sta.labels',"Facturado"),
                'backgroundColor' => "rgba(232,18,171,1)",
                'borderColor' => "rgba(255,99,132,1)",
                'pointBackgroundColor' => "rgba(255,99,132,1)",
                'pointBorderColor' => "#fff",
                'pointHoverBackgroundColor' => "#fff",
                'pointHoverBorderColor' => "rgba(255,99,132,1)",
                'data' => $facturados
            ]
        ]
    ]
]);
?>
                   
                    <!-- /.chart-responsive -->
               
                  
                  <!-- /.col -->
           
                <!-- /.row -->
              </div>
              <!-- ./card-body -->

      
      
      
      
      
      
      
      
      
      
      
      
      
      
      <br>
              <br><br>
              <br><br>
              <br>.<br>
              <br>.
              <br>
              <br>
      
     <h4>Estado de cuentas</h4> 

      <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              
             <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  
                  <tr>
                      <th>Contrato</th> 
                      <th>Mes</th> 
                      <th>Sald mes ant.</th> 
                     <th>Ingresos</th> 
                      <th>Egresos</th> 
                      <th>Sald actual</th> 
                      <th>Saldo en cuenta</th> 
                     <th>Diferencia</th>                      
                  </tr>
                  </thead>
                  <tbody>
                 <?php 
                 
                 $data= SigiEstadocuentas::find()->resumenByEdificios()->all();  ?>
                  <?php foreach($data as $fila) { 
                       $model=SigiEstadocuentas::findOne($fila->id);
                       $model->refreshMontos();
                      ?>     
                <tr>                   
                  <td "style"="font-size:0.5em"><?=$fila->codigo?><i style="color:#ccc;"><span class="fa fa-check"></span></i>
                  </td>
                  <td "style"="font-size:0.5em"><?=$fila->mes?><i style="color:#ccc;"><span class="fa fa-check"></span></i>
                  </td>
                  <td "style"="font-size:0.5em"><?=$formato->asDecimal($fila->saldmesant,2)?><i style="color:#ccc;"><span class="fa fa-check"></span></i>
                  </td>
                   <td "style"="font-size:0.5em"><?=$formato->asDecimal($fila->ingresos)?><i style="color:#ccc;"><span class="fa fa-check"></span></i>
                  </td>
                   <td "style"="font-size:0.5em"><?=$formato->asDecimal($fila->egresos)?><i style="color:#ccc;"><span class="fa fa-check"></span></i>
                  </td>
                   <td "style"="font-size:0.5em"><?=$formato->asDecimal($fila->saldfinal)?><i style="color:#ccc;"><span class="fa fa-check"></span></i>
                  </td>
                   <td "style"="font-size:0.5em"><?=$formato->asDecimal($fila->saldecuenta)?><i style="color:#ccc;"><span class="fa fa-check"></span></i>
                  </td>
                  <td "style"="font-size:0.5em"><?=$formato->asDecimal($fila->salddif)?><i style="color:#ccc;"><span class="fa fa-check"></span></i>
                  </td>
                 
                </tr> 
                 <?php } ?>      
                         
                        
                  
                  </tbody>
                </table>
              </div>
          </div>  
           
          
          
      </div>

