<?php
namespace frontend\modules\sigi\models;
use Yii;
class SigiTipomov extends \common\models\base\modelBase
{
    const TIPOMOV_DEFAULT='100';
    CONST MOV_AJUSTE='104';
    /**
     * {@inheritdoc}
     */
    public $booleanFields=['conciliable'];
    public static function tableName()
    {
        return '{{%sigi_tipomov}}';
    }
    
    public function rules()
    {
        return [
            [['codigo','descripcion','signo','edificio_id'], 'required'],
           
            [['codigo'], 'string', 'max' => 3],
            [['descripcion'], 'string', 'max' => 40],
            [['codigo'], 'unique'],
             [['edificio_id'], 'safe'],
             [['edificio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Edificios::className(), 'targetAttribute' => ['edificio_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'codigo' => Yii::t('sigi.labels', 'Codigo'),
            'descripcion' => Yii::t('sigi.labels', 'Descripcion'),
        ];
    }

     public function getSigiMovimientos()
    {
        return $this->hasMany(SigiMovimientosPre::className(), ['tipomov' => 'codigo']);
    }

    /**
     * {@inheritdoc}
     * @return SigiTipomovQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SigiTipomovQuery(get_called_class());
    }
    
    public function getIsCobranza(){
        return $this->conciliable && $this->signo > 0;
    }
    
    public function getIsPago(){
        return $this->conciliable && $this->signo < 0;
    }
    
    
    
    
    
}
