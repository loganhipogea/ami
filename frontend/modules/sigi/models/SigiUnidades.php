<?php
namespace frontend\modules\sigi\models;
use frontend\modules\sigi\Module as SigiModule;
use frontend\modules\sigi\interfaces\colectoresInterface;
use common\models\masters\Clipro;
use common\helpers\h;
use Yii;

/**
 * This is the model class for table "{{%sigi_unidades}}".
 *
 * @property int $id
 * @property string $codtipo
 * @property int $npiso
 * @property int $edificio_id
 * @property string $numero
 * @property string $nombre
 * @property string $area
 * @property string $participacion
 * @property int $parent_id
 * @property string $detalles
 *
 * @property SigiPropietarios[] $sigiPropietarios
 * @property SigiSuministros[] $sigiSuministros
 * @property SigiTipounidad $codtipo0
 * @property SigiEdificios $edificio
 */
class SigiUnidades extends \common\models\base\modelBase
{
    const TYP_PROPIETARIO='P';
    const TYP_INQUILINO='I';
     //const TYP_EX_PROPIETARIO='E';
    //const TYP_EX_INQUILINO='X';
    const SCENARIO_HIJO='import_hijos';
    //const SCENARIO_EDIFICIO='edificio';
    //const SCENARIO_COMPLETO='import_completo';
    const SCENARIO_BASICO='basica';
    const SCENARIO_PARENT='parent';
    const SCENARIO_UPDATE_BASICO='update_basico';
    public $booleanFields=['esnuevo','imputable','resumirprop'];
    public $hardFields=['edificio_id','numero'];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sigi_unidades}}';
    }
    
    
    public function behaviors()
         {
                return [
		 'auditoriaBehavior' => [
			'class' => '\common\behaviors\AuditBehavior' ,
                               ],
                    ];
        }
    
    
    

    //public $codpadre='';//PARA HACER UN ARTIDFICIO EN LA IMPORTACION DE 
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codtipo', 'npiso','edificio_id', 'numero', 'nombre','codpro'], 'required'],
            [['npiso', 'edificio_id'], 'integer'],
            ['numero', 'validateChild'],
            [['area','imputable'], 'validateArea'],
             ['codpro', 'validateApoderado'],
            ['numero', 'unique', 'targetAttribute' => ['edificio_id','numero','codtipo']],
            [['area', 'participacion'], 'number'],
            [['area'], 'required'],
            ['resumirprop', 'safe'],
            //['imputable', 'validateArea'],
            /*['parent_id', 'validateParent',
                'except' => ['import_basica',self::SCENARIO_UPDATE_BASICO,self::SCENARIO_HIJO,self::SCENARIO_COMPLETO]
             ],*/
            ['id', 'required',
                'on' => [self::SCENARIO_UPDATE_BASICO]
             ],
            [['codpadre','area','imputable'], 'required',
                'on' => [self::SCENARIO_HIJO]
             ],
            
            
           // [['codpro'], 'validateApoderado'],
            [['detalles'], 'string'],
            [['codpro','esnuevo','codpadre','parent_id','imputable','estreno'], 'safe'],
           // [['estreno','imputable'], 'safe'],
            [['codtipo'], 'string', 'max' => 4],
            [['numero'], 'string', 'max' => 12],
            [['nombre'], 'string', 'max' => 25],
             /*[
                 ['parent_id'], 'resolveParent',
                'on'=>[self::SCENARIO_HIJO,self::SCENARIO_COMPLETO]
              ],*/
            [['codtipo'], 'exist', 'skipOnError' => true, 'targetClass' => SigiTipoUnidades::className(), 'targetAttribute' => ['codtipo' => 'codtipo']],
            [['edificio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Edificios::className(), 'targetAttribute' => ['edificio_id' => 'id']],
            [['codpro'], 'exist', 'skipOnError' => true, 'targetClass' => Clipro::className(), 'targetAttribute' => ['codpro' => 'codpro']],
        ];
    }

    
      public function scenarios()
    {
        $scenarios = parent::scenarios(); 
        $scenarios['basica'] = ['edificio_id','codtipo','imputable','npiso','numero','area','codpro'];
        $scenarios[self::SCENARIO_HIJO] = ['edificio_id','codpadre','codtipo','imputable','numero','area','npiso'];
        //$scenarios[self::SCENARIO_COMPLETO] = ['edificio_id','parent_id','codtipo','imputable','numero','area','codpro','npiso','nombre','detalles','estreno'];
        $scenarios[self::SCENARIO_UPDATE_BASICO] = ['id','imputable','codpro'];
           $scenarios[self::SCENARIO_PARENT] = ['parent_id'];
           
        return $scenarios;
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sigi.labels', 'ID'),
            'codtipo' => Yii::t('sigi.labels', 'Tipo'),
             'codpro' => Yii::t('sigi.labels', 'G Gestión'),
            'npiso' => Yii::t('sigi.labels', 'Piso'),
            'edificio_id' => Yii::t('sigi.labels', 'Edificio'),
            'numero' => Yii::t('sigi.labels', 'Numero'),
            'nombre' => Yii::t('sigi.labels', 'Nombre'),
            'area' => Yii::t('sigi.labels', 'Area (m2)'),
            'participacion' => Yii::t('sigi.labels', '% Part'),
            'parent_id' => Yii::t('sigi.labels', 'Padre'),
            'codpadre' => Yii::t('sigi.labels', 'Cod Padre'),
            'detalles' => Yii::t('sigi.labels', 'Detalles'),
            'imputable' => Yii::t('sigi.labels', 'Imputable'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSigiPropietarios()
    {
        return $this->hasMany(SigiPropietarios::className(), ['unidad_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSigiSuministros()
    {
        return $this->hasMany(SigiSuministros::className(), ['unidad_id' => 'id']);
    }

     public function getTransferencias()
    {
        return $this->hasMany(SigiTransferencias::className(), ['unidad_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipo()
    {
        return $this->hasOne(SigiTipoUnidades::className(), ['codtipo' => 'codtipo']);
    }

    
    
    
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdificio()
    {
        return $this->hasOne(Edificios::className(), ['id' => 'edificio_id']);
    }
    
     public function getChildsUnits()
    {
        return $this->hasMany(SigiUnidades::className(), ['parent_id' => 'id']);
    }
    
     public function getPadre()
    {
        return $this->hasOne(SigiUnidades::className(), ['id' => 'parent_id']);
    }
    
     public function getClipro()
    {
        return $this->hasOne(Clipro::className(), ['codpro' => 'codpro']);
    }
    
    
     public function getMovimientos()
    {
        return $this->hasMany(SigiMovimientosPre::className(), ['unidad_id' => 'id']);
    }
    
    
     public function getKardexes()
    {
        return $this->hasMany(SigiKardexdepa::className(), ['unidad_id' => 'id']);
    }
    /**
     * {@inheritdoc}
     * @return SigiUnidadesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SigiUnidadesQuery(get_called_class());
    }
    
    public function beforeSave($insert) {
        if($insert){
            //Solo si es child
           // $this->participacion=$this->participacionArea();
            $this->resolveChildBeforeSave();
            if(empty($this->nombre)){
              $this->nombre=substr(SigiTipoUnidades::findOne($this->codtipo)->desunidad.'-'.$this->numero,0,25); 
              
            }
                
        }
        return parent::beforeSave($insert);
    }
    public function afterSave($insert, $changedAttributes)  {
         if($insert){
           /*  $this->refresh();
            if($this->esnuevo){
                //$this->estreno=null;
               $this->insertPropietarioEmpresa() ;
            } */
           //refresca el porcentaje de participacion  
             $this->edificio->refreshPorcentaje();
          if($this->isChild()){
              $this->refresh();
              
              yii::error('la nueva identidad es ');
               yii::error($this->id);
              $this->copyPropietarios();
                 } 
        
        }
    return parent::afterSave($insert, $changedAttributes);
          }
          
          
          
          
    public function hasChildunits(){
        return($this->getChildsUnits()->count()> 0)?true:false;
    }
    
    
    /*
     * VCerifica si la unidad a isnertar es una unidad 
     * hija, verifica si los campos parent_id o codpadre son
     * consistentes para alcanzar esta condicion
     */
    public function  isChild(){
        return is_null($this->myPadre())?false:true;
    }
    
    public function myPadre(){
       if(($this->parent_id >0 )){
            return static::findOne($this->parent_id);  
        }elseif(!empty($this->codpadre)){
           return static::find()->where(['edificio_id'=>$this->edificio_id,'numero'=>$this->codpadre])->one();  
        }else{
           return null;       
        }
        return null; 
    }
    
    
    
    public function isEntregado(){
        return (empty($this->estreno))?false:true;
    }
    
   
    /*CALCULA LA PARTICIPACION */
    
    public function participacionArea($porcentaje=false){
      
         $areaTotal=$this->edificio->area();
         /*if(!$porcentaje){
              $areaTotal=$areaTotal*100;
         return $areaTotal;
         }
          */
         
        if($areaTotal>0){
            return round(($this->area*(($porcentaje)?100:1))/$areaTotal,8);
        }else{
           return 0; 
        }  
      
       
        
    }
    /*
     * Se estrena este departamento
     */
    public function estrenar($fecha,$apoderado){
        
    }
    
    public function validateApoderado($attribute, $params)
    {
      /*verificar que el edificio a asignar tiene apoderadoso*/
      //if($this->isNewRecord){
         $edificio=Edificios::find()->where(['id'=>$this->edificio_id])->one(); 
         //var_dump($edificio);die();
         if(is_null($edificio)){
              $this->addError ('edificio_id',yii::t('sigi.errors','El edificio no Existe'));
              return; 
         }
      //}
     /*Solo si no es hijo importa validar 
      * el codpro, si no lo es, se agregara de mnera automatica en
      * el before save, heredando este valor del padre
      */
      if(!$this->isChild()){
         if(empty($this->codpro)){
           $this->addError ('codpro',yii::t('sigi.errors','Debe de indicar el grupo de gestión este campo está vacío'));
            return;
         }
             
        $edificio=$this->edificio;
         if(!$edificio->hasApoderados())
        $this->addError ('edificio_id',yii::t('sigi.errors','El edificio no tiene Grupos de gestión'));
        if(!in_array($this->codpro,$edificio->apoderados()))
         $this->addError ('codpro',yii::t('sigi.errors','Esta empresa no esta registrado en el edificio'));
      }
       
      
      
        
    }
    
    
    public function resolveChildBeforeSave(){
        if($this->isChild()){
            $padre=$this->myPadre();
            if(empty($this->parent_id))
             $this->parent_id=$this->myPadre()->id; //rellenar el parent_id del padre 
            $this->codpro=$padre->codpro; //rellenar el codpro del padre 
            
        }
    }
    
    public function validateArea($attribute, $params)
    {
       // var_dump($this->area,$this->imputable);
        //die();
      /*verificar que cuando es imputable area debe ser obligatorio*/
        yii::error($this->imputable);
        if( is_null($this->area) && $this->imputable){
            $this->addError('area',yii::t('sigi.errors','Esta unidad es imputable y debe de tener participación'));
        }
      
    }
   /*
    * Si es hija, antes de insertarla sus npapas deben de etener propietarios 
    * si no no peritir ingresar 
    */ 
    public function validateChild($attribute, $params)
    {
      if($this->getScenario()==self::SCENARIO_HIJO){
          if(!$this->isChild()){
               $this->addError('parent_id',yii::t('sigi.errors','Esta unidad no tiene ninguna referencia a su padre, revise el campo {campo1} ó el campo {campo2} ',['campo1'=>$this->getAttributeLabel('parent_id'),'campo2'=>$this->getAttributeLabel('codpadre')]));
            return ;
          }
      }
        
      if($this->isChild() && is_null($this->myPadre()->currentPropietario())){
          $this->addError('numero',yii::t('sigi.errors','La unidad padre {numeropadre} aun no tiene propietarios',['numeropadre'=>$this->myPadre()->numero]));
      }
    }
    
   
   
  private function insertPropietarioEmpresa(){
      $atributos=[
         'unidad_id'=>$this->id,
           'edificio_id'=>$this->edificio_id,
          'tipo'=>self::TYP_PROPIETARIO,
          'activo'=>true,
          'nombre'=>Clipro::find()->where(['codpro'=>$this->codpro])->one()->despro,
          'dni'=>Clipro::find()->where(['codpro'=>$this->codpro])->one()->rucpro,
      ];
      SigiPropietarios::firstOrCreateStatic($atributos, SigiPropietarios::SCENARIO_EMPRESA);
  }  
   
  
  public static function treeBase($edificio_id){
       $datos=static::find()->where(['edificio_id'=>$edificio_id])->asArray()->all();
       foreach($datos as $fila){
         $keyTree='uni_'.$fila['id'];
         $array_tree['items'][]=[             
                       'icon'=>'fa fa-couch',
                       'title' => $fila['nombre'],
                       'lazy' => true ,
                       // 'OTHER'=>'holis',
                          'key'=>$keyTree,
             'children' => [
                        ['title' => yii::t('base.names','Unidades'),'tooltip'=>'fill-unidades_'.$fila['id'],'key'=>$keyTree.'_unidades'],
                        ['title' => yii::t('base.names','Documentos'),'tooltip'=>'fill-documentos_'.$fila['id'],'key'=>$keyTree.'_documentos'],
                        ['title' => yii::t('base.names','Colectores'),'tooltip'=>'fill-grupos_'.$fila['id'],'key'=>$keyTree.'_grupos'],                       
                    ],
                        ];
       }
     
   }
  

   
   
   public function CalculoColector(colectoresInterface $colector){
      return $colector->factorProRateo()->montoTotal()->insertCosto();
   }

   public function porcParticipacion(colectoresInterface $colector,$mes,$anio){
       if($colector->isMedidor()){
          $medidor=$this->firstMedidor($colector->tipomedidor);
          $participacionInterna=$this->porcInterno();
          
          /*Si no encuentra un medidor en el departamento
           * Simpelnenre devuleve e porcentaje de participacion 
           * del area 
           */
          if(!is_null($medidor)){
              /* yii::error($this->numero.' Es Padre y tiene medidor  ');
               yii::error($this->numero.' Participacion Interna  ');
                yii::error($participacionInterna);
                  yii::error('Lectura ultima de '.$this->numero.' ');
                    yii::error($medidor->LastReadFacturable($mes,$anio));
                     yii::error('Lectura total de  '.$this->numero.' ');
                     $lecturatotal=$medidor->consumoTotal($mes,$anio);
                     yii::error($lecturatotal);*/
                    $parti=$medidor->participacionRead($mes,$anio);
             $valor=($parti>0)?$parti:$this->participacionArea();
              //yii::error('Retornando en padre   '.$valor);
             return  $valor*$participacionInterna;
          }else{
              //Puede ser que el padre lo tenga
             if($this->isChild()){
                 /* yii::error($this->numero.' Es hijo  ');
                   yii::error($this->numero.' Participacion Interna  ');
                yii::error($participacionInterna);*/
                 IF(!is_null($medidor=$this->padre->firstMedidor($colector->tipomedidor))){
                    //$lecturatotal=$medidor->consumoTotal($mes,$anio);
                   /* yii::error('Lectura ultima del medidor del padre '.$this->numero.' ');
                    yii::error($medidor->LastReadFacturable($mes,$anio));
                     yii::error('Lectura total del medidor del padre '.$this->numero.' ');
                     yii::error($lecturatotal);*/
                     //$valor=($lecturatotal>0)?round($medidor->LastReadFacturable($mes,$anio)/$lecturatotal,3):$this->participacionArea();  
                     //yii::error('Retornando en hijo '.$valor);
                     $parti=$medidor->participacionRead($mes,$anio);
                    $valor=($parti>0)?$parti:$this->participacionArea();
                         //yii::error('Retornando en padre   '.$valor);
                        return  $valor*$participacionInterna;
                 }else{
                   return $this->participacionArea();    
                 }
             }ELSE{
                return $this->participacionArea();    
             }
            
          }
          
          
          
       }elseif($colector->individual){
           return 1;
       }else{
           return $this->participacionArea(); 
       }

   }
   
   
  
   
   
   public function firstMedidor($type){
       return $this->getSigiSuministros()->andWhere(['tipo'=>$type,'activo'=>'1'])->one();
   }  
   
   public function propietarioRecibo(){
     if($this->imputable){
             $modelo= SigiPropietarios::find()->where(
               ['unidad_id'=>$this->id]
               )->andWhere(
               ['activo'=>'1','recibo'=>'1']
               )->one();
                if(!is_null($modelo)){
                    return $modelo;
                }else{
                    return $this->currentPropietario(); 
                } 
     }else{
        return  self::find()->andWhere([
             'edificio_id'=>$this->edificio_id,
             'imputable'=>'1',
             'codpro'=>$this->codpro,
             
             ])->one()->currentPropietario(); 
     }
       
   }
   
   public function currentPropietario(){
      return SigiPropietarios::find()->where(
               ['unidad_id'=>$this->id]
               )->andWhere(
               ['tipo'=>self::TYP_PROPIETARIO]
               )->andWhere(
               ['activo'=>'1']
               )->one();
   }
   
 public function miApoderado(){
     return SigiApoderados::find()->where(['codpro'=>$this->codpro,'edificio_id'=>$this->edificio_id])->one();
 }
 
 public function parentNumero(){
     if($this->isChild()){
        return $this->myPadre()->numero;
     }else{
         return '';
     }
 }
 
 public function copyPropietarios(){
   if($this->isChild()){
     foreach($this->myPadre()->sigiPropietarios as $propietario){
         yii::error('copyporpeitarios');
          yii::error($this->id);
       $this->insertPropietario($propietario); 
    }   
   }
    
 }
 
 public function insertPropietario($propietario){
     yii::error('inserpropietariuos');
          yii::error($this->id);
     $model=new SigiPropietarios();
     $model->attributes=$propietario->attributes;
     $model->unidad_id=$this->id;
     if($model->save()){
        yii::error('GRABO '.$this->id);    
     }ELSE{
      yii::error($model->getFirstError());   
     }
         
 }
 /*
  * Funcion que permite calcular le porcentaje de particiapcion interno
  * para cada unidad, agrupada según  la unidad padre
  * por EJEMPLO
  *       Depa  205 =>  80 m2
  *       Cochera del 205 => 10m2
  *       Deposito del 205  => 5 m2
  * Porcentaje interno del Depa= (80)/(80+10+5)=
  * Porcentaje interno del Deposito= (5)/(80+10+5)=
  * Porcentaje interno de la cochera= (10)/(80+10+5)=
  */
 public function porcInterno(){
     if($this->isChild()){//Es un hijo
         //Calculando el área de los hijos
         $Schilds=self::find()->select('sum(area)')->where(['parent_id'=>$this->parent_id])->scalar();
         $Sparent=$this->padre->area;
         $St=$Sparent+$Schilds;
         
         return round($this->area/$St,6);
     }elseif($this->hasChildunits()){ //Es un padre
         yii::error('tiene hijitos ');
         $Schilds=self::find()->select('sum(area)')->where(['parent_id'=>$this->id])->scalar();
          $Smio=$this->area;
          $St=$Smio+$Schilds;
          return round($Smio/$St,8);
     }else{//Es un departamento solo
         yii::error('el departametno esta solo');
         return 1;
     }
 }
 
 
 public function arrayParticipaciones(){
     $areatotal=$this->edificio->area();     
     $areasHijos=$this->find()->select(['nombre','numero','area','participacion'])->where(['parent_id'=>$this->id])->asArray()->all();
     
     if(count($areasHijos)>0){
         $datosAreas=$areasHijos;
         array_unshift($datosAreas,['nombre'=>$this->nombre,'numero'=>$this->numero,'area'=>$this->area+0,'participacion'=>$this->participacion+0]);
         
          
     }else{
         $datosAreas=[['nombre'=>$this->nombre,'numero'=>$this->numero,'area'=>$this->area+0,'participacion'=>$this->participacion+0]];
     }
     //var_dump($datosAreas);die(); 
     return ['aareas'=>$datosAreas,'atotal'=>$areatotal];
    
 }
 
 public function arrayPropietarios($nuevo=false){    
    if($nuevo){
      
     $arrayProp=$this->getSigiPropietarios()->select(['tipo','nombre','dni'])->where(['activo'=>'1'])->asArray()->all();
      
    }ELSE{
        
      $arrayProp=[];
    
     $propAntiguo=$this->getSigiPropietarios()->select(['tipo','nombre','dni'])->where(['activo'=>'0','tipo'=>self::TYP_PROPIETARIO])->
             orderBy('id desc')->limit(1)->asArray()->all();
    
     if(count($propAntiguo)==0)
      $propAntiguo=$this->getSigiPropietarios()->select(['tipo','nombre','dni'])->where(['activo'=>'1'])->limit(1)->asArray()->all();   
     $inquilinos=$this->getSigiPropietarios()->select(['tipo','nombre','dni'])->where(['activo'=>'1','tipo'=>self::TYP_INQUILINO])->asArray()->all();
     $arrayProp= array_merge($propAntiguo,$inquilinos);
      
    }
     
    
     return $arrayProp;
 }
 
 
 public function porcWithChilds($porcentaje=false){
     $areaEdificio=$this->edificio->area();
        if($areaEdificio>0){
            return round(($this->areaTotal()*(($porcentaje)?100:1))/$areaEdificio,12);
        }else{
           return 0; 
        }  
 }
 
 public function areaTotal(){
    return $this->area+$this->find()->select('sum(area)')->where(['edificio_id'=>$this->edificio_id,'parent_id'=>$this->id])->scalar();
 }
 
 public function mailsPropietarios(){
     $correos=$this->getSigiPropietarios()->select(['correo'])->
      where(['recibemail'=>'1'])->column();
     foreach($this->getSigiPropietarios()->all() as $fila){
         $correos[]=$fila->correo;
         //var_dump($fila->correo);
         $correos=array_merge($correos,$fila->correos());
     }
    return array_unique($correos);
    
 }
 
 /*Devuel mve le residente inmediato anteiror*
  *Si no encuentra ninguno devuelve el actual no mas 
  */
 public function oldPropietario($tipoResidente){
     $propietarioAnterior=$this->getSigiPropietarios()->where([
         'tipo'=>$tipoResidente,
         'activo'=>'0',
       ])->orderBy('id desc')->one();
     if(is_null($propietarioAnterior)){
       $propietarioAnterior=$this->currentPropietario();
     }
     return $propietarioAnterior;
 }
 
 
public function lastTransferencia(){
  return  $this->getTransferencias()->orderBy('id desc')->limit(1)->one();
}

public function hasUser(){
 $hallo=$this->obtenerUsuario();
 //yii::error($hallo,__FUNCTION__);
  return is_null($hallo)?false:true;
 
}

public function obtenerUsuario(){
    return \common\helpers\h::user()->identity->findByUsername($this->generateUsername());
}

public function generateUsername(){
   return  $this->edificio->codigo.'.'.$this->numero;
}
public  function generatePwd(){
   return TRIM($this->numero);
   //return random_int(1000, 9999).'';
}

public function hasFacturacion($mes,$annio){
  yii::error(SigiDetfacturacion::find()->where([
       'unidad_id'=>$this->id,
       'mes'=>$mes,
       'anio'=>$annio
           ])->createCommand()->rawSql,__FUNCTION__); 
   return  SigiDetfacturacion::find()->where([
       'unidad_id'=>$this->id,
       'mes'=>$mes,
       'anio'=>$annio
           ])->exists();
}


public function desacopla(){
    if($this->parent_id>0){
        $this->parent_id=null;
       return $this->save();
    }
}
/*
 * Observe que las deudas se sacan con 
 * el criterio de los 5 soles 
 * este valor se almacena en la tabla sstings
 * 
 */
public function misDeudasProvider(){
  // echo  $unidad=$this->id;die();
   /*echo  VwKardexPagos::find()->andWhere([
               'unidad_id'=>$this->id,
                ])->andWhere(['>',
                       'deuda',
                        h::gsetting('sigi','montominimo_deudor')
                ])->createCommand()->rawSql;die();*/
    return New \yii\data\ActiveDataProvider(
            [
         'query'=>VwKardexPagos::find()->andWhere([
               'unidad_id'=>$this->id,
                ])->andWhere(['>',
                       'deuda',
                        h::gsetting('sigi','montominimo_deudor')
                ])->andWhere(['aprobado'=>'1'])
           ]
          );
  }
  
public function idUser(){
   $usuario= \common\models\User::find()->andWhere([
        'username'=>$this->generateUsername()]
            )->one();
   if(is_null($usuario)){
       return null;
   }else{
       return $usuario->id;
   }
    
}
/*
 * Se fija si tiene mas de un propietario
 */
public function hasManyPropietarios(){
  return ($this->getSigiPropietarios()->andWhere(['activo'=>'1','tipo'=>self::TYP_PROPIETARIO])->count() > 1);
}


public function deuda(){
    $deuda=$this->getKardexes()->select(['sum(monto)'])->
            andWhere(['aprobado'=>'1'])->scalar();
    $deuda=($deuda>0)?$deuda:0; 
    return $deuda-$pagado;
}

private function pagado(){
 $val=$this->getMovimientos()->select(['sum(monto)'])->andWhere(['activo'=>'1'])->scalar();  
 return($val>0)?$val:0; 
}



}
