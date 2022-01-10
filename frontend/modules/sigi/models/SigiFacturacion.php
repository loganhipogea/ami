<?php
namespace frontend\modules\sigi\models;
use common\helpers\h;
use common\helpers\FileHelper;
use frontend\modules\report\Module as ModuleReporte;
use frontend\modules\sigi\models\SigiCuentaspor;
use frontend\modules\sigi\models\SigiDetfacturacion;
use frontend\modules\sigi\models\SigiDetFacturacionSearch;
use frontend\modules\sigi\models\SigiKardexdepa;
use frontend\modules\sigi\models\VwSigiFacturecibo;
use frontend\modules\sigi\models\VwSigiLecturas;
use Yii;
use  yii\web\ServerErrorHttpException;
use yii\base\Exception;
USE yii\data\ActiveDataProvider;
use frontend\modules\report\models\Reporte;
/**
 * This is the model class for table "{{%sigi_facturacion}}".
 *
 * @property int $id
 * @property int $edificio_id
 * @property string $mes
 * @property string $ejercicio
 * @property string $fecha
 * @property string $descripcion
 * @property string $detalles
 *
 * @property SigiDetfacturacion[] $sigiDetfacturacions
 * @property SigiEdificios $edificio
 */
class SigiFacturacion extends \common\models\base\modelBase
{
    const EST_CREADO='C';
    const EST_APROBADO='A';
    const SCE_BATCH='batch';
    //const EST_ANULADO='A';
    private $_reporte=null;
     private $_edificio=null;
   //public static $varsToReplace=['$cuenta'=>'','$dias'=>'','$banco'=>'','$correo_cobranza'=>''];
    public $hardFields=['edificio_id','mes','ejercicio'];
     public $booleanFields = ['historico'];
     public $dateorTimeFields=['fvencimiento'=>self::_FDATE,'fecha'=>self::_FDATE];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sigi_facturacion}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['edificio_id', 'mes', 'descripcion','fecha','fvencimiento','reporte_id'], 'required','except'=>self::SCE_BATCH],
            [['edificio_id', 'mes', 'fecha', 'ejercicio'],'required','on'=>self::SCE_BATCH],
            [['edificio_id'], 'integer'],
            [['fvencimiento','detalleinterno','unidad_id','edificio_id','mes','fecha','reporte_id','estado','historico'], 'safe'],
            ['fvencimiento', 'validateFechas','except'=>self::SCE_BATCH],
            [['detalles'], 'string'],
            [['mes','ejercicio','edificio_id'], 'unique', 'targetAttribute' => ['mes','ejercicio','edificio_id']],
            [['mes'], 'string', 'max' => 2],
            [['ejercicio'], 'string', 'max' => 4],
            [['fecha'], 'string', 'max' => 10],
            [['descripcion'], 'string', 'max' => 40],
            [['edificio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Edificios::className(), 'targetAttribute' => ['edificio_id' => 'id']],
        ];
    }
 public function scenarios() {
        $scenarios = parent::scenarios();       
          $scenarios[self::SCE_BATCH] = ['edificio_id', 'mes', 'fecha', 'ejercicio',
                                       
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
            'edificio_id' => Yii::t('sigi.labels', 'Edificio ID'),
            'mes' => Yii::t('sigi.labels', 'Mes'),
            'ejercicio' => Yii::t('sigi.labels', 'Ejercicio'),
            'fecha' => Yii::t('sigi.labels', 'Fecha'),
            'descripcion' => Yii::t('sigi.labels', 'Descripcion'),
            'detalles' => Yii::t('sigi.labels', 'Detalles'),
        ];
    }

   
    public function getSigiCuentaspor()
    {
        
        
        return $this->hasMany(SigiCuentaspor::className(), ['facturacion_id' => 'id']);
    }
    
    
     public function getUnidad()
    {
        return $this->hasOne(SigiUnidades::className(), ['id' => 'unidad_id']);
    }
    
    public function getSigiDetfacturacion()
    {
        return $this->hasMany(SigiDetfacturacion::className(), ['facturacion_id' => 'id']);
    }
    
    
    public function montoTotal(){
       RETURN $this->getSigiCuentaspor()->sum('monto');
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdificio()
    {
        if(is_null($this->_edificio)){
          return $this->hasOne(Edificios::className(), ['id' => 'edificio_id']);
       }else{
          return $this->_edificio;
       }
        
    }
    
    
    public function getReporte(){
       if(is_null($this->_reporte)){
          return $this->hasOne(Reporte::className(), ['id' => 'reporte_id']); 
       }else{
          return $this->_reporte;
       }
       
   
    }
    
     public function getKardexDepa(){
       return $this->hasMany(SigiKardexdepa::className(), ['facturacion_id' =>'id']);
   
    }
   

    /**
     * {@inheritdoc}
     * @return SigiFacturacionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SigiFacturacionQuery(get_called_class());
    }
 
    public function afterSave($insert,$changedAttributes ) {
      if($insert){
          $this->refresh();
          //yii::error('El id d efacturacion es');
          ///yii::error($this->id);
          if(!$this->historico)
          $this->createAutoFac(); //cREA LOS RECIBOS AUTOMATICOS DEL PRESUPUESTO
      }
        return parent::afterSave($insert,$changedAttributes );
    }
    
    
    /*
     *Crea los recibos automáticos para la facturacion
     * Solo aquellos de emisor interno JDp y que sean respuestables 
     */
    public function createAutoFac(){
        yii::error('generate');
        $scenario= SigiCuentaspor::SCENARIO_RECIBO_AUTOMATICO;
       $edificio= Edificios::findOne($this->edificio_id);
       yii::error(count($edificio->cargos));
       yii::error($edificio->id);
      foreach($edificio->cargos as $cargo){
            yii::error('inicnado segundo bucle ');
             yii::error(count($cargo->sigiCargosedificios));
          foreach($cargo->sigiCargosedificios as $colector){
              
              /*Si el registro es un presupeusto y aun no está registrado*/
              /* yii::error('es budget');
              yii::error($colector->isBudget());
               yii::error('has reciobo auto');
                  yii::error(!$this->hasReciboAuto($colector->id));*/
            if($colector->monto > 0){
             if($colector->isBudget() && !$this->hasReciboAuto($colector->id)) {
                       
                 $model=new SigiCuentaspor();
                      $model->setScenario(SigiCuentaspor::SCENARIO_RECIBO_AUTOMATICO);
                      $model->setAttributes($this->prepareFieldsAuto($edificio, $colector));
                      // yii::error($model->attributes);  
                      IF($model->save()){
                         yii::error('grabo');  
                      }ELSE{
                          
                         yii::error('error  :'.$model->getFirstError()); 
                      }
                 yii::error('El colector is es '.$colector->id);
                      }
           }
          }
        }
    }
    
    /*Verifica si ya existe el registro dentro de l afaturacion
     * 
     */    
    public function hasReciboAuto($id_colector){
        $registro=SigiCuentaspor::find()
                ->andWhere(['edificio_id'=>$this->edificio_id])
                ->andWhere( ['mes'=>$this->mes])
                 ->andWhere( ['facturacion_id'=>$this->id])
                ->andWhere(['anio'=>$this->ejercicio])
                 ->andWhere(['colector_id'=>$id_colector])->one();
       
       
            return (!is_null($registro))?true:false ;
        
    }
    
    private function prepareFieldsAuto($edificio,$colector){
   
        return [
            'edificio_id'=>$this->edificio_id,
            'facturacion_id'=>$this->id,
            'numerodoc'=>$edificio->codigo. SigiCuentaspor::COD_RECIBO_INTERNO.'-AB-00034',
            'descripcion'=>substr($colector->cargo->descargo,0,40),
            'mes'=>$this->mes,
            'anio'=>$this->ejercicio,
            'codestado'=> SigiCuentaspor::ESTADO_CREADO,
            'codocu'=> SigiCuentaspor::COD_RECIBO_INTERNO,
            'codpro'=>$edificio->emisorDefault()->codpro,
            'fedoc'=>$this->fecha,
           'colector_id'=>$colector->id,
            'codmon'=>\common\helpers\h::gsetting('general', 'moneda'),
            'monto'=>$colector->montoTotal($this->mes,$this->ejercicio),
        ];
    }
    
    /*Verifica que todosl los coelctores del 
     * rpesupesto 
     * esten en el detalle 
     */
    public function isCompleteColectores(){
       $dif= array_diff($this->idsColectoresInBudget(),$this->idsColectores());
       //VAR_DUMP($this->idsColectoresInBudget(),$this->idsColectores(),$dif);die();
       return (count($dif)>0)?false:true;
    }
    
    
    
    public function generateFacturacionMes(){        
        $errores=[];
        yii::error('generando facturacion');
        if(count($this->getSigiCuentaspor()->select('codmon')->distinct()->column())==1){
              if($this->isCompleteColectores()){
          if($this->isCompleteReadsSuministros()){
        /* foreach($this->sigiCuentaspor as $cuentapor){
            $err=$cuentapor->generateFacturacion();
            if(count($err)>0){
                $errores['error']=yii::t('sigi.errors','Se presentaron algunos incovenientes'); 
            }else{
               $errores['success']=yii::t('sigi.errors','Se ha generado la facturacion sin problemas '.$this->balanceMontos());  
            }
          }*/
           try{
                $this->shortFactu();
           } catch (\Exception $ex) {
               $this->addError('fecha',$ex->getMessage());
           }
          
           if($this->hasErrors()){
                $errores['error']=$this->getFirstError();//array_values($this->firstErrors[0]);
            return $errores;
           }
           
           
          $this->asignaIdentidad();//Importante  
           $this->asignaNumero();
           $this->updateAllMontoKardex();
          //$this->resolveTransferencias();
           
        }else{
            
           $errores['error']=yii::t('sigi.errors','Hay suministros que aun no tienen lectura verifique por favor'); 
        } 
       }else{
           $errores['error']=yii::t('sigi.errors','Falta agregar recibos o conceptos en la facturación');  
       }
       
       //Verificando que todos los recibos tengan la misma moneda 
        }else{
            $errores['error']=yii::t('sigi.errors','Existe más de una moneda verifique los detalles');
        }
        return $errores;
    }
    
    private function resolveTransferencias(){
        /*yii::error('--resolve transferencias---');
          yii::error(count($this->transfEsteMesModels()));
        foreach($this->transfEsteMesModels() as $model){
            $model->resolveParent();
        }*/
    }
    
    private function unResolveTransferencias(){
       /* foreach($this->transfEsteMesModels() as $model){
            $model->unResolveParent();
        }*/
    }
    /*
     * Esta funcion revisa la columna kardex_id de
     * la tabla facturaciondetalle y la catualiza
     * segune lgrupo de facturacion , de este modo ya se puede separar
     * lso recibos mediante un id 
     */
    public function asignaIdentidad(){
        $unidades_id=SigiDetfacturacion::find()->select(['unidad_id'])->
        distinct()->
                andWhere(['facturacion_id'=>$this->id,'kardex_id'=>null])->asArray()->all(); 
          foreach($unidades_id as $unidad){
             $identidad= $this->kardexDepa($unidad['unidad_id'],true);
            // var_dump($identidad->id);
              SigiDetfacturacion::updateAll([
                  'kardex_id'=>$identidad->id],
                      [
                        'facturacion_id'=>$this->id,
                         'kardex_id'=>null,
                          'unidad_id'=>$unidad['unidad_id']
                          
                      ]
                      
                      );
          }  
        
        //$criteria=['facturacion_id'=>$this->id,'kardex_id'=>null];
        //foreach($this->grupos() as $filaGrupo){
         // $criterio= SigiDetfacturacion::criteriaDepa(
                  /*$filaGrupo->grupofacturacion,
                  $filaGrupo->mes,
                  $filaGrupo->anio,
                  $filaGrupo->facturacion_id,
                  $filaGrupo->dias
                  );*/
            /* $detalle=  SigiDetfacturacion::find()->andWhere($criteria)->one();
           if(!is_null($detalle)){
              $identidad= $this->kardexDepa($detalle->unidad_id);
              //$criteria['identidad']=$identidad->id;
              SigiDetfacturacion::updateAll(['kardex_id'=>$identidad->id], $criteria);//    teAll($criteria);
           }*/
          
       //}
       //return true;
    }
    
    
    public function grupos(){
       return  $this->getSigiDetfacturacion()->
                select(['grupofacturacion','mes','anio','facturacion_id','dias'])->
                distinct()->all();
        
    }
    
    public function idsToFacturacion(){       
       return  array_column($this->getSigiDetfacturacion()->
                select('identidad')->distinct()
                ->all(),'identidad');        
    }
    
     public function idsKardex(){       
       return  array_column($this->getSigiDetfacturacion()->
                select('kardex_id')->distinct()
                ->all(),'kardex_id');        
    }
    
    public function idsColectores(){
       return  array_column($this->getSigiCuentaspor()->
                select('colector_id')->distinct()
                ->all(),'colector_id');
        
    }
    
    public function idsColectoresInBudget(){
       return  array_column(SigiBasePresupuesto::find()->
                select('cargosedificio_id')->distinct()->
               where([
                   'edificio_id'=>$this->edificio_id,
                     'ejercicio'=>$this->ejercicio,
                   ])->all(),'cargosedificio_id');
        
    }
    
    public function idsToCuentasPor(){
       return  array_column($this->getSigiCuentaspor()->
                select('id')->distinct()
                ->all(),'id');
        
    }
    
    
    
    /*Verifica que todos los medidores tengan su lectura*/
    public function isCompleteReadsSuministros(){
        $iscomplete=true;
        $tipomedidores=$this->edificio->typeMedidores();
   IF(count($tipomedidores)>0){
        foreach($tipomedidores as $key=>$type){
        $nlecturas=SigiLecturas::find()->where(
                ['edificio_id'=>$this->edificio_id,
                    'mes'=>$this->mes,
               'facturable'=>'1',
                    'codtipo'=>$type,
                   // 'activo'=>'1',
                ])->count();
       
      if($nlecturas ==0){
          $iscomplete=false; 
        break;   
      }
      $nmedidores=$this->edificio->nMedidores($type); 
       //var_dump($nmedidores,$nlecturas,$nlecturas % $nmedidores);die();
          if(($nlecturas % $nmedidores) <> 0) //Si las cantidades SON multiplos de la cantidad de medidores entonces OK           
          {
             $iscomplete=false; 
           break;     
          }
           }
   }else{
       return true;
   }
   
    return $iscomplete;      
          }
    
    /*Dataprovider de los mediores que faltan lecturas*/
    public function providerFaltaLecturas($type){
       $idsMedidores=$this->edificio->idsMedidores($type);
      $idsFaltan=[];
           $idsConLecturas=array_column(SigiLecturas::find()->select('suministro_id')
                ->where([
                    'edificio_id'=>$this->edificio_id,
                    'mes'=>$this->mes,
                    'anio'=>$this->ejercicio,
                    // 'flectura'=>static::SwichtFormatDate($this->fecha, 'date',false),
                   'facturable'=>'1',
                    'codtipo'=>$type,
                        ])->asArray()->all(),'suministro_id');
             /*var_dump(SigiLecturas::find()->select('suministro_id')
                ->where([
                    'edificio_id'=>$this->edificio_id,
                    'mes'=>$this->mes,
                    'anio'=>$this->ejercicio,
                    // 'flectura'=>static::SwichtFormatDate($this->fecha, 'date',false),
                   'facturable'=>'1',
                    'codtipo'=>$type,
                        ])->createCommand()->getRawSql());die();*/
                $idsTotales=$this->edificio->idsMedidores($type);
                
                $idsFaltan= array_diff($idsTotales,  $idsConLecturas);
               /* print_r($idsTotales);
                echo "<br><br><br><br><br>";
                 print_r($idsConLecturas);
                 echo "<br><br><br><br><br>";
                  print_r($idsFaltan);
              var_dump($idsTotales,$idsConLecturas,$idsFaltan);
               
               die();*/
              $query= SigiSuministros::find()->where(['in','id',$idsFaltan]);        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]); 
        return $dataProvider;
    }
    
    public function resetFacturacion(){
       if(!$this->isRelated()){//Siempre que no este relacionado
      $borrados= \frontend\modules\sigi\models\SigiDetfacturacion::deleteAll(['facturacion_id'=>$this->id]);
         //yii::error('borrados '.$borrados.'  Registros de detalle facturacion');
      $borrados= \frontend\modules\sigi\models\SigiKardexdepa::deleteAll(['facturacion_id'=>$this->id]);
       //yii::error('borrados '.$borrados.'  kardex depa');
      \frontend\modules\sigi\models\SigiLecturas::updateAll(['cuentaspor_id'=>null],
              [ 
                 'mes'=>$this->mes,
                  'anio'=>$this->ejercicio,
                  'cuentaspor_id'=>$this->idsToCuentasPor()
            ]);
         return true;
       } else {
          return false; 
       }
      
      //$this->unResolveTransferencias();
      
    }
            
  public function generateTempReads(){
      
  } 
  /*
   * Verifica que la suma de los notos de cuentas por
   * DEBE DE SER IGUAL A La Suma de los valores
   * de detfacturacion
   * Es un balance 
   */
   public function balanceMontos(){
      return $this->montoFacturado()-$this->montoTotal();
   }
   
   public function montoFacturado(){
       $valor=$this->detfacturacionQuery()->select('sum(monto)')->scalar();
       //var_dump($valor);die();
      return  is_null($valor)?0:$valor;
   }
   
   public function numeroRecibos(){
      return  $this->detfacturacionQuery()->select('kardex_id')->distinct()->count();
   }
   public function detfacturacionQuery(){
      return SigiDetfacturacion::find()->where(['facturacion_id'=>$this->id]); 
   }
   /*
    * Citeriop de filtro del mes anterior*/
    
   private function previousQuery(){
      
        $mesprev=($this->mes=='1')?'12':(($this->mes-1).'');
        $anioPrev=($this->mes=='1')?(($this->ejercicio-1).''):$this->ejercicio;
      return $this->getSigiDetfacturacion()->where(['mes'=>$mesprev,'anio'=>$anioPrev]);
   }
   //nUMERO MAXIMO ANTEIROR DEL RECIBO , DONDE SE QUEDO
   private function numeroAnterior(){
       RETURN $this->previousQuery()->max(numero);
   }
   
   private function asignaNumero(){
       $mes= str_pad( $this->mes , 2,  "0",STR_PAD_LEFT);       
   $depas=$this->getSigiDetfacturacion()->select(['grupofacturacion','dias'])->distinct()->orderBy('grupofacturacion ASC')->asArray()->all();
     $contador=1;
      foreach($depas as $key=>$depa){
          $numero=$this->ejercicio.'-'.$mes.'-'.str_pad( $contador.'' , 3,  "0",STR_PAD_LEFT);      
          SigiDetfacturacion::updateAll(['numerorecibo'=>$numero],['dias'=>$depa['dias'],'grupofacturacion'=>$depa['grupofacturacion'],'facturacion_id'=>$this->id]);
          $contador++;
      }
   }
   
   
    public function validateFechas($attribute, $params)
    {
      // $this->toCarbon('fecingreso');
       //$this->toCarbon('cumple');
       //self::CarbonNow();
       //var_dump(self::CarbonNow());
        
       if($this->toCarbon('fecha')->greaterThan($this->toCarbon('fvencimiento'))){
            $this->addError('fvencimiento', yii::t('base.errors','La fecha  {campo} es una fecha anterior a la fecha emisión',
                    ['campo'=>$this->getAttributeLabel('fvencimiento')]));
       }
     
    }
 
 public function beforeValidate() {
     yii::error('before validate');
     if($this->getScenario()==self::SCE_BATCH)
      $this->resolveBatch();
     return parent::beforeValidate();
 }
 
  public function beforeSave($insert){
      
      if($insert){
          $this->estado=self::EST_CREADO;
      }
      return parent::beforeSave($insert);
  }
  
  /*
   * Funcio que obtiene el registro unico para 
   * recolectar las cobranzas de los departamenteos
   * afiliados de la inmobiliaria 
   */
  private function hasKardexDepaComun(){
      if(empty($this->unidad_id))
      throw new ServerErrorHttpException(Yii::t('base.errors', 'No ha especificado la unidad general para  cobranza masiva'));
 return SigiKardexdepa::find()->where([
      'edificio_id'=>$this->edificio,
      'unidad_id'=>$this->unidad_id,//esta valor es la unidad id de l a
      'facturacion_id'=>$this->id,
      ])->one();
      
  }
  
  private function hasKardexDepa($unidad_id){
      return SigiKardexdepa::find()->where([
      'edificio_id'=>$this->edificio,
      'unidad_id'=>$unidad_id,
      'facturacion_id'=>$this->id,
      ])->one();
      
  }
  
  private function kardexDepaComun(){
      $registro=$this->hasKardexDepaComun();
    if(is_null($registro)){
        $attributes=[
        'edificio_id'=>$this->edificio_id,
        'unidad_id'=>$this->unidad_id,
        'facturacion_id'=>$this->id,
        'mes'=>$this->mes,
        'anio'=>$this->ejercicio,
        'fecha'=>$this->fecha,
       
            ];
        
     $modelo=New SigiKardexdepa();
     $modelo->setAttributes($attributes);
    
      if($modelo->save()){
          //var_dump('0k');die();
      }else{
       
        var_dump($modelo->getErrors());die();  
      }
      return $modelo;
    }else{
      return $registro;  
    }
    
  }
  
    public function kardexDepa($unidad_id,$force=false){  
         $registro=$this->hasKardexDepa($unidad_id);
    if(is_null($registro) or $force){
        $attributes=[
        'edificio_id'=>$this->edificio_id,
        'unidad_id'=>$unidad_id,
        'facturacion_id'=>$this->id,
        'mes'=>$this->mes,
        'anio'=>$this->ejercicio,
        'fecha'=>$this->fecha,
       // 'monto'=>
            ];
     $modelo=New SigiKardexdepa();
     $modelo->setAttributes($attributes);
      if($modelo->save()){
          //var_dump('0k');die();
      }else{
        var_dump($modelo->getErrors());die();  
      }
      return $modelo;
    }else{
      return $registro;  
    }
  }
  
  
  
  
  public function hasCobranzaMasiva(){
      $valor=false;
     foreach($this->edificio->apoderados as $apoderado){
         if(!$apoderado->cobranzaindividual && $apoderado->hasDepasImputables()){
            $valor=true; break; 
         }
    }
    return $valor;
  }
  
  /*Facturacion sin nmucho detalle */
  public function shortFactu(){
      set_time_limit(300);
      /*
      * Tomamos el control del tiempo
      */
     $tiempoInicio= microtime(true);
     
      /*Solo unidades padres que sean imputables*/
     //$unidades= $this->edificio->unidadesImputablesPadres();
     
     
     
     
     $unidadesTransferidas=array_combine(array_column($this->transfEsteMes(),'unidad_id'),array_column($this->transfEsteMes(),'fecha'));
     //YII::ERROR('UNIDADES TRANSFERIDAS');
     //YII::ERROR($unidadesTransferidas);
     //var_dump(date('j',strtotime($unidadesTransferidas[6795])));die();
     //$medidorAACC=$this->edificio->firstMedidorAACC();
     
     
     /*Si debe de cobrar masivamente, verifica que el apoderado
      * exiga facturacion masiva, por ejemplo la inmobiliaria 
      * quiere pagar de todos los recibos de un solo cocacho */
     $hasCobranzaMasiva=$this->hasCobranzaMasiva();
     
     if($hasCobranzaMasiva){
       //Obteniendo la unidad Grupal 
          //yii::error('OBTENIENDIO LA UNIDAD GRUPAL',__FUNCTION__);
      $kardexGrupal=$this->kardexDepaComun();
       $kardexGrupal->refresh();  
       //yii::error('ID kardex grupal',__FUNCTION__);
        //yii::error($kardexGrupal->id,__FUNCTION__);
     }else{
        //yii::error('NO tiene cobranza masiva',__FUNCTION__);  
     }
      
     $diasEnEsteMes=30;//date('t',strtotime($this->swichtDate('fecha',false)));
     
     
     //yii::error('tiempos de espera',__FUNCTION__);
     $tiempoEspera=h::gsetting('general','nSegundosEsperaApache');
    
     
     foreach($this->unidadesFacturablesQuery()->batch(10) as $unidades ){
          foreach($unidades as $unidad){
        $tiempoFinal= microtime(true);
        /*
         * Controlamos el tiempo de ejecucion 
         */
        
        //yii::error(h::gsetting('general','nSegundosEsperaApache'),__FUNCTION__);
       //yii::error('diferencia',__FUNCTION__);
        //yii::error($tiempoFinal-$tiempoInicio,__FUNCTION__);
       //yii::error($tiempoFinal,__FUNCTION__);
        if($tiempoEspera < ($tiempoFinal-$tiempoInicial)){
        
          // yii::error('********** Recorriendo unidad  '.$unidad->numero.'*******************');
       
         ///verficando primero si la unidad ha sido transferida 
        
        
        $dias=$diasEnEsteMes;
        
        if(in_array($unidad->id,array_keys($unidadesTransferidas))){
             //yii::error(' '.$unidad->numero.'*********HA SIDO TRANSFERIDA**********');
        
            $dias=date('j',strtotime($unidadesTransferidas[$unidad->id])); 
            //yii::error('*********DIAS**********  '.$dias);
        }else{
           $dias=$diasEnEsteMes;  
        }
        //yii::error(' Dias en este mes '.$diasEnEsteMes);
         //yii::error(' Dias '.$dias);
       //var_dump($unidadesTransferidas);die();
        
        
        /************************************************
         * Obteniendo la identidad del recibo ($identidad) 
         * y el flag si es resumido o no 
         ************************************************/
        $esResumido=false;
        if($hasCobranzaMasiva){
                  if($unidad->miApoderado()->cobranzaindividual){
                      $modeltemp=$this->kardexDepa($unidad->id);
                       $identidad=$modeltemp->id; unset($modeltemp);
          
                     }else{
                         if($dias==$diasEnEsteMes){
                             /*Solo en el caso de que esta unidad no sea
                              * parte de una transferencia, en otro
                              * caso no incluirlo en el resumido,
                              * si no insertarlo como recibo individual
                              * osea a qui no va
                              */
                             $identidad=$kardexGrupal->id; 
                             $esResumido=true;
                         }                       
                  } 
         }else{
                     $modeltemp=$this->kardexDepa($unidad->id);
                     $identidad=$modeltemp->id; unset($modeltemp);
         }
         /**********************
          * Ok ya obtuvioms la identidad del recibo
          ****************************************/
       
       
        /*************************************
         *   Recorriendo las cuentas por  (SigiCuentaspor Detalle de facturacion)
         *************************************/ 
         yii::error('******Recorreindo los conceptos ***********');
        foreach($this->sigiCuentaspor as $cuenta){
           
            $colector=$cuenta->colector;
             yii::error(' Recorriendo cuentas -> '.$colector->cargo->descargo);
            //yii::error(' Recorriendo cuentas  '.$colector->cargo->descargo);
           /*Verificando primero si es un cobro individual para un departamento*/
           if($colector->isMassive()){  
                yii::error(' Es masivo');           
             /*Verificando luego si es un medidor*/
             if($colector->isMedidor()){
                 
                 /*Se obtiene el suministro medidor*/
                 $medidor=$unidad->firstMedidor($colector->tipomedidor);
                 // yii::error(' verificando si es medidor -> '.$colector->cargo->descargo);
                 if(!is_null($medidor)){
                     //yii::error('Este colector es un medidor');
                     /*Se obtiene el factor de AACC si no tiene medidores en AACC =0 
                    * esto es el factor del consumo de todos las areas comunes
                        */
                      yii::error('Participacion Aacc medidor->porcConsumoAaCc() :'.$medidor->porcConsumoAaCc($cuenta->mes,$cuenta->anio));
                        $participacionAACC=$medidor->porcConsumoAaCc($cuenta->mes,$cuenta->anio);
                        $participacionImputados=1-$participacionAACC;
                       yii::error('Participacion imputados :'.$participacionImputados);
                     yii::error('Participacion medidor->participacionRead() :'.$medidor->participacionRead($cuenta->mes,$cuenta->anio));
                         
                     $participacion=$medidor->participacionRead($cuenta->mes,$cuenta->anio);
                   
                     $monto=round($participacion*($cuenta->monto*$participacionImputados),6);
                    //yii::error('El monto es '.$monto);
                     /***insertar un registrio en el detalle de factuaración SigiDetFacturacion  ****/
                    if(!$cuenta->existsDetalleFacturacion($unidad,$colector,false,$dias)){
                        //yii::error(' Inserta registroco aacc=0');
                        //participacion= $participacionimputados  para que $cuenta->insertaregistro()calcule el monto total solo de los imputados
                        $cuenta->insertaRegistro($identidad,$unidad,$medidor,$monto,'0',$participacionImputados,$dias,$esResumido);
                        
                    }
                       /*****************************/
                 }else{
                    
                 }
                     $monto=0;
                     
                     /******Recorreidno los medidores de aareas comunes
                      * Recordar que estos medidores se anclan o se registran
                      * dentro de una unidad que es imputable=0
                      */
                     yii::error(' recorriendo los medidores aacc  ');
                       $nMedidoresAACC=$this->edificio->nMedidoresAaCc();
                         foreach($this->edificio->medidoresAaCc() as $medidorAACC){
                            if($medidorAACC->hasUnitAfiliado($unidad->id)){
                                //yii::error('Esta unida esta afiliada a este medidor '.$medidorAACC->unidad->numero);
                                /*Siempre que esta unidad este afiliada al medidor AACC
                                
                             /*En este calculo se obtiene = (consumo actual) /(Consumo total) */
                            // $participacionAACC=$medidorAACC->participacionRead($cuenta->mes,$cuenta->anio);
                            /********************************
                             * Se agrega el monto ya calculado
                             * ****************************** */
                                
                                /*Ojo que la participacionAACC no se calcula por medidor 
                                 * se calcula por recibo. Por ejemplo si el recibo tiene 
                                 *  1000 soles :  800 unidades y 200 areas comunes 
                                 * $medidorAACC->porcConsumoAaCc()= 20% independientemente
                                 * de cuantos medidores haya
                                 * 
                                 * $medidorAACC->participacionRead() este si es para cada meiddor
                                 */
                             $participacionAACC=$medidorAACC->porcConsumoAaCc($cuenta->mes,$cuenta->anio);
                             yii::error('paraticipacion de este medidor :'.$participacionAACC);
                             if($medidorAACC->plano){  
                                yii::error('Este mdidor es plano');
                                  
                                  
                                $ndepasafiliados=$medidorAACC->ndepasRepartoPadres(); 
                                
                                yii::error('cantidad de departamentos afiliados :'.$ndepasafiliados);
                                if($ndepasafiliados>0){
                                    $montoAux=$participacionAACC*
                                            //$medidorAACC->participacionRead($this->mes,$this->ejercicio)*
                                            $cuenta->monto/($nMedidoresAACC*$ndepasafiliados);
                                    //yii::error('monto auxi= '.$participacionAACC.' * '.$cuenta->monto.'/('.$ndepasafiliados.'*'.$nMedidoresAACC.'  ) = '.$montoAux);
                                    /*Aqui ya no es incrementable el monto,(osea monto=monto+ ...  es un solo calculo total*/
                                    $monto+= $montoAux;
                                  }
                             }else{
                                 $montoaux=$participacionAACC*
                                            $medidorAACC->participacionRead($this->mes,$this->ejercicio)*
                                             $cuenta->monto*
                                            $medidorAACC->porcPartUnidadAfiliada($unidad);
                                $monto+=$montoaux;
                                /*yii::error('participacionAACC '.$participacionAACC);
                                yii::error('medidorAACC->participacionRead() '.$medidorAACC->participacionRead($this->mes,$this->ejercicio));
                                yii::error('areas afiliadas  : '.$medidorAACC->areasAfiliadas);
                                yii::error('area unidad  : '.$unidad->areaTotal());
                                yii::error('$medidorAACC->porcPartUnidadAfiliada '. $medidorAACC->porcPartUnidadAfiliada($unidad));
                                
                                YII::ERROR('monto total del recibo : '.$cuenta->monto);
                                yii::error('El monto que va sumando participacionAACC*medidorAACC->participacionRead()* $medidorAACC->porcPartUnidadAfiliada * monto total del recibo: '.$montoaux);
                                */
                             }
                            } else{
                                //yii::error(' Esta unida no esta afiliada a este medidor '.$medidorAACC->unidad->numero);
                            } 
                         }
                 /***insertar un registro  por todas las sumas de estos montos****/
                  if(!$cuenta->existsDetalleFacturacion($unidad,$colector,true,$dias) && $monto > 0){
                     //yii::error('insertando un registro con aac=1 el monto es  '.$monto);
                     
                                             /*$identidad,$unidad,$medidor,$monto,  $aacc, $participacion     ,$dias,$esResumido ) */
                      $cuenta->insertaRegistro($identidad,$unidad,null     ,$monto, '1'   , $participacionAACC,$dias,$esResumido); 
                  }
                 
                 /*****************************/
                 
                }else{
                 //yii::error(' No Es medidor');   
                /***************************************************
                 * En el caso de que el registro detalle Sigicuentaspor no se aun colector 
                 * Puede ser un presupuesto o un prorateo
                 *************************************************/  
                 //( Area de esta unidad+ Sum(areas hijas))/(Area total del edificio))*monto
                $monto=round($unidad->porcWithChilds()*$cuenta->monto,10);
                //yii::error('Monto es  '.$monto);
                /***insertar un registro****/
                if(!$cuenta->existsDetalleFacturacion($unidad,$colector,false,$dias))
                   //yii::error(' Insertando registrio');  
                        $cuenta->insertaRegistro($identidad,$unidad,null,$monto,'0',$unidad->porcWithChilds(),$dias,$esResumido);
                 /*****************************/
                 
                   }
                }else{
                 /***************************************************
                 * En el caso de que el registro detalle Sigicuentaspor 
                 * Sea un  cobro individual como una multa
                 *************************************************/      
                   if($cuenta->unidad_id>0 && $cuenta->unidad_id==$unidad->id) {
                       /***insertar un registrio****/
                       if(!$cuenta->existsDetalleFacturacion($unidad,$colector,false,$dias))
                    $cuenta->insertaRegistro($identidad,$unidad,null,$cuenta->monto,'0',1,$dias,$esResumido);
                      /*****************************/
                     
                  }                    
                  /***************************************************
                 * Si tiene saldos en la facturacion anterior 
                 *************************************************/ 
                       if(($saldo=$this->saldoAnterior($unidad))>0){
                        $cuenta->insertaRegistro($identidad  ,$unidad,null,$saldo,'0',1,$dias,$esResumido);
                                                /*$identidad,$unidad,$medidor,$monto,  $aacc, $participacion     ,$dias,$esResumido ) */
                       }                       
                  /***************************************************
                 * Si la cuenta esta afecta a mora 
                 *************************************************/ 
                       if(abs($colector->tasamora) >0){
                        //$cuenta->insertaRegistro($identidad,$unidad,null,$saldo,'0',1,$dias,$esResumido);
                                                /*$identidad,$unidad,$medidor,$monto,  $aacc, $participacion     ,$dias,$esResumido ) */
                       } 
            }
          }
           //yii::error('********** FIN DE  unidad  '.$unidad->numero.'*******************');
      
       }else{
         $this->addError('fecha',yii::t('base.errors','El tiempo de respuesta se ha agotado, pero el procedimiento no se ha completado aún, repita el proceso para retomarlo'));
         break;
     }
       
     
      }
     }
  }
  /*
   * Devuelve las transferencias de departamentos 
   * acaecidas durante el mes de la facturacion 
   * 
   */
  public function transfEsteMes(){
      
      $bordes=$this->fechasBordes();
       yii::error(SigiTransferencias::find()->select(['unidad_id','fecha'])->where([
             'between',
             'fecha',
             $bordes[0],
             $bordes[1],
                        ])->createCommand()->getRawSql());
     return  SigiTransferencias::find()->select(['unidad_id','fecha'])->where([
             'between',
             'fecha',
             $bordes[0],
             $bordes[1],
                        ])->andWhere(['activo'=>'1'])->asArray()->all();
    
  }
  
  /*
   * Devuelve las transferencias de departamentos 
   * acaecidas durante el mes de la facturacion 
   * 
   */
  public function transfEsteMesModels(){
      $bordes=$this->fechasBordes();
     
     return  SigiTransferencias::find()->where([
             'between',
             'fecha',
             $bordes[0],
             $bordes[1],
                        ])->all();
     
  }
  
  private function fechasBordes(){
      $inicio=$this->toCarbon('fecha')->subMonth()->startOfMonth()->subDay();
      $final=$inicio->copy()->endOfMonth()->addDay()->addMonth();
      return [$inicio->toDateString(),$final->toDateString()];
  }
  /*
   * PARTICIONA UN RECIBO si ha habido 
   * una transferenia durantre el mes de
   * la facturacion, proporcionalmente a los 
   * días nenter uno y otor propietario
   */
  public function particionarRecibo($unidad_id,$day,$grupocobranza,$grupofacturacion){
     //var_dump($identidad);die();
      $rows=$this->getSigiDetfacturacion()->where(['unidad_id'=>$unidad_id])->all();
     /*
      * Primero nos aseguramos que haya registros 
      */
      if(count($rows)>0) {
          
          //Primero vamos a determinar los 2 id_kardex en los mcuales
          //se distribuiran las particiones 
          // $primerKardex  y $segundoKardex
          
          /*
           * Si se trata de un id_kardex que esta resumido (Osea 
           * es de un recibo totalizado),  entonces se debe 
           * de crear uno nuevo (note que force=true). Esto 
           * porque el id kardex de resumido puede estar com`partido
           * por otros recibos
           */
         if($rows[0]->resumido){
             $primerKardex=$this->kardexDepa($unidad_id,true);
         }else{
             /*
              * En cambio si no es resumido, ya no se debe de crear
              * uno nuevo no es necesario 
              */
             $primerKardex=$this->kardexDepa($unidad_id); 
         }
         
         $segundoKardex= $this->kardexDepa($unidad_id, true);
         
     foreach($rows as $row ){        
         $model=New SigidetFacturacion();
         $model->attributes=$row->attributes;
         $model->setAttributes([
             'id'=>null,
             'kardex_id'=>$segundoKardex->id,
             'grupocobranza'=>$grupocobranza,
              'grupofacturacion'=>$grupofacturacion,             
             'monto'=>round($row->monto*$day/30,3),
         ]);
         $model->save();
         
     }
     $factor=1-$day/30;
     $expresion='monto*(1-'.$factor.')';
       SigiDetfacturacion::updateAll(['monto'=>NEW \yii\db\Expression($expresion)],
               ['kardex_id'=>$primerKardex->id]);
    
     }
       
  }
  
  
  
  public function resolveRecibosPartidos(){
     foreach($this->transfEsteMes() as $row) {        
        $unidad= SigiUnidades::findOne($row['unidad_id']);
        //var_dump($unidad->numero);
         $grupocobranza=(!$unidad->miApoderado()->cobranzaindividual)?$unidad->codpro:$unidad->numero;
         $grupofacturacion=(!$unidad->miApoderado()->facturindividual)?$unidad->codpro:$unidad->numero;
         $identidad=$this->getSigiDetfacturacion()->where(['unidad_id'=>$row['unidad_id']])->one()->identidad;    
        
// var_dump($this->getSigiDetfacturacion()->where(['unidad_id'=>$row['unidad_id']])->createCommand()->getRawSql());
         $day = date('j', strtotime($row['fecha']));
         $this->particionarRecibo($identidad, $day, $grupocobranza, $grupofacturacion);
     }
  
  }
  
  /*
   * Esta función es la que completa datos del kardex pasada la facturacion
   */
  private function completeDataKardex(){
      
  }
  
  /*Suma los nmotos cobrados */
  
 /* public function montocobrado(){
      return $this->getKardexDepa()->select('sum(monto)')->andWhere(['cancelado'=>'1'])->scalar();
  }*/
  
  public function porcentajeCobranza(){
      if($this->montoTotal()<=0) return 0;
      return 100*round(1-$this->deuda()/$this->montoTotal(),4);
  }
  
  /*Envia un correo nmasivo a los departamentos para 
   * entergarles su recibo*/
  public function sendMassiveRecibo(){
      $seconds=300;
      $tolerance=10;
      set_time_limit($seconds);
      try {
        $registros=SigiKardexdepa::find()->andWhere(['<','enviado',
          self::CarbonNow()->subSeconds($seconds-$tolerance)->format('Y-m-d H:i:s')
                   ])->andWhere(['facturacion_id'=>$this->id])->all();
     /* yii::error(SigiKardexdepa::find()->andWhere(['<','enviado',
          self::CarbonNow()->subMinutes(10)->format('Y-m-d H:i:s')
                   ])->andWhere(['facturacion_id'=>$this->id])->createCommand()->rawSql,__FUNCTION__);*/
      foreach($registros as $kardex){
         $kardex->mailRecibo();
      }  
      } catch (\yii\base\Exception $ex) {
          return ['error'=>$ex->getMessage()];
      }
      return ['success',yii::t('base.labels','Se enviaron masivamente los recibos')];
               
  }
   
 
  
  
  public function unidadesFacturablesQuery(){
      $idsFacturados=SigiDetfacturacion::find()->select(['unidad_id'])->distinct()->
              andWhere(['facturacion_id'=>$this->id])->
              orderBy(['id'=>SORT_ASC])->column();
     /*Eliminamos los dos últimos registros ids,si es que los hubiera,
      * esto con el fin de que si se interrumpió el proceso por termino 
      * de tiempo de respuesta, el proceso se reanude asegurándose de 
      * retomar dos ids procesados con anterioridad, quizas lso registros del último id
      * no fueron completados, de esta forma nos aseguramos de que se reanude
      * sin perder ninguna concatenacion
      * 
      * 
      * ---  ---- ---- ---- ---- ---- ---- <interrupcion>
      *            <Reanudacion> ---- ---- ----- ----- ---- ---- ---- ...asi sucesivamente
      * 
      */
      if(count($idsFacturados)>=2){
        array_pop($idsFacturados); array_pop($idsFacturados);  
      }
     
      
     /*yii::error(SigiUnidades::find()->andWhere(['edificio_id'=>$this->edificio_id])->andWhere([
             'imputable'=>'1',
                ])->andWhere(['parent_id'=>null])->andWhere(['not in','unidad_id',$idsFacturados])
             ->createCommand()->rawSql,__FUNCTION__);*/
  
     
      
      return SigiUnidades::find()->andWhere(['edificio_id'=>$this->edificio_id])->andWhere([
             'imputable'=>'1',
                ])->andWhere(['parent_id'=>null])->andWhere(['not in','id',$idsFacturados]);
  }
  
  
  public function recibo($idKardex,$disk=false){
      set_time_limit(300);
          ini_set("pcre.backtrack_limit", "10000000");
         $formato=$this->reporte->tamanopapel;
         $kardex=SigiKardexdepa::findOne($idKardex);
         

         
           //$dataProvider=(New SigiDetFacturacionSearch())->searchByIdentidad($idKardex);
           switch ($this->reporte_id) {
                case 1:
                  $dataProvider=(New SigiDetFacturacionSearch())->searchByIdentidad($idKardex);
                $contenido= h::currentController()->render('reports/recibos/recibo',['dataProvider'=>$dataProvider,'compacto'=>false]);
          
                break;
                case 2:
                    $dataProvider=(New SigiDetFacturacionSearch())->searchByIdentidad($idKardex);
                     $contenido= h::currentController()->render('reports/recibos/recibo',['dataProvider'=>$dataProvider,'compacto'=>false]);
          
                     break;
                 
                 case 3:
                            $dataProvider=(New SigiDetFacturacionSearch())->searchByIdentidad($idKardex);
                       $contenido= h::currentController()->render('reports/recibos/recibo',['dataProvider'=>$dataProvider,'compacto'=>true]);
          
                    break;
                case 4:
                    $datos=$kardex->groupDetailsForRecibo();
                    //yii::error($this,__FUNCTION__);
                     $contenido= h::currentController()->render('reports/recibos/recibo_complejo',['datos'=>$datos,'model'=>$this,'kardex'=>$kardex,'compacto'=>false]);
                //yii::error('recibo comlpejo',__FUNCTION__);
                //yii::error('Formato '.$formato,__FUNCTION__);
                        // $contenido= h::currentController()->render('@frontend/modules/sigi/views/facturacion/reports/recibos/recibo_complejo',['dataProvider'=>$dataProvider,'compacto'=>false]);
          
                    break;
                    
                 default:
                 $contenido= h::currentController()->render('reports/recibos/recibo',['dataProvider'=>$dataProvider,'compacto'=>false]);
          
            }
             $pdf=ModuleReporte::getPdf(['format'=>$formato]);
                
             
            /*
             * Tamaño de papel
             */
             //$stylesheet = file_get_contents(\yii::getAlias("@frontend/web/css/reporte.css")); // external css
              // $pdf->WriteHTML($stylesheet, 1);
             $pdf->WriteHTML($contenido);
             yii::error('paso Write html');
            if(!$disk){
                // $ruta=$this->pathTempToStore();
               //yii::error('y la ruta es  '.$ruta); 
                $pdf->output(/*$ruta, \Mpdf\Output\Destination::FILE*/);
            }else{
                 yii::error('escribiendo en disco',__FUNCTION__);
                $ruta=$this->pathTempToStore();
                 yii::error('ruta '.$ruta,__FUNCTION__);
                  yii::error('haciendo el  output al file  '.$ruta,__FUNCTION__);
                $pdf->output($ruta, \Mpdf\Output\Destination::FILE);  
                yii::error('YA BHIZO EK OUTPUR '.$ruta,__FUNCTION__);
                
                $kardex->deleteAllAttachments();
                $kardex->attachFromPath($ruta);
                @unlink($ruta);
            }
  }
  
  public function purgeRecibos(){
       $ruta=$this->pathRecibos();
      FileHelper::deleteDirectory($ruta,true);//TRUE PRESERVAR LA CARPETA
      $contador=0;
      foreach($this->kardexDepa as $kardex ){
            $kardex->deleteAllAttachments();
                $contador++;
          }
      return $contador;
  }
  
  public function generaRecibos(){
      //$this->purgeRecibos();
      //YII::ERROR('ENTRNADO EN GENERA RECIBOS');
      $sesion=h::session();
      if($sesion->has($this->hashSesion())){
          
      }else{
        
      }
      
      
      $contador=0;
      $kardexes= SigiDetfacturacion::find()-> 
       select(['kardex_id'])->distinct()->andWhere(['facturacion_id'=>$this->id])->
       orderBy(['grupounidad'=>SORT_ASC])->
          asArray()->all();
       //yii::error('KARDEXES');
     // yii::error($kardexes);
      foreach($kardexes as $kardex ){
          //YII::ERROR('EN EL BUCLE   KARDEX_ID '.$kardex['kardex_id']);
          $kardexModel=SigiKardexdepa::findOne($kardex['kardex_id']);
          if(!$kardexModel->hasAttachments()){
              //yii::error('kardex id no tiene arttach  '.$kardex['kardex_id'],__FUNCTION__);
            // yii::error('entrando a la funcion recibo',__FUNCTION__);
            
              $this->recibo($kardex['kardex_id'],true);
                $contador++; 
            }else{
              //YII::ERROR(' KARDEX_ID tiene attach '.$kardex['kardex_id']);  
            }
            unset($kardexModel);
          }
      
         // $this->compileRecibos();
      return $contador;
  }
  
  
  public function pathTempToStore($name=null){
       // $rutaTemp=\yii::getAlias('@frontend/web/img_repo/temp/'. uniqid().'.zip');
      
      $dir=\yii::getAlias('@frontend/web/sigi/temp/');
     
      if(!is_dir($dir)){
          mkdir($dir);
      }
      if(is_null($name))
      return $dir.uniqid().'.pdf';
      return $dir.$name.'.pdf';
  }
  
  
  public function compileRecibos(){
      /*Limpiamos primero los recibos*/
      $ruta=$this->pathRecibos();
      FileHelper::deleteDirectory($ruta,true);//TRUE PRESERVAR LA CARPETA
     $tamano=h::gsetting('sigi','nRecibosBloque');    
     $arch=[];
     $i=1;
     foreach($this->getKardexDepa()->orderBy(['unidad_id'=>SORT_ASC])->batch($tamano) as $kardexes ){
         
          $mpdf = new \Mpdf\Mpdf(['format'=>$this->reporte->tamanopapel]);
        
         foreach($kardexes as $kardex){
             yii::error('el kardex id es  '.$kardex->id,__FUNCTION__);
                $mpdf->AddPage();
                $pagecount = $mpdf->SetSourceFile($kardex->files[0]->path);
                    if ($pagecount > 0) {
                        for ($k = 1; $k <= $pagecount; $k++) {                  
                                $tplId = $mpdf->ImportPage($k);
                                $mpdf->UseTemplate($tplId);
                                    if ($k < $pagecount) {
                                        $mpdf->AddPage();
                                            }
                                                    }
                                    }
                            }
        $mpdf->Output($ruta.'BLOQUE_'.$i.'.pdf', \Mpdf\Output\Destination::FILE);
        $i++;
     } 
  }
  
  public function pathRecibos(){
      $dir=\yii::getAlias('@frontend/web/sigi/facturacion/');
      if(!is_dir($dir)){
        mkdir($dir);   
      }
         
      $dir.=$this->edificio->codigo.'/';
      
      if(!is_dir($dir)){
          //yii::error('segunda ',__FUNCTION__);
        mkdir($dir); 
      }
        
      $dir.=$this->mes.$this->ejercicio.'/';
      
      if(!is_dir($dir)){
         //yii::error('segunda ',__FUNCTION__);
         mkdir($dir); 
      }
           
     
     return $dir;
  }
  
  public function array_blocks_files(){
    $files=FileHelper::findFiles($this->pathRecibos(),['only'=>['*.pdf'],'recursive'=>false]);
    return $files;
  }
  
  
 public function isAprobado(){
     return ($this->estado==self::EST_APROBADO);
 }
  
 public function aprove($unAprove=false){
     $flag=($unAprove)?'0':'1';
     if($unAprove && $this->isRelated()){
         return false;
     }
     $this->estado=($unAprove)?self::EST_CREADO:self::EST_APROBADO;
     if($unAprove){//so se desap`rueba  ñlimpiare tosdos los recibos 
        $this->purgeRecibos(); 
     }
     SigiKardexdepa::updateAll(['aprobado'=>$flag], ['facturacion_id'=>$this->id]);
     
     return $this->save();
 }
 
 
 
 public  function updateAllMontoKardex(){
     $registros=$this->getKardexDepa()->all();
     foreach($registros as $registro){
         $registro->updateMonto();
     }
     return true;
  }
  
  public function deuda(){
     return round(VwKardexPagos::find()->select(['sum(deuda) as deuda'])->andWhere(['anio'=>$this->ejercicio,'mes'=>$this->mes,'edificio_id'=>$this->edificio_id])->scalar(),4);
   }
  
   /*
    * Esta funcion verifica que la facturacion 
    * esta comprometida en otros procesos, es decir 
    * ya no s epuede modificar nada. 
    * Esto mas por la inclusion de las cobranzas y movimientos 
    * bancacrios 
    */
  public function isRelated(){
      
      $isCompromise=false;
      $isCompromise= SigiMovimientosPre::find()->andWhere([
          'kardex_id'=>$this->idsKardex()
      ])->exists();
      
      
      return $isCompromise;
           
  } 
  
   public function montoCobrado(){
       return 0;
      //return  $this->detfacturacionQuery()->select('sum(monto)')->scalar();
   }
   
   public function previous(){
     return self::find()->select(['max(id)'])->andWhere(['<','id',$this->id])->
             andWhere([
                 'edificio_id'=>$this->edificio_id,
             ])->orderBy(['id'=>SORT_DESC])->one(); 
   }
           
  public function next(){
       return self::find()->select(['min(id)'])->andWhere(['>','id',$this->id])->
             andWhere([
                 'edificio_id'=>$this->edificio_id,
             ])->orderBy(['id'=>SORT_ASC])->one(); 
   }
   
  public function hasDetalle(){
      return $this->getSigiCuentaspor()->exists();
  }
  
  public function hasDetalleFacturacion(){
      return $this->getSigiDetfacturacion()->exists();
  }
  
  /*
   * Solo si tiene la cabecera o el registro de facturacion siguiente
   */
  public function hasNextFacturacion(){
     return (is_null($this->next()))?false:true;
  }
  public function hasPreviousFacturacion(){
     return (is_null($this->previous()))?false:true;
  }
  /*
   * SAi tiene facturacion siguiente pero con 
   * detalle
   */
  public function hasNextFacturacionWithDetail(){
      $modelNext=$this->next();
      if(!is_null($modelNext) && $modelNext->hasDetalle()){
          return true;
      }else{
          return false;
      }
  }
  
  public function hasPreviousFacturacionWithDetail(){
      $modelNext=$this->previous();
      if(!is_null($modelNext) && $modelNext->hasDetalle()){
          return true;
      }else{
          return false;
      }
  }
  
  public function isEditable(){
      //var_dump(!$this->hasNextFacturacionWithDetail(),!$this->hasDetalle());die();
     return (!$this->hasNextFacturacionWithDetail() && !$this->hasDetalleFacturacion() );
  }
    
  /*
   * Funcion que calcula el saldo de ajuste de
   * pagos por diferencia del mes anterior o la facturacion anterior
   */
 public function saldoAnterior($unidad ){
     $previo=$this->previous();
     $saldo=VwKardexPagos::find()->select(['deuda'])->andWhere([
         'unidad_id'=>$unidad->id,
         'mes'=>$previo->mes,
         'anio'=>$previo->ejercicio,         
         ])->andWhere(['<=','deuda',
             h::gsetting('sigi','montominimo_deudor')
             ])->scalar(); 
     return (is_null($saldo))?0:$saldo;
      
     } 
     
     
  public function testPDF(){
      $pdf=ModuleReporte::getPdf(['format'=>'A5-L']);  
       //$pdf=\frontend\modules\report\Module::getPdf(['format'=>'A4-L']);
     $pdf->WriteHTML("<div style ='position:absolute;  left:148px;  top:105px;  font-size:10;  font-family:cour;  color:#000;'>POSICION 148,105</div>");
               RETURN  $pdf->output(/*$ruta, \Mpdf\Output\Destination::FILE*/);
    
  }
  
  /*
   * Esta funcion recupera los documentos 
   * por cobrar o por pagar para incluirlos en el recibo mensual
   */
  public function rescueDocsFromEdificios(){
      $fechaLim=$this->toCarbon('fecha')->subMonths(3)->format(\common\helpers\timeHelper::formatMysqlDate());
                
      $criteria=['edificio_id'=>$this->edificio_id,
                  'en_recibo'=>'1',
                'facturacion_id'=>null,
                  ];
      /*$datos=(new \yii\db\Query())->from('{{%sigi_porpagar}}')
       ->andWhere(['>','fechadoc',$fechaLim])->where($criteria)->andWhere(['facturacion_id'=>null])->all();
     */ 
      $datos= SigiPorpagar::find()->andWhere($criteria)->all();
     /* echo SigiPorpagar::find()->andWhere($criteria)->createCommand()->rawSql;
      echo (count($datos));die();*/
     $docsIngresados=0;
      foreach($datos as $fila){
        if($this->insertDocu($fila)){
           $docsIngresados++;  
        } 
      }
      return $docsIngresados;
  }
  
  public function insertDocu($fila){
       //yii::error('avagdgdgdnxando0',__FUNCTION__);
      $scenario=(empty($fila['unidad_id']))?
              SigiCuentaspor::SCENARIO_RECIBO_EXTERNO_MASIVO:
              SigiCuentaspor::SCENARIO_RECIBO_INTERNO;
      $model= SigiCuentaspor::firstOrCreateStatic(
              ['facturacion_id'=>$this->id,
                  'edificio_id'=>$this->edificio_id,
                'codocu'=>$fila->codocu, 
                'numerodoc'=>$fila->numdocu, 
                  'descripcion'=>$fila->glosa, 
                   'codpro'=>$fila->codpro, 
                  'fedoc'=>$fila->fechadoc, 
                   'colector_id'=>$fila->cargoedificio_id,  
                   'mes'=>$this->mes, 
                  'anio'=>$this->ejercicio, 
                  'monto'=>$fila->monto, 
                  'codmon'=>$fila->codmon, 
                  'unidad_id'=>$fila->unidad_id, 
                  'mesconsumo'=>$this->mes, 
                  'anexado'=>true,
                  'consumo'=>0],
             $scenario,
              ['facturacion_id'=>$this->id,
                'codocu'=>$fila->codocu, 
                'numerodoc'=>$fila->numdocu,                
                   'codpro'=>$fila->codpro, 
                   
                  ],true);
      if(!is_null($model)){
         //yii::error('avanxando0',__FUNCTION__);
                 if($fila->hasAttachments())
                    $model->attachFromPath($d->files[0]->path);  
           $fila->facturacion_id=$this->id;
           //yii::error('VERIOFICANDO SI GRABA');
           $fila->save();
           
          return true;
      }else{
           //yii::error('retrocer',__FUNCTION__);
             return false;
      }
      
  }
 
 private  function hashSesion(){
    return h::userId().'_'.$this->id.'_facturacion';
 }
  
private function resolveBatch(){
    yii::error('resolve batch');
    $this->historico=true;
    $this->descripcion='Facturación '.\common\helpers\timeHelper::mes($this->mes).'  '.$this->ejercicio;
                 //yii::error($this->descripcion);
    
}
 /*
  * FUNCION QUE DEVUELVE UN ARRAY 
  * CON EL RESUMEN DE CONSUMOS DE AGUA
  * [
  *   'AACC'=>['CONSUMO'=>23,45M3,'MONTO'=>12.345],
  *   'INPUTADOS'=>['CONSUMO'=>23,45M3,'MONTO'=>12.345],
  * ]
  */
public function arrayConsumos(){
    $ids=$this->edificio->idsUnidadesNoImputables();
    $monto=$this->montoRecibo();
    //echo $monto; die();
    $resumen=[];
    $query=VwSigiLecturas::find()->select(['sum(delta)'])->
       andWhere([
           'edificio_id'=>$this->edificio_id,
           'mes'=>$this->mes,
           'anio'=>$this->ejercicio,
           'facturable'=>'1'
           ]);
    $imputados=(clone $query)->andWhere(['not in','unidad_id',$ids])->scalar();
    $aac=$query->andWhere(['unidad_id'=>$ids])->scalar();
   if(($imputados+0)>0 and ($aac+0)>0 ){
     $resumen['AACC'] =['CONSUMO'=>$aac,'MONTO'=>round(($aac/($aac+$imputados))*$monto,3)]; 
      $resumen['IMPUTADOS'] =['CONSUMO'=>$imputados,'MONTO'=>round(($imputados/($aac+$imputados))*$monto,3)];            
     return $resumen;
   }else{
       return [];
   }
    
    
}

public function montoRecibo(){
    $idColector=$this->edificio->idCargoAgua();
   if(!is_null($cargo=$this->getSigiCuentaspor()->
         andWhere(['colector_id'=>$idColector])->one())){
       return $cargo->monto;
   }else{
       return 0;
   }
}

}