<?php

namespace frontend\modules\op\models;

use Yii;

/**
 * This is the model class for table "{{%op_planestarifa}}".
 *
 * @property int $id
 * @property string $codigo
 * @property string $porc_dominical
 * @property string $porc_feriado
 * @property string $porc_nocturno
 * @property string $porc_localizacion
 * @property string $porc_refrigerio
 * @property string $porc_hextras
 * @property int $nhoras
 * @property string $hinicio_nocturno
 *
 * @property OpTareodet[] $opTareodets
 * @property OpTarifaHombre[] $opTarifaHombres
 */
class OpPlanestarifa extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%op_planestarifa}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['porc_dominical', 'porc_feriado', 'porc_nocturno', 'porc_localizacion', 'porc_refrigerio', 'porc_hextras'], 'number'],
            [['nhoras'], 'integer'],
            [['codigo'], 'string', 'max' => 4],
            [['hinicio_nocturno'], 'string', 'max' => 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'codigo' => Yii::t('app', 'Código'),
            'porc_dominical' => Yii::t('app', 'Dominical'),
            'porc_feriado' => Yii::t('app', 'Feriado'),
            'porc_nocturno' => Yii::t('app', 'Noche'),
            'porc_localizacion' => Yii::t('app', 'Local'),
            'porc_refrigerio' => Yii::t('app', 'Refrig'),
            'porc_hextras' => Yii::t('app', 'Hextras'),
            'nhoras' => Yii::t('app', 'N horas'),
            'hinicio_nocturno' => Yii::t('app', 'Hini Noche'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOpTareodets()
    {
        return $this->hasMany(OpTareodet::className(), ['tarifa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOpTarifaHombres()
    {
        return $this->hasMany(OpTarifaHombre::className(), ['tarifa_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return OptQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OpPlanestarifaQuery(get_called_class());
    }
}
