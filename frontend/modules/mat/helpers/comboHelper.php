<?php
/*
 * Esta clase extiende la clase original
 * pero adicionalmetne devuelve los data
 * para los combos  
 * FACULTADES
 * CARRERAS
 * CARRERAS POR FACULTAD
 */
namespace frontend\modules\mat\helpers;
use yii\helpers\ArrayHelper;
use common\helpers\ComboHelper as Combito;
use common\helpers\h;
use yii;
class ComboHelper extends Combito
{
    
    public static function getCboMovAlmacen(){
         //$idsEdificios= ;
        return [
            '100'=>'SALIDA PARA CONSUMO',
            '101'=>'DEVOLUCION',
            '900'=>'INGRESO POR COMPRA',
             '901'=>'REINGRESO',
            ];
        
    }
    
  
    
}


