<?php
/*
 * Esta clase extiende la clase original
 * pero adicionalmetne devuelve los data
 * para los combos  
 * FACULTADES
 * CARRERAS
 * CARRERAS POR FACULTAD
 */
namespace frontend\modules\cc\helpers;
use frontend\modules\cc\models\CcOrden;
use frontend\modules\cc\models\CcCc;
use common\helpers\ComboHelper as Combito;

use yii\helpers\ArrayHelper;
use common\helpers\h;
use yii;
class comboHelper extends Combito
{
     public static function getCboCuentas(){     
       /* $idsFacturados= \frontend\modules\sigi\models\SigiKardexdepa::find()->
                select(['id','nombre'])->distinct()-> 
                andWhere(['edificio_id'=>$edificio_id])->column();
         */ return ArrayHelper::map(
                          \frontend\modules\cc\models\CcCuentas::find()
                  //->where(['cuentas_id'=>$edificio_id])
                 ->all(),
                'id','nombre'); 
    } 
    public static function getCboParentCecos($model){     
       /* $idsFacturados= \frontend\modules\sigi\models\SigiKardexdepa::find()->
                select(['id','nombre'])->distinct()-> 
                andWhere(['edificio_id'=>$edificio_id])->column();
        * 
         */ 
        $filtro=null;
        if($model instanceof CcOrden)
         $filtro=['esorden'=>'O'];
        if($model instanceof CcCc)
         $filtro=['esorden'=>'C'];
        $query= \frontend\modules\cc\models\CcCc::find()
                  ->where(['parent_id'=>null]);
        if(!is_null($filtro))
         $query->andWhere($filtro);
        return ArrayHelper::map(                         
                 $query->all(),
                'id','descripcion'); 
    } 
    
}


