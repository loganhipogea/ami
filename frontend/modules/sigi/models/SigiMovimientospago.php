<?php
namespace frontend\modules\sigi\models;
use Yii;
class SigiMovimientospago extends \common\models\base\modelBase
{
    
     public $booleanFields=['activo'];
    const SCE_CONCILIACION_PAGO='pago';
     public static function tableName()
    {
        return '{{%sigi_movimientospago}}';
    }

    public function rules()
    {
        return [
            [['idop', 'edificio_id', 'cuenta_id', 'tipomov', 'glosa', 'monto', 'pago_id'], 'required'],
            [['idop', 'edificio_id', 'cuenta_id', 'pago_id'], 'integer'],
            [['monto', 'monto_usd', 'igv'], 'number'],
            [['monto'], 'validate_monto'],
            [['monto', 'pago_id'], 'safe'],
            [['fechaprog'], 'string', 'max' => 10],
            [['tipomov'], 'string', 'max' => 3],
            [['glosa'], 'string', 'max' => 40],
           // [['activo', 'ingreso'], 'string', 'max' => 1],
            [['edificio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Edificios::className(), 'targetAttribute' => ['edificio_id' => 'id']],
            [['pago_id'], 'exist', 'skipOnError' => true, 'targetClass' => SigiPorpagar::className(), 'targetAttribute' => ['pago_id' => 'id']],
            [['idop'], 'exist', 'skipOnError' => true, 'targetClass' => SigiMovbanco::className(), 'targetAttribute' => ['idop' => 'id']],
            [['tipomov'], 'exist', 'skipOnError' => true, 'targetClass' => SigiTipomov::className(), 'targetAttribute' => ['tipomov' => 'codigo']],
            
            ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'idop' => Yii::t('app', 'Idop'),
            'edificio_id' => Yii::t('app', 'Edificio ID'),
            'cuenta_id' => Yii::t('app', 'Cuenta ID'),
            'fechaprog' => Yii::t('app', 'Fechaprog'),
            'tipomov' => Yii::t('app', 'Tipomov'),
            'glosa' => Yii::t('app', 'Glosa'),
            'monto' => Yii::t('app', 'Monto'),
            'monto_usd' => Yii::t('app', 'Monto Usd'),
            'igv' => Yii::t('app', 'Igv'),
            'activo' => Yii::t('app', 'Activo'),
            'pago_id' => Yii::t('app', 'Pago ID'),
            'ingreso' => Yii::t('app', 'Ingreso'),
        ];
    }

     public function scenarios() {
         $scenarios = parent::scenarios();
          
          $scenarios[self::SCE_CONCILIACION_PAGO] = [
              'monto_fraccionado',
              'edificio_id', 'cuenta_id',
            'tipomov', 'glosa', 'monto',
             'activo','pago_id','diferencia'
              
              ];
      return $scenarios;
    }
    
    /**
     * {@inheritdoc}
     * @return SigiMovimientospagoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SigiMovimientospagoQuery(get_called_class());
    }
    
    
     public function getTipomov()
    {
        return $this->hasOne(SigiTipomov::className(), ['codigo' => 'tipomov']);
    }
    
    public function getCuenta()
    {
        return $this->hasOne(SigiCuentas::className(), ['id' => 'cuenta_id']);
    }
    
    
    public function getPorPagar()
    {
        return $this->hasOne(SigiPorpagar::className(), ['id' => 'pago_id']);
    }
    public function getEdificio()
    {
        return $this->hasOne(Edificios::className(), ['id' => 'edificio_id']);
    }
    
     public function getMovBanco()
    {
        return $this->hasOne(SigiMovbanco::className(), ['id' => 'idop']);
    }
   
    public function afterSave($insert, $changedAttributes) {
      $this->movBanco->refreshMonto();
      
      return parent::afterSave($insert, $changedAttributes);
   } 
   
   public function validate_monto($attribute,$params){
    if(($this->movBanco->tipoMov->signo > 0 && $this->movBanco->monto < 0) or
     ($this->movBanco->tipoMov->signo < 0 && $this->movBanco->monto > 0) )
      $this->addError($attribute,yii::t('base.labels','{monto} Este monto no tiene el signo que corresponde al movimiento',['monto'=>$this->monto]));
    
    if($this->isNewRecord){
         if($this->monto > ($this->movBanco->monto-$this->movBanco->montoConciliado()))
         $this->addError($attribute,yii::t('base.labels','{monto} Este monto no es consistente con  {monto_movimiento}',['monto_movimiento'=>$this->movBanco->monto,'monto'=>$this->monto]));
                  
      }else{
          /*
           * Si ya hay registro , loque debemos hacer es 
           * restar al conciliado el valor del monto anterior y comparar recein
           */
          if($this->monto > ($this->movBanco->monto-($this->movBanco->montoConciliado()-$this->getOldAttribute('monto'))))
         $this->addError($attribute,yii::t('base.labels','{monto} Este monto no es consistente con  {monto_movimiento} '.$this->getOldAttribute('monto'),['monto_movimiento'=>$this->movBanco->monto,'monto'=>$this->monto]));
          
      }
  }
  
    
}
