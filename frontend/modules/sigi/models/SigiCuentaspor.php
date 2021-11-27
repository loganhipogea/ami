<?php
namespace frontend\modules\sigi\models;
use frontend\modules\sigi\interfaces\colectoresInterface;
use common\models\masters\Clipro;
use common\models\masters\Documentos;
use common\helpers\h;
use Yii;
use common\behaviors\FileBehavior;
/**
 * This is the model class for table "{{%sigi_cuentaspor}}".
 *
 * @property int $id
 * @property int $edificio_id
 * @property string $codocu
 * @property string $descripcion
 * @property string $fedoc
 * @property int $mes
 * @property string $anio
 * @property string $detalle
 * @property string $fevenc
 * @property string $monto
 * @property string $igv
 * @property string $codestado
 *
 * @property SigiEdificios $id0
 */
class SigiCuentaspor extends \common\models\base\modelBase 
{
    const SCENARIO_RECIBO_INTERNO='interno';
        const SCENARIO_RECIBO_EXTERNO_MASIVO='externo';
    const SCENARIO_RECIBO_AUTOMATICO='auto';
    const COD_RECIBO_INTERNO='122';
    const ESTADO_CREADO='CREADO';
    const ESTADO_ANULADO='ANULADO';        
    public $dateorTimeFields=['fedoc'=>self::_FDATE,
        'fevenc'=>SELF::_FDATE];
   protected $Mycolector;
    public $booleanFields = ['anexado'];
    
    /*public function __construct(colectoresInterface $colector) {
        $this->Mycolector=$Colector;
        parent::__construct($config);
        
    }*/
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sigi_cuentaspor}}';
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
            [['edificio_id','colector_id','codpro','fedoc', 'codocu',
                'descripcion', 'mes', 'anio', 'monto'], 
                'required','except'=>self::SCENARIO_RECIBO_INTERNO],
            [['edificio_id', 'mes'], 'integer'],
            [['detalle'], 'string'],
            [['consumo'], 'number'],
             [['codpro','codmon','anexado'], 'safe'],
            /*ESCENARIO RECIBO INTERNO */
            [['edificio_id','unidad_id','colector_id',
                'fedoc','descripcion',
                'mes','anio','monto','codmon',
                'codpro','detalles','codocu'],
              'safe','on'=>self::SCENARIO_RECIBO_INTERNO
             ],
            [['edificio_id','unidad_id','colector_id',
                'fedoc','descripcion',
                'mes','anio','monto','codmon',
                'codpro','codocu'],
              'required','on'=>self::SCENARIO_RECIBO_INTERNO
             ],
            
            
            /*FIN DE ESCENARIO INTERNO */
            
             /*ESCENARIO RECIBO AUTOMATICO */
            [['facturacion_id','edificio_id','numerodoc','descripcion','codpro','fedoc',
                'mes','anio','monto','codmon','colector_id','detalle'],
              'safe','on'=>self::SCENARIO_RECIBO_AUTOMATICO
             ],
            [['facturacion_id','edificio_id','numerodoc','descripcion','codpro','fedoc',
                'mes','anio','monto','codmon','colector_id'],
              'required','on'=>self::SCENARIO_RECIBO_AUTOMATICO
             ],
            /*FIN DE ESCENARIO RECINBO AUTOMATRICO */
           
            
           [ ['numerodoc','facturacion_id','edificio_id','codpro','colector_id','fedoc','descripcion','detalle','mes','anio','monto','codmon','codocu','mesconsumo','consumo'],'safe','on'=>self::SCENARIO_RECIBO_EXTERNO_MASIVO],
            [['ejercicio','mes'], 'validatePeriodo', 'on' => self::SCENARIO_RECIBO_EXTERNO_MASIVO], 
            [['consumo'],'validateLecturaTotal','on'=>self::SCENARIO_RECIBO_EXTERNO_MASIVO
             ],
           [['facturacion_id','edificio_id','codpro','colector_id','fedoc','mes','anio','monto','codmon','codocu','mesconsumo','consumo'],'required','on'=>self::SCENARIO_RECIBO_EXTERNO_MASIVO], 
            
            
            [['monto'], 'number'],
            [['codocu'], 'string', 'max' => 3],
            [['descripcion'], 'string', 'max' => 40],
            [['fedoc', 'fevenc', 'igv', 'codestado'], 'string', 'max' => 10],
            [['anio'], 'string', 'max' => 4],
           // [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Edificios::className(), 'targetAttribute' => ['id' => 'id']],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sigi.labels', 'ID'),
            'edificio_id' => Yii::t('sigi.labels', 'Edificio'),
            'colector_id' => Yii::t('sigi.labels', 'Colector'),
            'codocu' => Yii::t('sigi.labels', 'Documento'),
             'codpro' => Yii::t('sigi.labels', 'Emisor'),
            'descripcion' => Yii::t('sigi.labels', 'Descripcion'),
            'fedoc' => Yii::t('sigi.labels', 'F. Docu'),
            'mes' => Yii::t('sigi.labels', 'Mes facturación'),
            'anio' => Yii::t('sigi.labels', 'Año'),
            'detalle' => Yii::t('sigi.labels', 'Detalle'),
            'fevenc' => Yii::t('sigi.labels', 'F. Venc'),
            'monto' => Yii::t('sigi.labels', 'Monto'),
             'codmon' => Yii::t('sigi.labels', 'Moneda'),
            'igv' => Yii::t('sigi.labels', 'Igv'),
            'codestado' => Yii::t('sigi.labels', 'Estado'),
             'mesconsumo' => Yii::t('sigi.labels', 'Mes aplicable'),
            'unidad_id' => Yii::t('sigi.labels', 'Unidad'),
        ];
    }
 public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_RECIBO_INTERNO] = ['facturacion_id','edificio_id','unidad_id','codpro','colector_id','fechadoc','descripcion','mes','anio','monto','codmon','codocu'];
       $scenarios[self::SCENARIO_RECIBO_EXTERNO_MASIVO] = ['numerodoc','facturacion_id','edificio_id','codpro','colector_id','fedoc','descripcion','detalle','mes','anio','monto','codmon','codocu','mesconsumo','consumo'];
        //$scenarios[self::SCENARIO_UPDATE_TABULAR] = ['codigo','coditem','tarifa'];
       // $scenarios[self::SCENARIO_REGISTER] = ['username', 'email', 'password'];*/
        return $scenarios;
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdificio()
    {
        return $this->hasOne(Edificios::className(), ['id' => 'edificio_id']);
    }
    public function getCargosEdificio()
    {
        return $this->hasOne(SigiCargosedificio::className(), ['id' => 'colector_id']);
    }
    public function getMoneda()
    {
        return $this->hasOne(\common\models\masters\Monedas::className(), ['codmon' => 'codmon']);
    }
    public function getDocumento()
    {
        return $this->hasOne(Documentos::className(), ['codocu' => 'codocu']);
    }
    public function getClipro()
    {
        return $this->hasOne(Clipro::className(), ['codpro' => 'codpro']);
    }
    
      public function getFacturacion()
    {
        return $this->hasOne(SigiFacturacion::className(), ['id' => 'facturacion_id']);
    }
      public function getDetFacturacion()
    {
        return $this->hasMany(SigiDetfacturacion::className(), ['cuentaspor_id'=>'id']);
    }
    /**
     * {@inheritdoc}
     * @return SigiCuentasporQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SigiCuentasporQuery(get_called_class());
    }
    
    
    public function valoresDefault(){
        $this->anio=date('Y');
        $this->mes=date('m');
        $this->codmon=h::gsetting('general', 'moneda');
    }
    
      
    public function getColector(){
        return $this->hasOne(SigiCargosedificio::className(), ['id' => 'colector_id']);
    }
    
    /*******************************************************
     * Obriene le data provier para su resspectivco colector
     * Es decir para colectores con meddores de agua 
     * obtinene las lecturas, 
     * Para colcores que dependen de lpresupeusto
     * deuelve los registros de las partidas correspondientes
     * ****************************************************
     * 
     */
    public function provider(){
       
    }
    
    
    private function resolveFieldsDefault(){
        if($this->getScenario()==self::SCENARIO_RECIBO_INTERNO){
            $this->codocu=SELF::COD_RECIBO_INTERNO;
            $this->numerodoc=$this->generateNumero();
            // $this->codpro=$this->generateNumero();
        }
    }
  private function generateNumero(){
      return '994950y4';
  } 
  
  public function beforeSave($insert) {
      if($insert){
            yii::error('Los atriburtos son:');
          yii::error($this->attributes);
          $this->resolveFieldsDefault();
           yii::error($this->attributes);
      }
      return parent::beforeSave($insert);
  }
  
  public function generateRecibosAuto($mes){
      $colectores=$this->edificio->colectores;
       foreach($colectores as $colector){
          if($colector->isBudget()){
              
              
              
             $this->createRecibo($monto,$mes);
          }
       }  
  }
  
  private function createRecibo($attributes){
      
  }
  /*Valida si el colecror es un punto de meidad , el edificio tiene
   * por lo menos un punto de medida de este tipo
   * en caso contrario debe de arrojar un error
   * porque no se puede emtir recibos externos msaivos
   * si el colector es putno de medida y no tiene medidores en su departamento
   */
  public function validateMedidor($attribute, $params)
    {
      
        if(!empty($this->parent_id)){
           $registro= $this->find()->where([
                   'id'=>$this->parent_id,
                     'edificio_id'=>$this->edificio_id,   
                       ])->one();
               if(is_null($registro)){
                   $this->addError ('parent_id',yii::t('sigi.errors','Este número de unidad no está registrado en el edificio'));
      
               } else{
                   if($registro->codpro <> $this->codpro){
                       $this->addError ('parent_id',yii::t('sigi.errors','La unidad padre tiene otro grupo de gestión "{gpadre}" ',['gpadre'=>$registro->codpro,'ghijo'=>$this->codpro]));  
                   }
               }
              
           
        }
      
    }
  
    
    /*Se asegura que el mes y el anio se an consistentes con 
     * FACTURACION tabla padre 
     * por  que se rompio la normalizacion
   */
  public function validatePeriodo($attribute, $params)
    {
     if(!($this->mes==$this->facturacion->mes) or  !($this->anio==$this->facturacion->ejercicio)  ) {
        $this->addError ('mes',yii::t('sigi.errors','Revise el periodo del plan de cobranza no coincide el mes o ano '   ));  
        return;            
     }
      
    }
    
    
    
   /*
    * Funcion que genera los registros detalles para 
    * la facturacion o par l aemision de los recibos individuales
    */ 
    public function generateFacturacion(){
        $errores=[];
    $colector=$this->colector;
         if($colector->individual){
               $unidad= SigiUnidades::find()->where(['id'=>$this->unidad_id])->one();
               $errores[]=$this->createRegistroFacturacion($unidad,$colector);
           }else{
               if($colector->isMedidor()){
                   $medidores=$this->edificio->suministrosByTypeQuery($colector->tipomedidor)->all();
                foreach( $medidores as $medidor){
                      $unidad=$medidor->unidad;
                      if($unidad->imputable){
                         $errores[]=$this->createRegistroFacturacion($unidad,$colector,$medidor); 
                         foreach($unidad->childsUnits as $childUnit){
                           $errores[]=$this->createRegistroFacturacion($childUnit,$colector,$medidor); 
                          }
                             
                      }else{
                          $depasReparto=$medidor->depasReparto();
                          foreach($depasReparto as $depa){
                              $errores[]=$this->createRegistroFacturacion($depa->unidad,$colector,$medidor);  
                          }
                         
                      }
                         
                      }
               }else{
                   foreach($this->edificio->unidadesImputables() as $unidad){
                   /*if($colector->isMedidor()){
                       $medidor=$unidad->firstMedidor($colector->tipomedidor);
                       if(!is_null($medidor))
                        $medidor->updateReadFacturable($mes,$anio,$this->id);
                    }*/
                    $errores[]=$this->createRegistroFacturacion($unidad,$colector);
                      }
                   
               }
               
           }
        
      return array_filter($errores); 
    }
 
    
  private function createRegistroFacturacion($unidad,$colector,$medidor=null){
      $msgError='';
      if(is_null($medidor)){
           $medidorHasAfiliados=false;
           $prorateo=false;
      }else{
         $medidorHasAfiliados=$medidor->hasAfiliados(); 
         $prorateo=$medidorHasAfiliados;
      }
     
      
          if(!$this->existsDetalleFacturacion($unidad,$colector,$prorateo)){
              if(is_null($medidor)){
                   $participacion=$unidad->porcParticipacion($colector,$this->mes,$this->anio);
              }else{
                 if($medidorHasAfiliados){
                   //$prorateo=true;
                     //La lectura de este medidor entre el numero de departamentos comprometidos
                 $ndepas=($medidor->ndepasReparto() >0)?$medidor->ndepasReparto():$unidad->edificio->queryUnidadesImputables()->count();
                yii::error('La particiapc  es '.$medidor->participacionRead($this->mes,$this->anio));
                 $participacion=$medidor->participacionRead($this->mes,$this->anio)/$ndepas;  
                  
                 }else{
                    $participacion=$unidad->porcParticipacion($colector,$this->mes,$this->anio); 
                 }
                 
              }
               $monto=$participacion*$this->monto;
               $model=New SigiDetfacturacion();
               $model->setAttributes($this->prepareAttributes($unidad,$colector,$monto,$prorateo));
            /*PARA AGRUPAR EN EL DEP A PADRE LOS HIJOS*/
            $model->grupounidad=($unidad->isChild())?$unidad->parentNumero():$unidad->numero;
            $model->grupounidad_id=($unidad->isChild())?$unidad->parent_id:$unidad->id;
            $model->grupofacturacion=($unidad->miApoderado()->facturindividual)?$unidad->codpro:$model->grupounidad;
            /*****************************************************/
            $model->participacion=$participacion;
            $model->codsuministro=(!is_null($medidor))?$medidor->codsuministro:null;
            $model->lectura=(!is_null($medidor))?$medidor->LastReadFacturable($this->mes,$this->anio)->lectura:null;
             $model->delta=(!is_null($medidor))?$medidor->LastReadFacturable($this->mes,$this->anio)->delta:null;
             $model->consumototal=(!is_null($medidor))?$medidor->consumoTotal($this->mes,$this->anio,true):null;
              $model->unidades=(!is_null($medidor))?$medidor->codum:null;
              $model->codmon=$this->codmon;
              
            if(!$model->save()){
                yii::error($model->getFirstError()); 
                $msgError=$model->getFirstError();
            }else{
                
            }
            //return $model->grupofacturacion;
          }
      return $msgError;    
  } 
    
 private function prepareAttributes($unidad,$colector,$monto,$prorateo=false){
     return [
                'cuentaspor_id'=>$this->id,
                'edificio_id'=>$this->edificio_id,
         'facturacion_id'=>$this->facturacion_id,
                'unidad_id'=>$unidad->id,
                'colector_id'=>$colector->id,
                'grupo_id'=>$colector->grupo_id,
                'monto'=>$monto,
                'igv'=>$monto*h::gsetting('general', 'igv'),
                //'cuentaspor_id'=>$this->id,
                'mes'=>$this->mes,
                'anio'=>$this->anio,
                 'aacc'=>($prorateo)?'1':'0',
                   'montototal'=>$this->monto,
            ];
 }  

public function existsDetalleFacturacion($unidad,$colector,$prorateo=false,$dias){    
    return SigiDetfacturacion::find()->
                where([
                    'cuentaspor_id'=>$this->id,
                    'edificio_id'=>$this->edificio_id,
                    'facturacion_id'=>$this->facturacion_id,
                     'unidad_id'=>$unidad->id,
                     'colector_id'=>$colector->id,
                'grupo_id'=>$colector->grupo_id,
                'mes'=>$this->mes,
                'anio'=>$this->anio,
                    'aacc'=>($prorateo)?'1':'0',
                    'dias'=>$dias
                //'prorateo'=>
                   
                        ])
                ->exists();
    
} 
/*
 * Funcion corta 
 */
public function insertaRegistro($identidad,$unidad,$medidor,$monto,$aacc,$participacion,$dias,$esResumido){
    $maxDias=30;
    
    if($dias==$maxDias){
      $this->insertaRegistroRaw($identidad,$unidad,$medidor,$monto,$aacc,$participacion,$dias,1,'1',$esResumido);  
    }else{
        $factor=$dias/$maxDias;
        
      $this->insertaRegistroRaw($identidad,$unidad,$medidor,$monto,$aacc,$participacion,$dias,$factor,'0','0'); 
     // $nuevaIdentidad=$this->facturacion->kardexDepa($unidad->id,true);
      //Le ponemos NULL
      $this->insertaRegistroRaw(null,$unidad,$medidor,$monto,$aacc,$participacion,$maxDias-$dias,1-$factor,'1','0'); 
    }
}

private function insertaRegistroRaw($identidad,$unidad,$medidor,$monto,$aacc,$participacion,$dias,$factor,$nuevoProp,$esResumido){
    if($factor==1){
        $grupocobranza=(!$unidad->miApoderado()->cobranzaindividual)?$unidad->codpro:$unidad->numero;
    }else{
       if($nuevoProp=='0') { 
       /////Si es registro con propietario antiguo
       // es necesario obtener el apoderado antiguo  
       // para mantener el grupo de cobranza original
            $codproant=$unidad->lastTransferencia()->codproant;
            //yii::error('UNIDAD  '.$unidad->numero);
            ///yii::error('UNIDAD  '.$unidad->numero);
            $apoderadoant= SigiApoderados::find()->
               where(['edificio_id'=>$this->edificio_id,'codpro'=>$codproant])
                    ->one();
            // yii::error('apoderado anterior  '.$apoderadoant->codpro);
           $grupocobranza=($apoderadoant->facturindividual)?$unidad->numero:$codproant;  
           //yii::error('GRUPO DE COBRANZA :  '.$grupocobranza);
       }else{ ///si es registro con propiestario nuevo , puede haber cambiado de apoderado pero no importa 
          $grupocobranza=($unidad->miApoderado()->facturindividual)?$unidad->numero:$unidad->codpro;    
       }
    }
    
    /*
     * Resolviendo el factor del monto total de los recibos de agua
     */
        if(is_null($medidor)){//Si es AACC o cualquier otro
            if($aacc=='1'){
                $factorMonto=$participacion; //Si se trata de un medidor de AACC aplicar le factor
            }else{
                $factorMonto=1;
            }
            
        }else{ //Si s etrata de un medidor de una uNIdad tambien aplicar el factor 
            $factorMonto=$participacion;
        }
    
   
        $model=New SigiDetfacturacion();
         $attributes=[ 'cuentaspor_id'=>$this->id,
                'edificio_id'=>$this->edificio_id,
         'facturacion_id'=>$this->facturacion_id,
                'unidad_id'=>$unidad->id,
                'colector_id'=>$this->colector->id,
                'grupo_id'=>$this->colector->grupo_id,
                'monto'=>$monto*$factor,
                'igv'=>round($monto*$factor*h::gsetting('general', 'igv'),4),
                //'cuentaspor_id'=>$this->id,
                'mes'=>$this->mes,
                'anio'=>$this->anio,
                 'aacc'=>$aacc,
                   'montototal'=>$this->monto*$factorMonto,
             'kardex_id'=>$identidad, //Importante 
         'grupounidad'=>$unidad->numero,
           'grupounidad_id'=>$unidad->id,
            'grupofacturacion'=>(!$unidad->miApoderado()->facturindividual)?$unidad->codpro:$unidad->numero,
             'grupocobranza'=>$grupocobranza,
            'participacion'=>$participacion,
          'codsuministro'=>(is_null($medidor))?null:$medidor->codsuministro,
            'lectura'=>(is_null($medidor))?null:$medidor->LastReadFacturable($this->mes,$this->anio)->lectura,
             'delta'=>(is_null($medidor))?null:$medidor->LastReadFacturable($this->mes,$this->anio)->delta,
            'consumototal'=>(is_null($medidor))?null:$medidor->consumoTotal($this->mes,$this->anio,true),
             'unidades'=>(is_null($medidor))?null:$medidor->codum,
             'codmon'=>$this->codmon,
             'dias'=>$dias,
             'nuevoprop'=>$nuevoProp,
             'resumido'=>($esResumido)?'1':'0',
             ];
        // yii::error( $attributes);
         $model->setAttributes($attributes);
        return $model->save();
  
}



public function creaRegistroLecturasTemp(){
    $colector=$this->colector;
    foreach($this->edificio->unidadesImputables() as $unidad){                   
                   if($colector->isMedidor()){
                       $medidor=$unidad->firstMedidor($colector->tipomedidor);
                       if(!is_null($medidor)){
                           SigiLecturasTemp::firstOrCreateStatic(
                                   static::attributesForTempRead($colector->tipomedidor,$unidad->id,$medidor->id)
                                   , null, static::attributesForVerifyTemp($medidor,$colector)
                                   );
                       }
                        
                    }
                }
         }

  
 private function attributesForTempRead($tipo,$unidad_id,$suministro_id){
     return [
         'cuentaspor_id'=>$this->id,
         'edificio_id'=>$this->edificio_id,
         'facturable'=>true,
         'codtipo'=>$tipo,
         'anio'=>$this->anio,
         'flectura'=>$this->fedoc,
          'mes'=>$this->mes,
          'user_id'=>h::userId(),
          'unidad_id'=>$unidad_id,
         'suministro_id'=>$suministro_id,
     ];
 }        
    
 private function attributesForVerifyTemp($medidor,$colector){
     return [
             'suministro_id'=>$medidor->id,
              'codtipo'=>$colector->tipomedidor,
            'mes'=>$this->mes,
             'anio'=>$this->anio,
             'user_id'=>h::userId()
        ];
 }
      
 
 public function validateLecturaTotal($attribute, $params){
     $tipomedidor=$this->cargosEdificio->tipomedidor;
   IF($tipomedidor== SigiSuministros::COD_TYPE_SUMINISTRO_DEFAULT){
      if(empty($this->consumo)){
         $this->addError('consumo',yii::t('sta.labels','El consumo no puede estar vacío'));
         return;
     }
     
   
       $consumoTotal= SigiLecturas::consumoTotal($this->edificio_id, 
                $this->mes, $tipomedidor, true);
       
      $tolerancia=h::gsetting('sigi', 'toleranciaMedidores');
      if($this->consumo >0){
          //var_dump( $consumoTotal);die();
        $porcentajeDiff=round(abs($this->consumo-$consumoTotal)*100/$this->consumo,2);
      if( $porcentajeDiff > $tolerancia){
          $this->adderror('consumo',yii::t('sta.labels','El consumo no coincide con las lecturas hay diferencia de '.$porcentajeDiff.' % '.$tolerancia.' '.$this->consumo.' '.$consumoTotal));
      }
    }else{
      $this->adderror('consumo',yii::t('sta.labels','El consumo no puede ser cero'));  
    } 
   }
     
     
 }
 
 
public function afterDelete() {
    /*Revertir algun documento relacionado 
     * en la tabla DOCDPORPAGAR*/
     if($this->anexado){
    $criteria=['edificio_id'=>$this->edificio_id,
                  'en_recibo'=>'1',
                'facturacion_id'=>$this->facturacion->id,
                'codocu'=>$this->codocu, 
                'numdocu'=>$this->numerodoc,                
                   'codpro'=>$this->codpro, 
                  ];
                  
    if(!is_null($model=SigiPorpagar::find()->andWhere($criteria)->one())){
        $model->facturacion_id=null;
        $model->save();
    }
     }
    return parent::afterDelete();
}
 
 }