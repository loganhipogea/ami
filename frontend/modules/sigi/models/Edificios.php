<?php

namespace frontend\modules\sigi\models;
use common\models\masters\Trabajadores;
use frontend\modules\sigi\models\SigiUnidades;
use frontend\modules\sigi\models\SigiCuentaspor;
use common\models\masters\Centros;
use yii\web\NotFoundHttpException;
use frontend\models\SignupForm;
use common\helpers\h;
use Yii;

/**
 * This is the model class for table "{{%sigi_edificios}}".
 *
 * @property int $id
 * @property string $codtra
 * @property string $nombre
 * @property string $latitud
 * @property string $meridiano
 * @property string $proyectista
 * @property string $tipo
 * @property int $npisos
 * @property string $detalles
 * @property string $codcen
 * @property string $direccion
 * @property string $coddepa
 * @property string $codprov
 *
 * @property Trabajadores $codtra0
 * @property Centros $codcen0
 */
class Edificios extends \common\models\base\modelBase
{
   public static $varsToReplace=[
       '$cuenta'=>'',
       '$dias'=>'',
       '$banco'=>'',
       '$correo_cobranza'=>''
                ];
    public $hardFields=['codigo','codcen'];
    /**
     * {@inheritdoc}
     */
    
     public function behaviors()
         {
                return [
		
		/*'fileBehavior' => [
			'class' => '\frontend\modules\attachments\behaviors\FileBehaviorAdvanced' 
                               ],*/
                    'auditoriaBehavior' => [
			'class' => '\common\behaviors\AuditBehavior' ,
                               ],
		
                    ];
        }
    
    
    
    public static function tableName()
    {
        return '{{%sigi_edificios}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codtra', 'nombre','codigo', 'tipo', 'npisos', 'codcen', 'direccion', 'coddepa', 'codprov'], 'required'],
            [['npisos'], 'integer'],
            [['coddist','codigo','facturacion'], 'safe'],
            [['detalles'], 'string'],
            [['codtra', 'codprov'], 'string', 'max' => 6],
            [['nombre', 'proyectista'], 'string', 'max' => 60],
            [['latitud', 'meridiano'], 'string', 'max' => 16],
            [['tipo'], 'string', 'max' => 3],
            [['codcen'], 'string', 'max' => 5],
            [['direccion'], 'string', 'max' => 100],
            [['coddepa'], 'string', 'max' => 9],
            [['codtra'], 'exist', 'skipOnError' => true, 'targetClass' => Trabajadores::className(), 'targetAttribute' => ['codtra' => 'codigotra']],
            [['codcen'], 'exist', 'skipOnError' => true, 'targetClass' => Centros::className(), 'targetAttribute' => ['codcen' => 'codcen']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sigi.labels', 'ID'),
            'codtra' => Yii::t('sigi.labels', 'Administrador'),
            'nombre' => Yii::t('sigi.labels', 'Nombre'),
            'latitud' => Yii::t('sigi.labels', 'Latitud'),
            'meridiano' => Yii::t('sigi.labels', 'Meridiano'),
            'proyectista' => Yii::t('sigi.labels', 'Proyectista'),
            'tipo' => Yii::t('sigi.labels', 'Tipo Unidad'),
            'npisos' => Yii::t('sigi.labels', 'Niveles'),
            'detalles' => Yii::t('sigi.labels', 'Detalles'),
            'codcen' => Yii::t('sigi.labels', 'Centro'),
            'direccion' => Yii::t('sigi.labels', 'Dirección'),
            'coddepa' => Yii::t('sigi.labels', 'Departamento'),
            'codprov' => Yii::t('sigi.labels', 'Provincia'),
             'coddist' => Yii::t('sigi.labels', 'Distrito'),
            'facturacion' => Yii::t('sigi.labels', 'Texto Facturación'),
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
    public function getCuentas()
    {
        return $this->hasMany(SigiCuentas::className(), ['edificio_id' => 'id']);
    }
    
    
   
    
    
     public function getPropietarios()
    {
        return $this->hasMany(SigiPropietarios::className(), ['edificio_id' => 'id']);
    }
     public function getApoderados()
    {
        return $this->hasMany(SigiApoderados::className(), ['edificio_id' => 'id']);
    }
    
    public function getColectores()
    {
        return $this->hasMany(SigiCargosedificio::className(), ['edificio_id' => 'id']);
    }
    
    public function getCargos()
    {
        return $this->hasMany(SigiCargosgrupoedificio::className(), ['edificio_id' => 'id']);
    }
    
    public function getCentro()
    {
        return $this->hasOne(Centros::className(), ['codcen' => 'codcen']);
    }
    
    public function getUnidades()
    {
        return $this->hasMany(SigiUnidades::className(), ['edificio_id' => 'id']);
    }
    
     public function getSuministros()
    {
        return $this->hasMany(SigiSuministros::className(), ['edificio_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return EdificiosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EdificiosQuery(get_called_class());
    }
    
    public function queryUnidades(){
        return SigiUnidades::find()->where([
            '[[edificio_id]]'=>$this->id,
           // 'imputable'=>'1',
                ]);
    }
    public function queryUnidadesImputables(){
        return $this->queryUnidades()->andWhere([
             'imputable'=>'1',
                ]);
    }
    
    /*
     * Deparatamenteos o unidades que sonimputables y ademas
     * son padres, o representan una cobranza,      * 
     */
    public function unidadesImputablesPadres(){
        return $this->queryUnidades()->andWhere([
             'imputable'=>'1'
                ])->andWhere(['parent_id'=>null])->
                andWhere(['>','area',0])->all(); 
         
    }
      
      /* Deparatamenteos o unidades  ademas
     * son padres, o representan una cobranza,      * 
     */
    public function unidadesPadresArray(){
        $consulta=$this->queryUnidades()->andWhere(['not',['parent_id'=>null]])->asArray()->all();
       return  array_combine(array_column($consulta,'id'),array_column($consulta,'numero'));
    }
    
    public function area(){
        if($this->isNewRecord)
        return 0;
        //var_dump($this->queryUnidades()->sum('[[area]]'));die();
        return (double)$this->queryUnidadesImputables()->sum('[[area]]');
    }
    
    public function hasApoderados(){
      
      return SigiApoderados::find()->where(
              [
               'edificio_id'=>$this->id,
                
              ]
              )->exists();  
    }
    
    /*
     * Array de codigos de apoderados
     */
    public function apoderados(){      
      return
        array_column(SigiApoderados::find()->where(
              [
               'edificio_id'=>$this->id,                
              ]
              )->asArray()->all(),'codpro');  
      }
      
  
      
      
   public static function treeBase(){
       $datos=static::find()->asArray()->all();
        $array_tree=[];
       foreach($datos as $fila){
         $keyTree='edi_'.$fila['id'];
         $array_tree[]=[             
                       'icon'=>'fa fa-building',
                       'title' => $fila['nombre'],
                       'lazy' => true ,
                       // 'OTHER'=>'holis',
                          'key'=>$keyTree,
             'children' => [
                        ['title' => yii::t('base.names','Unidades'),'tooltip'=>'fill-unidades_'.$fila['id'],'key'=>$keyTree.'_unidades','lazy'=>true],
                        ['title' => yii::t('base.names','Documentos'),'tooltip'=>'fill-documentos_'.$fila['id'],'key'=>$keyTree.'_documentos','lazy'=>true],
                        ['title' => yii::t('base.names','Colectores'),'tooltip'=>'fill-grupos_'.$fila['id'],'key'=>$keyTree.'_grupos','lazy'=>true],                                    
                    ],
                        ];
       }
       return $array_tree;
     
   }
   
   
   
   /***********
    * funcione s para verificar que la facturacion ya esta corecta
    * y que le deific esta listo 
    * para facturacion
    */
   
   /*Verifica que no falñta ningun departamentoi imputale 
    * le falte propietario 
    */
   public function facUnitsWithoutOwner(){
       /*Los departamentos que tienen por lo menis un propietario*/
       $idsWithOwner=SigiPropietarios::find()->select('[[unidad_id]]')->
               Where(['[[edificio_id]]'=>$this->id])->
       andWhere(['[[tipo]]'=> SigiUnidades::TYP_PROPIETARIO])->asArray()->all();
        $idsWithOwner= array_column($idsWithOwner, 'unidad_id');
       /*Los departamentos totoales 
        * 
        */
       return array_column(SigiUnidades::find()->select(['numero'])->
               where(['not in','id',$idsWithOwner])->
               all(),'numero');
   }
   
   
   /*Verifica que no falñta ningun medidor 
    * En cad adepartamento
    */
   public function facUnitsWithoutPoint($type){
       /*Los departamentos que tienen por lo menis un medidor*/
       $faltan=[];
      $idsTipo= array_column(SigiSuministros::find()->select('[[tipo]]')->distinct()->
         Where(['[[edificio_id]]'=>$this->id])->asArray()->all(),'tipo'); 
      if(count($idsTipo)==0){
          return ['all'=>['all']];
      }
     foreach($idsTipo as $tipo){
          $idsDepas= array_column(SigiSuministros::find()->select('[[unidad_id]]')->
               where(['[[edificio_id]]'=>$this->id,
                     'tipo'=>$tipo,
                   ])->
               asArray()->all(),'unidad_id');
        $Noestan=array_column(SigiUnidades::find()->select(['numero'])->
               where(['not in','id',$idsDepas])->
               all(),'numero');
        if(count($Noestan)>0){
            $faltan[$tipo]=$Noestan;
        }
         
     }
     return $falta;
   }
     
  /*
   * Genera los dcoumentos mensuales de facturacion
   *  de manera autoamtica : POr ejemplo
   * lo que sle de partidas de presupsuesto , aquellas 
   * que son fijas y regulares 
   */
   
  public function generateDocsPorCobrar($mes){
      foreach($this->colectores as $colector){
          if($colector->isFijoRegular()){
              //SigiCuentaspor::
          }
      }
  } 
  
  /*Obtiene el emisor por dafulr en el edificio*/
  public function emisorDefault(){
     $apoderado= $this->getApoderados()->andWhere(['emisordefault'=>'1'])->one();
     if(is_null($apoderado)){
       throw new NotFoundHttpException(Yii::t('sigi.labels', 'El edificio no tiene apoderados emisores, por favor agregue uno por default'));  
     }else{
         return $apoderado;
     }
     
  }
  /* devuevle solo las unidades imputabels como
   * array de activerecords
   */
  public function unidadesImputables(){
      return $this->queryUnidadesImputables()->all();
  }

  
  
  
  public function verifyIsFacturable(){
     \Yii::beginProfile('correo_a usuarios');
      /*
       * Primero porlo enos debe de teer un apoderado con falñg junta directiva y con flag emisor por defecto
       */
      $score=0;
     if($this->hasApoderados()){
            if($this->getApoderados()->andWhere(['tienejunta'=>'1'])->count()>0){
        
                }else{
                        $this->addError('id',yii::t('sigi.labels','No tiene ningún grupo de gestión marcado con "{campo} "  ',['campo'=>$this->getAttributeLabel('tienejuta')]));
                    }
                if($this->getApoderados()->andWhere(['emisordefault'=>'1'])->count()>0){
                         $score+=3;
                        }else{
                       $this->addError('id',yii::t('sigi.labels','No tiene ningún grupo de gestión marcado con "{campo} "  ',['campo'=>$this->getAttributeLabel('emisordefault')]));
                  
                    }
     }else{
         $this->addError('id',yii::t('sigi.labels','No tiene ningún grupo de gestión'));
     }
     
    
     if($this->getCuentas()->count()>0){
         $score+=3;
     }else{
        $this->addError('id',yii::t('sigi.labels','No tiene ninguna cuenta registrada '));
                  
     }
     if($this->getCargos()->count()>0){
         $score+=3;
         foreach($this->cargos as $cargo){
             if($cargo->getColectores()->count()> 0){
               /* foreach($cargo->colectores as  $colector){
                  if($colector->isBudget() && !($colector->getBasePresupuesto()->count()>0)) {
                      if(!($colector->monto > 0))
                    $this->addError('id',yii::t('sigi.labels','El colector "{colector} " , no tiene partidas presupuestales asignadas  ',['colector'=>$colector->cargo->descargo]));  
                }*/
                 
             }else{
                 $this->addError('id',yii::t('sigi.labels','El grupo "{grupo} " , no tiene ningún colector  ',['grupo'=>$cargo->descripcion]));
                  
             }
         }
         
     }else{
          $this->addError('id',yii::t('sigi.labels','No tiene ningun grupo de cobranza registrado '));
     }
   
     /*Si los departamentos tienen propietarios asignado*/
     if(count($this->unidadesImputables()) >0 ){
         $contador=1;
         foreach($this->unidadesImputables() as $unidad){
             
             if(!is_null($unidad->currentPropietario())){
                  
             }else{
                 $contador++;
                 if($contador < 10 )
                 $this->addError('id',yii::t('sigi.labels','La unidad "{unidad} " , no tiene asignado ningún propietario activo',['unidad'=>$unidad->numero]));
             }
             
         }
     }else{
        $this->addError('id',yii::t('sigi.labels','No tiene ninguna unidad imputable para cobranza ')); 
     }
     /*Ahor veriifcar que los medidores ya estan cargados*/
     
      \Yii::endProfile('correo_a usuarios');
     
     
     
     
  }
  
   public function nMedidores($type=SigiSuministros::COD_TYPE_SUMINISTRO_DEFAULT){
       return $this->getSuministros()->where(['tipo'=>$type])->count();
   }
   public function idsMedidores($type){
      return array_column($this->getSuministros()->select('id')->where(['tipo'=>$type])->asArray()->all(),'id'); 
   }
   
   public function typeMedidores(){
      return array_column($this->getSuministros()->
              select('tipo')->distinct()->asArray()->
              all(),'tipo'); 
   }
   /*Medidores de areas comunes */
    public function medidoresAaCc(){
       $ids= $this->getUnidades()->select('id')
                ->where(['imputable'=>'0'])->column();
      return $this->getSuministros()->where(['unidad_id'=>$ids,'activo'=>'1'])->all();
             
   }
   /*nUMERO Medidores de areas comunes */
    public function nMedidoresAaCc(){
       $ids= $this->getUnidades()->select('id')
                ->where(['imputable'=>'0'])->column();
      return $this->getSuministros()->where(['unidad_id'=>$ids,'activo'=>'1'])->count();
             
   }
  
   
  public function suministrosByTypeQuery($tipo){
      return SigiSuministros::find()->where([
          'edificio_id'=>$this->id,
          'tipo'=>$tipo,
          ]);
  }
  
  public function queryPropietariosActivos(){
      return $this->getPropietarios()->where(['activo'=>'1']);
  }
  
  public function refreshPorcentaje(){
      $areaTotal=$this->area();
      $strExp="area/".$areaTotal;
      if($areaTotal >0 )
      SigiUnidades::updateAll(['participacion'=> new \yii\db\Expression($strExp)], ['edificio_id'=>$this->id,'imputable'=>'1']);
  }
  
  public function messageFacturacion(){
      $variables=['[[cuenta]]'=>$this->cuentaActiva()->numero,
          '[[dias]]'=>h::gsetting('sigi','numeroDiasVencimiento'),
          '[[propietario_cuenta]]'=>$this->cuentaActiva()->clipro->despro,
           '[[banco]]'=>$this->cuentaActiva()->banco->nombre,
           '[[moneda]]'=>$this->cuentaActiva()->moneda->desmon,
          '[[correo_cobranza]]-'=>h::gsetting('sigi','correoCobranza1')
          ];
      return str_replace(array_keys($variables), array_values($variables), $this->facturacion);
          
  }
 public function cuentaActiva(){
     return $this->getCuentas()->where(['activa'=>'1'])->one();
 } 
 
 public function generateUsers(){
     
     $unidades=$this->unitsForUsers();
     yii::error(count($unidades),__FUNCTION__);
     foreach($unidades as $unidad){
        YII::ERROR('***************** '.$unidad->nombre.' **********',__FUNCTION__);
         YII::ERROR($unidad->nombre,__FUNCTION__);
         YII::ERROR($unidad->hasUser(),__FUNCTION__);
        $currentProp=$unidad->currentPropietario();
      if(!is_null($currentProp)){
          YII::ERROR(' tiene propietario',__FUNCTION__);
          $correo=$currentProp->correo;
            YII::ERROR($correo,__FUNCTION__);
       if(!$unidad->hasUser()){
           YII::ERROR('no tiene usuario aun ',__FUNCTION__);
            yii::error($correo);
           if(!empty($correo)){
               yii::error('tiene correo ',__FUNCTION__);           
               $userHallado=\common\helpers\h::user()->identity->findByEmail($correo);
               if(is_null($userHallado)){
                   $usuario= new \frontend\modules\sigi\models\users\SignupForm();    
                $usuario->email=$correo;
                $usuario->username=$unidad->generateUsername();
                $usuario->password=$unidad->generatePwd();
                    try {          
                            $user= $usuario->signup();
                            if(is_object($user)){
                                    yii::error('funco el sgunp o ',__FUNCTION__);
                                    $user->refresh();
                                    $profile=$user->profile;
                                    $profile->tipo= \common\models\Profile::PRF_RESIDENTE;
                                    $profile->save(); 
                                SigiUserEdificios::insertUserEdificio($user->id, $this->id);
                                    $role=h::gsetting('sigi','roleResidente');
                                    $rol=\Yii::$app->authManager->getRole($role);
                                            /****LE ASIGNA EL ROL */
                                                if(!is_null($rol)){
                                                    $vari= Yii::$app->authManager->assign(
                                                        $rol,
                                                            $user->id);                   
                                                 }else{
                                            //yii::error('Rol nulo');
                                                    }
                                          }
                                                    } catch (\yii\db\IntegrityException $ex) {           
                                                        yii::error('NO funco el sgunp o '.$ex->getMessage(),__FUNCTION__);
                                                } 
      
                                            unset($usuario);
               }else{
                  yii::error('Ya existia un usuario con este correo ',__FUNCTION__);                             
                    SigiUserEdificios::insertUserEdificio($userHallado->id, $this->id);
                   
               } 
                
                    } 
        }else{//si ya tiene usuario
                yii::error('Ya tiene usuario ',__FUNCTION__); 
                if(!is_null($user=$unidad->obtenerUsuario())){              
                    SigiUserEdificios::insertUserEdificio($user->id, $this->id);
                } 
        }
       }else{
           
           
       }  
       //die();
    }    
 }
 /*
  * Esta funcion se encargs de 
  * crear partidas presupuesales 
  * segunlos colescores refistrados en el edificio
  * siempre que encuentrwe que tienen los montos > o
  * (MODO RECIBO DETALLADO) 
  */
 public function replicaPresupuesto(){
     foreach($this->colectores as $colector){
         if($colector->monto > 0){
             $colector->createPartidaPresupuesto();
         }
     }
     return true;
 }
 
 
 /*
  * Esta funcion devuelve el monto total de 
  * los grupos de colectores 
  */
 
 public function montoTotalColectores(){
    return round($this->getColectores()->sum('monto'),4);
 }
 
  public function afterSave($insert, $changedAttributes) {
     if($insert){
         $this->refresh(); 
        // yii::error('afer save');
         //yii::error(h::userId());
         //yii::error($this->id);
         SigiUserEdificios::insertUserEdificio(h::userId(),$this->id);
     }
     return parent::afterSave($insert, $changedAttributes);
 }
 
 
 public function idsUnidadesNoImputables(){
   return  $this->getUnidades()->select(['id'])->andWhere(['imputable'=>'0'])->column();
 }
 
 public function firstMedidorAACC(){
   return   $this->getSuministros()->andWhere(['unidad_id'=>$this->idsUnidadesNoImputables()])->one();
 }
 
 public function idsUnidadesPadresImputables(){
   return  $this->getUnidades()->select(['id'])
           ->andWhere(['imputable'=>'1',])
           ->andWhere(['parent_id'=>null])
           ->column();
 }
 
 
 
/*
 * Extrae las unidades que solo 
 * son candidatas a tener usuario
 * por ejemplo excluye aquellas que tienen 
 * como propietario a la inmobiliaria 
 * Solo unidades que presenten junta directiva 
 * propietario
 * y que nos ean hijas
 */
public function unitsForUsers(){
    /*Primero, los apoderados deben 
     * de ser tipo junta directiva
     * la inmobilaria aqui no importa
     */
   $apoderados= $this->getApoderados()->select('codpro')->
            andWhere(['tienejunta'=>'1'])->column();
   yii::error($this->getApoderados()->select('codpro')->
            andWhere(['tienejunta'=>'1'])->createCommand()->rawSql,__FUNCTION__);
   yii::error($this->queryUnidades()->andWhere([
             'imputable'=>'1',
             'codpro'=>$apoderados,
                ])->andWhere(['parent_id'=>null])->createCommand()->rawSql);
   return $this->queryUnidades()->andWhere([
             'imputable'=>'1',
             'codpro'=>$apoderados,
                ])->andWhere(['parent_id'=>null])->all(); 
         
    
}
 public function getEstadoscuentas(){
     return $this->hasMany(SigiEstadocuentas::className(), ['edificio_id' => 'id']);
    
 }
     
 public function isInPeriodo(\Carbon\Carbon $fecha){
     $fecha1='1969-12-31';    
    $primer= $this->getEstadoscuentas()
       ->andWhere(['estado'=> SigiEstadocuentas::ESTADO_CREADO])
      ->orderBy(['codigo'=>SORT_ASC])     
       ->one();
    
    if(!is_null($primer)){
        $borders=\common\helpers\timeHelper::bordersDay($primer->mes, $primer->anio);
        $fecha1=$borders[0] ;
        $carbon1=\Carbon\Carbon::createFromFormat(\common\helpers\timeHelper::formatMysqlDate(), $fecha1);
        if($fecha->greaterThanOrEqualTo($carbon1)){
                        
            }
    }else{
       return false ;
    }
    
 }
 
}
 
 
