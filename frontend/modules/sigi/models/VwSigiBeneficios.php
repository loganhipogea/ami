<?php

namespace frontend\modules\sigi\models;

use Yii;

/**
 * This is the model class for table "{{%vw_sigi_colectores}}".
 *
 * @property int $idcargo
 * @property string $descargo
 * @property string $codcargo
 * @property int $idgrupo
 * @property int $edificio_id
 * @property string $codgrupo
 * @property string $descripciongrupo
 * @property int $idcolector
 * @property string $tasamora
 * @property string $frecuencia
 * @property string $regular
 * @property string $montofijo
 * @property string $tipomedidor
 * @property int $idedificio
 * @property string $codigo
 * @property string $nombre
 */
class VwSigiBeneficios extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%vw_sigi_beneficios}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idcargo', 'idgrupo', 'edificio_id', 'idcolector', 'idedificio'], 'integer'],
            [['descargo', 'codcargo', 'edificio_id', 'codgrupo', 'tasamora', 'frecuencia', 'regular', 'montofijo', 'nombre'], 'required'],
            [['tasamora'], 'number'],
            [['descargo', 'descripciongrupo'], 'string', 'max' => 40],
            [['codcargo'], 'string', 'max' => 4],
            [['codgrupo', 'frecuencia', 'tipomedidor'], 'string', 'max' => 3],
            [['regular', 'montofijo'], 'string', 'max' => 1],
            [['codigo'], 'string', 'max' => 8],
            [['nombre'], 'string', 'max' => 60],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idcargo' => Yii::t('sigi.labels', 'Idcargo'),
            'descargo' => Yii::t('sigi.labels', 'Descargo'),
            'codcargo' => Yii::t('sigi.labels', 'Codcargo'),
            'idgrupo' => Yii::t('sigi.labels', 'Idgrupo'),
            'edificio_id' => Yii::t('sigi.labels', 'Edificio ID'),
            'codgrupo' => Yii::t('sigi.labels', 'Codgrupo'),
            'descripciongrupo' => Yii::t('sigi.labels', 'Descripciongrupo'),
            'idcolector' => Yii::t('sigi.labels', 'Idcolector'),
            'tasamora' => Yii::t('sigi.labels', 'Tasamora'),
            'frecuencia' => Yii::t('sigi.labels', 'Frecuencia'),
            'regular' => Yii::t('sigi.labels', 'Regular'),
            'montofijo' => Yii::t('sigi.labels', 'Montofijo'),
            'tipomedidor' => Yii::t('sigi.labels', 'Tipomedidor'),
            'idedificio' => Yii::t('sigi.labels', 'Idedificio'),
            'codigo' => Yii::t('sigi.labels', 'Codigo'),
            'nombre' => Yii::t('sigi.labels', 'Nombre'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return VwSigiColectoresQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VwSigiBeneficiosQuery(get_called_class());
    }
}
