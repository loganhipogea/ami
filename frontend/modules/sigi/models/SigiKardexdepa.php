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
    
     public $booleanFields = ['cancelado','aprobado','historico'];
       const SCE_STATUS='status';
       const SCE_BATCH='batch';
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
          $scenarios[self::SCE_BATCH] = ['codepa','codedificio', 'mes', 'fecha', 'anio',
                                       'monto','detalles',
                                            ];
       return $scenarios;
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['facturacion_id',  'edificio_id', 'unidad_id', 'mes', 'fecha', 'anio'], 'required', 'except'=>[self::SCE_BATCH]],
            [['mes', 'fecha', 'anio'], 'required'],
            [['facturacion_id', 'unidad_id', 'edificio_id','historico','aprobado','enviado'], 'safe'],
            [['codepa','codedificio', 'mes', 'fecha', 'anio',
                                       'monto'], 'required','on'=>[self::SCE_BATCH]],
            
           // [['facturacion_id', 'operacion_id', 'edificio_id', 'unidad_id', 'mes'], 'integer'],
            [['monto', 'igv'], 'number'],
            [['detalles'], 'string'],
             [['cancelado','monto','enviado','aprobado','historico','voucher_id'], 'safe'],
            
            [['codepa'], 'validate_batch','on'=>self::SCE_BATCH],
            [['unidad_id','edificio_id'], 'required','on'=>self::SCE_BATCH,'message'=>yii::t('sigi.errors','El número de la unidad no es el correcto')],
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
      if($this->aprobado){
        $mailsPropietarios=$this->unidad->mailsPropietarios();
        $numerorecibo=$this->detalleFactu[0]->numerorecibo;
        if(count($mailsPropietarios)>0 && count($this->files)>0){
            $idReport=$this->facturacion->reporte_id;
            $identidad=$this->detalleFactu[0]->identidad;
            //var_dump($identidad);die();
            //$pathPDF=Reporte::findOne($idReport)->creaReporte($idReport, $identidad);        
            $mailer = new \common\components\Mailer();
            $message =new  \yii\swiftmailer\Message();
            $message->setSubject(Yii::t('sigi.labels','Recibo mensual ').' '.timeHelper::cboMeses()[$this->facturacion->mes].' '.$numerorecibo)
            ->setFrom([h::gsetting('sigi','correoCobranza1')=>'Cobranza Diar'])
            ->setTo($mailsPropietarios)
             ->attach($this->files[0]->path)
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
            //unlink($pathPDF);
      } else{
         $mensajes['error']=yii::t('base.errors','La facturación aún no ha sido aprobada'); 
      }
          //\Yii::endProfile('correo_a usuarios');
    return $mensajes;
    }
    
  public function  triggerUpload(){
      yii::error('trigger');
  }
  
  public function beforeValidate() {
      if($this->getScenario()==self::SCE_BATCH)
      $this->resolveIdsBatch();
     
      return parent::beforeValidate();
       
  }
  
  public function beforeSave($insert) {
 
      
      if($insert){
          $this->aprobado=($this->getScenario()==self::SCE_BATCH)?TRUE:FALSE;         
          $this->historico=($this->getScenario()==self::SCE_BATCH)?TRUE:FALSE;
          $this->cancelado=self::STATUS_CANCELADO_NADA;
      }
      
      return parent::beforeSave($insert);
  }
  
  public function montoCalculado(){
     return  round($this->getDetalleFactu()->select(['sum(monto)'])->scalar(),4);
      
  }
  
  public function numeroReciboConsultado(){
      try{
          
          $numero=$this->detalleFactu[0]->numerorecibo;
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
        $this->cancelado=$this->isCancelado(); //candelar puede ser falso para descancelar 
        yii::error('es acncelado o no ',__FUNCTION__);
        yii::error($this->cancelado,__FUNCTION__);
        
        $grabo=$this->save();
        $this->setScenario($oldScenario);
        RETURN $grabo;
      } return false;
  }
  
      
  
  
  
  public function updateMonto(){
     $this->monto=$this->montoCalculado();
     $this->save();
  }
  
  /*
   * Deuda del mismo recibo 
   */
  public function deuda(){
      return $this->monto-$this->montoPagado();
     //return VwKardexPagos::find()->select(['sum(deuda) as deuda'])->andWhere(['anio'=>$this->anio,'mes'=>$this->mes,'edificio_id'=>$this->edificio_id])->scalar();
   }
   
   
  public function montoPagado(){
      $valor=$this->getMovimientos()->select(['sum(monto)'])->
      andWhere(['activo'=>'1'])->scalar();
     if($valor>0)return $valor;
    return 0;
     //return VwKardexPagos::find()->select(['sum(deuda) as deuda'])->andWhere(['anio'=>$this->anio,'mes'=>$this->mes,'edificio_id'=>$this->edificio_id])->scalar();
   }
   
   /*
    * Deuda total
    */
  public function deudaKardex(){
      
      $deuda=VwKardexPagos::find()->select(['sum(deuda) as deuda'])->andWhere(['id'=>$this->id])->scalar(); 
     return (is_null($deuda))?0:$deuda;
  }
  private function resolveEdificio(){
     $model=Edificios::find()->where(['codigo'=>$this->codedificio])->one();
     return (is_null($model))?null:$model->id;
  }
  private function resolveIdsBatch(){
      $this->edificio_id=$this->resolveEdificio();
      $this->unidad_id=$this->resolveUnidadId();
     // yii::error('OTENOIENOD EL FACTURACION IU',__FUNCTION__);
       //yii::error($this->resolveFacturacionId(),__FUNCTION__);
      $this->facturacion_id=$this->resolveFacturacionId();
      $this->setAttributes([
          'cancelado'=>'0',
          'enviado'=>'1',
          'aprobado'=>true,
          'historico'=>true, 
                                            
      ]);
        yii::error($this->attributes,__FUNCTION__);
  }
  
  private function resolveUnidadId(){
      yii::error($this->attributes);
      $m=$this->edificio->getUnidades()->andWhere([
          'numero'=>$this->codepa
      ])->one();
      yii::error($this->edificio->getUnidades()->andWhere([
          'numero'=>$this->codepa
      ])->createCommand()->rawSql,__FUNCTION__);
      return is_null($m)?null:$m->id;
  }
  
   private function resolveFacturacionId(){
      $m= SigiFacturacion::find()->andWhere([
          //'unidad_id'=>$this->unidad_id,
          'edificio_id'=>$this->edificio_id,
          'mes'=>$this->mes,
          'ejercicio'=>$this->anio,
      ])->one();
      yii::error(SigiFacturacion::find()->andWhere([
          //'unidad_id'=>$this->unidad_id,
          'edificio_id'=>$this->edificio_id,
          'mes'=>$this->mes,
          'ejercicio'=>$this->anio,
      ])->createCommand()->rawSql,__FUNCTION__);
      return is_null($m)?null:$m->id;
  }
 
  public function validate_batch($attribute,$params){
           /*Existe este numero de departameneto*/
          // yii::error($this->unidad,__FUNCTION__);
       IF(is_null($this->resolveEdificio())){
          $this->addError('codedificio',yii::t('base.errors','Este edificio no existe'));  
       }
        IF(is_null($this->resolveUnidadId())){
          $this->addError('codepa',yii::t('base.errors','Esta unidad {depa} no existe',['depa'=>$this->codepa])); 
          
       } 
       IF(is_null($this->resolveFacturacionId())){
          $this->addError('mes',yii::t('base.errors','No se encontró facturación para esta deuda, revise si cargó la facturación histórico'));  
       } 
     /*Duplicado*/
      if(Self::find()->andWhere([ //'unidad_id'=>$this->unidad_id,
          'edificio_id'=>$this->edificio_id,
          'mes'=>$this->mes,
          'anio'=>$this->anio,
          'unidad_id'=>$this->unidad_id,
          ])->exists()) {
          yii::error(Self::find()->andWhere([ //'unidad_id'=>$this->unidad_id,
          'edificio_id'=>$this->edificio_id,
          'mes'=>$this->mes,
          'anio'=>$this->anio,
          'unidad_id'=>$this->unidad_id,
          ])->createCommand()->rawSql);
          $this->addError('unidad_id',yii::t('base.errors','Este kardex ya existe'));
          return ;
      }
      
  }
 
   /*
   * Sacando los grupos de concepto a mostrar en el recibo
   */
  private  function groupsToRecibo(){
     return  $this->getDetalleFactu()->select(['grupo_id','count(grupo_id) as cant'])->
     groupBy(['grupo_id'])->orderBy(['count(grupo_id)'=>SORT_DESC])->distinct()->asArray()->all();
  }
  
   /*
   * Sacando los detalles de grupo para el recibo
   */
  public function groupDetailsForRecibo(){ 
      $resumido=$this->isResumido();
      $expresion= new \yii\db\Expression('lectura-delta as lanterior');
      
      //YII::ERROR('grupos para el recibo');
        
                $groups=self::groupsToRecibo();
               //var_dump($groups);die();
         $container=[];
    if(!$resumido){
        foreach($groups as $filagGrupo){
                 $container[$filagGrupo['grupo_id']]=(new \yii\db\Query())->
                    select(['unidades','g.descripcion as desgrupo','f.descargo','codgrupo', 'aacc','codsuministro','unidades',$expresion,'lectura','delta',
                    'a.monto','montototal'])
                    ->from('{{%sigi_detfacturacion}} a')
                     ->innerJoin('{{%sigi_cargosedificio}} e','e.id=a.colector_id')
                    ->innerJoin('{{%sigi_cargos}} f', 'e.cargo_id=f.id')  
                    ->innerJoin('{{%sigi_cargosgrupoedificio}} g', 'a.grupo_id=g.id') 
                    ->andWhere(['kardex_id' =>$this->id])->andWhere(['a.grupo_id'=>$filagGrupo['grupo_id']])
                    ->all();
                
                 }      
        
         }else{
              foreach($groups as $filagGrupo){
                 $container[$filagGrupo['grupo_id']]=(new \yii\db\Query())->
                    select(['g.codgrupo','g.descripcion as desgrupo','aacc','f.descargo','montototal',
                        'sum(a.monto) as monto'])
                    ->from('{{%sigi_detfacturacion}}a')
                     ->innerJoin('{{%sigi_cargosedificio}} e','e.id=a.colector_id')
                    ->innerJoin('{{%sigi_cargos}} f', 'e.cargo_id=f.id')  
                    ->innerJoin('{{%sigi_cargosgrupoedificio}} g', 'a.grupo_id=g.id') 
                    ->andWhere(['kardex_id' =>$this->id])->andWhere(['a.grupo_id'=>$filagGrupo['grupo_id']])
                    ->groupBy(['g.codgrupo','g.descripcion','aacc','f.descargo','montototal'])
                    ->all();
                 yii::error('key grupo');yii::error($key_grupo);
                 yii::error((new \yii\db\Query())->
                    select(['g.codgrupo','g.descripcion','aacc','f.descargo','montototal',
                        'sum(a.monto) as monto'])
                    ->from('{{%sigi_detfacturacion}}a')
                     ->innerJoin('{{%sigi_cargosedificio}} e','e.id=a.colector_id')
                    ->innerJoin('{{%sigi_cargos}} f', 'e.cargo_id=f.id')  
                    ->innerJoin('{{%sigi_cargosgrupoedificio}} g', 'a.grupo_id=g.id') 
                    ->andWhere(['kardex_id' =>$this->id])->andWhere(['a.grupo_id'=>$filagGrupo['grupo_id']])
                    ->groupBy(['g.codgrupo','g.descripcion','aacc','f.descargo','montototal'])
                    ->createCommand()->rawSql);
              
              }
             
        }   
        
      return $container;
  }
  
  public function isResumido(){
     $array_depas=array_unique($this->getDetalleFactu()->select(['unidad_id'])->distinct()->column()); 
     return (count($array_depas)>1);
      
  }
  /*
   * Verifica si es un deudor,
   * Solo verificando el monto
   */
  public function isCancelado(){
     $tolerancia=h::gsetting('sigi', 'montominimo_deudor');
     $montopagado=$this->montoPagado();
     $diferencia=$this->monto-($tolerancia+$montopagado);
     /*yii::error('monto pagado',__FUNCTION__);
     yii::error( $montopagado,__FUNCTION__);
     yii::error( 'operacion',__FUNCTION__);
     yii::error( 'direfncia = '.$this->monto.'-('.$tolerancia.'-'.$montopagado.')',__FUNCTION__);
     */return ($diferencia<=0)?true:false;
  }
  
  
public function hasVoucher(){
    return ($this->voucher_id >0);
}

public function getVoucher(){
    if($this->hasVoucher()){
       return  SigiVouchers::findOne($this->voucher_id+0);
    }else{
        return null;
    }
}
  
  
}
