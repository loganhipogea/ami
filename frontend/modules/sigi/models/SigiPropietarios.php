<?php

namespace frontend\modules\sigi\models;
USE frontend\modules\sigi\models\SigiUnidades;
USE common\helpers\h;
USE common\models\masters\Clipro;
use Yii;

class SigiPropietarios extends \common\models\base\modelBase
{
    CONST SCENARIO_EMPRESA='empresa';
    CONST SCENARIO_TELEFONO='telefonos_correos';
    //CONST ROL_PROPIETARIO='r_propietario';
    public $booleanFields=['espropietario','recibemail','activo','recibo','resumirprop'];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sigi_propietarios}}';
    }
 public function scenarios()
    {
        $scenarios = parent::scenarios(); 
        $scenarios[self::SCENARIO_EMPRESA] = ['edificio_id','codepa','activo','tipo','dni','nombre','recibemail','correo','celulares','fijo'];
         $scenarios[self::SCENARIO_TELEFONO] = ['id','correo','celulares','fijo'];
        // $scenarios[self::SCENARIO_REGISTER] = ['username', 'email', 'password'];
        return $scenarios;
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'tipo','nombre','edificio_id'], 'required'],
             [[ 'nombre'],'string',  'max'=>70],
            [['unidad_id'], 'integer'],
            [['participacion'], 'number'],
             [['recibemail','nombre','espropietario','user_id'], 'safe'],
            [['detalle'], 'string'],
             [['codepa','edificio_id','activo','dni','correo','recibo'], 'safe'],
            [['dni'], 'valida_dni'],
             //[['activo'], 'safe'],
           // [['correo', 'dni'], 'unique', 'targetAttribute' => ['correo', 'dni']],
            [['codepa'], 'valida_codepa'],
            [['codepa'], 'required', 'on'=>self::SCENARIO_EMPRESA],
            [['id'], 'required', 'on'=>self::SCENARIO_TELEFONO],
            [['tipo'], 'string', 'max' => 1],
             [['correo', 'correo1', 'correo2'], 'email'],
            [['correo', 'correo1', 'correo2', 'celulares'], 'string', 'max' => 80],
            [['fijo', 'dni'], 'string', 'max' => 12],
            [['finicio', 'fcese'], 'string', 'max' => 10],
            [['edificio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Edificios::className(), 'targetAttribute' => ['edificio_id' => 'id']],
            [['unidad_id'], 'exist', 'skipOnError' => true, 'targetClass' => SigiUnidades::className(), 'targetAttribute' => ['unidad_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sigi.labels', 'ID'),
            'unidad_id' => Yii::t('sigi.labels', 'Unidad ID'),
            'tipo' => Yii::t('sigi.labels', 'Tipo'),
            'correo' => Yii::t('sigi.labels', 'Correo'),
            'correo1' => Yii::t('sigi.labels', 'Correo1'),
            'correo2' => Yii::t('sigi.labels', 'Correo2'),
            'celulares' => Yii::t('sigi.labels', 'Celulares'),
            'fijo' => Yii::t('sigi.labels', 'Fijo'),
            'dni' => Yii::t('sigi.labels', 'Dni'),
            'participacion' => Yii::t('sigi.labels', 'Participacion'),
            'detalle' => Yii::t('sigi.labels', 'Detalle'),
            'activo' => Yii::t('sigi.labels', 'Activo'),
            'finicio' => Yii::t('sigi.labels', 'Finicio'),
            'fcese' => Yii::t('sigi.labels', 'Fcese'),
            'codepa' => Yii::t('sigi.labels', 'Numero Dep'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnidad()
    {
        return $this->hasOne(SigiUnidades::className(), ['id' => 'unidad_id']);
    }
    
    public function getEdificio()
    {
        return $this->hasOne(Edificios::className(), ['id' => 'edificio_id']);
    }

    /**
     * {@inheritdoc}
     * @return SigiPropietariosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SigiPropietariosQuery(get_called_class());
    }
    
    public function beforeSave($insert){
        if($insert){
            $this->activo=true;
          //  if((!empty($this->codepa) && empty($this->unidad_id)))
          IF($this->getScenario()==static::SCENARIO_EMPRESA)
           $this->unidad_id=$this->departamento()->id;            
        }
        return parent::beforeSave($insert);
    }
    
    public function afterSave($insert, $changedAttributes) {
        
        IF(in_array('recibo',array_keys($changedAttributes)) && $this->recibo
                && $this->activo){
           self::updateAll(['recibo'=>'0'],['unidad_id'=>$this->unidad_id,['<>','id',$this->id]]);
        }
        /*
         * Si está registrado como usuario en el edificio
         * y cambia el correo, borrar la afiliacion
         */
         IF(in_array('correo',array_keys($changedAttributes))){
             yii::error('encontradn0 el usuario con '.$changedAttributes['correo'],__FUNCTION__);
             $user=\common\models\User::findByEmail($changedAttributes['correo']);
             yii::error($user,__FUNCTION__);
             if(!is_null($user)){
                 yii::error('funjco',__FUNCTION__);
                $user->email=$this->correo; $user->save();
               SigiUserEdificios::deleteAll(['user_id'=>$user->id,'edificio_id'=>$this->edificio->id]); 
             }
             
        }
       RETURN parent::afterSave($insert, $changedAttributes); 
    }
    
    public function departamento(){
        //yii::error(SigiUnidades::find()->where(['numero'=>$this->codepa,'edificio_id'=>$this->edificio_id])->createCommand()->getRawSql());
      return SigiUnidades::find()->where(['numero'=>$this->codepa,'edificio_id'=>$this->edificio_id])->one();
    }
        
    
    
    public function valida_codepa($attribute, $params)
    {
        if(!empty($this->codepa)){
            $registro= $this->departamento();
            if(is_null($registro)){
               $this->addError ('codepa',yii::t('sigi.errors','El número de departamento {numero} indicado no se enuentra en el edificio ',['numero'=>$this->codepa]));  
                  
            }
            
        }
            
        
      }
  public function valida_dni($attribute, $params)
    {
        $error=false;
     if(!((preg_match(h::settings()->get('general','formatoDNI'),$this->dni)==1) or 
        (preg_match(h::settings()->get('general','formatoRUC'),$this->dni)==1)
        )){
        $this->addError('dni',yii::t('sigi.errors','El valor para este campo no es correcto, debe ser un DNI o un RUC'));
    
      } 
            }          
   public function valida_propietario($attribute, $params)
    {
       if($this->isNewRecord){
           $esnuevo=Unidad::findOne()->esnuevo;
       }ELSE{
          $esnuevo=$this->unidad->esnuevo;
       }
       if($this->tipo=SigiUnidades::TYP_INQUILINO && 
          $esnuevo){
           $this->addError('nombre','No se permiten inquilinos en un departamento sin entregar');
       }
       
       
     } 
     /*
      * Fucnion pra generar usuairo 
      */
  public function generateUser(){
       $usuario= new \frontend\modules\sigi\models\users\SignupForm();
    
       $usuario->email=$this->correo;
       $usuario->username=$this->unidad->generateUsername();
       $usuario->password=$this->unidad->generatePwd();
      $usuario->signupResidente($this->edificio_id);
      /* if(!$usuario->hasErrors()){
           $this->user_id=$usuario->id;
           $this->save();
       }*/
       return $usuario;      
       
  }
  
  
public function correos(){
   return  SigiMailsprop::find()->select(['correo'])->andWhere(['propietario_id'=>$this->id])->column();
}  
     
}
