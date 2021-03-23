<?php

namespace frontend\modules\sigi\models;
use common\models\masters\Documentos;
use common\behaviors\FileBehavior;
use Yii;

/**
 * This is the model class for table "{{%sigi_edificiodocu}}".
 *
 * @property int $id
 * @property int $edificio_id
 * @property string $codocu
 * @property string $nombre
 * @property string $detalle
 *
 * @property Documentos $codocu0
 * @property SigiEdificios $edificio
 */
class SigiEdificiodocus extends \common\models\base\modelBase
{
   public $booleanFields=['importante']; 
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sigi_edificiodocu}}';
    }

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
    public function rules()
    {
        return [
            [['edificio_id', 'codocu','nombre', 'detalle'], 'required'],
            [['edificio_id'], 'integer'],
            [['importante'], 'safe'],
            [['detalle'], 'string'],
            [['codocu'], 'string', 'max' => 3],
            [['nombre'], 'string', 'max' => 60],
            [['codocu'], 'exist', 'skipOnError' => true, 'targetClass' => Documentos::className(), 'targetAttribute' => ['codocu' => 'codocu']],
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
            'codocu' => Yii::t('app', 'Documento'),
            'nombre' => Yii::t('app', 'Nombre'),
            'detalle' => Yii::t('app', 'Detalle'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocumento()
    {
        return $this->hasOne(Documentos::className(), ['codocu' => 'codocu']);
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
     * @return SigiEdificiodocusQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SigiEdificiodocusQuery(get_called_class());
    }
}
