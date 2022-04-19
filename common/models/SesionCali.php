<?php
namespace common\models;
use common\models\base\modelBase;
use Yii;
use yii\base\Model;

/**
 * Login form
 */
class SesionCali extends modelBase
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
      return [];  
    }
      public function attributeLabels()
    {
        return [
            'proc_id' => Yii::t('base.names', 'Proceso'),
            'os_id' => Yii::t('base.names', 'Orden'),
            'detos_id' => Yii::t('base.names', 'Item'),
           
        ];
    }
    
    public function restoreAttributes(){
        $this->proc_id=$this->getSesionCali()->idProceso;
        $this->os_id=$this->getSesionCali()->idOs;
         $this->detos_id=$this->getSesionCali()->idDetOs;
    }
   
    
    public function graba(){
        
        $this->getSesionCali()->inserta(
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
