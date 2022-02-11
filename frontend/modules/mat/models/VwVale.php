<?php

namespace frontend\modules\mat\models;

use Yii;

/**
 * This is the model class for table "{{%mat_vw_vale}}".
 *
 * @property string $numero
 * @property string $fecha
 * @property string $codmov
 * @property string $codpro
 * @property string $cant
 * @property string $um
 * @property string $codart
 * @property string $item
 * @property string $descripcion
 */
class VwVale extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mat_vw_vale}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['numero', 'codmov', 'codpro', 'codart', 'descripcion'], 'required'],
            [['cant'], 'number'],
            [['numero', 'fecha'], 'string', 'max' => 10],
            [['codmov'], 'string', 'max' => 3],
            [['codpro', 'codart'], 'string', 'max' => 6],
            [['um', 'item'], 'string', 'max' => 4],
            [['descripcion'], 'string', 'max' => 60],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'numero' => Yii::t('app', 'Numero'),
            'fecha' => Yii::t('app', 'Fecha'),
            'codmov' => Yii::t('app', 'Codmov'),
            'codpro' => Yii::t('app', 'Codpro'),
            'cant' => Yii::t('app', 'Cant'),
            'um' => Yii::t('app', 'Um'),
            'codart' => Yii::t('app', 'Codart'),
            'item' => Yii::t('app', 'Item'),
            'descripcion' => Yii::t('app', 'Descripcion'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return VwValeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VwValeQuery(get_called_class());
    }
}
