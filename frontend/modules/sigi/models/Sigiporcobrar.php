<?php

namespace frontend\modules\sigi\models;

use Yii;

/**
 * This is the model class for table "{{%sigi_porpagar}}".
 *
 * @property int $id
 * @property string $codocu
 * @property string $activo
 * @property int $edificio_id
 * @property string $monto
 * @property string $igv
 * @property string $codpresup
 * @property string $monto_usd
 * @property string $glosa
 * @property string $fechadoc
 * @property string $fechaprog
 * @property string $codestado
 * @property string $detalle
 * @property string $codmon
 * @property string $codpro
 * @property int $cargoedificio_id
 * @property string $numdocu
 * @property string $ingreso
 * @property int $unidad_id
 * @property int $facturacion_id
 *
 * @property SigiEdificios $edificio
 * @property SigiPropago[] $sigiPropagos
 */
class Sigiporcobrar extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sigi_porpagar}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codocu', 'edificio_id', 'monto', 'glosa', 'fechadoc', 'fechaprog', 'codestado', 'cargoedificio_id'], 'required'],
            [['edificio_id', 'cargoedificio_id', 'unidad_id', 'facturacion_id'], 'integer'],
            [['monto', 'igv', 'monto_usd'], 'number'],
            [['detalle'], 'string'],
            [['codocu'], 'string', 'max' => 3],
            [['activo', 'ingreso'], 'string', 'max' => 1],
            [['codpresup', 'fechadoc', 'fechaprog'], 'string', 'max' => 10],
            [['glosa'], 'string', 'max' => 40],
            [['codestado'], 'string', 'max' => 2],
            [['codmon', 'codpro'], 'string', 'max' => 6],
            [['numdocu'], 'string', 'max' => 35],
            [['edificio_id'], 'exist', 'skipOnError' => true, 'targetClass' => SigiEdificios::className(), 'targetAttribute' => ['edificio_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'codocu' => Yii::t('app', 'Codocu'),
            'activo' => Yii::t('app', 'Activo'),
            'edificio_id' => Yii::t('app', 'Edificio ID'),
            'monto' => Yii::t('app', 'Monto'),
            'igv' => Yii::t('app', 'Igv'),
            'codpresup' => Yii::t('app', 'Codpresup'),
            'monto_usd' => Yii::t('app', 'Monto Usd'),
            'glosa' => Yii::t('app', 'Glosa'),
            'fechadoc' => Yii::t('app', 'Fechadoc'),
            'fechaprog' => Yii::t('app', 'Fechaprog'),
            'codestado' => Yii::t('app', 'Codestado'),
            'detalle' => Yii::t('app', 'Detalle'),
            'codmon' => Yii::t('app', 'Codmon'),
            'codpro' => Yii::t('app', 'Codpro'),
            'cargoedificio_id' => Yii::t('app', 'Cargoedificio ID'),
            'numdocu' => Yii::t('app', 'Numdocu'),
            'ingreso' => Yii::t('app', 'Ingreso'),
            'unidad_id' => Yii::t('app', 'Unidad ID'),
            'facturacion_id' => Yii::t('app', 'Facturacion ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdificio()
    {
        return $this->hasOne(SigiEdificios::className(), ['id' => 'edificio_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSigiPropagos()
    {
        return $this->hasMany(SigiPropago::className(), ['porpagar_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return SigiporcobrarQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SigiporcobrarQuery(get_called_class());
    }
}
