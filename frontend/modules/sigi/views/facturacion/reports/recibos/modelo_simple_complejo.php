<?php
use frontend\modules\report\components\NumeroAletras;
use common\models\masters\Monedas;
//print_r($detalles);
 foreach($grupos as $index=>$grupo){
    if($index==0){ ?>
     <div style=" position:absolute;  left:35px;  top:75px;  font-size:9;  font-family:arial;  font-weight:bold;  color:#F72; ">
    <?php } elseif($index==1){?>
       <div style=" position:absolute;  left:580px;  top:75px;  font-size:9;  font-family:arial;  font-weight:bold;  color:#F72; ">
     <?php
         }else{ ?>
           <div>
       <?php 
          echo $this->render('block',['detalles'=>$detalles,'grupo'=>$grupo]); 
         }
     }
       ?>
       </div>
<div style="padding:3px; border: 1px solid #000;margin-bottom: 17px; font-size:7px;  "  >
    Total Recibo : <?=$totalMes.'   '.
        //Yii::$app->formatter->asSpellout(round($totalMes,3));
        (new NumeroAletras)->toWords(              
              round($totalMesRaw,2)).'  '.
               Monedas::findOne($codmon)->desmon ?>
</div>

