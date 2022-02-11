<?php

namespace frontend\modules\mat\models;
use common\models\masters\Maestrocompo;
use Yii;

/**
 * This is the model class for table "{{%mat_detvale}}".
 *
 * @property int $id
 * @property int $vale_id
 * @property string $item
 * @property string $cant
 * @property string $um
 * @property string $codart
 * @property string $codest
 *
 * @property Maestrocompo $codart0
 */
class MatDetvale extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mat_detvale}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vale_id', 'codart'], 'required'],
            [['vale_id'], 'integer'],
            [['cant'], 'number'],
             [['valor'], 'safe'],
            [['item', 'um'], 'string', 'max' => 4], 
            [['codart'], 'string', 'max' => 14],
            [['codest'], 'string', 'max' => 2],
            [['codart'], 'exist', 'skipOnError' => true, 'targetClass' => Maestrocompo::className(), 'targetAttribute' => ['codart' => 'codart']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'vale_id' => Yii::t('app', 'Vale ID'),
            'item' => Yii::t('app', 'Item'),
            'cant' => Yii::t('app', 'Cant'),
            'um' => Yii::t('app', 'Um'),
            'codart' => Yii::t('app', 'Codart'),
            'codest' => Yii::t('app', 'Codest'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterial()
    {
        return $this->hasOne(Maestrocompo::className(), ['codart' => 'codart']);
    }
    
     public function getVale()
    {
        return $this->hasOne(MatVale::className(), ['id' => 'vale_id']);
    }

    /**
     * {@inheritdoc}
     * @return MatDetvaleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MatDetvaleQuery(get_called_class());
    }
    
     public function beforeSave($insert) {
        if($insert){
           // $this->activo=true;            
            $this->item='1'.str_pad($this->vale->getDetalles()->count()+1,3,'0',STR_PAD_LEFT);
        }
        
        return parent::beforeSave($insert);
    }
}
