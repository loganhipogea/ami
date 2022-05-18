<?php

namespace frontend\modules\clasi\models;

use Yii;

/**
 * This is the model class for table "{{%clasi_clase_carac}}".
 *
 * @property string $codigo
 * @property string $clase_id
 * @property string $carac_id
 * @property string $tipovalor
 * @property string $descripcion
 * @property int $user_id
 *
 * @property ClasiCaracteristicas $carac
 * @property ClasiClases $clase
 * @property MatClasificacion[] $matClasificacions
 */
class ClasiClaseCarac extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%clasi_clase_carac}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codigo', 'clase_id', 'carac_id'], 'required'],
            [['user_id'], 'integer'],
            [['codigo'], 'string', 'max' => 31],
            [['clase_id', 'carac_id'], 'string', 'max' => 15],
            [['tipovalor'], 'string', 'max' => 1],
            [['descripcion'], 'string', 'max' => 40],
            [['codigo'], 'unique'],
            [['carac_id'], 'exist', 'skipOnError' => true, 'targetClass' => ClasiCarac::className(), 'targetAttribute' => ['carac_id' => 'codigo']],
            [['clase_id'], 'exist', 'skipOnError' => true, 'targetClass' => ClasiClases::className(), 'targetAttribute' => ['clase_id' => 'codigo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'codigo' => Yii::t('app', 'Codigo'),
            'clase_id' => Yii::t('app', 'Clase ID'),
            'carac_id' => Yii::t('app', 'Carac ID'),
            'tipovalor' => Yii::t('app', 'Tipovalor'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'user_id' => Yii::t('app', 'User ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarac()
    {
        return $this->hasOne(ClasiCarac::className(), ['codigo' => 'carac_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClase()
    {
        return $this->hasOne(ClasiClases::className(), ['codigo' => 'clase_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    /*public function getMatClasificacions()
    {
        return $this->hasMany(MatClasificacion::className(), ['clasificacion_id' => 'codigo']);
    }*/

    /**
     * {@inheritdoc}
     * @return ClasiClaseCaracQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ClasiClaseCaracQuery(get_called_class());
    }
}
