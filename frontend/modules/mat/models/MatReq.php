<?php
namespace frontend\modules\mat\models;
use common\models\masters\Trabajadores;
use Yii;
class MatReq extends \common\models\base\modelBase
{
    
    const EST_CRE='1000';
    const EST_APRO='1001';
    const EST_ANU='9999';
    
    public $prefijo='37';
    /**
     * {@inheritdoc}
     */
     public $dateorTimeFields=[
     'fechaprog'=>self::_FDATE,
     'fechasol'=>self::_FDATE,
         
         ];
    public static function tableName()
    {
        return '{{%mat_req}}';
    }
    
    
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
    
   
    public function rules()
    {
        return [
          //  [['numero'], 'required'],
            [['texto'], 'string'],
            [['numero', 'fechaprog', 'fechasol'], 'string', 'max' => 10],
            [['codtra'], 'string', 'max' => 6],
            [['descripcion'], 'string', 'max' => 40],
            [['codest'], 'string', 'max' => 3],
            [['codtra'], 'exist', 'skipOnError' => true, 'targetClass' => Trabajadores::className(), 'targetAttribute' => ['codtra' => 'codigotra']],
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
            'fechaprog' => Yii::t('app', 'F. programada'),
            'fechasol' => Yii::t('app', 'F. solicitada'),
            'codtra' => Yii::t('app', 'Solicitante'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'texto' => Yii::t('app', 'Texto'),
            'codest' => Yii::t('app', 'Estado'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrabajador()
    {
        return $this->hasOne(Trabajadores::className(), ['codigotra' => 'codtra']);
    }
    
     public function getDetalles()
    {
        return $this->hasMany(MatDetreq::className(), ['req_id' => 'id']);
           //return $this->hasMany(Examenes::className(), ['citas_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return MatReqQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MatReqQuery(get_called_class());
    }
    
    public function beforeSave($insert) {
        $this->numero=$this->correlativo('numero',10);
        RETURN parent::beforeSave($insert);
    }
    
    public function activate(){
        
        
    }
    
    
}
