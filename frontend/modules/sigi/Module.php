<?php

namespace frontend\modules\sigi;
use common\helpers\h;
USE \yii2mod\settings\models\enumerables\SettingType;
use frontend\modules\sigi\filters\FilterAccess;
/**
 * people module definition class amiugito
 */
class Module extends \yii\base\Module
{
  const CODIGOPERSONA_NATURAL='100000';
  const PROFILE_RESIDENTE='40';
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'frontend\modules\sigi\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        static::putSettingsModule();

        // custom initialization code goes here
    }
     public function behaviors(){
        return[
            [
            'class' => FilterAccess::className(), 
              //'except' => ['default/complete'],
            ],
        ];
    }
    
    
    
      private static function putSettingsModule(){
         h::getIfNotPutSetting('sigi','montominimo_deudor',5, SettingType::INTEGER_TYPE);
          h::getIfNotPutSetting('sigi','nRecibosBloque',50, SettingType::INTEGER_TYPE);
       // h::getIfNotPutSetting('sigi','numeroMaxLecturas',5, SettingType::INTEGER_TYPE);
        /* h::getIfNotPutSetting('sigi','numeroParaPromedioLecturas',12, SettingType::INTEGER_TYPE);
        h::getIfNotPutSetting('sigi','numeroDiasVencimiento',10, SettingType::INTEGER_TYPE);
        h::getIfNotPutSetting('sigi','correoCobranza1','asistente2@diargestion.com', SettingType::STRING_TYPE);
h::getIfNotPutSetting('sigi','correoCobranza2','asistente1@diargestion.com', SettingType::INTEGER_TYPE);
*/
//  h::getIfNotPutSetting('sigi','urlimagesalu','http:://www.orce.uni.edu.pe/alumnos/', SettingType::STRING_TYPE);
        // h::getIfNotPutSetting('sigi','prefiximagesalu','0060', SettingType::STRING_TYPE);
          return true;
    }
    
    
    
    public function getCodeNaturalPerson(){
        return self::CODIGOPERSONA_NATURAL;
    }
}
