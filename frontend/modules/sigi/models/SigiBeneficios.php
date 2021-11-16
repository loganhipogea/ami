<?php

namespace frontend\modules\sigi\models;

use Yii;

/**
 * This is the model class for table "{{%sigi_cargos}}".
 *
 * @property int $id
 * @property string $codcargo
 * @property string $descargo
 * @property string $esegreso
 * @property string $regular
 *
 * @property SigiCargosedificio[] $sigiCargosedificios
 */
class SigiBeneficios extends \common\models\base\modelBase
{
    
    public function behaviors() {
        return [
           
            'auditoriaBehavior' => [
                'class' => '\common\behaviors\AuditBehavior',
            ],
          
        ];
    }
    
  
    public $booleanFields=['esegreso','regular'];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sigi_cargos}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codcargo', 'descargo'], 'required'],
             [['codcargo'], 'unique'],
            [['esegreso', 'regular'], 'safe'],
            [['codcargo'], 'match',
                'pattern'=>'/[1-9]{1}[0-9]{2}/',
                'message'=>yii::t('sigi.errors','El formato debe de ser numérico de 3 dígitos y no comenzar por cero')
             ],
            [['codcargo'], 'string', 'max' => 4],
            [['descargo'], 'string', 'max' => 60],
            //[['esegreso', 'regular'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'codcargo' => Yii::t('app', 'Cod'),
            'descargo' => Yii::t('app', 'Descripción'),
            'esegreso' => Yii::t('app', 'Esegreso'),
            'regular' => Yii::t('app', 'Regular'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
   

    /**
     * {@inheritdoc}
     * @return SigiCargosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SigiBeneficiosQuery(get_called_class());
    }
    
    public function beforeSave($insert) {
        //yii::error('before ssave ',__FUNCTION__);
        if($insert)
        $this->esegreso=false;
        return parent::beforeSave($insert);
    }
    
}
