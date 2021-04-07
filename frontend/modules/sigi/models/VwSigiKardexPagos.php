<?php

namespace frontend\modules\sigi\models;

use Yii;

/**
 * This is the model class for table "{{%vw_sigi_kardex_pagos}}".
 *
 * @property int $facturacion_id
 * @property int $id
 * @property string $anio
 * @property int $mes
 * @property string $monto
 * @property string $nombre
 * @property int $unidad_id
 * @property int $edificio_id
 * @property string $numero
 * @property string $pagado
 */
class VwSigiKardexPagos extends \common\models\base\modelBase
{
      public $deudor=null;  
     public $dateorTimeFields = [
        'fecha' => self::_FDATE,
        /*'fopera1' => self::_FDATE,
          'fval' => self::_FDATE,
           'fval1' => self::_FDATE,*/
       // 'ftermino' => self::_FDATETIME
    ];
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%vw_sigi_kardex_pagos}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['facturacion_id', 'id', 'mes', 'unidad_id', 'edificio_id'], 'integer'],
            [['monto', 'pagado'], 'number'],
            [['anio'], 'string', 'max' => 4],
            [['nombre'], 'string', 'max' => 25],
            [['numero'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'facturacion_id' => Yii::t('app', 'Facturacion ID'),
            'id' => Yii::t('app', 'ID'),
            'anio' => Yii::t('app', 'Anio'),
            'mes' => Yii::t('app', 'Mes'),
            'monto' => Yii::t('app', 'Monto'),
            'nombre' => Yii::t('app', 'Nombre'),
            'unidad_id' => Yii::t('app', 'Unidad ID'),
            'edificio_id' => Yii::t('app', 'Edificio ID'),
            'numero' => Yii::t('app', 'Numero'),
            'pagado' => Yii::t('app', 'Pagado'),
        ];
    }
}
