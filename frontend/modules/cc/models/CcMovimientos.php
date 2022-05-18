<?php

namespace frontend\modules\cc\models;
use frontend\modules\cc\interfaces\MovimientosInterface;
use Yii;

class CcMovimientos extends \common\models\base\modelBase implements MovimientosInterface
{
     public $dateorTimeFields = [
        'fechaop' => self::_FDATE,
        'fechacre' => self::_FDATE,
         /* 'fval' => self::_FDATE,
           'fval1' => self::_FDATE,*/
       // 'ftermino' => self::_FDATETIME
    ];
     
    public $booleanFields=['activo'];
    CONST SCE_PAGO_CREDITO='pago_credito';
    CONST SCE_PAGO_CONTADO='pago_contado';
    CONST SCE_PAGO_RENDIR_PERSONA='pago_rendir_persona';
    CONST SCE_PAGO_CAJA_CHICA='pago_caja chica';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%cc_movimientos}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            
            [['cuenta_id', 'fechaop', 'glosa'], 'required'],            
            [['cuenta_id', 'user_id', 'caja_id'], 'integer'],
            [['monto', 'igv', 'monto_eq'], 'number'],
            [['detalle'], 'string'],
            //[['fechaop'], 'string', 'max' => 10],
           // [['fechacre'], 'string', 'max' => 19],
            [['glosa'], 'string', 'max' => 40],
           // [['activo', 'ingreso', 'tipo'], 'string', 'max' => 1],
            [['codtra'], 'string', 'max' => 6],
            [['cuenta_id'], 'exist', 'skipOnError' => true, 'targetClass' => CcCuentas::className(), 'targetAttribute' => ['cuenta_id' => 'id']],
        
            /*ESCENARIO DEPOSITO A CUENTA DE UNA PERSONA A RENDIR*/
            [['codtra'], 'required','on'=>self::SCE_PAGO_RENDIR_PERSONA], 
            
            /*ESCENARIO DEPOSITO A CUENTA DE CAJA CHICA*/
            [['caja_id'], 'required','on'=>self::SCE_PAGO_RENDIR_PERSONA], 
            
            
            
            ];
    }

    
    
    public function scenarios() {
            $scenarios = parent::scenarios();
            $scenarios[self::SCE_PAGO_CAJA_CHICA] = [ 'caja_id',
                'fechaop', 'glosa', 'user_id', 'cuenta_id', 
               'monto', 'igv', 'monto_eq', 'descripcion',
                'detalle'
                ];
             $scenarios[self::SCE_PAGO_CONTADO] = [ 
                'fechaop', 'glosa', 'user_id', 'cuenta_id', 
               'monto', 'igv', 'monto_eq', 'descripcion',
                'detalle'
                ];
             $scenarios[self::SCE_PAGO_CREDITO] = [ 
                'fechaop', 'glosa', 'user_id', 'cuenta_id', 
               'monto', 'igv', 'monto_eq', 'descripcion',
                'detalle'
                ];
             $scenarios[self::SCE_PAGO_RENDIR_PERSONA] = [ 'codtra',
                'fechaop', 'glosa', 'user_id', 'cuenta_id', 
               'monto', 'igv', 'monto_eq', 'descripcion',
                'detalle'
                ];
           
            return $scenarios;
    }
    
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'cuenta_id' => Yii::t('app', 'Cuenta ID'),
            'fechaop' => Yii::t('app', 'Fechaop'),
            'fechacre' => Yii::t('app', 'Fechacre'),
            'glosa' => Yii::t('app', 'Glosa'),
            'monto' => Yii::t('app', 'Monto'),
            'igv' => Yii::t('app', 'Igv'),
            'monto_eq' => Yii::t('app', 'Monto Eq'),
            'user_id' => Yii::t('app', 'User ID'),
            'activo' => Yii::t('app', 'Activo'),
            'ingreso' => Yii::t('app', 'Ingreso'),
            'detalle' => Yii::t('app', 'Detalle'),
            'tipo' => Yii::t('app', 'Tipo'),
            'caja_id' => Yii::t('app', 'Caja ID'),
            'codtra' => Yii::t('app', 'Codtra'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCuenta()
    {
        return $this->hasOne(CcCuentas::className(), ['id' => 'cuenta_id']);
    }
    
    public function getTrabajador()
    {
        return $this->hasOne(\common\models\masters\Trabajadores::className(), ['codigotra' => 'codtra']);
    }

    /**
     * {@inheritdoc}
     * @return CcMovimientosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CcMovimientosQuery(get_called_class());
    }
    
    public function beforeSave($insert) {
        if($insert){
            $this->activo=false;
        }
        return parent::beforeSave($insert);
    }
    /*
     * Esta funcion activa el movimiento 
     * y actualiza el saldo de la cuenta 
     */
    public function activate(){
      if(!$this->activo){
                $transa= $this->getdb()->beginTransaction();     
                $this->activo=true;
                $valido=$this->cuenta->actualizaSaldo($this) &&
                $this->save();
            if($valido ){
                    $transa->commit();
          
                    }else{
                        $transa->rollBack();
                    if(!$this->hasErrors()){
                        $this->addError('activo',$this->cuenta->getFirstError());
                        }
                    }
        return $valido;       
      }else{
         $this->addError('activo',yii::t('base.errors','Este movimiento ya está activo'));
           return false;             
      }
    
    }
    
    public function monto(){
        return $this->monto*-1;
    }
}
