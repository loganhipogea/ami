<?php

namespace frontend\modules\op\models;

use Yii;

/**
 * This is the model class for table "{{%op_otra}}".
 *
 * @property int $id
 * @property string $numero
 * @property string $fecha
 * @property string $placa
 * @property string $fsalida
 * @property string $fregreso
 * @property int $user_id
 * @property string $codtra
 * @property string $descripcion
 * @property string $texto
 * @property string $codest
 *
 * @property Trabajadores $codtra0
 */
class OpOtra extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%op_otra}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['numero'], 'required'],
            [['user_id'], 'integer'],
            [['texto'], 'string'],
            [['numero'], 'string', 'max' => 8],
            [['fecha'], 'string', 'max' => 10],
            [['placa'], 'string', 'max' => 14],
            [['fsalida', 'fregreso'], 'string', 'max' => 19],
            [['codtra'], 'string', 'max' => 6],
            [['descripcion'], 'string', 'max' => 40],
            [['codest'], 'string', 'max' => 3],
            [['codtra'], 'exist', 'skipOnError' => true, 'targetClass' => Trabajadores::className(), 'targetAttribute' => ['codtra' => 'codigotra']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'numero' => Yii::t('app', 'Numero'),
            'fecha' => Yii::t('app', 'Fecha'),
            'placa' => Yii::t('app', 'Placa'),
            'fsalida' => Yii::t('app', 'Fsalida'),
            'fregreso' => Yii::t('app', 'Fregreso'),
            'user_id' => Yii::t('app', 'User ID'),
            'codtra' => Yii::t('app', 'Codtra'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'texto' => Yii::t('app', 'Texto'),
            'codest' => Yii::t('app', 'Codest'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodtra0()
    {
        return $this->hasOne(Trabajadores::className(), ['codigotra' => 'codtra']);
    }

    /**
     * {@inheritdoc}
     * @return OpOtraQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OpOtraQuery(get_called_class());
    }
}
