<?php
namespace frontend\modules\cc\components;
use common\helpers\h;
/* 
 * Esta clase es la que efectua los filtros por facultad segun 
 * el perfil del ususario; es decir 
 * cualquier persona no puede visulaizar registros de otras facultades
 * por convencion el campo de criterio es el campo
 * "codfac" 
 */
class ActiveQueryScopeColector extends \yii\db\ActiveQuery 
{
    
  public function init()
    {
      //var_dump(SigiUserEdificios::filterEdificios());die();
       //$this->andWhere([ 'in', 'codfac',['FIM','FIP'] ]);
      $this->alias('t')->andWhere(['esorden'=>'O']);
        parent::init();
    }
    // HOLA MODIFICANDO

   
    
   public function complete(){
       return  $this->orWhere(['in',
              'edificio_id',Edificios::find()->select('id')->asArray()->all()
               ]);
   }
    
    
   
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

