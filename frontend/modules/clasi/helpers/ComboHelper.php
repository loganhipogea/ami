<?php
/*
 * Esta clase extiende la clase original
 * pero adicionalmetne devuelve los data
 * para los combos  
 * FACULTADES
 * CARRERAS
 * CARRERAS POR FACULTAD
 */
namespace frontend\modules\clasi\helpers;
use yii\helpers\ArrayHelper;
use frontend\modules\mat\helpers\ComboHelper as Combito;
use common\helpers\h;
use yii;
class ComboHelper extends Combito
{
    
    public static function actividadesOs($idOs){ 
                return ArrayHelper::map(
                                \frontend\modules\op\models\OpOsdet::find()
                ->where(['os_id'=>$idOs])->all(),
                'id','descripcion');
    }
     public static function procesos(){ 
                return ArrayHelper::map(
                                \frontend\modules\op\models\OpProcesos::find()->all()
               ,
                'id','descripcion');
    }
    
    public static function os(){ 
                return ArrayHelper::map(
                                \frontend\modules\op\models\OpOs::find()->all()
               ,
                'id','descripcion');
    }
    
    public static function clases(){ 
                return ArrayHelper::map(
                                \frontend\modules\clasi\models\ClasiClases::find()->all()
               ,
                'codigo','descripcion');
    }
    
}


