<?php

namespace frontend\modules\sigi\models;
USE frontend\modules\report\models\Reporte;
use frontend\modules\sigi\behaviors\FileBehavior;
use frontend\modules\sigi\behaviors\FileBehavior_residente;
use common\helpers\timeHelper;
use common\helpers\h;
use Yii;

/**
 * This is the model class for table "{{%sigi_kardexdepa}}".
 *
 * @property int $id
 * @property int $facturacion_id
 * @property int $operacion_id Numero de operacion del banco, para abonos  
 * @property int $edificio_id
 * @property int $unidad_id
 * @property int $mes
 * @property string $fecha
 * @property string $anio
 * @property string $codmon
 * @property string $numerorecibo Numeor del recibo  
 * @property string $monto
 * @property string $igv
 * @property string $detalles
 *
 * @property SigiUnidades $unidad
 * @property SigiFacturacion $facturacion
 * @property SigiEdificios $edificio
 */
class SigiKardexdepa extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    const STATUS_CANCELADO_NADA='0';
    CONST  STATUS_CANCELADO_PREV='1';
    CONST  STATUS_CANCELADO_CONF='2';
    public $montoNominal=0;  
    
     public $booleanFields = ['cancelado','aprobado'];
       const SCE_STATUS='status';
    public $dateorTimeFields = [
        'fecha' => self::_FDATE,
        'enviado'=>self::_FDATETIME
      
        
       // 'finicio' => self::_FDATETIME,
        //'ftermino' => self::_FDATETIME
    ];
    
    public static function tableName()
    {
        return '{{%sigi_kardexdepa}}';
    }

     public function behaviors()
         {
         
	/*return [		
		'fileBehavior' => [
			'class' => FileBehavior::className()
		]		
	];*/
           
          return [		
		        'fileBehavior' => [
			     'class' => FileBehavior_residente::className()
		           ],
                    ];
         }
    
     public function scenarios() {
        $scenarios = parent::scenarios();       
         $scenarios[self::SCE_STATUS] = ['cancelado'];
       return $scenarios;
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['facturacion_id',  'edificio_id', 'unidad_id', 'mes', 'fecha', 'anio'], 'required'],
           // [['facturacion_id', 'operacion_id', 'edificio_id', 'unidad_id', 'mes'], 'integer'],
            [['monto', 'igv'], 'number'],
            [['detalles'], 'string'],
             [['cancelado','monto','enviado','aprobado'], 'safe'],
            
            [['fecha'], 'string', 'max' => 10],
            [['anio'], 'string', 'max' => 4],
            [['codmon'], 'string', 'max' => 3],
            [['numerorecibo'], 'string', 'max' => 12],
            [['unidad_id'], 'exist', 'skipOnError' => true, 'targetClass' => SigiUnidades::className(), 'targetAttribute' => ['unidad_id' => 'id']],
            [['facturacion_id'], 'exist', 'skipOnError' => true, 'targetClass' => SigiFacturacion::className(), 'targetAttribute' => ['facturacion_id' => 'id']],
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
            'facturacion_id' => Yii::t('sigi.labels', 'Facturacion ID'),
            'operacion_id' => Yii::t('sigi.labels', 'Operacion ID'),
            'edificio_id' => Yii::t('sigi.labels', 'Edificio ID'),
            'unidad_id' => Yii::t('sigi.labels', 'Unidad ID'),
            'mes' => Yii::t('sigi.labels', 'Mes'),
            'fecha' => Yii::t('sigi.labels', 'Fecha'),
            'anio' => Yii::t('sigi.labels', 'Anio'),
            'codmon' => Yii::t('sigi.labels', 'Codmon'),
            'numerorecibo' => Yii::t('sigi.labels', 'Numerorecibo'),
            'monto' => Yii::t('sigi.labels', 'Monto'),
            'igv' => Yii::t('sigi.labels', 'Igv'),
            'detalles' => Yii::t('sigi.labels', 'Detalles'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnidad()
    {
        return $this->hasOne(SigiUnidades::className(), ['id' => 'unidad_id']);
    }
    
    
    public function getMovimientos()
    {
        return $this->hasMany(SigiMovimientosPre::className(), ['kardex_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFacturacion()
    {
        return $this->hasOne(SigiFacturacion::className(), ['id' => 'facturacion_id']);
    }
    
    
    

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdificio()
    {
        return $this->hasOne(Edificios::className(), ['id' => 'edificio_id']);
    }
    
     public function getDetalleFactu()
    {
        return $this->hasMany(SigiDetfacturacion::className(), ['kardex_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return SigiKardexdepaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SigiKardexdepaQuery(get_called_class());
    }
    
    public function mailRecibo(){
       // \Yii::beginProfile('correo_a usuarios');

        $mailsPropietarios=$this->unidad->mailsPropietarios();
        $numerorecibo=$this->detallesFactu[0]->numerorecibo;
        if(count($mailsPropietarios)>0){
            $idReport=$this->facturacion->reporte_id;
            $identidad=$this->detallesFactu[0]->identidad;
            //var_dump($identidad);die();
            $pathPDF=Reporte::findOne($idReport)->creaReporte($idReport, $identidad);        
            $mailer = new \common\components\Mailer();
            $message =new  \yii\swiftmailer\Message();
            $message->setSubject(Yii::t('sigi.labels','Recibo mensual ').' '.timeHelper::cboMeses()[$this->facturacion->mes].' '.$numerorecibo)
            ->setFrom([h::gsetting('sigi','correoCobranza1')=>'Cobranza Diar'])
            ->setTo($mailsPropietarios)
             ->attach($pathPDF)
            ->SetHtmlBody(timeHelper::saludo().' Estimado residente'
                    . 'adjunto encontrará el recibo correspondiente al mes de '.timeHelper::cboMeses()[$this->facturacion->mes].' Se'
                    . 'recomienda su pago dentro de los plazos establecidos');           
                try {        
                $result = $mailer->send($message);
                $mensajes['success']='Se envió el correo';
               // $this->enviado=true;$this->save();
                self::updateAll(['enviado'=>date('Y-m-d H:i:s')], ['id'=>$this->id]);
                    } catch (\Swift_TransportException $Ste) {      
                        $mensajes['error']=$Ste->getMessage();
                    }
            }
            unlink($pathPDF);
            
          //\Yii::endProfile('correo_a usuarios');
    return $mensajes;
    }
    
  public function  triggerUpload(){
      yii::error('trigger');
  }
  
  
  public function beforeSave($insert) {
      if($insert){
          $this->cancelado=self::STATUS_CANCELADO_NADA;
      }
      return parent::beforeSave($insert);
  }
  
  public function montoCalculado(){
     return  round($this->getDetalleFactu()->select(['sum(monto)'])->scalar(),4);
      
  }
  
  public function numeroReciboConsultado(){
      try{
          
          $numero=$this->detallesFactu[0]->numerorecibo;
          //var_dump($numero);die();
          return $numero;
      } catch (Exception $ex) {
            return 'No registrado';
      }
  }
  
  public function cancelar(){
      if($this->monto>0){
       $oldScenario=$this->getScenario();
        $this->setScenario(self::SCE_STATUS);
        $this->cancelado=true;
        $grabo=$this->save();
        $this->setScenario($oldScenario);
        RETURN $grabo;
      } return false;
  }
  
  
  
  
  
  public function updateMonto(){
     $this->monto=$this->montoCalculado();
     $this->save();
  }
  
  
  public function deuda(){
     return VwKardexPagos::find()->select(['sum(deuda) as deuda'])->andWhere(['anio'=>$this->anio,'mes'=>$this->mes,'edificio_id'=>$this->edificio_id])->scalar();
   }
  
  
}
