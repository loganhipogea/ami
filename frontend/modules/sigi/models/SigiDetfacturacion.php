<?php

namespace frontend\modules\sigi\models;

use Yii;

/**
 * This is the model class for table "{{%sigi_detfacturacion}}".
 *
 * @property int $id
 * @property int $cuentaspor_id
 * @property int $edificio_id
 * @property int $unidad_id
 * @property int $colector_id
 * @property int $grupo_id
 * @property string $monto
 * @property string $igv
 * @property string $grupounidad agrupa  todos los objetos: cochera, depositos  en el mismo departamento  
 * @property string $grupofacturacion Agrupa el documento del recibo, ojo lo hace por departametno o apoderado, MUY IMPORTANTES 
 * @property int $facturacion_id
 * @property int $mes
 * @property string $anio
 *
 * @property SigiUnidades $unidad
 * @property SigiEdificios $edificio
 * @property SigiCargosedificio $colector
 * @property SigiCargosgrupoedificio $grupo
 * @property SigiCuentaspor $cuentaspor
 */
class SigiDetfacturacion extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sigi_detfacturacion}}';
    }

    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cuentaspor_id', 'edificio_id', 'unidad_id', 'colector_id', 'grupo_id', 'monto', 'igv', 'grupounidad', 'grupofacturacion', 'facturacion_id', 'mes', 'anio'], 'required'],
            [['cuentaspor_id', 'edificio_id', 'unidad_id', 'colector_id', 'grupo_id', 'facturacion_id', 'mes'], 'integer'],
            [['monto', 'igv'], 'number'],
             [['unidades','codmon','grupounidad_id','grupocobranza','kardex_id','numerorecibo','resumido'], 'safe'],
             [['aacc','participacion','codsuministro','lectura','delta','consumototal','montototal','dias','nuevoprop','resumido'], 'safe'],
            [['grupounidad', 'grupofacturacion'], 'string', 'max' => 12],
            [['anio'], 'string', 'max' => 4],
            [['unidad_id'], 'exist', 'skipOnError' => true, 'targetClass' => SigiUnidades::className(), 'targetAttribute' => ['unidad_id' => 'id']],
            [['edificio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Edificios::className(), 'targetAttribute' => ['edificio_id' => 'id']],
            [['colector_id'], 'exist', 'skipOnError' => true, 'targetClass' => SigiCargosedificio::className(), 'targetAttribute' => ['colector_id' => 'id']],
            [['grupo_id'], 'exist', 'skipOnError' => true, 'targetClass' => SigiCargosgrupoedificio::className(), 'targetAttribute' => ['grupo_id' => 'id']],
            [['cuentaspor_id'], 'exist', 'skipOnError' => true, 'targetClass' => SigiCuentaspor::className(), 'targetAttribute' => ['cuentaspor_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sigi.labels', 'ID'),
            'cuentaspor_id' => Yii::t('sigi.labels', 'Cuentaspor ID'),
            'edificio_id' => Yii::t('sigi.labels', 'Edificio ID'),
            'unidad_id' => Yii::t('sigi.labels', 'Unidad ID'),
            'colector_id' => Yii::t('sigi.labels', 'Colector ID'),
            'grupo_id' => Yii::t('sigi.labels', 'Grupo ID'),
            'monto' => Yii::t('sigi.labels', 'Monto'),
            'igv' => Yii::t('sigi.labels', 'Igv'),
            'grupounidad' => Yii::t('sigi.labels', 'Grupounidad'),
            'grupofacturacion' => Yii::t('sigi.labels', 'Grupofacturacion'),
            'facturacion_id' => Yii::t('sigi.labels', 'Facturacion ID'),
            'mes' => Yii::t('sigi.labels', 'Mes'),
            'anio' => Yii::t('sigi.labels', 'Anio'),
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
        return $this->hasOne(Edificios::className(), ['id' => 'edificio_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColector()
    {
        return $this->hasOne(SigiCargosedificio::className(), ['id' => 'colector_id']);
    }
    
    public function getFacturacion()
    {
        return $this->hasOne(SigiFacturacion::className(), ['id' => 'facturacion_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrupo()
    {
        return $this->hasOne(SigiCargosgrupoedificio::className(), ['id' => 'grupo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCuentaspor()
    {
        return $this->hasOne(SigiCuentaspor::className(), ['id' => 'cuentaspor_id']);
    }

    /**
     * {@inheritdoc}
     * @return SigiDetfacturacionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SigiDetfacturacionQuery(get_called_class());
    }
    
    public static function maxIdentidad(){
        $maximo=static::find()->max('[[identidad]]');
       return (is_null($maximo))?1:$maximo+1;
    }
    
    public static function criteriaDepa($grupo,$mes,$anio,$facturacion_id,$dias){
        return [
            //'edificio_id'=>$this->edificio_id,
            'facturacion_id'=>$facturacion_id,
            'mes'=>$mes,
            'anio'=>$anio,
             'grupofacturacion'=>$grupo,
            'dias'=>$dias,
            ];
    }
    
    public function grupoFacturacion(){
        return static::find()->select([
            'facturacion_id','mes',
            'anio',
             'grupofacturacion'
            ])->distinct()->all();
    }
}
