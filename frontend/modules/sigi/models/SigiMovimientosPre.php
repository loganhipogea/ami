<?php

namespace frontend\modules\sigi\models;
use common\behaviors\FileBehavior;
use frontend\modules\message\models\Message;
use common\helpers\h;
use Yii;

/**
 * This is the model class for table "{{%sigi_movimientos}}".
 *
 * @property int $id
 * @property int $idop
 * @property int $edificio_id
 * @property int $cuenta_id
 * @property string $fechaop
 * @property string $fechacre
 * @property string $tipomov
 * @property string $glosa
 * @property string $monto
 * @property string $igv
 * @property string $monto_usd
 * @property int $user_id
 * @property string $activo
 *
 * @property SigiCuentas $cuenta
 * @property SigiTipomov $tipomov0
 * @property SigiEdificios $edificio
 */
class SigiMovimientosPre extends \common\models\base\modelBase
{
   const SCE_CREACION_BASICA='basico';
    const SCE_STATUS='status';
    
    /*ESCENARIOS PARA CONCILIACIO*/
    const SCE_CONCILIACION_PAGO='fraccion';      
    const SCE_CONCILIACION_PAGO_DOC_IMPUTADO='inputado';
    const SCE_CONCILIACION_PAGO_DOC_GENERAL='general';
    /********FIN DE ESCENARIOS CONCILAICION*********/
    
    
    
    
    
    const G_GRUPO_INGRESOS='C';//Cobranzas
    const G_GRUPO_EGRESOS='P';//Pagos
    const MOV_PAGOS='10';
     
     const MOV_COBROS='50';
   
    public $booleanFields=['activo','ingreso'];
    public $dateorTimeFields = [
        'fechaop' => self::_FDATE,
        'fechaop1' => self::_FDATE,
       'fechaprog' => self::_FDATE,
        //'ftermino' => self::_FDATETIME
    ];
    
   public $monto_fraccionado=0;
    public $fechaop1=null;
    
   public static function movimientos(){
       return [
           
       ];
   }
   
   
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sigi_movimientos}}';
    }

     public function behaviors()
         { 
          return [		
		        'fileBehavior' => [
			     'class' => FileBehavior::className()
		           ],
                    ];
         }
    
    
     public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios[self::SCE_CREACION_BASICA] = [
            'edificio_id', 'cuenta_id',
            'tipomov', 'glosa', 'monto',
             'activo','kardex_id','diferencia'
            ];
         $scenarios[self::SCE_STATUS] = ['activo'];
         
         
          $scenarios[self::SCE_CONCILIACION_PAGO] = [
              'monto_fraccionado',
              'edificio_id', 'cuenta_id',
            'tipomov', 'glosa', 'monto',
             'activo','kardex_id','diferencia'
              
              ];
          
          $scenarios[self::SCE_CONCILIACION_PAGO] = [
              'monto_fraccionado',
              'edificio_id', 'cuenta_id',
            'tipomov', 'glosa', 'monto',
             'activo','kardex_id','diferencia'
              
              ];
       /* $scenarios[self::SCENARIO_ASISTIO] = ['asistio'];
        $scenarios[self::SCENARIO_PSICO] = ['codtra'];
        $scenarios[self::SCENARIO_ACTIVO] = ['activo'];
        $scenarios[self::SCENARIO_REPROGRAMA] = ['fechaprog', 'duracion', 'finicio', 'ftermino', 'codtra'];
        */return $scenarios;
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idop', 'edificio_id', 'cuenta_id', 'user_id'], 'integer'],
            [['edificio_id', 'cuenta_id', /*'fechaop',*/  'tipomov', 'glosa',  /*'igv',*/  'activo'], 'required'],
           // [['monto'],'required', 'except'=>self::SCE_CONCILIACION_PAGO],
            [['monto', 'igv', 'monto_usd'], 'number'],
           // [['fechaop'], 'string', 'max' => 10],
            [['kardex_id','monto','diferencia','ingreso','unidad_id'], 'safe'],
         
             [['monto'], 'validate_monto'],
            [['monto_conciliado'], 'safe'],
            [['monto'], 'validate_monto_fraccionado',/*'on'=>self::SCE_CONCILIACION_PAGO*/],
           
            /*CAMPOS REQUERIDOS SEGUN ESCENARIO*/
            [['kardex_id'], 'required','on'=>self::SCE_CONCILIACION_PAGO],
            [['doc_id'], 'required',
                'on'=>[
                    self::SCE_CONCILIACION_PAGO_DOC_GENERAL,
                    self::SCE_CONCILIACION_PAGO_DOC_IMPUTADO
                    ]],
            
            //[['unidad_id'], 'required','on'=>self::SCE_CONCILIACION_PAGO_DOC_IMPUTADO],
            /*FIN DE CAMPOS REQUERIDOS SEGUN ESCENARIO*/
            
            
            [['fechacre'], 'string', 'max' => 19],
            [['tipomov'], 'string', 'max' => 3],
            [['glosa'], 'string', 'max' => 40],
            //[['activo'], 'string', 'max' => 1],
            [['cuenta_id'], 'exist', 'skipOnError' => true, 'targetClass' => SigiCuentas::className(), 'targetAttribute' => ['cuenta_id' => 'id']],
            //[['tipomov'], 'exist', 'skipOnError' => true, 'targetClass' => SigiTipomov::className(), 'targetAttribute' => ['tipomov' => 'codigo']],
            [['edificio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Edificios::className(), 'targetAttribute' => ['edificio_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sigi.labels', 'ID'),
            'idop' => Yii::t('sigi.labels', 'Idop'),
            'edificio_id' => Yii::t('sigi.labels', 'Edificio ID'),
            'cuenta_id' => Yii::t('sigi.labels', 'Cuenta ID'),
            'fechaop' => Yii::t('sigi.labels', 'Fechaop'),
            'fechacre' => Yii::t('sigi.labels', 'Fechacre'),
            'tipomov' => Yii::t('sigi.labels', 'Tipomov'),
            'glosa' => Yii::t('sigi.labels', 'Glosa'),
            'monto' => Yii::t('sigi.labels', 'Monto'),
            'igv' => Yii::t('sigi.labels', 'Igv'),
            'monto_usd' => Yii::t('sigi.labels', 'Monto Usd'),
            'user_id' => Yii::t('sigi.labels', 'User ID'),
            'activo' => Yii::t('sigi.labels', 'Activo'),
        ];
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
    public function getTipomov()
    {
        return $this->hasOne(SigiTipomov::className(), ['codigo' => 'tipomov']);
    }
    
    public function getKardex()
    {
        if($this->isKardex()){
           return $this->hasOne(SigiKardexdepa::className(), ['id' => 'kardex_id']);
 
        }elseif($this->isDocPago()){
            return $this->hasOne(SigiPorpagar::className(), ['id' => 'doc_id']);
 
        }elseif($this->isDocCobro()){
            //yii::error('ES UN COBRO ',__FUNCTION__);
            return $this->hasOne(SigiPorCobrar::className(), ['id' => 'doc_id']);
 
        }else{
            return null;
        }
            
      
     }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdificio()
    {
        return $this->hasOne(Edificios::className(), ['id' => 'edificio_id']);
    }
    
    
    
    
     public function getMovBanco()
    {
        return $this->hasOne(SigiMovbanco::className(), ['id' => 'idop']);
    }

    /**
     * {@inheritdoc}
     * @return SigiMovimientosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SigiMovimientosPreQuery(get_called_class());
    }
    
    public static function createBasic($attributes){
       // $oldScenario=$model->getScenario();
        $verifyAttributes=[
            'kardex_id'=>$attributes['kardex_id'],
            'tipomov'=>$attributes['tipomov'],
            ];
        self::firstOrCreateStatic($attributes,
                self::SCE_CREACION_BASICA,
                $verifyAttributes);
        
        
    }
    
    
  /*
   * ESTA FUNCION SE ENCARGA DE SICRONIZAR
   */
  
 
 
  
    
  public function beforeSave($insert) {
      if($insert){
          $this->ingreso=true;
          IF(empty($this->fechaop))$this->fechaop=
            self::SwichtFormatDate (self::CarbonNow()->format(\common\helpers\timeHelper::formatMysqlDate()),'date',true);
            if($this->isKardex()){
                 $this->unidad_id=$this->kardex->unidad_id;
               // $this->sincronizeKardex($insert); 
            }
           
      }
      
      
      
    //  var_dump($this->kardex_id,$this->kardex->monto);die();
      //Le sumamos el monto actual, porque aun no graba
     // $this->diferencia=$this->kardex->monto-($this->cancelado()+$this->monto);       
      return parent::beforeSave($insert);
  }  
  
  public function afterSave($insert, $changedAttributes) {
      yii::error('after save ',__FUNCTION__);
      if($insert){
         // $this->refreshAttachment();
      }
      
      /*Sólo si se trata de una aprobación del movimiento*/
      if( !$insert && in_array('activo', array_keys($changedAttributes))){
          yii::error('si s emodifico el esdtado ',__FUNCTION__);
        if($this->isKardex())$this->kardex->cancelar();
        
        $this->movBanco->refreshMonto();   
      }
      return parent::afterSave($insert, $changedAttributes);
  }
  
  public function afterDelete() {
       $this->movBanco->refreshMonto();
       /*
        * Ya no se refrescan $this->kardex->cancelar();
        * porque se supone que solo se pueden borrar 
        * registros que aun no han tenido ningun efecto dobre 
        * el kardex (activo=0)
        */
      return parent::afterDelete();
  }
  
  
  
  public function validate_monto_fraccionado($attribute,$params){
      $movBanco=$this->movBanco;
         $montoconciliado=$movBanco->montoConciliado();
      $signo=($this->monto>0)?1:-1;
      //if($this->isNewRecord){
         
         $diferencia=abs(abs($movBanco->monto)
                -abs($montoconciliado));
         if(abs($this->monto) > $diferencia)
         $this->addError($attribute,
          yii::t('base.labels',
              ' Este monto {monto} sobrepasa el monto pendiente a conciliar:  {monto_movimiento}',
                  ['monto_movimiento'=>$diferencia,'monto'=>$this->monto]));
        
        /*Aohra verificando los kardex*/
         if($this->isKardex()){
             $kardex=$this->kardex;
            if($this->monto > $kardex->deuda()){
              $this->addError($attribute, yii::t('base.labels',
              ' Este monto {monto} sobrepasa el monto pendiente a conciliar en el Kardex:  {monto_movimiento}',
                  ['monto_movimiento'=>$kardex->deuda(),'monto'=>$this->monto]));
          
            }
             
             
         }
         
         
      //}/*else{
          /*
           * Si ya hay registro , loque debemos hacer es 
           * restar al conciliado el valor del monto anterior y comparar recein
           */
          /*$montoconciliado=$montoconciliado-$this->getOldAttribute('monto');
          
          $diferencia=abs(abs($movBanco->monto)-abs($montoconciliado));
          if(abs($this->monto) > $diferencia)
         $this->addError($attribute,yii::t('base.labels',
              ' Este monto {monto} sobrepasa el monto pendiente a conciliar:  {monto_movimiento}',
                  ['monto_movimiento'=>$diferencia,'monto'=>$this->monto]));
         */      
    }
  
  /*
 
  
 /*
  * Verifica que exista un voucher subido por
  * el usuario en el modelo VwSigiKardex
  * file[1],file[2]
  * SI existe lo borra y lo adjunta al este modelo
  */
public function refreshAttachment(){
  $kardex= $this->kardex; 
  if($kardex->countFiles()>1){
       /*yii::error('eL NOMBRE DEL ARCHIVO ES ',__FUNCTION__);
        yii::error($kardex->files[1]->name,__FUNCTION__);*/
     $this->attachFromPath($kardex->files[1]->path);
       // yii::error($kardex->files[1]->path,__FUNCTION__);
      $kardex->deleteFile($kardex->files[1]->id);
     
      Message::compose(h::userId(),
              $kardex->unidad->idUser(),
              'Se ha recibido el Voucher de '.\common\helpers\timeHelper::mes($kardex->mes).' ',
               ' adjuntaste un Archivo que debe corresponder a un voucher de pago.'
              . ' Este documento ya ha sido abierto por la administración, y está'
              . ' en proceso de revisión. Muchas Gracias ');
      return true;
  }else{
      return false;
  }
}
  
public function validate_monto($attribute,$params){
    if(($this->movBanco->monto >= 0 && $this->monto < 0) or
     ($this->movBanco->monto < 0 && $this->monto > 0) )
      $this->addError($attribute,yii::t('base.labels','{monto} Este monto no tiene el signo que corresponde al movimiento',['monto'=>$this->monto]));
    
    
    if(abs($this->monto) > abs($this->movBanco->monto))
     $this->addError($attribute,yii::t('base.labels','Este monto {monto}  es mayor al monto {montob} del movimiento del banco',['monto'=>$this->monto,'montob'=>$this->movBanco->monto]));
    
   }
   
   public function isKardex(){ 
      return ($this->kardex_id >0);
  } 
 public function isDocPago(){
      return ($this->doc_id >0 && $this->ingreso =='0');
  } 
  
  public function isDocCobro(){
      return ($this->doc_id >0 && $this->ingreso=='1');
  } 
  
  /*
   * ESTA FUNCION VERIFICA
   * Si esta afectando el estado de cuenta de una unidad
   * por ejemplo una multa, una sancion o un vale de credito
   * o una devolución de dinero
   */
   private function isDocAfectaSaldoUnidad(){
      return ($this->doc_id >0 && $this->unidad_id > 0);
  } 
  
}
