<?php

namespace frontend\modules\op\models;
use common\models\masters\Trabajadores;
use common\models\masters\Clipro;
use Yii;

/**
 * This is the model class for table "{{%op_os}}".
 *
 * @property int $id
 * @property int $proc_id
 * @property string $numero
 * @property string $fechaprog
 * @property string $fechaini
 * @property string $codtra
 * @property string $codpro
 * @property string $descripcion
 * @property string $tipo
 * @property string $codestado
 * @property string $textocomercial
 * @property string $textointerno
 * @property string $textotecnico
 */
class OpOs extends \common\models\base\modelBase
{
    
    CONST LUGAR_TALLER='T';
    CONST LUGAR_PLANTA='P';
    
     public $dateorTimeFields = [
        'fechaprog' => self::_FDATE,
        'fechaini' => self::_FDATE,
        //'ftermino' => self::_FDATETIME
    ];
     
      
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%op_os}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['proc_id'], 'required'],
             [['item'], 'safe'],
            [['proc_id'], 'integer'],
            [['textocomercial', 'textointerno', 'textotecnico'], 'string'],
            [['numero'], 'string', 'max' => 10],
            [['fechaprog', 'fechaini'], 'string', 'max' => 10],
            [['codtra', 'codpro'], 'string', 'max' => 6],
            [['descripcion'], 'string', 'max' => 40],
            [['tipo'], 'string', 'max' => 1],
            [['codestado'], 'string', 'max' => 2],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'proc_id' => Yii::t('app', 'Proc ID'),
            'numero' => Yii::t('app', 'Numero'),
            'fechaprog' => Yii::t('app', 'Fechaprog'),
            'fechaini' => Yii::t('app', 'Fechaini'),
            'codtra' => Yii::t('app', 'Codtra'),
            'codpro' => Yii::t('app', 'Codpro'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'tipo' => Yii::t('app', 'Tipo'),
            'codestado' => Yii::t('app', 'Codestado'),
            'textocomercial' => Yii::t('app', 'Textocomercial'),
            'textointerno' => Yii::t('app', 'Textointerno'),
            'textotecnico' => Yii::t('app', 'Textotecnico'),
        ];
    }

    
    public function getCliente()
    {
        return $this->hasOne(Clipro::className(), ['codpro' => 'codpro']);
    }
    
    public function getResponsable()
    {
        return $this->hasOne(Trabajadores::className(), ['codigotra' => 'codtra']);
    }
    
     public function getProceso()
    {
        return $this->hasOne(OpProcesos::className(), ['id' => 'proc_id']);
    }
     public function getDetalles()
    {
        return $this->hasMany(OpOsdet::className(), ['os_id' => 'id']);
           //return $this->hasMany(Examenes::className(), ['citas_id' => 'id']);
    }
    /**
     * {@inheritdoc}
     * @return OpOsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OpOsQuery(get_called_class());
    }
    
    
    public function creaHijo(){
        $model=OpOsdet::instance();
        $model->setAttributes([
            'proc_id'=>$this->proc_id,
            'os_id'=>$this->id,
            'finicio'=>self::SwichtFormatDate(self::CarbonNow()->format('Y-m-d'),'date',true),
            'termino'=>self::SwichtFormatDate(self::CarbonNow()->format('Y-m-d'),'date',true),
             'descripcion'=>$this->descripcion,
            'emplazamiento'=>self::LUGAR_TALLER,
            'interna'=>true,
            
                ]);
        $model->save();
        //print_r($model->getErrors());die();
    }
    
     public function beforeSave($insert) {
       // yii::error('funcion beforeSave  '.date('Y-m-d H:i:s'));
        if ($insert) { 
           $this->item='1'.str_pad($this->proceso->getOrdenes()->count()+1,2,'0',STR_PAD_LEFT);
           $this->numero =$this->proceso->numero.'-'.$this->item;   
           
        }       
        return parent::beforeSave($insert);
    }
    
    public function afterSave($insert, $changedAttributes) {
        if($insert){      
            $this->refresh();
            $this->creaHijo();
            
        }
        return parent::afterSave($insert, $changedAttributes);
    }
}
