<?php

namespace frontend\modules\mat\models;

use Yii;

/**
 * This is the model class for table "{{%mat_clasificacion}}".
 *
 * @property int $id
 * @property string $clasificacion_id
 * @property string $codart
 * @property string $descripcion
 * @property string $valor
 * @property string $valor_numerico
 * @property string $codum
 * @property int $user_id
 *
 * @property Maestrocompo $codart0
 * @property ClasiClaseCarac $clasificacion
 */
class MatClaseCarac extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mat_clasificacion}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['clasificacion_id'], 'required'],
            [['valor_numerico'], 'number'],
            [['user_id'], 'integer'],
            [['clasificacion_id'], 'string', 'max' => 31],
            [['codart'], 'string', 'max' => 14],
            [['descripcion'], 'string', 'max' => 40],
            [['valor'], 'string', 'max' => 200],
            [['codum'], 'string', 'max' => 4],
            [['codart'], 'exist', 'skipOnError' => true, 'targetClass' => Maestrocompo::className(), 'targetAttribute' => ['codart' => 'codart']],
            [['clasificacion_id'], 'exist', 'skipOnError' => true, 'targetClass' => ClasiClaseCarac::className(), 'targetAttribute' => ['clasificacion_id' => 'codigo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'clasificacion_id' => Yii::t('app', 'Clasificacion ID'),
            'codart' => Yii::t('app', 'Codart'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'valor' => Yii::t('app', 'Valor'),
            'valor_numerico' => Yii::t('app', 'Valor Numerico'),
            'codum' => Yii::t('app', 'Codum'),
            'user_id' => Yii::t('app', 'User ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodart0()
    {
        return $this->hasOne(Maestrocompo::className(), ['codart' => 'codart']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClasificacion()
    {
        return $this->hasOne(ClasiClaseCarac::className(), ['codigo' => 'clasificacion_id']);
    }

    /**
     * {@inheritdoc}
     * @return MatClaseCaracQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MatClaseCaracQuery(get_called_class());
    }
}
