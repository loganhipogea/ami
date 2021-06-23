<?php

namespace frontend\modules\sigi\models;
use common\behaviors\FileBehavior;
use common\models\masters\Clipro;
use common\widgets\selectwidget\selectWidget;
use Yii;

/**
 * This is the model class for table "{{%sigi_porpagar}}".
 *
 * @property int $id
 * @property string $codocu
 * @property int $edificio_id
 * @property int $unidad_id
 * @property string $monto
 * @property string $igv
 * @property string $codpresup
 * @property string $monto_usd
 * @property string $glosa
 * @property string $fechadoc
 * @property string $codestado
 * @property string $detalle
 *
 * @property SigiEdificios $edificio
 */
class SigiPorpagar extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    
    const ESTADO_CREADO='10';
    const ESTADO_ANULADO='99';
    const ESTADO_PROGRAMADO='20';
    const SCE_ESTADO='estado';
    public $dateorTimeFields=[
        'fechaprog'=>self::_FDATE,
         'fechadoc'=>self::_FDATE,
         'fechaprog1'=>self::_FDATE
    ];
    public $fechaprog1=null;
    public $monto1=null;
    public static function tableName()
    {
        return '{{%sigi_porpagar}}';
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
            [['codocu', 'edificio_id','codpro',  'monto','cargoedificio_id',   'glosa', 'fechadoc','codmon','fechaprog'], 'required'],
            [['edificio_id', 'unidad_id'], 'integer'],
            [['monto', 'igv', 'monto_usd'], 'number'],
            [['detalle'], 'string'],
            // [['numdocu'], 'safe'],
            [['fechaprog'], 'validate_fechas'],
             [['fechaprog'], 'validate_programacion'],
            [['codmon','codpro','fechaprog','cuenta_id','numdocu'], 'safe'],
            [['codocu'], 'string', 'max' => 3],
            [['codpresup', 'fechadoc'], 'string', 'max' => 10],
             [['numdocu'], 'string', 'max' => 30],
            [['glosa'], 'string', 'max' => 40],
            [['codestado'], 'string', 'max' => 2],
            [['edificio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Edificios::className(), 'targetAttribute' => ['edificio_id' => 'id']],
        ];
    }
public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios[self::SCE_ESTADO] = [
            'codestado',
            ];
       return $scenarios;
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sigi.labels', 'ID'),
            'codocu' => Yii::t('sigi.labels', 'Documento'),
            'codpro' => Yii::t('sigi.labels', 'Proveedor'),
            'edificio_id' => Yii::t('sigi.labels', 'Edificio'),
            'unidad_id' => Yii::t('sigi.labels', 'Unidad'),
            'monto' => Yii::t('sigi.labels', 'Monto'),
              'monto1' => Yii::t('sigi.labels', 'Monto'),
            'igv' => Yii::t('sigi.labels', 'Igv'),
            'codpresup' => Yii::t('sigi.labels', 'Codpresup'),
            'monto_usd' => Yii::t('sigi.labels', 'Monto Usd'),
            'glosa' => Yii::t('sigi.labels', 'Glosa'),
            'fechadoc' => Yii::t('sigi.labels', 'F Doc'),
             'fechaprog' => Yii::t('sigi.labels', 'F Pago'),
             'fechaprog1' => Yii::t('sigi.labels', 'F Pago'),
            'codestado' => Yii::t('sigi.labels', 'Codestado'),
            'detalle' => Yii::t('sigi.labels', 'Detalle'),
             'numdocu' => Yii::t('sigi.labels', 'Número Doc'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdificio()
    {
        return $this->hasOne(Edificios::className(), ['id' => 'edificio_id']);
    }
    
     public function getDocumento()
    {
        return $this->hasOne(\common\models\masters\Documentos::className(), ['codocu' => 'codocu']);
    }
 public function getClipro()
    {
        return $this->hasOne(Clipro::className(), ['codpro' => 'codpro']);
    }
    
    
   public function getCargoEdificio()
    {
        return $this->hasOne(SigiCargosedificio::className(), ['id' => 'cargoedificio_id']);
    }  
    
    
 public function getProgramaPagos()
    {
        return $this->hasMany(SigiPropago::className(), ['porpagar_id' => 'id']);
    }
    
  public function getMovimientosPago()
    {
        return $this->hasMany(SigiMovimientospago::className(), ['pago_id' => 'id']);
    }
    /**
     * {@inheritdoc}
     * @return SigiPorpagarQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SigiPorpagarQuery(get_called_class());
    }
    
    /*
     * PRGARA UNPAGO
     * PARA ESTO CREA UN REGISTRO EN LA TABLA 
     * sigi_propago
     * PARA QUE SE REALIZAE EL DESEMBOLSO
     * CANBIA EL ESTADO A '20'
     */
    public function programarPago(){
        //validando la fecha 
        if(!$this->isDateValid('fechaprog') ){
             $this->addError('fechaprog',yii::t('sigi.errors','La fecha de programación está vacía'));
           
           return false;  
        }
        if($this->toCarbon('fechaprog')->lt($this->toCarbon('fechadoc'))){
            $this->addError('fechaprog',yii::t('sigi.errors','La fecha de programación {fechaprog} es anterior a la fecha {fechadoc} del documento',['fechaprog'=>$this->fechaprog,'fechadoc'=>$this->fechadoc]));
            return false;
        }
        
        if(!$this->hasPrograma()){
                $OldScenario=$this->getScenario();
                $this->setScenario(self::SCE_ESTADO);
                $this->codestado=self::ESTADO_PROGRAMADO;
               
                $this->save();
                
                 SigiPropago::firstOrCreateStatic(
                        $this->prepareAttributesProgra(),
                        SigiPropago::SCE_AUTO
                        );
                $this->setScenario($OldScenario);
              return true;
        }else{
            $this->addError('fechaprog',yii::t('sigi.labels','Ya hay un registro programado para este documento'));
            return false;
        }
        
    }
    
    public function RevertProgramaPago(){
        if($this->hasPrograma()){
                $OldScenario=$this->getScenario();
                $this->setScenario(self::SCE_ESTADO);
                $this->codestado=self::ESTADO_CREADO;
                 $modeloProg=SigiPropago::findOne([
                    'porpagar_id'=>$this->id,
                    'codestado'=>SigiPropago::ESTADO_CREADO,
                    ]);
                if(is_null($modeloProg)){
                      $this->addError('fechaprog',yii::t('sigi.labels','No hay nada que revertir, o ya se ha efectuado el pago de este documento'));
                    return false;
                }
                $modeloProg->setScenario($modeloProg::SCE_ESTADO);
                $modeloProg->codestado=$modeloProg::ESTADO_ANULADO;
                $modeloProg->save();
               
                $this->setScenario($OldScenario);
              return true;
        }else{
                        $this->addError('fechaprog',yii::t('sigi.labels','No hay un registro programado para este documento'));
            return false;
        }
        
        
    }
    
    public function beforeSave($insert) {
      if($insert){
          $this->codestado=self::ESTADO_CREADO;
      }
        return parent::beforeSave($insert);
    }
    
   
    
    private function prepareAttributesProgra(){
        return [
            'porpagar_id'=>$this->id,
            'edificio_id'=>$this->edificio_id,
             'cuenta_id'=>$this->edificio->cuentaActiva()->id,
            'fechaprog'=>$this->fechaprog,
            'codestado'=> SigiPropago::ESTADO_CREADO,
        ];
    }
    
    public function validate_fechas($attribute, $params){
        if($this->isDateValid('fechaprog') )
        if($this->toCarbon('fechaprog')->lt($this->toCarbon('fechadoc'))){
             $this->addError('fechaprog',yii::t('sigi.errors','La fecha de programación {fechaprog} es anterior a la fecha {fechadoc} del documento',['fechaprog'=>$this->fechaprog,'fechadoc'=>$this->fechadoc]));
            
        }
    }
    
    public function validate_programacion($attribute, $params){
      if($this->hasPrograma() && $this->hasChanged()){
          $this->addError('fechaprog',yii::t('sigi.labels','Este documento ya ha sido programado o pagado, no puede haber modificaciones'));
      }
    }
    /*
     * Verifica si tiene un pago programado  o pagado
     * En este caso a no e seditable
     */
    
     
    public function hasPrograma(){        
        return $this->getProgramaPagos()
                ->andWhere(['codestado'=> SigiPropago::estadosValidos()])->
                exists();
    }
    
     public function montoConciliado(){
      // echo  $this->getMovimientosDetalle()->select(['sum(monto)'])->createCommand()->rawSql;die();
        return $this->getProgramaPagos()->select(['sum(monto)'])->scalar();
    }
    
     public function montoPagado(){
      // echo  $this->getMovimientosDetalle()->select(['sum(monto)'])->createCommand()->rawSql;die();
        return $this->getMovimientosPago()->select(['sum(monto)'])->andWhere(['activo'=>'1'])->scalar();
    }
    
}
