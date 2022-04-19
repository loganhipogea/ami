<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class SesionCali extends Model
{
    public $proc_id;
    public $os_id;
    public $detos_id;
    public $_sesioncali=null;

    public function getSesionCali(){
        if(is_null($this->_sesioncali)){
            $this->_sesioncali= new \common\components\SesionCali();
        }
          return $this->_sesioncali ; 
        
    }
    
    public function rules()
    {
        
    }
      public function attributeLabels()
    {
        return [
            'proc_id' => Yii::t('base.names', 'Proceso'),
            'os_id' => Yii::t('base.names', 'Orden'),
            'detos_id' => Yii::t('base.names', 'Item'),
           
        ];
    }
    
    public function save(){
        $this->sesionCali->sesion->inserta(
                $this->proc_id, $this->os_id, $this->detos_id,
                );
    }
    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
   
}
