<?php
/*
 * Esta clase extiende la clase original
 * pero adicionalmetne devuelve los data
 * para los combos  
 * FACULTADES
 * CARRERAS
 * CARRERAS POR FACULTAD
 */
namespace frontend\modules\sigi\helpers;
use common\helpers\ComboHelper as Combito;
use frontend\modules\sigi\models\SigiUserEdificios;
use frontend\modules\sigi\models\SigiSuministros;
use frontend\modules\sigi\models\SigiUnidades;
use yii\helpers\ArrayHelper;
use common\helpers\h;
use yii;
class comboHelper extends Combito
{
     public static function getCboEdificios(){
         //$idsEdificios= ;
        return ArrayHelper::map(
                        \frontend\modules\sigi\models\Edificios::find()->
                         andWhere(['id'=>SigiUserEdificios::filterEdificios()])->all(),
                'id','nombre');
        
    }
    
    public static function getCboTipoUnidades(){
        return ArrayHelper::map(
        \frontend\modules\sigi\models\SigiTipoUnidades::find()->all(),
                'codtipo','desunidad');
    }
    
      public static function getCboCargos(){
        return ArrayHelper::map(
        \frontend\modules\sigi\models\SigiCargos::find()->all(),
                'id','descargo');
    }
    
    public static function getCboGrPresup(){
        return ArrayHelper::map(
        \frontend\modules\sigi\models\SigiGrupoPresupuesto::find()->all(),
                'codigo','descripcion');
    }
    
    /*
     * Devuel combno apoderados  por edificio
     */
    public static function getCboApoderados($id_edificio){
        $apode= \frontend\modules\sigi\models\SigiApoderados::find()
                 ->select(['codpro'])
                 ->where(['edificio_id'=>$id_edificio])->asArray()->all();
 $codigos=ArrayHelper::getColumn($apode, 'codpro');
        return ArrayHelper::map(
                \common\models\masters\Clipro::find()->
                where(['in',
              'codpro', $codigos
               ])->all(),
                'codpro','despro');
        
    }
    
     public static function getCboSameUnits($id_edificio,$id=null){
      if($id===null){
          return ArrayHelper::map(
                          \frontend\modules\sigi\models\SigiUnidades::find()
                  ->where(['edificio_id'=>$id_edificio])->all(),
                'id','numero'); 
      }else{
          return ArrayHelper::map(
                          \frontend\modules\sigi\models\SigiUnidades::find()
                  ->where(['edificio_id'=>$id_edificio])
                  //->andWhere(['imputable'=>'1'])
                  ->andWhere(['not', 'id=1'])->all(),
                'id','numero'); 
      }
       
    }
    
    public static function getCboPisos($init=-3,$top=50){
        $pisos=[];
        for ($x = $init; $x <= $top; $x++) {
              if($x<0){
                  $prefijo=yii::t('sigi.labels','SÓTANO');
              }else{
                  $prefijo=yii::t('sigi.labels','PISO'); 
              }
             $pisos[$x]=$prefijo.' '.abs($x);
            }
           $pisos[0]=yii::t('sigi.labels','AZOTEA');
        return $pisos;
    }
    
   public static function getCboGrupos($id_edificio){
        $apode= \frontend\modules\sigi\models\SigiCargosgrupoedificio::find()
                ->where(['edificio_id'=>$id_edificio])
                ->all();
 
        return ArrayHelper::map($apode,
                'codgrupo','descripcion');
        
    }  
    
    public static function getCboTipoResidente(){
        return [
            \frontend\modules\sigi\models\SigiUnidades::TYP_PROPIETARIO=>yii::t('sigi.labels','PROPIETARIO') ,
            \frontend\modules\sigi\models\SigiUnidades::TYP_INQUILINO=>yii::t('sigi.labels','INQULINO') ,
            // \frontend\modules\sigi\models\SigiUnidades::TYP_EX_PROPIETARIO=>yii::t('sigi.labels','ANTERIOR-PROPIETARIO') ,
            // \frontend\modules\sigi\models\SigiUnidades::TYP_EX_INQUILINO=>yii::t('sigi.labels','ANTERIOR-INQUILINO') ,
            ];
    } 
    
    /*
     * Devueklve las juntas de ropietarios del un edificio, solo
     * las juntas directivas 
     */
      public static function getCboJuntas($idedificio){
         $apode= \frontend\modules\sigi\models\SigiApoderados::find()
                 ->select(['codpro'])
                 ->where(['edificio_id'=>$idedificio,'tienejunta'=>'1'])->asArray()->all();
         
 $codigos=ArrayHelper::getColumn($apode, 'codpro');
         //VAR_DUMP($apode,$idedificio,$codigos);DIE();
        return ArrayHelper::map(
                \common\models\masters\Clipro::find()->
                where(['in',
              'codpro', $codigos
               ])->all(),
                'codpro','despro');
    }
    
    /*
     * Saca los colectores de emision individual
     * solo los indinviduales
     * POR EJEMPLO MULTAS, LAVANDERIA, RESERVAS 
     */
    public static  function getCboColectorNoMasivo($idedificio){
         $colec= \frontend\modules\sigi\models\VwSigiColectores::find()
                 ->select(['idcolector','descargo'])
                 ->where(['edificio_id'=>$idedificio,'individual'=>'1'])->asArray()->all();
         return ArrayHelper::map($colec,'idcolector','descargo'); 
    }
    
    /*
     * Saca los colectores de emision masiva
     * solo los imasivas Y ADEMAS  NO presuspuestos 
     * 
     * YA NO MULTAS SOLO RECOBOS DE AGUA, CUOTAS EXTRAPORDINARIAS ETC 
     * 
     */
    public static function getCboColectorMasivo($idedificio){
         $colec= \frontend\modules\sigi\models\VwSigiColectores::find()
                 ->select(['idcolector','descargo'])
                 ->where(['edificio_id'=>$idedificio])
                 ->andWhere(['=','montofijo','0'])
                // ->andWhere(['<>','regular','1'])
                  ->andWhere(['=','individual','0'])
                 ->asArray()->all();
         
         /*echo  \frontend\modules\sigi\models\VwSigiColectores::find()
                 ->select(['idcolector','descargo'])
                 ->where(['edificio_id'=>$idedificio])
                 ->andWhere(['=','montofijo','0'])
                // ->andWhere(['<>','regular','1'])
                  ->andWhere(['=','individual','0'])->createCommand()->getRawSql();DIE();
         */
                  return ArrayHelper::map($colec,'idcolector','descargo'); 
    }
    
    
    
     public static function getCboColectores($idedificio){
         $colec= \frontend\modules\sigi\models\VwSigiColectores::find()
                 ->select(['idcolector','descargo'])
                 ->where(['edificio_id'=>$idedificio,/*'individual'=>'1'*/])->asArray()->all();
         return ArrayHelper::map($colec,'idcolector','descargo'); 
    }
    
      public static function getCboUnitsByEdificio($id_edificio){
     
          return ArrayHelper::map(
                          \frontend\modules\sigi\models\SigiUnidades::find()
                  ->where(['edificio_id'=>$id_edificio])
                   ->andWhere(['imputable'=>'1'])->
                  all(),
                'id','numero'); 
     
    }
    
    
    public static function getCboUnitsNotImputables($id_edificio){
     /*ECHO  \frontend\modules\sigi\models\SigiUnidades::find()
                  ->andWhere(['edificio_id'=>$id_edificio])
                  ->andWhere(                            
                              ['or',"imputable='0'",'area=0']                          
                          )->createCommand()->rawSql;                  
              DIE();  */  
          return ArrayHelper::map(
                          \frontend\modules\sigi\models\SigiUnidades::find()
                  ->andWhere(['edificio_id'=>$id_edificio])
                  ->andWhere(                            
                              ['or',"imputable='0'",'area=0']                          
                          )->all(),
                'id','numero'); 
      
       
    }
    
   public static function getCboReportes(){
     
          return ArrayHelper::map(
                          \frontend\modules\report\models\Reporte::find()
                 /* ->where(['edificio_id'=>$id_edificio])
                  ->andWhere(['not',['imputable'=>'1']])*/->all(),
                'id','nombrereporte'); 
      
       
    }
    
    public static function getCboUnitsByTipoMedidor($edificio_id,$codtipo){
     $idsUnidadesWithMedidor= \frontend\modules\sigi\models\SigiSuministros::find()-> 
             select(['unidad_id'])->andWhere(['edificio_id'=>$edificio_id,'tipo'=>$codtipo])->column();
        //var_dump( $idsUnidadesWithMedidor,\frontend\modules\sigi\models\SigiSuministros::find()-> 
             //select(['unidad_id'])->andWhere(['edificio_id'=>$edificio_id,'tipo'=>$codtipo])->createCommand()->getRawSql()); die();     
          return ArrayHelper::map(
                          \frontend\modules\sigi\models\SigiUnidades::find()
                  ->andWhere(['id'=>$idsUnidadesWithMedidor])->all(),
                'id','numero');
    }
    
    public static function getCboCodPresupuestos($edificio_id){
         return ArrayHelper::map(
                         \frontend\modules\sigi\models\SigiBasePresupuesto::find()
                  ->andWhere(['edificio_id'=>$edificio_id])->all(),
                'codigo','descripcion');
    }
    
    public static function getCboUnitsNotChilds($id_edificio){
     
        $idsChilds= \frontend\modules\sigi\models\SigiUnidades::find()->
                select(['id'])->andWhere(['edificio_id'=>$id_edificio])->andWhere(['>','parent_id',0])->column();
        //VAR_DUMP($idsChilds);DIE();
        /*ECHO  \frontend\modules\sigi\models\SigiUnidades::find()
                  ->where(['edificio_id'=>$id_edificio])
                  ->andWhere(['not in','id',$idsChilds])->createCommand()->rawSql;
        die();*/
          return ArrayHelper::map(
                          \frontend\modules\sigi\models\SigiUnidades::find()
                  ->where(['edificio_id'=>$id_edificio])
                  ->andWhere(['not in','id',$idsChilds])->all(),
                'id','numero'); 
      
       
    }
    
     public static function getCboUnitsFacturadas($id_facturacion){     
        $idsFacturados= \frontend\modules\sigi\models\SigiKardexdepa::find()->
                select(['unidad_id'])->distinct()-> 
                andWhere(['facturacion_id'=>$id_facturacion])->column();
          return ArrayHelper::map(
                          \frontend\modules\sigi\models\SigiUnidades::find()
                  ->where(['id'=>$idsFacturados])->all(),
                'id','numero'); 
    }
    
    
   public static function getCboCuentasByEdificio($edificio_id){     
       /* $idsFacturados= \frontend\modules\sigi\models\SigiKardexdepa::find()->
                select(['id','nombre'])->distinct()-> 
                andWhere(['edificio_id'=>$edificio_id])->column();
         */ return ArrayHelper::map(
                          \frontend\modules\sigi\models\SigiCuentas::find()
                  ->where(['edificio_id'=>$edificio_id])->all(),
                'id','nombre'); 
    } 
    
     public static function getCboKardexByEdificio($edificio_id){     
       /* $idsFacturados= \frontend\modules\sigi\models\SigiKardexdepa::find()->
                select(['id','nombre'])->distinct()-> 
                andWhere(['edificio_id'=>$edificio_id])->column();
         */ return ArrayHelper::map(
                          \frontend\modules\sigi\models\SigiCuentas::find()
                  ->where(['edificio_id'=>$edificio_id])->all(),
                'id','nombre'); 
    } 
    
    
     public static function getCboKardexPagados($edificio_id){
         $formateador=h::formato();
        $datos= \frontend\modules\sigi\models\VwSigiKardexPagos::find()
                 ->andWhere(['edificio_id'=>$edificio_id])->
                 orderBy([
                     'anio'=>SORT_ASC,
                     'mes'=>SORT_ASC,
                     'monto'=>SORT_ASC,
                     'numero'=>SORT_ASC
                     ])->
                asArray()->all();
         $combo=[];
         $combo['']=str_pad('Deuda recibo', 20, "_", STR_PAD_LEFT).
                 str_pad('Monto recibo', 20, "_", STR_PAD_LEFT).
                   '  -  '.str_pad('Monto cancelado', 20, "_", STR_PAD_LEFT).
                  '  -  '.str_pad("UNIDAD",12, "_", STR_PAD_LEFT).
                   '  -  '."AÑO".'-'.
                   str_pad("MES",3, "_", STR_PAD_LEFT);
         foreach($datos as $fila){
             $combo[$fila['id']]=str_pad( $formateador->asDecimal(trim($fila['deuda'])+0,2), 20, "_", STR_PAD_LEFT).
                     str_pad( $formateador->asDecimal(trim($fila['monto'])+0,2), 20, "_", STR_PAD_LEFT).
                   '  -  '.str_pad($formateador->asDecimal(trim($fila['pagado'])+0,2), 20, "_", STR_PAD_LEFT).
                   '  -  '.'[['.str_pad(trim($fila['numero']),12, "_", STR_PAD_LEFT).']]'.
                   '  -  '.$fila['anio'].'-'.
                   str_pad($fila['mes'],3, "_", STR_PAD_LEFT);
         }
         //array_combine(array_column($combo,'id'),array_column($combo,'id'));
       /* $idsFacturados= \frontend\modules\sigi\models\SigiKardexdepa::find()->
                select(['id','nombre'])->distinct()-> 
                andWhere(['edificio_id'=>$edificio_id])->column();
         */ return $combo; 
    }
    
  public static function getCboTipoMov($edificio_id=null){
  if(is_null($edificio_id))
  return ArrayHelper::map(
                  \frontend\modules\sigi\models\SigiTipomov::find()
                  ->all(),
                'codigo','descripcion');
  return ArrayHelper::map(
                  \frontend\modules\sigi\models\SigiTipomov::find()
                  ->andWhere(['edificio_id'=>$edificio_id])->all(),
                'codigo','descripcion');
    }  
  
   public static function getCboPropietarios($unidad_id){
  return ArrayHelper::map(
                  \frontend\modules\sigi\models\SigiPropietarios::find()
                  ->andWhere(['unidad_id'=>$unidad_id,'activo'=>'1'])->all(),
                'id','nombre');
    }  
    
    
     public static function IdsMedidoresByEdificio($edificio_id,$tipo=SigiSuministros::COD_TYPE_SUMINISTRO_DEFAULT,$exceptions=[]){
     $idsSuministros= 
             \frontend\modules\sigi\models\SigiSuministros::find()-> 
             select(['id'])->andWhere([
                                        'edificio_id'=>$edificio_id,
                                        'tipo'=>$tipo
                                                    ])->column();
        
         return ArrayHelper::map(
                          \frontend\modules\sigi\models\SigiSuministros::find()
                  ->andWhere(['id'=>array_diff($idsSuministros, $exceptions)])->all(),
                'id','codsuministro');
    }
    
    public static function getCboDocsPagados($edificio_id,$ingreso){
         $formateador=h::formato();
         $datos=(new \yii\db\Query())->from('{{%sigi_vw_porpagar}}')
       // $datos= \frontend\modules\sigi\models\SigiV  VwSigiKardexPagos::find()
                 ->andWhere(['edificio_id'=>$edificio_id])->
                 andWhere(['ingreso'=>$ingreso])->
                 orderBy([                     
                     'fechadoc'=>SORT_ASC
                     ])->all();
       
         $combo=[];
         $combo['']=str_pad('Monto pendiente', 12, "_", STR_PAD_LEFT).
                 str_pad('Monto documento', 12, "_", STR_PAD_LEFT).
                '  -  '.str_pad('Monto conciliado', 12, "_", STR_PAD_LEFT).
                  '  -  '.str_pad("DOCUMENTO",20, "_", STR_PAD_LEFT).
                  '  -  '.str_pad("FECHA",10, "_", STR_PAD_LEFT).
                 '  -  '.str_pad("NUMERO",12, "_", STR_PAD_RIGHT).
                 '  -  '.str_pad("DESCRIPCION",20, "_", STR_PAD_LEFT).
                 '  -  '.str_pad("IMPUTADO",20, "_", STR_PAD_LEFT);
         foreach($datos as $fila){
             if(!empty($fila['codpro'])){
                 $imputado=$fila['despro'];
             }else{
                $imputado=$fila['nombre']; 
             }
             $combo[$fila['id']]=
                   str_pad( $formateador->asDecimal(trim($fila['deuda'])+0,2), 12, "_", STR_PAD_LEFT).
                   str_pad( $formateador->asDecimal(trim($fila['monto'])+0,2), 12, "_", STR_PAD_LEFT).
                   '  -  '.str_pad($formateador->asDecimal(trim($fila['pagado'])+0,2), 12, "_", STR_PAD_LEFT).
                   '  -  '.str_pad(trim($fila['desdocu']),20, "_", STR_PAD_RIGHT).
                   '  -  '.$fila['fecha'].'-'.
                   str_pad($fila['numdocu'],12, "_", STR_PAD_RIGHT).
                   str_pad($fila['glosa'],20, "_", STR_PAD_LEFT).
                    str_pad($imputado,20, "_", STR_PAD_LEFT)
                     ;
         }
         //array_combine(array_column($combo,'id'),array_column($combo,'id'));
       /* $idsFacturados= \frontend\modules\sigi\models\SigiKardexdepa::find()->
                select(['id','nombre'])->distinct()-> 
                andWhere(['edificio_id'=>$edificio_id])->column();
         */ return $combo; 
    }
    
  public static function getCboGruposBene($id_edificio){
        $apode= \frontend\modules\sigi\models\SigiBenegrupoedificio::find()
                ->where(['edificio_id'=>$id_edificio])
                ->all();
 
        return ArrayHelper::map($apode,
                'codgrupo','descripcion');
        
    }   
  
   public static function getCboUnidadesPosiblesHijas($unidad_id_padre){
        $model=Sigiunidades::findOne($unidad_id_padre);
        $idsUnidadesConHijos=Sigiunidades::find()->
                select(['parent_id'])->andWhere([
                  'edificio_id'=>$model->edificio_id,                   
                ])
                ->andWhere([
                  '>','parent_id',0                 
                ])->
                column();
        $idsUnidadesAfiliadas=Sigiunidades::find()->
                select(['id'])->andWhere([
                  'edificio_id'=>$model->edificio_id,                   
                ])
                ->andWhere([
                  '>','parent_id',0                 
                ])->
                column();
        $filtro=array_unique(array_merge($idsUnidadesConHijos, $idsUnidadesAfiliadas));
       $apode= SigiUnidades::find()
                ->andWhere(['edificio_id'=>$model->edificio_id])
                ->andWhere(['not in','id',$filtro])
                ->all();
 
        return ArrayHelper::map($apode,
                'id','nombre'); 
    }   
    
}


