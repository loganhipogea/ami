<?php

namespace frontend\modules\sigi\models;

use Yii;

/**
 * This is the model class for table "{{%sigi_cargosgrupoedificio}}".
 *
 * @property int $edificio_id
 * @property string $codgrupo
 * @property string $descripcion
 * @property string $activo
 *
 * @property SigiCargosedificio[] $sigiCargosedificios
 * @property SigiEdificios $edificio
 */
class SigiCargosgrupoedificio extends \common\models\base\modelBase
{
    
    public $booleanFields = ['egreso'];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sigi_cargosgrupoedificio}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['edificio_id','descripcion'], 'required'],
            [['edificio_id'], 'integer'],
            [['egreso'], 'safe'],
            [['codgrupo'], 'string', 'max' => 3],
            [['descripcion'], 'string', 'max' => 40],
            [['activo'], 'string', 'max' => 1],
            [['codgrupo'], 'unique'],
            [['edificio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Edificios::className(), 'targetAttribute' => ['edificio_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'edificio_id' => Yii::t('app', 'Edificio ID'),
            'codgrupo' => Yii::t('app', 'Codgrupo'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'activo' => Yii::t('app', 'Activo'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColectores()
    {
        return $this->hasMany(SigiCargosedificio::className(), ['grupo_id' => 'id']);
    }
    
     public function getSigiCargosedificios()
    {
        return $this->hasMany(SigiCargosedificio::className(), ['grupo_id' => 'id']);
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
     * @return SigiCargosgrupoedificioQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SigiCargosgrupoedificioQuery(get_called_class());
    }
    
    public function beforeSave($insert) {
        if($insert){
            //$this->codgrupo=$this->correlativo('codgrupo');
        }
        RETURN parent::beforeSave($insert);
    }
}
