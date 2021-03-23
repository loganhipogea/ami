<?php

namespace frontend\modules\sigi\models;
use frontend\modules\sigi\behaviors\FileBehavior_residente;
use frontend\modules\sigi\models\SigiKardexdepa;
use Yii;

/**
 * This is the model class for table "{{%vw_sigi_kardexdepa}}".
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
 * @property string $nombre
 * @property string $numero
 * @property string $codtipo
 * @property string $desunidad
 */
class VwSigiKardexdepa extends \common\models\base\modelBase
{
   
    public $fecha1=null;
    public $booleanFields = ['cancelado'];
    public $dateorTimeFields = [
        'fecha' => self::_FDATE,
       // 'finicio' => self::_FDATETIME,
        //'ftermino' => self::_FDATETIME
    ];
    
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%vw_sigi_kardexdepa}}';
    }

    
    
   
    public $monto_calculado;
   // public $convertTimes=false;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'facturacion_id', 'operacion_id', 'edificio_id', 'unidad_id', 'mes'], 'integer'],
            [['facturacion_id', 'edificio_id', 'unidad_id', 'mes', 'fecha', 'anio', 'nombre', 'numero', 'codtipo', 'desunidad'], 'required'],
            [['monto', 'igv'], 'number'],
            [['detalles'], 'string'],
            [['fecha'], 'string', 'max' => 10],
            [['anio', 'codtipo'], 'string', 'max' => 4],
            [['codmon'], 'string', 'max' => 3],
            [['numerorecibo', 'numero'], 'string', 'max' => 12],
            [['nombre'], 'string', 'max' => 25],
            [['desunidad'], 'string', 'max' => 40],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sigi.labels', 'ID'),
            'facturacion_id' => Yii::t('sigi.labels', 'Facturacion ID'),
            'operacion_id' => Yii::t('sigi.labels', 'Operacion ID'),
            'edificio_id' => Yii::t('sigi.labels', 'Edificio ID'),
            'unidad_id' => Yii::t('sigi.labels', 'Unidad ID'),
            'mes' => Yii::t('sigi.labels', 'Mes'),
            'fecha' => Yii::t('sigi.labels', 'Fecha'),
            'anio' => Yii::t('sigi.labels', 'Anio'),
            'codmon' => Yii::t('sigi.labels', 'Codmon'),
            'numerorecibo' => Yii::t('sigi.labels', 'Numerorecibo'),
            'monto' => Yii::t('sigi.labels', 'Monto'),
            'igv' => Yii::t('sigi.labels', 'Igv'),
            'detalles' => Yii::t('sigi.labels', 'Detalles'),
            'nombre' => Yii::t('sigi.labels', 'Nombre'),
            'numero' => Yii::t('sigi.labels', 'Numero'),
            'codtipo' => Yii::t('sigi.labels', 'Codtipo'),
            'desunidad' => Yii::t('sigi.labels', 'Desunidad'),
        ];
    }

    public function getEdificio()
    {
        return $this->hasOne(Edificios::className(), ['id' => 'edificio_id']);
    }
    
    public function getKardexDepa(){
         return SigiKardexDepa::findOne($this->id);
    }
    
    /**
     * {@inheritdoc}
     * @return VwSigiKardexdepaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VwSigiKardexdepaQuery(get_called_class());
    }
    
    public function getMonto(){
        return SigiDetfacturacion::find()->select('sum(monto)')->where(
                [
                    'facturacion_id'=>$this->facturacion_id,
                    'kardex_id'=>$this->id,
                ])->scalar();
    }
    
    public function getSigiKardexDepa(){
        return SigiKardexdepa::findOne($this->id);
    }
    
    /*
     * para que cumpla con el procedimieto del Actionselectimage
     */
    
   /* public function save($runValidation = true, $attributeNames = NULL){
        return true;
    }*/
    
    /*public function  triggerUpload(){
      yii::error('trigger');
    }*/
  
  
    
}
