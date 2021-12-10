<?php

namespace frontend\modules\sigi\models;

use Yii;


/**
 * This is the model class for table "{{%sigi_cargosedificio}}".
 *
 * @property int $id
 * @property int $edificio_id
 * @property int $cargo_id
 * @property string $tasamora
 * @property string $codgrupo
 * @property int $plazovencimiento
 * @property string $regular
 * @property string $montofijo
 * @property int $frecuencia
 * @property string $tipomedidor
 *
 * @property SigiEdificios $edificio
 * @property SigiCargosgrupoedificio $codgrupo0
 * @property SigiCargos $cargo
 */
class SigiCargosedificio extends \common\models\base\modelBase implements
\frontend\modules\sigi\interfaces\colectoresInterface
{
   private $_monto;
    public $booleanFields= [
        'regular',
        'individual',
        'montofijo',
        'emisorexterno'
        ];
    /**
     * {@inheritdoc}
     */
     const SCENARIO_IMPORTACION='importacion_cargos';
    
    public static function tableName()
    {
        return '{{%sigi_cargosedificio}}';
    }
   
    
    public function scenarios()
    {
        $scenarios = parent::scenarios(); 
       $scenarios[self::SCENARIO_IMPORTACION] = [
           'edificio_id', 'cargo_id', 'grupo_id','regular',
        'individual',
        'montofijo',
        'emisorexterno','tipomedidor','monto'];
        return $scenarios;
    }
    
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['edificio_id', 'cargo_id', 'tasamora', 'grupo_id'], 'required'],
            [['edificio_id', 'cargo_id', 'plazovencimiento', 'frecuencia'], 'integer'],
            [['tasamora'], 'number'],
            [[ 'regular',
        'individual',
        'montofijo',
        'emisorexterno','tipomedidor','monto','detalle'],'safe'],
            //[['regular', 'montofijo'], 'string', 'max' => 1],
            [['edificio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Edificios::className(), 'targetAttribute' => ['edificio_id' => 'id']],
            //[['codgrupo'], 'exist', 'skipOnError' => true, 'targetClass' => SigiCargosgrupoedificio::className(), 'targetAttribute' => ['grupo_id' => 'id']],
            //[['cargo_id'], 'exist', 'skipOnError' => true, 'targetClass' => SigiCargos::className(), 'targetAttribute' => ['cargo_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'edificio_id' => Yii::t('app', 'Edificio ID'),
            'cargo_id' => Yii::t('app', 'Cargo ID'),
            'tasamora' => Yii::t('app', 'Tasamora'),
            //'codgrupo' => Yii::t('app', 'Codgrupo'),
            'plazovencimiento' => Yii::t('app', 'Plazovencimiento'),
            'regular' => Yii::t('app', 'Regular'),
            'montofijo' => Yii::t('app', 'Montofijo'),
            'frecuencia' => Yii::t('app', 'Frecuencia'),
            'tipomedidor' => Yii::t('app', 'Tipomedidor'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdificio()
    {
        return $this->hasOne(Edificios::className(), ['id' => 'edificio_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrupo()
    {
        return $this->hasOne(SigiCargosgrupoedificio::className(), ['id' => 'grupo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCargo()
    {
        return $this->hasOne(SigiCargos::className(), ['id' => 'cargo_id']);
    }
    public function getBeneficio()
    {
        return $this->hasOne(SigiBeneficios::className(), ['id' => 'cargo_id']);
    }
 public function getCuentaspor()
    {
        return $this->hasMany(SigiCuentaspor::className(), ['colector_id'=>'id']);
    }
    
  public function getBasePresupuesto()
    {
        return $this->hasMany(SigiBasePresupuesto::className(), ['cargosedificio_id'=>'id']);
    }  
    
    /**
     * {@inheritdoc}
     * @return SigiCargosedificioQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SigiCargosedificioQuery(get_called_class());
    }
    
    public static function frecuencias(){
        return [
            '0.5'=>yii::t('base.names','QUINCENAL'),
            '1'=>yii::t('base.names','MENSUAL'),
            '2'=>yii::t('base.names','BIMESTRAL'),
            '3'=>yii::t('base.names','TRIMESTRAL'),
            '6'=>yii::t('base.names','SEMETRAL'),
            '12'=>yii::t('base.names','ANUAL'),
        ];
    }
    
    public function beforeSave($insert) {
        IF($insert){
           $this->resolveDefaults();
            $this->codigo=$this->correlativo('codigo',null,'edificio_id');
        }
        RETURN parent::beforeSave($insert);
    }
    
  public function isMedidor(){
      return !empty($this->tipomedidor);
  }
   
  public function isFijoRegular(){
      return ($this->regular && $this->montofijo);
  }
  
  public function isBudget(){
      return ($this->isFijoRegular() && !$this->emisorexterno);
  }
  
  public function isMassive(){
      return (!$this->individual);
  }
    
   
    
    public function montoTotal($mes,$anio){
     if($this->isBudget()){
          /* yii::error(SigiBasePresupuesto::find()->
                 select('sum(mensual) as monto')->where(
                    ['cargosedificio_id'=>$this->id,'ejercicio'=>$anio]
            )->createCommand()->getRawSql());*/
       if($this->monto >0 ){
           return $this->monto;
       }else{
         $valor=SigiBasePresupuesto::find()->
                 select('sum(mensual) as monto')->where(
                    ['cargosedificio_id'=>$this->id,'ejercicio'=>$anio]
            )->scalar();
         return is_null($valor)?0:$valor;  
       }
         
     }else{
        /* yii::error(SigiCuentaspor::find()->
                 select('sum(monto)as monto')->where(
                    ['colector_id'=>$this->id,'mes'=>$mes,'anio'=>$anio]
            )->createCommand()->getRawSql());*/
         $valor=SigiCuentaspor::find()->
                 select('sum(monto)as monto')->where(
                    ['colector_id'=>$this->id,'mes'=>$mes,'anio'=>$anio]
            )->scalar();
         return is_null($valor)?0:$valor;
     }
    }
    
    
     
     public function dataProvider($mes){
     if($this->isBudget()){
         return SigiBasePresupuesto::find()->
                 select('sum(mensual)as monto')->where(
                    ['cargosedificio_id'=>$this->id,'mes'=>$mes]
            )->scalar();
     }else{
         return SigiCuentaspor::find()->
                 select('sum(monto)as monto')->where(
                    ['colector_id'=>$this->id,'mes'=>$mes]
            )->scalar();
     }
     
     
    }
    /*
     * Ubica las fuentes de cobranza
     */
    public function sourceProvider($mes){
       
    }
    
    public function resolveDefaults(){
        foreach($this->booleanFields as $campo){
            if(is_null($this->{$campo})){
                $this->{$campo}='0';
            }
        }
        return true;
    }
  
    /*
     * Crea un registro de presupuesto
     */
    
    public function createPartidaPresupuesto(){
        $ejercicio= SigiFacturacion::find()->select(['max(ejercicio)'])->scalar();
        if($ejercicio){
            
        }else{
            $ejercicio=date('Y');
        }
        $atributes=[
            'edificio_id'=>$this->edificio_id,
            'cargosedificio_id'=>$this->id,
            'codigo'=>'',            
            'descripcion'=>$this->cargo->descargo,
            'activo'=>'1',
            'ejercicio'=>$ejercicio,          
            'mensual'=>$this->monto
                ];
        
                $d=SigiBasePresupuesto::firstOrCreateStatic($atributes,
                        SigiBasePresupuesto::SCENARIO_REGULAR,
                        ['edificio_id'=>$this->edificio_id, 'ejercicio'=>$ejercicio,  
            'cargosedificio_id'=>$this->id,]);
                yii::error($d);
    }
}  

