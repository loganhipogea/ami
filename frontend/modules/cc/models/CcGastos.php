<?php

namespace frontend\modules\cc\models;
use frontend\modules\cc\models\CcCompras;
use Yii;

/**
 * This is the model class for table "{{%cc_gastos}}".
 *
 * @property int $id
 * @property int $comprobante_id
 * @property int $proc_id
 * @property int $os_id
 * @property int $detos_id
 * @property int $ceco_id
 * @property string $monto
 * @property string $monto_usd
 * @property int $user_id
 */
class CcGastos extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    
   
     
    use \frontend\modules\cc\traits\CcTrait;   
   
    public static function tableName()
    {
        return '{{%cc_gastos}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['comprobante_id',
                'proc_id', 'os_id',
                'detos_id', 'ceco_id', 'user_id'], 'integer'],
            
             [['monto',], 'validate_monto'],
            [['tipo','detalle',], 'safe'],
            [['monto', 'monto_usd'], 'number'],
            
             [['ceco_id','monto'],'required'],
            [['proc_id', 'os_id','detos_id'],'required','on'=>['SCE_D']],
          
              ];
    }
 public function scenarios() {
            $scenarios = parent::scenarios();
            $scenarios['SCE_'.$this->codigo_costo_directo()] = ['comprobante_id',
                'proc_id', 'os_id',
                'detos_id', 'ceco_id', 'user_id','monto', 'monto_usd'];
            $scenarios['SCE_'.$this->codigo_costo_indirecto()] = ['comprobante_id',
                 'ceco_id', 'user_id','monto', 'monto_usd'];
            $scenarios['SCE_'.$this->codigo_costo_orden()] = ['comprobante_id',
                 'ceco_id', 'user_id','monto', 'monto_usd'];
            return $scenarios;
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'comprobante_id' => Yii::t('app', 'Comprobante ID'),
            'proc_id' => Yii::t('app', 'Proc ID'),
            'os_id' => Yii::t('app', 'Os ID'),
            'detos_id' => Yii::t('app', 'Detos ID'),
            'ceco_id' => Yii::t('app', 'Ceco ID'),
            'monto' => Yii::t('app', 'Monto'),
            'monto_usd' => Yii::t('app', 'Monto Usd'),
            'user_id' => Yii::t('app', 'User ID'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return CcGastosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CcGastosQuery(get_called_class());
    }
    
    public function getCeco()
    {
        if($this->is_acumulado())
        return $this->hasOne(CcOrden::className(), ['id' => 'ceco_id']);
        return $this->hasOne(CcCc::className(), ['id' => 'ceco_id']);
    }
    public function getComprobante()
    {
        return $this->hasOne(CcCompras::className(), ['id' => 'comprobante_id']);
    }
    
    
    public function validate_monto($attribute,$params){
        $comprobante=$this->comprobante;
        if($this->isNewRecord){
            if(($comprobante->acumulado()+$this->monto) >$comprobante->monto){
                $diferencia=$comprobante->monto-$comprobante->acumulado();
                 $this->addError($attribute,yii::t('base.errors','El monto registrado en esta calificación no puede ser mayor a {monto}',['monto'=>$diferencia]));
            }
           
        }else{
           if(($comprobante->acumulado($this->id)+$this->monto) >$comprobante->monto){
                $diferencia=$comprobante->monto-$comprobante->acumulado($this->id);
                 $this->addError($attribute,yii::t('base.errors','El monto registrado en esta calificación no puede ser mayor a {monto}',['monto'=>$diferencia]));
            } 
        }
    }
    
   public function color(){
       return self::colores[$this->getScenario()];
   }
    
    public function beforeSave($insert) {
        
        /*if($insert)
        $this->tipo=substr($this->getScenario(),4);*/
        return parent::beforeSave($insert);
    }
    
    public function is_acumulado(){
        return ($this->tipo==$this->codigo_costo_orden());
    }
    
}
