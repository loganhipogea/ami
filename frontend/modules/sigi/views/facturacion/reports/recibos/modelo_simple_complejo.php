<?php
use frontend\modules\report\components\NumeroAletras;
use common\models\masters\Monedas;

$i=1;
 foreach($datos as $grupo_id=>$bloque){
     if($i==1){ ?>
         <div style=" position:absolute;  left:35px;    font-size:9;  font-family:arial;  font-weight:bold;">
     <?php 
       echo $this->render('block',['bloque'=>$bloque,'codmon'=>$codmon]); 
       
       ?>
         </div>
      <?php
       break; }
     }
      ?>  
  
 <?php 
 $i=2; ?> 
<div style=" position:absolute;  left:580px; top:120px;  font-size:9;  font-family:arial;  font-weight:bold; background-color:#F72; ">
 <table>        
 <?php foreach($datos as $grupo_id=>$bloque){
     if($i>1){ ?>
       <tr>
         <?php     echo $this->render('block',['bloque'=>$bloque,'codmon'=>$codmon]); ?>
       </tr>
       <?php }
     }
      ?>  
  </table>
  </div>    
     
       
<div style="padding:3px; border: 1px solid #000;margin-bottom: 17px; font-size:7px;  "  >
    Total Recibo : <?=$totalMes.'   '.
        //Yii::$app->formatter->asSpellout(round($totalMes,3));
        (new NumeroAletras)->toWords(              
              round($totalMesRaw,2)).'  '.
               Monedas::findOne($codmon)->desmon ?>
</div>

