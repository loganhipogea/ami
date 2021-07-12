<?php

namespace frontend\modules\sigi\models;

use Yii;

/**
 * This is the model class for table "{{%sigi_reempmedidor}}".
 *
 * @property int $id
 * @property int $suministro_id_ant
 * @property string $ultima_lectura
 * @property string $fecha_ultima_lectura
 * @property string $fecha_reemplazo
 * @property string $codsuministro_actual
 * @property string $lectura_actual
 * @property string $detalle
 *
 * @property SigiSuministros $suministroIdAnt
 */
class SigiReempmedidor extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    
     public $dateorTimeFields = [
        'fecha_ultima_lectura' => self::_FDATETIME,
        'fecha_reemplazo' => self::_FDATETIME,
        //'ftermino' => self::_FDATETIME
    ];
    public static function tableName()
    {
        return '{{%sigi_reempmedidor}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['suministro_id_ant', 'ultima_lectura',
                'fecha_ultima_lectura', 'fecha_reemplazo',
                'codsuministro_actual'], 'required'],
            [['suministro_id_ant'], 'integer'],
            [['ultima_lectura', 'lectura_actual'], 'number'],
            [['detalle'], 'string'],
            [['fecha_ultima_lectura', 'fecha_reemplazo'], 'string', 'max' => 10],
            [['codsuministro_actual'], 'string', 'max' => 12],
            [['suministro_id_ant'], 'exist', 'skipOnError' => true, 'targetClass' => SigiSuministros::className(), 'targetAttribute' => ['suministro_id_ant' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'suministro_id_ant' => Yii::t('app', 'Suministro Id Ant'),
            'ultima_lectura' => Yii::t('app', 'Ultima Lectura'),
            'fecha_ultima_lectura' => Yii::t('app', 'Fecha Ultima Lectura'),
            'fecha_reemplazo' => Yii::t('app', 'Fecha Reemplazo'),
            'codsuministro_actual' => Yii::t('app', 'Codsuministro Actual'),
            'lectura_actual' => Yii::t('app', 'Lectura Actual'),
            'detalle' => Yii::t('app', 'Detalle'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSuministroAnt()
    {
        return $this->hasOne(SigiSuministros::className(), ['id' => 'suministro_id_ant']);
    }

    /**
     * {@inheritdoc}
     * @return SigiReempmedidorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SigiReempmedidorQuery(get_called_class());
    }
}
