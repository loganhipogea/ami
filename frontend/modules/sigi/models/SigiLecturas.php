<?php

namespace frontend\modules\sigi\models;
use  yii\web\ServerErrorHttpException;
use Yii;
use common\behaviors\FileBehavior;
class SigiLecturas extends \common\models\base\modelBase
{
    
    public $dateorTimeFields=['flectura'=>self::_FDATE];
    public $booleanFields=['facturable'];
    public $_codedificio=null;
    /**
     * {@inheritdoc}
     */
    
     public function behaviors()
         {
        return [		
		        'fileBehavior' => [
			     'class' => FileBehavior::className()
		           ],
                    ];
         }
    
    const SCENARIO_IMPORTACION='importacion_simple';
    const SCENARIO_SESION='SESION';
    const SCENARIO_FLAG_FACTURACION='factur';
    public static function tableName()
    {
        return '{{%sigi_lecturas}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['suministro_id','lectura','flectura', 'unidad_id', 'mes','anio'], 'required','on'=>'default'],
              
            [['flectura'], 'valida_depa','on'=>self::SCENARIO_IMPORTACION],
            [['mes','anio','edificio_id','flectura'],'required','on'=>self::SCENARIO_SESION],
            [['lectura', 'mes','anio','edificio_id','unidad_id','flectura','suministro_id','codedificio'],'required','on'=>self::SCENARIO_SESION],
            
            [['suministro_id', 'unidad_id', 'mes'], 'required','on'=>'default'],
            //[['suministro_id','mes', 'anio'], 'unique', 'targetAttribute' => ['mes']],
             [['suministro_id', 'unidad_id'], 'integer'],
            [['lectura', 'lecturaant', 'delta'], 'number'],
            ['lectura', 'valida_lectura'],
            [['codepa'], 'string', 'max' => 12],
             [['mes','codedificio'], 'safe'],
            /*
             * VALIDACIONES GENERALES
             */
             [['flectura'], 'validate_duplicado','except'=>[self::SCENARIO_IMPORTACION,self::SCENARIO_SESION]],
           //  ['lectura','validateActivo'],
            /*******************/
            
             [['codedificio'], 'string', 'max' => 12], 
            [['codepa','codedificio','cuentaspor_id','facturable','codtipo','edificio_id','lecturaant'], 'safe'],
           
            /*Escenario imortacion*/
            // [['codepa'], 'valida_depa','on'=>self::SCENARIO_IMPORTACION],
            [['codepa'], 'validate_general','on'=>self::SCENARIO_IMPORTACION],
             
            // [['codepa'], 'valida_lectura','on'=>self::SCENARIO_IMPORTACION],
            [['flectura'], 'unique', 'targetAttribute' =>['codepa','mes','anio','codedificio', 'codtipo'] ,'on'=>self::SCENARIO_IMPORTACION],
            [['codepa','codedificio','codtipo','mes','anio','lectura','flectura'], 'required','on'=>self::SCENARIO_IMPORTACION],
             //[['codedificio'], 'exist', 'skipOnError' => true, 'targetClass' => Edificios::className(), 'targetAttribute' => ['codedificio' => 'codigo'],'on'=>self::SCENARIO_IMPORTACION],
             //[['codepa'], 'exist', 'skipOnError' => true, 'targetClass' => SigiUnidades::className(), 'targetAttribute' => ['numero' => 'codepa']],
     
            /*Fin de escebnario imortacion*/
            [['mes'], 'integer'],
            [['flectura'], 'string', 'max' => 10],
            [['hlectura'], 'string', 'max' => 5],
            [['suministro_id'], 'exist', 'skipOnError' => true, 'targetClass' => SigiSuministros::className(), 'targetAttribute' => ['suministro_id' => 'id']],
        ];
    }
 public function scenarios()
    {
        $scenarios = parent::scenarios(); 
        $scenarios[self::SCENARIO_IMPORTACION] = ['activo','codepa','flectura','codedificio','codtipo','mes','anio','lectura',/*'lecturaant',*/];
       $scenarios[self::SCENARIO_FLAG_FACTURACION] = ['activo','cuentaspor_id'];
      $scenarios[self::SCENARIO_SESION] = ['activo','lectura', 'lecturaant', 'delta','mes','anio','edificio_id','unidad_id','flectura','suministro_id','codedificio'];
        return $scenarios;
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sigi.labels', 'ID'),
            'suministro_id' => Yii::t('sigi.labels', 'Suministro'),
            'unidad_id' => Yii::t('sigi.labels', 'Unidad'),
            'codepa' => Yii::t('sigi.labels', 'Unidad'),
            'mes' => Yii::t('sigi.labels', 'Mes'),
            'flectura' => Yii::t('sigi.labels', 'F. Lect'),
            'flectura1' => Yii::t('sigi.labels', 'F. Lect'),
            'hlectura' => Yii::t('sigi.labels', 'Hlectura'),
            'lectura' => Yii::t('sigi.labels', 'Lectura'),
            'lecturaant' => Yii::t('sigi.labels', 'Lect Ant'),
            'delta' => Yii::t('sigi.labels', 'Delta'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSuministro()
    {
        return $this->hasOne(SigiSuministros::className(), ['id' => 'suministro_id']);
    }
    
    public function getEdificio()
    {
        return $this->hasOne(Edificios::className(), ['id' => 'edificio_id']);
    }
    
    public function getUnidad()
    {
        return $this->hasOne(SigiUnidades::className(), ['id' => 'unidad_id']);
    }

    /**
     * {@inheritdoc}
     * @return SigiLecturasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SigiLecturasQuery(get_called_class());
    }
    
    public function beforeSave($insert) {
      if($insert){
          $this->resolveIds();
          IF(empty($this->codepa))$this->codepa=$this->unidad->numero;
          
          if($this->isDateForFirstRead(true)){
               $this->lecturaant=$this->lastReadValue(); 
                $this->delta=$this->lectura+$this->deltaPredecesor();  
          }else{
            $this->lecturaant=$this->lastReadValue(); 
                $this->delta=$this->lectura-$this->lecturaant; 
          }
          
      }else{
         if($this->hasChanged('lectura'))
           $this->delta=$this->lectura-$this->lastReadValue();    
      }  
        RETURN parent::beforeSave($insert);
    }
    
   
   
    
    public function lastReadNumeric($fecha=null){
        $ll=$this->medidor()->lastRead($fecha);
       return (is_null($ll))?0:$ll->lectura;
    }
    public function lastDateRead($fecha=null){
        $ll=$this->medidor()->lastRead($fecha);
       return (is_null($ll))?0:$ll->flectura; 
    }
    public function nextReadNumeric($fecha){
        $ll=$this->medidor()->nextRead($fecha);
       return (is_null($ll))?null:$ll->lectura;
    }
    public function nextDateRead($fecha){
        $ll=$this->medidor()->nextRead($fecha);
       return (is_null($ll))?null:$ll->flectura;
    }
    
    
    
    
    
     public function valida_lectura($attribute, $params)
    {
      /*Validando fecha*/
        // yii::error('validando fecha ',__FUNCTION__);
         $depa= $this->depa(); 
   //YII::ERROR($depa);
   if(is_null($depa)){
      // YII::ERROR('DEPA ER ES NULO');
          $this->addError('codepa',yii::t('sigi.labels','El codigo de departamento para este edificio no existe '.$this->getScenario()));
          return;
      }
      
            
      if(!$this->medidor()->activo)
          $this->addError('codepa',yii::t('sigi.labels','Este suministro está desactivado'.$this->getScenario()));
          
         //$this->valida_depa($attribute, $params);
        /* $mes=$this->toCarbon('flectura')->month+0;
        if(!((integer)$this->mes == (integer)$mes)){
            $this->addError('flectura',yii::t('sigi.errors','La fecha no corresponde al mes'));
        }*/
         
          //yii::error('validando SI ESMERNMO QUE LA LECTURA ANTERIOR ',__FUNCTION__);
         //yii::error($this->lectura,__FUNCTION__);
         //yii::error($this->lastReadNumeric($this->flectura),__FUNCTION__);
         if($this->lectura < $this->lastReadNumeric($this->flectura))
              $this->addError('lectura',yii::t('base.labels','Este valor es menor que la última lectura {xx}',['xx'=>$this->lastReadNumeric($this->flectura)]));
        
         $medidor=$this->medidor($type=SigiSuministros::COD_TYPE_SUMINISTRO_DEFAULT);
         
         //yii::error('validando SI ES MAYOR QUE UNA LECTURA POSTERIOR ',__FUNCTION__);
      /*Si la lectura corresponde a una nueva lectura */
         //yii::error(!$medidor->isDateForLastRead($this->flectura),__FUNCTION__);
         
         if(!$medidor->isDateForLastRead($this->flectura)){
             //yii::error($this->nextReadNumeric($this->flectura),__FUNCTION__);
              if($this->lectura > $this->nextReadNumeric($this->flectura))
              $this->addError('lectura','Existe una lectura posterior a '.$this->flectura.', y es menor que la lectura que esta intentando ingresar '.$this->nextReadNumeric($this->flectura)->lectura,['flectura'=>$this->flectura,'ultimalectura'=>$this->nextReadNumeric($this->flectura)->lectura]);
           }
        
     } 
     
    private function resolveIds(){
        if($this->getScenario()==self::SCENARIO_IMPORTACION){
          $this->facturable=true;
          $this->edificio_id= $this->edificioByCode()->id;        
        $this->unidad_id= $this->depa()->id;
        $this->suministro_id=$this->medidor()->id;  
        }
    }
    public function valida_depa($attribute, $params)
    {
        //yii::error('valida_depa '.$this->codepa);
        $edificio=$this->edificioByCode();
      if(is_null($edificio)){
          $this->addError('codedificio',yii::t('sigi.labels','El codigo de edificio no existe'));
          return;
      }       
   $depa= $this->depa(); 
   //YII::ERROR($depa);
   if(is_null($depa)){
       //YII::ERROR('DEPA ES NULO');
          $this->addError('codepa',yii::t('sigi.labels','El codigo de departamento para este edificio no existe '.$this->getScenario()));
          return;
      } 
  //VERIFICANDO QUE EL DEPA TENGA MDEIDOR DE ESTE TIPO
     if(is_null($this->medidor())){
        $this->addError('codepa',yii::t('sigi.labels','Este departamento no tiene ningun medidor del tipo {medidor}',['medidor'=> SigiSuministros::comboValueFieldStatic('tipo',SigiSuministros::COD_TYPE_SUMINISTRO_DEFAULT)]));
          return;  
     }
     
      
        
    }     
    
   /* public function getCodigoEdificio(){
       
        if(is_null($this->codedificio)){
            if(empty($this->edificio_id))
                throw New \yii\web\ServerErrorHttpException(yii::t('base.labels','No existe datos del id edificio y del código tampoco'));   
             return $this->edificio->codigo;
            
        }else{
            return $this->codedificio;
        }
    }*/
    
    
    
    private function edificioByCode(){  
        $edificio=Edificios::find()->where(['codigo'=>$this->codedificio])->one();
        //if(is_null($edificio))
          //throw new ServerErrorHttpException(Yii::t('base.errors','El código del edificio {codigo} no existe ',['codigo'=>$this->codedificio]));
    	return $edificio;
    }
    private function depa(){
       // yii::error('funcion depa',__FUNCTION__);
        /*yii::error(SigiUnidades::find()->where([
            'numero'=>$this->codepa,
            'edificio_id'=>$this->edificioByCode()->id,
            ])->createCommand()->getRawSql());*/
       return  SigiUnidades::find()->where([
            'numero'=>$this->codepa,
            'edificio_id'=>$this->edificioByCode()->id,
            ])->one();
    }
    
    
    
    
    public function medidor($type=SigiSuministros::COD_TYPE_SUMINISTRO_DEFAULT){
       if($this->suministro_id >0)
         return $this->suministro; 
       if(!empty($this->codepa) && !is_null($this->edificioByCode()))
       return  $this->depa()->firstMedidor($type);
        
       
    }
    
    
    
    
    public function hasUsedFactur(){
        if(!$this->facturable){
           return false; 
        }else{
            return ($this->cuentaspor_id >0)?true:false;
        }
    }
    
    public function putFacturado($idcuentaspor){
        $oldscenario=$this->getScenario();
        $this->setScenario(self::SCENARIO_FLAG_FACTURACION);
        $this->cuentaspor_id=$idcuentaspor;
       $grabo=$this->save();
        $this->setScenario($oldscenario);
        return $grabo;
    }
    
    
    /*
     * AllRECORDS:  TRUE Criterio apra facturables y no facturables
     * false:  criterios para solamente facturables por default  false
     */
    public function isDateForFirstRead($allRecords=false){
        return is_null($this->previousRead($allRecords))?true:false;
    }
    public function previousRead($allRecords=false){
        
       $this->hasCompleteCriteriaFields();       
       //yii::error($this->facturable);
         $valorFacturable=($this->resolveFacturable())?'1':'0'; 
          $query=self::find()->where(['suministro_id'=>$this->resolveSuministroId()])->
                 andWhere(['<>','id',!is_null($this->id)?$this->id:0])->
      andWhere(['<=','flectura',static::SwichtFormatDate($this->flectura, 'date',false)])->
      orderBy('flectura DESC')->limit(1);
       if(!$allRecords){///Si se trata de solo facturables 
           $query=$query->andWhere(['facturable'=>$valorFacturable]);
       }/*yii::error($query->createCommand()->getRawSql());*/
      return $query->one();  
    }
    
    public function isDateForLastRead($allRecords=false){
        return is_null($this->nextRead($allRecords))?true:false;
    }
    
    
    public function nextRead($allRecords=false){
       $this->hasCompleteCriteriaFields();        
        $valorFacturable=($this->resolveFacturable())?'1':'0'; 
         $query=self::find()->where(['suministro_id'=>$this->resolveSuministroId()])->
                 andWhere(['<>','id',!is_null($this->id)?$this->id:0])->
      andWhere(['>=','flectura',static::SwichtFormatDate($this->flectura, 'date',false)])->
      orderBy('flectura ASC')->limit(1);
         yii::error($query->createCommand()->rawSql,__FUNCTION__);
        if(!$allRecords){///Si se trata de solo facturables 
           $query=$query->andWhere(['facturable'=>$valorFacturable]);
       }
       // yii::error('Sql nextRead');
        //yii::error($query->createCommand()->getRawSql(),__FUNCTION__);
      return $query->one();  
    }
    public function lastReadValue($allRecords=false){
        //yii::error('** lastReadValue() **');
       
      $registro=$this->previousRead($allRecords);
      // yii::error('Registro '.(IS_NULL($registro)?' ES ':' NO ES ').'  NULO');
      return(is_null($registro))?$this->medidor()->liminf:$registro->lectura;
    } 
    public function nextReadValue($allRecords=false){
      $registro=$this->nextRead($allRecords);
      return(is_null($registro))?$this->medidor()->limsup:$registro->lectura;
  } 
    private function hasCompleteCriteriaFields(){
        if(empty($this->flectura) || !is_bool($this->facturable) )
            throw new ServerErrorHttpException(Yii::t('base.errors', 'Las propiedades {valor} y {campo}  no son las adecuadas ',['valor'=>$this->getAttributeLabel('flectura'),'campo'=>$this->getAttributeLabel('facturable')]));
    		   
    }
    
  
    public function validate_general($attribute, $params){
       // yii::error('**** validategeneral *****'.$this->codepa.'********');
        
        
        if($this->hasErrors())
           return;
        /*yii::error('tene erroes? ');
       yii::error($this->hasErrors());
        yii::error('isDateForFirstRead');  
          yii::error($this->isDateForFirstRead(true));  
          yii::error('isDateForLASTRead');  
          yii::error($this->isDateForLastRead(true)); 
          yii::error('lectura');  
          yii::error($this->lectura); 
           yii::error('ultima lectura');  
          yii::error($this->lastReadValue(true)); */
          
          
          
        if($this->isDateForFirstRead(true) && $this->isNewRecord){
            
            
            
        }elseif($this->isDateForLastRead(true)){
           
             if($this->lectura < $this->lastReadValue(true)){
                 //yii::error('isDateForLastRead');
                 $this->addError('lectura',yii::t('sigi.errors','Hay una lectura {lectura} anterior a esta fecha, y es mayor a la que pretende ingresar',['lectura'=>$this->lastReadValue(true)]));
             }
        }else{
            // yii::error('Esta en el medio');
           if($this->lectura < $this->lastReadValue(true)){
               $this->addError('lectura',yii::t('sigi.errors','Hay una lectura {lectura} anterior a esta fecha, y es mayor a la que pretende ingresar',['lectura'=>$this->lastReadValue(true)]));
           } 
           if($this->lectura > $this->nextReadValue(true)){
               $this->addError('lectura',yii::t('sigi.errors','Hay una lectura {lectura} posterior a esta fecha, y  es menor a la que pretende ingresar',['lectura'=>$this->nextReadValue(true)]));
            
           } 
        }
        //yii::error('*********Fin de validate general*************');
    }
      /*
       * Verifica si ya eiste un registor duplicado*/
      
    public function validate_duplicado(){
      if(!$this->facturable)
      return false;
      if(!$this->isNewRecord)
       return;
        $criteria=[
            'mes'=>$this->mes,
            'anio'=>$this->anio,
            'suministro_id'=>$this->suministro_id,
            'facturable'=>'1',
        ];
       if(self::find()->where($criteria)->exists())
       $this->addError('lectura',yii::t('sigi.errors','Ya hay una lectura facturable en el mismo periodo'));
            
    }
    
    private function resolveFacturable(){
        if($this->getScenario()==self::SCENARIO_IMPORTACION){
            return true;
        }else{
            if($this->facturable=='0')return false;
            if($this->facturable=='1')return true;
        }
    }
    private function resolveSuministroId(){
        if($this->getScenario()==self::SCENARIO_IMPORTACION){
            return $this->medidor()->id;
        }else{
            return $this->suministro_id;
        }
    }
    /*
     * Devuel en porcentaje la desviacion del promedio 
     */
    public function desviacionConsumo(){
        $prom=$this->suministro->averageReads($this->id);
        $consumo=$this->delta;
        if($prom >0){
            $desviacion=round(($consumo-$prom)*100/$prom,3);
        }else{
           $desviacion=0; 
        }
       return $desviacion;
    }
    public function calificacionConsumo(){
        $desviacion=$this->desviacionConsumo();
       if( $desviacion > 10 ){
           return \common\helpers\colorHelper::GREEN;
       } elseif($desviacion < 30){
           return \common\helpers\colorHelper::ORANGE;
           
       }else{
          return \common\helpers\colorHelper::RED; 
       }
           
    }
    
  public static function consumoTotal($edificio_id, $mes,$tipoMedidor=null,$facturable=true){
       if(is_null($tipoMedidor)){
           $tipoMedidor= SigiSuministros::COD_TYPE_SUMINISTRO_DEFAULT;
       }
       $model=Edificios::findOne($edificio_id);
            if(is_null($model))
                 throw new NotFoundHttpException(Yii::t('sigi.labels', 'No se encontró el registro del edificio para este id '.$edificio_id));
      $idsMedidores=$model->idsMedidores($tipoMedidor);
        
      $resultado= SELF::find()->select(['sum(delta)'])->
              andWhere([
               'edificio_id'=>$edificio_id,
               'mes'=>$mes,
               'facturable'=>($facturable)?'1':'0',
                  'suministro_id'=>$idsMedidores
              ]
              )->scalar();
      /* var_dump(SELF::find()->select(['sum(delta)'])->
              andWhere([
               'edificio_id'=>$edificio_id,
               'mes'=>$mes,
               'facturable'=>($facturable)?'1':'0',
                  'suministro_id'=>$idsMedidores
              ]
              )->createCommand()->getRawSql());die();*/
      return ($resultado)?$resultado:0;
             
      }
      
  public function beforeValidate() {
      if(empty($this->codepa) && !empty($this->unidad_id)){
          $this->codepa=$this->unidad->numero;
      }          
      return parent::beforeValidate();
  }    
   
  /*
   * Si esta lectura ha sido usada en un proceso 
   * de facturacion 
   */
 public function isInFacturacion(){
     if($this->facturable)
    return  SigiDetfacturacion::find()->andWhere([
        'unidad_id'=>$this->unidad_id,
        'mes'=>$this->mes,
        'anio'=>$this->anio
    ])->exists();
     return false;
 } 

 public function deltaPredecesor(){
    if(!is_null($reeemplazo=$this->suministro->hasReemplazo())){
        var_dump($reeemplazo->attributes);die();
         return $reemplazo->suministroAnt->lastRead(null,true)->delta;
      }else{
          return 0;
      }
 }
 
}
