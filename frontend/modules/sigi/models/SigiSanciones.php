<?php

namespace frontend\modules\sigi\models;
use frontend\modules\sigi\behaviors\FileBehavior;
use Yii;

/**
 * This is the model class for table "{{%sigi_multas}}".
 *
 * @property int $id
 * @property int $edificio_id
 * @property int $unidad_id
 * @property int $unidad_id_ocurrencia
 * @property int $propietario_id
 * @property string $fecha
 * @property string $focurrencia
 * @property string $activo
 * @property string $tipo
 * @property string $descripcion
 * @property string $monto
 * @property string $detalle
 *
 * @property SigiUnidades $unidad
 * @property SigiEdificios $edificio
 */
class SigiSanciones extends \common\models\base\modelBase
{
   public $fecha1=null;
   public $focurrencia1=null;
    public $monto1=null;
    
    public $dateorTimeFields=[
        'fecha'=>self::_FDATE,
         'fecha1'=>self::_FDATE,
         'focurrencia'=>self::_FDATETIME,
         'focurrencia1'=>self::_FDATETIME
    ];
    
     public function behaviors()
    {
	return [		
		'fileBehavior' => [
			'class' => FileBehavior::className()
		]		
	];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sigi_multas}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['edificio_id', 'unidad_id',  'propietario_id', 'tipo', 'descripcion', 'monto','focurrencia','fecha'], 'required'],
            [['edificio_id', 'unidad_id', 'unidad_id_ocurrencia', 'propietario_id'], 'integer'],
            [['monto'], 'number'],
            [['detalle'], 'string'],
             [['fecha1','focurrencia1','monto1','detalle'], 'safe'],
            [['fecha'], 'string', 'max' => 10],
            [['focurrencia'], 'string', 'max' => 19],
            [['activo'], 'string', 'max' => 1],
            [['tipo'], 'string', 'max' => 3],
            [['descripcion'], 'string', 'max' => 40],
            [['unidad_id'], 'exist', 'skipOnError' => true, 'targetClass' => SigiUnidades::className(), 'targetAttribute' => ['unidad_id' => 'id']],
            [['edificio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Edificios::className(), 'targetAttribute' => ['edificio_id' => 'id']],
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
            'unidad_id' => Yii::t('app', 'Unidad ID'),
            'unidad_id_ocurrencia' => Yii::t('app', 'Unidad Id Ocurrencia'),
            'propietario_id' => Yii::t('app', 'Propietario ID'),
            'fecha' => Yii::t('app', 'Fecha'),
            'focurrencia' => Yii::t('app', 'Focurrencia'),
            'activo' => Yii::t('app', 'Activo'),
            'tipo' => Yii::t('app', 'Tipo'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'monto' => Yii::t('app', 'Monto'),
            'detalle' => Yii::t('app', 'Detalle'),
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
     * {@inheritdoc}
     * @return SigiSancionesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SigiSancionesQuery(get_called_class());
    }
}
