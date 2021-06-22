<?php
namespace frontend\modules\sigi\models;
use Yii;

/**
 * This is the model class for table "{{%sigi_movbanco}}".
 *
 * @property int $id
 * @property int $cuenta_id
 * @property int $edificio_id
 * @property string $fopera
 * @property string $fval
 * @property string $monto
 * @property int $noper
 * @property string $descripcion
 *
 * @property SigiCuentas $cuenta
 * @property SigiEdificios $edificio
 */
class SigiMovbanco extends \common\models\base\modelBase
{
   
    const SCE_IMPORTACION='importacion';
    const SCE_CORTE='corte';
      const TIPO_NORMAL='N';
       const TIPO_MOVIMIENTO_COBRANZA='10';
      const TIPO_CORTE='C'; //MOVIMIENTO PARA HACER UN CORTE
    public $fopera1=null;
        public $fval1=null;
     public $dateorTimeFields = [
        'fopera' => self::_FDATE,
        'fopera1' => self::_FDATE,
          'fval' => self::_FDATE,
           'fval1' => self::_FDATE,
       // 'ftermino' => self::_FDATETIME
    ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sigi_movbanco}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cuenta_id', 'edificio_id', 'fopera', 'monto','tipomov'], 'required'],
            [['cuenta_id', 'edificio_id', 'noper'], 'integer'],
            [['monto'], 'number'],
             [['monto'],'validate_monto'],
             [['tipomov','cuenta_id','monto','descripcion','monto_conciliado','diferencia'], 'safe'],
            //[['fopera', 'fval'], 'string', 'max' => 10],
            [['descripcion'], 'string', 'max' => 30],
            [['cuenta_id'], 'exist', 'skipOnError' => true, 'targetClass' => SigiCuentas::className(), 'targetAttribute' => ['cuenta_id' => 'id']],
            [['edificio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Edificios::className(), 'targetAttribute' => ['edificio_id' => 'id']],
             [['tipomov'], 'exist', 'skipOnError' => true, 'targetClass' => SigiTipomov::className(), 'targetAttribute' => ['tipomov' => 'codigo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sigi.labels', 'ID'),
            'cuenta_id' => Yii::t('sigi.labels', 'Cuenta ID'),
            'edificio_id' => Yii::t('sigi.labels', 'Edificio ID'),
            'fopera' => Yii::t('sigi.labels', 'Fopera'),
            'fval' => Yii::t('sigi.labels', 'Fval'),
            'monto' => Yii::t('sigi.labels', 'Monto'),
            'noper' => Yii::t('sigi.labels', 'Noper'),
            'descripcion' => Yii::t('sigi.labels', 'Descripcion'),
        ];
    }

    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios[self::SCE_IMPORTACION] = [ 'cuenta_id', 'edificio_id', 'fopera', 'monto', 'noper', 'descripcion'];
         $scenarios[self::SCE_CORTE] = [ 'cuenta_id', 'edificio_id', 'fopera','monto',  'descripcion'];
        
        return $scenarios;
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCuenta()
    {
        return $this->hasOne(SigiCuentas::className(), ['id' => 'cuenta_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdificio()
    {
        return $this->hasOne(Edificios::className(), ['id' => 'edificio_id']);
    }

     public function getTipoMov()
    {
        return $this->hasOne(SigiTipomov::className(), ['codigo' => 'tipomov']);
    }
    /**
     * {@inheritdoc}
     * @return SigiMovbancoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SigiMovbancoQuery(get_called_class());
    }
    
    
    
    
     public function getMovimientosDetalle()
    {
        return $this->hasMany(SigiMovimientosPre::className(), ['idop' => 'id']);
    }
    
    
    public function getMovimientosDetallePago()
    {
        return $this->hasMany(SigiMovimientospago::className(), ['idop' => 'id']);
    }
    /*
     * Suma los montos conciliados con 
     * elrecibo del kardex, mediante la tabla SigiMovimientosPre
     */
    public function montoConciliado(){
      // echo  $this->getMovimientosDetalle()->select(['sum(monto)'])->createCommand()->rawSql;die();
        if($this->tipoMov->isCobranza){
            return $this->getMovimientosDetalle()->select(['sum(monto)'])->andWhere(['activo'=>'1'])->scalar();
        }elseif($this->tipoMov->isPago){
           return abs($this->getMovimientosDetallePago()->select(['sum(monto)'])->andWhere(['activo'=>'1'])->scalar()); 
        }else{
            
        }
        
    }
    
    public function refreshMonto(){
         if($this->tipoMov->conciliable){
             //echo "salio"; die();
                $this->monto_conciliado=$this->tipoMov->signo*abs($this->montoConciliado());
                //var_dump($this->monto_conciliado);die();
                $this->diferencia=$this->tipoMov->signo*(abs($this->monto)-abs($this->monto_conciliado));
                /*Update All para no despertar el disparador*/
                $this->updateAll([
                    'diferencia'=>$this->monto-$this->monto_conciliado,
                    'monto_conciliado'=>$this->monto_conciliado,
                        ],
                ['id'=>$this->id]);
         }
      // return $this->save();
       return true;
    }
    
   
  public function beforeSave($insert) {
      if($this->tipomov==self::TIPO_MOVIMIENTO_COBRANZA){
          if($insert){
          /*Al iniciar la diferencia es la misma que el monto puesto que no se ha conciliado nada*/
          $this->diferencia=$this->monto;
         }
      }else{
         $this->diferencia=0; 
      }
      
      return parent::beforeSave($insert);
  }
  
  public function validate_monto($attribute,$params){
    if(($this->tipoMov->signo > 0 && $this->monto < 0) or
     ($this->tipoMov->signo < 0 && $this->monto > 0) )
      $this->addError('monto',yii::t('base.labels','{monto} Este monto no tiene el signo que corresponde al movimiento',['monto'=>$this->monto]));
    
   
  } 
}
