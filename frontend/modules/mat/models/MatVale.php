<?php

namespace frontend\modules\mat\models;
use common\models\masters\Clipro;
use Yii;

/**
 * This is the model class for table "{{%mat_vale}}".
 *
 * @property int $id
 * @property string $numero
 * @property string $fecha
 * @property string $codpro
 * @property string $codmov
 * @property string $descripcion
 * @property string $texto
 * @property string $codest
 *
 * @property Clipro $codpro0
 */
class MatVale extends \common\models\base\modelBase implements \frontend\modules\mat\interfaces\EstadoInterface
{
    /**
     * {@inheritdoc}
     */
    const ESTADO_CREADO='10';
     const ESTADO_APROBADO='20';
      const ESTADO_ANULADO='99';
    public $prefijo='67';
     public $dateorTimeFields = [
        'fecha' => self::_FDATE,       
    ];
    public static function movimientos(){
        return [    
            '100'=>['SALIDA PARA CONSUMO',-1],
            '101'=>['DEVOLUCION',-1],
            '103'=>['ANULACION VALE',-1],
            '900'=>['INGRESO POR COMPRA',1],
             '901'=>['REINGRESO',1],
            ];
        
    }
    
    public function signo(){
       $movimientos= $this->movimientos();
       return $movimientos[$this->codmov][1];
    }
    
    public static function tableName()
    {
        return '{{%mat_vale}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'codpro', 'codmov'], 'required'],
            [['texto'], 'string'],
            [['numero', 'fecha'], 'string', 'max' => 10],
            [['codpro'], 'string', 'max' => 6],
            [['codmov', 'codest'], 'string', 'max' => 3],
            [['descripcion'], 'string', 'max' => 40],
            [['codpro'], 'exist', 'skipOnError' => true, 'targetClass' => Clipro::className(), 'targetAttribute' => ['codpro' => 'codpro']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'numero' => Yii::t('app', 'Numero'),
            'fecha' => Yii::t('app', 'Fecha'),
            'codpro' => Yii::t('app', 'Codpro'),
            'codmov' => Yii::t('app', 'Codmov'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'texto' => Yii::t('app', 'Texto'),
            'codest' => Yii::t('app', 'Codest'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClipro()
    {
        return $this->hasOne(Clipro::className(), ['codpro' => 'codpro']);
    }
  public function getDetalles()
    {
        return $this->hasMany(MatDetvale::className(), ['vale_id' => 'id']);
           //return $this->hasMany(Examenes::className(), ['citas_id' => 'id']);
    }
    /**
     * {@inheritdoc}
     * @return MatValeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MatValeQuery(get_called_class());
    }
    
    public function beforeSave($insert) {
        IF($insert){
            $this->numero=$this->correlativo('numero',10);
            $this->codest=self::ESTADO_CREADO;
        } 
        
        RETURN parent::beforeSave($insert);
    }
    
    public function Aprobar(){
        $transaccion=$this->getDb()->beginTransaction(\yii\db\Transaction::SERIALIZABLE);
      foreach($this->detalles as $detvale){
          $detvale->aprobado();
      }
            $this->codest=self::ESTADO_APROBADO;
            $this->save();
           $transaccion->commit();
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
