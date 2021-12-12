<?php

namespace frontend\modules\sigi\models;
USE common\models\masters\Clipro;
USE common\models\masters\Ums;
use Yii;

/**
 * This is the model class for table "{{%sigi_suministros}}".
 *
 * @property int $id
 * @property string $tipo
 * @property string $codpro
 * @property string $codsuministro
 * @property string $numerocliente
 * @property string $codum
 * @property int $unidad_id
 * @property string $detalles
 * @property int $frecuencia
 *
 * @property Ums $codum0
 * @property SigiUnidades $unidad
 * @property Clipro $codpro0 
 */
class SigiSuministros extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    CONST COD_TYPE_SUMINISTRO_DEFAULT='101'; //medidor tipo agua 
    const SCENARIO_IMPORTACION='importacion_simple';
    const SCENARIO_REEMPLAZO='reemplazo';
     const SCENARIO_CODSUMINISTRO='cod_suministro';
     public $booleanFields=['activo','plano'];
     
    private $_areasAfiliadas=0; 
     
     
    public static function tableName()
    {
        return '{{%sigi_suministros}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tipo', 'codpro', 'codum', 'unidad_id'], 'required'],
              [['liminf', 'limsup','activo','plano','edificio_id'], 'safe'],
            [['unidad_id', 'frecuencia'], 'integer'],
            [['detalles'], 'string'],
            [['tipo'], 'string', 'max' => 3],
            
             [['id','codsuministro'], 'safe','on'=>self::SCENARIO_CODSUMINISTRO],
            /*Escenario imortacion*/
             [['codepa'], 'valida_depa','on'=>self::SCENARIO_IMPORTACION],
             [['codepa','codedificio','tipo','codum','codpro'], 'required','on'=>self::SCENARIO_IMPORTACION],
              [['codepa','codedificio','tipo','codum','codpro','codsuministro'], 'safe','on'=>self::SCENARIO_IMPORTACION],
            
            [['codedificio'], 'exist', 'skipOnError' => true, 'targetClass' => Edificios::className(), 'targetAttribute' => ['codedificio' => 'codigo'],'on'=>self::SCENARIO_IMPORTACION],
             //[['codepa'], 'exist', 'skipOnError' => true, 'targetClass' => Edificios::className(), 'targetAttribute' => ['codedificio' => 'codigo']],
     
             [['id_anterior','delta_anterior','codsuministro'], 'safe','on'=>self::SCENARIO_REEMPLAZO],
            [['codsuministro','delta_anterior','id_anterior'], 'required','on'=>self::SCENARIO_REEMPLAZO],
            
            [['codpro'], 'string', 'max' => 6],
            [['codsuministro'], 'string', 'max' => 12],
            [['numerocliente'], 'string', 'max' => 25],
            [['codum'], 'string', 'max' => 4],
            [['codum'], 'exist', 'skipOnError' => true, 'targetClass' => Ums::className(), 'targetAttribute' => ['codum' => 'codum']],
            [['unidad_id'], 'exist', 'skipOnError' => true, 'targetClass' => SigiUnidades::className(), 'targetAttribute' => ['unidad_id' => 'id']],
            [['codpro'], 'exist', 'skipOnError' => true, 'targetClass' => Clipro::className(), 'targetAttribute' => ['codpro' => 'codpro']],
        ];
    }
public function scenarios()
    {
        $scenarios = parent::scenarios(); 
       $scenarios[self::SCENARIO_IMPORTACION] = ['codepa','codedificio','tipo','codum','codpro','codsuministro'];
        $scenarios[self::SCENARIO_CODSUMINISTRO] = ['id','codsuministro'];
       $scenarios[self::SCENARIO_REEMPLAZO] = ['unidad_id','edificio_id','tipo',
           'codpro','codum','codsuministro','numerocliente','detalles','frecuencia',
           'limsup','liminf','activo','plano','id_anterior','delta_anterior'];
        return $scenarios;
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sigi.labels', 'ID'),
            'tipo' => Yii::t('sigi.labels', 'Tipo'),
            'codpro' => Yii::t('sigi.labels', 'Proveedor'),
            'codsuministro' => Yii::t('sigi.labels', 'Cod. Suminis'),
            'numerocliente' => Yii::t('sigi.labels', 'Nro Cliente'),
            'codum' => Yii::t('sigi.labels', 'Um'),
            'unidad_id' => Yii::t('sigi.labels', 'Unidad'),
             'edificio_id' => Yii::t('sigi.labels', 'Edificio'),
            'detalles' => Yii::t('sigi.labels', 'Detalles'),
            'frecuencia' => Yii::t('sigi.labels', 'Frec'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUm()
    {
        return $this->hasOne(Ums::className(), ['codum' => 'codum']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnidad()
    {
        return $this->hasOne(SigiUnidades::className(), ['id' => 'unidad_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClipro()
    {
        return $this->hasOne(Clipro::className(), ['codpro' => 'codpro']);
    }
public function getEdificio()
    {
        return $this->hasOne(Edificios::className(), ['id' => 'edificio_id']);
    }
    
    public function getLecturas()
    {
        return $this->hasMany(SigiLecturas::className(), ['suministro_id' =>'id']);
    }
    
    public function lecturasFacturablesQuery()
    {
        return SigiLecturas::find()->where(['suministro_id' =>$this->id,'facturable'=>'1']);
        
          }
    
   private static function resolveFormatDate($fecha){
      if($fecha instanceof \Carbon\Carbon){
            return $fecha->format(\common\helpers\timeHelper::formatMysqlDate());
        }else{ //ES UNA CADENA
            return self::SwichtFormatDate($fecha,'date', false);
        } 
   }
          
    public function lastRead($fecha=null,$facturable=false)
    {
        
        
        
        
        //$query=$this->queryReads(); 
        $valorFacturable=($facturable)?'1':['0','1'];        
             if(is_null($fecha)){
                        $query=$this->queryReads()->andWhere(['facturable'=>$valorFacturable ,'id'=>$this->queryReads()->max('id')]);
                yii::error($this->queryReads()->createCommand()->rawSql);
                        
             }else{
                 $fecha=self::resolveFormatDate($fecha);
                    //yii::error('ya pe');
                    /*yii::error($this->queryReads()->andWhere(['facturable'=>$valorFacturable])->andWhere(['<=','flectura',$fecha])/*->andWhere(['<=','id',$this->queryReads()->max('id')])
                   ->orderBy('id desc')->limit(1)->createCommand()->rawSql);*/
                        $query=$this->queryReads()->andWhere(['facturable'=>$valorFacturable])->andWhere(['<=','flectura',$fecha])/*->andWhere(['<=','id',$this->queryReads()->max('id')])*/
                   ->orderBy('id desc')->limit(1); 
                     //yii::error($query->createCommand()->rawSql);    
                    }        
       return $query->one(); 
    }
   
    
    
  public function lastReadValue($fecha=null,$facturable=false){
     // $fecha=self::resolveFormato($fecha);
      $registro=$this->lastRead($fecha,$facturable);
      return(is_null($registro))?$this->liminf:$registro->lectura;
  } 
    
    
      
    public function nextRead($fecha,$facturable=false){
        $fecha=self::resolveFormatDate($fecha);
         $valorFacturable=($facturable)?'1':['0','1'];   
        $query=$this->queryReads()->
      andWhere(['facturable'=>$valorFacturable])->andWhere(['>=','flectura',$fecha])->
      orderBy('id ASC')->limit(1);
        //yii::error($query->createCommand()->getRawSql());
      return $query->one();  
    }
    
    public function previousRead($fecha,$facturable=false){
        $fecha=self::resolveFormatDate($fecha);
         $valorFacturable=($facturable)?'1':['0','1'];   
        $query=$this->queryReads()->
      andWhere(['facturable'=>$valorFacturable ,'<=','flectura',$fecha])->
      orderBy('id ASC')->limit(1);
       // yii::error($query->createCommand()->getRawSql());
      return $query->one();  
    }
    
     public function nextReadValue($fecha=null,$facturable=false){
        
      $registro=$this->nextRead($fecha,$facturable);
      return(is_null($registro))?$this->limsup:$registro->lectura;
  } 
    
    
    /*Verifica con una fecha si esta fecha es mayor a cualquier lectura.
     * 
     * Corresponderia a una nueva lectura
     * En otro caso , habria ya una lectura con esta fecha o una fecha anterior
     * fecha   en formato dd/mm/yyyy (Formato usuario)
     */
    public function isDateForLastRead($fecha,$facturable=false){
        return is_null($this->nextRead($fecha,$facturable))?true:false;
    }
    
    
    public function isDateForFirstRead($fecha,$facturable=false){
        return is_null($this->previousRead($fecha,$facturable))?true:false;
    }
    
    private function queryReads(){
        return SigiLecturas::find()->where(['suministro_id' => $this->id]);
    }
    
    private function queryReadsForThisMonth($mes,$anio,$facturable=false){
        $valor=($facturable)?'1':['0','1'];
        //yii::error('----queryreas for this mont--');
        /*yii::error(SigiLecturas::find()->where(['edificio_id' => $this->edificio_id])->
                andwhere(['facturable'=>$valor,'mes' => $mes,'anio'=>$anio,'suministro_id'=>$this->id])->
                createCommand()->getRawSql());*/
        return SigiLecturas::find()->where(['edificio_id' => $this->edificio_id])->
                andwhere(['facturable'=>$valor,'mes' => $mes,'anio'=>$anio]);
        
    }
    
     Public function LastReadFacturable($mes,$anio){
     $reg= $this->queryReads()->
                andWhere(['facturable'=>'1','mes' => $mes,'anio'=>$anio])->one();
     return $reg;
    }
    
     Public function LastReadFacturableValue($mes,$anio){
     $reg= $this->LastReadFacturable($mes, $anio);
     return (is_null($reg))?0:$reg->lectura;
    }
    
    public function consumoTotal($mes,$anio,$facturable=true){
        //$valor=($facturable)?'1':'0';
         
        $query=$this->queryReadsForThisMonth($mes,$anio,$facturable);
       
       
        if($query->count()>0)
            //yii::error($query->select('sum(delta)')->createCommand ()->rawSql);
         return  $query->select('sum(delta)')->scalar();
        return 0;
    }
    
    
    
    /**
     * {@inheritdoc}
     * @return SigiSuministrosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SigiSuministrosQuery(get_called_class());
    }
    
    public function ultimaLectura(){
      return 1;  
    }
    
    private function edificio(){
        return Edificios::find()->where(['codigo'=>$this->codedificio])->one();
    }
    private function depa(){
       return  SigiUnidades::find()->where([
            'numero'=>$this->codepa,
        'edificio_id'=>$this->edificio()->id,
            ])->one();
    }
    /*private function medidor(){
       return  $this->depa()->firstMedidor(SigiSuministros::COD_TYPE_SUMINISTRO_DEFAULT);
    }*/
    public function valida_depa($attribute, $params)
    {
        $edificio=$this->edificio();
      if(is_null($edificio)){
          $this->addError('codedificio',yii::t('sigi.labels','El codigo de edificio no existe'));
          return;
      }       
   $depa= $this->depa(); 
   if(is_null($depa)){
          $this->addError('codepa',yii::t('sigi.labels','El codigo de departamento para este edificio no existe'));
          return;
      } 
    }
    
  private function resolveIds(){ 
      if($this->getScenario()==self::SCENARIO_IMPORTACION){
         $this->edificio_id= $this->edificio()->id;        
        $this->unidad_id= $this->depa()->id;
        $this->numerocliente=substr($this->depa()->numero.'_'.$this->comboValueField('tipo'),0,25);
      }
        
       // $this->suministro_id=$this->medidor()->id;        
    }
    
 public function beforeSave($insert) {
      if($insert){
          $this->activo=true;
          $this->resolveIds();
          if(empty($this->liminf))
              $this->liminf=0;
          if(empty($this->limsup))
              $this->limsup=999999999;
        //$this->lecturaant=$this->lastReadNumeric();   
      }else{
          
      }  
        RETURN parent::beforeSave($insert);
    }
   
/*
 * Devuelve un array de lecturas 
 * 
 */
public function matrixReads(){
    
}

public function hasUsedFactur(SigiLecturas $lectura){
    return $lectura->hasUsedFactur();
}

/*
 * Coloca el flag de facturado a la
 * lectura del mes 
 */
public function updateReadFacturable($mes,$anio,$idcuentaspor){
   $registro=$this->readFacturableByMonth($mes, $anio);
   if(is_null($registro)){
       return false;
   }else{
       return $registro->putFacturado($idcuentaspor);
   }
}

public function readFacturableByMonth($mes,$anio){
   return $this->queryReadsForThisMonth($mes, $anio, true)->one();
}

/*Agrega una lectura 
 * solo conl afecha y el valor del 
 * se nrtga de validar 
 */
public function addRead(SigiLecturas $lectura){
    if($this->isDateForFirstRead($fecha, $facturable)){
        $lectura->save();
    }elseif($this->isDateForLastRead($fecha,$facturable)){
        
    }else{
        
    }
}

public function lastReads($forGraphical=false){
   $nlecturas=min(\common\helpers\h::gsetting('sigi','numeroMaxLecturas'),
                $this->lecturasFacturablesQuery()->count()
               );
  /* $registrosLecturas=$this->
           lecturasFacturablesQuery()->
           orderBy('flectura ASC')->limit($nlecturas)->all();
   $lecturas=[];
    foreach($registrosLecturas as $lectura){
        $lecturas[$lectura->mes]=$lectura->delta;
    }
    */
    $lecturas= SigiLecturas::find()->select(['mes','sum(delta) as consumo'])
     ->andWhere(['suministro_id'=>$this->id])->groupBy(['mes','anio'])->limit($nlecturas)->
     asArray()->all();
    $lecturas=array_combine(array_column($lecturas,'mes'),array_column($lecturas,'consumo'));
    
    
    if($forGraphical){
        $meses= array_values(\common\helpers\timeHelper::mapMonths(array_keys($lecturas)));
        $lecturas=array_combine($meses,array_values($lecturas));
        array_shift($lecturas);
        return $lecturas;
    }else{
         array_shift($lecturas);
          return $lecturas;
    }
    
}
  
public function participacionRead($mes,$anio){
    if($this->isAACC()){
       $consumoT=$this->consumoAreasComunes($mes, $anio);  
    
    }else{
      $consumoT=$this->consumoTotal($mes, $anio)-$this->consumoAreasComunes($mes, $anio);  
    }
    
    $consumo=$this->LastReadFacturable($mes,$anio)->delta;
    if($consumoT > 0){
        return round($consumo/$consumoT,10);
    }else{
        return 0;
    }
}
public function sigiSumiDepaQuery(){
     return SigiSumiDepa::find()->where(['suministro_id' =>$this->id /*,'afiliado'=>'1'*/]);
}
public function depasReparto(){
   return  $this->sigiSumiDepaQuery()->all();
}
public function ndepasReparto($total=false){
    if($total){
       return  $this->sigiSumiDepaQuery()->count();  
     
    }else{/*Solo las afiliadas*/
      return  $this->sigiSumiDepaQuery()->andWhere(['afiliado'=>'1'])->count();  
    }
}

/*
 * Numero de unidades afiliadas que son 
 * imputables y no son hijas 
 * Esto es, unidades que se han afiliado 
 * y no estan dentro de otra unidad 
 */
public function ndepasRepartoPadres(){
    
  return $this->sigiSumiDepaQuery()
            ->andWhere(['afiliado'=>'1'])->count();
           // ->andWhere(['unidad_id'=>$this->edificio->idsUnidadesPadresImputables()])->count();  
    
}
   


public function isAACC(){
    return !$this->unidad->imputable;
}

public function afterSave($insert, $changedAttributes) {
    if(!$this->unidad->imputable && $this->unidad->area >0){
        $this->fillDepas();
    }
    
    return parent::afterSave($insert, $changedAttributes);
}
/*
 * Llena los departamenteos afiliados a este mdidor, 
 * en caso de que la unidad padre no sea imputable
 */
public function fillDepas(){
    foreach($this->edificio->unidadesImputablesPadres() as $unidad){
        yii::error('recorriendo '.$unidad->numero);
        $attributes=[
            'edificio_id'=>$this->edificio_id,
             'unidad_id'=>$unidad->id,
            'suministro_id'=>$this->id, 
            //'afiliado'=>'1'
        ];
        $attributesFill=[
            'edificio_id'=>$this->edificio_id,
             'unidad_id'=>$unidad->id,
            'suministro_id'=>$this->id, 
            'afiliado'=>'1'
        ];
        SigiSumiDepa::firstOrCreateStatic($attributesFill,null,$attributes);
            
            
    }
}
/*
 * Registro de unidad es que comparten el consumo de este medidor
 * Siemre que la unidad en la queeste montao el medidor sea no imputable 
 */
public function providerAfiliados(){
    $provider = new \yii\data\ActiveDataProvider([
    'query' => $this->sigiSumiDepaQuery(),
    'pagination' => [
        'pageSize' => 100,
    ],
]);
    return $provider;
}

public function hasAfiliados(){
    return($this->sigiSumiDepaQuery()->count()>0)?true:false;
}

public function averageReads($idLectura=null){
   $nlecturas=min(\common\helpers\h::gsetting('sigi','numeroParaPromedioLecturas'),
                $this->queryReads()->count()
               );
   if($idLectura >0){
      return $this->queryReads()->sum('avg(delta)')->where(['id'<$idLectura])->orderBy('id DESC')->limit($nlecturas)->scalar();
     
   }else{
       return $this->queryReads()->sum('avg(delta)')->orderBy('id DESC')->limit($nlecturas)->scalar();
      
   }
  
}

public function consumoAreasComunes($mes,$anio,$facturable=true){
   $valor=($facturable)?'1':'0';
        
  return SigiLecturas::find()->select(['sum(delta)'])->andWhere([
       'edificio_id' => $this->edificio_id,
       'facturable'=>$valor,
       'mes' => $mes,
       'anio'=>$anio,
       'unidad_id'=>$this->edificio->idsUnidadesNoImputables()
           ])->scalar();
    
}

public function porcConsumoAaCc($mes,$anio,$porcentaje=false){
    $consumototal=$this->consumoTotal($mes, $anio);
    yii::error('consumo de areas comunes '.$this->consumoAreasComunes($mes, $anio),__FUNCTION__);
    yii::error('consumo total '.$consumototal,__FUNCTION__);
    
    if($consumototal>0)
         return  $this->consumoAreasComunes($mes, $anio)/$consumototal;
    return 0;
}


public function hasUnitAfiliado($unidad_id){
    if($this->isAACC()){
       return  $this->sigiSumiDepaQuery()->select(['id'])->andWhere(['unidad_id'=>$unidad_id,'afiliado'=>'1'])->exists();
       // return (in_array($unidad_id,$this->sigiSumiDepaQuery()->select(['unidad_id'])->column()));
    }else{
        return false;
    }
}

public function getAreasAfiliadas(){
    if($this->_areasAfiliadas==0){
       $idsAfiliadas= $this->sigiSumiDepaQuery()->select(['unidad_id'])->andWhere(['afiliado'=>'1'])->column();
       $idHijas= SigiUnidades::find()->select(['id'])->andWhere(['parent_id'=>$idsAfiliadas])->column();
       $this->_areasAfiliadas=SigiUnidades::find()->select('sum(area)')->andWhere(['id'=>array_merge($idsAfiliadas,$idHijas)])->scalar();
    }
    return $this->_areasAfiliadas;
    
    }


public function porcPartUnidadAfiliada($unidad){
    if($this->areasAfiliadas >0)
   return round($unidad->areaTotal()/$this->areasAfiliadas,4); 
    return 0;
}

public function resolveReemplazo(){
    $medAnt=self::findOne($this->id_anterior);
    $medAnt->activo=false; $medAnt->save();
}

public function hasReemplazo(){
    if($this->hasLecturas(true)) return false;
    $model=SigiReempmedidor::find()->andWhere(['suministro_id_ant'=>$this->id])->orderBy(['id'=>SORT_DESC])->one();
    return !is_null($model)?$model:false;
}

public function hasLecturas($facturable=false){
    $flag=($facturable)?'0':'1';
    return $this->getLecturas()->andWhere(['suministro_id'=>$this->id,'facturable'=>$flag])->exists();
}


        


}
