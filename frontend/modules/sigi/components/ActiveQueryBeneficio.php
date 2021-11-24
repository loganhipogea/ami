<?php
namespace frontend\modules\sigi\components;
//use frontend\modules\sigi\models\SigiUserEdificios;
//use frontend\modules\sigi\models\Edificios;
use frontend\modules\sigi\components\ActiveQueryScope;
//use frontend\modules\sta\staModule;
//use common\helpers\h;

class ActiveQueryBeneficio extends ActiveQueryScope 
{
    
  public function init()
    {
      //var_dump(SigiUserEdificios::filterEdificios());die();
       //$this->andWhere([ 'in', 'codfac',['FIM','FIP'] ]);
      $this->alias('t')->andWhere(['egreso'=>'0']);
        parent::init();
    }
    // HOLA MODIFICANDO

   
   
    
   
   /*
    * Cada que se efectue una llamada a un SQL
    * Siempre filtrará los valores de facultagitdes 
    * asignados en la tabla 'userfacultades' a cada usuario
    * sin necesidad de escribir la condicion una y otra vez
    * Se vale de los valores  devueltos porla funcion 
    * UserFacultades::filterFacultades()
    */
   /* public function all($db = null)
    {
        $this->andWhere(
              ['in',
              'codfac', UserFacultades::filterFacultades()
               ]
               );
        return parent::all($db);
    }*/
    
    /*public function active()
        {
          return $this->andWhere(
              ['in',
              'codfac', UserFacultades::filterFacultades()
               ]
               );
        }*/
}

