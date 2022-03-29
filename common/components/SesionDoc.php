<?php


namespace common\components;


use common\helpers\h;

class SesionDoc extends \yii\base\Component
{
  private $_sesion=null;
  const NOMBRE_SESION='documentos2365844';
  public function init(){
     if($this->sesion->has(self::NOMBRE_SESION)){
           
        } else{
           $this->sesion[self::NOMBRE_SESION]=[];
        }
  }
  
  public function getSesion(){
      if(is_null($this->_sesion))
         return h::session ();
      return $this->_sesion;
  }
  
  private function resolveParam($claseModel){
      if($claseModel instanceof \yii\db\ActiveRecord){
         return  $claseModel::className();
      }else{
          return $claseModel;
      }
  }
  
  
  public function inserta($claseModel,$id){
     $claseModel= $this->resolveParam($claseModel);
     //var_dump($claseModel);die();
      $array=$this->sesion[self::NOMBRE_SESION];
      if(!in_array($id, array_values($array[$claseModel])))
      $array[$claseModel][]=$id;
      $this->sesion[self::NOMBRE_SESION]=$array;    
      
   }
  
   public function elimina($claseModel,$id){
       $claseModel= $this->resolveParam($claseModel);
      $array=$this->sesion[self::NOMBRE_SESION];
       $invertido=array_flip($array[$claseModel]);
       unset($invertido[$id]);
       $valores=array_values(array_flip($invertido));
      $array[$claseModel]=$valores;      
      $this->sesion[self::NOMBRE_SESION]=$array;    
      
   }
    
   public function flush($claseModel){
      $claseModel= $this->resolveParam($claseModel);
       $array=$this->sesion[self::NOMBRE_SESION];
     $array[$claseModel]=[];
      $this->sesion[self::NOMBRE_SESION]=$array;   
      }
   
   
}
