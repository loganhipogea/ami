<?php

namespace common\behaviors;
use common\components\SesionCali;
use yii;
use yii\base\Behavior;


/*
 *
 * 
 */

class CaliBehavior extends Behavior {

    private $_ses=null;
   
    public function getSes(){
        if(is_null($this->_ses)){
            $this->_ses=New SesionCali();
        }
        return $this->_ses;
    }
    
    
   public function califica(){
       $ses=New SesionCali();
       $model=$this->owner;
       if($model->isNewRecord){
           $model->setAttributes([
               'proc_id'=>$ses->idProceso,
               'os_id'=>$ses->idOs,
               'detos_id'=>$ses->idDetos,
           ]);
        }
       
    }
  
  public function  idProc(){
      return $this->ses->idProceso;
  } 
   public function  idOs(){
       return $this->ses->idOs;
  } 
   public function  idDetos(){
       return $this->ses->idDetos;
  } 
    
}
