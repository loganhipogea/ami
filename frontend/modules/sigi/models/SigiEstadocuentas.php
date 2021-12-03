<?php

namespace frontend\modules\sigi\models;
use frontend\modules\sigi\models\Edificios;
use common\helpers\timeHelper;
use Yii;

/**
 * This is the model class for table "{{%sigi_estadocuentas}}".
 *
 * @property int $id
 * @property int $edificio_id
 * @property int $cuenta_id
 * @property string $saldmesant
 * @property string $ingresos
 * @property string $egresos
 * @property string $saldfinal
 * @property string $saldecuenta
 * @property string $salddif
 * @property string $mes
 * @property string $anio
 *
 * @property SigiEdificios $edificio
 * @property SigiCuentas $cuenta
 */
class SigiEstadocuentas extends \common\models\base\modelBase
{
   const ESTADO_CREADO='CREA';
   const ESTADO_CERRADO='CERR';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sigi_estadocuentas}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['edificio_id',  'mes','anio','cuenta_id'], 'required'],
            [['edificio_id', 'cuenta_id'], 'integer'],
            [['saldmesant', 'ingresos', 'egresos', 'saldfinal', 'saldecuenta', 'salddif'], 'number'],
            [['mes'], 'string', 'max' => 2],
            [['anio'], 'string', 'max' => 4],
            [['anio','mes'], 'unique', 'targetAttribute' => ['anio','mes']],
           
            [['edificio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Edificios::className(), 'targetAttribute' => ['edificio_id' => 'id']],
            [['cuenta_id'], 'exist', 'skipOnError' => true, 'targetClass' => SigiCuentas::className(), 'targetAttribute' => ['cuenta_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'edificio_id' => Yii::t('app', 'Edificio ID'),
            'cuenta_id' => Yii::t('app', 'Cuenta ID'),
            'saldmesant' => Yii::t('app', 'Saldmesant'),
            'ingresos' => Yii::t('app', 'Ingresos'),
            'egresos' => Yii::t('app', 'Egresos'),
            'saldfinal' => Yii::t('app', 'Saldfinal'),
            'saldecuenta' => Yii::t('app', 'Saldecuenta'),
            'salddif' => Yii::t('app', 'Salddif'),
            'mes' => Yii::t('app', 'Mes'),
            'anio' => Yii::t('app', 'Anio'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdificio()
    {
        return $this->hasOne(Edificios::className(), ['id' => 'edificio_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCuenta()
    {
        return $this->hasOne(SigiCuentas::className(), ['id' => 'cuenta_id']);
    }

    /**
     * {@inheritdoc}
     * @return SigiEstadocuentasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SigiEstadocuentasQuery(get_called_class());
    }
    
    public function beforeSave($insert) {
        if($insert)$this->estado=$this::ESTADO_CREADO;
        $this->codigo=$this->anio.$this->mes;
        return parent::beforeSave($insert);
    }
    /*
     * Coloca un where para fiktrar las fechas del periodo*/
     
    public function whereFechas(){
        $limits=timeHelper::bordersDay($this->mes, $this->anio);
        return ['between',$limits[0],$limits[1]];
    }
}
