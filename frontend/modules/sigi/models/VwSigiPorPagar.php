<?php

namespace frontend\modules\sigi\models;

use Yii;

/**
 * This is the model class for table "{{%sigi_vw_porpagar}}".
 *
 * @property int $edificio_id
 * @property int $cargoedificio_id
 * @property string $glosa
 * @property string $fechadoc
 * @property string $despro
 * @property string $codpro
 * @property string $pagado
 * @property string $deuda
 * @property string $descargo
 */
class VwSigiPorPagar extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sigi_vw_porpagar}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['edificio_id', 'cargoedificio_id'], 'integer'],
            [['pagado', 'deuda'], 'number'],
            [['id'], 'safe'],
            [['glosa'], 'string', 'max' => 40],
            [['fechadoc'], 'string', 'max' => 10],
            [['despro', 'descargo'], 'string', 'max' => 60],
            [['codpro'], 'string', 'max' => 6],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'edificio_id' => Yii::t('app', 'Edificio ID'),
            'cargoedificio_id' => Yii::t('app', 'Cargoedificio ID'),
            'glosa' => Yii::t('app', 'Glosa'),
            'fechadoc' => Yii::t('app', 'Fechadoc'),
            'despro' => Yii::t('app', 'Despro'),
            'codpro' => Yii::t('app', 'Codpro'),
            'pagado' => Yii::t('app', 'Pagado'),
            'deuda' => Yii::t('app', 'Deuda'),
            'descargo' => Yii::t('app', 'Descargo'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return VwSigiPorPagarQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VwSigiPorPagarQuery(get_called_class());
    }
}
