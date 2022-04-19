<?php

namespace frontend\modules\mat\models;
use frontend\modules\mat\models\MatDetVale;
use Yii;

/**
 * This is the model class for table "{{%mat_kardex}}".
 *
 * @property int $id
 * @property int $detereq_id
 * @property string $fecha
 * @property string $cant
 */
class MatKardex extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    
    private $_signo=null;
   public $dateorTimeFields = [
        'fecha' => self::_FDATE,       
    ];
    public static function tableName()
    {
        return '{{%mat_kardex}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //[['detreq_id'], 'required'],
            [['detreq_id'], 'integer'],
             [['detvale_id'], 'safe'],
            [['cant'], 'number'],
            [['fecha'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'detreq_id' => Yii::t('app', 'Detereq ID'),
            'fecha' => Yii::t('app', 'Fecha'),
            'cant' => Yii::t('app', 'Cant'),
        ];
    }
   public function getVale()
    {
        return $this->hasOne(MatDetVale::className(), ['id' => 'valedet_id']);
    }
    
     public function getStock()
    {
        return $this->hasOne(MatStock::className(), ['id' => 'stock_id']);
    }
    /**
     * {@inheritdoc}
     * @return MatKardexQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MatKardexQuery(get_called_class());
    }
    
    public function beforeSave($insert) {
        if($insert)
        
        return parent::beforeSave($insert);
    }
    
   public function afterSave($insert, $changedAttributes) {
       //$this->actualizaStock();
       return parent::afterSave($insert, $changedAttributes);
   }
    
   
    
}
