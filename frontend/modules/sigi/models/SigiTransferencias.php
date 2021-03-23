<?php

namespace frontend\modules\sigi\models;
use frontend\modules\sigi\models\SigiPropietarios;
use Yii;

/**
 * This is the model class for table "{{%sigi_transferencias}}".
 *
 * @property int $id
 * @property int $edificio_id
 * @property int $unidad_id
 * @property string $fecha
 * @property string $tipotrans
 * @property string $nombre
 * @property string $correo
 * @property string $dni
 * @property int $parent_id
 *
 * @property SigiEdificios $edificio
 * @property SigiUnidades $unidad
 */
class SigiTransferencias extends \common\models\base\modelBase
{
   const TRANS_VENTA='10';
    public $dateorTimeFields=['fecha'=>self::_FDATE];
    public $booleanFields=['activo'];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sigi_transferencias}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['edificio_id', 'unidad_id', 'fecha', 'tipotrans', 'nombre','codpro'], 'required'],
            [['edificio_id', 'unidad_id', 'parent_id'], 'integer'],
             [['edificio_id'], 'validate_inquilinos'],
            [['edificio_id'], 'validate_parent'],
             [['unidad_id'], 'validate_propietario'],
            [['edificio_id'], 'validate_facturacion'],
            [['fecha'], 'string', 'max' => 10],
            [['tipotrans'], 'string', 'max' => 2],
            [['correo'], 'email'],
             [['activo'], 'safe'],
            [['codpro','parent_id','fecha','edificio_id','tipotrans','correo','dni','codproant'], 'safe'],
            [['codpro'], 'validateCodpro'],
            [['nombre', 'correo'], 'string', 'max' => 60],
            [['dni'], 'string', 'max' => 14],
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
            'edificio_id' => Yii::t('sigi.labels', 'Edificio'),
            'unidad_id' => Yii::t('sigi.labels', 'Unidad'),
            'fecha' => Yii::t('sigi.labels', 'Fecha'),
            'tipotrans' => Yii::t('sigi.labels', 'Tipotrans'),
            'nombre' => Yii::t('sigi.labels', 'Nuevo Prop'),
            'codpro' => Yii::t('sigi.labels', 'Gr. Gestión'),
            'correo' => Yii::t('sigi.labels', 'Correo'),
            'dni' => Yii::t('sigi.labels', 'Dni'),
            'parent_id' => Yii::t('sigi.labels', 'Asignado a:'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdificio()
    {
        return $this->hasOne(Edificios::className(), ['id' => 'edificio_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnidad()
    {
        return $this->hasOne(SigiUnidades::className(), ['id' => 'unidad_id']);
    }

    /**
     * {@inheritdoc}
     * @return SigiTransferenciasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SigiTransferenciasQuery(get_called_class());
    }
    
    public function afterSave($insert,$ChangedAttributes){
       if($insert){
           //if($this->tipotrans==self::TRANS_VENTA){              
             $this->resolveTransferencia();
           //}
       }else{
           // SI SE ANULO LA TRANSFERENCIA
           if(!$this->activo)$this->resolveTransferencia(true); //TRUE DESHACER TODO
       }
        return parent::afterSave($insert,$ChangedAttributes);
    }
    
    public function beforeSave($insert){
       if($insert){
           $this->activo=true;
           $this->codproant=$this->unidad->codpro;
       }
        return parent::beforeSave($insert);
    }
    
    
    
    
    
    
    
    
    
    private function insertPropietario($mentirita=false){
        
        SigiPropietarios::updateAll([
             'activo'=>'0',
             'fcese'=>$this->swichtDate('fecha',false),
            ],
                [
                   'unidad_id'=>$this->unidad_id,
                   //'tipo'=> SigiUnidades::TYP_PROPIETARIO 
                    
                ]); 
        
        
        
        $model=new SigiPropietarios();
        $model->setAttributes([
            'unidad_id'=>$this->unidad_id,
            'codepa'=>$this->unidad->numero,
            'edificio_id'=>$this->edificio_id,
              'tipo'=> SigiUnidades::TYP_PROPIETARIO, 
             'correo'=>$this->correo,
            'nombre'=>$this->nombre,
              'finicio'=> $this->fecha
        ]);
       if($mentirita){
          return $model->validate();  
       }else{
           return $model->save();  
       }
       
    }
    
    public function resolveCodpro($undo=false){
                $unidad=$this->unidad;
                $unidad->setScenario($unidad::SCENARIO_BASICO); 
                if(!$undo){
                    $unidad->codpro=$this->codpro;
                }else{//Si es deshcer sacar el codpro anterior de la auditoria
                   $unidad->codpro=($unidad->oldValueField('codpro'))?$unidad->oldValueField('codpro'):$this->codpro; 
                }                
               return  $unidad->save();  
               
    }
    
    public function resolveParent($undo=false){
         yii::error('----resolve parent----');
           yii::error($this->attributes);
       if(!is_null($this->parent_id)){
           $exito=true;
                $unidad=$this->unidad;
                $unidad->setScenario($unidad::SCENARIO_PARENT); 
                 if(!$undo){
                    $unidad->parent_id=$this->parent_id; 
                 }else{
                    $unidad->parent_id=($unidad->oldValueField('parent_id'))?$unidad->oldValueField('parent_id')+0:$this->parent_id;  
                 }
                
               IF(!$unidad->save()){
                 yii::error('fallo----');
                 $exito=false;
                 yii::error($unidad->getErrors());  
               }   
           return $exito;
       }
       return true;
        }  
       
     public function unResolveParent(){
       
                $unidad=$this->unidad;
                $unidad->setScenario($unidad::SCENARIO_PARENT);            
                $unidad->parent_id=null;
                $unidad->save();
       
     }   
 
     
     
     
     
    private function resolveTransferencia($undo=false){
       $this->resolvePropietario($undo);
       $this->resolveCodpro($undo);
       $this->resolveParent($undo);
       $this->resolveChilds($undo);
    }
    
   public function validateCodpro($attribute, $params)
    {
     //no puede haber un codpro con un parent_id  incosistentes
       if($this->parent_id >0 ){
          $codpro= SigiUnidades::findOne($this->parent_id)->codpro;
          if($codpro <> $this->codpro)
            $this->addError('codpro',yii::t('sigi.errors','La unidad padre tiene grupo de gestion {grupo} diferente al ingresado {ingresadndo}',['grupo'=>$codpro,'ingresado'=>$this->codpro]));
       }
       
    }
    
    
  private function resolveChilds($undo=false){
      yii::error('entrando a la funcion',__FUNCTION__);
      if(!$undo){
          $exito=true;
          foreach($this->unidad->childsUnits as $unidadHija){
          
            yii::error('recorriendo el bucle',__FUNCTION__);
          $unidadHija->setScenario($unidadHija::SCENARIO_PARENT);
          //if(!$undo){
               $unidadHija->parent_id=null;
          //}else{
              //yii::error('deshaciendo childs',__FUNCTION__);
               $unidadHija->parent_id=($unidadHija->oldValueField('parent_id'))?$unidadHija->oldValueField('parent_id')+0:null;
          //}
        
          IF(!$unidadHija->save()){
              $exito=false;
              break;
              yii::error('uhbi error el el ',__FUNCTION__);
              yii::error($unidadHija->getErrors(),__FUNCTION__);
          }          
        }
      }else{
          yii::error('deshaciendo childs',__FUNCTION__);
          $exito=true;
         $historiales= \common\models\audit\Activerecordlog::find()->where([
              'model'=>$this->unidad->className(),
              'field'=>'parent_id',
              'oldvalue'=>$this->unidad->id,
             // 'clave'=>$this->id
          ])->all();
         yii::error(\common\models\audit\Activerecordlog::find()->where([
              'model'=>self::className(),
              'field'=>'parent_id',
              'oldvalue'=>$this->unidad->id,
             // 'clave'=>$this->id
          ])->createCommand()->rawSql);
         foreach($historiales as $historial){
             
             yii::error('historial de unidades',__FUNCTION__);
            $unidad= SigiUnidades::findOne($historial->clave);
            $unidad->parent_id=$historial->oldvalue;
            if(!$unidad->save()){$exito=false;break;};
         }
          
      }
      return $exito;
  }
  
  /*
   * Desactiva/activa el propietario actual 
   */
  private function resolvePropietario($undo=false){
    
       /*SigiPropietarios::updateAll(['activo'=>($undo)?'1':'0',
             'fcese'=>($undo)?null:$this->swichtDate('fecha',false),
            ],['unidad_id'=>$this->unidad_id,]); */
       
       if(!$undo){//Si es hacer 
           $actual=$this->unidad->currentPropietario(); 
           //VAR_dump($this->unidad,$actual);die();
           $actual->activo=false;$actual->save();
        return (new SigiPropietarios([
            'unidad_id'=>$this->unidad_id,
            'codepa'=>$this->unidad->numero,
            'edificio_id'=>$this->edificio_id,
              'tipo'=> SigiUnidades::TYP_PROPIETARIO, 
             'correo'=>$this->correo,
            'nombre'=>$this->nombre,
              'finicio'=> $this->fecha
                              ]))->save();            
     }else{//Si es dehacer 
         /*Busca y Borra el usuario recien creado*/
         $this->unidad->currentPropietario()->delete();
         /*Luego nbusca el porpiestsario inmentdiatr anterrior y lo activca*/
         $model=$this->unidad->oldPropietario(SigiUnidades::TYP_PROPIETARIO);
       $model->activo=true;
      return  $model->save();
       
         
     }       
  }
  
  /*Se asegura de no tener inquilinos o ocnceionados antes de 
   * efectuar la transferencia*/
   
  public function validate_inquilinos($attribute,$params){
     if($this->unidad->getSigiPropietarios()->andWhere(['<>','tipo',SigiUnidades::TYP_PROPIETARIO])->count()>0)
     $this->addError ('edificio_id',yii::t('base.labels','Esta unidad tiene concesionados, antes de transferir por favor elimine los concesionados'));
  }
  
  public function validate_propietario(){
      if(is_null($this->unidad->currentPropietario())){
          $this->addError('unidad_id',yii::t('sigi.labels','Esta unidad no tiene propietario asignado'));
      }
  }
  
  /*
   * se asegura de no hacer transgrencias en fechas en als cuales 
   * ya habido facturacion, para hacer una entrega  trnasferencia
   * no debe de haber regisdtros factiurados en esta unidad
   * Es decir primero transfiera , luego facture
   */
  public function validate_facturacion($attribute,$params){
      $carbon=$this->toCarbon('fecha');      
     if($this->unidad->hasFacturacion(
                            $carbon->format('m'),
                            $carbon->format('y')
             )
        ) $this->addError ('unidad_id',yii::t('base.labels','Ya hay facturación para este mes'));
      
  }
  
   /*
   * se asegura de no hacer transgrencias asignando
    * un parent_id si tiene hijos, el parent_id 
    * debe aplicarse en genral para Cocheras y depositos
   */
  public function validate_parent($attribute,$params){
      if($this->parent_id > 0  && $this->unidad->hasChildunits())
      $this->addError('edificio_id',yii::t('base.labels','No puedes transferir esta unidad tiene adjuntos'));
  }
  
  public function hasFacturacion(){
      $carbon=$this->toCarbon('fecha');
       RETURN $this->unidad->hasFacturacion(
                            $carbon->format('m'),
                            $carbon->format('y')
             );
  }
  
  
  
  public function particionaRecibo(){
      IF($this->hasFacturacion()){
          
          
          
      }else{
          return false;
      }
      
  }
  
  
}
