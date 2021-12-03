<?php

namespace frontend\modules\sigi\models;

use Yii;

/**
 * This is the model class for table "{{%sigi_vw_resuestadocuenta}}".
 *
 * @property string $monto
 * @property string $descripcion
 * @property int $edificio_id
 * @property string $codigo
 * @property int $cuenta_id
 */
class VwSigiResuestadocuenta extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sigi_vw_resuestadocuenta}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['monto'], 'number'],
            [['edificio_id', 'cuenta_id'], 'required'],
            [['edificio_id', 'cuenta_id'], 'integer'],
            [['descripcion'], 'string', 'max' => 40],
            [['codigo'], 'string', 'max' => 8],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'monto' => Yii::t('app', 'Monto'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'edificio_id' => Yii::t('app', 'Edificio ID'),
            'codigo' => Yii::t('app', 'Codigo'),
            'cuenta_id' => Yii::t('app', 'Cuenta ID'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return VwSigiResuestadocuentaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VwSigiResuestadocuentaQuery(get_called_class());
    }
}
