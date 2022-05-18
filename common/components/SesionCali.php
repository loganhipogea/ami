<?php
namespace common\components;
use common\helpers\h;
class SesionCali extends \yii\base\Component 
{
  private $_sesion=null;
  const NOMBRE_SESION='calificacion37438573';
  const KEY_PROCESO='proceso';
   const KEY_OS='os';
    const KEY_DETOS='detos';
  public function init(){
     if($this->sesion->has(self::NOMBRE_SESION)){
           
        } else{
           $this->sesion[self::NOMBRE_SESION]=[];
        }
  }
  
  public function getSesion(){
      if(is_null($this->_sesion)){
          $this->_sesion= h::session ();
      }else{
          
      }
      return $this->_sesion;
  }
  
  
  
  
  public function inserta($proc_id,$os_id=null,$detos_id=null){
    // $claseModel= $this->resolveParam($claseModel);
     //var_dump($claseModel);die();
      $array=$this->sesion[self::NOMBRE_SESION];
      if(is_null($proc_id) && is_null($os_id) && is_null($detos_id) ) {
         $array=[]; 
      }else{
         $array[self::KEY_PROCESO]=$proc_id;
         $array[self::KEY_OS]=$os_id;
         $array[self::KEY_DETOS]=$detos_id; 
      }
      
      
      $this->sesion[self::NOMBRE_SESION]=$array;
      
   }
  
   
    
   public function flush($claseModel){
     
       $array=$this->sesion[self::NOMBRE_SESION];
     $array[$claseModel]=[];
      $this->sesion[self::NOMBRE_SESION]=$array;   
      }
   
  public function getIdProceso(){
      $array=$this->sesion[self::NOMBRE_SESION];
      if(array_key_exists(self::KEY_PROCESO, $array))
      return $this->sesion[self::NOMBRE_SESION][self::KEY_PROCESO];
      return null;
  }
  
  public function getIdOs(){
     $array=$this->sesion[self::NOMBRE_SESION];
      if(array_key_exists(self::KEY_OS, $array))
      return $this->sesion[self::NOMBRE_SESION][self::KEY_OS];
      return null;
  }
  
  public function getIdDetos(){
      $array=$this->sesion[self::NOMBRE_SESION];
      if(array_key_exists(self::KEY_DETOS, $array))
      return $this->sesion[self::NOMBRE_SESION][self::KEY_DETOS];
      return null;
  }
  
  public static function isFill(){
      $sesion=h::session();
      if($sesion->has(self::NOMBRE_SESION))
        if(array_key_exists(self::KEY_DETOS, $sesion[self::NOMBRE_SESION]))
         if(!empty($sesion[self::NOMBRE_SESION][self::KEY_DETOS]))
           return true;
      return false;
     
  }
   
}
