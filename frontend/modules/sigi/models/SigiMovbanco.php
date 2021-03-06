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
     
    public $fopera1=null;
     public $monto1=null;
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
            [['cuenta_id'], 'validate_resumen'],
            [['cuenta_id', 'edificio_id', 'fopera', 'monto'], 'required'],
            [['cuenta_id', 'edificio_id', 'noper'], 'integer'],
            [['monto','monto1'], 'double'],
             [['monto'],'validate_monto'],
           
            
            ['monto', 'unique', 'targetAttribute' => 
                 ['cuenta_id','edificio_id', 'fopera','monto'],
              'message'=>yii::t('sta.errors',
                      'Esta combinacion de valores {monto}-{fopera} ya existe',
                      ['monto'=>$this->getAttributeLabel('monto'),
                        //'tipomov'=>$this->getAttributeLabel('tipomov'),
                          'fopera'=>$this->getAttributeLabel('fopera'),
                          //'codcar'=>$this->getAttributeLabel('codcar')
                          ]
                      )
                ],
             [['cuenta_id','monto','descripcion','monto_conciliado','diferencia','detalle'], 'safe'],
            //[['fopera', 'fval'], 'string', 'max' => 10],
            [['descripcion'], 'string', 'max' => 50],
            [['cuenta_id'], 'exist', 'skipOnError' => true, 'targetClass' => SigiCuentas::className(), 'targetAttribute' => ['cuenta_id' => 'id']],
            [['edificio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Edificios::className(), 'targetAttribute' => ['edificio_id' => 'id']],
             //[['tipomov'], 'exist', 'skipOnError' => true, 'targetClass' => SigiTipomov::className(), 'targetAttribute' => ['tipomov' => 'codigo']],
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

     /*public function getTipoMov()
    {
        return $this->hasOne(SigiTipomov::className(), ['codigo' => 'tipomov']);
    }*/
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
       
            return $this->getMovimientosDetalle()->select(['sum(monto)'])->andWhere(['activo'=>'1'])->scalar();
        
        
    }
    
    public function refreshMonto(){
            $signo=($this->monto >=0)?1:-1;
             //echo "salio"; die();
                $this->monto_conciliado=$signo*abs($this->montoConciliado());
                //var_dump($this->monto_conciliado);die();
                $this->diferencia=$signo*(abs($this->monto)-abs($this->monto_conciliado));
               
                
               /*OJO Update All para no despertar el disparador*/
                /* $this->updateAll([
                    'diferencia'=>$this->diferencia,
                    'monto_conciliado'=>$this->monto_conciliado,
                        ],
                ['id'=>$this->id]);*/  
       return $this->save();
    }
    
   
  public function beforeSave($insert) {
      
          if($insert){
          /*Al iniciar la diferencia es la misma que el monto puesto que no se ha conciliado nada*/
          $this->diferencia=$this->monto;
         }
      
      
      return parent::beforeSave($insert);
  }
  
  
  public function afterSave($insert, $changedAttributes) {
      if($insert){
          //aplicamos la transaccion
         $this->cuenta->updateSaldo($this->monto,$this->fopera);
      }else{
          if(in_array('monto', array_keys($changedAttributes))){
           $this->cuenta->updateSaldo($this->monto-$changedAttributes['monto'],$this->fopera);   
        }      }      
      return parent::afterSave($insert, $changedAttributes);
  }
  
  
  public function validate_monto($attribute,$params){
      if(is_string($this->monto) && (strpos($this->monto,',') or strpos($this->monto,"'"))){
          $this->addError($attribute,
                 yii::t('base.errors','Monto tiene un formato inv??lido, elimine las comas o apostrofes en serpador de miles o millones')
                  );
      }
    /*if(($this->monto > 0 && $this->monto < 0) or
     ($this->tipoMov->signo < 0 && $this->monto > 0) )
      $this->addError('monto',yii::t('base.labels','{monto} Este monto no tiene el signo que corresponde al movimiento',['monto'=>$this->monto]));
    */
   return true;
  } 

 public function afterDelete() {
     //var_dump($this->attributes);
     
     /*
      * OJO OBSERVE QUE INVERTIMOS EL MONTO
      * RECORDAR QUE ESTAMOS BORRANDO EL 
      * REGISTRO Y LO QUE TENEMOS QUE HACER ES 
      * DEJAR LAS COSAS COMO ESTABAN ANTES DE 
      * QUE EXISTIERA, POR ESO SE INVIERTE EL SIGNO
      * PARA QUE SE ACTUALIOXE EL SALDO CORRECTAMENTE 
      */
     $this->cuenta->updateSaldo(-$this->monto,
             $this->CarbonNow()->format(\common\helpers\timeHelper::formatMysqlDate())
             );
     return parent::afterDelete();
 }
 /*
  * Determina a que periodo pertenece
  */
 private function determinePeriod(){
   $carbon=$this->toCarbon('fopera');
    $mes= str_pad($carbon->month,2,'0',STR_PAD_LEFT);
    $anio=$carbon->year;
    
     
    if(!is_null($period=SigiEstadocuentas::find()->
            andWhere([
                'mes'=>$mes,
                'anio'=>$anio,
                'edificio_id'=>$this->edificio_id
                    ])->one())){
       return $period->id;
                    }else{
        return null;
                    }
    
 }
 
 public function validate_resumen($attribute,$params){
    
     $resumen_id=$this->determinePeriod();
     if(is_null($resumen_id)){
        $this->adderror('fopera',yii::t('base.errors','La fecha de este mov no pertenece a ning??n periodo v??lido'));
        //return; 
     }     
     $this->resumen_id=$resumen_id;
     
 }
 /*public function beforeValidate() {
     $this->resumen_id=$this->determinePeriod();
     return parent::beforeValidate();
 }*/
 
}
