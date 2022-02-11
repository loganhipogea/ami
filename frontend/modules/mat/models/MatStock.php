<?php

namespace frontend\modules\mat\models;
use frontend\modules\mat\models\MatDetreq;

use Yii;

/**
 * This is the model class for table "{{%mat_stock}}".
 *
 * @property int $id
 * @property string $codart
 * @property string $cant
 * @property string $um
 * @property string $ubicacion
 * @property string $cantres
 * @property string $codal
 * @property string $valor
 * @property string $lastmov
 *
 * @property Maestrocompo $codart0
 */
class MatStock extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mat_stock}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codart'], 'required'],
            [['cant', 'cantres', 'valor'], 'number'],
            [['codart', 'ubicacion'], 'string', 'max' => 14],
            [['um', 'codal'], 'string', 'max' => 4],
            [['lastmov'], 'string', 'max' => 10],
            [['codart'], 'unique'],
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
            'codart' => Yii::t('app', 'Codart'),
            'cant' => Yii::t('app', 'Cant'),
            'um' => Yii::t('app', 'Um'),
            'ubicacion' => Yii::t('app', 'Ubicacion'),
            'cantres' => Yii::t('app', 'Cantres'),
            'codal' => Yii::t('app', 'Codal'),
            'valor' => Yii::t('app', 'Valor'),
            'lastmov' => Yii::t('app', 'Lastmov'),
        ];
    }
 public function getDetreq()
    {
        return $this->hasOne(MatDetreq::className(), ['codart' => 'codart']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterial()
    {
        return $this->hasOne(Maestrocompo::className(), ['codart' => 'codart']);
    }

    /**
     * {@inheritdoc}
     * @return MatStockQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MatStockQuery(get_called_class());
    }
    
    public function actualiza(MatKardex $kardex){
        
       }
}
