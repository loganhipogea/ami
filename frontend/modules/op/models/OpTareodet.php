<?php

namespace frontend\modules\op\models;
use common\models\masters\Trabajadores;

use Yii;

/**
 * This is the model class for table "{{%op_tareodet}}".
 *
 * @property int $id
 * @property int $tareo_id
 * @property string $hinicio
 * @property string $hfin
 * @property int $proc_id
 * @property int $os_id
 * @property int $detos_id
 * @property string $codtra
 * @property string $descripcion
 * @property string $detalle
 * @property int $tarifa_id
 * @property string $costo
 * @property string $htotales
 *
 * @property Trabajadores $codtra0
 * @property OpOs $os
 * @property OpTareo $tareo
 * @property OpProcesos $proc
 * @property OpOsdet $detos
 * @property OpPlanestarifa $tarifa
 */
class OpTareodet extends \common\models\base\modelBase
{
       use  \common\traits\timeTrait;
        const ESTADO_CREADO='10';
        const ESTADO_APROBADO='20';
        const ESTADO_ANULADO='99';
        
     public $dateorTimeFields=[
        'hinicio'=>self::_FHOUR,
        'hfin'=>self::_FHOUR];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%op_tareodet}}';
    }
public function behaviors() {
        return [
           /* 'AccessDownloadBehavior' => [
                'class' => AccessDownloadBehavior::className()
            ],*/
            /*'fileBehavior' => [
                'class' => FileBehavior::className()
            ],*/
            'auditoriaBehavior' => [
                'class' => '\common\behaviors\AuditBehavior',
            ],
            'caliBehavior' => [
                'class' => '\common\behaviors\CaliBehavior',
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tareo_id', 'proc_id', 'os_id', 'detos_id', 'tarifa_id'], 'required'],
            [['tareo_id', 'proc_id', 'os_id', 'detos_id', 'tarifa_id'], 'integer'],
            [['detalle'], 'string'],
            [['costo', 'htotales'], 'number'],
             [['hextras',], 'safe'],
            [['hinicio', 'hfin'], 'string', 'max' => 5],
            [['hinicio', 'hfin'], 'validahoras'],
            [['codtra'], 'string', 'max' => 6],
            [['descripcion'], 'string', 'max' => 40],
            [['codtra'], 'exist', 'skipOnError' => true, 'targetClass' => Trabajadores::className(), 'targetAttribute' => ['codtra' => 'codigotra']],
            [['os_id'], 'exist', 'skipOnError' => true, 'targetClass' => OpOs::className(), 'targetAttribute' => ['os_id' => 'id']],
            [['tareo_id'], 'exist', 'skipOnError' => true, 'targetClass' => OpTareo::className(), 'targetAttribute' => ['tareo_id' => 'id']],
            [['proc_id'], 'exist', 'skipOnError' => true, 'targetClass' => OpProcesos::className(), 'targetAttribute' => ['proc_id' => 'id']],
            [['detos_id'], 'exist', 'skipOnError' => true, 'targetClass' => OpOsdet::className(), 'targetAttribute' => ['detos_id' => 'id']],
            [['tarifa_id'], 'exist', 'skipOnError' => true, 'targetClass' => OpPlanestarifa::className(), 'targetAttribute' => ['tarifa_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'tareo_id' => Yii::t('app', 'Tareo ID'),
            'hinicio' => Yii::t('app', 'Hinicio'),
            'hfin' => Yii::t('app', 'Hfin'),
            'proc_id' => Yii::t('app', 'Proc ID'),
            'os_id' => Yii::t('app', 'Os ID'),
            'detos_id' => Yii::t('app', 'Detos ID'),
            'codtra' => Yii::t('app', 'Codtra'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'detalle' => Yii::t('app', 'Detalle'),
            'tarifa_id' => Yii::t('app', 'Tarifa ID'),
            'costo' => Yii::t('app', 'Costo'),
            'htotales' => Yii::t('app', 'Htotales'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrabajador()
    {
        return $this->hasOne(Trabajadores::className(), ['codigotra' => 'codtra']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOs()
    {
        return $this->hasOne(OpOs::className(), ['id' => 'os_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTareo()
    {
        return $this->hasOne(OpTareo::className(), ['id' => 'tareo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProc()
    {
        return $this->hasOne(OpProcesos::className(), ['id' => 'proc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetos()
    {
        return $this->hasOne(OpOsdet::className(), ['id' => 'detos_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTarifa()
    {
        return $this->hasOne(OpPlanestarifa::className(), ['id' => 'tarifa_id']);
    }

    /**
     * {@inheritdoc}
     * @return OpTareodetQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OpTareodetQuery(get_called_class());
    }
    
    public function beforeSave($insert) {
        if($insert){
           // $this->activo=true;            
            //$this->item='1'.str_pad($this->vale->getDetalles()->count()+1,3,'0',STR_PAD_LEFT);
            $this->estado=self::ESTADO_CREADO;
        }
        if($this->hasChanged('hinicio') || $this->hasChanged('hfin')){
            $this->htotales=$this->horasTrabajadas();
            $this->hextras=$this->horasExtras();
            $this->monto=$this->calculaCosto();
        }
            
        return parent::beforeSave($insert);
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
    
    private function isHabilitadoToAprobar(){
        
    }
    
    public function validahoras($attribute, $params) {
        if($this->toCarbon('hinicio')->gt($this->toCarbon('hfin'))){
            $this->addError($attribute,yii::t('base.errors','La hora de inicio es menor que la hora de salida'));
        }
        
    }
    
    private function horasTrabajadas(){
        return $this->toCarbon('hfin')->
               diffInHours($this->toCarbon('hinicio'));
    }
    
    public function horasExtras(){
       $dif= $this->toCarbon('hfin')->
               diffInHours($this->toCarbon('hinicio'))-$this->tarifa->plan->nhoras;
        if($dif<0)return 0;
        return $dif;
       
    }
    
    private function calculaCosto(){
       /*factor de locacion*/
        
        
        /*factor de festividad*/
         $factorTurno=$this->tarifa->plan->porc_feriado/100;
         
          /*factor dominical*/
         $factorTurno=$this->tarifa->plan->porc_dominical/100;
        
         
        /*factor de turno (NOCHE/DIA)*/ 
        $factorTurno=$this->tarifa->plan->porc_hextras/100;
        
        
        /*factor de horas extras*/ 
        //$factorExtras=$this->tarifa->plan->p
                //porc_hextras/100;
       // $montoExtras=$this->horasExtras()*$factorExtras;
        
        
        /*factor de riesgo*/ 
    }
    
}
