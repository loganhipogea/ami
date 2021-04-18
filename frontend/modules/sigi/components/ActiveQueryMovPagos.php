<?php
namespace frontend\modules\sigi\components;
//use frontend\modules\sigi\models\SigiUserEdificios;
use frontend\modules\sigi\models\SigiMovimientosPre;
//use frontend\modules\sta\staModule;
//use common\helpers\h;
/* 
 * Esta clase es la que efectua los filtros por facultad segun 
 * el perfil del ususario; es decir 
 * cualquier persona no puede visulaizar registros de otras facultades
 * por convencion el campo de criterio es el campo
 * "codfac" 
 */
class ActiveQueryMovCobranzas extends \yii\db\ActiveQuery 
{
    
  public function init()
    {
      //var_dump(SigiUserEdificios::filterEdificios());die();
       //$this->andWhere([ 'in', 'codfac',['FIM','FIP'] ]);
      $this->alias('t')->andWhere(['ingreso'=> SigiMovimientosPre::G_GRUPO_INGRESOS]);
        parent::init();
    }
 
}

