<?php

namespace frontend\modules\mat\models;
use common\models\masters\Maestrocompo;
use frontend\modules\mat\models\MatKardex;
use frontend\modules\mat\models\MatAtenciones;
USE frontend\modules\mat\interfaces\ReqInterface;
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
implements ReqInterface {



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
            [['cant'], 'number'],
            [['um'], 'verify_um'],
            [['codart'], 'validate_stock'],
             [['valor'], 'safe'],
            [['item', 'um'], 'string', 'max' => 4], 
            [['codart'], 'string', 'max' => 14],
            [['codest'], 'string', 'max' => 2],
            [['codart'], 'exist', 'skipOnError' => true, 'targetClass' => Maestrocompo::className(), 'targetAttribute' => ['codart' => 'codart']],
        ];
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
        }        
        return parent::beforeSave($insert);
    }
    
    public function getCantReal(){
        if(is_null($this->_cantreal)){
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
      $kardex=MatKardex::instance();
      $vale=$this->vale;
      $kardex->setAttributes([
          'stock_id'=>$this->stock->id,
          'signo'=>$vale->signo(),
          'cant'=>$this->cant,
          'um'=>$this->material->codum,
          'umreal'=>$this->um,
          'fecha'=>$vale->fecha,
          'detvale_id'=>$this->id,
           'codmov'=>$vale->codmov,
          //'detreq_id'=>$this->id,
      ]);
     return $karde->save();
  }
  
  private function createStock(){
      $stock= MatStock::instance();
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
     return $karde->save();
  }
  
  
  /*Verifica que haya registro de stock
   * si no bora error
   * 
   */
  public function validate_stock(){
     if(is_null($this->stock))
     $this->addError ('codart',yii::t('base.errores','No existe registro de stock para este material'));
  }
  
  private function updateStock(MatStock $stock){
      $stock->cant=$stock->cant+$this->cantreal->cant; 
            $stock->valor=($stock->valor+($this->vale->signo()*$this->cantreal->cant)*($vale->valor))/
               ($stock->cant+$this->cant); 
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
        return $atenciones->save();
     }else{
         return false;
     }
     
  }
  
  
  /*
   * Ejecuta todas las acciones cuando se 
   * aprueba el item
   */
  public function aprobado(){
      $vale=$this->vale;
      $transaccion=$this->getDb()->beginTransaction(\yii\db\Transaction::SERIALIZABLE);
        if(is_null($stock=$this->stock())){
            $this->createStock();
        }else{
            $this->updateStock($stock);
        }
         $this->createKardex();   
         $this->trazabilidad();         
      $transaccion->commit();
   }
     
     
}
