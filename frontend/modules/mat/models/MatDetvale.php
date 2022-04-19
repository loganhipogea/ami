<?php

namespace frontend\modules\mat\models;
use common\models\masters\Maestrocompo;
use frontend\modules\mat\models\MatKardex;
use frontend\modules\mat\models\MatAtenciones;
USE frontend\modules\mat\interfaces\ReqInterface;
use frontend\modules\mat\interfaces\EstadoInterface;
use Yii;

/**
 * This is the model class for table "{{%mat_detvale}}".
 *
 * @property int $id
 * @property int $vale_id
 * @property string $item
 * @property string $cant
 * @property string $um
 * @property string $codart
 * @property string $codest
 *
 * @property Maestrocompo $codart0
 */
class MatDetvale extends \common\models\base\modelBase 
implements ReqInterface,EstadoInterface {

        const ESTADO_CREADO='10';
        const ESTADO_APROBADO='20';
        const ESTADO_ANULADO='99';
        CONST MOV_SALIDA='scenario_i';
        CONSt MOV_INGRESO='scenario_i';

   private $_cantreal=null;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mat_detvale}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vale_id', 'codart'], 'required'],
            [['vale_id'], 'integer'],
            [['detreq_id'], 'required','on'=>self::MOV_SALIDA],
            [['cant'], 'number'],
            [['cant'], 'validate_cant_stock','on'=>self::MOV_SALIDA],
            //[['um'], 'verify_um'],
           // [['codart'], 'validate_stock'],
             [['valor'], 'safe'],
            [['item', 'um'], 'string', 'max' => 4], 
            [['codart'], 'string', 'max' => 14],
            [['codest'], 'string', 'max' => 2],
            [['codart'], 'exist', 'skipOnError' => true, 'targetClass' => Maestrocompo::className(), 'targetAttribute' => ['codart' => 'codart']],
        ];
    }

    
    public function scenarios() {
            $scenarios = parent::scenarios();
            $scenarios[self::MOV_SALIDA] = [ 'vale_id', 'codart', 'cant', 'valor', 'item', 'um','descripcion'];
            $scenarios[self::MOV_INGRESO] = [ 'vale_id', 'codart', 'cant', 'valor', 'item', 'um','descripcion','detreq_id'];
        
            return $scenarios;
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'vale_id' => Yii::t('app', 'Vale ID'),
            'item' => Yii::t('app', 'Item'),
            'cant' => Yii::t('app', 'Cant'),
            'um' => Yii::t('app', 'Um'),
            'codart' => Yii::t('app', 'Codart'),
            'codest' => Yii::t('app', 'Codest'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterial()
    {
        return $this->hasOne(Maestrocompo::className(), ['codart' => 'codart']);
    }
    
     public function getKardex()
    {
        return $this->hasOne(MatKardex::className(), ['vale_id' => 'id']);
    }
    
     public function getVale()
    {
        return $this->hasOne(MatVale::className(), ['id' => 'vale_id']);
    }

     public function stock()
    {
        return MatStock::findOne(['codart'=>$this->codart]);
    }
        public function getAtenciones()
    {
        return $this->hasMany(MatAtenciones::className(), ['detvale_id' => 'id']);
    }
    
    
    
    public function cant_atendida(){
       return $this->atenciones()->sum('cantidad');
    }
    /**
     * {@inheritdoc}
     * @return MatDetvaleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MatDetvaleQuery(get_called_class());
    }
    
     public function beforeSave($insert) {
        if($insert){
           // $this->activo=true;            
            $this->item='1'.str_pad($this->vale->getDetalles()->count()+1,3,'0',STR_PAD_LEFT);
            $this->codest=self::ESTADO_CREADO;
        }        
        return parent::beforeSave($insert);
    }
    
    public function getCantReal(){
        if(is_null($this->_cantreal) && !$this->isNewRecord){
          $this->cant=$this->cant*$this->material->factorConversion($this->um);
        }
        return $this;       
    }
    
    
    
   
  public function verify_um() {
     if(!$this->material->existsUm($this->um,false)){
          $this->addError('um',yii::t('base.errors','La unidad de medida no está registrada'));
       }
  }
  
  
  private function createKardex(){
      $kardex=new MatKardex();
      $vale=$this->vale;
      $kardex->setAttributes([
          'stock_id'=>$this->stock()->id,
          'signo'=>$vale->signo(),
          'cant'=>$this->cant,
          'um'=>$this->material->codum,
          'umreal'=>$this->um,
          'fecha'=>$vale->fecha,
          'detvale_id'=>$this->id,
           'codmov'=>$vale->codmov,
          'detvale_id'=>$this->id,
          //'detreq_id'=>$this->id,
      ]);
     // print_r($kardex->attributes);die();
       $salio=$kardex->save();
      //print_r($kardex->getErrors());
     return $salio;
     //return $kardex->save();
  }
  
  private function createStock(){
      $stock= New MatStock();
     // $vale=$this->vale;
      $stock->setAttributes([
          'codart'=>$this->codart,
          'cant'=>$this->cant,
          'cantres'=>0,
          //'signo'=>$vale->signo(),
          //'cant'=>$this->cant,
          'um'=>$this->material->codum,
          'valor'=>$this->valor,
          
      ]);
      $salio=$stock->save();
      //print_r($stock->getErrors());
     return $salio;
  }
  
  
  /*Verifica que haya registro de stock
   * si no bora error
   * 
   */
  /*public function validate_stock(){
     if(is_null($this->stock))
     $this->addError ('codart',yii::t('base.errores','No existe registro de stock para este material'));
  }*/
  
  private function updateStock(MatStock $stock){
     // $vale=$this->vale;
     // yii::error('cant stock  antes dwl cambio');
       //yii::error($stock->cant);
      $stock->cant=$stock->cant+$this->cantreal->cant; 
      /* yii::error('signo');
       yii::error($this->vale->signo());
        yii::error('valor del detalle ');
       yii::error($this->valor);
          yii::error('cant stock  cambiado');
       yii::error($stock->cant);
          yii::error('valor stock ');
       yii::error($stock->valor);*/
            /*$stock->valor=($stock->valor+$this->vale->signo()*$this->valor)/
               ($stock->cant+$this->cant); */
      $stock->valor+=$this->vale->signo()*$this->valor;
       $stock->valor_unit=$stock->valor/($stock->cant);
             return $stock->save();
  }
 
/*Establece la trazabilidad de 
 * de la compra
 */
  private function trazabilidad(){
     if($this->detreq_id>0){
          $atenciones= (MatAtenciones::instance());
        $atenciones->setAttributes([
          'detreq_id'=>$this->detreq_id,
          'detvale_id'=>$this->id,
            'cant'=>$this->cant,
      ]);
         $salio=$atenciones->save();
      //print_r($atenciones->getErrors());
     return $salio;
        //return $atenciones->save();
     }else{
         return false;
     }
     
  }
  
  
  /*
   * Ejecuta todas las acciones cuando se 
   * aprueba el item
   */
  public function aprobado(){
     if($this->isCreado()){
      $vale=$this->vale;
      $transaccion=$this->getDb()->beginTransaction(\yii\db\Transaction::SERIALIZABLE);
        if(is_null($stock=$this->stock())){
            $this->createStock();
        }else{
            $this->updateStock($stock);
        }
         $this->createKardex();   
         $this->trazabilidad();
         $this->codest=self::ESTADO_APROBADO;
         $this->save();
      $transaccion->commit();
     }
   }
   
   public function validate_cant_stock(){
       if($this->getScenario()==self::MOV_SALIDA){
          if(is_null($stock=$this->stock())){
              $this->addError('cant',yii::t('base.labels','El material no tiene registro de stock'));
          }else{
              if($this->getCantReal()->cant > $stock->cant){
                $this->addError('cant',yii::t('base.labels','No hay cantidad suficiente de material en stock'));  
              }
          }
           
           
       }
   }
     
     public function isCreado(){
        return ($this->codest==self::ESTADO_CREADO)?true:false;
    }
     public function isAprobado(){
       return ($this->codest==self::ESTADO_APROBADO)?true:false; 
    }
     public function isAnulado(){
       return ($this->codest==self::ESTADO_ANULADO)?true:false; 
    }
    public function isBloqueado(){
       return $this->isAnulado()|| $this->isAprobado();
    }
    
    
    
}
