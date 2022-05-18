<?php

namespace frontend\modules\op\models;

use Yii;

/**
 * This is the model class for table "{{%op_osdet}}".
 *
 * @property int $id
 * @property int $proc_id
 * @property int $os_id
 * @property string $finicio
 * @property string $termino
 * @property string $descripcion
 * @property string $item
 * @property string $emplazamiento
 * @property string $codtra
 * @property string $tipo
 * @property string $tarifa
 * @property string $detalle
 * @property string $valor
 * @property string $numero
 * @property string $interna
 *
 * @property OpProcesos $proc
 * @property OpOs $os
 */
class OpOsdet extends \common\models\base\modelBase
{
   public $booleanFields = [
        'interna' ,
       // 'fechaini' => self::_FDATE,
        //'ftermino' => self::_FDATETIME
    ];
     public $dateorTimeFields=[
     'finicio'=>self::_FDATETIME,
     'termino'=>self::_FDATETIME,
         
         ];
    public function behaviors()
         {
                return [
		
		'fileBehavior' => [
			'class' => '\common\behaviors\FileBehavior' 
                               ],
                    'auditoriaBehavior' => [
			'class' => '\common\behaviors\AuditBehavior' ,
                               ],
		
                    ];
        }
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%op_osdet}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['proc_id', 'os_id'], 'integer'],
            [['detalle'], 'string'],
            [['valor'], 'number'],
            //[['numero'], 'required'],
            [['finicio', 'termino'], 'string', 'max' => 19],
            [['descripcion'], 'string', 'max' => 40],
            [['item'], 'string', 'max' => 3],
            [['emplazamiento', 'tipo', 'tarifa',], 'string', 'max' => 1],
            [['codtra'], 'string', 'max' => 6],
            [['numero'], 'string', 'max' => 9],
            [['proc_id'], 'exist', 'skipOnError' => true, 'targetClass' => OpProcesos::className(), 'targetAttribute' => ['proc_id' => 'id']],
            [['os_id'], 'exist', 'skipOnError' => true, 'targetClass' => OpOs::className(), 'targetAttribute' => ['os_id' => 'id']],
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
            'os_id' => Yii::t('app', 'Os ID'),
            'finicio' => Yii::t('app', 'Finicio'),
            'termino' => Yii::t('app', 'Termino'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'item' => Yii::t('app', 'Item'),
            'emplazamiento' => Yii::t('app', 'Emplazamiento'),
            'codtra' => Yii::t('app', 'Codtra'),
            'tipo' => Yii::t('app', 'Tipo'),
            'tarifa' => Yii::t('app', 'Tarifa'),
            'detalle' => Yii::t('app', 'Detalle'),
            'valor' => Yii::t('app', 'Valor'),
            'numero' => Yii::t('app', 'Numero'),
            'interna' => Yii::t('app', 'Interna'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProc()
    {
        return $this->hasOne(OpProcesos::className(), ['id' => 'proc_id']);
    }
    
      public function getTrabajador()
    {
        return $this->hasOne(\common\models\masters\Trabajadores::className(), ['codigotra' => 'codtra']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOs()
    {
        return $this->hasOne(OpOs::className(), ['id' => 'os_id']);
    }

    /**
     * {@inheritdoc}
     * @return OpOsdetQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OpOsdetQuery(get_called_class());
    }
    
    public function beforeSave($insert) {
        if($insert){
          $this->item='1'.str_pad($this->os->getDetalles()->count()+1,2,'0',STR_PAD_LEFT);
          $this->interna=true;  
        }
        return parent::beforeSave($insert);
    }
    
    public function comprar(){
        $this->interna=false;
       $this->save();
        $model=New \frontend\modules\mat\models\MatDetreq();
        $model->setScenario($model::SCE_IMPUTADO);
        $model->setAttributes([
                            'req_id'=>$model->detectaIdReq(),
                             'cant'=>1,
                            // 'um'=>'PZA',
                        'descripcion'=>$this->descripcion,
                             'os_id'=>$this->os_id,
                            'detos_id'=>$this->id,
                                'proc_id'=>$this->proc_id
                    ]);
       // yii::error('atributos');
        //yii::error($model->attributes);
        
       $model->save();
        
    }
    /*
     * Verifica si tiene uan solicitud de compra activa
     */
    private function hasReqActive(){
       
    }
    
}
