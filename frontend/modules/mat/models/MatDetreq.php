<?php

namespace frontend\modules\mat\models;
use frontend\modules\mat\interfaces\ReqInterface;
use common\helpers\h;
use Yii;

/**
 * This is the model class for table "{{%mat_detreq}}".
 *
 * @property int $id
 * @property int $req_id
 * @property string $codart
 * @property string $descripcion
 * @property string $cant
 * @property string $um
 * @property string $imptacion
 * @property string $tipim
 * @property string $texto
 *
 * @property MatReq $req
 */
class MatDetreq extends \common\models\base\modelBase 
implements ReqInterface
{
   public $boolean_fields=['activo'];
   private $_cantreal=null;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mat_detreq}}';
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
    
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
             [['cant','req_id','cant','item',
                 'um','activo','descripcion','texto','os_id','detos_id','proc_id'], 'safe'],
            [['req_id'], 'integer'],
            [['cant'], 'number'],
            [['texto'], 'string'],
            [['codart', 'imptacion'], 'string', 'max' => 14],
            [['descripcion'], 'string', 'max' => 40],
            [['um'], 'string', 'max' => 4],
            [['tipim'], 'string', 'max' => 1],
            [['req_id'], 'exist', 'skipOnError' => true, 'targetClass' => MatReq::className(), 'targetAttribute' => ['req_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'req_id' => Yii::t('app', 'Req ID'),
            'codart' => Yii::t('app', 'Código'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'cant' => Yii::t('app', 'Cant'),
            'um' => Yii::t('app', 'Um'),
            'imptacion' => Yii::t('app', 'Imputación'),
            'tipim' => Yii::t('app', 'Tipim'),
            'texto' => Yii::t('app', 'Texto'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReq()
    {
        return $this->hasOne(MatReq::className(), ['id' => 'req_id']);
    }
    
     public function getMaterial()
    {
        return $this->hasOne(\common\models\masters\Maestrocompo::className(), ['codart' => 'codart']);
    }

    
    /* public function getStock()
    {
        return $this->hasOne(MatStock::className(), ['codart' => 'codart']);
    }*/
    /**
     * {@inheritdoc}
     * @return MatDetreqQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MatDetreqQuery(get_called_class());
    }
    
    public function desactiva($desactiva=true){
        $this->activo=!$desactiva;
        $this->save();
    }
    
    public function beforeSave($insert) {
        if($insert){
            $this->ultimo= time();
            $this->activo=true;            
            $this->item='1'.str_pad($this->req->getDetalles()->count()+1,3,'0',STR_PAD_LEFT);
            $this->user_id=h::userId();
        }
        if($this->hasChanged('codart'))
          $this->descripcion=$this->material->descripcion;
        return parent::beforeSave($insert);
    }
    
  public function getCantReal(){
        if(is_null($this->_cantreal)){
           if(is_null($this->um)){
            
              }else
          $this->cant=$this->cant*$this->material->factorConversion($this->um);
        }
        return $this;       
    }
    
   
  public function verify_um() {
     if(!$this->material->existsUm($this->um,false)){
          $this->addError('um',yii::t('base.errors','La unidad de medida no está registrada'));
       }
  }
  
  public function isActive(){
      return $this->activo;
  }
  
  
  /*Para aquellas requesiciones que son generadas 
   * dentro de una OT, es necesario automatizar 
   * el id 
   */
  public function detectaIdReq(){
      if(!$this->req_id>0){
         $registro= $this->find()->andWhere(['user_id'=>h::userId()])->orderBy(['id'=>SORT_DESC])->one();
          if(is_null($registro)){
             return  self::createNewReq();
          }else{
              if(time()-$registro->ultimo >60*60){
                   return  self::createNewReq();
              }else{
                  return $registro->req_id;
              }
          }
      }
    }
  
  
  
  public static function createNewReq(){
      $model= MatReq::instance();
      $model->setAttributes(
              [
                  'descripcion'=>'AUTO',
                  'fechasol'=>self::SwichtFormatDate(self::CarbonNow()->format('Y-m-d'), 'date', true),
                  'fechaprog'=>self::SwichtFormatDate(self::CarbonNow()->format('Y-m-d'), 'date', true),
              ]
            );  
      if($model->save()){
          $model->refresh();
            return $model->id;
      }else{
         return -1; 
      }
      
     }
  
     
     
    
}
