<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\helpers\timeHelper;
use common\helpers\h;
use frontend\modules\sigi\models\VwSigiFacturecibo;
use frontend\modules\sigi\models\SigiUnidades;

$frt=h::formato();

?>
<!DOCTYPE html>
    <html lang="es">
    <head>        
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
       <title></title>
        
    </head>
   <body style="overflow-y: scroll;">
   <!--  LOGO DEL RECIBO    !--> 
   <div style="position:absolute;
            width:180px;height:80px;
            padding:0px; top:4px;
            left:4px; border-style:solid; border-width:0px; border-color:#e1e1e1 ">

        <div style="position:absolute; padding:1px;border-style:none;top:5px; left:5px; ">
            <div style="float:right">
                <?=Html::img('@web/sigi/logo_diar.jpg',['width'=>120,'height'=>120])?>
            </div>

        </div>
    </div>
  <!-- FIN DEL   LOGO DEL RECIBO    !--> 
  
  
<div style=" position:absolute;  left:551px;  top:41px;  font-size:14;  font-family:cour;  color:#000; ">
    ESTADO :
</div>
 <div style=" position:absolute;  left:681px;  top:41px;  font-size:12;  font-family:cour;  font-weight:bold;  color:#000; ">
       <?=($model->estado=='CREA')?'EN PROCESO':'COMPLETO'?>
</div>
  
<div style=" position:absolute;  left:551px;  top:70px;  font-size:14;  font-family:cour;  color:#000; ">
    ÚLT. ACT :
</div>
 <div style=" position:absolute;  left:681px;  top:70px;  font-size:12;  font-family:cour;  font-weight:bold;  color:#000; ">
       <?=(empty($model->lastOPeracion()))?'No hay':$model->lastOPeracion()?>
</div>
  
  
  
 <div style="position:absolute;  left:120x;  top:51px;  font-size:16;  font-family:cour;  font-weight:bold;  color:#000; ">
    <?=$model->edificio->nombre?>
 </div>
 <div style="position:absolute;   left:120px;  top:71px;  font-size:8;  font-family:arial;  font-weight:none;  color:#000; ">
      <?=$model->edificio->direccion?>
 </div>
  
  <div style="position:absolute;   left:190px;  top:150px;  font-size:18;  font-family:cour;  font-weight:900;  color:#e6193c; ">
      REPORTE ECONOMICO MENSUAL <?= timeHelper::mes($model->mes+0)?> - <?=$model->anio?>
 </div>
 
 
       <?PHP  
       $egresos=$model->egresosArray();
       $ingresos=$model->ingresosArray();
       //print_r($egresos);die();
       ?>
  
         <div style="position:absolute;  left:50px;  top:200px; width:700px; border-style: solid; border-width: 1px; border-color: #999">
             <table style="width:100%">
                 <tr>
                        <td style=" background-color: #ddd; padding:5px; font-size:14;color:black; font-weight:1900;  font-family:cour;width:80%;">
                            SALDO CUENTA MES ANTERIOR:
                        </td >
                        <td style=" background-color: #ddd; padding:5px; font-size:14;color:black; font-weight:800; text-align:right;   font-family:cour;width:20%;">
                            <?=$frt->asDecimal($model->saldmesant,2)?>
                        </td>
                 </tr>
           
             
            </table>
             
       </div>
       
  
           <div style="position:absolute;  left:50px;  top:250px; width:700px; border-style: solid; border-width: 1px; border-color: #999">
             <table style="width:100%">
                 <tr>
                        <td style=" background-color: #ddd; border-bottom: 1px solid #ccc; padding:5px; font-size:14;color:black; font-weight:1900;  font-family:cour;width:80%;">
                            INGRESOS
                        </td >
                        <td style="background-color: #ddd;border-bottom: 1px solid #ccc; padding:5px; font-size:14;color:black; font-weight:1900; text-align:right;   font-family:cour;width:20%;">
                            MONTO
                        </td>
                 </tr>
            <?php foreach($ingresos as $filaingreso) {  ?>
                 <tr>
                        <td style="border-bottom: 1px solid #f4f4f4; padding:5px;font-size:14;  font-family:cour;width:80%;display: inline-block">
                    <?=$filaingreso['descripcion']?>
                        </td>
                        <td style="text-align:right;border-bottom: 1px solid #f4f4f4;padding:5px;text-align:right;font-size:14;  font-family:cour;width:20%;display: inline-block"> 
                      <?=$frt->asDecimal($filaingreso['monto'],2)?>
                        </td>
                 </tr>
                 
              <?php }  ?>
                 <tr style="border-bottom: 1px solid #f4f4f4;">
                     <td style="padding:5px; text-align:right; font-size:14px;color:black">Subtotal:</td>
                     <td style="padding:5px;text-align:right; font-size:14px;color:black"><?=$frt->asDecimal($model->totalIngresos(),2)?></td>
                 </tr>
            </table>
          </div>
  
  
  
         <div style="position:absolute;  left:50px;  top:600px; width:700px; border-style: solid; border-width: 1px; border-color: #999">
             <table style="width:100%">
                 <tr>
                        <td style=" background-color: #ddd; padding:5px; font-size:14;color:black; font-weight:1900;  font-family:cour;width:80%;">
                            EGRESOS
                        </td >
                        <td style=" background-color: #ddd; padding:5px; font-size:14;color:black; font-weight:1900; text-align:right;   font-family:cour;width:20%;">
                            MONTO
                        </td>
                 </tr>
            <?php foreach($egresos as $filaegreso) {  ?>
                 <tr>
                        <td style="padding:5px;font-size:14;  font-family:cour;width:80%;display: inline-block">
                    <?=$filaegreso['descripcion']?>
                        </td>
                        <td style="text-align:right;padding:5px;text-align:right;font-size:14;  font-family:cour;width:20%;display: inline-block"> 
                      <?=$frt->asDecimal($filaegreso['monto'],2)?>
                        </td>
                 </tr>
              <?php }  ?>
                 <tr style="border-bottom: 1px solid #f4f4f4;">
                     <td style="padding:5px;text-align:right; font-size:14px;color:black">Subtotal:</td>
                     <td style="padding:5px;text-align:right; font-size:14px;color:black"><?=$frt->asDecimal($model->totalEgresos(),2)?></td>
                 </tr>
            </table>
             
       </div>
  
  <!--   SALDO FINAL     -->
      <div style="position:absolute;  left:50px;  top:800px; width:700px; border-style: solid; border-width: 1px; border-color: #999">
             <table style="width:100%">
                 <tr>
                        <td style=" background-color: #ddd; padding:5px; font-size:14;color:black; font-weight:1900;  font-family:cour;width:80%;">
                            SALDO FINAL:
                        </td >
                        <td style=" background-color: #ddd; padding:5px; font-size:14;color:black; font-weight:800; text-align:right;   font-family:cour;width:20%;">
                            <?=$frt->asDecimal($model->saldfinal,2)?>
                        </td>
                 </tr>
           
             
            </table>
             
       </div>
  <!--   SALDO SEGUNE STADO DE CUENTA ACTUAL      -->
       <div style="position:absolute;  left:50px;  top:830px; width:700px; border-style: solid; border-width: 1px; border-color: #999">
             <table style="width:100%">
                 <tr>
                        <td style=" background-color: #ddd; padding:5px; font-size:14;color:black; font-weight:1900;  font-family:cour;width:80%;">
                            SALDO SEGÚN ESTADO DE CUENTA ACTUAL :
                        </td >
                        <td style=" background-color: #ddd; padding:5px; font-size:14;color:black; font-weight:800; text-align:right;   font-family:cour;width:20%;">
                            <?=$frt->asDecimal($model->saldecuenta,2)?>
                        </td>
                 </tr>
           
             
            </table>
             
       </div>  
   <!--  DIFERENCIA      -->
       <div style="position:absolute;  left:50px;  top:860px; width:700px; border-style: solid; border-width: 1px; border-color: #999">
             <table style="width:100%">
                 <tr>
                        <td style=" background-color: #ddd; padding:5px; font-size:14;color:black; font-weight:1900;  font-family:cour;width:80%;">
                            DIFERENCIA:
                        </td >
                        <td style=" background-color: #ddd; padding:5px; font-size:14;color:black; font-weight:800; text-align:right;   font-family:cour;width:20%;">
                            <?=$frt->asDecimal($model->salddif,2)?>
                        </td>
                 </tr>
           
             
            </table>
             
       </div>   
       
       
       
         
   </body>
    </html>
    


