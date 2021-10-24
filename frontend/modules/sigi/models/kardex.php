<?php

namespace frontend\modules\sigi\models;

use Yii;

/**
 * This is the model class for table "{{%sigi_kardexdepa}}".
 *
 * @property int $id
 * @property int $facturacion_id
 * @property int $operacion_id Numero de operacion del banco, para abonos  
 * @property int $edificio_id
 * @property int $unidad_id
 * @property int $mes
 * @property string $fecha
 * @property string $anio
 * @property string $codmon
 * @property string $numerorecibo Numeor del recibo  
 * @property string $monto
 * @property string $igv
 * @property string $detalles
 * @property int $reporte_id
 * @property string $noperacion
 * @property int $banco_id
 * @property string $cancelado
 * @property string $enviado
 * @property string $aprobado
 *
 * @property SigiUnidades $unidad
 * @property SigiEdificios $edificio
 * @property SigiFacturacion $facturacion
 */
class kardex extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sigi_kardexdepa}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['facturacion_id', 'edificio_id', 'unidad_id', 'mes', 'fecha', 'anio'], 'required'],
            [['facturacion_id', 'operacion_id', 'edificio_id', 'unidad_id', 'mes', 'reporte_id', 'banco_id'], 'integer'],
            [['monto', 'igv'], 'number'],
            [['detalles'], 'string'],
            [['fecha'], 'string', 'max' => 10],
            [['anio'], 'string', 'max' => 4],
            [['codmon'], 'string', 'max' => 3],
            [['numerorecibo'], 'string', 'max' => 12],
            [['noperacion'], 'string', 'max' => 14],
            [['cancelado', 'aprobado'], 'string', 'max' => 1],
            [['enviado'], 'string', 'max' => 19],
            [['unidad_id'], 'exist', 'skipOnError' => true, 'targetClass' => SigiUnidades::className(), 'targetAttribute' => ['unidad_id' => 'id']],
            [['edificio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Edificios::className(), 'targetAttribute' => ['edificio_id' => 'id']],
            [['facturacion_id'], 'exist', 'skipOnError' => true, 'targetClass' => SigiFacturacion::className(), 'targetAttribute' => ['facturacion_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'facturacion_id' => Yii::t('app', 'Facturacion ID'),
            'operacion_id' => Yii::t('app', 'Operacion ID'),
            'edificio_id' => Yii::t('app', 'Edificio ID'),
            'unidad_id' => Yii::t('app', 'Unidad ID'),
            'mes' => Yii::t('app', 'Mes'),
            'fecha' => Yii::t('app', 'Fecha'),
            'anio' => Yii::t('app', 'Anio'),
            'codmon' => Yii::t('app', 'Codmon'),
            'numerorecibo' => Yii::t('app', 'Numerorecibo'),
            'monto' => Yii::t('app', 'Monto'),
            'igv' => Yii::t('app', 'Igv'),
            'detalles' => Yii::t('app', 'Detalles'),
            'reporte_id' => Yii::t('app', 'Reporte ID'),
            'noperacion' => Yii::t('app', 'Noperacion'),
            'banco_id' => Yii::t('app', 'Banco ID'),
            'cancelado' => Yii::t('app', 'Cancelado'),
            'enviado' => Yii::t('app', 'Enviado'),
            'aprobado' => Yii::t('app', 'Aprobado'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnidad()
    {
        return $this->hasOne(SigiUnidades::className(), ['id' => 'unidad_id']);
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
    public function getFacturacion()
    {
        return $this->hasOne(SigiFacturacion::className(), ['id' => 'facturacion_id']);
    }

    /**
     * {@inheritdoc}
     * @return 7Query the active query used by this AR class.
     */
    public static function find()
    {
        return new Query(get_called_class());
    }
    
    public function beforeSave($insert) {
         yii::error('beforeSAVE');
        parent::beforeSave($insert);
       
    }
}
