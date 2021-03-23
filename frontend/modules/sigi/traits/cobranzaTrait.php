<?php
namespace frontend\modules\sigi\traits;
use frontend\modules\sigi\models\VwKardexPagos;
use yii;
trait cobranzaTrait
{

    
  public function deuda(){
     return VwKardexPagos::find()->select(['sum(deuda) as deuda'])->andWhere(['anio'=>$this->anio,'mes'=>$this->mes,'edificio_id'=>$this->edificio_id])->scalar();
   }
  
    
}
