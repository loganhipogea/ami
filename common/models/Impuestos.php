<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%impuestos}}".
 *
 * @property string $codigo
 * @property string $activo
 * @property string $descripcion
 * @property string $valor
 */
class Impuestos extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%impuestos}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codigo', 'descripcion', 'valor'], 'required'],
            [['valor'], 'number'],
            [['codigo'], 'string', 'max' => 6],
            [['activo'], 'string', 'max' => 1],
            [['descripcion'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'codigo' => Yii::t('app', 'Codigo'),
            'activo' => Yii::t('app', 'Activo'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'valor' => Yii::t('app', 'Valor'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return ImpuestosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ImpuestosQuery(get_called_class());
    }
}
