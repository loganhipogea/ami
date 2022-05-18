<?php

namespace frontend\modules\op\models;

use Yii;

/**
 * This is the model class for table "{{%op_tarifa_hombre}}".
 *
 * @property int $id
 * @property int $tarifa_id
 * @property string $codtra
 * @property string $costohora
 *
 * @property OpPlanestarifa $tarifa
 */
class OpTarifaHombre extends \common\models\base\modelBase
{
    
    public $booleanFields=['activo'];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%op_tarifa_hombre}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tarifa_id'], 'required'],
            [['tarifa_id'], 'integer'],
             [['activo'], 'safe'],
            [['costohora'], 'number'],
              [['tarifa_id','codtra','activo'],'unique','targetAttribute' => ['tarifa_id','codtra','activo'], 'message'=>yii::t('sta.labels','Ya existe una tarifa activa para este trabajador')],
            [['codtra'], 'string', 'max' => 6],
            [['tarifa_id'], 'exist', 'skipOnError' => true, 'targetClass' => OpPlanestarifa::className(), 'targetAttribute' => ['tarifa_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'tarifa_id' => Yii::t('app', 'Tarifa ID'),
            'codtra' => Yii::t('app', 'Codtra'),
            'costohora' => Yii::t('app', 'Costohora'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlan()
    {
        return $this->hasOne(OpPlanestarifa::className(), ['id' => 'tarifa_id']);
    }
    
     public function getTrabajador()
    {
        return $this->hasOne(\common\models\masters\Trabajadores::className(), ['codigotra' => 'codtra']);
    }

    /**
     * {@inheritdoc}
     * @return OpTarifaHombreQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OpTarifaHombreQuery(get_called_class());
    }
}
